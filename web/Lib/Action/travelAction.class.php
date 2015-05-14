<?php
class travelAction extends CommonAction {

	private $type_select;
	private $topic = array(1 => "古镇游", 2 => "山水游", 3 => "海岛游", 4 => "乐园游");
	protected $max_p = 3000;

	public function _initialize() {
		$authentic = array("order", "order_success");
		in_array(ACTION_NAME, $authentic) ? $this->authentic = 1 : $this->authentic = 0;
		parent::_initialize();
		$this->type_select = $_GET["type"] ? intval($_GET["type"]) : -1;
		$this->assign("current", $this->type_select);
	}

	public function index() {

		$id  = isset($_GET['id']) ? intval($_GET['id']) : 0; //获取分页页码
		$day = $_GET['day']; //? intval($_GET['day']) : 1; //获取分页页码
		$this->assign('id', $id);
		$View = M("Line");
		$where = 'status=0';
		if($id>0)  $where .=" and line_type='$id' ";
		if($day!=null&&$day>0){
			$this->assign('day', $day);
			if($day>0) $where .=" and trip_days='$day' ";
		}
		$count = $View->where($where)->count();
		$p = isset($_GET['p']) ? intval($_GET['p']) : 1; //获取分页页码
		class_exists("Page") or import("ORG.Util.Page");
		$Page = new Page($count, 9);
		$show = $Page->show();
		$list = $View->where($where)->order('sort,id desc')->limit($Page->firstRow . "," . $Page->listRows)->select();
		$this->assign('list', $list);
		$this->assign("page", $show);

		$this->display();
	}


	public function init_function() {

		function url_params($params) {
			$url_params = array();
			foreach ($params as $k => $v) {
				$url_params[] = urlencode($k) . "=" . urlencode($v);
			}
			return join("&", $url_params);
		}

		function get_special_info($lineid = "0") {
			static $line_info = null;
			if ($line_info === null)
			$line_info = M("line_info");
			$content = $line_info->where("lid=$lineid")->getField("special_info");
			return preg_replace("/\<.*?\>/", "", $content);
		}

		function get_titlepage($lineid = "0", $type = "pic_small") {
			static $line_pic = null;
			if ($line_pic === null)
			$line_pic = M("line_pic");
			$pic_path = $line_pic->where("line_id=$lineid")->order("istitlepage")->getField($type);
			return $pic_path;
		}

		function get_tuan($lineid = "0") {
			static $line_price = null;
			if ($line_price === null)
			$line_price = M("line_price");

			if ($line_price->where("line_id=$lineid and price_type=4")->count())
			return "天天发团";

			$week = $line_price->where("line_id=$lineid and price_type=3")->order("price_date")->getField("id,price_date");
			if (count($week) == 7)
			return "天天发团";

			$stage = $line_price->where("line_id=$lineid and price_type=2 and from_unixtime(price_date_end,'%Y%m%d')>= from_unixtime(UNIX_TIMESTAMP(),'%Y%m%d')")->field("id,price_date,price_date_end")->select();
			$day = $line_price->where("line_id=$lineid and price_type=1 and from_unixtime(price_date,'%Y%m%d')>= from_unixtime(UNIX_TIMESTAMP(),'%Y%m%d')")->getField("id,price_date");
			$i = 1;
			foreach ($day as $d) {
				if ($i = 5)
				break;
				$str.=date("Y-m-d,", $d);
				$i++;
			}
			foreach ($stage as $sd) {
				if ($i = 5)
				break;
				$str.=date("Y-m-d至", $sd["price_date"]) . date("Y-m-d,", $sd["price_date_end"]);
				$i++;
			}
			$wed = array("1" => "二", "1" => "三", "1" => "四", "1" => "五", "1" => "六", "1" => "日",);
			foreach ($week as $wd) {
				if ($i = 5)
				break;
				$str.="每周" . $wed[$wd] . ",";
				$i++;
			}
			$str = rtrim($str, ",") . "等";
			return $str;
		}

	}


