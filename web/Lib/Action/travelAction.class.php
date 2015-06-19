<?php
require_once ("alipay/alipay.config.php");
require_once ("alipay/lib/alipay_submit.class.php");
require_once ("alipay/lib/alipay_notify.class.php");
require_once ("Core/Common/functions.php");
class travelAction extends CommonAction {
	private $type_select;
	private $topic = array (
			1 => "古镇游",
			2 => "山水游",
			3 => "海岛游",
			4 => "乐园游" 
	);
	protected $max_p = 3000;
	public function _initialize() {
		$authentic = array (
				"order",
				"order_success" 
		);
		in_array ( ACTION_NAME, $authentic ) ? $this->authentic = 1 : $this->authentic = 0;
		parent::_initialize ();
		$this->type_select = $_GET ["type"] ? intval ( $_GET ["type"] ) : - 1;
		$this->assign ( "current", $this->type_select );
	}
	public function index() {
		$areaid = ($_GET ['areaid']);
		$id = isset ( $_GET ['id'] ) ? intval ( $_GET ['id'] ) : 0; // 获取分页页码
		$day = $_GET ['day']; // ? intval($_GET['day']) : 1; //获取分页页码
		$this->assign ( 'id', $id );
		$View = M ( "Line" );
		$where = 'status=0';
		if ($id > 0)
			$where .= " and line_type='$id' ";
		if ($day != null && $day > 0) {
			$this->assign ( 'day', $day );
			if ($day > 0)
				$where .= " and trip_days='$day' ";
		}
		if (day == 0) {
			$this->assign ( 'day', $day );
		}
		if ($areaid != null && $areaid != '') {
			$where .= " and linebelongto='$areaid' ";
		}
		$count = $View->where ( $where )->count ();
		$p = isset ( $_GET ['p'] ) ? intval ( $_GET ['p'] ) : 1; // 获取分页页码
		class_exists ( "Page" ) or import ( "ORG.Util.Page" );
		$Page = new Page ( $count, 9 );
		$show = $Page->show ();
		$list = $View->where ( $where )->order ( 'sort,id desc' )->limit ( $Page->firstRow . "," . $Page->listRows )->select ();
		$this->assign ( 'list', $list );
		$this->assign ( "page", $show );
		$this->assign ( "id", $id );
		$this->assign ( "areaid", $areaid );
		$this->display ();
	}
	public function init_function() {
		function url_params($params) {
			$url_params = array ();
			foreach ( $params as $k => $v ) {
				$url_params [] = urlencode ( $k ) . "=" . urlencode ( $v );
			}
			return join ( "&", $url_params );
		}
		function get_special_info($lineid = "0") {
			static $line_info = null;
			if ($line_info === null)
				$line_info = M ( "line_info" );
			$content = $line_info->where ( "lid=$lineid" )->getField ( "special_info" );
			return preg_replace ( "/\<.*?\>/", "", $content );
		}
		function get_titlepage($lineid = "0", $type = "pic_small") {
			static $line_pic = null;
			if ($line_pic === null)
				$line_pic = M ( "line_pic" );
			$pic_path = $line_pic->where ( "line_id=$lineid" )->order ( "istitlepage" )->getField ( $type );
			return $pic_path;
		}
		function get_tuan($lineid = "0") {
			static $line_price = null;
			if ($line_price === null)
				$line_price = M ( "line_price" );
			
			if ($line_price->where ( "line_id=$lineid and price_type=4" )->count ())
				return "天天发团";
			
			$week = $line_price->where ( "line_id=$lineid and price_type=3" )->order ( "price_date" )->getField ( "id,price_date" );
			if (count ( $week ) == 7)
				return "天天发团";
			
			$stage = $line_price->where ( "line_id=$lineid and price_type=2 and from_unixtime(price_date_end,'%Y%m%d')>= from_unixtime(UNIX_TIMESTAMP(),'%Y%m%d')" )->field ( "id,price_date,price_date_end" )->select ();
			$day = $line_price->where ( "line_id=$lineid and price_type=1 and from_unixtime(price_date,'%Y%m%d')>= from_unixtime(UNIX_TIMESTAMP(),'%Y%m%d')" )->getField ( "id,price_date" );
			$i = 1;
			foreach ( $day as $d ) {
				if ($i = 5)
					break;
				$str .= date ( "Y-m-d,", $d );
				$i ++;
			}
			foreach ( $stage as $sd ) {
				if ($i = 5)
					break;
				$str .= date ( "Y-m-d至", $sd ["price_date"] ) . date ( "Y-m-d,", $sd ["price_date_end"] );
				$i ++;
			}
			$wed = array (
					"1" => "二",
					"1" => "三",
					"1" => "四",
					"1" => "五",
					"1" => "六",
					"1" => "日" 
			);
			foreach ( $week as $wd ) {
				if ($i = 5)
					break;
				$str .= "每周" . $wed [$wd] . ",";
				$i ++;
			}
			$str = rtrim ( $str, "," ) . "等";
			return $str;
		}
	}
	public function order_ding() {
		/*
		 * layout ( false ); // 临时关闭当前模板的布局功能
		 * $id = $_GET ["id"] ? intval ( $_GET ["id"] ) : 0;
		 * $LineTao = M ( "LineTao" );
		 * $tao = $LineTao->find ( $id );
		 * $this->assign ( "tao", $tao ); // 基本信息
		 */
		$lineid = $_GET ['id'];
		$year = $_GET ['year'];
		$month = $_GET ['month'];
		$day = $_GET ['day'];
		$index = $_GET ['index'];
		$numrange = $_GET ['numrange'];
		$price_type = 1;
		$line = M ( "line" );
		$line_base = $line->find ( $lineid );
		$this->assign ( "line_base", $line_base ); // 基本信息
		                                           // 获取 价钱设置
		                                           // 取 2-3人 4-6人7-9人10-12人 13人以上设置
		$line_price = M ( "LinePrice" );
		$price_day_tmp1 = null;
		$price_day_tmp2 = null;
		$price_day_tmp3 = null;
		$price_day_tmp4 = null;
		$price_day_tmp5 = null;
		$price_day = null;
		if ($line_base ['line_type'] != 3 && $line_base ['line_type'] != 5) {
			if ($numrange == 0) {
				$numrange = 6;
			}
			$price_day = $line_price->where ( "price_type=1 and line_id=$lineid and numrange=" . $numrange . " and year=" . $year . " and month=" . $month . " and day=" . $day )->find ();
			$price_day_tmp0 = $line_price->where ( "price_type=1 and line_id=$lineid and numrange=6" )->select ();
			$price_day_tmp1 = $line_price->where ( "price_type=1 and line_id=$lineid and numrange=1" )->select ();
			$price_day_tmp2 = $line_price->where ( "price_type=1 and line_id=$lineid and numrange=2" )->select ();
			$price_day_tmp3 = $line_price->where ( "price_type=1 and line_id=$lineid and numrange=3" )->select ();
			$price_day_tmp4 = $line_price->where ( "price_type=1 and line_id=$lineid and numrange=4" )->select ();
			$price_day_tmp5 = $line_price->where ( "price_type=1 and line_id=$lineid and numrange=5" )->select ();
		} else {
			$price_type = 2;
			$price_day = $line_price->where ( "price_type=2 and line_id=$lineid and numrange=" . $numrange . " and year=" . $year . " and month=" . $month . " and day=" . $day )->find ();
			$price_day_tmp0 = $line_price->where ( "price_type=2 and line_id=$lineid and numrange=0" )->select ();
			$price_day_tmp1 = $line_price->where ( "price_type=2 and line_id=$lineid and numrange=0" )->select ();
			$price_day_tmp2 = $line_price->where ( "price_type=2 and line_id=$lineid and numrange=0" )->select ();
			$price_day_tmp3 = $line_price->where ( "price_type=2 and line_id=$lineid and numrange=0" )->select ();
			$price_day_tmp4 = $line_price->where ( "price_type=2 and line_id=$lineid and numrange=0" )->select ();
			$price_day_tmp5 = $line_price->where ( "price_type=2 and line_id=$lineid and numrange=0" )->select ();
		}
		$travel_price_list = array (
				5 => $price_day_tmp5,
				4 => $price_day_tmp4,
				3 => $price_day_tmp3,
				2 => $price_day_tmp2,
				1 => $price_day_tmp1,
				0 => $price_day_tmp0 
		);
		$this->assign ( "line_type", $line_type ['line_type'] );
		$this->assign ( "travel_price_list", json_encode ( $travel_price_list ) );
		$price_day ['cryf'] = $price_day ['price_adultpre'];
		$price_day ['etyf'] = $price_day ['price_childrenpre'];
		$price_day ['ydzf'] = $price_day ['price_adultpre'];
		$price_day ['creczf'] = $price_day ['price_adultec'];
		$price_day ['eteczf'] = $price_day ['price_childrenec'];
		if ($price_day ['price_adultec'] != null) {
			$price_day ['ddhzf'] = $price_day ['price_adultec'];
		} else {
			$price_day ['ddhzf'] = $price_day ['price_adult'] - $price_day ['price_adultpre'];
		}
		$this->assign ( "price_day", $price_day );
		$this->assign ( "tripday", $year . '-' . $month . '-' . $day );
		$this->display ();
	}
	public function order_ding_act() {
		$LineOrder = D ( 'LineOrder' );
		if (empty ( $_POST ['name'] )) {
			$this->ajaxReturn ( "", "联系人不能为空", "n" );
			exit ();
		}
		if (empty ( $_POST ['phone'] )) {
			$this->ajaxReturn ( "", "手机号码不能为空", "n" );
			exit ();
		}
		if (empty ( $_POST ['phones'] )) {
			$this->ajaxReturn ( "", "备用手机号码不能为空", "n" );
			exit ();
		}
		if (empty ( $_POST ['email'] )) {
			$this->ajaxReturn ( "", "email不能为空", "n" );
			exit ();
		}
		if (empty ( $_POST ['desc'] )) {
			$this->ajaxReturn ( "", "备注说明不能为空", "n" );
			exit ();
		}
		if (empty ( $_POST ['ends'] )) {
			$this->ajaxReturn ( "", "请填写旅行日期", "n" );
			exit ();
		}
		if ($_POST ['pnumber'] == 0) {
			$this->ajaxReturn ( "", "请选择预定人数", "n" );
			exit ();
		}
		// if (empty ( $_POST ['roomnum'] )) {
		// $this->ajaxReturn ( "", "请填写房间数", "n" );
		// exit ();
		// }
		// 获取用户选择日期和人数规模从后台取得线路价钱
		$id = $_POST ['lid'];
		$ends = $_POST ['ends'];
		$year = substr ( $ends, 0, 4 );
		$month = substr ( $ends, 5, 2 );
		$day = substr ( $ends, 8, 2 );
		$pnumber = $_POST ['pnumber'];
		$cnumber = $_POST ['cnumber'];
		$roomnum = $_POST ['roomnum'];
		$numrange = 1;
		if ($pnumber == 1) {
			$numrange = 0;
		} else if ($pnumber >= 2 and $pnumber <= 3) {
			$numrange = 1;
		} else if ($pnumber >= 4 and $pnumber <= 6) {
			$numrange = 2;
		} else if ($pnumber >= 7 and $pnumber <= 9) {
			$numrange = 3;
		} else if ($pnumber >= 10 and $pnumber <= 12) {
			$numrange = 4;
		} else if ($pnumber >= 13) {
			$numrange = 5;
		}
		$line = M ( "line" );
		$line_base = $line->find ( $id );
		$price_type = 1;
		if ($line_base ['line_type'] != 3 && $line_base ['line_type'] != 5 && $line_base ['line_type'] != 2) {
			$price_type = 1;
			if ($numrange == 0) {
				$numrange = 6; // 获取单个人的价钱
			}
		} else {
			$price_type = 2;
			$numrange = 0;
		}
		$line_price = M ( "LinePrice" );
		$price_day = $line_price->where ( "price_type=" . $price_type . " and line_id=" . $id . " and numrange=" . $numrange . " and year=" . $year . " and month=" . $month . " and day=" . $day )->find ();
		if ($price_day == null) {
			$this->ajaxReturn ( "", "订单提交失败" . $year . '-' . $month . '-' . $day . '没有报价设置，请拨打热线电话咨询。', "n" );
		}
		// 计算单房差
		$dfcz = 0;
		if ($roomnum != null && $roomnum != '') {
			$totalnum = $pnumber * 1 + $cnumber * 1;
			// $ytfjs = $pnumber / 2;
			// if ($pnumber % 2 > 0) {
			// $ytfjs = $ytfjs - 0.5;
			// }
			$sjfjs = $roomnum * 1;
			if ($sjfjs * 2 - $pnumber > 0) {
				$dfcz = $price_day ['dfc'] * ($sjfjs * 2 - $pnumber);
			} else {
				$dfcz = 0;
			}
		}
		//
		$price = $price_day ['price_adult'] * $pnumber + $price_day ['price_children'] * $cnumber + $dfcz;
		$remoney = $price_day ['price_adultpre'] * $pnumber + $price_day ['price_childrenpre'] * $cnumber + $dfcz;
		$pmoney = $price_day ['price_adult'];
		$premoney = $price_day ['price_adultpre'];
		$cmoney = $price_day ['price_children'];
		$cremoney = $price_day ['price_childrenpre'];
		$lcode = $line_base ['code'];
		$startdate = $ends;
		// $_POST ['phones']
		$phone = $_POST ['phone'];
		// 从系统中查找是否有phones 数据
		$orderlist = $LineOrder->where ( "phone='" . $phone . "'" )->select ();
		$orderid = $phone . "-" . "001";
		if (count ( $orderlist ) != 0) {
			$ordercount = count ( $orderlist );
			$ordercount = $ordercount * 1 + 1;
			$neworderid = "" . $ordercount . "";
			$strlength = strlen ( $neworderid );
			$zero = '';
			for($i = $strlength; $i < 3; $i ++) {
				$neworderid = "0" . $neworderid . "";
			}
			$orderid = $phone . "-" . $neworderid;
		} else {
			$orderid = $phone . "-" . "001";
		}
		$_POST ['status'] = 0;
		$_POST ['orderid'] = $orderid;
		// $_POST ['orderid'] = time () . rand ( 1000, 9999 );
		$_POST ['type'] = 1;
		$order = D ( 'order' );
		if ($LineOrder->create ()) {
			$time = time ();
			$currentdate = date ( "y-m-d", $time );
			$LineOrder->orderdate = $currentdate;
			$LineOrder->startdate = $_POST ['ends'];
			$LineOrder->price = $price;
			$LineOrder->remoney = $remoney;
			$LineOrder->pmoney = $pmoney;
			$LineOrder->premoney = $premoney;
			$LineOrder->cmoney = $cmoney;
			$LineOrder->cremoney = $cremoney;
			$LineOrder->lcode = $lcode;
			$LineOrder->startdate = $startdate;
			$LineOrder->dfc = $price_day ['dfc'];
			$LineOrder->dfcz = $dfcz;
			$LineOrder->pmoneyec = $price_day ['price_adultec'];
			$LineOrder->pmoneyyk = $price_day ['price_adultyk'];
			$LineOrder->cmoneyec = $price_day ['price_childrenec'];
			$LineOrder->cmoneyyk = $price_day ['price_childrenyk'];
			$LineOrder->trip_days = $line_base ['trip_days'];
			$LineOrder->orderid = $orderid;
			$pmoneyec = 0;
			if ($LineOrder->pmoneyec != 0) {
				$pmoneyec = $LineOrder->pmoneyec;
			}
			$cmoneyec = 0;
			if ($LineOrder->cmoneyec != 0) {
				$cmoneyec = $LineOrder->cmoneyec;
			}
			$LineOrder->eczfz = $pmoneyec * $pnumber + $cmoneyec * $cnumber;
			$pyk = 0;
			if ($LineOrder->pmoneyyk != 0) {
				$pyk = $LineOrder->pmoneyyk;
			}
			$cyk = 0;
			if ($LineOrder->cmoneyyk != 0) {
				$cyk = $LineOrder->cmoneyyk;
			}
			$LineOrder->ykz = $pyk * $pnumber + $cyk * $cnumber;
			$LineOrder->add ();
			$insert_id = $LineOrder->getLastInsID ();
			// 邮件发送
			$OrderData = $LineOrder->field ( "*,date_add(startdate, interval trip_days-1 day) as enddate" )->find ( $insert_id );
			$this->assign ( "protocolData", $OrderData );
			$protocolcontent = $this->fetch ( "protocol", "", "" );
			$messContent = "亲 您的订单" . $OrderData ['orderid'] . "已提交成功,合同已发送至您的邮箱,如有变动请联系客服4001888332,用手机号可在官网www.hf97667.com查询订单详情";
			$this->sendEmail ( $OrderData ['email'], $OrderData ['name'], "团队境内旅游合同", $protocolcontent );
			$messDate = array (
					'action' => 'send',
					'username' => '70208213',
					'password' => md5 ( 'hf6317995' ),
					'phone' => $OrderData ['phone'],
					'content' => urlencode ( $messContent ) 
			);
			// 短信发送
			$this->curl_post ( "http://api.duanxin.cm/", $messDate, true );
			$this->ajaxReturn ( U ( 'order_ding_view', array (
					"orderid" => $OrderData ['orderid'] 
			) ), "订单详情", "u" );
		} else {
			$this->ajaxReturn ( "", "订单提交失败", "n" );
		}
	}
	public function order_ping() {
		layout ( false ); // 临时关闭当前模板的布局功能
		$id = $_GET ["id"] ? intval ( $_GET ["id"] ) : 0;
		$line = M ( "line" );
		$line_base = $line->find ( $id );
		$this->assign ( "line_base", $line_base ); // 基本信息
		$this->display ();
	}
	public function order_ping_act() {
		$LinePin = D ( 'LinePin' );
		$Order = D ( 'Order' );
		$_POST ['num'] = intval ( $_POST ['people'] ) + intval ( $_POST ['woman'] ) + intval ( $_POST ['chd'] );
		
		if (empty ( $_POST ['tuan_name'] )) {
			$this->ajaxReturn ( "", "团名不能为空", "n" );
			exit ();
		}
		if (empty ( $_POST ['name'] )) {
			$this->ajaxReturn ( "", "联系人不能为空", "n" );
			exit ();
		}
		if (empty ( $_POST ['phone'] )) {
			$this->ajaxReturn ( "", "手机号码不能为空", "n" );
			exit ();
		}
		if (empty ( $_POST ['email'] )) {
			$this->ajaxReturn ( "", "email不能为空", "n" );
			exit ();
		}
		if (empty ( $_POST ['desc'] )) {
			$this->ajaxReturn ( "", "备注说明不能为空", "n" );
			exit ();
		}
		if (empty ( $_POST ['strat'] )) {
			// $this->ajaxReturn("", "报名截止日期不能为空", "n");
			// exit();
		}
		if (empty ( $_POST ['ends'] )) {
			$this->ajaxReturn ( "", "旅行开始日期不能为空", "n" );
			exit ();
		}
		if ($_POST ['num'] == 0) {
			$this->ajaxReturn ( "", "请选择人数", "n" );
			exit ();
		}
		if ($_POST ['num'] > intval ( $_POST ['mins'] )) {
			$this->ajaxReturn ( "", "目标人数不能小于已有人数", "n" );
			exit ();
		}
		if ($_POST ['mins'] > intval ( $_POST ['maxs'] )) {
			$this->ajaxReturn ( "", "目标人数不能大于最多接受人数", "n" );
			exit ();
		}
		$_POST ['price'] = $_POST ['num'] * $_POST ['cmoney'];
		$_POST ['status'] = 0;
		$_POST ['orderid'] = time () . rand ( 1000, 9999 );
		$_POST ['type'] = 0;
		if ($LinePin->create ()) {
			$LinePin->orderdate = time ();
			$LinePin->add ();
			$Order->orderid = $LinePin->orderid;
			$Order->addtime = $LinePin->orderdate;
			$Order->status = 0;
			$Order->add ();
			$insert_id = $LinePin->getLastInsID ();
			$this->ajaxReturn ( U ( 'order_ping_view', array (
					"id" => $insert_id 
			) ), "订单详情", "u" );
		} else {
			$this->ajaxReturn ( "", "订单提交失败", "n" );
		}
	}
	public function order_ping_view() {
		layout ( false ); // 临时关闭当前模板的布局功能
		
		$id = $_GET ["id"] ? intval ( $_GET ["id"] ) : 0;
		$line = M ( "LinePin" );
		$vo = $line->find ( $id );
		$this->assign ( "vo", $vo ); // 基本信息
		$this->display ();
	}
	public function order_ding_view() {
		layout ( false );
		$LineOrder = D ( 'LineOrder' );
		$orderid = $_GET ["orderid"];
		$vo = $LineOrder->where ( "orderid='" . $orderid . "'" )->find ();
		$lineid = $vo ['lid'];
		$Line = D ( 'Line' );
		$lineInfo = $Line->where ( "id='" . $lineid . "'" )->find ();
		$this->assign ( "vo", $vo ); // 基本信息
		$this->assign ( "lineInfo", $lineInfo );
		// print_r($lineInfo);
		// exit();
		$this->display ();
	}
	public function order_success() {
		$table_line_order = M ( 'line_order' )->getTableName () . " line_order";
		$table_line = M ( 'line' )->getTableName () . " line";
		$order_userinfo = M ( 'order_userinfo' );
		$order_id = $_GET ['order_id'];
		$list = M ()->table ( $table_line_order )->join ( "$table_line on line_order.line_id=line.id" )->field ( 'line_order.*,line.names' )->where ( "line_order.id='$order_id' AND line_order.user_id='{$_SESSION['user_id']}'" )->find ();
		$list ['pri_card'] = D ( 'cash_coupon' )->show_coupon ( $list ['used_card'] );
		$list ['num'] = count ( $order_userinfo->where ( "order_id='$order_id' and type='LINE'" )->select () );
		$list ['earnest'] = $list ['front_money'];
		
		if (empty ( $list )) {
			$this->error ( "页面出错！" );
		}
		$paymentapi = A ( "paymentapi" );
		$banks = $paymentapi->get_banks ( 'wangyin' );
		if ($list ['status'] == '1') {
			$this->assign ( "usinfo", $list );
			$this->display ( 'order_untreated' );
			exit ();
		} elseif ($list ['status'] == '2') {
			$this->assign ( "usinfo", $list );
			$this->assign ( "banks", $banks );
			$this->assign ( "amount", M ( 'user' )->where ( "id='{$_SESSION['user_id']}'" )->getfield ( 'amount' ) );
			$this->display ( 'order_processed' );
			exit ();
		} else {
			$this->error ( '订单错误!' );
		}
	}
	public function order_pay() {
		if (! $_POST ['orderid']) {
			$this->error ( "线路选择错误" );
		}
		$user = M ( 'user' );
		$order_id = $_POST ['orderid'];
		$orderinfo = D ( 'LineOrder' )->where ( "orderid='" . $order_id . "'" )->find ();
		$should_amount = $orderinfo ['remoney'];
		$name = $orderinfo ['name'];
		$phone = $orderinfo ['phone'];
		$this->assign ( "price", $should_amount );
		$this->assign ( "name", $name );
		$this->assign ( "phone", $phone );
		$this->assign ( "orderid", $order_id );
		$this->display ();
	}
	public function order_reject() { // 把订单状态改为已申请退款
		$orderid = $_POST ['reorderid'];
		$lineOrder = D ( 'LineOrder' );
		$orderinfo = $lineOrder->where ( "orderid='" . $orderid . "'" )->find ();
		if ($orderinfo ['state'] == 1) {
			$lineOrder->where ( "orderid='" . $orderid . "'" )->setField ( "state", "2" );
			$this->success ( "申请退款成功。", U ( "order_query", array (
					'phone' => $orderinfo ['phone'] 
			) ) );
		} else if ($orderinfo ['state'] == 0) {
			$this->error ( "此订单未支付，不能退款。" );
		} else if ($orderinfo ['state'] == 4) {
			$this->error ( "此订单已发团，不能退款。" );
		}
	}
	/**
	 * 调用支付宝后者网银钱包进行支付
	 */
	public function paymoney() {
		$pay_bank = $_POST ['pay_bank'];
		$orderid = $_POST ['orderid'];
		if ($pay_bank == 'directPay') { // 支付宝直接支付
			                                // 组织数据调用支付宝接口
		} else {
			// 组织数据调用网银钱包接口
		}
	}
	public function detail() {
		$id = $_GET ["id"] ? intval ( $_GET ["id"] ) : 0;
		$line = M ( "line" );
		$line_info = M ( "LineInfo" );
		$line_pic = M ( "LinePic" );
		$line_base = $line->find ( $id );
		$line_keep = M ( 'line_keep' );
		$keep = $line_keep->where ( "user_id='{$_SESSION['user_id']}' and line_id='$id'" )->count ();
		if ($line_base) {
			// 显示方式(1,按天，2,可视化)
			$view_result = array ();
			$view_method = $line_base ["edit_model"];
			
			// 获取按天显示方式的记录
			if ($view_method == 1) {
				$line_travel = M ( "LineTravel" );
				$line_travel_section = M ( "LineTravelSection" );
				$line_day = $line_travel->where ( "line_id=" . $line_base ["id"] )->order ( "day" )->select ();
				if ($line_day) {
					foreach ( $line_day as $day ) {
						$map = array (
								'line_id' => array (
										"eq",
										$line_base ["id"] 
								),
								'travel_id' => array (
										"eq",
										$day ["id"] 
								) 
						);
						$view_result [] = array (
								"day_info" => $day,
								"Section_info" => $line_travel_section->where ( $map )->order ( "names" )->select () 
						);
					}
				}
			}
			// 出发城市
			$belong = M ( "Area" );
			$start_city_belong = $belong->where ( "id=" . $line_base ["city_id"] )->find ();
			// 目的地城市
			$target_city_belong = $belong->table ( $belong->getTableName () . " be" )->join ( M ( "line_target" )->getTableName () . " tar on be.id=tar.area_id" )->where ( array (
					"tar.id" => array (
							"in",
							$line_base ["target"] 
					) 
			) )->getField ( "tar.id,names" );
			// 线路详细描述
			$lineinfo = $line_info->where ( "lid=" . $line_base ["id"] )->find ();
			// dump($lineinfo); exit();
			// 图片列表
			$linepic = $line_pic->where ( "line_id=" . $line_base ["id"] )->select ();
			
			// 基本价格
			// 线路价格列表
			$this->travel_price_list ( $id );
			// 线路问答
			$this->travel_que ( $id );
			
			// 拼团列表
			// $this->ping_list ( $id );
			
			// 拼团列表
			// $this->zutuan_list ( $id );
		}
		
		$this->assign ( "keep_status", $keep );
		$this->assign ( "line_base", $line_base ); // 基本信息
		                                           // print_r($line_base);
		                                           // exit();
		$this->assign ( "view_method", $view_method ); // 显示方式1按天，2可视化
		$this->assign ( "view_result", $view_result ); // 按天显示方式内容
		$this->assign ( "lineinfo", $lineinfo ); // 其它信息
		$this->assign ( "linepic", $linepic ); // 图片
		$this->assign ( "start_city_belong", $start_city_belong ); // 出发城市
		$this->assign ( "target_city_belong", $target_city_belong ); // 目的地城市
		$this->assign ( "price_pt", $price_pt ); // 普通价格
		$this->assign ( "price_date", $price_date_json ); // 按星期几价格
		$this->assign ( "price_stage", $price_stage_json ); // 指定阶段价格
		$this->assign ( "price_day_json", $price_day_json ); // 指定日期价格
		$this->assign ( "line_id", $id ); // 线路id
		                                  // dump($line_base);
		$this->init_function ();
		// 获取相关的6个线路放下面 同一个地区，统一天数的线路
		$city_id = $line_base ['linebelongto'];
		$trip_days = $line_base ['trip_days'];
		$relines = M ( 'line' )->where ( " linebelongto='" . $city_id . "' and trip_days=" . $trip_days )->limit ( 6 )->select ();
		$this->assign ( "relines", $relines ); // 相关旅游线路
		                                       // 获取实时订单信息
		$sysOrder = M ( 'SysOrder' );
		$orderlist = $sysOrder->order ( 'orderdate desc' )->limit ( 10 )->select ();
		$this->assign ( "orderlist", $orderlist );
		$this->display ();
	}
	protected function travel_price_list($id) {
		$line_price = M ( "LinePrice" );
		// 普通价格
		$price_pt = $line_price->where ( "price_type=4 and line_id=$id" )->field ( "RACKRATE,price_adult,price_children" )->find ();
		// 按星期价格
		$price_date_tmp = $line_price->where ( "price_type=3 and line_id=$id" )->select ();
		foreach ( $price_date_tmp as $tmp ) {
			$price_date [$tmp ["price_date"]] = array (
					"RACKRATE" => $tmp ["RACKRATE"],
					"price_adult" => $tmp ["price_adult"],
					"price_children" => $tmp ["price_adult"] 
			);
		}
		// 按阶段
		$price_stage_tmp = $line_price->where ( "price_type=2 and line_id=$id" )->select ();
		foreach ( $price_stage_tmp as $tmp ) {
			$key = date ( "Ymd", $tmp ["price_date"] ) . "_" . date ( "Ymd", $tmp ["price_date_end"] );
			$price_stage [$key] = array (
					"RACKRATE" => $tmp ["RACKRATE"],
					"price_adult" => $tmp ["price_adult"],
					"price_children" => $tmp ["price_adult"] 
			);
		}
		$line = M ( 'Line' );
		$line_type = $line->where ( "id=" . $id )->field ( "line_type" )->find ();
		$price_type = 1;
		$price_day_tmp1 = null;
		$price_day_tmp2 = null;
		$price_day_tmp3 = null;
		$price_day_tmp4 = null;
		$price_day_tmp5 = null;
		if ($line_type [line_type] != 3 && $line_type [line_type] != 5 && $line_type [line_type] != 2) {
			$price_day_tmp0 = $line_price->where ( "price_type=1 and line_id=$id and numrange=6" )->select ();
			$price_day_tmp1 = $line_price->where ( "price_type=1 and line_id=$id and numrange=1" )->select ();
			$price_day_tmp2 = $line_price->where ( "price_type=1 and line_id=$id and numrange=2" )->select ();
			$price_day_tmp3 = $line_price->where ( "price_type=1 and line_id=$id and numrange=3" )->select ();
			$price_day_tmp4 = $line_price->where ( "price_type=1 and line_id=$id and numrange=4" )->select ();
			$price_day_tmp5 = $line_price->where ( "price_type=1 and line_id=$id and numrange=5" )->select ();
		} else {
			$price_day_tmp0 = $line_price->where ( "price_type=2 and line_id=$id and numrange=0" )->select ();
			$price_day_tmp1 = $line_price->where ( "price_type=2 and line_id=$id and numrange=0" )->select ();
			$price_day_tmp2 = $line_price->where ( "price_type=2 and line_id=$id and numrange=0" )->select ();
			$price_day_tmp3 = $line_price->where ( "price_type=2 and line_id=$id and numrange=0" )->select ();
			$price_day_tmp4 = $line_price->where ( "price_type=2 and line_id=$id and numrange=0" )->select ();
			$price_day_tmp5 = $line_price->where ( "price_type=2 and line_id=$id and numrange=0" )->select ();
		}
		// 按指定日期
		foreach ( $price_day_tmp0 as $tmp ) {
			// $key = date ( "Ymd", $tmp ["price_date"] );
			$vmonth = $tmp ["month"];
			
			if (strlen ( $vmonth ) < 2) {
				$vmonth = '0' . $vmonth;
			}
			$iday = $tmp ["day"];
			if (strlen ( $iday ) < 2) {
				$iday = '0' . $iday;
			}
			$key = $tmp ["year"] . $vmonth . $iday;
			$price_day0 [$key] = array (
					"RACKRATE" => $tmp ["RACKRATE"],
					"price_adult" => $tmp ["price_adult"],
					"price_adultpre" => $tmp ["price_adultpre"],
					"price_adultec" => $tmp ["price_adultec"],
					"price_adultyk" => $tmp ["price_adultyk"],
					"price_children" => $tmp ["price_children"],
					"price_childrenec" => $tmp ["price_childrenec"],
					"price_childrenpre" => $tmp ["price_childrenpre"],
					"price_childrenyk" => $tmp ["price_childrenyk"],
					"dfc" => $tmp ["dfc"],
					"price_desc" => $tmp ["price_desc"] 
			);
		}
		
		foreach ( $price_day_tmp1 as $tmp ) {
			// $key = date ( "Ymd", $tmp ["price_date"] );
			$vmonth = $tmp ["month"];
			
			if (strlen ( $vmonth ) < 2) {
				$vmonth = '0' . $vmonth;
			}
			$iday = $tmp ["day"];
			if (strlen ( $iday ) < 2) {
				$iday = '0' . $iday;
			}
			$key = $tmp ["year"] . $vmonth . $iday;
			$price_day1 [$key] = array (
					"RACKRATE" => $tmp ["RACKRATE"],
					"price_adult" => $tmp ["price_adult"],
					"price_adultpre" => $tmp ["price_adultpre"],
					"price_adultec" => $tmp ["price_adultec"],
					"price_adultyk" => $tmp ["price_adultyk"],
					"price_children" => $tmp ["price_children"],
					"price_childrenec" => $tmp ["price_childrenec"],
					"price_childrenpre" => $tmp ["price_childrenpre"],
					"price_childrenyk" => $tmp ["price_childrenyk"],
					"dfc" => $tmp ["dfc"],
					"price_desc" => $tmp ["price_desc"] 
			);
		}
		foreach ( $price_day_tmp2 as $tmp ) {
			// $key = date ( "Ymd", $tmp ["price_date"] );
			$vmonth = $tmp ["month"];
			if (strlen ( $vmonth ) < 2) {
				$vmonth = '0' . $vmonth;
			}
			$iday = $tmp ["day"];
			if (strlen ( $iday ) < 2) {
				$iday = '0' . $iday;
			}
			$key = $tmp ["year"] . $vmonth . $iday;
			$price_day2 [$key] = array (
					"RACKRATE" => $tmp ["RACKRATE"],
					"price_adult" => $tmp ["price_adult"],
					"price_adultpre" => $tmp ["price_adultpre"],
					"price_adultec" => $tmp ["price_adultec"],
					"price_adultyk" => $tmp ["price_adultyk"],
					"price_children" => $tmp ["price_children"],
					"price_childrenec" => $tmp ["price_childrenec"],
					"price_childrenpre" => $tmp ["price_childrenpre"],
					"price_childrenyk" => $tmp ["price_childrenyk"],
					"dfc" => $tmp ["dfc"],
					"price_desc" => $tmp ["price_desc"] 
			);
		}
		foreach ( $price_day_tmp3 as $tmp ) {
			// $key = date ( "Ymd", $tmp ["price_date"] );
			$vmonth = $tmp ["month"];
			if (strlen ( $vmonth ) < 2) {
				$vmonth = '0' . $vmonth;
			}
			$iday = $tmp ["day"];
			if (strlen ( $iday ) < 2) {
				$iday = '0' . $iday;
			}
			$key = $tmp ["year"] . $vmonth . $iday;
			$price_day3 [$key] = array (
					"RACKRATE" => $tmp ["RACKRATE"],
					"price_adult" => $tmp ["price_adult"],
					"price_adultpre" => $tmp ["price_adultpre"],
					"price_adultec" => $tmp ["price_adultec"],
					"price_adultyk" => $tmp ["price_adultyk"],
					"price_children" => $tmp ["price_children"],
					"price_childrenec" => $tmp ["price_childrenec"],
					"price_childrenpre" => $tmp ["price_childrenpre"],
					"price_childrenyk" => $tmp ["price_childrenyk"],
					"dfc" => $tmp ["dfc"],
					"price_desc" => $tmp ["price_desc"] 
			);
		}
		foreach ( $price_day_tmp4 as $tmp ) {
			// $key = date ( "Ymd", $tmp ["price_date"] );
			$vmonth = $tmp ["month"];
			if (strlen ( $vmonth ) < 2) {
				$vmonth = '0' . $vmonth;
			}
			$iday = $tmp ["day"];
			if (strlen ( $iday ) < 2) {
				$iday = '0' . $iday;
			}
			$key = $tmp ["year"] . $vmonth . $iday;
			$price_day4 [$key] = array (
					"RACKRATE" => $tmp ["RACKRATE"],
					"price_adult" => $tmp ["price_adult"],
					"price_adultpre" => $tmp ["price_adultpre"],
					"price_adultec" => $tmp ["price_adultec"],
					"price_adultyk" => $tmp ["price_adultyk"],
					"price_children" => $tmp ["price_children"],
					"price_childrenec" => $tmp ["price_childrenec"],
					"price_childrenpre" => $tmp ["price_childrenpre"],
					"price_childrenyk" => $tmp ["price_childrenyk"],
					"dfc" => $tmp ["dfc"],
					"price_desc" => $tmp ["price_desc"] 
			);
		}
		foreach ( $price_day_tmp5 as $tmp ) {
			// $key = date ( "Ymd", $tmp ["price_date"] );
			$vmonth = $tmp ["month"];
			if (strlen ( $vmonth ) < 2) {
				$vmonth = '0' . $vmonth;
			}
			$iday = $tmp ["day"];
			if (strlen ( $iday ) < 2) {
				$iday = '0' . $iday;
			}
			$key = $tmp ["year"] . $vmonth . $iday;
			$price_day5 [$key] = array (
					"RACKRATE" => $tmp ["RACKRATE"],
					"price_adult" => $tmp ["price_adult"],
					"price_adultpre" => $tmp ["price_adultpre"],
					"price_adultec" => $tmp ["price_adultec"],
					"price_adultyk" => $tmp ["price_adultyk"],
					"price_children" => $tmp ["price_children"],
					"price_childrenec" => $tmp ["price_childrenec"],
					"price_childrenpre" => $tmp ["price_childrenpre"],
					"price_childrenyk" => $tmp ["price_childrenyk"],
					"dfc" => $tmp ["dfc"],
					"price_desc" => $tmp ["price_desc"] 
			);
		}
		$travel_price_list = array (
				4 => $price_pt,
				3 => $price_date,
				2 => $price_stage,
				1 => $price_day = array (
						5 => $price_day5,
						4 => $price_day4,
						3 => $price_day3,
						2 => $price_day2,
						1 => $price_day1,
						0 => $price_day0 
				) 
		);
		$this->assign ( "line_type", $line_type [line_type] );
		$this->assign ( "travel_price_list", json_encode ( $travel_price_list ) );
	}
	
