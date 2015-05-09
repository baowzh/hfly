<?php

/**
 * Description of paymentapiAction
 *
 * @author Administrator
 */
class_exists("spyc") or import("ORG.Util.spyc"); //yml解析类

class paymentapiAction extends Action {

    public function banks() {
        $api_name = $_POST["api_name"];
        if (!$api_name) {
            $this->ajaxReturn(array("status" => "n", "data" => "", "info" => "请求的接口名称不能为空"));
            exit;
        }
        $payment_api = M("payment_api");
        $where["names_en"] = $api_name;
        $payment = $payment_api->where($where)->find();
        if (!$payment) {
            $this->ajaxReturn(array("status" => "n", "data" => "", "info" => "请求的接口不存在"));
            exit;
        }
        if ($payment["status"] != 1) {
            $this->ajaxReturn(array("status" => "n", "data" => "", "info" => $payment["names"] . "接口在维护中.."));
            exit;
        }
        $payment_bank = M("payment_bank");
        $banks = $payment_bank->where("api_id={$payment['api_id']} and status=1")->order("types")->select();
        $data = array(1 => array(), 2 => array());
        foreach ($banks as $val) {
            $data[$val["types"]][] = array(
                "code" => $val["mark"],
                "icon" => __HOST__ . __ROOT__ . "/" . $val["pic"],
                "name" => $val["names"],
                "class" => "style"
            );
        }
        $this->ajaxReturn(array("status" => "y", "data" => $data, "info" => "返回成功"));
    }

    public function get_banks($api_name) {
        if (!$api_name) {
            return array("status" => "n", "data" => "", "info" => "请求的接口名称不能为空");
        }
        $payment_api = M("payment_api");
        $where["names_en"] = $api_name;
        $payment = $payment_api->where($where)->find();
        if (!$payment) {
            return array("status" => "n", "data" => "", "info" => "请求的接口不存在");
        }
        if ($payment["status"] != 1) {
            return array("status" => "n", "data" => "", "info" => $payment["names"] . "接口在维护中..");
        }
        $payment_bank = M("payment_bank");
        $banks = $payment_bank->where("api_id={$payment['api_id']} and status=1")->order("types")->select();
        $data = array(1 => array(), 2 => array());
        foreach ($banks as $val) {
            $data[$val["types"]][] = array(
                "code" => $val["mark"],
                "icon" => __HOST__ . __ROOT__ . "/" . $val["pic"],
                "name" => $val["names"],
                "class" => $val["style"]
            );
        }
        return array("status" => "y", "data" => $data, "info" => "返回成功");
    }
    
    public function manage() {
        $MerchantID = $_POST["MerchantID"];
        $payment_merchant = M("payment_merchant");
        $merchant_info = $payment_merchant->where(array("MerchantID" => $MerchantID))->find();
        if (!$merchant_info) {
            $this->front("商户号不存在！", $_POST);
        }
        if ($merchant_info["status"] != 1) {
            $this->front("商户未激活！", $_POST);
        }
        $api_lists = explode(",", $merchant_info["api_lists"]);
        if (!in_array($_POST["apiName"], $api_lists)) {
            $this->front("无权使用", $_POST);
        }
        $payment_api = M("payment_api");
        $where["names_en"] = $_POST["apiName"];
        $payment = $payment_api->where($where)->find();
        if (!$payment) {
            $this->front("请求参数错误！", $_POST);
        }
        if ($payment["status"] != 1) {
            $this->front($payment["names"] . "接口在维护中..", $_POST);
        }
        $payment_bill = M("payment_bill");
        $where = array(
            "OrderId" => $_POST['OrderId'],
            "MerchantID" => $_POST['MerchantID'],
        );
        $old_bill = $payment_bill->where($where)->find();
        if ($old_bill) {
            if ($old_bill['status'] == 1) {
                $this->front($_POST['OrderId'] . "已经支付完成，请不要重复支付", $_POST);
            }
            if ($old_bill['amount'] != $_POST['amount']) {
                $this->front("重复支付的订单不能改变金额", $_POST);
            }
        }
        if (!$this->check_md5($merchant_info['MerchantKey'])) {
            $this->front("签名校验失败", $_POST);
        }
        $data = $this->create_bill($old_bill, $_POST);
        $post = $this->create_post($data, $payment);
        $this->assign("post", $post);
        $this->assign("payment", $payment);
        C("LAYOUT_ON", false);
        C("TOKEN_ON", false);
        $this->display();
    }

    //前台返回的通知
    public function front($msg, $post = array()) {
        header("Content-Type:text/html; charset=utf-8");
        exit($msg);
    }

