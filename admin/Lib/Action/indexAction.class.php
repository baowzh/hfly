<?php

import("ORG.Util.ArrayModel"); //数组解析类

class indexAction extends CommonAction {

    protected $nav_arr_model = null;

    /**
     * 后台首页
     */
    public function index() {
        $ADMINSTRATOR = in_array($_SESSION['admin_id'], explode(",", C('ADMINSTRATOR'))) ? true : false;

        $array_id = array();
        $role = spyc_load_file("./Conf/role.yml");
        if (!$ADMINSTRATOR) {
            $role_id = isset($_SESSION['role_id']) ? $_SESSION['role_id'] : "4";
            $group_name = $role["role_" . $role_id]['names'];
            $array_id = explode(",", $role["role_" . $role_id]["lists"]);
        } else {
            $group_name = $role["role_0"]['names'];
        }

        $user_info = $this->get_user_info($_SESSION['admin_id']);
        $admin_nav_string = F("admin_nav_" . $role_id);
        $admin_left_nav_string = F("admin_left_nav_" . $role_id);

        $this->assign("group_name", $group_name);
        $this->assign("user_info", $user_info);
        $this->assign("admin_nav", $admin_nav_string ? $admin_nav_string : $this->get_admin_nav($ADMINSTRATOR, $role_id, $array_id));
        $this->assign("admin_left_nav", $admin_left_nav_string ? $admin_left_nav_string : $this->get_left_admin_nav($ADMINSTRATOR, $role_id, $array_id));
        $this->display();
    }

    public function main() {
        $role = spyc_load_file("./Conf/role.yml");
        $role_id = isset($_SESSION['role_id']) ? $_SESSION['role_id'] : "4";
        $group_name = $role["role_" . $role_id]['names'];
        $this->assign("group_name", $group_name);
        $db = D('');
        $db = DB::getInstance();
        $tables = $db->getTables();
        $info = array(
            'SERVER_SOFTWARE' => PHP_OS . ' ' . $_SERVER["SERVER_SOFTWARE"],
            'mysql_get_server_info' => php_sapi_name(),
            'MYSQL_VERSION' => mysql_get_server_info(),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'max_execution_time' => ini_get('max_execution_time') . "秒",
            'disk_free_space' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
        );
        $counts = array(
            "line" => D("line")->count(),
            "hotel" => D("hotel")->count(),
            "viewpoint" => D("viewpoint")->count(),
            "line_order" => D("line_order")->count(),
            "hotel_order" => D("hotel_order")->count(),
            "viewpoint_order" => D("viewpoint_order")->count(),
            "article" => D("article")->count(),
            "user" => D("user")->count(),
            "article_section" => D("article_section")->count(),
        );

        $this->assign("tripec_info", $info);
        $this->assign("counts", $counts);
        $this->display();
    }

    public function get_user_info($user_id) {
        $User = M('User');
        $user_info = $User->where("id=" . $user_id)->find();

        return $user_info;
    }

    public function get_update_version() {
        
    }

    public function get_admin_nav($ADMINSTRATOR, $role_id, $array_id) {
        $nav_arr = spyc_load_file("./Conf/nav.yml");
        $nav = $this->nav_arr_model = new ArrayModel($nav_arr);
        $where["pid"] = array("eq", 0);
        $top_nav = $nav->where($where)->order("sort asc")->select();
        $item = "";
        foreach ($top_nav as $v) {
            if ($v["enable"] != 1 || $v["show"] != 1) {
                continue; //如果此节点已停用或者不显示在导航栏，进入下一次循环
            }
            if (in_array($v["id"], $array_id) && !$ADMINSTRATOR) {
                continue; //如果无此节点权限，进入下一次循环
            }
            $url = ($v["url"] == "#" || $v["url"] == "") ? "javascript:void();" : U($v["url"]);
            $item .= "<li id=\"menu_{$v['id']}\"><span><a href=\"##\" onClick=\"sethighlight({$v['id']},'{$url}');\">{$v['names']}</a></span></li>\n";
        }
        F("admin_nav_" . $role_id, $item);
        return $item;
    }

    public function get_left_admin_nav($ADMINSTRATOR, $role_id, $array_id, $now_id = 0) {
        if ($this->nav_arr_model === null) {
            $nav_arr = spyc_load_file("./Conf/nav.yml");
            $nav = $this->nav_arr_model = new ArrayModel($nav_arr);
        } else {
            $nav = $this->nav_arr_model;
        }
        $where["pid"] = array("eq", $now_id);
        $left_nav = $nav->where($where)->order("sort asc")->select();
        if (!$left_nav)
            return '';
        $item = "";
        foreach ($left_nav as $v) {
            if ($v["enable"] != 1 || $v["show"] != 1) {
                continue; //如果此节点已停用或者不显示在导航栏，进入下一次循环
            }
            if (in_array($v["id"], $array_id) && !$ADMINSTRATOR) {
                continue; //如果无此节点权限，进入下一次循环
            }
            $url = ($v["url"] == "#" || $v["url"] == "") ? "javascript:void();" : U($v["url"]);
            $item .= "<dl id=\"nav_{$v['id']}\">\n";
            $item .= "<dt>{$v['names']}</dt>";
            $map["pid"] = array("eq", $v['id']);
            $left_nav_list = $nav->where($map)->order("sort asc")->select();
            foreach ($left_nav_list as $list) {
                if ($list["enable"] != 1 || $list["show"] != 1) {
                    continue; //如果此节点已停用或者不显示在导航栏，进入下一次循环
                }
                if (in_array($list["id"], $array_id) && !$ADMINSTRATOR) {
                    continue; //如果无此节点权限，进入下一次循环
                }
                $list_url = ($list["url"] == "#" || $list["url"] == "") ? "javascript:void();" : U($list["url"]);
                $item .= "<dd id=\"nav_{$list['id']}\">
                        <span onclick=\"javascript:gourl('{$list['id']}','{$list_url}')\"><a href=\"{$list_url}\" target=\"main\">{$list['names']}</a></span>\n";
                $item .= $this->get_left_admin_nav($ADMINSTRATOR, $role_id, $array_id, $list['id']);
                $item .= "</dd>";
            }
            $item.="</dl>";
        }
        if ($now_id == 0) {
            F("admin_left_nav_" . $role_id, $item);
        }
        return $item;
    }

    /**
      ×Main页面
     */
    public function main_page() {
        $this->display();
    }

    /**
      ×注销登陆
     */
    public function logout() {
        Session::clear();
        $this->redirect('index/');
    }

}

?>