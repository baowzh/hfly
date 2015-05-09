<?php

class articleAction extends CommonAction {

	protected $authentic = 0; //是否开启用户认证，0：不开启，1：开启

	public function detail() {
		$id = (isset($_GET["id"])) ? $_GET["id"] : 0;

		//生成文章分类列表
		$sec = M("ArticleSection");
		$list = $sec->where("pid=0 AND status=1")->order("id asc")->select();
		$this->assign("list", $list);

		if ($id > 0) {
			//获取文章内容
			$art = M("Article");
			$content = M()->table($art->getTableName() . " art")
					 ->join($sec->getTableName() . " sec ON art.cid = sec.id")
					 ->where("art.id=$id AND art.status=1")
					 ->field("art.*, sec.id as Section_id")
					 ->find();
			$art->where("id={$content['id']}")->setInc("hits", 1);
		} else {
			//获取文章内容
			$map = (isset($_GET["detail"])) ? "sec.id=" . $_GET["detail"] : "sec.id > 0";
			$art = M("Article");
			$content = M()->table($art->getTableName() . " art")
					 ->join($sec->getTableName() . " sec ON art.cid = sec.id")
					 ->where($map . " AND art.status=1")
					 ->field("art.*, sec.model, sec.id as Section_id")
					 ->order("sec.id asc")
					 ->find();
			//查不到内容（$content 为空）或为单页模型，则获取文章列表
			if ($content == null)
				$this->articelList($_GET["detail"]);
			elseif ($content["model"] == 0)
				$this->articelList($content["Section_id"]);
			else
				$art->where("id=" . $content["id"])->setInc("hits", 1);
		}

		$this->assign("content", $content);
		$this->assign("detailtype", 0);
		$this->display();
	}

	//生成文章列表
	private function articelList($detail_id) {
		$art = M("Article");

		$count = $art->where("cid=$detail_id AND status=1")->count();
		$page = $this->pagebar($count);

		$content = $art->where("cid=$detail_id AND status=1")->page($page)->order("id desc")->select();
		$title = M("ArticleSection")->where("id=$detail_id AND status=1")->getField("names");

		$this->assign("title", $title);
		$this->assign("detail_id", $detail_id);
		$this->assign("content", $content);
		$this->display("articel_list");
		exit;
	}

	//公告展示
	public function notice() {
		$id = (isset($_GET["id"])) ? $_GET["id"] : 0;
		$list = array(array("id" => "1", "names" => "网站公告"));
		$this->assign("list", $list);

		$not = M("Notice");
		$content = $not->where("id=$id")->find();
		$not->where("id=$id")->setInc("hits", 1);

		if (empty($content)) {
			$count = $not->count();
			$page = $this->pagebar($count);
			$content = $not->page($page)->order("id desc")->select();

			$this->assign("title", $list[0]["names"]);
			$this->assign("detail_id", $list[0]["id"]);
			$this->assign("content", $content);
			$this->display("notice_list");
			exit;
		}

		$content["Section_id"] = $list[0]["id"];
		$this->assign("content", $content);
		$this->assign("detailtype", 1);
		$this->display("detail");
	}

}