    //后台返回通知
    public function back($status, $params = array(), $echo = "") {
        $put = var_export($params, true);
        if ($status == "success") {
            file_put_contents("./Upload/log/success-" . $_GET['paymentname'] . date("-YmdHis-") . rand_string(3) . ".txt", $put);
            exit($echo ? $echo : "ok");
        } else {
            file_put_contents("./Upload/log/error-" . $_GET['paymentname'] . date("-YmdHis-") . rand_string(3) . ".txt", $put);
            exit($echo ? $echo : "error");
        }
    }

    //前台接收地址
    public function receive() {
        $paymentname = $_GET["paymentname"];
        $where["names_en"] = $paymentname;
        $payment_api = M("payment_api");
        $payment = $payment_api->where($where)->find();
        if (!$payment) {
            $this->front("非法数据！", $_POST);
        }
        $configs = spyc_load($payment["configs"]);
        $orms = $configs["orm"]['return'];
        $fields = $_POST;
        $fields[$orms["MerchantKey"]] = $payment["merchantkey"];
        foreach ($configs["static"] as $skey => $sval) {
            $fields[$skey] = $sval;
        }
        $patterns = array("/#([a-zA-Z0-9_]+)#/e", "/%([a-zA-Z0-9_]+)%/e");
        $replaces = array('date("\\1")', '$fields["\\1"]');
        foreach ($configs["rules"]['return'] as $rkey => $rval) {
            $tmp_val = preg_replace($patterns, $replaces, $rval[0]);
            for ($i = 1; $i < count($rval); $i++) {
                $funcs = explode("=", $rval[$i]);
                if (count($funcs) == 1) {
                    $tmp_val = $funcs[0]($tmp_val);
                    continue;
                } else {
                    $params_str = substr($rval[$i], strlen($funcs[0]) + 1);
                    $params = array(0 => $tmp_val);
                    preg_replace("/\'([^\']*)\'/e", '$params[]="\\1";', $params_str);

                    foreach ($params as $p => $v) {
                        if ($v == "###") {
                            $params[$p] = $tmp_val;
                            unset($params[0]);
                            break;
                        }
                    }
                    $tmp_val = call_user_func_array($funcs[0], $params);
                }
            }
            $fields[$rkey] = $tmp_val;
        }
        if ($fields[$orms['returnmd5info']] != $fields[$orms['returnmd5check']]) {
            $this->front("签名检验失败", $_POST);
        }
        $status_msg = $configs["orm"]['status'][$fields[$orms['status']]];
        if ($fields[$orms['status']] != $configs["orm"]['status']['success']) {
            $this->front($status_msg ? $status_msg : "支付失败", $_POST);
        }
        $bill_info = M("payment_bill")->where(array('POrderId' => $fields[$orms['OrderId']]))->find();
        if (!$bill_info) {
            $this->front("非法订单", $_POST);
        }
        $payment_merchant = M("payment_merchant");
        $merchant_info = $payment_merchant->where(array("MerchantID" => $bill_info["MerchantID"]))->find();
        $post = array(
            "MerchantID" => $bill_info["MerchantID"],
            "OrderId" => $bill_info['OrderId'],
            "amount" => $fields[$orms['amount']],
            "status" => "01",
            "apiName" => $paymentname,
            "info" => $status_msg ? $status_msg : "支付完成",
            "bank" => $fields[$orms['bank']],
            "remark1" => $bill_info['remark1'],
            "remark2" => $bill_info['remark2']
        );
        $post['md5info'] = strtoupper(md5($post['MerchantID'] . $post['OrderId'] . $post['amount'] . $paymentname . "01" . $merchant_info['MerchantKey']));
        $this->assign("post", $post);
        $this->assign("payment", array("url" => $bill_info['Receive']));
        C("LAYOUT_ON", false);
        C("TOKEN_ON", false);
        $this->display("manage");
    }

