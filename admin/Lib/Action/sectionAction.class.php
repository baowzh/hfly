<?php

/**
 * 内容管理
 *
 * @author gemini
 */
class sectionAction extends CommonAction {

    public function classify_management() {
        $ArticleSection = D("ArticleSection");
        $data = $ArticleSection->get_section_table();
        $this->assign("acount", $data['count']);
        $this->assign("section_str", $data['section_str']);
        $this->display();
    }

    public function classify_add() {
        $ArticleSection = D("ArticleSection");
        if (!isset($_POST['save'])) {
            $psection = $ArticleSection->get_section();
            $this->assign("psection", $psection);
            $this->display();
            exit;
        } else {
            $_POST['pic_path'] = $_POST["pic_front"];
            if ($ArticleSection->create()) {
                $ArticleSection->add();
                $this->success("栏目添加成功", U("classify_management"));
            } else {
                $this->error($ArticleSection->getError());
            }
        }
    }

    public function classify_edit() {
        $id = $_GET["id"];
        if (isset($_GET["id"]))
            unset($_GET["id"]);
        $ArticleSection = D("ArticleSection");
        $Section_info = $ArticleSection->where("id=$id")->find();
        if (!$Section_info) {
            $this->error("栏目不存在", U("classify_management", $_GET));
            exit;
        }
        if (!isset($_POST['save'])) {
            $classify_info = $ArticleSection->where("id='$id'")->select();
            $pid = $classify_info[0]['pid']; // 传入栏目所属栏目
            $psection = $ArticleSection->get_section($pid);
            $this->assign("psection", $psection);
            $this->assign("id", $id);
            $this->assign("section", $Section_info);
            $this->display();
            exit;
        }else{
            $article = M("Article");
            $count = $article->where("cid={$_POST['id']}")->count();
            if($_POST["model"]==intval(1) && intval($count)>1) {
                $this->error("所属模型修改失败！单页模型下只能有一篇文章。");
                exit;
            }
            if($_POST['pic_front']!="") {
                $_POST['pic_path'] = $_POST['pic_front'];
                $logopath = $ArticleSection->where("id=".$id)->getField("pic_path");
                @unlink($_SERVER['DOCUMENT_ROOT'] . __ROOT__ . $logopath);
            }
            if ($ArticleSection->create()) {
                $ArticleSection->where("id=$id")->save();
                $this->success("修改栏目成功", U("classify_management"));
            } else {
                $this->error($ArticleSection->getError());
            }
        }
    }

    public function classify_del() {
        $id = $_GET["id"];
        if (isset($_GET["id"]))
            unset($_GET["id"]);
        $ArticleSection = M("ArticleSection");
        $children = $ArticleSection->where("pid=$id")->select();

        // 如果要删除的分类下面还有子分类，则提醒错误。
        if (!empty($children)) {
            $this->error("该分类包含子分类，请先删除其下子分类！");
            exit();
        }

        $ArticleSection->where("id=$id")->delete();
        $this->redirect("classify_management");
    }

    public function about_us() {
        $p = isset($_GET['p']) ? intval($_GET['p']) : 0; //获取分页页码
        $article = M("article");
        $admin_user = M("admin_user");
        $article_section = D("ArticleSection");
        $condition = array();
        $condition["cid"] = array("in", $article_section->get_ids("1"));
        if ($_GET['title'] != "") {
            $condition["title"] = array('like', '%' . $_GET['title'] . '%');
            $this->assign('title', $_GET['title']);
        }
        if ($_GET['btime']) {
            $btime = $_GET['btime'];
            $btime = strtotime($btime);
            if ($_GET['etime']) {

                $etime = $_GET['etime'] . ' 23:59:59';
                $etime = strtotime($etime);
                $condition["add_time"] = array('between', array($btime, $etime));
            } else {
                $condition["add_time"] = array('egt', $btime);
            }

            $this->assign('btime', $_GET['btime']);
        }
        if ($_GET['etime']) {

            $etime = $_GET['etime'] . ' 23:59:59';
            $etime = strtotime($etime);
            if ($_GET['btime']) {
                $btime = $_GET['btime'];
                $btime = strtotime($btime);
                $condition["add_time"] = array('between', array($btime, $etime));
            } else {
                $condition["add_time"] = array('elt', $etime);
            }
            $this->assign('etime', $_GET['etime']);
        }

        $lists = $article->where($condition)->page("$p," . PAGESIZE)->order('id desc')->select();

        $count = $article->where($condition)->count(); // 查询满足要求的总记录数
        $this->pagebar($count); //设置分页导航条
        if ($lists) {
            foreach ($lists as $k => $v) {
                $lists[$k]["admin_name"] = $admin_user->where("id={$v['publish_id']}")->getField("user_name");
                $lists[$k]["section_name"] = $article_section->where("id={$v['cid']}")->getField("names");
            }
        }
        $this->assign('lists', $lists); //
        $this->display();
    }

