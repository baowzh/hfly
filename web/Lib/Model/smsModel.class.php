<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of smsModel
 *
 * @author Administrator
 */
class smsModel extends Model {

    protected $_auto = array(
        array("send_id", "get_send_id", 1, "callback"),
        array("receive", "get_receive", 1, "callback"),
        array("send_time", "0", 1, "string"),
        array("create_time", "time", 1, "function"),
        array("create_time", "time", 1, "function"),
        array("status", "0", 1, "string"),
    );
    protected $http;
    protected $send_log;
    protected $sms_error;
    protected $user_id;
    protected $sms_config = array();

    /**
     * 发送短信后返回的结果
     * @var array 
     */
    protected $sms_return = array(
        "XML" => "",
        "URL" => "",
        "Msg" => ""
    );

    /**
     * 请求URL地址列表
     * @var array
     */
    protected $url_gather = array(
        'send' => 'sendsms.action', //发送短信地址
        'sendtimesms' => 'sendtimesms.action', //发送定时短信
        'money' => 'querybalance.action', //查询余额地址
        'pay' => 'chargeup.action', //充值地址
        'password' => 'changepassword.action', //修改密码地址
        'getmo' => 'getmo.action', //接收上行短信
        'register' => 'regist.action', //序列号注册
        'logout' => 'logout.action', //注销序列号
        'registdetailinfo' => 'registdetailinfo.action', //注册企业信息
    );

    /**
     * 错误提示码
     * @var array
     */
    protected $error_info = array(
        '3' => '连接过多，指单个节点要求同时建立的连接数过多',
        '10' => '客户端注册失败',
        '11' => '企业信息注册失败',
        '12' => '查询余额失败',
        '13' => '充值失败',
        '14' => '手机转移失败',
        '15' => '手机扩展转移失败',
        '16' => '取消转移失败',
        '17' => '发送信息失败',
        '18' => '发送定时信息失败',
        '22' => '注销失败',
        '27' => '查询单条短信费用错误码',
        '304' => '客户端发送三次失败',
        '305' => '服务器返回了错误的数据，原因可能是通讯过程中有数据丢失',
        '307' => '发送短信目标号码不符合规则，手机号码必须是以0、1开头',
        '308' => '新密码必须是数字'
    );

    /**
     * 发送时设置
     * @var array
     * @$setting["timeout"] 超时设置,单位秒，默认0(代表不限时间)
     * @$setting["type"] 发送类型，默认为 unknown
     * @$setting["auth"] 是否要求通过手机认证才发送，默认为false
     * @$setting["code"] 发送时附带的验证码，默认0
     * @$setting["user_id"] 发送时附带的验证码，默认0
     */
    public $setting = array();

    public function _initialize() {
        parent::_initialize();
        $this->send_log = M("sms_log");
        if (session_name() != "ADMIN_PHPSESSID") {
            $this->user_id = $_SESSION['user_id'];
        } else {
            $this->user_id = 0;
        }
        $this->sms_config = C("sms_api");
        $this->sms_config["sms_url"] = rtrim($this->sms_config["sms_url"], "/") . "/";
        class_exists('Http') or import('ORG.Net.Http');
        $this->http = new Http();
    }