	// 组团价格
	protected function zutuan_list($id) {
		$line_que = M ( "LineTao" );
		$lists = $line_que->where ( "line_id='$id' " )->order ( "id desc" )->select ();
		$this->assign ( "zutuan_list", $lists );
	}
	
	// 拼团价格
	protected function ping_list($id) {
		$line_que = M ( "LinePin" );
		$lists = $line_que->where ( "lid='$id' and state=1 and type=0" )->order ( "id desc" )->select ();
		$this->assign ( "ping_list", $lists );
	}
	protected function travel_que($id) {
		$line_que = M ( "line_que" );
		$lists = $line_que->where ( "line_id=$id" )->order ( "id desc" )->select ();
		$this->assign ( "lists_que", $lists );
		$this->assign ( "lists_quecount", count ( $lists ) );
	}
	public function consult() {
		// if (! isset ( $_SESSION ["user_id"] )) {
		// $this->ajaxReturn(array("info" => "请先登录", "status" => "n"));
		// exit;
		// }
		if (strlen ( trim ( $_POST ["question1"] ) ) < 5) {
			$this->ajaxReturn ( array (
					"info" => "至少输入5个字符-1",
					"status" => "n" 
			) );
			exit ();
		}
		$id = $this->_get ( "id" );
		$line_que = M ( "line_que" );
		$publish_time = time () - 300;
		$last_que_count = $line_que->where ( "line_id=$id and user_id={$_SESSION["user_id"]} and publish_time>$publish_time" )->count ();
		if ($last_que_count > 0) {
			$this->ajaxReturn ( array (
					"info" => "您的操作过于频繁-2",
					"status" => "n" 
			) );
			exit ();
		}
		$line = M ( "line" );
		$line_count = $line->where ( "id=$id and status=0" )->count ();
		if ($line_count == 0) {
			$this->ajaxReturn ( array (
					"info" => "您咨询的路线不存在或已经停用-3",
					"status" => "n" 
			) );
			exit ();
		}
		$data = array (
				"line_id" => $id,
				"user_id" => $_POST ["user_id"],
				"question1" => trim ( $_POST ["question1"] ),
				"publish_time" => time (),
				"status" => 1,
				"sort" => 0 
		);
		$line_que->add ( $data );
		$public = APP_TMPL_PATH . "Public";
		$publish_time = date ( "Y-m-d H:i:s", $data ["publish_time"] );
		$user_name = get_user ( $_SESSION ["user_id"] );
		$dom = <<<EOF
		           <div class="dialog_left">
                        <div class="toux"><img height="45" src="http://www.hf97667.com/style/images/niu.jpg" ></div>
                        <div class="dia_cont">{$data["question1"]}</div>
                        <div class="clear"></div>
                   </div>

EOF;
		$this->ajaxReturn ( array (
				"info" => $dom,
				"status" => "y" 
		) );
	}
	public function validform() {
		$param = $_POST ["param"];
		$name = $_POST ["name"];
		switch ($name) {
			case "verify" :
				if ($_SESSION ["verify"] == md5 ( $param )) {
					$ajaxreturn = array (
							"info" => "输入正确",
							"status" => "y" 
					);
				} else {
					$ajaxreturn = array (
							"info" => "输入错误",
							"status" => "n" 
					);
				}
				break;
		}
		$this->ajaxReturn ( $ajaxreturn );
	}
	
