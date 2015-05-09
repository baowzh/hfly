<?php
import("ORG.Util.Page"); // 导入分页类
// 导入分页类

class roleAction extends CommonAction {

    public function add() {
        if (!isset($_POST['submit'])) {
            $this->display();
        } else {
            $Roles = M("Role");
            $count = $Roles->where("name= '" . $_POST['name'] . "'")->count();
            if ($count > 0) {
                $this->assign('message', '角色组名已经存在');
                $this->display();
                exit();
            }
            $data = $Roles->create();
            
            $Roles->add($data);
           // $this->redirect('lists', array('message' => '添加组成功'));
           $this->success("添加角色成功",U("lists"));
        }
    }
    
    public function activation(){
        $role = spyc_load_file("./Conf/role.yml");
        $names = trim($_GET["id"]);
        if (!isset($role[$names])) {
            $this->error("角色不存在", U("lists"));
            exit;
        }                           
        $role[$names]['status'] = $role[$names]["status"]?0:1;       
        file_put_contents("./Conf/role.yml", Spyc::YAMLDump($role));
        $this->redirect("lists");
    }

    public function lists() {
        $role = spyc_load_file(ROOT_PATH.APP_NAME."/Conf/role.yml");           
        $this->assign("role", $role);
        $this->display();
    }

    public function edit() {
        $role = spyc_load_file("./Conf/role.yml");
        $names = trim($_GET["id"]);
        if (!isset($role[$names])) {
            $this->error("角色不存在", U("lists"));
            exit;
        }
        $keys = explode("_", $names);
        $role[$names]["level"] = $keys[1];
        if (!$_POST) {
            $this->assign("id", $names);
            $this->assign("role_info", $role[$names]);
            $this->display();
            exit;
        }
        $tmp_role = $role[$names];
        unset($role[$names]);
        $level = intval(trim($_POST["level"]));
        foreach ($role as $k => $v) {
            if ($v["names"] == trim($_POST["names"])) {
                $this->error("角色名已存在");
                exit;
                break;
            }
            $ks = explode("_", $k);
            if ($ks[1] == $level) {
                $this->error("角色级别已存在");
                exit;
                break;
            }
        }
        $role["role_" . $level] = array(
            "names" => trim($_POST["names"]),
            "status" => $tmp_role["status"],
            "lists" => $tmp_role["lists"],
            "action" => $tmp_role["action"],
        );
        ksort($role);
        reset($role);
        file_put_contents("./Conf/role.yml", Spyc::YAMLDump($role));
        $this->success("编辑成功！", U("lists"));
    }

    //删除
    public function del() {
        //$this->redirect('lists',array('message'=>'删除组别成功'));

        $role = spyc_load_file("./Conf/role.yml");
        $id = trim($_GET["id"]);
        if (!isset($role[$id])) {
            $this->error("角色不存在", U("lists"));
            exit;
        }
        unset($role[$id]);
        file_put_contents("./Conf/role.yml", Spyc::YAMLDump($role));
        $this->redirect("lists");
    }

    public function auth() {
        $role = spyc_load_file("./Conf/role.yml");
        $names = trim($_GET["id"]);
        if (!isset($role[$names])) {
            $this->error("角色不存在", U("lists"));
            exit;
        }
        $array_id = explode(",", $role[$names]["lists"]);
        import("ORG.Util.ArrayModel"); //数组解析类
        $nav_arr = spyc_load_file("./Conf/nav.yml");
        $nav = new ArrayModel($nav_arr);
        $where["pid"] = array("eq", 0);
        $top_nav = $nav->where($where)->order("sort asc")->select();
        foreach ($top_nav as $v) {
            $item.="<tr><td>";
            $item.=$v["id"] . "</td><td>";
            $item.=in_array($v["id"], $array_id) ? "<input type=\"checkbox\" name=\"nav_id[]\" value=\"{$v["id"]}\"></td>" : "<input type=\"checkbox\" name=\"nav_id[]\" checked value=\"{$v["id"]}\"></td>";
            $item.="<td class=\"tl\">{$v['names']}</td>";
            $item.=$v["enable"] == 1 ? "<td>已启用</td>" : "<td>已禁用</td>";
            $item.="</tr>";
            $item.=$this->getsubnav($nav, $v["id"], $array_id);
        }
        $this->assign("names", $names);
        $this->assign("role_info", $role[$names]);
        $this->assign("nav_str", $item);
        $this->display();
    }

    public function role_set_auth() {
        if (!$_SERVER['REQUEST_METHOD'] == "GET") {
            $this->error("非法操作", U("lists"));
        }
        $role = spyc_load_file("./Conf/role.yml");
        $names = trim($_GET["names"]);
        if (!isset($role[$names])) {
            $this->error("角色不存在", U("lists"));
            exit;
        }
        $nav_id = (array) $_POST["nav_id"];
        $nav_arr = spyc_load_file("./Conf/nav.yml");
        $lists = $action = "";
        foreach ($nav_arr as $nav) {
            if (!in_array($nav["id"], $nav_id)) {
                $lists.="," . $nav["id"];
                $action.="," . $nav["url"];
            }
        }
        $role[$names]['lists'] = trim($lists, ",");
        $role[$names]['action'] = trim($action, ",");
        file_put_contents("./Conf/role.yml", Spyc::YAMLDump($role));
        $this->success("保存成功！", U("lists"));
    }
    
    private function getsubnav($nav, $id, $array_id, $loop = "&nbsp;&nbsp;") {
		$where["pid"] = array("eq", $id);
		$count = $nav->where($where)->count();
		if ($count == 0) {
			return "";
		}
		$sub_nav = $nav->where($where)->order("sort asc")->select();
		$i = 1;
		foreach ($sub_nav as $v) {
			$item.="<tr><td>";
			$item.=$v["id"] . "</td><td>";
			$item.=in_array($v["id"], $array_id) ? "<input type=\"checkbox\" name=\"nav_id[]\" value=\"{$v["id"]}\"></td>" : "<input type=\"checkbox\" name=\"nav_id[]\" checked value=\"{$v["id"]}\"></td>";
			$item.=$i == $count ? "<td class=\"tl\">{$loop}└─{$v['names']}</td>" : "<td class=\"tl\">{$loop}├─{$v['names']}</td>";
			$item.=$v["enable"] == 1 ? "<td>已启用</td>" : "<td>已禁用</td>";
			$item.="</tr>";
			$i++;
		}
		return $item;
	}

}
?>