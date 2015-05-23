<?php
import ( "ORG.Util.Page" );
import ( "ORG.Net.UploadFile" );
import ( "@.ORG.file" );
class lineAction extends CommonAction {
	
	// 添加
	public function add() {
		if (! $_POST) {
			// 出发城市
			$table_city = M ( "city_belong" )->getTableName () . ' city';
			$table_area = M ( "area" )->getTableName () . ' area';
			$start_city = M ( "city_belong" )->table ( $table_city )->join ( $table_area . " on city.cid=area.id" )->where ( "types='LINE'" )->field ( "city.*,area.names" )->order ( "city.sort" )->select ();
			// 目的地类型
			$city_type = M ( "LineType" )->order ( "sort" )->select ();
			
			// 线路主题
			// $line_topic = M('line_topic_type')->order("sort")->select();
			
			// 目的地城市列表
			/*
			 * $map = array();
			 * $map['target.start_id'] = $start_city ? array('eq', $start_city[0]['cid']) : array('eq', 0);
			 * $map['target.type_id'] = $city_type ? array('eq', $city_type[0]['id']) : array('eq', 0);
			 * $target_list = D("LineTarget")->gettar($map);
			 */
			
			$this->assign ( "start_city", $start_city );
			$this->assign ( "city_type", $city_type );
			// $this->assign("target_list", $target_list);
			// $this->assign("line_topic", $line_topic);
			$this->display ();
		} else {
			$Line = D ( 'Line' );
			$linebelongto = $_POST ['linebelongto'];
			$Line->linebelongto = $linebelongto;
			$LineInfo = M ( "LineInfo" );
			$LineTravel = D ( "LineTravel" );
			$LineTravelSection = D ( "LineTravelSection" );
			if (! isset ( $_POST ['status'] )) {
				$_POST ['status'] = 0;
			}
			if ($Line->create ()) {
				$Line->add ();
				$insert_id = $Line->getLastInsID ();
				
				// 添加其它内容到line_info表
				$LineInfo->create ();
				$LineInfo->lid = $insert_id;
				$LineInfo->add ();
				
				$date_insert_id = $LineTravel->insertdata ( $insert_id ); // 添加行程安排到 line_travel
				$LineTravelSection->insdata ( $insert_id, $date_insert_id ); // 添加行程安排的阶段到 line_travel_section
				$submitandsetprice = $_POST ['submitandnext'];
				if ($submitandsetprice == 1) {
					$this->redirect ( "price_list", array (
							'line_id' => $insert_id 
					), 2, "保存成功，请继续维护报价信息。" );
				} else {
					$this->success ( "添加成功", U ( "show_list" ) );
				}
			} else {
				$this->error ( "添加失败," . $Line->getError () );
			}
		}
	}
	public function auto() {
		$auto = substr ( date ( "ymdHis" ), 2, 8 ) . mt_rand ( 100000, 999999 );
		$this->assign ( "auto", $auto );
	}
	public function Line_info() {
		$this->display ( "Line_info" );
	}
	public function show_list() {
		$linetype = M ( 'line_type' );
		$Line = M ( "line" );
		unset ( $_GET ['_URL_'] );
		$order = "sort";
		// ! $_GET ['p']
		if ($_GET) {
			$where ['names'] = array (
					"LIKE",
					"%" . $_GET ['names'] . "%" 
			);
			if ($_GET ['areaid'] != '') {
				$where ['linebelongto'] = array (
						"eq",
						$_GET ['areaid'] 
				);
			}
			if ($_GET ['linetype'] != '') {
				$where ['line_type'] = array (
						"eq",
						$_GET ['linetype'] 
				);
			}
			if ($_GET ['status'] != '') {
				$where ['status'] = array (
						"eq",
						$_GET ['status'] 
				);
			}
			if ($_GET ['target_type'] != '') {
				$where ['target_type'] = array (
						"eq",
						$_GET ['target_type'] 
				);
			}
			
			if (! empty ( $_GET ['sort'] )) {
				$order = $_GET ['sort'] . " " . $_GET ['path'];
			}
		}
		$linetype = $linetype->select ();
		$count = $Line->where ( $where )->count ();
		$page = $this->pagebar ( $count );
		$list = $Line->page ( $page )->where ( $where )->order ( $order )->select ();
		$this->assign ( 'massage' );
		$this->assign ( "get", $_GET );
		$this->assign ( "linetype", $linetype );
		$this->assign ( 'list', $list );
		$this->display ();
	}
	