	public function order_ding() {
		layout(false); // 临时关闭当前模板的布局功能
		$id = $_GET["id"] ? intval($_GET["id"]) : 0;
		$LineTao = M("LineTao");
		$tao = $LineTao->find($id);
		$this->assign("tao", $tao); //基本信息

		$line = M("line");
		$line_base = $line->find($tao["line_id"]);
		$this->assign("line_base", $line_base); //基本信息

		$this->display();
	}


	public function order_ding_act() {
		$LinePin = D('LinePin');
		$_POST['num'] = intval($_POST['people'])+intval($_POST['woman'])+intval($_POST['chd']);

		if(empty($_POST['name'])){
			$this->ajaxReturn("", "联系人不能为空", "n");
			exit();
		}
		if(empty($_POST['phone'])){
			$this->ajaxReturn("", "手机号码不能为空", "n");
			exit();
		}
		if(empty($_POST['phones'])){
			$this->ajaxReturn("", "备用手机号码不能为空", "n");
			exit();
		}
		if(empty($_POST['email'])){
			$this->ajaxReturn("", "email不能为空", "n");
			exit();
		}
		if(empty($_POST['desc'])){
			$this->ajaxReturn("", "备注说明不能为空", "n");
			exit();
		}


		$_POST['price']    = $_POST['num']*$_POST['cmoney'];
		$_POST['status']   = 0;
		$_POST['orderid']  = time().rand(1000, 9999);
		$_POST['type']     = 1;
		if ($LinePin->create()) {
			$LinePin->add();
			$insert_id = $LinePin->getLastInsID();
			$this->ajaxReturn(U('order_ding_view',array("id"=>$insert_id)),"订单详情", "u");
		} else {
			$this->ajaxReturn("", "订单提交失败", "n");
		}
	}




	public function order_ping() {
		layout(false); // 临时关闭当前模板的布局功能
		$id = $_GET["id"] ? intval($_GET["id"]) : 0;
		$line = M("line");
		$line_base = $line->find($id);
		$this->assign("line_base", $line_base); //基本信息
		$this->display();

	}
	public function order_ping_act() {
		$LinePin = D('LinePin');
		$_POST['num'] = intval($_POST['people'])+intval($_POST['woman'])+intval($_POST['chd']);

		if(empty($_POST['tuan_name'])){
			$this->ajaxReturn("", "团名不能为空", "n");
			exit();
		}
		if(empty($_POST['name'])){
			$this->ajaxReturn("", "联系人不能为空", "n");
			exit();
		}
		if(empty($_POST['phone'])){
			$this->ajaxReturn("", "手机号码不能为空", "n");
			exit();
		}
		if(empty($_POST['email'])){
			$this->ajaxReturn("", "email不能为空", "n");
			exit();
		}
		if(empty($_POST['desc'])){
			$this->ajaxReturn("", "备注说明不能为空", "n");
			exit();
		}
		if(empty($_POST['strat'])){
			//$this->ajaxReturn("", "报名截止日期不能为空", "n");
			//exit();
		}
		if(empty($_POST['ends'])){
			$this->ajaxReturn("", "旅行开始日期不能为空", "n");
			exit();
		}
		if($_POST['num']==0){
			$this->ajaxReturn("", "请选择人数", "n");
			exit();
		}
		if($_POST['num']>intval($_POST['mins'])){
			$this->ajaxReturn("", "目标人数不能小于已有人数", "n");
			exit();
		}
		if($_POST['mins']>intval($_POST['maxs'])){
			$this->ajaxReturn("", "目标人数不能大于最多接受人数", "n");
			exit();
		}

		$_POST['price']    = $_POST['num']*$_POST['cmoney'];
		$_POST['status']   = 0;
		$_POST['orderid']  = time().rand(1000, 9999);
		$_POST['type']     = 0;
		if ($LinePin->create()) {
			$LinePin->add();
			$insert_id = $LinePin->getLastInsID();
			$this->ajaxReturn(U('order_ping_view',array("id"=>$insert_id)),"订单详情", "u");
		} else {
			$this->ajaxReturn("", "订单提交失败", "n");
		}
	}
	public function order_ping_view() {
		layout(false); // 临时关闭当前模板的布局功能

		$id = $_GET["id"] ? intval($_GET["id"]) : 0;
		$line = M("LinePin");
		$vo = $line->find($id);
		$this->assign("vo", $vo); //基本信息
		$this->display();
	}


