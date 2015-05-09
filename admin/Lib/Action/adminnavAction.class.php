<?php

/**
 * Description of AdminnavAction
 *
 * @author Gemini
 */
class adminnavAction extends CommonAction {

    public function _initialize() {
        parent::_initialize();
        if (!isset($_SESSION["jee_admin_nav"]) || $_SESSION["jee_admin_nav"] != md5("jeechange")) {
            if ($_POST && $_POST["admin_nav_pwd"] == "jeechange") {
                $_SESSION["jee_admin_nav"] = md5("jeechange");
                $this->redirect("Adminnav/index");
                exit;
            } elseif ($_POST && $_POST["admin_nav_pwd"] != "jeechange") {
                $this->assign("message", "密码错误，请重新输入");
            } else {
                $this->assign("message", "此功能仅限开发人员使用，如果你是开发人员，请输入开发人员密码");
            }
            $this->display("Adminnav:login");
            exit;
        }
    }

    public function index() {
        $Nav = D("AdminNav");
        $menu = $Nav->getNav();
        $this->assign("Nav_menu_str", $menu);
        $this->display();
    }

    public function add() {
        $Nav = D("AdminNav");
        if (!$_POST) {
            $parid = $_GET["pid"] ? $_GET["pid"] : 0;
            $Option_str = $Nav->getOption($parid);
            $this->assign("option_str", $Option_str);
            $this->display();
        } else {
            if (!$Nav->create()) {
                $parid = $_GET["pid"] ? $_GET["pid"] : 0;
                $Option_str = $Nav->getOption($parid);
                $this->assign("option_str", $Option_str);
                $this->assign("message", $Nav->getError());
                $this->display();
                exit();
            } else {
                $Nav->add();
                $this->assign("jumpUrl", U("AdminNav/index"));
                $this->success("添加成功");
            }
        }
    }

    public function edit() {
        $Nav = D("AdminNav");
        $navdb = $Nav->where("id=" . $_GET["catid"])->find();
        if (!$navdb) {
            $this->error("栏目名称不存在或者已经删除");
            exit;
        }
        $parid = $navdb["pid"];
        if (!$_POST) {
            $Option_str = $Nav->getOption($parid);
            $this->assign("option_str", $Option_str);
            $this->assign("navdb", $navdb);
            $this->display();
        } else {
            $_POST["id"] = $_POST["id"] = $this->get["catid"] = $_GET["catid"];
            if (!$Nav->create()) {
                $Option_str = $Nav->getOption($parid);
                $this->assign("option_str", $Option_str);
                $this->assign("navdb", $navdb);
                $this->assign("message", $Nav->getError());
                $this->display();
                exit();
            } else {
                $Nav->save();
                $this->assign("jumpUrl", U("AdminNav/index"));
                $this->success("修改成功");
            }
        }
    }

    public function order() {
        if ($_POST) {
            $Nav = M("AdminNav");
            foreach ($_POST["sort"] as $k => $v) {
                $Nav->where('id=' . $k)->setField("sort", $v);
            }
        }
        $this->assign("jumpUrl", U("AdminNav/index"));
        $this->success("排序成功");
    }

    public function del() {
        $Nav = M("AdminNav");
        $navdb = $Nav->where("id=" . $_GET["catid"])->find();
        if ($navdb) {
            $count = $Nav->where("pid=" . $_GET["catid"])->count();
            if ($count > 0) {
                $this->error("该菜单存在子菜单，请先把子菜单移到其它菜单或删除子菜单再进行操作");
                exit;
            }
            $Nav->where('id=' . $_GET["catid"])->delete();
            $this->assign("jumpUrl", U("AdminNav/index"));
            $this->success("删除成功");
        } else {
            $this->assign("jumpUrl", U("AdminNav/index"));
            $this->error("找不到要删除的菜单");
        }
    }

}
?>
