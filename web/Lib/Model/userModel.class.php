<?php

/**
 * Description of UserModel
 *
 * @author Gemini
 */
class UserModel extends Model {

    public $remember = false; //记住登录密码
    /**
     * 字段映射
     * @var array
     */
    protected $_map = array(
        'username' => 'login_name',
        'password' => 'pwd',
    );

    /**
     * 自动验证
     * @var array
     */
    protected $_validate = array(
        array('login_name', '', '帐号已经注册！ ', 0, 'unique', 1), //在新增的时候验证 login_name 字段是否唯一 
        array('password', 'require', '请填写密码！'),
        array('password_repat', 'pwd', '确认密码不正确 ', 1, 'confirm'), //  验证确认密码是否和密码一致
        array('email', '', '此邮箱已经注册! ', 0, 'unique', 3), //在新增或修改的时候验证 email 字段是否唯一
    );

    /**
     * 自动填充
     * @var array 
     */
    protected $_auto = array(
        array('status', '1', 1),
        array('pwd', 'md5', 3, 'function'),
//        array('create_time', 'mktime', 3, 'function'),  
    );

    /**
     * 获取用户登陆信息
     * @param bool $cookie 是否使用通过记住密码的cookie获取，默认不使用
     * @return array
     */
    public function getLoginUser($cookie = false) {
        return $_SESSION[C('USER_AUTH_KEY')] ? $this->find($_SESSION[C('USER_AUTH_KEY')]) : $this->getCookieUser($cookie);
    }

    /**
     * 设置用户的登陆信息
     * @param array $user_arr 用户信息
     * @param bool $cookie 是否用cookie记住密码
     */
    public function setLoginInfo($user_arr, $cookie = false) {
        $_SESSION[C('USER_AUTH_KEY')] = $user_arr['id'];
        if ($cookie) {
            $user_token_time = time() + 3600 * 24 * 30; //token到期时间
            $user_token = md5($user_arr['id'] . $user_arr[$this->$_map['password']] . $user_token_time);
            setcookie(C('USER_AUTH_KEY'), $user_arr['id'], $user_token_time, '/');
            setcookie('user_token_time', $user_token_time, $user_token_time, '/');
            setcookie('user_token', $user_token, $user_token_time, '/');
        }
    }

    /**
     * 清除用户登陆信息 
     */
    public function clearLoginInfo() {
        $_SESSION = array();
        isset($_COOKIE['user_id']) ? setcookie("user_id", "", time() - 3600, "/") : false;
        isset($_COOKIE['user_login_time']) ? setcookie("user_login_time", "", time() - 3600, "/") : false;
        isset($_COOKIE['user_login_token']) ? setcookie("user_login_token", "", time() - 3600, "/") : false;
    }

    //如果使用了记住密码功能，根据cookie返回用户信息    
    private function getCookieUser($cookie) {
        if (!$cookie)
            return false;
        else {
            $id = isset($_COOKIE[C('USER_AUTH_KEY')]) ? $_COOKIE[C('USER_AUTH_KEY')] : 0;
            $user_arr = $id ? $this->getpassword($id) : 0;
            $token_time = isset($_COOKIE['user_token_time']) ? $_COOKIE['user_token_time'] : time() - 3600;
            $token = isset($_COOKIE['user_token']) ? $_COOKIE['user_token'] : "";
            $validate_token = md5($id . $user_arr[$this->$_map['password']] . $token_time);
            if ($token_time > time() && $token == $validate_token) {
                $_SESSION[C('USER_AUTH_KEY')] = $id;
                return $user_arr;
            } else
                false;
        }
    }

    /**
     * 设置登录信息
     * @param type $userinfo 用户信息
     */
    public function set_login($userinfo, $isajax = false) {
//        dump($_COOKIE);
//        exit;
        $_SESSION["user_id"] = $userinfo["id"];
        $_SESSION["user_name"] = $userinfo['username'];
        $_SESSION["login_time"] = $userinfo['login_time'];
        $_SESSION["login_ip"] = $userinfo['login_ip'];
        
        if ($this->remember) {
            $time = time();
            setcookie("user_id", $_SESSION["user_id"], $time + 864000, "/");
            setcookie("user_login_time", $time, $time + 864000, "/");
            setcookie("user_login_token", md5($userinfo["id"] . $time . C("DB_PWD")), $time + 864000, "/");
        }
                
        $update = array(
            'login_time' => time(),
            'login_ip' => get_client_ip(),
            'hits' => $userinfo['hits'] + 1,
        );
        unset($_SESSION['login_count']);
        M("user")->where("id=" . $userinfo['id'])->save($update);
        if ($isajax === false) {          
           
            
            redirect(base64_decode($_GET['referer']));
            exit;
        } else {
            $data = array(
                "info" => "登录成功",
                "status" => "1",
                "data" => $isajax
            );
            return $data;
        }
    }

    public function hasNotReg(&$msg) {
        if (!isset($_POST["agree"])) {
            $msg = "必须同意才能注册";
            return false;
        }
        if ($_POST["password"] != $_POST["password"]) {
            $msg = "两次密码不一致";
            return false;
        }
        $map["username"] = trim($_POST["username"]);
        $u_count = $this->where($map)->count();
        if ($u_count > 0) {
            $msg = "用户名已经被注册";
            return false;
        }
        $map["create_time"] = array("gt" => time() - 86400);
        $tmp_count = M("user_tmp")->where($map)->count();
        if ($tmp_count > 0) {
            $msg = "用户名已经被注册";
            return false;
        }
        $where["email"] = trim($_POST["email"]);
        $e_count = $this->where($where)->count();
        if ($e_count > 0) {
            $msg = "邮箱已经被注册";
            return false;
        }
        return true;
    }


    /**
     *  获取用户的详细信息
     */
    public function get_user_detail($user_id) {
        $User = M('user');

        $user_detail = $User->table(C('DB_PREFIX') . "user AS user ")
                            ->join(C('DB_PREFIX'). "user_info AS info ON user.id=info.user_id")
                            ->join(C('DB_PREFIX'). "education_background AS education ON info.education=education.id")
                            ->join(C('DB_PREFIX'). "industry_background AS industry ON info.industry=industry.id")
                            ->where("user.id=".$user_id)
                            ->find();
       
        if ($user_detail) {
            return $user_detail;
        } else {
            return NULL;
        }
    }
	
	    /*
      资金处理
      userid- 用户ID
      money-变化金额
      now_money-变化后帐号当前金额
      types-明细类型
      in_type-收支类型，0：支出，1收入
     */

    public function change_money($user_id, $money, $types, $in_type) {
        if ($money > 0) {
            $Income = M("income");
            if ($in_type == 0) {
                $this->where("id=$user_id")->setDec("money", $money);
            } else {
                $this->where("id=$user_id")->setInc("money", $money);
            }

            $now_money = $this->where("id=$user_id")->getField("money");

            $data["user_id"] = $user_id;
            $data["code_id"] = $this->get_code($user_id);
            $data["money"] = $money;
            $data["now_money"] = $now_money;
            $data["types"] = $types;
            $data["in_type"] = $in_type;
            $data["create_time"] = time();
            $Income->add($data);
        }
    }

    public function get_code($user_id) {
        do {
            $code_id = date("YmdHis").$user_id . rand_string(3, 1);
        } while (M('income')->where("code_id='$code_id'")->count());
        return $code_id;
    }
	
}

?>
