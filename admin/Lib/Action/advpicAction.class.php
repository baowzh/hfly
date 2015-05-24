<?php
import ( "ORG.Util.Page" );
import ( "ORG.Net.UploadFile" );
import ( "@.ORG.file" );
class advpicAction extends CommonAction {
	public function lists() {
		$advert = M ( 'advert' );
		$advertArea = M ( 'advertArea' );
		$count = $advert->where ( "types=2" )->count ();
		$page = $this->pagebar ( $count );
		$lists = $advert->field ( "*,advert.sort f_sort,advert.id aid" )->table ( $advert->getTableName () . " advert" )->join ( M ( "file_manager" )->getTableName () . " manager on advert.pic = manager.id" )->where ( "types=2" )->page ( $page )->order ( 'advert.area_id asc,advert.sort asc,advert.id desc' )->select ();
		foreach ( $lists as $k => $v ) {
			$lists [$k] ['path'] = __ROOT__ . $lists [$k] ['path'];
			$lists [$k] ['area'] = $advertArea->where ( "id={$v['area_id']}" )->getField ( 'names' );
		}
		
		$this->assign ( 'lists', $lists );
		$this->display ();
	}
	public function add() {
		if (! $_POST) {
			$advertArea = M ( 'advert_area' );
			$arr = $advertArea->select ();
			$this->assign ( 'lists', $arr );
			$this->display ();
		} else {
			$advert = D ( 'advert' );
			if ($iuoi = $advert->create ()) {
				$advert->types = 2;
				if ($advert->areaid = '0471') {
					$advert->areaname = '呼和浩特';
				} else if ($advert->areaid = '0470') {
					$advert->areaname = '呼伦贝尔';
				} else if ($advert->areaid = '0479') {
					$advert->areaname = '锡林郭勒盟';
				} else if ($advert->areaid = '0483') {
					$advert->areaname = '额济纳';
				}
				$advert->add ();
				$this->success ( '添加成功', U ( "lists" ) );
			} else {
				$this->error ( '添加失败.' . $advert->getError (), U ( "lists" ) );
			}
		}
	}
	public function edit() {
		if (! $_POST) {
			$advert = M ( 'advert' );
			$advertArea = M ( 'advertArea' );
			$fileManager = M ( "fileManager" );
			
			$id = $_GET ['id'];
			$lists = $advert->where ( "id='$id'" )->find ();
			$arr = $advertArea->select ();
			$file = $fileManager->where ( "id='{$lists['pic']}'" )->find ();
			$file ['path'] = __ROOT__ . $file ['path'];
			$this->assign ( 'lists', $lists );
			$this->assign ( 'areas', $arr );
			$this->assign ( 'img', $file );
			$this->display ();
		} else {
			$advert = D ( 'advert' );
			if ($data = $advert->create ()) {
				if ($advert->areaid = '0471') {
					$advert->areaname = '呼和浩特';
				} else if ($advert->areaid = '0470') {
					$advert->areaname = '呼伦贝尔';
				} else if ($advert->areaid = '0479') {
					$advert->areaname = '锡林郭勒盟';
				} else if ($advert->areaid = '0483') {
					$advert->areaname = '额济纳';
				}
				$advert->save ( $data );
				$this->success ( '编辑成功', U ( "lists" ) );
			} else {
				$this->error ( '编辑失败.' . $advert->getError () );
			}
		}
	}
	public function del() {
		$advert = M ( 'advert' );
		$fileManager = M ( 'fileManager' );
		$id = $_GET ['id'];
		$objadvert = $advert->where ( "id='$id'" )->find ();
		$path = $fileManager->where ( "id={$objadvert['pic']}" )->getField ( 'path' );
		@ unlink ( ROOT_PATH . "." . $path );
		@ unlink ( ROOT_PATH . "." . dirname ( $path ) . "/s_" . basename ( $path ) );
		@ unlink ( ROOT_PATH . "." . dirname ( $path ) . "/m_" . basename ( $path ) );
		$fileManager->where ( "id={$objadvert['pic']}" )->delete ();
		if ($advert->where ( "id='$id'" )->delete ()) {
			$this->success ( '删除成功', U ( "lists" ) );
		} else {
			$this->error ( '删除失败.' . $advert->getError () );
		}
	}
	public function area_lists() {
		$p = isset ( $_GET ['p'] ) ? intval ( $_GET ['p'] ) : 0;
		$advertArea = M ( 'advertArea' );
		$count = $advertArea->count ();
		$list = $advertArea->page ( "$p," . PAGESIZE )->order ( 'id desc' )->select ();
		$this->pagebar ( $count );
		$this->assign ( 'list', $list );
		$this->display ();
	}
	public function area_add() {
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
	public function area_edit() {
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
	public function area_del() {
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
