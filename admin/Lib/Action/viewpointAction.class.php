<?php

import("ORG.Util.Page");
import("ORG.Net.UploadFile");
import("@.ORG.file");

class viewpointAction extends CommonAction {

	//添加
	public function add() {
		if (!isset($_POST['submit'])) {
			//所属地区列表
			$city_belong = M('city_belong');
			$list_city_id = $city_belong->join(C('DB_PREFIX') . "area" . C('DB_SUFFIX') . " ON " . C('DB_PREFIX') . "city_belong" . C('DB_SUFFIX') . ".cid=" . C('DB_PREFIX') . "area" . C('DB_SUFFIX') . ".id")
			->where("types='Viewpoint'")
			->field("*," . C('DB_PREFIX') . "city_belong" . C('DB_SUFFIX') . ".sort as sort")
			->select();
			// 获取景点分组
			$viewpointtopics=M("viewpointtopic")->select();
			$this->assign('list_city_id', $list_city_id);
			$this->assign('list_view_type', $list_view_type);
			$this->assign('list_fit_person', $list_fit_person);
			$this->assign('viewpointtopics', $viewpointtopics);
			$this->display();
		} else {
			$Viewpoint = M('Viewpoint');
			$Viewpoint->create();
			$Viewpoint->names = $_POST['names'];
			if ($_POST['SEO'] != '') {
				$seo_info = M('seo_info');
				$seo_info->create();
				$seo_info->title = $_POST['title'];
				$seo_info->keyword = $_POST['keyword'];
				$seo_info->detail = $_POST['detail'];
				$Viewpoint->seo_id = $seo_info->add();
			}

			if ($_POST['location_x'] != '' && $_POST['location_y'] != '') {
				$Viewpoint->position = "{$_POST['location_x']},{$_POST['location_y']}";
			}
			$Viewpoint->city_id = $_POST['city_id'];
			$Viewpoint->rank = $_POST['rank'];
			
			$Viewpoint->pic = $_POST['pic_front'];
		
			$Viewpoint->sort = $_POST['sort'];
			$Viewpoint->status = $_POST['status'];
			$Viewpoint->status = $_POST['status'];
			$Viewpoint->topiccode = $_POST['topiccode'];
			$Viewpoint->add();
			$this->redirect("show_list");
		}
	}

	//编辑
	public function edit() {
		if (!isset($_POST['submit'])) {
			$id = $_GET['id'];
			$Viewpoint = M('Viewpoint');
			$map["id"] = array("eq", $id);
			$objViewpoint = $Viewpoint->where($map)->find();
			$seo_id = array("eq", $id);
			$seo_info = M('seo_info');
			$map["id"] = array("eq", $objViewpoint['seo_id']);
			$objseo_info = $seo_info->where($map)->find();

			//所属地区列表
			$city_belong = M('city_belong');
			$list_city_id = $city_belong->join(C('DB_PREFIX') . "area" . C('DB_SUFFIX') . " ON " . C('DB_PREFIX') . "city_belong" . C('DB_SUFFIX') . ".cid=" . C('DB_PREFIX') . "area" . C('DB_SUFFIX') . ".id")
			->where("types='Viewpoint'")
			->field("*," . C('DB_PREFIX') . "city_belong" . C('DB_SUFFIX') . ".sort as sort")
			->select();

			$objViewpoint['fit_person'] = explode(",", $objViewpoint['fit_person']);

			if ($objViewpoint['position'] != NULL) {
				$position = explode(",", $objViewpoint['position']);
				$objViewpoint['location_x'] = $position[0];
				$objViewpoint['location_y'] = $position[1];
				//dump($objViewpoint);
			}
			$viewpointtopics=M("viewpointtopic")->select();
			$this->assign('viewpointtopics', $viewpointtopics);
			$this->assign('objViewpoint', $objViewpoint);
			$this->assign('objseo_info', $objseo_info);
			$this->assign("id", $id);
			$this->assign('list_city_id', $list_city_id);
			$this->display();
		} else {
			$Viewpoint = M('Viewpoint');
			$Viewpoint->create();
			$Viewpoint->id = $_POST['id'];
			$Viewpoint->names = $_POST['names'];
			if ($_POST['SEO'] != '' && $_POST['SEO'] != null) {
				$seo_info = M('SeoInfo');
				$seo_info->create();
				$seo_info->title = $_POST['title'];
				$seo_info->keyword = $_POST['keyword'];
				$seo_info->detail = $_POST['detail'];
				if ($_POST['seo_id'] > 0)
				$seo_info->where("id=" . $_POST['seo_id'])->save();
				else
				$Viewpoint->seo_id = $seo_info->add();
			}
			else {
				$seo_info = M('SeoInfo');
				$seo_info->where('id=' . $_POST['seo_id'])->delete();
				$Viewpoint->seo_id = 0;
			}
			if ($_POST['location_x'] != '' && $_POST['location_y'] != '') {
				$Viewpoint->position = "{$_POST['location_x']},{$_POST['location_y']}";
				//dump($Viewpoint->position);
			}
			$Viewpoint->city_id = $_POST['city_id'];
			$Viewpoint->rank = $_POST['rank'];
			$Viewpoint->view_type = $_POST['view_type'];
			$Viewpoint->fit_person = join(",", $_POST['fit_person']);
			$Viewpoint->pic = $_POST['pic_front'];

			$Viewpoint->contact = $_POST['contact'];
			$Viewpoint->view_info = $_POST['view_info'];
			
			$Viewpoint->sort = $_POST['sort'];
			$Viewpoint->status = $_POST['status'];
			$Viewpoint->topiccode = $_POST['topiccode'];
			$Viewpoint->save();
			$this->redirect("show_list");
		}
	}

	 

	//部分编辑
	public function ajax_save() {
		header('Content-Type:text/html;charset=utf-8');
		$id = $_GET['id'];
		$names = $_POST['names'];
		$sort = $_POST['sort'];
		$Viewpoint = M('Viewpoint');
		$Viewpoint->create();
		$Viewpoint->id = $id;
		$Viewpoint->names = $names;
		$Viewpoint->sort = $sort;
		$Viewpoint->save();
		echo 1;
		exit;
	}


	public function del() {
		$id = $_GET['id'];
		$Line = M('Viewpoint');
		$Line->where("id=$id")->delete();
		$this->redirect("show_list");
	}
	//全部列表
	public function show_list() {
		$View = M("Viewpoint");
		if (!empty($_GET['title'])) {
			$where["names"] = array("like", "%{$_GET['title']}%");
			$this->assign("title", $_GET['title']);
		} else {
			$where = '1=1';
		}
		$count = $View->where($where)->count();
		$page = $this->pagebar($count);
		$list = $View->page($page)->where($where)->order('sort,id desc')->select();

		$this->assign('list', $list);
		$this->display();
	}


}

?>