	/**
	 * 价格列表转换成json
	 *
	 * @param type $arr
	 *        	价格结果
	 * @param type $date_f
	 *        	是否格式化日期
	 * @return type
	 */
	private function json_price_list($arr, $date_f = false) {
		$json_arr = array ();
		if ($date_f) {
			foreach ( $arr as $k => $v ) {
				$json_arr [date ( "Y-m-d", $k )] = explode ( "|", $v );
			}
		} else {
			foreach ( $arr as $k => $v ) {
				$json_arr [$k] = explode ( "|", $v );
			}
		}
		return json_encode ( $json_arr );
	}
	public function add_coll() {
		$uid = $_SESSION ['user_id'];
		$id = $_GET ['id'];
		$line_keep = M ( 'line_keep' );
		$data ['line_id'] = $id;
		$data ['user_id'] = $uid;
		$data ['create_time'] = time ();
		$data ['status'] = 1;
		$count = $line_keep->where ( "user_id = '$uid' and line_id='$id'" )->count ();
		if (empty ( $uid )) {
			$this->ajaxReturn ( "", "用户未登陆", "0" );
			exit ();
		}
		if ($count > 0) {
			$line_keep->where ( "user_id = '$uid' and line_id='$id'" )->delete ();
			$this->ajaxReturn ( "", "", "2" );
			exit ();
		} else {
			$line_keep->add ( $data );
			$this->ajaxReturn ( "", "收藏成功!", "1" );
			exit ();
		}
	}
	public function order_query() {
		$phone = $_GET ['phone'];
		$lineOrder = M ( 'linePin' );
		$Line = M ( 'Line' );
		// 1.获取发起的拼团订单
		// $list = $lineOrder->join ( $Line->getTableName () . ' line on line.id=' . $lineOrder->getTableName () . '.lid' )->field ( $lineOrder->getTableName () . '.*,line.names,line.line_type' )->where ( $lineOrder->getTableName () . ".phone=$phone" . " and type=0" )->order ( "id desc" )->select ();
		// $this->assign ( "pinglist", $list );
		// 2.报名团订单
		// print_r($list);
		// $list = $lineOrder->join ( $Line->getTableName () . ' line on line.id=' . $lineOrder->getTableName () . '.lid' )->field ( $lineOrder->getTableName () . '.*,line.names,line.line_type' )->where ( $lineOrder->getTableName () . ".phone=$phone" . " and type=1" )->order ( "id desc" )->select ();
		// $this->assign ( "dinglist", $list );
		// print_r($list);
		// 3.普通订单
		$lineOrder = M ( 'lineOrder' );
		$list = $lineOrder->join ( $Line->getTableName () . ' line on line.id=' . $lineOrder->getTableName () . '.lid' )->field ( $lineOrder->getTableName () . '.*,' . $lineOrder->getTableName () . '.price-remoney restmoney,line.names,line.line_type,line.ly_type,line.compnay' )->where ( "phone=$phone" )->order ( "id desc" )->select ();
		$this->assign ( "orderlist", $list );
		// print_r($list);
		$this->display ();
	}
	public function alipay() {
		/**
		 * 获取订单信息并进行支付
		 */
		$orderid = $_POST ['orderid'];
		$LineOrder = D ( 'LineOrder' );
		$orderInfo = $LineOrder->where ( array (
				'orderid' => $orderid 
		) )->find ();
		if ($orderInfo != null) {
			$price = $orderInfo ['remoney'];
			$state = $orderInfo ['state'];
			if ($state != 0) {
				$this->error ( "此订单已经支付，不能重复支付！" );
			} else {
				$alipaySubmit = new AlipaySubmit ( array (
						'partner' => '2088911378604746',
						'seller_email' => '3094372894@qq.com',
						'key' => 'u5ak2wi6qtt1jg0qdjb68n0dm7l1hgur',
						'sign_type' => strtoupper ( 'MD5' ),
						'input_charset' => strtolower ( 'gbk' ),
						'cacert' => getcwd () . '\\alipay\\cacert.pem',
						'transport' => 'http' 
				) );
				// 支付类型
				$payment_type = "1";
				// 必填，不能修改
				// 服务器异步通知页面路径
				$notify_url = "http://www.hf97667.com/index.php/travel/alipaynotify";
				// 需http://格式的完整路径，不能加?id=123这类自定义参数
				
				// 页面跳转同步通知页面路径
				$return_url = "http://www.hf97667.com/index.php/travel/alipayreturn"; //
				                                                                      // 需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
				                                                                      // 商户订单号 // $out_trade_no = $_POST ['WIDout_trade_no'];
				$out_trade_no = $orderid;
				// 商户网站订单系统中唯一订单号，必填
				
				// 订单名称
				$subject = '包团旅行订单';
				// 必填
				
				// 付款金额
				// $total_fee = $_POST ['WIDtotal_fee'];
				$total_fee = $price;
				// 必填
				
				// 订单描述
				
				$body = '内蒙古汇丰旅行社有限公司包团旅行预定订单';
				// 默认支付方式
				$paymethod = "bankPay";
				if ($_POST ['pay_bank'] == 'directPay') {
					$paymethod = "directPay";
				} else {
					$paymethod = "bankPay";
				}
				// 必填
				// 默认网银
				// $defaultbank = $_POST ['WIDdefaultbank'];
				if ($paymethod == 'directPay') {
					$defaultbank = "";
				} else {
					$defaultbank = $_POST ['pay_bank'];
				}
				// 必填，银行简码请参考接口技术文档
				
				// 商品展示地址
				// $show_url = $_POST ['WIDshow_url'];
				$show_url = "http://www.hf97667.com/";
				// 需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html
				
				// 防钓鱼时间戳
				$anti_phishing_key = $alipaySubmit->query_timestamp ();
				// 若要使用请调用类文件submit中的query_timestamp函数
				
				// 客户端的IP地址
				$exter_invoke_ip = "121.42.111.74";
				// 非局域网的外网IP地址，如：221.0.0.1
				// echo $alipay_config ['partner'];
				// exit();
				/**
				 * *********************************************************
				 */
				
				// 构造要请求的参数数组，无需改动
				$parameter = array (
						"service" => "create_direct_pay_by_user",
						// "partner" => trim ( $alipay_config ['partner'] ),
						"partner" => trim ( '2088911378604746' ),
						// "seller_email" => trim ( $alipay_config ['seller_email'] ),3094372894@qq.com
						"seller_email" => trim ( '3094372894@qq.com' ),
						"payment_type" => $payment_type,
						"notify_url" => $notify_url,
						"return_url" => $return_url,
						"out_trade_no" => $out_trade_no,
						"subject" => $subject,
						"total_fee" => $total_fee,
						"body" => $body,
						"paymethod" => $paymethod,
						"defaultbank" => $defaultbank,
						"show_url" => $show_url,
						"anti_phishing_key" => $anti_phishing_key,
						"exter_invoke_ip" => $exter_invoke_ip,
						"_input_charset" => trim ( strtolower ( 'utf-8' ) ) 
				);
				
				// 建立请求
				
				$html_text = $alipaySubmit->buildRequestForm ( $parameter, "get", "确认" );
				echo $html_text;
			}
		} else {
			$this->error ( "没有找到订单信息！" );
		}
	}
	public function alipaynotify() {
		$alipayNotify = new AlipayNotify ( array (
				'partner' => '2088911378604746',
				'seller_email' => '3094372894@qq.com',
				'key' => 'u5ak2wi6qtt1jg0qdjb68n0dm7l1hgur',
				'sign_type' => strtoupper ( 'MD5' ),
				'input_charset' => strtolower ( 'gbk' ),
				'cacert' => getcwd () . '\\alipay\\cacert.pem',
				'transport' => 'http' 
		) );
		// $verify_result = $alipayNotify->verifyReturn ();
		// if ($verify_result) { // 验证成功
		// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// 请在这里加上商户的业务逻辑程序代码
		
		// ——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
		// 获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
		
		// 商户订单号
		
		$out_trade_no = $_POST ['out_trade_no'];
		
		// 支付宝交易号
		
		$trade_no = $_POST ['trade_no'];
		
		// 交易状态
		$trade_status = $_POST ['trade_status'];
		
		if ($_POST ['trade_status'] == 'TRADE_FINISHED' || $_POST ['trade_status'] == 'TRADE_SUCCESS') {
			// 判断该笔订单是否在商户网站中已经做过处理
			// $orderModel = M ()->query ( "select orderid,price,state from jee_line_pin where orderid=" . $out_trade_no . " union select orderid,price,state from jee_line_order where orderid=" . $out_trade_no . "" );
			$LineOrder = D ( 'LineOrder' );
			$orderInfo = $LineOrder->where ( array (
					'orderid' => $out_trade_no 
			) )->find ();
			$state = $orderInfo ['state'];
			if ($state == 0) { // 如果订单状态是未支付则修改为已支付
				/*
				 * $LinePin = D ( 'LinePin' );
				 * $LinePin->where ( array (
				 * 'orderid' => $out_trade_no
				 * ) )->setField ( array (
				 * 'state' => 1,
				 * 'trade_no' => $trade_no
				 * ) );
				 */
				$LineOrder = D ( 'LineOrder' );
				$LineOrder->where ( array (
						'orderid' => $out_trade_no 
				) )->setField ( array (
						'state' => 1,
						'trade_no' => $trade_no 
				) );
				
				// 发送支付短信开始
				$messContent = "亲 您的订单" . $out_trade_no . "已支付成功,行程已确认,客服会在出团前一天通知您具体集合时间地点联系人等信息.如有变动请联系客服4001888332,用手机号可在官网www.hf97667.com查询订单详情.";
				$messDate = array (
						'action' => 'send',
						'username' => '70208213',
						'password' => md5 ( 'hf6317995' ),
						'phone' => $orderInfo ['phone'],
						'content' => urlencode ( $messContent ) 
				);
				$this->curl_post ( "http://api.duanxin.cm/", $messDate, true );
			}
			
			// 如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			
			// 如果有做过处理，不执行商户的业务程序
		} else {
			echo "trade_status=" . $_POST ['trade_status'];
		}
		
		echo "验证成功<br />";
		
		// ——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
		
		// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// } else {
		// 验证失败
		// 如要调试，请看alipay_notify.php页面的verifyReturn函数
		// echo "验证失败";
		// }
	}
	public function alipayreturn() {
		$alipayNotify = new AlipayNotify ( array (
				'partner' => '2088911378604746',
				'seller_email' => '3094372894@qq.com',
				'key' => 'u5ak2wi6qtt1jg0qdjb68n0dm7l1hgur',
				'sign_type' => strtoupper ( 'MD5' ),
				'input_charset' => strtolower ( 'gbk' ),
				'cacert' => getcwd () . '\\alipay\\cacert.pem',
				'transport' => 'http' 
		) );
		$verify_result = $alipayNotify->verifyReturn ();
		// echo print_r($verify_result);
		// exit();
		// if ($verify_result==1) { // 验证成功
		// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// 请在这里加上商户的业务逻辑程序代码
		
		// ——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
		// 获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
		
		// 商户订单号
		
		$out_trade_no = $_GET ['out_trade_no'];
		
		// 支付宝交易号
		
		$trade_no = $_GET ['trade_no'];
		
		// 交易状态
		$trade_status = $_GET ['trade_status'];
		// echo $_GET ['trade_status'];
		// exit();
		
		if ($_GET ['trade_status'] == 'TRADE_FINISHED' || $_GET ['trade_status'] == 'TRADE_SUCCESS') {
			// 判断该笔订单是否在商户网站中已经做过处理
			// $orderModel = M ()->query ( "select orderid,price,state from jee_line_pin where orderid=" . $out_trade_no . " union select orderid,price,state from jee_line_order where orderid=" . $out_trade_no . "" );
			$LineOrder = D ( 'LineOrder' );
			$orderInfo = $LineOrder->where ( array (
					'orderid' => $out_trade_no 
			) )->find ();
			$state = $orderInfo ['state'];
			if ($state == 0) { // 如果订单状态是未支付则修改为已支付
				$LinePin = D ( 'LinePin' );
				$LinePin->where ( array (
						'orderid' => $out_trade_no 
				) )->setField ( array (
						'state' => 1,
						'trade_no' => $trade_no 
				) );
				
				$LineOrder->where ( array (
						'orderid' => $out_trade_no 
				) )->setField ( array (
						'state' => 1,
						'trade_no' => $trade_no 
				) );
				// 发送支付短信开始
				$messContent = "亲 您的订单" . $out_trade_no . "已支付成功,行程已确认,客服会在出团前一天通知您具体集合时间地点联系人等信息.如有变动请联系客服4001888332,用手机号可在官网www.hf97667.com查询订单详情";
				$messDate = array (
						'action' => 'send',
						'username' => '70208213',
						'password' => md5 ( 'hf6317995' ),
						'phone' => $OrderData ['phone'],
						'content' => urlencode ( $messContent ) 
				);
				$this->curl_post ( "http://api.duanxin.cm/", $messDate, true );
				$this->assign ( "mess", '支付成功!' );
			} else if ($state >= 1) {
				$this->assign ( "mess", '此订单已经支付过!' );
			}
			$Line = M ( 'Line' );
			$lineOrder1 = M ( 'lineOrder' );
			$list = $lineOrder1->join ( $Line->getTableName () . ' line on line.id=' . $lineOrder1->getTableName () . '.lid' )->field ( $lineOrder1->getTableName () . '.*,' . $lineOrder1->getTableName () . '.price-remoney restmoney,line.names,line.line_type,line.ly_type,line.compnay' )->where ( "orderid='" . $out_trade_no . "'" )->select ();
			$this->assign ( "orderlist", $list );
			$this->assign ( "success", 1 );
		} else {
			echo "trade_status=" . $_GET ['trade_status'];
			$this->assign ( "mess", '此订单已经支付过!' );
			$this->assign ( "success", 0 );
		}
		
		// echo "验证成功<br />";
		
		// ——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
		
		// ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// } else {
		// 验证失败
		// 如要调试，请看alipay_notify.php页面的verifyReturn函数
		// echo "验证失败";
		// }
		$this->display ();
	}
	function curl_post($url, $param = null, $isJson = false) {
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		if ($param != null && $param != "") {
			curl_setopt ( $ch, CURLOPT_POST, 1 );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $param );
		}
		if ($isJson == false)
			$data = json_decode ( curl_exec ( $ch ), true );
		else
			$data = curl_exec ( $ch );
		curl_close ( $ch );
		return $data;
	}
	/**
	 * post 方式提交http 请求并获取返回结果
	 *
	 * @param unknown $URL        	
	 * @param unknown $data        	
	 * @param unknown $cookie        	
	 * @param string $referrer        	
	 * @return string
	 */
	function HTTP_Post($URL, $data, $cookie, $referrer = "") {
		// parsing the given URL
		$URL_Info = parse_url ( $URL );
		// Building referrer
		if ($referrer == "") // if not given use this script as referrer
			$referrer = "111";
			// making string from $data
		foreach ( $data as $key => $value )
			$values [] = "$key=" . urlencode ( $value );
		$data_string = implode ( "&", $values );
		// Find out which port is needed - if not given use standard (=80)
		if (! isset ( $URL_Info ["port"] ))
			$URL_Info ["port"] = 80;
			// building POST-request:
		$request = "POST " . $URL_Info ["path"] . " HTTP/1.1\n";
		$request .= "Host: " . $URL_Info ["host"] . "\n";
		$request .= "Referer: $referrer\n";
		$request .= "Content-type: application/x-www-form-urlencoded\n";
		$request .= "Content-length: " . strlen ( $data_string ) . "\n";
		$request .= "Connection: close\n";
		// $request .= "Cookie: $cookie\n";
		$request .= "\n";
		$request .= $data_string . "\n";
		$fp = fsockopen ( $URL_Info ["host"], $URL_Info ["port"] );
		fputs ( $fp, $request );
		$result = "";
		while ( ! feof ( $fp ) ) {
			$result .= fgets ( $fp, 1024 );
		}
		
		fclose ( $fp );
		return $result;
	}
	function sendEmail($emailaddr = 'hf97667@163.com', $emailname = 'hf97667', $subject = '团队境内旅游合同', $content = '团队境内旅游合同') {
		$email = D ( "email" );
		$email->send ( $emailaddr, $emailname, $subject, $content );
	}
	function sendMail() {
		$this->sendEmail ( 'imubwz@126.com', 'baowz', '测试邮件', '测试邮件' );
	}
	function sendMess() {
		$messDate = array (
				'action' => 'send',
				'username' => '70208213',
				'password' => md5 ( 'hf6317995' ),
				'phone' => '15184707203',
				'content' => urlencode ( "测试短信" ) 
		);
		$this->curl_post ( "http://api.duanxin.cm/", $messDate, true );
	}
	function sendLineInfoToQuNRW() {
		layout ( false );
		$line = M ( "line" );
		$linePrice = M ( "line_price" );
		$year = date ( 'Y' );
		$month = date ( 'm' );
		$day = date ( 'd' );
		// $linePrices = $linePrice->join ( $line->getTableName () . " on line_id=jee_line.id" )->where ( "year=" . $year . " and month=" . $month . " and day=" . $day . "" )->field ( "jee_line.*,1000 price_adult,1000 price_children,100 dfc" )->select ();
		$lineInfos = $line->where ( "qunaer=1" )->field ( " *,front_money as price_adult, cmoney as price_children,100 as dfc " )->select ();
		$list = array ();
		foreach ( $lineInfos as $lineInfo ) {
			// 每条线路生成一个
			$routes = array ();
			$city_name = M ( 'area' )->where ( "id='" . $lineInfo ['city_id'] . "'" )->field ( "names" )->find ();
			$images = M ( 'line_pic' )->where ( "line_id='" . $lineInfo ['id'] . "'" )->field ( "CONCAT('http://www.hf97667.com', pic_path) as pic_path " )->select ();
			$imagesvar = array ();
			foreach ( $images as $image ) {
				$imagesvar ['image'] = $image ['pic_path'];
			}
			$line_info = M ( "line_info" )->where ( "lid='" . $lineInfo ['id'] . "'" )->field ( "special_info,contain,notcontain,tip" )->find ();
			
			if ($line_info ['feature'] == null) {
				$features = array (
						'feature' => '线路特色' 
				);
			} else {
				$features = array (
						'feature' => '<![CDATA[' . strip_tags ( $line_info ['feature'] ) . ']]>' 
				);
			}
			$fee_includes = array (
					'fee_include' => '<![CDATA[' . strip_tags ( $line_info ['contain'] ) . ']]>' 
			);
			$fee_excludes = array (
					'fee_exclude' => '<![CDATA[' . $line_info ['notcontain'] . ']]>' 
			);
			$tips = array (
					'tip' => '<![CDATA[' . strip_tags ( $line_info ['tip'] ) . ']]>' 
			);
			// 费用包含
			// 获取每个线路的价格信息
			$line_prices = M ( 'line_price' )->where ( "line_id='" . $lineInfo ['id'] . "'" )->field ( "price_date,price_adult,price_children,dfc" )->select ();
			$route_dates = array ();
			foreach ( $line_prices as $key => $line_price ) {
				$route_date = array (
						'date' => date ( 'Y-m-d', $line_price ['price_date'] ),
						'price' => $line_price ['price_adult'],
						'child_price' => $line_price ['price_children'],
						'price_diff' => $line_price ['dfc'],
						'elename' => 'route_date' 
				);
				$route_dates [] = $route_date;
			}
			// 获取每天的形成
			$line_travels = M ( 'line_travel' )->where ( "line_id='" . $lineInfo ['id'] . "'" )->select ();
			$daily_trips = array ();
			foreach ( $line_travels as $daily_tripi ) {
				$dinings = $daily_tripi ['dining'];
				$diningArray = explode ( ",", $dinings );
				$beveragestr = "";
				$zacanhan = 0;
				$wucanhan = 0;
				$wancanhan = 0;
				foreach ( $diningArray as $diningi ) {
					if ($diningi == '1') {
						$zacanhan = 1;
					}
					if ($diningi == '2') {
						$wucanhan = 1;
					}
					if ($diningi == '3') {
						$wancanhan = 1;
					}
				}
				if ($zacanhan == 1) {
					$beveragestr = $beveragestr . "早餐：含";
				} else {
					$beveragestr = $beveragestr . "早餐：自理";
				}
				if ($wucanhan == 1) {
					$beveragestr = $beveragestr . "  午餐：含";
				} else {
					$beveragestr = $beveragestr . "  午餐：自理";
				}
				if ($wancanhan == 1) {
					$beveragestr = $beveragestr . "  晚餐：含";
				} else {
					$beveragestr = $beveragestr . "  晚餐：自理";
				}
				$daily_trip = array (
						'day' => $daily_tripi ['day'],
						'desc' => $daily_tripi ['title'],
						'title' => $daily_tripi ['title'],
						'elename' => 'daily_trip',
						'traffic' => $lineInfo ['traffic'],
						'beverage' => $beveragestr 
				);
				// 获取行程具体内容
				$line_travel_sections = M ( 'line_travel_section' )->where ( "line_id='" . $lineInfo ['id'] . "' and travel_id='" . $daily_tripi ['id'] . "'" )->find ();
				$daily_trip ['desc'] = '<![CDATA[' . strip_tags ( $line_travel_sections ['content'] ) . ']]>';
				array_push ( $daily_trips, $daily_trip );
			}
			// 获取线路最早时间和最晚时间
			$maxandminDate = M ( 'line_price' )->where ( "line_id='" . $lineInfo ['id'] . "' and year='" . $year . "'" )->field ( "max(DATE(FROM_UNIXTIME(price_date))) maxdate,min(DATE(FROM_UNIXTIME(price_date))) mindate" )->find ();
			// 获取线路价钱
			$adultandchildren = M ( 'line_price' )->where ( "line_id='" . $lineInfo ['id'] . "' and year='" . $year . "'" )->field ( "min(price_adult) price_adult,max(price_children) price_children,max(dfc) dfc  " )->find ();
			if ($adultandchildren ['dfc'] == null) {
				$adultandchildren ['dfc'] = 0;
			}
			$route = array (
					'title' => $lineInfo ['names'],
					'url' => 'http://www.hf97667.com/index.php/travel/detail/id/' . $lineInfo ['id'] . '',
					'price' => $adultandchildren ['price_adult'],
					'price_desc' => '儿童标准（1.2米以下为儿童，儿童价格只含当地旅游车费和行程中所包含的餐费，超过1.2米的建议按成人报名）；单房差（酒店住宿都是按2人标准间核算的，如出现单人住一间房需补齐1间房费用，如不补单房差费用便默认和其他客人拼住一间房）。',
					'child_price' => $adultandchildren ['price_children'],
					'price_diff' => $adultandchildren ['dfc'],
					'function' => '跟团游',
					'departure' => $city_name ['names'],
					'type' => '国内游',
					'subject' => '自然风光',
					'date_of_departure' => $maxandminDate ['mindate'], // 最早出行时间
					'date_of_expire' => $maxandminDate ['maxdate'], // 最晚出行时间
					'advance_day' => 1,
					'day_num' => $lineInfo ['trip_days'],
					'hotel_night' => $lineInfo ['hotel_night'],
					'to_traffic' => $lineInfo ['traffic'],
					'back_traffic' => $lineInfo ['traffic'],
					'images' => $imagesvar,
					'features' => $features,
					'fee_includes' => $fee_includes,
					'tips' => $tips,
					'route_dates' => $route_dates,
					'elename' => 'route',
					'daily_trips' => $daily_trips 
			);
			array_push ( $routes, $route );
			$xmlstr = xml_encode ( $routes, "utf-8", "routes" );
			file_put_contents ( $lineInfo ['code'] . ".xml", $xmlstr );
			$listi = array (
					'url' => "http://www.hf97667.com/" . $lineInfo ['code'] . ".xml" 
			);
			array_push ( $list, $listi );
		}
		// 转化为xml文件
		$returnxml = '<?xml version="1.0" encoding="utf-8"?><list>';
		foreach ( $list as $li ) {
			$returnxml = $returnxml . '<url>' . $li ['url'] . '</url>';
		}
		$returnxml = $returnxml . '</list>';
		header ( 'Content-Type:text/xml; charset=utf-8' );
		$this->show ( $returnxml, "utf-8", "text/xml" );
	}
	public function meetinglines() {
		// 获取所有团体策划相关的文章列表
		$article = M ( 'article' );
		$count = $article->join ( M ( 'article_section' )->getTableName () . " section on section.id=jee_article.cid" )->where ( " section.e_names in ('hyxl','hyfw','htqd','cjbz','cgal')" )->field ( "jee_article.*" )->count ();
		$p = isset ( $_GET ['p'] ) ? intval ( $_GET ['p'] ) : 1; // 获取分页页码
		class_exists ( "Page" ) or import ( "ORG.Util.Page" );
		$Page = new Page ( $count, 5 );
		$show = $Page->show ();
		$articlelist = $article->join ( M ( 'article_section' )->getTableName () . " section on section.id=jee_article.cid" )->where ( " section.e_names in ('hyxl','hyfw','htqd','cjbz','cgal')" )->order ( 'add_time desc' )->field ( "jee_article.*" )->limit ( $Page->firstRow . "," . $Page->listRows )->select ();
		$this->assign ( 'articlelist', $articlelist );
		$this->assign ( "page", $show );
		$this->display ();
	}
	public function meetingdetail() {
		$id = (isset ( $_GET ["id"] )) ? $_GET ["id"] : 0;
		// 生成文章分类列表
		$sec = M ( "ArticleSection" );
		$list = $sec->where ( "pid=0 AND status=1" )->order ( "id asc" )->select ();
		$this->assign ( "list", $list );
		
		if ($id > 0) {
			// 获取文章内容
			$art = M ( "Article" );
			$content = M ()->table ( $art->getTableName () . " art" )->join ( $sec->getTableName () . " sec ON art.cid = sec.id" )->where ( "art.id=$id AND art.status=1" )->field ( "art.*, sec.id as Section_id" )->find ();
			$art->where ( "id={$content['id']}" )->setInc ( "hits", 1 );
		} else {
			// 获取文章内容
			$map = (isset ( $_GET ["detail"] )) ? "sec.id=" . $_GET ["detail"] : "sec.id > 0";
			$art = M ( "Article" );
			$content = M ()->table ( $art->getTableName () . " art" )->join ( $sec->getTableName () . " sec ON art.cid = sec.id" )->where ( $map . " AND art.status=1" )->field ( "art.*, sec.model, sec.id as Section_id" )->order ( "sec.id asc" )->find ();
			// 查不到内容（$content 为空）或为单页模型，则获取文章列表
			if ($content == null)
				$this->articelList ( $_GET ["detail"] );
			elseif ($content ["model"] == 0)
				$this->articelList ( $content ["Section_id"] );
			else
				$art->where ( "id=" . $content ["id"] )->setInc ( "hits", 1 );
		}
		
		$this->assign ( "content", $content );
		$this->assign ( "detailtype", 0 );
		$this->display ();
	}
	public function tosetpricedesc() {
		// 儿童标准（1.2米以下为儿童，儿童价格只含当地旅游车费和行程中所包含的餐费，超过1.2米的建议按成人报名）；单房差（酒店住宿都是按2人标准间核算的，如出现单人住一间房需补齐1间房费用，如不补单房差费用便默认和其他客人拼住一间房）。
		$this->display ();
	}
	public function setpricedesc() {
		$linePrice = M ( 'LinePrice' );
		$content = $_POST ['content'];
		//
		$linePrice->where ( array (
				'1' => 1 
		) )->setField ( array (
				'price_desc' => $content 
		) );
		//
		// $linePrice->setField(array ('price_desc'=>$content));
		echo 'success';
	}
}

?>
