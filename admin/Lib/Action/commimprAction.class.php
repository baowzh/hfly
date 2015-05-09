<?php

import("ORG.Util.Page");

class commimprAction extends CommonAction {

    //添加
    public function add() {
        if (!isset($_POST['save'])) {
            $types = $_GET['types'];
            $this->assign('types', $types);
            $this->display();
        } else {
        	$types = $_POST['types'];
            $CommImpr = M('CommImpr');
            $CommImpr->create();
            $CommImpr->names = $_POST['names'];
            $CommImpr->sort = $_POST['sort'];
            $CommImpr->types = $_POST['types'];
            //dump($_POST['types']);exit;
            $CommImpr->add();
          // $this->success("添加成功");
          $this->redirect("show_list","t=".$types);
        }
    }
    
    //点击了列表下方的删除按钮之后
    public function deleteall()
    {
    	
        if(isset($_POST['dosubmit']))
        {
            $done = false;
            $CommImpr = M('CommImpr');
            $count = $CommImpr->count();
            $id = $CommImpr->getField("id",true);
            for($i=0;$i<$count;$i++)
            {
                if($_POST["items_".$id[$i]])
                {
                    $CommImpr->where("id=".$id[$i])->delete();
                    $done = true;
                }
            }
            if($done)
              $this->success("删除成功！");
            else
              $this->error("请勾选至少1项。");
        }
        else
        {
           $this->error("请至少选择一项");
        }
    }

    //编辑
    public function ajax_save() {
        $id = $_GET['id'];
        $names = $_POST['names'];
        $sort = $_POST['sort'];
        $CommImpr = M('CommImpr');
        $CommImpr->create();
        $CommImpr->id = $id;
        $CommImpr->names = $names;
        $CommImpr->sort = $sort;
        $CommImpr->save();
        echo 1;exit;
    }
    
    //删除    
    public function ajax_del(){
        header('Content-Type:text/html;charset=utf-8');
        $CommImpr = M('CommImpr');
        $condition['id'] = array('eq',$_GET['id']);
        $CommImpr->where($condition)->delete();
        echo 1;exit;

    }

    //全部列表
    public function show_list() {
        $types = $_GET['t'];
        $CommImpr = M("CommImpr");
        $count = $CommImpr->where("types='$types'")->count();
        $page = $this->pagebar($count);
        $list = $CommImpr->page($page)->where("types='$types'")->order("sort,id desc")->select();

        $this->assign('list', $list);
        $this->assign('types', $types);
        $this->display('show_list');
    }
    
    public function sort_list() {
        $CommImpr = M("CommImpr");
        $types = $_GET['t'];
        foreach ($_POST["sort"] as $key => $val) {
            $CommImpr->where("id={$key}")->setField("sort", $val);
        }
        $this->redirect("show_list","t=".$types);
    }
    
    
    //成功后跳转*
    public function succefull_forward() {
    
    }

}

?>