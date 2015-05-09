<?php
/**
 * 会员中心
 */
class userAction extends usercommonAction {

    public function index() {	
	$User = M('User');
	$Sms = M('SmsLog');
	$RounteOrder = M('LineOrder');
	$HotelOrder = M('HotelOrder');
	$ViewpointOrder = M('ViewpointOrder');
	
	$account_balance =
	    $User->where("id=".$_SESSION['user_id'])->getField("amount");
	
	$unread_sms =
	    $Sms->where("user_id=".$_SESSION['user_id']." AND status = 2")
	    ->count();
	
	$rounte_orders =
	    $RounteOrder->where("user_id=".$_SESSION['user_id']." AND status = 0")
	    ->count();
	
	$hotel_orders =
	    $HotelOrder->where("user_id=".$_SESSION['user_id']." AND status=0")
	    ->count();
	
	$viewpoint_orders =
	    $ViewpointOrder->where("user_id=".$_SESSION['user_id']." AND status=0")
	    ->count();
        
        
        //订单数量     3.6 hebin 更新
        $line_list['order_num'] = $RounteOrder->where("user_id='{$_SESSION['user_id']}'")->count();
        
        $this->assign("line_list",$line_list);
	$this->assign('user_name',$_SESSION['user_name']);
	$this->assign("unread_sms", $unread_sms);
	$this->assign("rounte_orders", $rounte_orders);
	$this->assign("hotel_orders", $hotel_orders);
	$this->assign("viewpoint_orders", $viewpoint_orders);
	
        $this->display("user_center");
    }

}















