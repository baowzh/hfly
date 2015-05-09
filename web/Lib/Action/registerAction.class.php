
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of registerAction
 *
 * @author Administrator
 */
class registerAction extends CommonAction {

    protected $authentic = 0;

    public function index() {
        $this->display("register");
    }

    public function register() {
        if (!$_POST) {
            $this->display();
            exit();
        }
        $user = D("user");
        if (!$user->hasNotReg($msg)) {
            $this->error($msg);
        }
        $email_str = trim($_POST['email']);
        $username = trim($_POST["username"]);
        $email = D('email');
        $email->setting["timeout"] = 10;
        $email->setting["type"] = "user_active";
        $email->setting["user_id"] = 0;
        $email->setting["title"] = "TripEC用户激活";
        $email->setting["code"] = rand_string(6, 5);
        $link = __HOST__ . U("user_active_byemail", array("code" => $email->setting["code"], "username" => $username));
        $email->setting["link"] = md5($link);
        $runtime = D("runtime");
        $content = $runtime
                ->assign($email->setting)
                ->assign("to_user", $email_str)
                ->assign("title", "tripec")
                ->assign("active_url", $link)
                ->get_contents("email/register");
        $email->setting["content"] = $content;


        if ($email->send($email_str, "", "", "", $return)) {
            $user_tmp = D("userTmp");
            $map["email"] = $email_str;

            $user_tmp->where($map)->delete();
            $data = array("username" => $username, "email" => $email_str, "password" => trim(md5($_POST["password"])), "create_time" => time());
            $tid = $user_tmp->add($data);
            $resend = U('register_resend', array('tid' => $tid, 'sid' => $return['data']['sid']));
            $this->assign("tid", $tid);
            $this->assign("resend", $resend);
            $this->assign("email_return", $return);
            $this->display("activation");
        } else {
            echo $return["msg"];
            exit;
            $this->error($return["msg"]);
            exit;
        }
    }

    public function register_resend() {
        $sid = intval($_GET["sid"]);
        $tid = intval($_GET["tid"]);
        $email = D("email");
        $email_log = M("email_log")->where("type='user_active' and id=$sid")->find();
        $userTmp = M("userTmp");
        $objUserTmp = $userTmp->where("id='$tid'")->find();
        if ($objUserTmp['email'] != $email_log['email']) {
            $this->error("非法操作", U('register'));
            exit;
        }
        if (!$email_log) {
            $this->error("非法操作", U('register'));
            exit;
        }
        $user_status = M("user")->where("id=" . $email_log["user_id"])->getField("status");
        if ($user_status == 1) {
            $this->error("用户已经激活！", U('login/index'));
            exit;
        }

        $email->setting["timeout"] = 30;
        $email->setting["type"] = "user_active";
        $email->setting["user_id"] = $email_log["user_id"];
        $email->setting["title"] = "TripEC用户激活";
        $email->setting["code"] = rand_string(6, 5);
        $link = __HOST__ . U('user_active_byemail', array("code" => $email->setting["code"], "username" => $objUserTmp['username']));
        $email->setting["link"] = md5($link);
        $runtime = D("runtime");
        $content = $runtime
                ->assign($email->setting)
                ->assign("to_user", $email_str)
                ->assign("title", "tripec")
                ->assign("active_url", $link)
                ->get_contents("email/register");
        $email->setting["content"] = $content;

        if ($email->send($email_log['email'], $email_log['email'], "", "", $return)) {

            $resend = U('register_resend', array('tid' => $tid, 'sid' => $return['data']['sid']));
            $this->assign("tid", $tid);
            $this->assign("resend", $resend);
            $this->assign("email_return", $return);
            $this->display("activation");
        } elseif($return['timeout']) {            
            $this->error($return["msg"]);
            exit;
        }else{
             $this->error($return["msg"], U('register'));
            exit;
        }
    }

