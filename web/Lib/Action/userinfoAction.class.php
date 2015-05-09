<?php

/**
 * 文件名称：userinfoAction.class.php
 * 用途说明：用户个人资料类
 * 开发人员：maruiming2010@jeechange.com
 * 创建时间：2013/10/31 14:47:39
 */
import('ORG.Util.Page'); // 导入分页类

class userinfoAction extends usercommonAction {

    /**
     * 用户个人信息资料修改
     */
    public function revise_userdetail() {
        $User = D("user");
        $Education = M("EducationBackground");
        $Industry = M("IndustryBackground");
    
        if (!empty($_POST)) {
            foreach ($_POST as $key=>$val) {
                if (empty($val)) {
                    $this->error("修改信息不能为空值！");
                }
            }

            $data = array();
            $data['true_name'] = $_POST['true_name'];
            $data['identity_no'] = $_POST['identity_no'];
            $data['sex'] = $_POST['sex'];
            $data['address'] = $_POST['address'];
            $data['industry'] = $_POST['industry'];
            $data['education'] = $_POST['education'];

            $Info = M('UserInfo');
            $Info->where("user_id=".$_SESSION['user_id'])->save($data);
        }


        $user_detail = $User->get_user_detail($_SESSION['user_id']);
        $educations = $Education->select();
        $industrys = $Industry->select();

        $this->assign('educations', $educations);
        $this->assign('industrys', $industrys);
        $this->assign('detail', $user_detail);
        $this->display();
    }

    /**
     * 用户个人信息密码修改
     */
    public function revise_password() {
        if (!empty($_POST)) {
            if($_POST['new_password'] == $_POST['affirm_password'] ) {
                $User = M('User');
                $password = md5($_POST['old_password']);
                $exist = $User->where("password='".$password."' AND id=".$_SESSION['user_id'])->find();
               
                if ($exist) {
                    $data['password'] = md5($_POST['new_password']);
                    $result = $User->where("id=".$_SESSION['user_id'])->save($data);
                   
                    $this->success(" 密码更改成功！");
                } else {
                    $this->error("您输入的原密码不正确！");
                }
            } else {
                $this->error('两次输入的密码不一致！');
            }
        }

        $this->display();
    }

    /**
     * 用户个人信息登录方式修改
     */
    public function revise_loginmethod() {
        $User = D("user");

        if (!empty($_POST['email'])) {
            $pattern = '/^[a-z0-9_\-]+(\.[_a-z0-9\-]+)*@([_a-z0-9\-]+\.)+([a-z]{2}|aero|arpa|biz|com|coop|edu|gov|info|int|jobs|mil|museum|name|nato|net|org|pro|travel)$/';
            if (preg_match($pattern, $_POST['email'], $match)) {
                $data['email'] = $_POST['email'];
                $result = $User->where("id=".$_SESSION['user_id'])->save($data);
                    $this->success('登录邮箱修改成功！');
                    exit;
            } else {
                $this->error("你输入的邮箱格式不正确！");
                 exit;
            }
        }
        if (!empty($_POST['phone'])) {
            $pattern = '/^(?:13\d{9}|15[0|1|2|3|5|6|7|8|9]\d{8}|18[0|2|3|5|6|7|8|9]\d{8}|14[5|7]\d{8})$/';

            if (preg_match($pattern, $_POST['phone'], $match)) {
                $data['phone'] = $_POST['phone'];
                $result = $User->where("id=".$_SESSION['user_id'])->save($data);
                    $this->success('登录手机修改成功！');
                     exit;
            } else {
                $this->error("你输入的手机号码格式不正确！");
                 exit;
            }
        }

        $user_detail = $User->get_user_detail($_SESSION['user_id']);
        $User = $User->where("id=".$_SESSION['user_id'])->find();
        $this->assign('detail', $user_detail);
        $this->assign('user', $User);
        $this->display();
    }

    /**
     * 消息列表
     */
    public function message_list() {
        $id = $_SESSION['user_id'];
        $message = M('sms_log');
        $list = $message->where("user_id='$id'")->select();
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 消息详情
     */
    public function short_message() {
        $uid = $_SESSION['user_id'];
        $id = $_GET['id'];
        $message = M('sms_log');
        $lists = $message->where("user_id='$uid' AND id='$id'")->find();
        $this->assign("lists", $lists);
        $this->display();
    }

    /**
     * 删除消息
     */
    public function message_del() {
        $uid = $_SESSION['user_id'];
        $id = $_GET['id'];
        $message = M('sms_log');
        if ($message->where("user_id='$uid' AND id='$id'")->delete()) {
            $this->success("删除成功!");
        } else {
            $this->success("删除失败!");
        }
    }

    /**
     * 个人账户明细
     */
    public function finance_list() {
	$Incomes = D('Incomes');
	$User = M('user');

	$count = $Incomes->count($_SESSION['user_id']);
	$page = $this->pagebar($count);
	
	$list = $Incomes->get_list($page, $_SESSION['user_id']);

	$this->assign('list',$list);

	$this->display();
    }
    
    public function validform() {
		$param = $_POST["param"];
		$name = $_POST["name"];
		switch ($name) {
			case"verify":
				if ($_SESSION["verify"] == md5($param)) {
					$ajaxreturn = array("info" => "输入正确", "status" => "y");
				} else {
					$ajaxreturn = array("info" => "输入错误", "status" => "n");
				}
				break;
		}
		$this->ajaxReturn($ajaxreturn);
	}
}

