    /**
     * 发送短信
     * @param string $phone 手机号，多个手机号用英文逗号隔开
     * @param string $content 内容
     * @param array $return 返回结果
     * @return string|boolean
     */
    public function send($phone = null, $content = null, &$return = array()) {
        $phone = $this->get_phone($phone);
        if (!$phone) {
            $return["msg"] = '手机号码不能为空';
            return false;
        }
        $content = $this->get_content($content);
        if (!$content) {
            $return["msg"] = '发送内容不能为空';
            return false;
        }
        $time = time();
        $out = $this->setting["timeout"] ? $this->setting["timeout"] : 0;
        $type = $this->setting["type"] ? $this->setting["type"] : "unknown";
        $auth = $this->setting["auth"] ? $this->setting["auth"] : false;
        $code = $this->setting["code"] ? $this->setting["code"] : 0;
        $sms_id = $this->setting["sms_id"] ? $this->setting["sms_id"] : 0;
        $user_id = $this->get_user($phone);
        if (!$this->is_timeout($time, $phone, $type, $out) || !$this->is_auth($phone, $auth)) {
            $return["msg"] = $this->sms_error;
            return false;
        }
        if (!$this->send_sms($phone, $content, $user_id)) {
            $return["sms_return"] = $this->sms_return;
            $return["msg"] = $this->sms_error;
            return false;
        }
        $sms_data = array();
        $sms_data["sms_id"] = $sms_id;
        $sms_data["send_id"] = $this->user_id == 0 ? $_SESSION['user_id'] : 0;
        $sms_data["user_id"] = $user_id;
        $sms_data["phone"] = $phone;
        $sms_data["create_time"] = $time;
        $sms_data["content"] = $content;
        $sms_data["type"] = $type;
        $sms_data["code"] = $code;
        $sms_data["status"] = $out == 0 ? 1 : 0;
        $sms_data["sid"] = $status = $this->send_log->add($sms_data);
        $return["data"] = $sms_data;
        $return["sms_return"] = $this->sms_return;
        return true;
    }

    private function send_sms($phone, $smsText, $user_id, $Addserial = null) {
        $msg = "";
        switch ($this->sms_config['sms_model']) {
            case "1": //正常模式   
                break;
            case "2": //不调用运营商接口模式，即调试模式      
                $msg = $smsText;
                break;
            case "3": //维护模式
                if (preg_match("/(^|\,){$user_id}:(1[3-9]\d{9})/", $match)) {
                    $phone = $match[2];
                } else {
                    $this->sms_error = "当前为短信系统正在进行维护，给您带来不便，敬请原谅！";
                    return false;
                }
        }
        $url = $this->sms_config['sms_url'] . $this->url_gather['send'];
        $url.='?cdkey=' . $this->sms_config['sms_cdkey'];
        $url.='&password=' . $this->sms_config['sms_pwd'] . '&phone=';
        $url.=is_array($phone) ? implode(',', $phone) : $phone;
        $url.='&message=' . urlencode($smsText);
        $url.=$Addserial ? '&addserial=' . $Addserial : '';
        return $this->request_url($url, $msg);
    }

    /**
     * 发送url请求
     * @param string $url
     * @return false|string
     */
    private function request_url($url, $msg) {
        $this->sms_return["XML"] = $result = $this->getSMSresult($url);
        $this->sms_return["URL"] = $url;
        $result_info = $this->xml_decode($result, "response");
        if ($result_info['error'] == 0) {
            $this->sms_return["Msg"] = $msg ? $msg : $result_info['message'];
            return true;
        } elseif ($result_info['error'] > 0 && isset($this->error_info[$result_info['error']])) {
            $this->sms_error = $result_info['error'] . ":" . $this->error_info[$result_info['error']];
            return false;
        } elseif ($result_info['error'] < 0 || !isset($this->error_info[$result_info['error']])) {
            $this->sms_error = $result_info['message'];
        }
    }

    private function getSMSresult($url) {
        if ($this->sms_config["sms_model"] != 2) {
            return $this->http->fsockopenDownload($url);
        } else {
            $return = '<?xml version="1.0" encoding="UTF-8"?>';
            $return.='<response>';
            $return.= '<error>0</error>';
            $return.= '<message>此结果为调试模式下的结果，不是真实返回的结果</message>';
            $return.= '</response>';
            return $return;
        }
    }

