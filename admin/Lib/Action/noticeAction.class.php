<?php

/**
 * 内容管理
 *
 * @author gemini
 */
class noticeAction extends CommonAction {

    public function notice() {
        $notice = M("notice");
        $condition = array();
        if ($_GET['title'] != "") {
            $condition["title"] = array('like', '%' . $_GET['title'] . '%');
            $this->assign('title', $_GET['title']);
        }
        $condition["status"] = 1;
        $count = $notice->where($condition)->count(); // 查询满足要求的总记录数
        $page = $this->pagebar($count); //设置分页导航条        
        $lists = $notice->where($condition)->page($page)->order('id desc')->select();

        $this->assign('lists', $lists);
        $this->display();
    }

    public function notice_add() {
        if ($_POST) {
            $notice = D("notice");
            if ($data=$notice->create()) {
            	$data['create_time'] = date('Y-m-d H:i:s');
                $id = $notice->add($data);
                $seo = D("seo");
                $seo->set_seo($id, $notice->getModelName());
                $this->success("添加成功", U("notice"));
            } else {
                $this->error($notice->getError());
            }
        } else {
            $this->display();
        }
    }

    public function notice_edit() {
        $id = $_GET["id"];
        if (isset($_GET["id"]))
            unset($_GET["id"]);
        $notice = D("notice");
        $notice_info = $notice->where("id=$id")->find();
        if (!$notice_info) {
            $this->error("公告不存在", U("notice", $_GET));
            exit;
        }
        $seo = D("seo");
        if ($_POST) {
            $_POST["id"] = $id;
            if ($data = $notice->create()) {
                $notice->save($data);
                $seo->set_seo($id, $notice->getModelName());
                $this->success("修改成功", U("notice"));
            } else {
                $this->error($notice->getError());
            }
        } else {
            $this->assign("notice_info", $notice_info);
            $this->assign("seo_info", $seo->get_seo($id, $notice->getModelName()));
            $this->display();
        }
    }

    public function notice_del() {
        $id = $_GET["id"];
        if (isset($_GET["id"]))
            unset($_GET["id"]);
        $notice = M("notice");
        $notice->where("id=$id")->delete();
        $seo = M("seo");
        $seo->where("relate_id=$id and relate_table='" . $notice->getModelName() . "'")->delete();
        $this->redirect("notice");
    }

public function deleteall() {
	
		if (isset($_POST['dosubmit'])) {
			$done = false;
			$Article = M("Notice");
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
    
    
    
}
	





?>