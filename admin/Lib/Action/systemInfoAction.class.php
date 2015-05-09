<?php
import("ORG.Util.Page"); // 导入分页类�
class systemInfoAction extends CommonAction {
	public function add() {
		if (!isset ($_POST['submit'])) {
			$SystemInfo = M("SystemInfo");
			$list = $SystemInfo->where('level < 3')->select();
			$this->assign('list', $list);
			$this->display();
		} else {
			$SystemInfo = M("SystemInfo");
			$SystemInfo->create();
			$SystemInfo->add();
			$this->redirect('lists',array('message'=>'添加节点成功'));
			//$this->redirect('lists');
		}
	}
	public function lists() {
		$SystemInfo = M("SystemInfo");
		$list = $SystemInfo->page($_GET['p'].',15')->select();
		foreach ($list as $p => $v) {
			$pid_name = $SystemInfo->where('id='.$v['pid'])->getField('name');
			$tmp[] = array (
				'id' => $v['id'],
				'value' => $v['value'],
				'status' => $v['status'],
				'name' => $v['name'],
				'pid' => $pid_name,
				'level' => $v['level'],
				'info' => $v['info']
			);
		}
		$this->assign('list', $tmp);
		$count = $SystemInfo->count();
		$Page = new Page($count,15); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show(); // 分页显示输出
		$this->assign('page', $show); // 赋值分页输出
		$this->assign('message', $message);
		$this->display("lists");
	}
	//编辑节点
	public function edit() {
		if (!isset ($_POST['submit'])) {
			$get = init_request();
			$SystemInfo = M("SystemInfo");
			$Role_edit = $SystemInfo->where('id=' . $get[0])->find();
			$pid_name = $SystemInfo->where('id=' . $Role_edit['pid'])->getField('name');
			$this->assign('pid_name', $pid_name);
			$list = $SystemInfo->where('level < 3')->select();
			$this->assign('list', $list);
			$this->assign('Role_edit', $Role_edit);
			$this->display();
		} else {
			$SystemInfo = M("SystemInfo");
			if ($SystemInfo->create()) {
				if (false !== $SystemInfo->save()) {
					$this->redirect('lists');
					//self :: lists('编辑节点成功');
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
		$SystemInfo = M("SystemInfo");
		$SystemInfo->where('id=' . $get[0])->delete();
		$this->redirect('lists');
	}
}
?>