	// 编辑
	public function edit() {
		$Line = D ( 'Line' );
		$LineInfo = M ( "LineInfo" );
		$LineTravel = D ( "LineTravel" );
		$LineTravelSection = D ( "LineTravelSection" );
		if (! $_POST) {
			// 读取line表和line_info表线路信息
			$line_list = $Line->table ( $Line->getTableName () . " line" )->join ( $LineInfo->getTableName () . " lineinfo on line.id=lineinfo.lid" )->field ( "line.*,lineinfo.special_info,lineinfo.order_info,lineinfo.tip,lineinfo.General" )->where ( 'line.id=' . $_GET ["id"] )->find ();
			
			// 选中的目的地城市
			$target = explode ( ',', $line_list ['target'] );
			
			// 线路主题
			$line_topic = M ( 'line_topic_type' )->order ( "sort" )->select ();
			
			// 出发城市
			$table_city = M ( 'city_belong' )->getTableName () . ' city';
			$table_area = M ( 'area' )->getTableName () . ' area';
			$start_city = M ()->table ( $table_city )->join ( $table_area . " on city.cid=area.id" )->where ( "types='LINE'" )->field ( "city.*,area.names" )->order ( "city.sort" )->select ();
			
			// 目的地类型
			$city_type = M ( "LineType" )->order ( "sort" )->select ();
			
			// 目的地城市列表
			$map = array ();
			$map ['target.start_id'] = $start_city ? array (
					'eq',
					$start_city [0] ['cid'] 
			) : array (
					'eq',
					0 
			);
			$map ['target.type_id'] = $city_type ? array (
					'eq',
					$city_type [0] ['id'] 
			) : array (
					'eq',
					0 
			);
			$target_list = D ( "LineTarget" )->gettar ( $map );
			
			$this->assign ( "start_city", $start_city ); // 出发城市
			$this->assign ( "city_type", $city_type ); // 目的地类型
			$this->assign ( "target", $target ); // 选中的目的地
			$this->assign ( "target_list", $target_list ); // 目的地列表
			$this->assign ( "line_list", $line_list ); // 线路信息
			$this->assign ( "line_topic", $line_topic ); // 线路主题
			$this->assign ( "ding", array (
					'1',
					'2',
					'3' 
			) );
			$this->display ();
		} else {
			$_POST ["id"] = $_POST ['id'] = $_GET ["id"];
			if (! isset ( $_POST ['status'] )) {
				$_POST ['status'] = 0;
			}
			if ($data = $Line->create ()) {
				$Line->save ();
				
				$LineInfo->where ( "lid=" . $_POST ["id"] )->save ( $_POST );
				$updateid = $LineTravel->update ( $_POST ["id"] );
				$LineTravelSection->update ( $_POST ["id"], $updateid );
				$submitandsetprice = $_POST ['submitandnext'];
				if ($submitandsetprice == 1) {
					$this->redirect ( "price_list", array (
							'line_id' =>  $_POST ["id"] 
					), 2, "保存成功，请继续维护报价信息。" );
				} else {
					$this->redirect ( "show_list" );
				}
			} else {
				echo $Line->getError ();
			}
		}
	}
	public function ajax_edit() {
		$id = $_GET ['id'];
		$LineTravel = D ( "LineTravel" );
		$LineTravelSection = D ( "LineTravelSection" );
		// 读取line_travel表行程安排记录
		$Travel = $LineTravel->where ( "line_id=" . $id )->order ( "day" )->select ();
		
		// 读取line_travel_section表行程安排中的阶段记录，返回数据格式为$Section[天]=当天所有阶段记录
		$Section = $LineTravelSection->getSection ( $Travel );
		$data = array ();
		$count = count ( $Travel );
		for($i = 1; $i <= $count; $i ++) {
			$day_info = current ( $Travel );
			$data [$day_info ["day"]] = array (
					"title" => $day_info ["title"],
					"dining" => explode ( ",", $day_info ["dining"] ),
					"stay" => $day_info ["stay"],
					"con" => array () 
			);
			if (isset ( $Section [$day_info ["id"]] )) {
				foreach ( $Section [$day_info ["id"]] as $v ) {
					$data [$day_info ["day"]] ["con"] [$v ["names"]] = array (
							"title" => $v ["title"],
							"content" => $v ["content"] 
					);
				}
			}
			next ( $Travel );
		}
		
		$this->ajaxReturn ( $data );
	}
	
