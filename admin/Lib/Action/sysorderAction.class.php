<?php
import ( "ORG.Util.Page" );
class sysorderAction extends CommonAction {
	
	// 添加
	public function add() {
		if (! $_POST) {
		$this->display ();
		}else{
			$SysOrder = D( 'SysOrder' );
			if ($iuoi = $SysOrder->create ()) {
				$SysOrder->add ($iuoi);
				$this->redirect ( "show_list" );
			}
			
		}
		
	}
	
	// 点击了列表下方的删除按钮之后
	public function deleteall() {
		if (! isset ( $_POST ["deleteall"] )) {
			$this->error ( "至少选中一项！" );
		}
		$sysOrder = M ( "SysOrder" );
		foreach ( $_POST ["deleteall"] as $id ) {
			$sysOrder->where ( "id=$id" )->delete ();
		}
		$this->success ( "删除成功", U ( "show_list" ) );
	}
	
	// 删除
	public function ajax_del() {
		header ( 'Content-Type:text/html;charset=utf-8' );
		$id = $_GET ['id'];
		$SysOrder = M ( 'SysOrder' );
		$SysOrder->where ( "id=$id" )->delete ();
		echo 1;
		exit ();
	}
	
	// 全部列表
	public function show_list() {
		$SysOrder = M ( "SysOrder" );
		$list = $SysOrder->select ();
		$this->assign ( 'list', $list );
		$this->display ();
	}
}