	public function order_success() {
		$table_line_order = M('line_order')->getTableName() . " line_order";
		$table_line = M('line')->getTableName() . " line";
		$order_userinfo = M('order_userinfo');
		$order_id = $_GET['order_id'];
		$list = M()->table($table_line_order)
		->join("$table_line on line_order.line_id=line.id")
		->field('line_order.*,line.names')
		->where("line_order.id='$order_id' AND line_order.user_id='{$_SESSION['user_id']}'")
		->find();
		$list['pri_card'] = D('cash_coupon')->show_coupon($list['used_card']);
		$list['num'] = count($order_userinfo->where("order_id='$order_id' and type='LINE'")->select());
		$list['earnest'] = $list['front_money'];

		if (empty($list)) {
			$this->error("页面出错！");
		}
		$paymentapi = A("paymentapi");
		$banks = $paymentapi->get_banks('wangyin');
		if ($list['status'] == '1') {
			$this->assign("usinfo", $list);
			$this->display('order_untreated');
			exit;
		} elseif ($list['status'] == '2') {
			$this->assign("usinfo", $list);
			$this->assign("banks", $banks);
			$this->assign("amount", M('user')->where("id='{$_SESSION['user_id']}'")->getfield('amount'));
			$this->display('order_processed');
			exit;
		} else {
			$this->error('订单错误!');
		}
	}

	public function order_pay() {
		if (!$_POST['orderid']) {
			$this->error("线路选择错误");
		}
		$user = M('user');
		$order_id = $_POST['orderid'];
		$table_line_order = M('LinePin')->getTableName() . " Line_Pin";
		$list = M()->table($table_line_order)
		->where("orderid='$order_id'")
		->find();
		$should_amount = $list['price'] ;
		$name = $list['name'] ;
		$phone = $list['phone'] ;
		$this->assign("price", $should_amount);
		$this->assign("name", $name);
		$this->assign("phone", $phone);
		$this->assign("orderid",$order_id);
		//$earnest = _get_front_money($list['line_id'], $should_amount);
       /*
		if ($_POST['psw_on']) {
			$uinfo = $user->where("id ='$id' AND password='" . md5($_POST['password']) . "'")->find();
			if ($uinfo) {
				if ($usinfo['amount'] >= $earnest) {
					$user->where("id ='$id'")->setDec('money', $earnest);
				} else {
					$surplus = $earnest - $usinfo['amount'];
					$user->where("id ='$id'")->setDec('money', $usinfo['amount']);
				}
				//剩余未付金额 $surplus
			} else {
				$this->error("密码输入错误!");
			}
		} else {

		}*/
		$this->display();
	}
	/**
	 *  调用支付宝后者网银钱包进行支付
	 */
	public function paymoney() {
		$pay_bank= $_POST['pay_bank'];
		$orderid= $_POST['orderid'];
		if($pay_bank=='directPay'){// 支付宝直接支付
			// 组织数据调用支付宝接口
			
			
		}else{
			//组织数据调用网银钱包接口
			
		}
		
		

		
	}
	public function detail() {
		$id = $_GET["id"] ? intval($_GET["id"]) : 0;
		$line = M("line");
		$line_info = M("LineInfo");
		$line_pic = M("LinePic");
		$line_base = $line->find($id);
		$line_keep = M('line_keep');
		$keep = $line_keep->where("user_id='{$_SESSION['user_id']}' and line_id='$id'")->count();
		if ($line_base) {
			//显示方式(1,按天，2,可视化)
			$view_result = array();
			$view_method = $line_base["edit_model"];

			//获取按天显示方式的记录
			if ($view_method == 1) {
				$line_travel = M("LineTravel");
				$line_travel_section = M("LineTravelSection");
				$line_day = $line_travel->where("line_id=" . $line_base["id"])->order("day")->select();
				if ($line_day) {
					foreach ($line_day as $day) {
						$map = array(
                            'line_id' => array("eq", $line_base["id"]),
                            'travel_id' => array("eq", $day["id"])
						);
						$view_result[] = array(
                            "day_info" => $day,
                            "Section_info" => $line_travel_section->where($map)->order("names")->select()
						);
					}
				}
			}
			//出发城市
			$belong = M("Area");
			$start_city_belong = $belong->where("id=" . $line_base["city_id"])->find();
			//目的地城市
			$target_city_belong = $belong->table($belong->getTableName() . " be")
			->join(M("line_target")->getTableName() . " tar on be.id=tar.area_id")
			->where(array("tar.id" => array("in", $line_base["target"])))->getField("tar.id,names");
			//线路详细描述
			$lineinfo = $line_info->where("lid=" . $line_base["id"])->find();
			// dump($lineinfo); exit();
			//图片列表
			$linepic = $line_pic->where("line_id=" . $line_base["id"])->select();

			//基本价格
			//线路价格列表
			$this->travel_price_list($id);
			//线路问答
			$this->travel_que($id);

			//拼团列表
			$this->ping_list($id);

			//拼团列表
			$this->zutuan_list($id);

		}

		$this->assign("keep_status", $keep);
		$this->assign("line_base", $line_base); //基本信息
		$this->assign("view_method", $view_method); //显示方式1按天，2可视化
		$this->assign("view_result", $view_result); //按天显示方式内容
		$this->assign("lineinfo", $lineinfo); //其它信息
		$this->assign("linepic", $linepic); //图片
		$this->assign("start_city_belong", $start_city_belong); //出发城市
		$this->assign("target_city_belong", $target_city_belong); //目的地城市
		$this->assign("price_pt", $price_pt); //普通价格
		$this->assign("price_date", $price_date_json); //按星期几价格
		$this->assign("price_stage", $price_stage_json); //指定阶段价格
		$this->assign("price_day_json", $price_day_json); //指定日期价格
		$this->assign("line_id", $id); //线路id
		//dump($line_base);
		$this->init_function();
		$this->display();
	}



