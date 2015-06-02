<?php

/**
 * Description of emailModel
 * @author Administrator
 */
class emailModel extends Model {

    protected $_auto = array(
        array("send_id", "get_send_id", 1, "callback"),
        array("receive", "get_receive", 1, "callback"),
        array("att_id", "get_att_id", 1, "callback"),
        array("send_time", "0", 1, "string"),
        array("create_time", "time", 1, "function"),
        array("create_time", "time", 1, "function"),
        array("status", "0", 1, "string"),
    );
    protected $email_error;
    protected $email_config = array();
    protected $send_log;
    protected $file_manager;

    /**
     * 发送时设置
     * @var array
     * @$setting["timeout"] 超时设置,单位秒，默认0(代表不限时间)
     * @$setting["type"] 发送类型，默认为 unknown
     * @$setting["auth"] 是否要求通过手机认证才发送，默认为false
     * @$setting["code"] 发送时附带的验证码，默认0
     * @$setting["user_id"] 发送时附带的验证码，默认0
     * @$setting["email_id"] 邮箱id
     * @$setting["link"] 邮件中附带的验证链接
     * @$setting["att"] 邮件中附件id
     * @$setting["att_path"] 邮件中附件路径
     */
    public $setting = array();

    public function _initialize() {
        parent::_initialize();
        $this->send_log = M("email_log");
        $this->file_manager = M("file_manager");
        $this->email_config = C("email_api");
        class_exists('PHPMailer') or import('ORG.Net.PHPMailer');
    }

    /**
     * 发送邮件
     * @param type $email 邮箱地址
     * @param type $email_name 邮箱显示的用户名
     * @param type $title 邮箱标题
     * @param type $content 邮箱内容
     * @param type $return 返回结果
     * @return boolean
     */
    public function send($email = null, $email_name = null, $title = null, $content = null, &$return = array()) {
      //  $email = $this->get_email($email);
        if (!$email) {
            $return["msg"] = '邮箱地址不能为空';
            return false;
        }
        $emails = explode(",", $email);
        foreach ($emails as $email_item) {
        	
            if (!$this->regex($email_item, "email")) {
                $return["msg"] = '邮箱格式不正确';
                return false;
                break;
            }
        }
        $title = $this->get_title($title);
        $content = $this->get_content($content);
        if (!$content || !$title) {
            $return["msg"] = '发送主题或内容不能为空';
            return false;
        }
        $time = time();
        $out = $this->setting["timeout"] ? $this->setting["timeout"] : 0;
        $type = $this->setting["type"] ? $this->setting["type"] : "unknown";
        $auth = $this->setting["auth"] ? $this->setting["auth"] : false;
        $code = $this->setting["code"] ? $this->setting["code"] : 0;
        $email_id = $this->setting["email_id"] ? $this->setting["email_id"] : 0;
        $link = $this->setting["link"] ? $this->setting["link"] : "#";
        $att = $this->setting["att"] ? $this->setting["att"] : "";
        $Attachment = $this->get_attachment();
        $user_id = $this->get_user($email);
        /*
        if (!$this->is_timeout($time, $email, $type, $out) || !$this->is_auth($email, $auth)) {
            $return["msg"] = $this->email_error;
            $return["timeout"]=true;
            return false;
        }*/
        if (!$this->send_email($email, $email_name, $title, $content, $Attachment)) {
            $return["sms_return"] = $this->email_return;
            $return["msg"] = $this->email_error;
            return false;
        }
        /*
        $sms_data = array();
        $sms_data["email_id"] = $email_id;
        $sms_data["send_id"] = $this->user_id == 0 && isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
        $sms_data["user_id"] = $user_id;
        $sms_data["email"] = $email;
        $sms_data["create_time"] = $time;
        $sms_data["title"] = $title;
        $sms_data["content"] = $content;
        $sms_data["att_id"] = is_array($att) ? join(",", $att) : $att;
        $sms_data["type"] = $type;
        $sms_data["code"] = $code;
        $sms_data["link"] = $link;
        $sms_data["status"] = $out == 0 ? 1 : 0;
        $sms_data["sid"] = $status = $this->send_log->add($sms_data);
        $return["data"] = $sms_data;
        $return["email_return"] = $this->email_error;
        $return["email_server"] = "http://mail." . end(explode("@", $email));
        */
        return true;
    }

    public function check_email(&$return, $change_status = 1) {
        $time = time();
        $email = $this->setting["email"] ? $this->setting["email"] : M("user")->where("id=" . $this->setting["user_id"])->getField("email");
        $map = array(
            'email' => array('eq', $email),
            'type' => array('eq', $this->setting["type"]),
            'create_time' => array('gt', $time - $this->setting["timeout"]),
            'user_id' => array('eq', $this->setting["user_id"]),
            'link' => array('eq', $this->setting["link"]),
            "status" => 0
        );
        $return = $this->send_log->where($map)->order("id desc")->find();
        if ($return && $change_status) {
            $this->send_log->where($map)->setField("status", $change_status);
        }
        return $return ? true : false;
    }

