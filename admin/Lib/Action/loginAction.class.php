<?php

/**
 * 用户登录类
 */
class loginAction extends CommonAction {

    protected $authentic = 0; //是否开启用户认证，0：不开启，1：开启

    public function index() {
        if (!isset($_POST['submit']) && !isset($_SESSION['admin_id'])) {
            $this->display();
        } else {
            if (md5($_POST['verify']) != $_SESSION['verify']) {
                $message = "您输入的验证码不正确";
            } else {
               // $_POST = haddslashes($_POST, 1);
                $data['login_name'] = $_POST['login_name'];
                $AdminUser = M("AdminUser");
                $user_info = $AdminUser->where($condtion)->find();
                if ($user_info) {
                    if ($user_info["pwd"] == md5($_POST["pwd"])) {
                        unset($_SESSION['admin_id']);
                        unset($_SESSION['admin_login_names']);
                        $_SESSION['role_id'] = $user_info["role_id"];
                        $_SESSION['admin_id'] = $user_info["id"];
                        $_SESSION['admin_login_names'] = $data['login_name'];
                        $_SESSION['last_login_time'] = $user_info['last_login_time'] ? $user_info['last_login_time'] : time();
                        $_SESSION['last_login_ip'] = $user_info['last_login_ip'] ? $user_info['last_login_ip'] : get_client_ip();
                        $_SESSION['login_count'] = $user_info['login_count'] ? $user_info['login_count'] : 1;
                        $AdminUser->where("id={$user_info["id"]}")->save(array("last_login_time"=>time(),"last_login_ip"=>  get_client_ip(),"login_count"=> $user_info['login_count']+1));
                        $this->redirect('index/index');
                    } else {
                        $message = "您输入的用户名和密码不匹配";
                    }
                } else {
                    $message = "您输入的用户名不存在";
                }
            }
            $this->assign('message', $message);
            $this->display();
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('login/index');
    }

}