	// 部分编辑
	public function ajax_save() {
		header ( 'Content-Type:text/html;charset=utf-8' );
		$id = $_GET ['id'];
		$names = $_POST ['names'];
		$sort = $_POST ['sort'];
		$Line = M ( 'Line' );
		$Line->create ();
		$Line->id = $id;
		$Line->names = $names;
		$Line->sort = $sort;
		$Line->save ();
		echo 1;
		exit ();
	}
	public function getdata() {
		$data = array (
				"20130924" => array (
						"2000",
						"1800",
						"1500" 
				),
				"20131001" => array (
						"2000",
						"1800",
						"1500" 
				) 
		);
		$this->ajaxReturn ( $data );
	}
	public function del() {
		$id = $_GET ['id'];
		$Line = M ( 'Line' );
		// $picpath = $Line->where("id=$id")->getField("picpath");
		
		$Line->where ( "id=$id" )->delete ();
		$this->redirect ( "show_list" );
	}
	public function online() {
		$id = $_GET ['id'];
		$Line = M ( 'Line' );
		$Line->where ( "id=$id" )->setField ( "status", "0" );
		$this->redirect ( "show_list" );
	}
	public function offline() {
		$id = $_GET ['id'];
		$Line = M ( 'Line' );
		$Line->where ( "id=$id" )->setField ( "status", "1" );
		$this->redirect ( "show_list" );
	}
	public function deleteall() {
		if (! isset ( $_POST ["deleteall"] )) {
			$this->error ( "至少选中一项！" );
		}
		$Line = M ( 'Line' );
		// $picpath = $Line->where("id=$id")->getField("picpath");
		foreach ( $_POST ["deleteall"] as $id ) {
			$Line->where ( "id=$id" )->delete ();
		}
		$this->success ( "删除成功", U ( "show_list" ) );
	}
	
	// 删除
	public function imgdeleteall() {
		$items = $_POST ['items'];
		$line_pic = M ( 'line_pic' );
		foreach ( $items as $k => $v ) {
			$list = $line_pic->where ( "id='$v'" )->find ();
			$pic = $_SERVER ['DOCUMENT_ROOT'] . __ROOT__ . $list ['pic_path'];
			if (! empty ( $list ['pic_path'] ) && is_file ( $pic )) {
				@unlink ( dirname ( $pic ) . "/" . basename ( $pic ) );
				@unlink ( dirname ( $pic ) . "/s_" . basename ( $pic ) );
				@unlink ( dirname ( $pic ) . "/m_" . basename ( $pic ) );
				@unlink ( dirname ( $pic ) . "/b_" . basename ( $pic ) );
			}
			$line_pic->where ( "id='$v'" )->delete ();
		}
		$this->success ( "删除成功" );
	}
	
	// 图片列表
	public function pic_list() {
		$LinePic = M ( "LinePic" );
		$line_id = $_GET ["line_id"];
		$map ["line_id"] = array (
				"eq",
				$line_id 
		);
		$list = $LinePic->where ( $map )->order ( "istitlepage,sort" )->select ();
		foreach ( $list as $k => $li ) {
			$patharr = explode ( "/", $li ["pic_path"] );
			// $patharr[count($patharr) - 1] = "m_" . $patharr[count($patharr) - 1];
			$patharr [count ( $patharr ) - 1] = $patharr [count ( $patharr ) - 1];
			$path = join ( "/", $patharr );
			$list [$k] = array_merge ( $list [$k], array (
					"m_picPath" => $path 
			) );
		}
		$this->assign ( "add_url", U ( 'line/pic_add', array (
				'line_id' => $line_id 
		) ) );
		$this->assign ( 'list', $list );
		$this->assign ( 'line_id', $line_id );
		$this->display ();
	}
	
