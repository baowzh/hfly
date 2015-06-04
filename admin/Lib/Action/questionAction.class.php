<?php

/**
 * 客户留言管理
 *
 * @author gemini
 */
class questionAction extends CommonAction {
	public function show_list() {
		$lineque = M ( "line_que" );
		$condition ["status"] = 1;
		$count = $lineque->join ( M ( 'line' )->getTableName () . " line" . ' on line.id=line_id' )->field("line_que.*")->count (); // 查询满足要求的总记录数
		$page = $this->pagebar ( $count ); // 设置分页导航条
		$lists = $lineque->page ( $page )->order ( 'publish_time desc' )->select ();
		$this->assign ( 'lists', $lists );
		$this->display ();
	}
	public function question_edit() {
		$id = $_GET ["id"];
		if (isset ( $_GET ["id"] ))
			unset ( $_GET ["id"] );
		$lineque = D ( "line_que" );
		$lineque_info = $lineque->where ( "id=$id" )->find ();
		if (! $lineque_info) {
			$this->error ( "留言信息不存在", U ( "question", $_GET ) );
			exit ();
		}
		if ($_POST) {
			$_POST ["id"] = $id;
			if ($data = $lineque->create ()) {
				$lineque->save ( $data );
				$this->success ( "修改成功", U ( "question" ) );
			} else {
				$this->error ( $notice->getError () );
			}
		} else {
			$this->assign ( "lineque_info", $lineque_info );
			$this->display ();
		}
	}
	public function question_del() {
		$id = $_GET ["id"];
		if (isset ( $_GET ["id"] ))
			unset ( $_GET ["id"] );
		$lineque = M ( "line_que" );
		$lineque->where ( "id=$id" )->delete ();
		$this->redirect ( "show_list" );
	}
	/*
	 * public function deleteall() {
	 * if (isset ( $_POST ['dosubmit'] )) {
	 * $done = false;
	 * $Article = M ( "Notice" );
	 * $count = $Article->count ();
	 * $id = $Article->getField ( "id", true );
	 * for($i = 0; $i < $count; $i ++) {
	 * if ($_POST ["items_" . $id [$i]]) {
	 * $picpath = $Article->where ( "id=" . $id [$i] )->getField ( "pic" );
	 * $Article->where ( "id=" . $id [$i] )->delete ();
	 * @unlink ( $_SERVER ['DOCUMENT_ROOT'] . __ROOT__ . $picpath );
	 * $done = true;
	 * }
	 * }
	 * if ($done)
	 * $this->success ( "删除成功！" );
	 * else
	 * $this->error ( "请勾选至少1项。" );
	 * } else {
	 * $this->error ( "请至少选择一项" );
	 * }
	 * }
	 */
}

?>