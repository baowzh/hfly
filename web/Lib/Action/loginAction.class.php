<?php

/**
 * Description of loginAction
 *
 * @author Gemini
 */
class loginAction extends CommonAction {

    protected $authentic = 0;

    public function _initialize() {
        parent::_initialize();
        if (!isset($_GET["referer"])) { //设置登录后跳转的页面
            $host = current(explode(":", $_SERVER["HTTP_HOST"]));
            $referer = $_SERVER["HTTP_REFERER"];
            $referer_parse = parse_url($referer);
            if ($referer_parse["host"] == $host && strtolower(MODULE_NAME) != "login") {
                $_GET["referer"] = base64_encode($referer);
            } else {
                $_GET["referer"] = base64_encode(__Index__);
            }
        }
        unset($_GET["_URL_"]);
        if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0 && strtolower(ACTION_NAME) != "logout") { //如果已登陆，则直接跳到referer
            redirect(base64_decode($_GET["referer"]));
            exit;
        }
    }

    public function index() {
        $this->display();
    }

    public function login() {
        if (!$_POST) {
            $this->display("index");
        } else {
            $user = D('user');
            $user_email_bind = M('user_email_bind');
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            
            
            //邮箱登陆
            $user_id = $user_email_bind->where("email = '$username' AND status = '1'")->getField('user_id');
            if(!$user_id){
                $userinfo = $user->where("username='$username' AND status='1'")->find();//用户名登陆
            }else{
            //用户名登陆
                $userinfo = $user->where("id='$user_id' AND status='1'")->find();
            }
            if(!$userinfo){
                $this->error("该用户不存在!");
                exit;
            }
            if ($userinfo['password'] != md5($password)) {
                $this->error("密码错误！");
                exit;
            }
            $user->remember = $_POST['login_state'] ? true : false;

            $user->set_login($userinfo);
        }
    }

    public function logout() {
        $user = D("user");
        $user->clearLoginInfo();
        $this->redirect("index/index");
    }

}

?>