    /**
     * 解析xml
     * @param string $xml
     * @param string $root 根元素名称
     * @return array
     */
    private function xml_decode($xml, $root = 'so') {
        if (!$xml) {
            return array("error" => -1, "message" => "未知错误");
        }
        $search = '/<(' . $root . ')>(.*)<\/\s*?\\1\s*?>/s';
        $array = array();
        if (preg_match($search, $xml, $matches)) {
            $array = $this->xml_to_array($matches[2]);
        }
        return $array;
    }

    /**
     * 将xml转换成数组
     * @param type $xml
     * @return array
     */
    private function xml_to_array($xml) {
        $search = '/<(\w+)\s*?(?:[^\/>]*)\s*(?:\/>|>(.*?)<\/\s*?\\1\s*?>)/s';
        $array = array();
        if (preg_match_all($search, $xml, $matches)) {
            foreach ($matches[1] as $i => $key) {
                $value = $matches[2][$i];
                if (preg_match_all($search, $value, $_matches)) {
                    $array[$key] = xml_to_array($value);
                } else {
                    if ('ITEM' == strtoupper($key)) {
                        $array[] = html_entity_decode($value);
                    } else {
                        $array[$key] = html_entity_decode($value);
                    }
                }
            }
        }
        return $array;
    }

    private function get_phone($phone) {
        if ($phone) {
            return $phone;
        }
        $user_id = isset($this->setting["user_id"]) ? $this->setting["user_id"] : $this->user_id;
        $auth_phone = M("user_phone_authentic")->where("status=1 and user_id=$user_id")->getField("phone");
        if ($auth_phone) {
            return $auth_phone;
        }
        $phone = M("user")->where("status=1 and id=$user_id")->getField("phone");
        return $phone;
    }

    private function get_user($phone) {
        $user_id = isset($this->setting["user_id"]) ? $this->setting["user_id"] : $this->user_id;
        if ($user_id > 0) {
            return $user_id;
        }
        if (isset($this->setting["user_id"])) {
            return $this->setting["user_id"];
        }
        $auth_user_id = M("user_phone_authentic")->where("status=1 and phone='$phone'")->getField("user_id");
        if ($auth_user_id) {
            return $auth_user_id;
        }
        $id = M("user")->where("status=1 and phone='$phone'")->getField("id");
        return $id;
    }

    private function get_content($content) {
        return $content ? $content : (isset($this->setting['content']) ? $this->setting['content'] : "");
    }

    private function is_timeout($time, $phone, $type, $out, $gtype = false) {
        if ($out == 0) {
            return true;
        }
        $map0 = array(
            'phone' => array('eq', $phone),
            'send_type' => array('eq', $type),
            'send_time' => array('lt', $time - $out),
            "status" => 0
        );
        //将所有已过期的状态设置为1
        $this->send_log->where($map0)->setField('status', '1');
        $map = array(
            'phone' => array('eq', $phone),
            'send_type' => array('eq', $type),
            'send_time' => array('gt', $time - $out),
            "status" => 0
        );
        $isout = $this->send_log->where($map)->find();
        if ($isout && !$gtype) {
            $this->sms_error = "两次发送间隔时间不能少于" . $out . "秒";
            return false;
        } elseif ($isout && $gtype) {
            return $isout;
        } elseif (!$isout && $gtype) {
            $this->sms_error = "验证码不正确或验证超时，请在获取后" . $out . "秒内进行验证";
            return false;
        } else {
            return true;
        }
    }

    private function is_auth($phone, $auth) {
        if (!$auth) {
            return true;
        }
        $user_authentic = M("user_phone_authentic");
        $map["status"] = array("eq", 1);
        $map["phone"] = array("in", $phone);
        $phoneinfo = $user_authentic->where($map)->count();
        if ($phoneinfo > 0) {
            return true;
        } else {
            $this->sms_error = "手机号码未通过认证";
            return false;
        }
    }

    protected function get_send_id() {
        return $this->user_id == 0 ? $_SESSION['user_id'] : -1;
    }

    protected function get_receive() {
        return join(";", $_POST['receive_values']) . ";";
    }

}

?>
