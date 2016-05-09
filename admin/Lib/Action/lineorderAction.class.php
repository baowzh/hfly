<?php
class lineorderAction extends CommonAction {
	public function show_list() {
		$where = array ();
		if (! empty ( $_GET ['name'] )) {
			$where ["name"] = array (
					"like",
					"%{$_GET['name']}%" 
			);
		}
		if (! empty ( $_GET ['lcode'] )) {
			$where ["lcode"] = array (
					"eq",
					"{$_GET['lcode']}" 
			);
		}
		if (! empty ( $_GET ['phone'] )) {
			$where ["phone"] = array (
					"like",
					"%{$_GET['phone']}%" 
			);
		}
		if (! empty ( $_GET ['orderid'] )) {
			$where ["orderid"] = array (
					"eq",
					"{$_GET['orderid']}" 
			);
		}
		if (! empty ( $_GET ['strorderdate'] )) {
			$where ["startdate"] = array (
					"elt",
					"{$_GET['strorderdate']}" 
			);
		}
		if (! empty ( $_GET ['endorderdate'] )) {
			$where ["startdate"] = array (
					"egt",
					"{$_GET['endorderdate']}" 
			);
		}
		if ( $_GET ['state'] !='99' and $_GET ['state']!='') {
			$where ["jee_line_order.state"] = array (
					"eq",
					"{$_GET ['state']}" 
			);
		}
		if (! empty ( $_GET ['city'] )) {
			$where ["line.linebelongto"] = array (
					"eq",
					"{$_GET['city']}" 
			);
		}
		if (! empty ( $_GET ['line_type'] )) {
			$where ["line.line_type"] = array (
					"eq",
					"{$_GET['line_type']}" 
			);
		}
		$Line = M ( 'Line' );
		$lineOrder = M ( 'lineOrder' );
		$count = $lineOrder->join ( $Line->getTableName () . ' line on line.id=' . $lineOrder->getTableName () . '.lid' )->field ( $lineOrder->getTableName () . '.*,line.names' )->where ( $where )->count ();
		$page = $this->pagebar ( $count );
		$list = $lineOrder->join ( $Line->getTableName () . ' line on line.id=' . $lineOrder->getTableName () . '.lid' )->field ( $lineOrder->getTableName () . '.*,line.id as line_id,line.names,line.line_type,CASE WHEN UNIX_TIMESTAMP()-UNIX_TIMESTAMP(date_add(startdate, interval jee_line_order.trip_days day))>0 and state=0 THEN 1 ELSE 0 end as del' )->where ( $where )->order ( "id desc" )->page ( $page )->select ();
		if($_GET ['state']=='' or $_GET ['state']==null){
			$_GET ['state']='99';
		}
		$this->assign ( "list", $list );
		$this->assign ( "type", $_GET ['type'] );
		$this->assign ( "get", $_GET );
		$this->display ();
	}
	public function select_win() {
		$orderid = $_GET ['orderid'];
		$lineOrder = M ( 'lineOrder' );
		$order_table = $lineOrder->getTableName () . " ordertab";
		$line_table = M ( 'line' )->getTableName () . " line";
		$list = $lineOrder->table ( $order_table )->field ( "ordertab.*,pnumber+cnumber as number,line.names,line.code,line.line_type,round(dfcz/dfc,0) as dfcnum " )->join ( "$line_table on line.id=ordertab.lid" )->where ( "ordertab.orderid='$orderid'" )->find ();
		$this->assign ( "list", $list );
		$jsonOrder = json_encode ( $list );
		$this->assign ( "jsonOrder", $jsonOrder );
		$this->display ();
	}
	public function edit_win() {
		if (! $_POST) {
			$id = $_GET ['id'];
			$lineOrder = M ( 'lineOrder' );
			$user_table = M ( 'user' )->getTableName () . " user";
			$order_table = $lineOrder->getTableName () . " line_pin";
			$line_table = M ( 'line' )->getTableName () . " line";
			$order_userinfo = M ( 'order_userinfo' );
			$list = $lineOrder->table ( $order_table )->field ( "*,line_pin.status o_status,line_pin.id o_id,line_pin.front_money o_front_money,line_pin.amount o_amount" )->
			// ->join("$user_table on user.id=line_pin.user_id")
			join ( "$line_table on line.id=line_pin.line_id" )->where ( "line_pin.id='$id'" )->find ();
			if (! in_array ( $list ['o_status'], array (
					'1',
					'2' 
			) )) {
				$this->error ( "订单状态不可编辑!" );
			}
			$order_userinfo = M ( 'order_userinfo' );
			$order_userinfolist = $order_userinfo->where ( "order_id='$id' and type='LINE'" )->select ();
			$list ['total_money'] = $list ['o_amount'];
			$this->assign ( "list", $list );
			$this->assign ( "order_userinfolist", $order_userinfolist );
			$this->display ();
		} else {
			$id = $_POST ['id'];
			$price = $_POST ['price'];
			$reject = $_POST ['reject'];
			$lineOrder = M ( 'lineOrder' );
			if ($reject != null && $reject == 'on') {
				// 修改订单状态为已退款同时调用支付宝接口进行退款
				$lineOrder->where ( "id=$id" )->setField ( "state", "3" );
				$lineOrder->where ( "id=$id" )->setField ( "rejectamount", $_POST ['rejectamount'] );
				$lineOrder->where ( "id=$id" )->setField ( "rejectreason", $_POST ['rejectreason'] );
				$this->success ( "编辑成功！", U ( 'show_list' ) );
			} else {
				if ($price == '' or $price == 0) {
					$this->error ( "费用总计不能0!" );
				}
				$remoney = $_POST ['remoney'];
				if ($remoney == '' or $remoney == 0) {
					$this->error ( "预付订金总额0!" );
				}
				// $eczfz=$_POST ['eczfz'];
				// if($eczfz=='' or $eczfz==0){
				// $this->error ( "到达支付总额0!" );
				// }
				
				if ($data = $lineOrder->create ()) {
					//print_r($data);
					// exit();
					$lineOrder->where ( "id='$id'" )->save ();
					$this->success ( "编辑成功！", U ( 'show_list' ) );
					// 如果是退款则调用支付宝接口进行退款reject
				} else {
					$this->error ( "编辑失败！" );
				}
			}
		}
	}
	
	// 处理状态
	public function set_status() {
		$id = $_GET ['id'];
		$lineOrder = M ( 'lineOrder' );
		$orderinfo = $lineOrder->where ( "id='$id'" )->find ();
		if ($orderinfo ['state'] == 1) { // 已经支付的订单则改为发团
			$orderinfo = $lineOrder->where ( "id='$id'" )->setField ( 'state', '4' );
			$this->success ( "订单处理成功！" );
		}
	}
	public function delorder() {
		$orderid = $_GET ['delorderid'];
		$lineOrder = M ( 'lineOrder' );
		$orderinfo = $lineOrder->field ( "*,CASE WHEN UNIX_TIMESTAMP()-UNIX_TIMESTAMP(date_add(startdate, interval trip_days day))>0 and state=0 THEN 1 ELSE 0 end as del" )->where ( "orderid='".$orderid."'" )->find ();
		if ($orderinfo ['state'] == '0') { // 已经支付的订单则改为发团
			$orderinfo = $lineOrder->where ( "orderid='$orderid'" )->delete ();
			$this->success ( "删除成功！" );
		} else {
			$this->error ( "已支付过的订单不能删除！" );
		}
	}
}

?>