    public function aboutus_add() {
        $ArticleSection = D("ArticleSection");
        if (!$_POST) {
            $ArticleSection = D("ArticleSection");
            $this->assign("pid_option", $ArticleSection->get_option("1"));
            $this->display();
            exit;
        }
        $article = D("article");
        if ($article->create()) {
            $id = $article->add();
            $seo = D("seo");
            $seo->set_seo($id, $article->getModelName());
            $this->success("添加成功", U("about_us"));
        } else {
            $this->error($article->getError());
        }
    }

    public function aboutus_edit() {
        $id = $_GET["id"];
        if (isset($_GET["id"]))
            unset($_GET["id"]);
        $article = D("article");
        $article_info = $article->where("id=$id")->find();
        if (!$article_info) {
            $this->error("记录不存在", U("about_us", $_GET));
            exit;
        }
        $ArticleSection = D("ArticleSection");
        $seo = D("seo");
        if (!$_POST) {
            $ArticleSection = D("ArticleSection");
            $this->assign("pid_option", $ArticleSection->get_option("1", $article_info["cid"]));
            $this->assign("article", $article_info);
            $this->assign("seo_info", $seo->get_seo($id, $article->getModelName()));
            $this->display();
            exit;
        }
        $_POST["id"] = $id;
        $data = $article->create();
        if ($data) {
            $article->save($data);
            $seo->set_seo($id, $article->getModelName());
            $this->success("修改成功", U("about_us"));
        } else {
            $this->error($article->getError());
        }
    }

    public function aboutus_del() {
        $id = $_GET["id"];
        if (isset($_GET["id"]))
            unset($_GET["id"]);
        $article = M("article");
        $article->where("id=$id")->delete();
        $seo = M("seo");
        $seo->where("relate_id=$id and relate_table='" . $article->getModelName() . "'")->delete();
        $this->redirect("about_us");
    }

    public function credit_system() {
        $p = isset($_GET['p']) ? intval($_GET['p']) : 0; //获取分页页码
        $article = M("article");
        $admin_user = M("admin_user");
        $article_section = D("ArticleSection");
        $condition = array();
        $condition["cid"] = array("in", $article_section->get_ids("2"));
        if ($_GET['title'] != "") {
            $condition["title"] = array('like', '%' . $_GET['title'] . '%');
            $this->assign('title', $_GET['title']);
        }
        $lists = $article->where($condition)->page("$p," . PAGESIZE)->order('id desc')->select();

        $count = $article->where($condition)->count(); // 查询满足要求的总记录数
        $this->pagebar($count); //设置分页导航条
        if ($lists) {
            foreach ($lists as $k => $v) {
                $lists[$k]["admin_name"] = $admin_user->where("id={$v['publish_id']}")->getField("user_name");
                $lists[$k]["section_name"] = $article_section->where("id={$v['cid']}")->getField("names");
            }
        }
        $this->assign('lists', $lists); //
        $this->display();
    }

    public function credit_add() {
        $ArticleSection = D("ArticleSection");
        if (!$_POST) {
            $ArticleSection = D("ArticleSection");
            $this->assign("pid_option", $ArticleSection->get_option("2"));
            $this->display();
            exit;
        }
        $article = D("article");
        if ($article->create()) {
            $id = $article->add();
            $seo = D("seo");
            $seo->set_seo($id, $article->getModelName());
            $this->success("添加成功", U("credit_system"));
        } else {
            $this->error($article->getError());
        }
    }