    /**
     * @param type $email
     * @param type $email_name
     * @param type $title
     * @param type $body
     * @param type $Attachment
     * @return boolean
     */
      private function send_email($email, $email_name, $title, $body, $Attachment = null) {
        $mail = new PHPMailer();
        $mail->IsSMTP(); //使用SMTP方式发送
        $mail->SMTPAuth = true; //设置服务器是否需要SMTP身份验证
        $mail->Host = $this->email_config['email_server']; //SMTP 主机地址 
        $mail->Port = $this->email_config['email_port']; //SMTP 主机端口
        $mail->From = $this->email_config['email_user']; //发件人EMAIL地址
        $mail->FromName = $this->email_config['email_fromname']; //发件人在SMTP主机中的用户名 
        $mail->Username = $this->email_config['email_user']; //发件人的姓名 
        $mail->Password = $this->email_config['email_pwd']; //发件人在SMTP主机中的密码 
        $mail->CharSet = $this->email_config['email_charset']; //发件人在SMTP主机中的密码 
        $mail->Subject = $title; //邮件主题 
        $mail->AltBody = 'text/html'; //设置在邮件正文不支持HTML时的备用显示
        $mail->Body = $body; //邮件内容做成
        $mail->IsHTML(true); //是否是HTML邮件
        $emails = explode(',', $email);
        $email_names = explode(',', $email_name);
        foreach ($emails as $k => $v) {
            $_name = isset($email_names[$k]) ? $email_names[$k] : $v;
            $mail->AddAddress($v, $_name); //收件人的地址和姓名 
        }
        $mail->AddReplyTo($this->email_config['email_return'], $this->email_config['email_returnname']); //收件人回复时回复给的地址和姓名
        if ($Attachment) {
            foreach ($Attachment as $v) {
                $mail->AddAttachment($v['path'], $v['name']); //附件的路径和附件名称
            }
        }
        try {
            $mail->Send(true);
        } catch (phpmailerException $e) {
            $code = $e->getCode();
            if ($code == 0)
                $msg = "您输入的邮箱不存在！";
            else {
                $msg = $e->errorMessage();
            }
            $this->email_error = "邮件错误: " . $msg;
            //print_r( $this->email_error);
            return false;
        }
        return true;
    }

    protected function get_email($email) {
        if ($email) {
            return $email;
        }
        $user_id = isset($this->setting["user_id"]) ? $this->setting["user_id"] : $this->user_id;
        $auth_phone = M("user_email_authentic")->where("status=1 and user_id=$user_id")->getField("email");
        if ($auth_phone) {
            return $auth_phone;
        }
        $email = M("user")->where("status=1 and id=$user_id")->getField("email");
        return $email;
    }

    private function get_user($email) {
        $user_id = isset($this->setting["user_id"]) ? $this->setting["user_id"] : $this->user_id;
        if ($user_id > 0) {
            return $user_id;
        }
        if (isset($this->setting["user_id"])) {
            return $this->setting["user_id"];
        }
        $auth_user_id = M("user_email_authentic")->where("status=1 and phone='$email'")->getField("user_id");
        if ($auth_user_id) {
            return $auth_user_id;
        }
        $id = M("user")->where("status=1 and email='$email'")->getField("id");
        return $id;
    }

    private function get_content($content) {
        return $content ? $content : (isset($this->setting['content']) ? $this->setting['content'] : "");
    }

    private function get_title($title) {
        return $title ? $title : (isset($this->setting['title']) ? $this->setting['title'] : "");
    }

    private function is_timeout($time, $email, $type, $out, $gtype = false) {
        if ($out == 0) {
            return true;
        }
        $map0 = array(
            'email' => array('eq', $email),
            'type' => array('eq', $type),
            'create_time' => array('lt', $time - $out),
            "status" => 0
        );
        //将所有已过期的状态设置为1
        $this->send_log->where($map0)->setField('status', '1');
        $map = array(
            'email' => array('eq', $email),
            'type' => array('eq', $type),
            'create_time' => array('gt', $time - $out),
            "status" => 0
        );
        $isout = $this->send_log->where($map)->find();
        if ($isout && !$gtype) {
            $this->email_error = "两次发送间隔时间不能少于" . $out . "秒";
            return false;
        } elseif ($isout && $gtype) {
            return $isout;
        } elseif (!$isout && $gtype) {
            $this->email_error = "邮件验证不正确或验证超时，请在获取邮件后" . $out . "秒内进行验证";
            return false;
        } else {
            return true;
        }
    }

    private function is_auth($email, $auth) {
        if (!$auth) {
            return true;
        }
        $user_authentic = M("user_email_authentic");
        $map["status"] = array("eq", 1);
        $map["email"] = array("in", $email);
        $emailinfo = $user_authentic->where($map)->count();
        if ($emailinfo > 0) {
            return true;
        } else {
            $this->email_error = "邮箱地址未通过认证";
            return false;
        }
    }

    protected function get_attachment() {
        $file_lists = array();
        if (isset($this->setting["att"])) {
            $map["id"] = array("in", $this->setting["att"]);
            $file_list = $this->file_manager->where($map)->select();
            foreach ($file_list as $v) {
                $file_lists[] = array(
                    "name" => $v["names"],
                    "path" => ROOT_PATH . "." . $v["path"],
                );
            }
        }
        if (isset($this->setting["att_path"])) {
            $paths = is_array($this->setting["att_path"]) ? $this->setting["att_path"] : explode(",", $this->setting["att_path"]);
            foreach ($paths as $v) {
                $file_lists[] = array(
                    "name" => basename($v),
                    "path" => ROOT_PATH . "." . $v,
                );
            }
        }
        return $file_lists;
    }

    protected function get_send_id() {
        return $this->user_id == 0 ? $_SESSION['user_id'] : -1;
    }

    protected function get_att_id() {
        $att = isset($this->setting["att"]) ? $this->setting["att"] : $_POST["att"];
        return is_array($att) ? join(",", $att) : $att;
    }

    protected function get_receive() {
        return join(";", $_POST['receive_values']) . ";";
    }

}

?>