    //后台接收地址
    public function autoreceive() {
        $paymentname = $_GET["paymentname"];
        $where["names_en"] = $paymentname;
        $payment_api = M("payment_api");
        $payment = $payment_api->where($where)->find();
        if (!$payment) {
            $this->back("error", $_POST);
        }
        $configs = spyc_load($payment["configs"]);
        $orms = $configs["orm"]['return'];
        $fields = $_POST;
        $fields[$orms["MerchantKey"]] = $payment["merchantkey"];
        foreach ($configs["static"] as $skey => $sval) {
            $fields[$skey] = $sval;
        }
        $patterns = array("/#([a-zA-Z0-9_]+)#/e", "/%([a-zA-Z0-9_]+)%/e");
        $replaces = array('date("\\1")', '$fields["\\1"]');
        foreach ($configs["rules"]['return'] as $rkey => $rval) {
            $tmp_val = preg_replace($patterns, $replaces, $rval[0]);
            for ($i = 1; $i < count($rval); $i++) {
                $funcs = explode("=", $rval[$i]);
                if (count($funcs) == 1) {
                    $tmp_val = $funcs[0]($tmp_val);
                    continue;
                } else {
                    $params_str = substr($rval[$i], strlen($funcs[0]) + 1);
                    $params = array(0 => $tmp_val);
                    preg_replace("/\'([^\']*)\'/e", '$params[]="\\1";', $params_str);

                    foreach ($params as $p => $v) {
                        if ($v == "###") {
                            $params[$p] = $tmp_val;
                            unset($params[0]);
                            break;
                        }
                    }
                    $tmp_val = call_user_func_array($funcs[0], $params);
                }
            }
            $fields[$rkey] = $tmp_val;
        }
        if ($fields[$orms['returnmd5info']] != $fields[$orms['returnmd5check']]) {
            $this->back("error", array($_POST, $fields), $configs["orm"]['status']['error_echo']);
        }
        $status_msg = $configs["orm"]['status'][$fields[$orms['status']]];
        if ($fields[$orms['status']] != $configs["orm"]['status']['success']) {
            $this->back("error", $_POST, $configs["orm"]['status']['error_echo']);
        }
        $bill_info = M("payment_bill")->where(array('POrderId' => $fields[$orms['OrderId']]))->find();
        if (!$bill_info) {
            $this->back("error", array($_POST, $fields), $configs["orm"]['status']['error_echo']);
        }
        $payment_merchant = M("payment_merchant");
        $merchant_info = $payment_merchant->where(array("MerchantID" => $bill_info["MerchantID"]))->find();
        if ($bill_info['status'] != 1) {
            M("payment_bill")->where(array("id" => $bill_info['id']))->save(array('status' => '1','finish_time'=>time()));
        }
        $post = array(
            "MerchantID" => $bill_info["MerchantID"],
            "OrderId" => $bill_info['OrderId'],
            "amount" => $fields[$orms['amount']],
            "status" => "01",
            "apiName" => $paymentname,
            "info" => $status_msg ? $status_msg : "支付完成",
            "bank" => $fields[$orms['bank']],
            "remark1" => $bill_info['remark1'],
            "remark2" => $bill_info['remark2']
        );
        $post['md5info'] = strtoupper(md5($post['MerchantID'] . $post['OrderId'] . $post['amount'] . $paymentname . "01" . $merchant_info['MerchantKey']));
        $curl = $this->curl_post($post, $bill_info['AutoReceive']);
        if ($curl != "ok") {
            $put_content = "<?php return array('post'=>" . var_export($post, true) . ",'url'=>'{$bill_info['AutoReceive']}',";
            $put_content .= "'count'=>1,'runtime'=>" . time() . ");?>";
            file_put_contents("./Upload/runlog/{$bill_info['OrderId']}-{$fields[$orms['OrderId']]}.php", $put_content);
        }
        $this->back("success", array($_POST, $fields), $configs["orm"]['status']['success_echo']);
    }

