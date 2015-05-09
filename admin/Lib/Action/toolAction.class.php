<?php
import("@.ORG.phpzip");
import("@.Jeesell.Award");
class toolAction extends CommonAction
{
	public function dbclear()
	{
		if(empty($this->get[0])){
			$this->display();
		}
		else if($this->get[0]=='do'){
			$Model = new Model();
			$Model->execute("truncate table ".C(DB_PREFIX)."user".C(DB_SUFFIX).";");
			$Model->execute("truncate table ".C(DB_PREFIX)."user_info".C(DB_SUFFIX).";");
			$Model->execute("truncate table ".C(DB_PREFIX)."user_subcount".C(DB_SUFFIX).";");
			$Model->execute("truncate table ".C(DB_PREFIX)."charge".C(DB_SUFFIX).";");
			$Model->execute("truncate table ".C(DB_PREFIX)."income".C(DB_SUFFIX).";");
			$Model->execute("truncate table ".C(DB_PREFIX)."layer_list".C(DB_SUFFIX).";");
			$Model->execute("truncate table ".C(DB_PREFIX)."admin_user".C(DB_SUFFIX).";");
			$Model->execute("truncate table ".C(DB_PREFIX)."agent".C(DB_SUFFIX).";");
			$Model->execute("truncate table ".C(DB_PREFIX)."change_money_list".C(DB_SUFFIX).";");
			$Model->execute("truncate table ".C(DB_PREFIX)."convert_money_list".C(DB_SUFFIX).";");
			$Model->execute("truncate table ".C(DB_PREFIX)."order".C(DB_SUFFIX).";");
			$Model->execute("truncate table ".C(DB_PREFIX)."mention".C(DB_SUFFIX).";");
			$Model->execute("truncate table ".C(DB_PREFIX)."payment_list".C(DB_SUFFIX).";");
			$Model->execute("truncate table ".C(DB_PREFIX)."remittance".C(DB_SUFFIX).";");

			$Model->execute("insert into ".C(DB_PREFIX)."admin_user".C(DB_SUFFIX)."
			(id,user_id,pwd,status) values(1,1,'21232f297a57a5a743894a0e4a801fc3',1);");
			$Model->execute("insert into ".C(DB_PREFIX)."user".C(DB_SUFFIX)."
			(id,rid,pid,user_type,unit_count,area,login_name,pwd1,pwd2,status)
			values(1,0,0,0,2,0,'admin','21232f297a57a5a743894a0e4a801fc3','21232f297a57a5a743894a0e4a801fc3',1);");
			$Model->execute("insert into ".C(DB_PREFIX)."user_info".C(DB_SUFFIX)."
			(id,user_id) values(1,1);");
			$Model->execute("insert into ".C(DB_PREFIX)."user_subcount".C(DB_SUFFIX)."
			(id,user_id,count_left_total,count_right_total,count_left_remain,count_right_remain)
			values(1,1,0,0,0,0);");
			$this->assign('message','执行成功');
			$this->display();
		}
	}
	/**
	 * 备份数据库
	 */
	public function dbbak(){
		@set_time_limit( 0 );
		$pageSize = 1000;
		$dataDir = "../#data/db/";

		if ( !empty( $_POST['btnSubmit'] ) )
		{
			if ( !count( $_POST['arrTables'] ) )
			{
				$this->assign( "msg", "请选择要备份的数据表。" );
				$this->assign( "backUrl", "dbbak" );
				$this->display( "_msg" );
				exit( );
			}
			if ( !file_exists( $dataDir ) )
			{
				$this->assign( "msg", "数据备份目录 ".$dataDir." 不存在。" );
				$this->assign( "backUrl", "dbbak" );
				$this->display( "_msg" );
				exit( );
			}
			if ( !is_writeable( $dataDir ) )
			{
				$this->assign( "msg", "数据备份目录 ".$dataDir." 不不可写。" );
				$this->assign( "backUrl", "dbbak" );
				$this->display( "_msg" );
				exit( );
			}
			$filename = date( "Ymd-His" ).".sql";
			$file = $dataDir.$filename;
			$i = 0;
			for ( ;	$i < count( $_POST['arrTables'] );	++$i	)
			{
				$table_one = $_POST['arrTables'][$i];
				$table=str_replace("jee_","",$table_one);
				$table_num=strlen($table);
				$table_num=$table_num-1;
				$table=substr($table,0,$table_num);
				$tables= M("$table");
				$recCount = $tables->select();
				$recCount=count($recCount);
				$pageCount = ceil( $recCount / $pageSize );
				$pageIndex = 1;
				for ( ;	$pageIndex <= $pageCount;	++$pageIndex	)
				{
					$recFrom = ( $pageIndex - 1 ) * $pageSize;
					$arr = $tables->select();
					$rowsCount = count( $arr );
					if ( !( 0 < $rowsCount ) )
					{
						continue;
					}
					$j = 0;
					for ( ;	$j < $rowsCount;	++$j	)
					{
						$arrValues = array( );
						foreach ( $arr[$j] as $value )
						{
							if ( NULL === $value )
							{
								$arrValues[] = "NULL";
							}
							else
							{
								$value = "'".addslashes( $value )."'";
								$value = str_replace( "\r", "\\r", $value );
								$value = str_replace( "\n", "\\n", $value );
								$arrValues[] = $value;
							}
						}
						writesql( $file, "REPLACE INTO `".$table_one."` VALUES (".implode( ", ", $arrValues ).");\n" );
					}
				}
				writesql( $file, "\n" );
			}
			$filename = eregi_replace( ".sql\$", ".zip", $filename );

			$zip = new phpzip( );
			$zip->zip( $file, $dataDir.$filename );
			unlink( $file );
			$this->assign( "msg", "数据备份成功！<br/>备份文件为：<a href='#'>{$filename}</a>" );
			$this->assign( "backUrl", "dbbak" );
			$this->display('_msg');
			exit( );
		}
		//	$arr = $db->fetchrows( "SHOW TABLE STATUS" );
		$Model = new Model();
		$arr =$Model->query( "SHOW TABLE STATUS" );
		//dump($arr);
		$this->assign( "arr", $arr );
		$this->display ();
	}
	/**
	 * 写入
	 */
	function writesql( $file, $content )
	{
		$fp = fopen( $file, "a+" );
		flock( $fp, 2 );
		fwrite( $fp, $content );
		fclose( $fp );
	}
	/**
	 * 数据库还原
	 */
	public function dbrestore(){
		@set_time_limit( 0 );
		$dataDir = "../#data/db/";
		$action = !empty( $_GET['action'] ) ? $_GET['action'] : "";
		if ( "import" == $action && !empty( $_GET['file'] ) )
		{
			$filename = $_GET['file'];
			$oriFilename = "";
			if ( eregi( ".zip\$", $filename ) )
			{
				$oriFilename = $filename;
				$filename = eregi_replace( ".zip\$", ".sql", $filename );
				$zip = new phpzip( );
				$zip->unzip( $dataDir.$oriFilename, $dataDir );
			}
			if ( !( $fp = fopen( $dataDir.$filename, "r" ) ) )
			{
				exit( "File not found." );
			}
			$sql = "";
			while ( !feof( $fp ) )
			{
				$line = trim( fgets( $fp, 524288 ) );
				if ( ereg( ";\$", $line ) )
				{
					$sql .= $line;
					$db->query( $sql );
					$sql = "";
				}
				else if ( !ereg( "^(//|--)", $line ) )
				{
					$sql .= $line;
				}
			}
			fclose( $fp );
			if ( !empty( $oriFilename ) )
			{
				unlink( $dataDir.$filename );
			}
			$tpl->assign( "msg", "数据恢复成功！" );
			$tpl->assign( "backUrl", "db_import.php" );
			$tpl->display( "_msg.tpl" );
			exit( );
		}
		if ( "delete" == $action && !empty( $_GET['file'] ) || unlink( $dataDir.$_GET['file'] ) )
		{
			header( "location: ?" );
			exit( );
		}
		$arrSqls = array( );
		if ( $handle = @opendir( $dataDir ) )
		{
			while ( FALSE !== ( $file = readdir( $handle ) ) )
			{
				if ( is_file( $dataDir.$file ) )
				{
					$arrSqls[] = array(
				"file" => $file,
				"size" => filesize( $dataDir.$file )
					);
				}
			}
			closedir( $handle );
		}
		$this->assign( "arr", $arrSqls );
		$this->display( );
	}

	/**
	 * 执行层碰
	 */
	public function do_layer(){
		if (! isset ( $_POST ['submit'] )) {
			$this->display ();
		} else {
			$Award =  new Award();
			$Award->AwardLayerCom();
			$this->display();
		}
	}
}


?>