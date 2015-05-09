<?php

/**
 * Description of bakupAction
 *
 * @author Administrator
 */
class bakupAction extends CommonAction {

    /**
     * 数据库列表
     */
    function index() {
        $dbName = C('DB_NAME');
        $model = M();
        $tables = $model->query("show TABLES FROM `{$dbName}`");
        $table_key = 'Tables_in_' . $dbName;
        foreach ($tables as $index => $table) {
            $count = $model->query("SELECT count(*) as count FROM {$table[$table_key]} WHERE 1");
            $size = $model->query("SHOW TABLE STATUS FROM `{$dbName}` LIKE '{$table[$table_key]}'");
            
            unset($tables[$index][$table_key]);
            $tables[$index]['name'] = $table[$table_key];
            $tables[$index]['count'] = $count[0]['count'];
            $tables[$index]['size'] = round($size[0]['Data_length']/1024, 2);
            $totalsize+=$tables[$index]['size'];
        }
        $this->assign("totalsize", round($totalsize/1024, 2));
        $this->assign("tables", $tables);
        $this->display();
    }

    /**
     * 数据库备份
     */
    function bak() {
        $tables = $_POST['tables'];
        $sizelimit = $_POST['sizelimit'];
        $baktype = $_POST['baktype'];
        if ($_POST['dosubmit']) {
            if (!$baktype) {
                $this->error("备份结构和备份数据至少选择一个");
                exit;
            } else {
                $baktype_1 = in_array("1", $baktype) ? true : false;
                $baktype_2 = in_array("2", $baktype) ? true : false;
            }
            if (!$tables || !is_array($tables)) {
                $this->error("请选择要备份的表");
                exit;
            }
            $dbName = C('DB_NAME');
            $model = M();
            $list_tables = $model->query("show TABLES FROM `{$dbName}`");
            $table_key = 'Tables_in_' . $dbName;
            $used_table = array();
            foreach ($list_tables as $table) {
                if (in_array($table[$table_key], $tables)) {
                    $used_table[] = $table[$table_key];
                }
            }
            $sql_temp = '';
            $data = array();
            foreach ($used_table as $v) {
                if ($baktype_1) {
                    $sql_temp.=$this->show_create($v);
                    if (strlen($sql_temp) >= ($sizelimit * 1024)) {
                        $this->write2file($sql_temp);
                        $sql_temp = '';
                    }
                }
                if ($baktype_2) {
                    $data = $model->table($v)->select();
                    foreach ($data as $dv) {
                        $sql_temp.=$this->show_insert($v, $dv);
                        if (strlen($sql_temp) >= ($sizelimit * 1024)) {
                            $this->write2file($sql_temp);
                            $sql_temp = '';
                        }
                    }
                }
                $sql_temp.=$sql_temp ? "\n" : '';
            }
            $this->write2file($sql_temp);
            $this->success("备份成功");
        }
    }

    /**
     * 已备份的数据库
     */
    function import_list() {
        $sqlfiles = glob(ROOT_PATH . '/Backup/database/*.sql');
        $file_list = array();       
        if (is_array($sqlfiles)) {
            $i = 0;
            foreach ($sqlfiles as $sqlfile) {
                preg_match("/([a-z0-9_]+_\d{8}_[0-9a-z]{3}_)(\d+)\.sql/i", basename($sqlfile), $num);
                $i = isset($file_list[$num[1]]) ? count($file_list[$num[1]]) : 0;
                $file_list[$num[1]][$i]["filename"] = basename($sqlfile);
                $file_list[$num[1]][$i]["filesize"] = round(filesize($sqlfile) / (1024), 2);
                $file_list[$num[1]][$i]["maketime"] = date('Y-m-d H:i:s', filemtime($sqlfile)); //取得文件修改时间
                $file_list[$num[1]][$i]["num"] = $num[2];
            }
        }
        $this->assign('file_list', $file_list);
        $this->display();
    }

    /**
     * 数据库还原
     */
    function import() {
        $filename = $_GET["file"];        
        $filelimit = explode("_", $filename);
        unset($filelimit[3]);
        $filenames = join("_", $filelimit);
        $sqlfile_paths = glob(ROOT_PATH . '/Backup/database/' . $filenames . '_*.sql');
        for ($i = 0; $i < count($sqlfile_paths); $i++) {
            $sql = file2str(ROOT_PATH . '/Backup/database/' . $filenames . '_' . $i . '.sql');
            $success = $this->exec_sql($sql, $msg, $sql_count);
        }
        if ($success) {
            $this->success("导入成功！共执行{$sql_count}条语句",U("import_list"));
        } else {
            header("Content-Type:text/html; charset=utf-8");
            echo "<pre>";
            echo $msg;
            echo "</pre>";
        }
    }

