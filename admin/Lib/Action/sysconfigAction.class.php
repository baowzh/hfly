<?php
import("ORG.Util.Page"); // 导入分页类
class sysconfigAction extends CommonAction {
	public function base_config() {
		$BaseConfig = M("BaseConfig");
		$list = $BaseConfig->order('sort')->page($_GET['p'] . ',20')->select();
		$this->assign('list', $list);
		$this->assign('message', isset ($_REQUEST['message']) ? C($_REQUEST['message']) : '');

		$count = $BaseConfig->count();
		$Page = new Page($count, 20); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show(); // 分页显示输出
		$this->assign('page', $show); // 赋值分页输出
		$this->display();
	}
	public function base_config_add() {
		if (!isset ($_POST['submit'])) {
			$this->display();
		} else {
			$BaseConfig = M("BaseConfig");
			if ($BaseConfig->create()) {
				if (false !== $BaseConfig->add()) {
					$this->redirect('base_config', array (
						'message' => 'MESSAGE_SUCCESS'
					));
				} else {
					$this->assign('message', '添加失败');
					$this->display();
				}
			} else {
				$this->assign('message', '添加失败');
				$this->display();
			}
		}
	}

	public function base_config_edit() {
		if (!isset ($_POST['submit'])) {
			$get = init_request();
			$BaseConfig = M("BaseConfig");
			$baseConfig = $BaseConfig->where('id=' . $get[0])->find();
			$this->assign('baseConfig', $baseConfig);
			$this->display();
		} else {
			$BaseConfig = M("BaseConfig");
			if ($BaseConfig->create()) {
				if (false !== $BaseConfig->save()) {
					$this->redirect('base_config', array (
						'message' => 'MESSAGE_SUCCESS'
					));
				} else {
					$this->assign('message', '添加失败');
					$this->display();
				}
			} else {
				$this->assign('message', '添加失败');
				$this->display();
			}
		}
	}

	public function base_config_del() {
		$get = init_request();
		$BaseConfig = M("BaseConfig");
		$BaseConfig->where('id=' . $get[0])->delete();
		$this->redirect('base_config', array (
			'message' => 'MESSAGE_SUCCESS'
		));
	}

}
?>