    public function credit_edit() {
        $id = $_GET["id"];
        if (isset($_GET["id"]))
            unset($_GET["id"]);
        $article = D("article");
        $article_info = $article->where("id=$id")->find();
        if (!$article_info) {
            $this->error("记录不存在", U("about_us", $_GET));
            exit;
        }
        $ArticleSection = D("ArticleSection");
        $seo = D("seo");
        if (!$_POST) {
            $ArticleSection = D("ArticleSection");
            $this->assign("pid_option", $ArticleSection->get_option("2", $article_info["cid"]));
            $this->assign("article", $article_info);
            $this->assign("seo_info", $seo->get_seo($id, $article->getModelName()));
            $this->display();
            exit;
        }
        $_POST["id"] = $id;
        $data = $article->create();
        if ($data) {
            $article->save($data);
            $seo->set_seo($id, $article->getModelName());
            $this->success("修改成功", U("credit_system"));
        } else {
            $this->error($article->getError());
        }
    }

    public function credit_del() {
        $id = $_GET["id"];
        if (isset($_GET["id"]))
            unset($_GET["id"]);
        $article = M("article");
        $article->where("id=$id")->delete();
        $seo = M("seo");
        $seo->where("relate_id=$id and relate_table='" . $article->getModelName() . "'")->delete();
        $this->redirect("credit_system");
    }

    public function help_center() {
        $p = isset($_GET['p']) ? intval($_GET['p']) : 0; //获取分页页码
        $article = M("article");
        $admin_user = M("admin_user");
        $article_section = D("ArticleSection");
        $condition = array();
        $condition["cid"] = array("in", $article_section->get_ids("3"));
        if ($_GET['title'] != "") {
            $condition["title"] = array('like', '%' . $_GET['title'] . '%');
            $this->assign('title', $_GET['title']);
        }

        if ($_GET['btime']) {
            $btime = $_GET['btime'];
            $btime = strtotime($btime);
            if ($_GET['etime']) {

                $etime = $_GET['etime'] . ' 23:59:59';
                $etime = strtotime($etime);
                $condition["jee_article.add_time"] = array('between', array($btime, $etime));
            } else {
                $condition["jee_article.add_time"] = array('egt', $btime);
            }

            $this->assign('btime', $_GET['btime']);
        }
        if ($_GET['etime']) {

            $etime = $_GET['etime'] . ' 23:59:59';
            $etime = strtotime($etime);
            if ($_GET['btime']) {
                $btime = $_GET['btime'];
                $btime = strtotime($btime);
                $condition["jee_article.add_time"] = array('between', array($btime, $etime));
            } else {
                $condition["jee_article.add_time"] = array('elt', $etime);
            }
            $this->assign('etime', $_GET['etime']);
        }
        $lists = $article->where($condition)->page("$p," . PAGESIZE)->order('id desc')->select();
        $count = $article->where($condition)->count(); // 查询满足要求的总记录数
        $this->pagebar($count); //设置分页导航条
        if ($lists) {
            foreach ($lists as $k => $v) {
                $lists[$k]["admin_name"] = $admin_user->where("id={$v['publish_id']}")->getField("user_name");
                $lists[$k]["section_name"] = $article_section->where("id={$v['cid']}")->getField("names");
            }
        }
        $this->assign('lists', $lists); //
        $this->display();
    }

    public function help_add() {
        $ArticleSection = D("ArticleSection");
        if (!$_POST) {
            $ArticleSection = D("ArticleSection");
            $this->assign("pid_option", $ArticleSection->get_option("3"));
            $this->display();
            exit;
        }
        $article = D("article");
        if ($article->create()) {
            $id = $article->add();
            $seo = D("seo");
            $seo->set_seo($id, $article->getModelName());
            $this->success("添加成功", U("help_center"));
        } else {
            $this->error($article->getError());
        }
    }

