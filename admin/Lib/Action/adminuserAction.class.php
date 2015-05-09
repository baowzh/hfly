<?php
import("ORG.Util.Page"); // 导入分页类
class adminuserAction extends CommonAction {
    public function add() {
    	
        if (!isset ($_POST['submit'])) {
            $role = spyc_load_file("./Conf/role.yml");
            reset($role);
            $role_list = array();
            while (list($key, $item) = each($role)) {
                if ($item["status"] == 1) {
                    $keys = explode("_", $key);
                    $role_list[]=array("id"=>$keys[1],'name'=>$item["names"]);
                }
            }
            $this->assign('Roles_list', $role_list);
            $this->display();
        } else {
            $adminUser = M("AdminUser");
            $count = $adminUser->where("login_name='" . $_POST['login_name'] . "'")->find();
            if ($count) {
                $this->assign('message', '用户名已经存在');
                $this->display();
                exit ();
            }
            if ($data = $adminUser->create()) {
                $data['pwd'] = md5($_POST['pwd']);
                $data['create_time'] = date('Y-m-d H:i:s');
                if ($user_id = $adminUser->add($data)) {
                    $RoleUser = M('RoleUser');
                    $data['role_id'] = $_POST['group'];
                    $data['user_id'] = $user_id;
                    $RoleUser->add($data);
                   /* $this->redirect('lists', array(
                        'message' => '增加后台管理员成功'
                    ));*/
                    $this->success("添加后台管理员成功",U("lists"));
                } else {
                   /* $this->assign('message', '增加后台管理失败');
                    $this->display();*/
                	$this->error("添加后台管理员失败",U("lists"));
                }
            }
        }
    }

    //列出所有的用户
    public function lists() {
        $AdminUser = M('admin_user');
         if (!empty($_GET['title'])) {
            $where['login_name'] = array('like', "%{$_GET['title']}%");
            $this->assign("title", $_GET['title']);
        } else {
            $where = "1=1";
        }
        $count = $AdminUser->where($where)->count();
        $page = $this->pagebar($count);
        $list = $AdminUser->where($where)->order('id desc')->page($page)->select();
        $this->assign('list', $list);
        $this->display();
    }

    //管理员删除
    public function del() {
        $adminUser = M("AdminUser");
        $adminUser->where("id={$this->get [0]}")->delete();
        $this->redirect('lists', array(
            'message' => '删除成功'
        ));
    }
	public function deleteall() {
		
		if (isset($_POST['dosubmit'])) {
			$done = false;
			$Article = M("admin_user");
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
	
    public function ajax_del() {
        header('Content-Type:text/html;charset=utf-8');
        $id = $_GET['id'];
        $Hotel = M('admin_user');
        //$Hotelpic = M('HotelPic');
       // $picpath = $Hotelpic->where("hotel_id=$id")->getField("picpath");
        $Hotel->where("id=$id")->delete();
        @unlink($_SERVER['DOCUMENT_ROOT'] . __ROOT__ . $picpath);

        //$dt = new HotelDeleterModel($id); //关联表删除
        //$dt->deleteFromTable();

        echo 1;
        exit;
    }

    //管理员状态修改
    public function edit() {
    	
        if (!isset ($_POST['submit'])) {
        	
            $adminUser = M("AdminUser");
            $admin = $adminUser->where('id=' .$_GET["id"])->find();
			//var_dump($admin);exit;
            $role = spyc_load_file("./Conf/role.yml");
            reset($role);
            $role_list = array();
            while (list($key, $item) = each($role)) {
                if ($item["status"] == 1) {
                    $keys = explode("_", $key);
                    $role_list[]=array("id"=>$keys[1],'name'=>$item["names"]);
                }
            }
            $this->assign('roles', $role_list);
            $this->assign('list', $admin);
            $this->display();
        } else {
        	
            $adminUser = M("AdminUser");
            $data = $adminUser->create();
            //dump($data);exit;
            $this->assign('list', $data);
            $adminUser->save($data);
            /*$this->redirect('lists', array(
                'message' => '修改成功'
            ));*/
            $this->success("修改成功",U("lists"));
        }
    }

    //验证用户是否存在
    public function isexit() {
        $adminUser = M("AdminUser");
        $count = $adminUser->where("login_name='" . $this->get[0] . "'")->find();
        if ($count > 0) {
            $this->ajaxReturn('1', "新增成功！", 1);
        } else {
            $this->ajaxReturn('0', "新增成功！", 0);
        }
        exit ();
    }

    public function resetPwd() {
        if (!isset ($_POST['submit'])) {
            $adminUser = M('AdminUser');
            $list = $adminUser->where("id=" . $this->get[0])->find();
            //dump($list);
            $this->assign('list', $list);
            $this->display();
        } else {
            $AdminUser = M('AdminUser');
            $data = $AdminUser->create();
            $data['pwd'] = md5($_POST['pwd1']);
            $AdminUser->save($data);
            $this->redirect('lists', array(
                'message' => '修改成功'
            ));
        }
    }

}

?>