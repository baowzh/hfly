<?php
import("ORG.Util.Page"); // 导入分页类
class messageAction extends CommonAction {
	//留言信息
	public function messages() {
		$Liuyan = M("Message");
		$content = $Liuyan->order('user_time DESC')->page($_GET['p'] . ',20')->select();
		$count = $Liuyan->count();
		$Page = new Page($count, 20); // 实例化分页类 传入总记录数和每页显示的记录数
		$show = $Page->show(); // 分页显示输出
		$this->assign('page', $show); // 赋值分页输出
		$this->assign('content', $content);
		$this->display();

	}
	//编辑留言
	public function edit() {
		if (!isset ($_POST['submit'])) {
			$get = init_request();
			$Liuyan_edit = M("Message");
			$liuyan_edit = $Liuyan_edit->where('id=' . $get[0])->find();
			$this->assign('liuyan_edit', $liuyan_edit);
			$this->display();
		} else {
			$Liuyan_edit = M("Message");
			$data['admin_time'] = date('Y-m-d H:i:s');
			$data['contents'] = $_POST['contents'];
			$data['id'] = $_POST['id'];
			if ($Liuyan_edit->create($data)) {
				if (false !== $Liuyan_edit->save()) {
					$this->redirect('messages');
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

	//删除留言
	public function del() {
		$get = init_request();
		$Liuyan = M("Message");
		$Liuyan->where('id=' . $get[0])->delete();
		$this->redirect('messages');
	}

	//管理员浏览用户留言
	public function browse() {
		$Liuyan = M ( "Message" );
		$content=$Liuyan->where('id='.$this->get[0])->find();
		$this->assign ( 'content', $content );
		$this->display();
	}

}
?>