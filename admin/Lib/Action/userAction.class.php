<?php
import("ORG.Util.Page"); // 导入分页类
import("ORG.Net.UploadFile");
import("@.ORG.file");

class userAction extends CommonAction {

    //全部列表
    public function show_list() {
        $User = M("User");
        $message = $_GET['message'];
        $condition = array();
        if ($_GET['key'] != '') {
            $where['username'] = array('like', '%' . $_GET['key'] . '%');
            $where["email"] = array('like', '%' . $_GET['key'] . '%');
            $where["phone"] = array('like', '%' . $_GET['key'] . '%');
            $where['_logic'] = 'or';
            $condition['_complex'] = $where;
            $this->assign('key', $_GET['key']);
        }
        $count = $User->where($condition)->count();
        $Page = new Page($count, 15);
        $list = $User->where($condition)->order('id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $show = $Page->show();

        $this->assign('page', $show);
        $this->assign('list', $list);
        $this->assign('message', $message);
        $this->display();
    }

    /**
     * 添加会员
     */
    public function add() {
        if (!isset($_POST['submit'])) {
            $this->display();
        } else {
            $user = M("User");
            $count = $user->where("username='" . $_POST['username'] . "'")->find();
            if ($count) {
                $this->assign('message', '用户名已经存在');
                $this->display();
                exit();
            }
            if ($user->create()) {
                $data['username'] = $_POST['username'];
                $data['email'] = $_POST['email'];
                $data['phone'] = $_POST['phone'];
                $data['password'] = md5($_POST['password']);
                $data['create_time'] = date('Y-m-d H:i:s');
                $data['status'] = $_POST['status'];
                if ($user_id = $user->add($data)) {
                    unset($data);
                    //$this->redirect('show_list', array(
                      //  'message' => '添加用户成功'
                   // ));
                   $this->success("添加成功",U("show_list"));
                } else {
                    unset($data);
                    $this->assign('message', '添加用户失败');
                    $this->display();
                }
            }
        }
    }

    /**
     *  用户修改
     */
    public function edit() {
        $user = M("User");
        if (!isset($_POST['submit'])) {
            $condition = array(
                'id' => $_GET['id']
            );
            $detail = $user->where($condition)->find();
            $this->assign('detail', $detail);
            $this->display();
        } else {
            if ($user->create()) {
                $data['id'] = $_POST['id'];
                $data['email'] = $_POST['email'];
                $data['phone'] = $_POST['phone'];
                if ($_POST['password'] != '') {
                    $data['password'] = md5($_POST['password']);
                }
                $data['status'] = $_POST['status'];
                if ($user->save($data)) {
                    unset($data);
                    $this->success('编辑用户成功', 'show_list');
                } else {
                    unset($data);
                    $this->error('编辑用户失败', 'show_list');
                }
            }
        }
    }

    /**
     *   删除用户
     */
    public function del() {
        $User = M("User");
        $id = $_GET['id'];
        $map['id'] = array('eq', $id);
        $User->where($map)->delete();
        $this->success('删除用户成功', 'show_list');
    }

    //删除选中的
	public function deleteall() {
		if (isset($_POST['dosubmit'])) {
			$done = false;
			$Article = M("User");
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


    
    
    /**
     * 短信列表
     */
    public function sms_lists() {
        $Sms = M('Sms');
        $User = M('User');
        $message = $_GET['message'];
        $count = $Sms->count();
        $Page = new Page($count, 15);
        $list = $Sms->order('id,sort desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
        foreach ($list as $key => $value) {
            $login_name = $User->where('id=' . $value['user_id'])->getField('login_name');
            $tem[] = array(
                'id' => $value['id'],
                'login_name' => $login_name == '' ? '全部会员' : $login_name,
                'title' => $value['title'],
                'sort' => $value['sort'],
                'createtime' => date('Y-m-d H:i:s', $value['createtime']),
                'user_id' => $value['user_id']
            );
        }
        $this->assign('list', $tem);
        $show = $Page->show();
        $this->assign('page', $show);
        $this->assign('message', $message);
        $this->display();
    }

    /**
     *  发送短信
     */
    public function send_sms() {
        $Sms = M("Sms");
        if (!isset($_POST['__hash__'])) {
            $User = M("User");
            $condition = array();
            $user_id = $_GET['user_id'];
            if ($user_id) {
                $condition['id'] = array('eq', $user_id);
            } else {
                $condition['id'] = 0;
            }
            $objUser = $User->where($condition)->field('id,login_name')->find();
            $this->assign('objUser', $objUser);
            $this->display();
        } else {
            $user_id = trim($_POST['user_id']);
            $title = $_POST['title'];
            $Sms->create();
            $Sms->user_id = $user_id;
            $Sms->title = $title;
            $Sms->content = $_POST['content'];
            $Sms->sort = trim($_POST['sort']);
            $Sms->createtime = strtotime(date('Y-m-d H:i:s'));
            if ($Sms->add()) {
                $message = '短信添加成功';
            } else {
                $message = '短信添加失败';
            }
            $this->redirect('sms_lists', array('message' => $message));
        }
    }

    /**
     *  用户保存
     */
    public function ajax_save() {
        $User = M('User');
        $id = $_GET['id'];
        $status = $_POST['status'];
        $User->create();
        $User->id = $id;
        $User->status = $status;
        $User->save();
        echo 1;
        exit;
    }

    /**
     *  添加短信
     */
    public function addsms() {
        if (!isset($_POST['__hash__'])) {
            $this->display();
        } else {
            $Sms = M("Sms");
            $Sms->create();
            $Sms->user_id = 0;
            $Sms->createtime = strtotime(date('Y-m-d H:i:s'));
            if ($Sms->add()) {
                $this->redirect('sms_lists', array('message' => "添加成功！"));
            } else {
                $this->redirect('sms_lists', array('message' => "添加失败！"));
            }
        }
    }

    /**
     *  编辑短信
     */
    public function edit_sms() {
        $Sms = M("Sms");
        $User = M("User");
        if (!isset($_POST['__hash__'])) {
            $id = $_GET['id'];
            $map['id'] = array('eq', $id);
            $list = $Sms->where($map)->find();
            $login_name = $User->where('id=' . $list['user_id'])->getField('login_name');
            $this->assign('login_name', $login_name);
            $this->assign('list', $list);
            $this->display();
        } else {
            $sid = trim($_POST['id']);
            if (isset($sid)) {
                $Sms->create();
                $Sms->id = $sid;
                $Sms->save();
                $this->redirect('sms_lists', array('message' => '保存成功！'));
            } else {
                $this->redirect('sms_lists', array('message' => '网络错误！'));
            }
        }
    }

    /**
     *  短信列表修改保存
     */
    public function ajax_sms_save() {
        $Sms = M("Sms");
        $id = $_GET['id'];
        $title = $_POST['title'];
        $sort = $_POST['sort'];
        $createtime = strtotime($_POST['createtime']);
        $Sms->create();
        $Sms->id = $id;
        $Sms->title = $title;
        $Sms->sort = $sort;
        $Sms->createtime = $createtime;
        $Sms->save();
        echo 1;
        exit;
    }

    /**
     * 	测试发短信
     */
    public function testsms() {
        $phone = '15077166892';
        $sms = D("sms");
        $sms->setting["timeout"] = 60;
        $sms->setting["type"] = "withdraw";
        $sms->setting["user_id"] = $user_id;
        $sms->setting["title"] = "帐户提现";
        $sms->setting["content"] = "你的提现验证码为" . $sms->setting["code"] . ",【微金担保】";
        if ($sms->send($phone, "", $return)) {
            //$this->ajaxReturn(array("status" => 1, "info" => "获取成功！", "data" => $return));
            echo "成功";
            exit;
        } else {
            $this->ajaxReturn(array("status" => 0, "info" => $return["msg"], "data" => $return));
            echo $return["msg"];
            exit;
        }
    }

    /**
     * 	测试发邮件
     */
    public function lol() {
        $mail = '20674657@qq.com';
        $email = D('email');
        $email->setting["timeout"] = 30;
        $email->setting["type"] = "user_active";
        $email->setting["user_id"] = $email_log["user_id"];
        $email->setting["title"] = "test";
        $email->setting["link"] = md5($link);
        $email->setting["content"] = "test";
        if ($email->send($mail, $mail, "", "", $return)) {
            echo "成功";
            //$this->assign("email_return", $return);
            //$this->display("check_email");
        } else {
            echo "失败";
            //$this->error($return["msg"], U('register'));
            //exit;
        }
    }

    /**
     *  删除短信
     */
    public function ajax_sms_del() {
        $Sms = M("Sms");
        $id = $_GET['id'];
        $map['id'] = array('eq', $id);
        $Sms->where($map)->delete();
        echo 1;
        exit;
    }

}
?>