<?php

class viewimprAction extends CommonAction {

	public function show_list() {
		$impr_list = M('ViewpointImpr');
		$view = M('Viewpoint');
		$user = M('User');
		$imprs = $impr_list->select();

		foreach ($imprs as $p => $i) {
			$view_name = $view->where("id=" . $i["view_id"])->getField("names");
			$user_name = $user->where("id=" . $i["user_id"])->getField("login_name");
			$imprs[$p]["view_name"] = $view_name;
			$imprs[$p]["user_name"] = $user_name;

			$average = (floatval($i["decoration"]) +
					 floatval($i["traffic"]) +
					 floatval($i["hygiene"]) +
					 floatval($i["goods"]) +
					 floatval($i["prices"])) / 5;
			if ($average >= 80 && $average <= 100)
				$imprs[$p]["score"] = "好评";
			elseif ($average >= 65 && $average < 80)
				$imprs[$p]["score"] = "良评";
			elseif ($average >= 50 && $average < 65)
				$imprs[$p]["score"] = "中评";
			elseif ($average < 50)
				$imprs[$p]["score"] = "差评";
		}

		$this->assign("list", $imprs);
		$this->display();
	}

	//景点点评 - 设置点评奖金
	public function award() {
		$id = $_GET['id'];
		$imprs = M('ViewpointImpr');
		$imprinfo = $imprs->where("id=$id")->getField("id, view_id, order_id");
		foreach ($imprinfo as $info)
			$imprinfo = $info;
		$order = D("ViewpointOrder");
		$award = $order->get_order($info['order_id']);
		$imprinfo["bonus_comm"] = $award["award_price"];

		$this->assign("info", $imprinfo);
		$this->display();
	}

	public function update() {
		$id = $_GET['id'];
		$this->assign('id', $id);
		$impr_list = M('ViewpointImpr');

		if (!isset($_POST['save'])) {
			$view = M('Viewpoint');
			$impr_type = M('CommImpr');
			$impr = $impr_list->where("id=" . $id)->find();
			$impr_types = explode(",", $impr['impr_type']);
			$view_name = $view->where("id=" . $impr["view_id"])->getField("names");
			$impr_list = $impr_type->where("types='VIEWPOINT'")->select();
			$impr['view_name'] = $view_name;

			$this->assign("view", $impr);
			$this->assign("imprs", $impr_list);
			$this->assign("impr_type", $impr_types);

			$this->display();
		} else {
			$data = $impr_list->create();
			$data['impr_type'] = join(",", $_POST['impr_type']);
			$data['sort'] = ($data['sort'] == "") ? 0 : $data['sort'];
			$data['publish_time'] = date("Y-m-d H:i:s");
			$impr_list->where("id=" . $id)->save($data);
			$this->success("修改成功！");
		}
	}

	//删除    
	public function ajax_del() {
		header('Content-Type:text/html;charset=utf-8');
		$id = $_GET['id'];
		$impr_list = M('ViewpointImpr');
		$impr_list->where("id=$id")->delete();
		echo 1;
		exit;
	}

	//景点点评 - 完成审核
	public function check() {
		$id = $_POST['impr_id'];
		$impr_list = M('ViewpointImpr');
		$impr_list->where("id=$id")->save(array('status' => 2));

		// 改订单状态为“已结束”
		$order = $impr_list->where("id=$id")->find();
		M("ViewpointOrder")->where("id={$order['order_id']}")->save(array("status" => 5));
		// 开始发奖金
		$money = $_POST['bonus_comm'];
		M("User")->where("id={$order["user_id"]}")->setInc("award", $money);

		$this->success("审核成功", "show_list");
	}

	//点击了列表下方的删除按钮之后
	public function deleteall() {
		if (isset($_POST['dosubmit'])) {
			$done = false;
			$view = M("ViewpointImpr");
			$count = $view->count();
			$id = $view->getField("id", true);
			for ($i = 0; $i < $count; $i++) {
				if ($_POST["items_" . $id[$i]]) {
					$view->where("id=" . $id[$i])->delete();
					$done = true;
				}
			}
			if ($done)
				$this->success("删除成功！");
			else
				$this->error("请勾选至少1项。");
		}
		else {
			$this->redirect("show_list");
		}
	}

	public function sort_list() {
		$impr_list = M('ViewpointImpr');
		$pages = ($_GET['p'] == null ? '1' : $_GET['p']);
		$list = $impr_list->page($pages . ',15')->order("sort")->select();

		/* 将新排序写入数据库 */
		$sort_list = $list;
		for ($i = 0; $i < count($list); $i++) {
			for ($k = count($list) - 2; $k >= $i; $k--) {
				if ($list[$k + 1]['id'] < $list[$k]['id']) {
					$tmp = $list[$k + 1];
					$list[$k + 1] = $list[$k];
					$list[$k] = $tmp;
				}
			}
		}foreach ($list as $k => $i) {
			$data[$k]["user_id"] = $list[$k]["user_id"] = $sort_list[$k]["user_id"];
			$data[$k]["view_id"] = $list[$k]["view_id"] = $sort_list[$k]["view_id"];
			$data[$k]["impr_type"] = $list[$k]["impr_type"] = $sort_list[$k]["impr_type"];
			$data[$k]["decoration"] = $list[$k]["decoration"] = $sort_list[$k]["decoration"];
			$data[$k]["traffic"] = $list[$k]["traffic"] = $sort_list[$k]["traffic"];
			$data[$k]["hygiene"] = $list[$k]["hygiene"] = $sort_list[$k]["hygiene"];
			$data[$k]["goods"] = $list[$k]["goods"] = $sort_list[$k]["goods"];
			$data[$k]["prices"] = $list[$k]["prices"] = $sort_list[$k]["prices"];
			$data[$k]["content"] = $list[$k]["content"] = $sort_list[$k]["content"];
			$data[$k]["publish_time"] = $list[$k]["publish_time"] = $sort_list[$k]["publish_time"];
			$data[$k]["sort"] = $list[$k]["sort"] = $sort_list[$k]["sort"];
			$data[$k]["status"] = $list[$k]["status"] = $sort_list[$k]["status"];
			$impr_list->where("id=" . $list[$k]["id"])->save($data[$k]);
		}

		$this->redirect("show_list", array("p" => $pages));
	}

}

?>