	protected function travel_price_list($id) {
		$line_price = M("LinePrice");
		//普通价格
		$price_pt = $line_price->where("price_type=4 and line_id=$id")->field("RACKRATE,price_adult,price_children")->find();
		//按星期价格
		$price_date_tmp = $line_price->where("price_type=3 and line_id=$id")->select();
		foreach ($price_date_tmp as $tmp) {
			$price_date[$tmp["price_date"]] = array("RACKRATE" => $tmp["RACKRATE"], "price_adult" => $tmp["price_adult"], "price_children" => $tmp["price_adult"]);
		}
		//按阶段
		$price_stage_tmp = $line_price->where("price_type=2 and line_id=$id")->select();
		foreach ($price_stage_tmp as $tmp) {
			$key = date("Ymd", $tmp["price_date"]) . "_" . date("Ymd", $tmp["price_date_end"]);
			$price_stage[$key] = array("RACKRATE" => $tmp["RACKRATE"], "price_adult" => $tmp["price_adult"], "price_children" => $tmp["price_adult"]);
		}
		//按指定日期
		$price_day_tmp = $line_price->where("price_type=1 and line_id=$id")->select();
		foreach ($price_day_tmp as $tmp) {
			$key = date("Ymd", $tmp["price_date"]);
			$price_day[$key] = array("RACKRATE" => $tmp["RACKRATE"], "price_adult" => $tmp["price_adult"], "price_children" => $tmp["price_adult"]);
		}

		$travel_price_list = array(4 => $price_pt, 3 => $price_date, 2 => $price_stage, 1 => $price_day);


		$this->assign("travel_price_list", json_encode($travel_price_list));
	}


	//组团价格
	protected function zutuan_list($id) {
		$line_que = M("LineTao");
		$lists = $line_que->where("line_id='$id' ")->order("id desc")->select();
		$this->assign("zutuan_list", $lists);
	}

