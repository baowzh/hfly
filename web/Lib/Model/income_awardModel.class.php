<?php

class income_awardModel extends Model {
    /*
      奖金处理
      user_id- 用户ID
      money-变化金额
      now_money-变化后帐号当前金额
      types-明细类型(0:线路,1:酒店,2:经典)
      in_type-收支类型，0：支出，1收入
     */

    public function change_award($user_id, $money, $types, $in_type) {
        if ($money > 0) {
            $user = M("user");
            $line_order = M('line_order');
            if ($in_type == 0) {
                $user->where("id=$user_id")->setDec("award", $money);
            } else {
                $user->where("id=$user_id")->setInc("award", $money);
            }

            do {
                $code = "A" . date("ymdHi") . rand_string(5, 0);
            } while ($line_order->where("code='$code'")->find());

            $now_money = $user->where("id=$user_id")->getField("award");
            $data['user_id'] = $user_id;
            $data['code'] = $code;
            $data["money"] = $money;
            $data["now_money"] = $now_money;
            $data["types"] = $types;
            $data["in_types"] = $in_type;
            $data["create_time"] = time();
            $this->add($data);
        }
    }

}

?>
