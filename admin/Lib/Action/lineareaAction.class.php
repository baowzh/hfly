<?php
import ( "ORG.Util.Page" );
import ( "ORG.Net.UploadFile" );
import ( "@.ORG.file" );
class lineareaAction extends CommonAction {
	public function lists() {
		$lineArea = M ( 'LineArea' );
		$lists = $lineArea->select ();
		foreach ( $lists as $k => $v ) {
			$lists [$k] ['url'] = __ROOT__ . $lists [$k] ['url'];
		}
		$this->assign ( 'lists', $lists );
		$this->display ();
	}
	public function add() {
		if (! $_POST) {
			$LineArea = M ( 'LineArea' );
			$arr = $LineArea->select ();
			$this->assign ( 'lists', $arr );
			$this->display ();
		} else {
			$lineArea = D ( 'LineArea' );
			if ($iuoi = $lineArea->create ()) {
				$lineArea->add ( $iuoi );
				$this->success ( '添加成功', U ( "lists" ) );
			} else {
				$this->error ( '添加失败.' . $lineArea->getError (), U ( "lists" ) );
			}
		}
	}
	public function edit() {
		if (! $_POST) {
			$lineArea = M ( 'LineArea' );
			$fileManager = M ( "fileManager" );
			$id = $_GET ['id'];
			$lists = $lineArea->where ( "id='$id'" )->find ();
			$file = $fileManager->where ( "id='{$lists['imgid']}'" )->find ();
			$file ['path'] = __ROOT__ . $file ['path'];
			$this->assign ( 'lists', $lists );
			$this->assign ( 'img', $file );
			$this->display ();
		} else {
			$lineArea = M ( 'LineArea' );
			if ($data = $lineArea->create ()) {
				// print_r ( $data );
				// exit();
				/*
				 * $lineArea->where ( 'id=' . $_POST ['id'] )->setField ( 'imgurl', $_POST ['imgurl'] );
				 * $lineArea->where ( 'id =' . $_POST ['id'] )->setField ( 'name', $_POST ['name'] );
				 * $lineArea->where ( 'id' . $_POST ['id'] )->setField ( 'code', $_POST ['code'] );
				 * $lineArea->where ( 'id' . $_POST ['id'] )->setField ( 'imgid', $_POST ['imgid'] );
				 */
				$lineArea->save ( $data );
				$this->success ( '编辑成功', U ( "lists" ) );
			} else {
				$this->error ( '编辑失败.' . $lineArea->getError () );
			}
		}
	}
	public function del() {
		$LineArea = M ( 'LineArea' );
		$fileManager = M ( 'fileManager' );
		$id = $_GET ['id'];
		$objadvert = $LineArea->where ( "id='$id'" )->find ();
		$path = $fileManager->where ( "id={$objadvert['imgid']}" )->getField ( 'path' );
		@ unlink ( ROOT_PATH . "." . $path );
		@ unlink ( ROOT_PATH . "." . dirname ( $path ) . "/s_" . basename ( $path ) );
		@ unlink ( ROOT_PATH . "." . dirname ( $path ) . "/m_" . basename ( $path ) );
		$fileManager->where ( "id={$objadvert['imgid']}" )->delete ();
		if ($LineArea->where ( "id='$id'" )->delete ()) {
			$this->success ( '删除成功', U ( "lists" ) );
		} else {
			$this->error ( '删除失败.' . $LineArea->getError () );
		}
	}
	public function linearea_lists() {
		$p = isset ( $_GET ['p'] ) ? intval ( $_GET ['p'] ) : 0;
		$advertArea = M ( 'advertArea' );
		$count = $advertArea->count ();
		$list = $advertArea->page ( "$p," . PAGESIZE )->order ( 'id desc' )->select ();
		$this->pagebar ( $count );
		$this->assign ( 'list', $list );
		$this->display ();
	}
	public function linearea_add() {
		if (! $_POST) {
			$this->display ();
		} else {
			$advertArea = D ( 'advertArea' );
			if ($data = $advertArea->create ()) {
				$advertArea->add ();
				$this->success ( '添加成功', U ( "area_lists" ) );
			} else {
				$this->error ( '添加失败.' . $advertArea->getError () );
			}
		}
	}
	public function linearea_edit() {
		if (! $_POST) {
			$advertArea = M ( 'advertArea' );
			$id = $_GET ['id'];
			$list = $advertArea->where ( "id='$id'" )->find ();
			$this->assign ( 'list', $list );
			$this->display ();
		} else {
			$advertArea = D ( 'advertArea' );
			if ($data = $advertArea->create ()) {
				$advertArea->save ( $data );
				$this->success ( '编辑成功', U ( "area_lists" ) );
			} else {
				$this->error ( '编辑失败.' . $advertArea->getError () );
			}
		}
	}
	public function linearea_del() {
		$advertArea = M ( 'advertArea' );
		$id = $_GET ['id'];
		if ($advertArea->where ( "id='$id'" )->delete ()) {
			$this->success ( '删除成功', U ( "area_lists" ) );
		} else {
			$this->error ( '删除失败.' . $advertArea->getError () );
		}
	}
}
?>
