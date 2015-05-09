<?php

/**
 * Description of lineorderAction
 *
 * @author Genini
 */
class lineorderAction extends CommonAction {

    public function _initialize() {
        if (ACTION_NAME == 'back')
            return;
        parent::_initialize();
    }

    public function form() {
        $payment_merchant = M('payment_merchant');
        $user_bill = M('user_bill');
        $user_recharge = M('user_recharge');
        $merchant = $payment_merchant->where("MerchantID='{$_POST['MerchantID']}' and status='1'")->find();

        $_POST['OrderId'] = $this->create_orderid();
        $_POST['apiName'] = $merchant['api_lists'];
        $_POST['AutoReceive'] = "http://demo_v1.tripec.cn/index.php/lineorder/back"; //C('paymentAPI_Path');
        $_POST['Receive'] = "http://demo_v1.tripec.cn/index.php/lineorder/front"; //C('paymentAPI_Path');
        $_POST['md5info'] = strtoupper(md5($_POST['MerchantID'] . $_POST['OrderId'] . $_POST['amount'] . $_POST['apiName'] . $merchant['MerchantKey']));

        //M('user_bill')
        $data['user_id'] = $_SESSION['user_id'];
        $data['code_id'] = $_POST['OrderId'];
        $data['money'] = $_POST['amount'];
        $data['balance'] = 0;
        $data['mark'] = 'LINE';
        $data['create_time'] = time();
        $user_bill->add($data);

        //M('user_recharge')
        $user_data['order_id'] = $_POST['order_id'];
        $user_data['user_id'] = $_SESSION['user_id'];
        $user_data['code_id'] = $_POST['OrderId'];
        $user_data['money'] = $_POST['amount'];
        $user_data['api_name'] = $_POST['apiName'];
        $user_data['bank_name'] = $_POST['bank'];
        $user_data['browser'] = $_SERVER['HTTP_USER_AGENT'];
        $user_data['start_time'] = time();
        $user_recharge->add($user_data);
        $this->assign("list", $_POST);
        C("LAYOUT_ON", false);
        header("Content-Type:text/html;charset=utf-8");
        echo "正在处理，请稍后...";
        $this->display();
    }

    public function create_orderid() {
        do {
            $code_id = date("YmdHis") . rand_string(3, 1);
        } while (M('user_bill')->where("code_id='$code_id'")->count());
        return $code_id;
    }

    public function front() {
        $user_bill = M('user_bill')->where("code_id='{$_POST['OrderId']}'")->find();
        dump($_POST);
        $key = M('payment_merchant')->where("MerchantID='{$_POST['MerchantID']}'")->getField("MerchantKEY");
        $md5info = strtoupper(md5($_POST['MerchantID'] . $_POST['OrderId'] . $_POST['amount'] . $_POST['apiName'] . $_POST['status'] . $key));
        if ($md5info != $_POST['md5info']) {
            echo "签名错误";
            exit;
        }
        if (empty($user_bill)) {
            echo "找不到订单信息";
            exit;
        }
        if ($_POST['status'] == '01') {
            $this->assign("post", $_POST);
            $this->display("pay_end");
            exit;
        } else {
            echo "支付失败";
            exit;
        }
    }

    public function back() {
        $user_bill = M('user_bill')->where("code_id='{$_POST['OrderId']}'")->find();
        $key = M('payment_merchant')->where("MerchantID='{$_POST['MerchantID']}'")->getField("MerchantKEY");
        if (empty($user_bill)) {
            echo "找不到订单信息";
            exit;
        }
        $md5info = strtoupper(md5($_POST['MerchantID'] . $_POST['OrderId'] . $_POST['amount'] . $_POST['apiName'] . $_POST['status'] . $key));
        if ($md5info != $_POST['md5info']) {
            echo "签名错误";
            exit;
        }
        
        //支付成功写入明细表并修改状态
        $list = M('user_recharge')->where("code_id='{$_POST['OrderId']}'")->find();
        $olist = M('line_order')->where("id='{$list['order_id']}'")->find();
        M('user_recharge')->where("code_id='{$_POST['OrderId']}'")->setfield(array("status" => "1", "finish_time" => time()));
        //支付成功扣除相应款项
        M('line_order')->where("id='{$list['order_id']}'")->setfield("status", 3);
        $put .= M('line_order')->_sql();
        file_put_contents("./Upload/log/linepay" . date("-YmdHis-") . rand_string(3) . ".txt", $put);
        echo "ok";
        exit;
    }

}

?>