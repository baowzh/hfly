<?php

import("ORG.Util.Page");
import("ORG.Net.UploadFile");
import("@.ORG.file");

class advtextAction extends CommonAction{
    
    // 文字广告列表
    public function lists(){
        $advert = M('advert');
        $advertArea = M('advertArea');        
        $count = $advert->where("types=1")->count();
        $page = $this->pagebar($count);       
        $lists = $advert->field("*,advert.sort f_sort,advert.id aid")
                ->table($advert->getTableName()." advert")
                ->join(M("file_manager")->getTableName()." manager on advert.pic = manager.id")
                ->where("types=1")
                ->page($page)->order('advert.area_id asc,advert.sort asc,advert.id desc')->select();
        foreach ($lists as $k => $v) {           
            $lists[$k]['area'] = $advertArea->where("id={$v['area_id']}")->getField('names');
        }        
        $this->assign('lists', $lists);
        $this->display();
    }
    
    // 文字广告添加
    public function add() {
        if (!$_POST) {
            $advertArea = M('advert_area');
            $arr = $advertArea->select();           
            $this->assign('lists', $arr);
            $this->display();
        } else {
            $advert = D('advert');
            if ($iuoi = $advert->create()) {
                $advert->types=1;
                $advert->add();
                $this->success('添加成功', U("lists"));
            } else {
                $this->error('添加失败.' . $advert->getError(), U("lists"));
            }
        }
    }
    //删除
	public function del() {
        $advert = M('advert');
        $fileManager = M('fileManager');
        $id = $_GET['id'];
        $objadvert = $advert->where("id='$id'")->find();
        $path = $fileManager->where("id={$objadvert['pic']}")->getField('path');
        @ unlink(ROOT_PATH . "." . $path);
        @ unlink(ROOT_PATH . "." . dirname($path) . "/s_" . basename($path));
        @ unlink(ROOT_PATH . "." . dirname($path) . "/m_" . basename($path));
        $fileManager->where("id={$objadvert['pic']}")->delete();
        if ($advert->where("id='$id'")->delete()) {
            $this->success('删除成功', U("lists"));
        } else {
            $this->error('删除失败.' . $advert->getError());
        }
    }
    
public function deleteall() {
		if (isset($_POST['dosubmit'])) {
			$done = false;
			$Article = M("Advert");
			$count = $Article->count();
			$id = $Article->getField("id", true);
			for ($i = 0; $i < $count; $i++) {
				if ($_POST["items_" . $id[$i]]) {
					$picpath = $Article->where("id=" . $id[$i])->getField("pic");
					$Article->where("id=" . $id[$i])->delete();
					@unlink($_SERVER['DOCUMENT_ROOT'] . __ROOT__ . $picpath);
					$done = true;
				}
			}
			if ($done)
				$this->success("删除成功！");
			else
				$this->error("请勾选至少1项。");
		}
		else {
			$this->error("请至少选择一项");
		}
	}
    
    public function edit() {
        if (!$_POST) {
            $advert = M('advert');
            $advertArea = M('advertArea');
            $id = $_GET['id'];
            $lists = $advert->where("id='$id'")->find();
            $arr = $advertArea->select();           
            $this->assign('lists', $lists);
            $this->assign('areas', $arr);
            $this->assign('img', $file);
            $this->display();
        } else {
            $advert = D('advert');
            if ($data = $advert->create()) {
                $advert->save($data);
                $this->success('编辑成功', U("lists"));
            } else {
                $this->error('编辑失败.' . $advert->getError());
            }
        }
    }

    // 文字广告删除
    public function ajax_del(){
        $id = $_GET['id'];
       
        $Adv = M("advert");
//        $picpath = $Adv->where("id=$id")->getField("picpath");
		 var_dump($id);exit;
        $Adv->where("id=" . $id . " and type=1")->delete();
//        
//        @unlink(C('ROOT')."/web/File/adv_pic/".$picpath);
       
    }
}

?>
