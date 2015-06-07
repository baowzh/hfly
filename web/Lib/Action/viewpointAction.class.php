<?php
class viewpointAction extends CommonAction {
	public function _initialize() {
		$authentic = array (
				"order",
				"order_success" 
		);
		in_array ( ACTION_NAME, $authentic ) ? $this->authentic = 1 : $this->authentic = 0;
		parent::_initialize ();
	}
	public function detail() {
		$id = $_GET ["id"] ? intval ( $_GET ["id"] ) : 0;
		// 景点信息
		$info = M ( "viewpoint" )->where ( "id='$id'" )->find ();
		if ($info ['position'] != NULL) {
			$position = explode ( ",", $info ['position'] );
			$info ['location_x'] = $position [0];
			$info ['location_y'] = $position [1];
		}
		$this->assign ( "viewpoint", $info );
		$this->display ();
	}
	public function index() {
		$areaid = $_GET ['areaid'];
		$topiccode = $_GET ['topiccode'];
		$View = M ( "Viewpoint" );
		$where = '1=1';
		if (isset ( $_GET ["areaid"] )) {
			$where = "1=1 and city_id='" . $_GET ["areaid"] . "'";
		} else {
			$where = '1=1';
		}
		if (isset ( $_GET ["topiccode"] )) {
			$where = $where . " and topiccode='".$topiccode."'";
		}
		$count = $View->where ( $where )->count ();
		$p = isset ( $_GET ['p'] ) ? intval ( $_GET ['p'] ) : 1; // 获取分页页码
		class_exists ( "Page" ) or import ( "ORG.Util.Page" );
		$Page = new Page ( $count, 9 );
		$show = $Page->show ();
		
		$list = $View->where ( $where )->order ( 'sort,id desc' )->limit ( $Page->firstRow . "," . $Page->listRows )->select ();
		$this->assign ( 'list', $list );
		$this->assign ( "page", $show );
		$this->display ();
	}
}
