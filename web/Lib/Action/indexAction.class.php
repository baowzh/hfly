<?php
class indexAction extends CommonAction {
	protected $authentic = 0;
	public function _initialize() {
		C ( "TOKEN_ON", false );
		parent::_initialize ();
	}
	public function index() {
		// 网站公告
		$areaid = $_GET ['areaid'];
		$time = time ();
		$notice_list = M ( "notice" )->cache ( "index/index/notice_list", 600 )->where ( "status=1 and (start_time is null or start_time<=$time) and (end_time is null or end_time>=$time)" )->order ( "sort asc ,id desc" )->limit ( 8 )->select ();
		$this->assign ( "notice_list", $notice_list );
		
		$Viewpoint = M ( "Viewpoint" );
		if (isset ( $_GET ["areaid"] )) {
			$areaid = $_GET ['areaid'];
			$this->assign ( 'areaid', $areaid );
			$this->assign ( 'areaid1', $areaid );
		} else {
			$areaid = "0471";
			$this->assign ( 'areaid', $areaid );
			$this->assign ( 'areaid1', $_GET ['areaid'] );
		}
		$pointlist = $Viewpoint->where ( "pic != '' and  city_id='" . $areaid . "'" )->order ( 'sort,id desc' )->limit ( 0, 6 )->select ();
		$this->assign ( 'pointlist', $pointlist );
		
		$article = M ( "Article" );
		$Articlelist = $article->where("cid<>'7' and cid<>'9' and cid<>'10'" )->order ( 'sort,id desc' )->limit ( 18 )->select ();
		$this->assign ( 'Articlelist', $Articlelist );
		$mod_Line = M ( "Line" );
		
		$Line1 = $mod_Line->where ( "line_type = '1' and  linebelongto=" . $areaid )->order ( 'sort,id desc' )->limit ( 2 )->select ();
		$this->assign ( 'Line1', $Line1 );
		$Line11 = $mod_Line->where ( "line_type = '1' and  linebelongto=" . $areaid )->order ( 'id desc' )->limit ( 2 )->select ();
		$this->assign ( 'Line11', $Line11 );
		
		$Line2 = $mod_Line->where ( "line_type = '2' and  linebelongto=" . $areaid )->order ( 'sort,id desc' )->limit ( 2 )->select ();
		$this->assign ( 'Line2', $Line2 );
		$Line22 = $mod_Line->where ( "line_type = '2' and  linebelongto=" . $areaid )->order ( 'id desc' )->limit ( 2 )->select ();
		$this->assign ( 'Line22', $Line22 );
		
		$Line3 = $mod_Line->where ( "line_type = '3' and  linebelongto=" . $areaid )->order ( 'sort,id desc' )->limit ( 2 )->select ();
		$this->assign ( 'Line3', $Line3 );
		$Line33 = $mod_Line->where ( "line_type = '3'  and  linebelongto=" . $areaid )->order ( 'id desc' )->limit ( 2 )->select ();
		$this->assign ( 'Line33', $Line33 );
		
		$Line4 = $mod_Line->where ( "line_type = '4'  and  linebelongto=" . $areaid )->order ( 'sort,id desc' )->limit ( 2 )->select ();
		$this->assign ( 'Line4', $Line4 );
		$Line44 = $mod_Line->where ( "line_type = '4'  and  linebelongto=" . $areaid )->order ( 'id desc' )->limit ( 2 )->select ();
		$this->assign ( 'Line44', $Line44 );
		// 获取要滚动的常规团线路列表
		$normalline = $mod_Line->where ( "line_type = '3' and  linebelongto='" . $areaid . "'" )->order ( 'sort,id desc' )->limit ( 12 )->select ();
		$this->assign ( 'normalline', $normalline );
		$latercounsel = session ( 'latercounsel' );
		session ( 'areaid', $areaid );
		$this->assign ( 'latercounsel', $latercounsel );
		$property = $mod_Line->where ( "property = '4'" )->order ( 'sort,id desc' )->limit ( 4 )->select ();
		$this->assign ( 'property', $property );
		// 获取民族风情区的文章列表
		$lmwy = "lmwy";
		$cynmg = "cynmg";
		$swdxyy = "swdxyy";
		$mzfq = "mzfq";
		$cygjmhnm = "cygjmhnm";
		$wmlx = "wmlx";
		$lmwyi = $article->join ( M ( 'article_section' )->getTableName () . " article_section" . ' on article_section.id=cid' )->where ( "article_section.e_names='{$lmwy}'" )->order ( 'add_time' )->limit ( 1 )->select ();
		$this->assign ( 'lmwyi', $lmwyi );
		$cynmgi = $article->join ( M ( 'article_section' )->getTableName () . " article_section" . ' on article_section.id=cid' )->where ( "article_section.e_names='{$cynmg}'" )->order ( 'add_time' )->limit ( 1 )->select ();
		$this->assign ( 'cynmgi', $cynmgi );
		$swdxyyi = $article->join ( M ( 'article_section' )->getTableName () . " article_section" . ' on article_section.id=cid' )->where ( "article_section.e_names='{$swdxyy}'" )->order ( 'add_time' )->limit ( 1 )->select ();
		$this->assign ( 'swdxyyi', $swdxyyi );
		$mzfqi = $article->join ( M ( 'article_section' )->getTableName () . " article_section" . ' on article_section.id=cid' )->where ( "article_section.e_names='{$mzfq}'" )->order ( 'add_time' )->limit ( 1 )->select ();
		$this->assign ( 'mzfqi', $mzfqi );
		$cygjmhnmi = $article->join ( M ( 'article_section' )->getTableName () . " article_section" . ' on article_section.id=cid' )->where ( "article_section.e_names='{$cygjmhnm}'" )->order ( 'add_time' )->limit ( 1 )->select ();
		$this->assign ( 'cygjmhnmi', $cygjmhnmi );
		$wmlxi = $article->join ( M ( 'article_section' )->getTableName () . " article_section" . ' on article_section.id=cid' )->where ( "article_section.e_names='{$wmlx}'" )->order ( 'add_time' )->limit ( 1 )->select ();
		$this->assign ( 'wmlxi', $wmlxi );
		// 自定义订单
		// 获取旅游咨询文章列表
		$lvzx = $article->join( M ( 'article_section' )->getTableName () . " article_section" . ' on article_section.id=cid')->field( "jee_article.*")->where("article_section.e_names='lvzx'")->order ( 'add_time' )->limit ( 18 )->select ();
		$this->assign ( 'lvzx', $lvzx );
		$LineOrder = M ( 'LineOrder' );
		$realorder = $LineOrder->field ( " CONCAT(SUBSTR(name from 1 for 1),'**') name,pnumber pcount,cnumber ccount,lcode,orderdate" )->order ( " orderdate desc" )->limit ( 8 )->select ();
		$this->assign ( 'realorder', $realorder );
		$sysOrder = M ( 'SysOrder' );
		$orderlist = $sysOrder->order ( 'orderdate desc' )->limit ( 14 - count ( $realorder ) )->select ();
		$this->assign ( 'orderlist', $orderlist );
		$this->display ();
	}
	