    public function help_edit() {
        $id = $_GET["id"];
        if (isset($_GET["id"]))
            unset($_GET["id"]);
        $article = D("article");
        $article_info = $article->where("id=$id")->find();
        if (!$article_info) {
            $this->error("记录不存在", U("help_center", $_GET));
            exit;
        }
        $ArticleSection = D("ArticleSection");
        $seo = D("seo");
        if (!$_POST) {
            $ArticleSection = D("ArticleSection");
            $this->assign("pid_option", $ArticleSection->get_option("3", $article_info["cid"]));
            $this->assign("article", $article_info);
            $this->assign("seo_info", $seo->get_seo($id, $article->getModelName()));
            $this->display();
            exit;
        }
        $_POST["id"] = $id;
        $data = $article->create();
        if ($data) {
            $article->save($data);
            $seo->set_seo($id, $article->getModelName());
            $this->success("修改成功", U("help_center"));
        } else {
            $this->error($article->getError());
        }
    }

    public function help_del() {
        $id = $_GET["id"];
        if (isset($_GET["id"]))
            unset($_GET["id"]);
        $article = M("article");
        $article->where("id=$id")->delete();
        $seo = M("seo");
        $seo->where("relate_id=$id and relate_table='" . $article->getModelName() . "'")->delete();
        $this->redirect("help_center");
    }

    public function feedback() {
        $p = isset($_GET['p']) ? intval($_GET['p']) : 0; //获取分页页码
        $feedback = D("feedback");
        $condition = array();
        if ($_GET['user_name'] != "") {
            $condition["jee_user.user_name"] = array('like', '%' . $_GET['user_name'] . '%');
            $this->assign('user_name', $_GET['user_name']);
        }

        if ($_GET['btime']) {
            $btime = $_GET['btime'];
            $btime = strtotime($btime);
            if ($_GET['etime']) {

                $etime = $_GET['etime'] . ' 23:59:59';
                $etime = strtotime($etime);
                $condition["jee_feedback.add_time"] = array('between', array($btime, $etime));
            } else {
                $condition["jee_feedback.add_time"] = array('egt', $btime);
            }

            $this->assign('btime', $_GET['btime']);
        }
        if ($_GET['etime']) {

            $etime = $_GET['etime'] . ' 23:59:59';
            $etime = strtotime($etime);
            if ($_GET['btime']) {
                $btime = $_GET['btime'];
                $btime = strtotime($btime);
                $condition["jee_feedback.add_time"] = array('between', array($btime, $etime));
            } else {
                $condition["jee_feedback.add_time"] = array('elt', $etime);
            }
            $this->assign('etime', $_GET['etime']);
        }
        $count = $feedback->where($condition)->count();
        $lists = $feedback->where($condition)->join('jee_user on jee_feedback.user_id=jee_user.id')->page("$p," . PAGESIZE)->order("add_time desc")->select();
        $this->pagebar($count); //设置分页导航条
        $this->assign('lists', $lists); //
        $this->display();
    }

    public function feedback_view() {
        $id = $_GET["id"];
        if (isset($_GET["id"]))
            unset($_GET["id"]);
        $feedback = D("feedback");
        $feedback_info = $feedback->where("id=$id")->find();
        if (!$feedback_info) {
            $this->error("记录不存在", U("feedback", $_GET));
            exit;
        }
        if (!$_POST) {
            $this->assign("lists", $feedback_info);
            $this->display();
            exit;
        }
        $_POST["id"] = $id;
        if ($feedback->create()) {
            $feedback->reply_id = $_SESSION["user_id"];
            $feedback->reply_time = time();
            $feedback->save();
            $this->success("回复成功", U("feedback", $_GET));
        } else {
            $this->error($feedback->getError());
        }
    }

    public function feedback_del() {
        $id = $_GET["id"];
        if (isset($_GET["id"]))
            unset($_GET["id"]);
        $feedback = M("feedback");
        $feedback_info = $feedback->where("id=$id")->find();
        if (!$feedback_info) {
            $this->error("记录不存在", U("feedback", $_GET));
            exit;
        }
        $feedback->where("id=$id")->delete();
        $this->success("删除成功", U("feedback", $_GET));
    }

