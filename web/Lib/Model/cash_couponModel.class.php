<?php

class cash_couponModel extends Model {
    /*
      优惠券处理
      $code 优惠券号
     */

    //标记使用
    public function change_coupon($code,$user_id) {
        $time = time();
        $coupon = $this->where("serial_num='$code' AND status='0'")->find();
        if ($coupon['coupon_value'] > 0) {
            $data = array('status' => 1, 'use_uid' => $user_id, 'use_time' => $time);
            if ($this->where("serial_num='$code' AND status='0'")->setfield($data)) {
                return $code;
            }
        }
    }
    //退回序列号
    public function back_coupon($code,$user_id) {
        $coupon = $this->where("serial_num='$code' AND status='1'")->find();
        if ($coupon['coupon_value'] > 0) {
            $data = array('status' => 0, 'use_uid' => null, 'use_time' => null);
            if ($this->where("serial_num='$code' AND status='1'")->setfield($data)) {
                return $code;
            }
        }
    }

    public function show_coupon($code) {
        return $this->where("serial_num='$code'")->getfield('coupon_value') ? $this->where("serial_num='$code'")->getfield('coupon_value') : 0;
    }

}

?>