	// 图片新增
	public function pic_add() {
		if (! isset ( $_POST ['save'] )) {
			$line_id = $_GET ["line_id"];
			$Line = M ( "Line" );
			
			$map ["id"] = array (
					"eq",
					$line_id 
			);
			$objLine = $Line->where ( $map )->find ();
			$this->assign ( 'line_id', $line_id );
			$this->assign ( 'objLine', $objLine );
			$this->display ();
		} else {
			$LinePic = M ( "LinePic" );
			$LinePic->create ();
			$LinePic->istitlepage = 2;
			$LinePic->pic_path = $_POST ['pic_front'];
			$LinePic->add ();
			$this->success ( "保存成功", U ( 'pic_list', array (
					'line_id' => $_GET ["line_id"] 
			) ) );
		}
	}
	
	// 图片编辑
	public function pic_edit() {
		if (! isset ( $_POST ['submit'] )) {
			$id = $_GET ['id'];
			$LinePic = M ( "LinePic" );
			$map ["id"] = array (
					"eq",
					$id 
			);
			$objLinePic = $LinePic->where ( $map )->find ();
			$this->assign ( 'id', $id );
			$this->assign ( 'objLinePic', $objLinePic );
			$this->display ();
		} else {
			$id = $_POST ['id'];
			$names = $_POST ['names'];
			$LinePic = M ( "LinePic" );
			$LinePic->create ();
			$LinePic->id = $id;
			$LinePic->names = $names;
			$LinePic->save ();
			$this->display ();
		}
	}
	
	// 图片删除
	public function pic_del() {
		$id = $_GET ['id'];
		$LinePic = M ( 'LinePic' );
		$picpath = $LinePic->where ( "id=$id" )->find ();
		$sizes = array (
				"s_",
				"m_",
				"b_",
				"" 
		);
		for($i = 0; $i < 4; $i ++) {
			$patharr = explode ( "/", $picpath ["pic_path"] );
			$patharr [count ( $patharr ) - 1] = $sizes [$i] . $patharr [count ( $patharr ) - 1];
			$path = join ( "/", $patharr );
			@unlink ( $_SERVER ['DOCUMENT_ROOT'] . __ROOT__ . $path );
		}
		$LinePic->where ( "id=$id" )->delete ();
		$this->success ( "保存成功", U ( 'pic_list', array (
				'line_id' => $_GET ["line_id"] 
		) ) );
	}
	
	// 设置为封面
	public function ajax_cover() {
		$id = $_GET ['id'];
		$istitlepage = $_GET ["istitlepage"];
		$LinePic = M ( 'LinePic' );
		$map ["id"] = array (
				"eq",
				$id 
		);
		$LinePic->where ( $map )->setField ( 'istitlepage', $istitlepage );
		echo 1;
		exit ();
	}
	