    public function feedback_bug() {
        $p = isset($_GET['p']) ? intval($_GET['p']) : 0; //获取分页页码
        $feedback = M("feedback_bug");
        $condition = array();
        if ($_GET['user_name'] != "") {
            $condition["jee_user.user_name"] = array('like', '%' . $_GET['user_name'] . '%');
            $this->assign('user_name', $_GET['user_name']);
        }

        if ($_GET['btime']) {
            $btime = $_GET['btime'];
            $btime = strtotime($btime);
            if ($_GET['etime']) {

                $etime = $_GET['etime'] . ' 23:59:59';
                $etime = strtotime($etime);
                $condition["jee_feedback_bug.add_time"] = array('between', array($btime, $etime));
            } else {
                $condition["jee_feedback_bug.add_time"] = array('egt', $btime);
            }

            $this->assign('btime', $_GET['btime']);
        }
        if ($_GET['etime']) {

            $etime = $_GET['etime'] . ' 23:59:59';
            $etime = strtotime($etime);
            if ($_GET['btime']) {
                $btime = $_GET['btime'];
                $btime = strtotime($btime);
                $condition["jee_feedback_bug.add_time"] = array('between', array($btime, $etime));
            } else {
                $condition["jee_feedback_bug.add_time"] = array('elt', $etime);
            }
            $this->assign('etime', $_GET['etime']);
        }
        $count = $feedback->where($condition)->count();
        $lists = $feedback->where($condition)->join('jee_user on jee_feedback_bug.user_id=jee_user.id')->page("$p," . PAGESIZE)->order("add_time desc")->select();
        $this->pagebar($count); //设置分页导航条
        $this->assign('lists', $lists); //
        $this->display();
    }

    public function feedback_bug_view() {
        $id = $_GET["id"];
        if (isset($_GET["id"]))
            unset($_GET["id"]);
        $feedback = D("feedback_bug");
        $feedback_info = $feedback->where("id=$id")->find();
        if (!$feedback_info) {
            $this->error("记录不存在", U("feedback", $_GET));
            exit;
        }
        if (!$_POST) {
            $this->assign("lists", $feedback_info);
            $this->display();
            exit;
        }
        $_POST["id"] = $id;
        if ($feedback->create()) {
            $feedback->reply_id = $_SESSION["user_id"];
            $feedback->reply_time = time();
            $feedback->save();
            $this->success("回复成功", U("feedback_bug", $_GET));
        } else {
            $this->error($feedback->getError());
        }
    }

    public function feedback_bug_del() {
        $id = $_GET["id"];
        if (isset($_GET["id"]))
            unset($_GET["id"]);
        $feedback = M("feedback_bug");
        $feedback_info = $feedback->where("id=$id")->find();
        if (!$feedback_info) {
            $this->error("记录不存在", U("feedback_bug", $_GET));
            exit;
        }
        $feedback->where("id=$id")->delete();
        $this->success("删除成功", U("feedback_bug", $_GET));
    }

    public function article_list() {
        $cid = $_GET["section"];
        $p = isset($_GET['p']) ? intval($_GET['p']) : 0; //获取分页页码
        $article = M("article");
        $admin_user = M("admin_user");
        $article_section = D("ArticleSection");
        $condition = array();
        $condition["cid"] = $cid;
        $lists = $article->where($condition)->page("$p," . PAGESIZE)->order('id desc')->select();
        $count = $article->where($condition)->count(); // 查询满足要求的总记录数
        $this->pagebar($count); //设置分页导航条
        if ($lists) {
            foreach ($lists as $k => $v) {
                $lists[$k]["admin_name"] = $admin_user->where("id={$v['publish_id']}")->getField("user_name");
            }
        }
        $this->assign("section_bar", $article_section->section_bar($cid));
        $this->assign('lists', $lists); //
        $this->display();
    }

    public function article_add() {
        $cid = $_GET["section"];
        $ArticleSection = D("ArticleSection");
        if (!$_POST) {
            $ArticleSection = D("ArticleSection");
            $this->assign("pid_option", $ArticleSection->get_section($cid));
            $this->display();
            exit;
        }
        $article = D("article");
        if ($article->create()) {
            $id = $article->add();
            $seo = D("seo");
            $seo->set_seo($id, $article->getModelName());
            $this->success("添加成功", U("article_list", $_GET));
        } else {
            $this->error($article->getError());
        }
    }

