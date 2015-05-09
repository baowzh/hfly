<?php

class_exists("spyc") or import("ORG.Util.spyc"); //yml解析类
class_exists("Http") or import("ORG.Net.Http"); //yml解析类

class CommonAction extends Action {

    protected $authentic = 1; //是否开启用户认证，0：不开启，1：开启
    protected $session_name = "ADMIN_PHPSESSID"; //记录session_id的 Cookie 名，为防止与前台的 Cookie 名混淆，此处加了 ADMID_ 前缀

    public function _initialize() {
        if (strtolower(MODULE_NAME) == "common")
            $this->authentic = 0;
        if (!isset($_SESSION)) {
            //如果没开启session，则开启session
            session_name($this->session_name);
            session_start();
        }
        if ($this->authentic) {
            $this->is_authentic();
        }
        $this->getPageSize();
    }

    final protected function get_tripec_authorization() {        
        
    }

      

    /**
     * 判断用户权限
     */
    protected function is_authentic() {
        if (!isset($_SESSION["admin_id"]) || $_SESSION["admin_id"] < 1) {
            $this->redirect("/login");
        }
        $ADMINSTRATOR = in_array($_SESSION['admin_id'], explode(",", C('ADMINSTRATOR'))) ? true : false;
        if ($ADMINSTRATOR) {
            return true;
        }
        $role = spyc_load_file("./Conf/role.yml");
        $role_id = isset($_SESSION['role_id']) ? "role_" . $_SESSION['role_id'] : "role_4";
        if (!isset($role[$role_id]) || $role[$role_id]["status"] != 1) {
            $this->show("你所属的角色已禁用或已删除！");
            exit;
        }
        $roles = explode(",", $role[$role_id]["action"]);
        $ModuleAction = MODULE_NAME . "/" . ACTION_NAME;
        $user_role = true;
        if (in_array($ModuleAction, $roles)) {
            $user_role = false;
        }
        if ($role[$role_id]["status"] != 1) {
            $user_role = false;
        }
        if (!$user_role) {
            $this->show("操作失败，权限不足");
            exit;
        }
    }

    /**
     * 分页条 在Action 设置后 直接在模板要显示分页的地方 {$page} 就行了
     * @param int $count 总记录数
     * @param int $pagesize 每页分页数
     */
    public function pagebar($count, $pagesize = PAGESIZE, &$limit = '') {
        $p = isset($_GET['p']) ? intval($_GET['p']) : 1; //获取分页页码
        class_exists("Page") or import("ORG.Util.Page");
        $Page = new Page($count, $pagesize);
        $show = $Page->show();
        if ($count > 0) {
            $this->assign("page", $show . PAGESIZE_SELECT);
        } else {
            $this->assign("page", $show);
        }
        $limit = $Page->firstRow . "," . $Page->listRows;
        return $p . "," . PAGESIZE;
    }

    /**
     * 获取分页信息
     */
    public function getPageSize() {
        $pagesize = isset($_COOKIE["pagesize"]) ? intval($_COOKIE["pagesize"]) : 15;
        define("PAGESIZE", $pagesize);
        $sizecount = array(5, 10, 12, 15, 20, 30, 50, 100); //可选记录条数列表
        //设置分页设置的url为 U('Common/setPageSize')
        $pagestr = " 每页显示<select onchange=\"location.href='" . U('Common/setPageSize') . "/pagesize/'+this.value\">";
        foreach ($sizecount as $v) {
            if ($v == $pagesize) {
                $pagestr.="<option value=\"$v\" selected=\"selected\">$v</option>";
            } else {
                $pagestr.="<option value=\"$v\">$v</option>";
            }
        }
        $pagestr.="</select> 条";
        define("PAGESIZE_SELECT", $pagestr);
    }

    /**
     * 设置每页显示记录数
     */
    public function setPageSize() {
        $url = $_SERVER["HTTP_REFERER"]; //获取设置完成后跳回的页面
        $pagesize = isset($_GET["pagesize"]) ? intval($_GET["pagesize"]) : 15;
        $sizecount = array(5, 10, 12, 15, 20, 30, 50, 100); //可选记录条数列表
        $pagesize = in_array($pagesize, $sizecount) ? $pagesize : 15;
        setcookie("pagesize", $pagesize, time() + 86400 * 365, "/"); //把信息写到cookie中，有效期为365天
        header("Location: $url");
    }

    /**
     * 验证码
     */
    public function verify() {
        class_exists("Image") or import("ORG.Util.Image");

        Image :: buildImageVerify();
    }

    /**
     * 生成代金券
     */
    public function create_cash() {
        M()->query("TRUNCATE TABLE `jee_cash_coupon`");
        $str = null;
        for ($i = 100; $i <= 360; $i += 40) {
            for ($u = 0; $u < 135; $u++) {
                $str = "INSERT INTO `jee_cash_coupon` (`serial_num`, `coupon_value`, `creator_id`, `create_time`, `expire_time`, `use_time`, `status`) "
                        . "VALUES ('" . strtoupper($i . substr(md5(((time() + strtotime("today")) . rand(10000, 99999))), 8, 16)) . "', $i , 9 , " . time() . " , " . strtotime('2030-8-8') . " , NULL, 0);";
                M()->query($str);
            }
        }
    }

}
