<?php
import("ORG.Util.Page"); // 导入分页类
// 导入分页类�
class nodeAction extends CommonAction {
	public function add() {
		if (!isset ($_POST['submit'])) {
			$this->display();
		} else {
			$Node = M("Node");
			if ($Node->create()) {
				$data = $Node->create();
				$SystemInfo = M("SystemInfo");
				if (null == $_POST['third']) {
					if (null == $_POST['secend']) {
						if (null == $_POST['first']) {
							$this->assign('message', '项目入口不可以为空');
							$this->display();
							exit ();
						} else {
							$admin = $SystemInfo->where('id=' . $_POST['first'])->find();
							$data['name'] = $admin['value'];
							$data['level'] = $admin['level'];
							$data['pid'] = $admin['pid'];
						}
					} else {
						$admin = $SystemInfo->where('id=' . $_POST['secend'])->find();
						$data['name'] = $admin['value'];
						$data['level'] = $admin['level'];
						$pid_obj = $SystemInfo->where('id=' . $_POST['first'])->find();
						$pid = $Node->where("name='" . $pid_obj['value'] . "' and level =" . $pid_obj['level'])->getField('id');
						$data['pid'] = $pid;
					}
				} else {
					$admin = $SystemInfo->where('id=' . $_POST['third'])->find();
					$data['name'] = $admin['value'];
					$data['level'] = $admin['level'];
					$pid_obj = $SystemInfo->where('id=' . $_POST['secend'])->find();
					$pid = $Node->where("name='" . $pid_obj['value'] . "' and level =" . $pid_obj['level'])->getField('id');
					$data['pid'] = $pid;
				}
				$count = $Node->where("name='" . $data['name'] . "' and level =" . $data['level'] . " and pid=" . $data['pid'])->find();
				if ($count) {
					$this->assign('message', '节点已经存在');
					$this->display();
					exit ();
				}
				$Node->add($data);
				$this->redirect('lists', array (
					'message' => '添加节点成功'
				));
			}else{
				$this->redirect('lists', array (
					'message' => '添加节点失败'
				));
			}
		}
	}
	public function lists() {
		$Node = M("Node");
		$list = $Node->page($_GET['p'] . ',15')->select();
		foreach ($list as $p => $v) {
			$pid_name = $Node->where('id=' . $v['pid'])->getField('title');
			$tmp[] = array (
				'id' => $v['id'],
				'name' => $v['name'],
				'status' => $v['status'],
				'title' => $v['title'],
				'pid' => $pid_name,
				'level' => $v['level'],
				'remark' => $v['remark']
			);
		}
		$this->assign('list', $tmp);

		$count = $Node->count();
		$Page = new Page($count, 15); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show(); // 分页显示输出
		$this->assign('page', $show); // 赋值分页输出�
		$this->assign('message', $message);
		$this->display('lists');
	}

	//编辑节点
	public function edit() {
		if (!isset ($_POST['submit'])) {
			$get = init_request();
			$Node = M("Node");
			$Role_edit = $Node->where('id=' . $get[0])->find();
			$pid_name = $Node->where('id=' . $Role_edit['pid'])->getField('name');
			$this->assign('pid_name', $pid_name);
			$list = $Node->where('level < 3')->select();
			$this->assign('list', $list);
			$this->assign('Role_edit', $Role_edit);
			$this->display();
		} else {
			$Node = M("Node");
			if ($Node->create()) {
				if (false !== $Node->save()) {
					$this->redirect('lists');
				} else {
					$this->assign('message', '编辑失败');
					$this->display();
				}
			} else {
				$this->assign('message', '编辑失败');
				$this->display();
			}
		}
	}
	//删除节点
	public function del() {
		$get = init_request();
		$Node = M("Node");
		$Node->where('id=' . $get[0])->delete();
		$this->redirect('lists');
	}
	//激活节点�
	public function activation() {
		$id = $this->get[0];
		$Node = M("Node");
		$objUser = $Node->where("id=$id")->find();
		if ($objUser['status'] == 1) {
			self :: lists('不能重复激活�');
		} else {
			$datas['status'] = 1;
			$Node->where("id=$id")->data($datas)->save();
			self :: lists('激活�成功');
		}
	}
	//三级联动菜单
	public function first() {
		$SystemInfo = M("SystemInfo");
		$lists = $SystemInfo->where('level=1')->select();
		$this->ajaxReturn('1', "新增成功！", $lists);
		exit ();
	}
	public function secend() {
		$SystemInfo = M("SystemInfo");
		$Node = M("Node");
		$sys_obj = $SystemInfo->where('id=' . $_POST['id'])->find();
		$node_obj = $Node->where("name='" . $sys_obj['value'] . "' and level=" . $sys_obj['level'] . " and status = 1")->find();
		if ($node_obj) {
			$lists = $SystemInfo->where('pid=' . $_POST['id'])->select();
		} else {
			$lists = null;
		}
		$this->ajaxReturn('1', "新增成功！", $lists);
		exit ();
	}
}
?>