	// 线路价格列表
	public function price_list() {
		$line_price = M ( "LinePrice" );
		$line_info = M ( 'LineInfo' );
		$sel_numrange = $_POST ['sel_numrange'];
		// echo $sel_numrange;
		// exit();
		$id = $_GET ['line_id'] ? intval ( $_GET ['line_id'] ) : 0;
		
		// 基本价格
		$price_pt = $line_price->where ( "price_type=4 and line_id=" . $id )->find ();
		// 按星期价格
		$price_date = $line_price->where ( "price_type=3 and line_id=" . $id )->getField ( "price_date,RACKRATE,price_adult,price_children" );
		// 按阶段
		$price_stage = $line_price->where ( "price_type=2 and line_id=" . $id )->select ();
		// 按指定日期
		if ($sel_numrange != null) {
			$price_day = $line_price->where ( "price_type=1 and line_id=" . $id . " and numrange=" . $sel_numrange )->getField ( "price_date,RACKRATE,price_adult,price_children" );
			$price_day_json = $this->json_price_list ( $price_day );
		} else {
			$price_day = $line_price->where ( "price_type=1 and line_id=" . $id )->getField ( "price_date,RACKRATE,price_adult,price_children" );
			$price_day_json = $this->json_price_list ( $price_day );
		}
		// 费用说明
		$contain = $line_info->where ( "lid=" . $id )->find ();
		$this->assign ( "price_pt", $price_pt );
		$this->assign ( "price_date", $price_date );
		$this->assign ( "price_stage", $price_stage );
		$this->assign ( "price_day", $price_day );
		$this->assign ( "contain", $contain );
		$this->assign ( "price_day_json", $price_day_json );
		$this->assign ( "line_id", $id );
		$this->assign ( "sel_numrange", $sel_numrange );
		$this->assign ( "stage_data_html", preg_replace ( "/[\t\r\xc2\xa0]/", "", $this->fetch ( "stage_html" ) ) );
		$this->display ();
	}
	public function month_price_list() {
		$year = $_GET ['year'];
		$month = $_GET ['month'];
		$lineid = $_GET ['line_id'];
		$numrange = $_GET ['numrange1'];
		$price_type = 1;
		if ($numrange == 0) {
			$price_type = 2;
		} else {
			$price_type = 1;
		}
		$line_price = M ( "LinePrice" );
		$priceList = $line_price->where ( "year=" . $year . " and month='" . $month . "' and line_id=" . $lineid . " and numrange=" . $numrange . " and  price_type=" . $price_type )->select ();
		if ($priceList != null) {
			$this->ajaxReturn ( $priceList );
		} else {
			$this->ajaxReturn ( array () );
		}
		// 通过年月获取制定年月的价钱设置
	}
	public function month_price_del() {
		$year = $_POST ['year'];
		$month = $_POST ['month'];
		$lineid = $_POST ['line_id'];
		$numrange = $_POST ['numrange'];
		$seldays = $_POST ['seldays'];
		$seldayarray = explode ( ',', $seldays );
		
		//
		
		foreach ( $seldayarray as $val ) {
			$line_price = M ( "LinePrice" );
			$day = substr ( $val, 6, 2 );
			$line_price->where ( "year=" . $year . " and month='" . $month . "' and line_id=" . $lineid . " and numrange=" . $numrange . " and  price_type=1 and day=" . $day )->delete ();
			// $linePrice->delete ();
		}
		
		//$this->redirect ( "line/price_list" );
		$this->redirect ( "line/price_list",array('line_id'=>$lineid), 1,'页面跳转中~' );
		// 通过年月获取制定年月的价钱设置
	}
	public function price_update() {
		$seldays = $_POST ['seldays'];
		$seldayarray = explode ( ',', $seldays );
		// print_r($seldayarray[0]);
		// exit();
		// $linePrice->update_4 (); // 基本价格
		// $linePrice->update_3 (); // 星期价格
		// $linePrice->update_2 (); // 阶段价格
		// $linePrice->update_1 (); // 指定日期价格
		// 费用说明
		// $LineInfo = M ( "LineInfo" );
		// $LineInfo->where ( "lid=" . $_POST ["line_id"] )->save ( $_POST );
		$linePrice = D ( 'LinePrice' );
		foreach ( $seldayarray as $val ) {
			unset ( $linePrice->id );
			$linePrice->create ();
			if ($val == 0) {
				continue;
			}
			if ($linePrice->numrange == 0) { // numrange
				$linePrice->price_type = 2;
			} else {
				$linePrice->price_type = 1;
			}
			$linePrice->price_date = strtotime ( $val );
			$linePrice->day = substr ( $val, 6, 2 );
			$linePrice->line_id = $_POST ["line_id"];
			
			$linePrice->add ();
		}
		$this->redirect ( "line/price_list",array('line_id'=>$_POST ["line_id"]), 1,'页面跳转中~' );
	}
	
	// 线路订单
	public function order_list() {
		echo '受限于前台功能...';
		exit ();
	}
	
