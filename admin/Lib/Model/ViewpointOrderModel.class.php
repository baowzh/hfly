<?php

class ViewpointOrderModel extends Model {

	/**
	 * 获取用户订购的景点门票
	 * @access public
	 *
	 * @param int $status 订单状态
	 * @param string $page_param  是一个字符串，格式如："当前页,每页记录数"
	 *
	 * @return Object 返回查询到的订单数据对象
	 */
	public function get_orders($page_param = NULL, $status = NULL) {
		$Order = M('ViewpointOrder');

		if (!empty($status)) {
			$where = "view_order.status=$status";
		}
		$orders = $Order->table(C('DB_PREFIX') . "viewpoint_order AS view_order")
				 ->join(C('DB_PREFIX') . "viewpoint_orderticket AS odticket ON odticket.order_id=view_order.id")
				 ->join(C('DB_PREFIX') . "viewpoint_ticket AS ticket ON ticket.id=odticket.ticket_id")
				 ->join(C('DB_PREFIX') . "viewpoint viewpoint ON viewpoint.id=ticket.viewpoint_id")
				 ->join(C('DB_PREFIX') . "user user ON view_order.user_id=user.id")
				 ->join(C('DB_PREFIX') . "status_type status_type ON view_order.status=status_type.id")
				 ->where($where)
				 ->order('view_order.status_change_time asc')
				 ->page($page_param)
				 ->field("*, view_order.create_time, view_order.status as order_status, view_order.id, SUM(ticket.award_price) as award_price")
				 ->group("view_order.id")
				 ->select();
		return $orders;
	}


	public function get_order($order_id) {
		$Order = M('ViewpointOrder');
		$orders = $Order->table(C('DB_PREFIX') . "viewpoint_order AS view_order")
				 ->join(C('DB_PREFIX') . "viewpoint_orderticket AS odticket ON odticket.order_id=view_order.id")
				 ->join(C('DB_PREFIX') . "viewpoint_ticket AS ticket ON ticket.id=odticket.ticket_id")
				 ->join(C('DB_PREFIX') . "viewpoint viewpoint ON viewpoint.id=ticket.viewpoint_id")
				 ->join(C('DB_PREFIX') . "user user ON view_order.user_id=user.id")
				 ->join(C('DB_PREFIX') . "status_type status_type ON view_order.status=status_type.id")
				 ->where("view_order.id = $order_id")
				 ->order('view_order.status_change_time asc')
				 ->field("*, view_order.create_time, view_order.status as order_status, view_order.id, SUM(ticket.award_price) as award_price")
				 ->group("view_order.id")
				 ->find();
		return $orders;
	}
	
	/**
	 * 根据id获取用户订购的景点门票详情
	 * @access public
	 *
	 * @param int $id 订单id
	 *
	 * @return Object 返回查询到的订单数据对象
	 */
	public function get_order_by_id($order_id) {
		$Order = M('ViewpointOrder');

		$where = "view_order.id=$order_id";

		$order = $Order->table(C('DB_PREFIX') . "viewpoint_order AS view_order")
				 ->join(C('DB_PREFIX') . "viewpoint_orderticket AS odticket ON odticket.order_id=view_order.id")
				 ->join(C('DB_PREFIX') . "viewpoint_ticket AS ticket ON ticket.id=odticket.ticket_id")
				 ->join(C('DB_PREFIX') . "viewpoint viewpoint ON viewpoint.id=ticket.viewpoint_id")
				 ->join(C('DB_PREFIX') . "user user ON view_order.user_id=user.id")
				 //->join(C('DB_PREFIX')."ticket_type type ON ticket.ticket_type=type.id")
				 ->join(C('DB_PREFIX') . "status_type status_type ON view_order.status=status_type.id")
				 ->join(C('DB_PREFIX') . "ticket_contactor contactor ON view_order.contactor_id=contactor.id")
				 //->join(C('DB_PREFIX') . "ticket_collector collector ON view_order.collector_id=collector.id")
				 ->join(C('DB_PREFIX') . "cash_coupon coupon ON view_order.coupon_num=coupon.serial_num")
				 ->where($where)
				 ->field("*, view_order.create_time, status_type.status_name as status_name, view_order.status as order_status, "
						  . "view_order.id, viewpoint.id as viewpoint_id, ticket.names as type_name, contactor.contact_name as contactor_name, "
						  . "contactor.contact_phone as contactor_phone,contactor.contact_email as contactor_email, "
						  . "view_order.serial_num as serial_num, ticket.award_price as award_money")
				 ->group("ticket.id")
				 ->select();
		$usinfo = array();
		$award_money = 0;
		foreach ($order as $key => $i) {
			$award_money += $i["award_money"];
			$usinfo = array_merge($usinfo, $i);
			$usinfo["tickets"][$key] = array("ticket_type" => $i["type_name"], "ticket_count" => $i["ticket_count"]);
		}
		unset($usinfo["ticket_type"]);
		$usinfo["award_money"] = $award_money;
		return $usinfo;
	}