    public function curl_post($post, $url, $cookie = array()) {
        $conn = curl_init($url);
        //curl_setopt($conn, CURLOPT_TIMEOUT, 10);
        curl_setopt($conn, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($conn, CURLOPT_MAXREDIRS, 7); //HTTp定向级别
        curl_setopt($conn, CURLOPT_HEADER, 1);
        if ($cookie) {
            curl_setopt($conn, CURLOPT_COOKIE, join(';', $cookie));
        }
        curl_setopt($conn, CURLOPT_POST, 1);
        curl_setopt($conn, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($conn, CURLOPT_FOLLOWLOCATION, 1); // 302 redirect
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($conn);
        list($header, $body) = explode("\r\n\r\n", $content);
        preg_match_all("/set\-cookie:([^\r\n]*)/i", $header, $matches);
        $cookies = $cookies_tmp = array();
        if ($matches) {
            foreach ($matches[1] as $match) {
                $cookies_tmp = array_merge($cookies_tmp, explode(";", $match));
            }
        }
        foreach ($cookies_tmp as $item) {
            $item = trim($item);
            if (!in_array($item, $cookies))
                $cookies[] = $item;
        }
        $response['cookie'] = $cookies;
        $response['header'] = $header;
        preg_match("/^HTTP(?:S)?\/\d\.\d\s(\d*)\s/", $header, $http_status);
        $response['status'] = $http_status[1];
        $response['body'] = $body;
        $response['content'] = $content;
        $put = var_export($response, true);
        file_put_contents("./Upload/log/response-" . $_GET['paymentname'] . date("-YmdHis-") . rand_string(3) . ".txt", $put);
        return $body;
    }

    //校验签名
    private function check_md5($key) {
        $MerchantID = $_POST['MerchantID'];
        $OrderId = $_POST['OrderId'];
        $amount = $_POST['amount'];
        $apiName = $_POST['apiName'];
        return $_POST["md5info"] == strtoupper(md5($MerchantID . $OrderId . $amount . $apiName . $key));
    }

    //创建订单
    public function create_bill($old_bill, $post) {
        $data['OrderId'] = $post['OrderId'];
        $data['POrderId'] = $old_bill['POrderId'] ? $old_bill['POrderId'] : $this->create_PorderId();
        $data['MerchantID'] = $post['MerchantID'];
        $data['amount'] = $post['amount'];
        $data['apiName'] = $post['apiName'];
        $data['AutoReceive'] = $post['AutoReceive'];
        $data['Receive'] = $post['Receive'];
        $data['bank'] = $post['bank'];
        $data['remark1'] = $post['remark1'];
        $data['remark2'] = $post['remark2'];
        $data['start_time'] = $old_bill['start_time'] ? $old_bill['start_time'] : time();
        $data['browser'] = $_SERVER["HTTP_USER_AGENT"];
        $data['status'] = 0;
        if ($old_bill) {
            M("payment_bill")->where(array('id' => $old_bill['id']))->save($data);
            $data['id'] = $old_bill['id'];
        } else {
            $data['id'] = M("payment_bill")->add($data);
        }
        return $data;
    }

    //生成单号
    private function create_PorderId() {
        $payment_bill = M('payment_bill');
        do {
            $POrderId = date("YmdHis") . rand_string(6, 1);
            $count = $payment_bill->where('POrderId=\'' . $POrderId . '\'')->count();
        } while ($count > 0);
        return $POrderId;
    }

    //生成Post
    public function create_post($data, $payment) {
        $maps = array(
            "MerchantID" => $payment["merchantid"],
            "MerchantKey" => $payment["merchantkey"],
            "OrderId" => $data["POrderId"],
            "amount" => $data["amount"],
            "AutoReceive" => $this->get_AutoReceive($data["apiName"]),
            "Receive" => $this->get_Receive($data["apiName"]),
            "bank" => $data["bank"],
            "remark1" => $data["remark1"],
            "remark2" => $data["remark2"],
            "sendmd5info" => ""
        );
        $configs = spyc_load($payment["configs"]);
        if (!is_array($configs)) {
            $this->front("接口配置出错，请联系客服", $post);
        }
        $fields = array();
        foreach ($maps as $key => $val) {
            if (isset($configs["orm"]['send'][$key])) {
                $fields[$configs["orm"]['send'][$key]] = $val;
            }
        }
        foreach ($configs["static"] as $skey => $sval) {
            $fields[$skey] = $sval;
        }
        $patterns = array("/#([a-zA-Z0-9_]+)#/e", "/%([a-zA-Z0-9_]+)%/e");
        $replaces = array('date("\\1")', '$fields["\\1"]');
        foreach ($configs["rules"]['send'] as $rkey => $rval) {
            $tmp_val = preg_replace($patterns, $replaces, $rval[0]);
            for ($i = 1; $i < count($rval); $i++) {
                $funcs = explode("=", $rval[$i]);
                if (count($funcs) == 1) {
                    $tmp_val = $funcs[0]($tmp_val);
                    continue;
                } else {
                    $params_str = substr($vals[$i], strlen($funcs[0]) + 1);
                    $params = array(0 => $tmp_val);
                    preg_replace("/\'([^\']*)\'/e", '$params[]=\\1;', $params_str);
                    foreach ($params as $p => $v) {
                        if ($v == "###") {
                            $params[$p] = $tmp_val;
                            unset($params[0]);
                            break;
                        }
                    }
                    $tmp_val = call_user_func_array($funcs[0], $params);
                }
            }
            $fields[$rkey] = $tmp_val;
        }
        $post = array();
        foreach ($configs["required"] as $required) {
            if (empty($fields[$required])) {
                $this->front("$required 为必填字段！", $_POST);
                break;
            }
            $post[$required] = $fields[$required];
        }
        foreach ($configs["optional"] as $optional) {
            $post[$optional] = $fields[$optional];
        }
        return $post;
    }

    //后台通知地址
    private function get_AutoReceive($type) {
        return __HOST__ . U("autoreceive", array("paymentname" => $type));
    }

    //前台通知地址
    private function get_Receive($type) {
        return __HOST__ . U("receive", array("paymentname" => $type));
    }

}