    public function article_edit() {
        $id = $_GET["id"];
        $cid = $_GET["section"];
        $article = D("article");
        $article_info = $article->where("id=$id")->find();
        if (!$article_info) {
            $this->error("记录不存在", U("article_list", $_GET));
            exit;
        }
        $ArticleSection = D("ArticleSection");
        $seo = D("seo");
        if (!$_POST) {
            $ArticleSection = D("ArticleSection");
            $this->assign("pid_option", $ArticleSection->get_section($cid));
            $this->assign("article", $article_info);
            $this->assign("seo_info", $seo->get_seo($id, $article->getModelName()));
            $this->display();
            exit;
        }
        $_POST["id"] = $id;
        $data = $article->create();
        if ($data) {
            $article->save($data);
            $seo->set_seo($id, $article->getModelName());
            unset($_GET["id"]);
            $this->success("修改成功", U("article_list", $_GET));
        } else {
            $this->error($article->getError());
        }
    }
    
    public function classify_delall(){
        if(isset($_POST['id'])){
            foreach($_POST['id'] as $id){
                $ArticleSection = M("ArticleSection");
                $parent = $ArticleSection->where("id=$id")->find();
                $children = $ArticleSection->where("pid=$id")->select();
                // 如果要删除的分类下面还有子分类，则提醒错误。
                if (!empty($children)) {
                    $this->error("选择的分类“{$parent["names"]}”中包含子分类，请先删除其下子分类！");
                    exit();
                }
                @unlink($_SERVER['DOCUMENT_ROOT'].__ROOT__.$parent[$k]["pic_path"]);
                $ArticleSection->where("id=$id")->delete();
            }
            $this->success("删除成功！");
        }
        $this->error("请至少选择一项");
    }

    public function article_del() {
        if(isset($_GET["id"])){
            $id = $_GET["id"];
            unset($_GET["id"]);
        }
        $article = M("article");
        $article->where("id=$id")->delete();
        $seo = M("seo");
        $seo->where("relate_id=$id and relate_table='" . $article->getModelName() . "'")->delete();
        $this->redirect("article_list", $_GET);
    }

    // 页脚信息列表
    public function footbar_info() {
        $p = isset($_GET['p']) ? intval($_GET['p']) : 0; //获取分页页码
        $article = M("article");
        $admin_user = M("admin_user");
        $article_section = D("ArticleSection");
        $condition = array();
        if ($_GET['title'] != "") {
            $condition["title"] = array('like', '%' . $_GET['title'] . '%');
            $this->assign('title', $_GET['title']);
        }
        if ($_GET['btime']) {
            $btime = $_GET['btime'];
            $btime = strtotime($btime);
            if ($_GET['etime']) {

                $etime = $_GET['etime'] . ' 23:59:59';
                $etime = strtotime($etime);
                $condition["add_time"] = array('between', array($btime, $etime));
            } else {
                $condition["add_time"] = array('egt', $btime);
            }

            $this->assign('btime', $_GET['btime']);
        }
        if ($_GET['etime']) {

            $etime = $_GET['etime'] . ' 23:59:59';
            $etime = strtotime($etime);
            if ($_GET['btime']) {
                $btime = $_GET['btime'];
                $btime = strtotime($btime);
                $condition["add_time"] = array('between', array($btime, $etime));
            } else {
                $condition["add_time"] = array('elt', $etime);
            }
            $this->assign('etime', $_GET['etime']);
        }

        $section_id = $article_section->where("names='页脚信息'")->select();

        $condition["cid"] = array("in", $article_section->get_ids($section_id[0]['id']));
        $lists = $article->where($condition)->page("$p," . PAGESIZE)->order('id desc')->select();

        $count = $article->where($condition)->count(); // 查询满足要求的总记录数
        $this->pagebar($count); //设置分页导航条
        if ($lists) {
            foreach ($lists as $k => $v) {
                $lists[$k]["admin_name"] = $admin_user->where("id={$v['publish_id']}")->getField("user_name");
                $lists[$k]["section_name"] = $article_section->where("id={$v['cid']}")->getField("names");
            }
        }
        $this->assign('lists', $lists); //
        $this->display();
    }