    public function user_active_byemail() {

        $code = $_GET["code"];
        $username = $_GET["username"];
        $email = D("email");
        $userTmp = M("userTmp");
        $objUserTmp = $userTmp->where("username='$username'")->find();
        $email->setting["timeout"] = 86400;
        $email->setting["type"] = "user_active";
        $email->setting["user_id"] = "0";
        $email->setting["code"] = $code;
        $email->setting["email"] = $objUserTmp['email'];
        $link = __HOST__ . U('user_active_byemail', array("code" => $code, "username" => $username));
        $email->setting["link"] = md5($link);
        if ($email->check_email($return)) {
            $user = D('user');
            $user_email_bind = M('user_email_bind');
            $user_data['username'] = $objUserTmp['username'];
            $user_data['password'] = $objUserTmp['password'];
            $user_data['pay_password'] = $objUserTmp['password'];
            $user_data['email'] = $objUserTmp['email'];
            $user_data['amount'] = 0;
            $user_data['create_time'] = time();
            $user_data['status'] = 1;
            $id = $user->add($user_data);

            $email_data['user_id'] = $id;
            $email_data['email'] = $objUserTmp['email'];
            $email_data['create_time'] = time();
            $email_data['status'] = 1;

            $user_email_bind->add($email_data);
            $userinfo = $user->where("id = '$id'")->find();
            $_GET['referer'] = base64_encode(U('successful'));
            $user->set_login($userinfo);
        } else {
            $this->error("邮件已失效或者已经激活！");
        }
    }

    public function successful() {
        $this->display();
    }

    /**
     * 邮箱找回密码
     */
    public function find_pw_byemail() {
        
    }

    /**
     * 验证用户是否已经注册
     */
    public function ajax_isreguser() {
        header('Content-Type:text/html;charset=utf-8');
        $username = $_GET['username'];
        $user = M("user");
        $count = $user->where("login_name='$username'")->find();
        if ($count > 0) {
            echo '0';
        } else {
            echo '1';
        }
        exit();
    }

    /**
     * 验证邮箱是否存在
     */
    public function ajax_isregmail() {
        header('Content-Type:text/html;charset=utf-8');
        $email = $_GET['email'];
        $user = M("user");
        $count = $user->where("email='$email'")->find();
        if ($count > 0) {
            echo '0';
        } else {
            echo '1';
        }
        exit();
    }

    public function valid() {
        $name = $_POST["name"];
        $param = $_POST["param"];
        $user = M("user");
        $user_tmp = M("user_tmp");
        switch ($name) {
            case "username":
                $map["username"] = $param;
                $user_count = $user->where($map)->count();
                if ($user_count > 0) {
                    $this->ajaxReturn(array("info" => "用户名已经被注册", "status" => "n"));
                }
                $map["create_time"] = array("gt" => time() - 86400);
                $tmp_count = $user_tmp->where($map)->count();
                if ($tmp_count > 0) {
                    $this->ajaxReturn(array("info" => "用户名已经被注册", "status" => "n"));
                }
                $this->ajaxReturn(array("info" => "用户名可以注册", "status" => "y"));
                break;
            case "email":
                $map["email"] = $param;
                $user_count = $user->where($map)->count();
                if ($user_count > 0) {
                    $this->ajaxReturn(array("info" => "邮箱已经被注册", "status" => "n"));
                }
                $this->ajaxReturn(array("info" => "邮箱可以注册", "status" => "y"));
                break;
            default:
                $this->ajaxReturn(array("info" => "非法请求", "status" => "y"));
        }
    }

    /**
     *  找回密码页
     */
    public function retrieve_password() {
        $User = D("User");
        $email = D("email");

        if (empty($_POST)) {
            $this->display();
            exit();
        }

        $username = trim($_POST['username']);
        $email_address = trim($_POST['email']);


        //校验用户名与邮箱是否匹配
        $user_id = $User->where("username='$username' AND email = '$email_address'")->getField('id');

        if ($user_id) {
            $new_password = randpw();

            $data['password'] = md5($new_password);

            $User->where("id=$user_id")->save($data);

            $email->setting["timeout"] = 30;
            $email->setting["type"] = "retrieve_password";
            $email->setting["user_id"] = $user_id;
            $email->setting["title"] = "TripEC找回密码";
            $email->setting["code"] = rand_string(6, 5);
            $link = __HOST__ . U('register/retrieve_password', array("code" => $email->setting["code"], "username" => $username));
            $email->setting["link"] = md5($link);
            $email->setting["content"] = "您已经选择通过邮箱修改了您的密码，新的密码是：" . $new_password . "。请妥善保管好您的新密码。" .
                    "如果此操作并非处于您本人的意愿，请及时与本站工作人员联系，谢谢！";

            if ($email->send($email_address, $email_address, "", "", $return)) {
                $this->display("retrieved_password");
            } else {
                $this->error("邮件发送失败!");
            }
        } else {
            $this->error('用户名和邮箱不匹配，请重新输入！');
        }
    }

}
