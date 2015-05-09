<?php

/**
 * 会员提现模块
 */
class withdrawAction extends usercommonAction {

    public function _initialize() {
        parent::_initialize();
        C("TOKEN_ON", false);
    }

    public function withdraw_apply() {
        if (isset($_POST['submit'])) {
            $user_id = ($_SESSION['user_id'] > 0) ? $_SESSION['user_id'] : 0;
            $bf_draw = 0;
            if ($user_id) {
                $bf_draw = M('User')->where("id=$user_id")->getField("amount");
                if ($bf_draw < $_POST["money"]) {
                    $this->error("输入数额已超过可提金额！");
                    exit;
                }
                M('User')->where("id=$user_id")->setDec("amount", $_POST["money"]);
                $bf_draw -= $_POST["money"];
            }
            $withdraw = M('DrawMoney');
            if ($withdraw->create()) {
                $withdraw->user_id = $user_id;
                $withdraw->bf_draw = $bf_draw;
                $withdraw->add_time = time();
                $withdraw->status = 0;
                $withdraw->add();
                session("withdraw_apply", true);
                $this->redirect("withdraw");
            } else {
                $this->error("表单已过期！");
            }
        } else {
            $user_id = ($_SESSION['user_id'] > 0) ? $_SESSION['user_id'] : 0;
            $userinfo = array();
            if ($user_id) {
                $userinfo = M('User')->where("id=$user_id")->find();
                $checking_money = M('DrawMoney')->where("user_id=$user_id")->sum("money");
                $userinfo['checking_money'] = $checking_money;
            }
            $this->assign("userinfo", $userinfo);
            $this->display();
        }
    }

    public function withdraw() {
        if (session("withdraw_apply")) {
            session("withdraw_apply", null);
            $this->display();
        } else {
            $this->redirect("withdraw_list");
        }
    }

    public function withdraw_list() {
        $user_id = ($_SESSION['user_id'] > 0) ? $_SESSION['user_id'] : 0;
        $DrawMoney = M('DrawMoney')->where("user_id=$user_id")->select();
        $this->assign("list", $DrawMoney);
        $this->display();
    }

}

?>
