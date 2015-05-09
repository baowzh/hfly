<?php

class HotelOrderModel extends Model {

	private $HotelRoomType_MODEL;

	public function __construct() {
		parent::__construct();
		$this->HotelRoomType_MODEL = M("HotelRoomType");
	}

	/**
	 * 查询某一天，某一种房型的是否还有空房<br/>
	 * @param int $date 日期的时间戳（仅精确到天）<br/>
	 * @param int $room_id 房型的ID<br/>
	 * @return int 指定的某天的房间数<br/><br/>
	 */
	public function getRoomCountOfOneDay($date, $room_id) {
		//合计在指定日期仍被占用的间房的数量
		$order_count = $this->where("room_id=$room_id AND leave_date>=$date AND status<>5 AND status<>6")->sum("room_count");
		//合计正好在指定日期退房的房间数量
		$expire_count = $this->where("room_id=$room_id AND leave_date=$date")->sum("room_count");
		//查询某个房型的信息
		$room = $this->HotelRoomType_MODEL->where("id=$room_id")->find();

		$emptyroom = intval($room["room_count"] - $order_count + $expire_count);
		return $emptyroom;
	}

	/**
	 * 从支付平台的银行列表中获得某一银行的信息
	 * @param int $bank_mark 银行编号
	 * @return array 银行的信息
	 */
	public function payment_get_A_bank($bank_mark) {
		$bank = M()->table(M("PaymentApi")->getTableName() . " payment")
				 ->join(M("PaymentBank")->getTableName() . " bank ON payment.api_id = bank.api_id")
				 ->where("bank.mark = $bank_mark")
				 ->field("payment.names as payment_name, bank.names as bank_name, bank.pic as pic")
				 ->find();
		return $bank;
	}

}
