<?php

import("ORG.Util.Page");

class line_topic_typeAction extends CommonAction {

    //添加
    public function add() {
        if (empty($_POST)) {
            $types = $_GET['types'];
            $this->assign('types', $types);
            $this->display();
        } else {
            $line_topic_type = M('line_topic_type');
            $line_topic_type->create();
            $line_topic_type->names = $_POST['names'];
            $line_topic_type->sort = $_POST['sort'];
            $line_topic_type->status = '1';
            if($line_topic_type->add()){
                $this->success("添加成功",U('show_list'));
            }else{
                $this->error("添加失败");
            }
        }
    }

    //保存
    public function ajax_save() {
        header('Content-Type:text/html;charset=utf-8');
        $id = $_GET['id'];
        $names = $_POST['names'];
        $sort = $_POST['sort'];
        $line_topic_type = M('line_topic_type');
        $line_topic_type->create();
        $line_topic_type->id = $id;
        $line_topic_type->names = $names;
        $line_topic_type->sort = $sort;
        $line_topic_type->save();
        echo 1;exit;
    }
    
    //删除    
	public function del(){
	header('Content-Type:text/html;charset=utf-8');
        $id = $_GET['id'];
        $line_topic_type = M('line_topic_type');
        $line_topic_type->where("id=$id")->delete();
        $this->success("删除成功",U('show_list'));
    }

    //全部列表
    public function show_list() {        
        $line_topic_type = M("line_topic_type");
        $count = $line_topic_type->count();
        $page=  $this->pagebar($count);
        $list = $line_topic_type->page($page)->order("sort")->select();        
        $this->assign('list', $list);
        $this->assign('types', $types);
        $this->display();
    }
    
    public function deleteall() {
        if (!isset($_POST["items"])) {
            $this->error("至少选中一项！");
        }
        $Line = M('line_topic_type');
        //        $picpath = $Line->where("id=$id")->getField("picpath");
        foreach ($_POST["items"] as $id) {
            $Line->where("id=$id")->delete();
        }
        $this->success("删除成功",U("show_list"));
    }

}

?>