	// 异步加载目的地
	public function ajax_target() {
		$start = isset ( $_POST ["city_id"] ) ? $_POST ["city_id"] : 0;
		$type = isset ( $_POST ["target_type"] ) ? $_POST ["target_type"] : 0;
		$default = isset ( $_POST ["default"] ) ? $_POST ["default"] : 0;
		
		$map ['target.start_id'] = array (
				'eq',
				$start 
		);
		$map ['target.type_id'] = array (
				'eq',
				$type 
		);
		$linetarget = D ( "LineTarget" );
		$target_list = $linetarget->gettar ( $map );
		
		$this->assign ( "default", $default );
		$this->assign ( "target_list", $target_list );
		$data = $this->fetch ();
		$status = $target_list ? 1 : 0;
		$this->ajaxReturn ( $data, $map, $status );
	}
	public function sort_list() {
		$line = M ( "line" );
		foreach ( $_POST ["sort"] as $key => $val ) {
			$line->where ( "id={$key}" )->setField ( "sort", $val );
		}
		$this->redirect ( "show_list" );
	}
	private function json_price_list($arr) {
		$json_arr = array ();
		foreach ( $arr as $k => $v ) {
			$json_arr [date ( "Ymd", $k )] = array (
					$v ["RACKRATE"],
					$v ["price_adult"],
					$v ["price_children"] 
			);
		}
		$json_arr ['url'] = '';
		return json_encode ( $json_arr );
	}
	public function is_code() {
		$param = $_POST ["param"];
		$count = M ( "line" )->where ( array (
				"code" => $param 
		) )->count ();
		if ($count > 0) {
			$this->ajaxReturn ( array (
					"info" => "编号已经存在！",
					"status" => "n" 
			) );
		} else {
			$this->ajaxReturn ( array (
					"info" => "编号可以使用！",
					"status" => "y" 
			) );
		}
	}
	public function reset_sort() {
		$url = empty ( $_GET ['jumpurl'] ) ? 'line/show_list' : base64_decode ( $_GET ['jumpurl'] );
		$sort = $_POST ['sort'];
		$base_pos = $_POST ['base_pos'];
		echo $base_pos;
		$field = empty ( $_GET ['field'] ) ? 'sort' : $_GET ['field'];
		
		switch ($base_pos) {
			case "line" :
				$base_gg = 'line';
				break;
			case "line_topic_type" :
				$base_gg = 'line_topic_type';
				break;
			case "linetarget" :
				$base_gg = 'line_target';
				break;
			case "linetarget2" :
				$base_gg = 'line_target_topic';
				break;
			default :
				echo "排序出错";
				exit ();
		}
		$base = M ( $base_gg );
		foreach ( $sort as $k => $v ) {
			$base->where ( "id='{$k}'" )->setfield ( $field, $v );
		}
		$this->redirect ( $url );
	}
	
	// 图片列表
	public function tao_list() {
		$LineTao = M ( "LineTao" );
		$line_id = intval ( $_GET ["line_id"] );
		$map ["line_id"] = array (
				"eq",
				$line_id 
		);
		$list = $LineTao->where ( $map )->order ( "sort" )->select ();
		$this->assign ( 'list', $list );
		$this->assign ( 'line_id', $line_id );
		$this->display ();
	}
	
	// 图片新增
	public function tao_add() {
		if (! isset ( $_POST ['save'] )) {
			$line_id = $_GET ["line_id"];
			$Line = M ( "Line" );
			$map ["id"] = array (
					"eq",
					$line_id 
			);
			$objLine = $Line->where ( $map )->find ();
			$this->assign ( 'line_id', $line_id );
			$this->assign ( 'objLine', $objLine );
			$this->display ();
		} else {
			$LineTao = M ( "LineTao" );
			$LineTao->create ();
			$LineTao->add ();
			$this->success ( "保存成功", U ( 'tao_list', array (
					'line_id' => $_POST ["line_id"] 
			) ) );
		}
	}
	
	// 图片编辑
	public function tao_edit() {
		if (! isset ( $_POST ['save'] )) {
			$id = $_GET ['id'];
			$LineTao = M ( "LineTao" );
			$map ["id"] = array (
					"eq",
					$id 
			);
			$objLineTao = $LineTao->where ( $map )->find ();
			$this->assign ( 'id', $id );
			$this->assign ( 'objLineTao', $objLineTao );
			$this->display ();
		} else {
			$id = $_POST ['id'];
			$names = $_POST ['names'];
			$LineTao = M ( "LineTao" );
			$LineTao->create ();
			$LineTao->id = $id;
			$LineTao->names = $names;
			$LineTao->save ();
			$this->success ( "保存成功", U ( 'tao_list', array (
					'line_id' => $_POST ["line_id"] 
			) ) );
		}
	}
	
	// 图片删除
	public function tao_del() {
		$id = $_GET ['id'];
		$LineTao = M ( 'LineTao' );
		$LineTao->where ( "id=$id" )->delete ();
		$this->success ( "保存成功", U ( 'tao_list', array (
				'line_id' => $_GET ["line_id"] 
		) ) );
	}
}

?>