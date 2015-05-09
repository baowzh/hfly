<?php

import("ORG.Util.Page");
import("ORG.Net.UploadFile");
import("@.ORG.file");

class advcodeAction extends CommonAction {

    //put your code here
    // 代码广告列表
    public function show_lists() {
        $Adv = D("Adv");
        $pages = ($_GET['p'] == null ? '1' : $_GET['p']);
        $list = $Adv->where("type=3")->page($pages . ',15')->select();
        $count = $Adv->where("type=3")->count();
        $Page = new Page($count, 15);
        $show = $Page->show();

        $this->assign('page', $show);
        $this->assign('list', $list);
        $this->display();
    }

    // 添加代码广告
    public function add() {
        if (!isset($_POST['submit'])) {
            $this->display();
        } else {
            $Adv = M("Adv");
            $Adv->create();
            $Adv->names = $_POST['names'];
            $Adv->type = 3;
            $Adv->area_memo = $_POST['area_memo'];
            $Adv->content = $_POST['content'];
            $Adv->add();
        }
    }

    // 文字广告编辑
    public function ajax_save() {
        $id = $_GET['id'];
        $names = $_POST['names'];
        $link = $_POST['link'];
        $content = $_POST['content'];
        $area_memo = $_POST['area_memo'];
        $Adv = M("Adv");
        $Adv->create();
        $Adv->id = $id;
        $Adv->names = $names;
        $Adv->link = $link;
        $Adv->content = $content;
        $Adv->area_memo = $area_memo;
        $Adv->save();
        echo 1;
        exit;
    }

    // 文字广告删除
    public function ajax_del(){
        $id = $_GET['id'];
        $Adv = M("Adv");
//        $picpath = $Adv->where("id=$id")->getField("picpath");
        $Adv->where("id=" . $id . " and type=3")->delete();
//        
//        @unlink(C('ROOT')."/web/File/adv_pic/".$picpath);
        echo 1;exit;
    }

}

?>