	// 异步读取目的地城市
	public function ajax_target() {
		$cid = isset ( $_GET ["cid"] ) ? intval ( $_GET ["cid"] ) : 0;
		if ($cid > 0) {
			$line_type = M ( 'LineType' );
			$line_topic = M ( 'LineTargetTopic' );
			$line_target = D ( 'TargetView' );
			$types = $line_type->order ( 'sort' )->select ();
			$target = array ();
			if ($types) {
				$result = array ();
				foreach ( $types as $vv ) {
					$topic_list = $line_topic->getField ( "id,id as id1", "start_id=" . $cid . " and type_id=" . $vv ["id"] );
					$map ["Target.topic_id"] = array (
							"in",
							$topic_list 
					);
					$result = $line_target->where ( $map )->Distinct ( true )->select ();
					
					if ($result) {
						$target [] = array (
								"type" => $vv ["names"],
								"result" => $result 
						);
					}
				}
			}
			$this->assign ( "target", $target );
			$data = $this->fetch ();
			$this->ajaxReturn ( $data, "", $data ? 1 : 0 );
		}
	}
	protected function target_city($types = 'LINE', $limit = 12) {
		$city_belong = M ( "city_belong" )->getTableName () . " belong";
		$area = M ( "area" )->getTableName () . " area";
		$target_city = M ()->cache ( "target_city_12_$types", 0 )->table ( $city_belong )->join ( $area . " on area.id=belong.cid" )->where ( "belong.types ='$types'" )->order ( "belong.sort,area.pid" )->limit ( $limit )->getField ( "belong.cid,belong.id,area.pid,area.names,area.names_en" );
		
		if ($types == 'LINE')
			$this->assign ( "target_city", $target_city );
		return $target_city;
	}
	
	// 按线路类型查找目的地
	public function line_target($types) {
		$start_id = $this->tVar ["currentCity"] ["id"];
		$line_targer = M ( "line_target" );
		$line_targer_table = $line_targer->getTableName () . ' target';
		$area_table = M ( "area" )->getTableName () . ' area';
		$target_type = array ();
		$where ['target.start_id'] = $start_id;
		foreach ( $types as $type ) {
			$where ['target.type_id'] = $type ['id'];
			$target_type [$type ['id']] = $line_targer->table ( $line_targer_table )->join ( $area_table . ' on target.area_id=area.id' )->where ( $where )->field ( 'target.*,area.names areanames' )->select ();
			$types_names [$type ['id']] = $type ['names'];
		}
		$this->assign ( "target_type", $target_type );
		$this->assign ( "types_names", $types_names );
	}
	public function latercounsel() {
		$latercounsel = isset ( $_GET ["latercounsel"] ) ? intval ( $_GET ["latercounsel"] ) : 0;
		session ( 'latercounsel', $latercounsel );
		echo $latercounsel;
	}
}

?>