<?php
import ( "ORG.Util.Page" );
class viewpointtopicAction extends CommonAction {
	
	// 添加
	public function add() {
		if (empty ( $_POST )) {
			$types = $_GET ['types'];
			$this->assign ( 'types', $types );
			$this->display ();
		} else {
			$viewpointtopic = M ( 'viewpointtopic' );
			$viewpointtopic->create ();
			$viewpointtopic->names = $_POST ['names'];
			$viewpointtopic->code = $_POST ['code'];
			$viewpointtopic->sort = $_POST ['sort'];
			$viewpointtopic->citycode=$_POST ['citycode'];
			if($viewpointtopic->citycode=='0471'){
				$viewpointtopic->cityname='呼和浩特';
			}else if($viewpointtopic->citycode=='0479'){
				$viewpointtopic->cityname='锡林郭勒';
			}
			else if($viewpointtopic->citycode=='0483'){
				$viewpointtopic->cityname='额济纳';
			}
			else if($viewpointtopic->citycode=='0470'){
				$viewpointtopic->cityname='呼伦贝尔';
			}
			if ($viewpointtopic->add ()) {
				$this->success ( "添加成功", U ( 'show_list' ) );
			} else {
				$this->error ( "添加失败" );
			}
		}
	}
	
	// 删除
	public function del() {
		header ( 'Content-Type:text/html;charset=utf-8' );
		$code = $_GET ['code'];
		$viewpointtopic = M ( 'viewpointtopic' );
		$viewpointtopic->where ( "code='" . $code . "'" )->delete ();
		$this->success ( "删除成功", U ( 'show_list' ) );
	}
	
	// 全部列表
	public function show_list() {
		$viewpointtopic = M ( "viewpointtopic" );
		$count = $viewpointtopic->count ();
		$page = $this->pagebar ( $count );
		$list = $viewpointtopic->page ( $page )->order("sort")->select ();
		$this->assign ( 'list', $list );
		$this->display ();
	}
	public function deleteall() {
		if (! isset ( $_POST ["items"] )) {
			$this->error ( "至少选中一项！" );
		}
		$Line = M ( 'viewpointtopic' );
		// $picpath = $Line->where("id=$id")->getField("picpath");
		foreach ( $_POST ["items"] as $code ) {
			$Line->where ( "code='".$id."'" )->delete ();
		}
		$this->success ( "删除成功", U ( "show_list" ) );
	}
}

?>