<?php

class linequestionAction extends CommonAction {

    public function show_list() {
        $line_que = M('LineQue');
        $line = M('line');
        $user = M('User');
        $count = $line_que->count();
        $page = $this->pagebar($count);
        $ques = $line_que->page($page)->order("status='1',sort")->select();
        
        foreach ($ques as $p => $i) {
            $line_name = $line->where("id=" . $i["line_id"])->getField("names");
            $user_name = $user->where("id=" . $i["user_id"])->getField("login_name");
            $ques[$p]["line_name"] = $line_name;
            $ques[$p]["user_name"] = $user_name;
        }

        $this->assign("list", $ques);
        $this->display();
    }

    public function answer() {
        $id = $_GET['id'];
        $this->assign('id', $id);
        $line_que = M('LineQue');

        if (!isset($_POST['save'])) {
            $line = M('line');
            $ques = $line_que->where('id=' . $id)->find();
            $line_name = $line->where("id=" . $ques["line_id"])->getField("names");
            $ques['line_name'] = $line_name;
            $this->assign("list", $ques);
            $this->display();
        } else {
            if ($_POST['answer'] != null && $_POST['answer'] != "") {
                $_POST['status'] = 2;
                $_POST['answer_time'] = time();
            } else {
                $_POST['status'] = 1;
                $_POST['answer_time'] = null;
                $_POST['answer'] = null;
            }
            $line_que->create();
            $line_que->where('id=' . $id)->save();
            $this->success("发布成功",U('show_list'));
        }
    }

    //删除
    public function del() {
        $id = $_GET['id'];
        $ques_list = M('LineQue');
        
        if($ques_list->where("id=$id")->delete()){
            $this->success("删除成功！");
        }else{
            $this->error("删除失败！");
        }
    }

    public function deleteall() {
        if (!isset($_POST["items"])) {
            $this->error("至少选中一项！");
        }
        $Line = M('line_que');
        //        $picpath = $Line->where("id=$id")->getField("picpath");
        foreach ($_POST["items"] as $id) {
            $Line->where("id=$id")->delete();
        }
        $this->success("删除成功",U("show_list"));
    }

}

?>