	//拼团价格
	protected function ping_list($id) {
		$line_que = M("LinePin");
		$lists = $line_que->where("lid='$id' and state=1 and type=0")->order("id desc")->select();
		$this->assign("ping_list", $lists);
	}

	protected function travel_que($id) {
		$line_que = M("line_que");
		$lists = $line_que->where("line_id=$id")->order("id desc")->select();
		$this->assign("lists_que", $lists);
	}

	public function consult() {
		if (!isset($_SESSION["user_id"])) {
			//$this->ajaxReturn(array("info" => "请先登录", "status" => "n"));
			//exit;
		}

		if (strlen(trim($_POST["question1"])) < 5) {
			$this->ajaxReturn(array("info" => "至少输入5个字符-1", "status" => "n"));
			exit;
		}
		$id = $this->_get("id");
		$line_que = M("line_que");
		$publish_time = time() - 300;
		$last_que_count = $line_que->where("line_id=$id and user_id={$_SESSION["user_id"]} and publish_time>$publish_time")->count();
		if ($last_que_count > 0) {
			$this->ajaxReturn(array("info" => "您的操作过于频繁-2", "status" => "n"));
			exit;
		}
		$line = M("line");
		$line_count = $line->where("id=$id and status=1")->count();
		if ($line_count == 0) {
			$this->ajaxReturn(array("info" => "您咨询的路线不存在或已经停用-3", "status" => "n"));
			exit;
		}
		$data = array(
            "line_id" => $id,
            "user_id" => $_SESSION["user_id"],
            "question1" => trim($_POST["question1"]),
            "publish_time" => time(),
            "status" => 1,
            "sort" => 0,
		);
		$line_que->add($data);
		$public = APP_TMPL_PATH . "Public";
		$publish_time = date("Y-m-d H:i:s", $data["publish_time"]);
		$user_name = get_user($_SESSION["user_id"]);
		$dom = <<<EOF
		           <div class="dialog_left">
                        <div class="toux"><img height="45" src="/style/images/niu.jpg" ></div>
                        <div class="dia_cont">{$data["question1"]}</div>
                        <div class="clear"></div>
                   </div>

EOF;
		$this->ajaxReturn(array("info" => $dom, "status" => "y"));
	}

	public function validform() {
		$param = $_POST["param"];
		$name = $_POST["name"];
		switch ($name) {
			case"verify":
				if ($_SESSION["verify"] == md5($param)) {
					$ajaxreturn = array("info" => "输入正确", "status" => "y");
				} else {
					$ajaxreturn = array("info" => "输入错误", "status" => "n");
				}
				break;
		}
		$this->ajaxReturn($ajaxreturn);
	}

	/**
	 * 价格列表转换成json
	 * @param type $arr  价格结果
	 * @param type $date_f 是否格式化日期
	 * @return type
	 */
	private function json_price_list($arr, $date_f = false) {
		$json_arr = array();
		if ($date_f) {
			foreach ($arr as $k => $v) {
				$json_arr[date("Y-m-d", $k)] = explode("|", $v);
			}
		} else {
			foreach ($arr as $k => $v) {
				$json_arr[$k] = explode("|", $v);
			}
		}
		return json_encode($json_arr);
	}

	public function add_coll() {
		$uid = $_SESSION['user_id'];
		$id = $_GET['id'];
		$line_keep = M('line_keep');
		$data['line_id'] = $id;
		$data['user_id'] = $uid;
		$data['create_time'] = time();
		$data['status'] = 1;
		$count = $line_keep->where("user_id = '$uid' and line_id='$id'")->count();
		if (empty($uid)) {
			$this->ajaxReturn("", "用户未登陆", "0");
			exit;
		}
		if ($count > 0) {
			$line_keep->where("user_id = '$uid' and line_id='$id'")->delete();
			$this->ajaxReturn("", "", "2");
			exit;
		} else {
			$line_keep->add($data);
			$this->ajaxReturn("", "收藏成功!", "1");
			exit;
		}
	}



}

?>