    /**
     * 下载文件
     */
    function down() {
        $filename = $_GET["file"];
        $file_path = ROOT_PATH . './Backup/database/' . trim($filename,".sql").".sql";
        if (is_file($file_path)) {
            import('ORG.Net.Http');
            $Http = new Http();
            $Http->download($file_path, $filename.".sql");
        } else {
            $this->error("文件不存在或者已删除");
        }
    }

    /**
     * 删除备份文件
     */
    function delfile() {
        $filename =  $_GET["file"];
        $file_path = ROOT_PATH . './Backup/database/' . trim($filename,".sql").".sql";
        if (is_file($file_path)) {
            @unlink($file_path);
            $this->success("删除成功");
        } else {
            $this->error("文件不存在或者已删除");
        }
    }

    /**
     * 上传备份文件
     */
    function upbak() {

    }

    /**
     * 生成数据表创建的sql
     * @staticvar string $model
     * @param type $table
     * @return string
     */
    function show_create($table) {
        static $model = '';
        if ($model == '') {
            $model = M();
        }
        $create_sql = "DROP TABLE IF EXISTS `$table`;\n";
        $create_r = $model->query("SHOW CREATE TABLE {$table}");
        $create_sql.=$create_r[0]["Create Table"] . ";\n\n";
        return $create_sql;
    }

    /**
     * 生成插入数据的sql
     * @param type $table
     * @param type $data
     * @return string
     */
    function show_insert($table, $data) {
        $insert_sql = "INSERT INTO $table VALUES(";
        $comma = "";
        foreach ($data as $value) {
            /* mysql_escape_string --  转义一个字符串用于 mysql_query */
            $insert_sql .= $comma . "'" . mysql_escape_string($value) . "'";
            $comma = ",";
        }
        $insert_sql .= ");\n";
        return $insert_sql;
    }

    /**
     * 将sql写入到文件中
     * @staticvar int $i
     * @staticvar string $file
     * @param type $string
     */
    function write2file($string) {
        static $i = 0;
        static $file = '';
        if ($file == '') {
            $file = ROOT_PATH . './Backup/database/' . C('DB_NAME') . date("_Ymd_") . rand_string(3, 1);
        }
        str2file($string, $file . "_" . $i . ".sql");
        $i++;
    }

    /**
     * 执行导入的sql语句
     * @staticvar string $conn
     * @staticvar int $run
     * @staticvar boolean $success
     * @staticvar string $error
     * @param type $sql
     * @param type $msg
     * @param type $sql_count
     * @return boolean
     */
    function exec_sql($sql, &$msg = "", &$sql_count = 0) {
        static $conn = '';
        static $run = 0;
        static $success = true;
        static $error = '';
        if ($conn == '') {
            $conn = @mysql_connect(C("DB_HOST") . ":" . C("DB_PORT"), C("DB_USER"), C("DB_PWD"));
            if (!$conn) {
                throw_exception(mysql_error());
            }
            mysql_query("set names utf8", $conn);
            $h = @mysql_select_db(C("DB_NAME"), $conn);
            if (!$h) {
                throw_exception(mysql_error());
            }
        }
        $sql = preg_replace("/TYPE=(InnoDB|MyISAM)( DEFAULT CHARSET=[^; ]+)?/", "TYPE=\\1 DEFAULT CHARSET=utf8", $sql);
        $sqls = str_replace("\r", "\n", $sql);
        $queriesarray = explode(";\n", trim($sqls));
        unset($sql);
        unset($sqls);
        foreach ($queriesarray as $query) {
            $str1 = substr(trim($query), 0, 1);
            if ($str1 != '#' && $str1 != '-' && $query != "") {
                if (!mysql_query(trim($query, ";"), $conn)) {
                    $success = false;
                    $error.="<font color=\"red\">Error:" . mysql_error() . "</font><br>\n";
                }
            }
            $run++;
        }
        $msg = $error;
        $sql_count = $run;
        return $success;
    }

}

?>