    // 添加页脚信息文章。
    public function footbar_info_add() {
        $ArticleSection = D("ArticleSection");
        if (!$_POST) {
            $ArticleSection = D("ArticleSection");
            $section_id = $ArticleSection->where("names='页脚信息'")->select();

            $this->assign("pid_option", $ArticleSection->get_option($section_id[0]['id']));
            $this->display();
            exit;
        }
        $article = D("article");
        if ($article->create()) {
            $id = $article->add();
            $seo = D("seo");
            $seo->set_seo($id, $article->getModelName());
            $this->success("添加成功", U("footbar_info"));
        } else {
            $this->error($article->getError());
        }
    }

    // 编辑页脚信息文章
    public function footbar_info_edit() {
        $id = $_GET["id"];
        if (isset($_GET["id"]))
            unset($_GET["id"]);
        $article = D("article");
        $article_info = $article->where("id=$id")->find();
        if (!$article_info) {
            $this->error("记录不存在", U("about_us", $_GET));
            exit;
        }
        $ArticleSection = D("ArticleSection");
        $seo = D("seo");
        if (!$_POST) {
            $ArticleSection = D("ArticleSection");
            $section_id = $ArticleSection->where("names='页脚信息'")->select();

            $this->assign("pid_option", $ArticleSection->get_option($section_id[0]['id'], $article_info["cid"]));
            $this->assign("article", $article_info);
            $this->assign("seo_info", $seo->get_seo($id, $article->getModelName()));
            $this->display();
            exit;
        }
        $_POST["id"] = $id;
        $data = $article->create();
        if ($data) {
            $article->save($data);
            $seo->set_seo($id, $article->getModelName());
            $this->success("修改成功", U("footbar_info"));
        } else {
            $this->error($article->getError());
        }
    }

    // 删除页脚信息文章
    public function footbar_info_del() {
        $id = $_GET["id"];
        if (isset($_GET["id"]))
            unset($_GET["id"]);
        $article = M("article");
        $article->where("id=$id")->delete();
        $seo = M("seo");
        $seo->where("relate_id=$id and relate_table='" . $article->getModelName() . "'")->delete();
        $this->redirect("footbar_info");
    }

    public function noticedel() {
        $notice = M('notice');
        $ids = $_POST['c_select'];
        foreach ($ids as $v) {
            $notice->where("id='$v'")->delete();
        }
        $this->success('删除成功');
    }

    public function about_usalldel() {
        $article = M('article');
        $ids = $_POST['c_select'];
        foreach ($ids as $v) {
            $article->where("id='$v'")->delete();
        }
        $this->success('删除成功');
    }

    public function credit_systemalldel() {
        $article = M('article');
        $ids = $_POST['c_select'];
        foreach ($ids as $v) {
            $article->where("id='$v'")->delete();
        }
        $this->success('删除成功');
    }

    public function help_centeralldel() {
        $article = M('article');
        $ids = $_POST['c_select'];
        foreach ($ids as $v) {
            $article->where("id='$v'")->delete();
        }
        $this->success('删除成功');
    }

    public function footbar_infoalldel() {
        $article = M('article');
        $ids = $_POST['c_select'];
        foreach ($ids as $v) {
            $article->where("id='$v'")->delete();
        }
        $this->success('删除成功');
    }

    public function classify_managementalldel() {
        $ArticleSection = M('ArticleSection');
        $ids = $_POST['c_select'];
        foreach ($ids as $v) {
            $ArticleSection->where("id='$v'")->delete();
        }
        $this->success('删除成功');
    }

    public function sort_list() {
        $ArticleSection = M("ArticleSection");
        foreach ($_POST["sort"] as $key => $val) {
            $ArticleSection->where("id={$key}")->setField("sort", $val);
        }
        $this->redirect("classify_management");
    }
}

?>