	/**
	 * 获取用户订购的景点门票数量
	 * @access public
	 *
	 * @param int $status 订单状态
	 *
	 * @return int 返回查询到的符合要求的订单数
	 */
	public function count($status = NULL) {
		$Order = M('ViewpointOrder');
		if (!empty($status)) {
			$orders = $Order->where("status=$status")
					 ->count();
		} 
		return $orders;
	}

	public function get_order_untreatedDATA($order_num) {
		$data = M()->table($this->getTableName() . " ord")
				 ->join(M("ViewpointOrderticket")->getTableName() . " odtik ON odtik.order_id = ord.id")
				 ->join(M("ViewpointTicket")->getTableName() . " tik ON odtik.ticket_id = tik.id")
				 ->join(M("Viewpoint")->getTableName() . " view ON view.id = tik.viewpoint_id")
				 ->join("RIGHT JOIN " . M("TicketContactor")->getTableName() . " cont ON ord.contactor_id = cont.id")
				 ->where("ord.serial_num='$order_num'")
				 ->field("ord.id, view.id as view_id, ord.serial_num, view.names as view_name, ord.ticket_num, cont.contact_name, "
						  . "cont.contact_phone, odtik.ticket_count, ord.all_money, ord.must_pay, ord.use_award, ord.coupon_num, "
						  . "tik.names as ticket_type")
				 ->group("tik.names")
				 ->select();
		$usinfo = array();
		foreach ($data as $key => $i) {
			$usinfo = array_merge($usinfo, $i);
			$usinfo["tickets"][$key] = array("ticket_type" => $i["ticket_type"], "ticket_count" => $i["ticket_count"]);
		}
		unset($usinfo["ticket_type"]);
		return $usinfo;
	}

	public function get_order_treatedDATA($order_id) {
		$data = M()->table($this->getTableName() . " ord")
				 ->join(M("CashCoupon")->getTableName() . " cash ON cash.serial_num = ord.serial_num")
				 ->join(M("ViewpointOrderticket")->getTableName() . " odtik ON odtik.order_id = ord.id")
				 ->join(M("ViewpointTicket")->getTableName() . " tik ON odtik.ticket_id = tik.id")
				 ->join(M("Viewpoint")->getTableName() . " view ON view.id = tik.viewpoint_id")
				 ->join("RIGHT JOIN " . M("TicketContactor")->getTableName() . " cont ON ord.contactor_id = cont.id")
				 ->where("ord.id=$order_id")
				 ->field("ord.id, view.id as view_id, ord.serial_num, view.names as view_name, ord.ticket_num, cont.contact_name, "
						  . "cont.contact_phone, odtik.ticket_count, ord.all_money, ord.must_pay, ord.use_award, ord.coupon_num, "
						  . "tik.names as ticket_type, ord.status, tik.earnest")
				 ->group("tik.names")
				 ->select();
		$usinfo = array();
		foreach ($data as $key => $i) {
			$usinfo = array_merge($usinfo, $i);
			$usinfo["tickets"][$key] = array("ticket_type" => $i["ticket_type"], "ticket_count" => $i["ticket_count"]);
		}
		unset($usinfo["ticket_type"]);
		return $usinfo;
	}

}
