<?php

import("ORG.Util.Page"); // 导入分页类

class onepageAction extends CommonAction {

    //下拉选择
    function cate($selected = 0, $parent_id = 0, $m = -1, $gets = 0) {
        $sec = M("section");
        $Article = M("Article");
        $res = $sec->where("pid=$parent_id")->select();
        $cid = $Article->where("id=$gets")->find();
        $n = str_pad('', $m, '-', STR_PAD_RIGHT);
        $n = str_replace('-', '&nbsp;&nbsp;', $n);
        $options = '';
        static $i = 0;
        if ($cid[cid] == 0) {
            $selected = "selected";
        } else {
            $selected = "";
        }
        if ($i == 0) {
            $options .= "<option $selected value='0' >≡ 作为一级栏目 ≡</option>\n";
        }
        if ($res) {
            $n++;
            foreach ($res as $key => $val) {
                $i++;
                if ($val['id'] == $cid[cid]) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $options .= "<option $selected value='{$val['id']}'>";
                if ($val['pid'] == 0) {
                    $head = "┣ ";
                    $options .= $head . $val['names'] . "</option>\n";
                } else
                    $options .= $n . "├  " . $val['names'] . "</option>\n";
                $options .= self :: cate($selected, $val['id'], $m + 3, $gets);
            }
        }
        return $options;
    }

    //添加文章
    public function content() {
        if (!isset($_POST['submit'])) {
            $arr = self :: cate();
            $this->assign('option', $arr);
            $this->assign('message', isset($_REQUEST['message']) ? C($_REQUEST['message']) : '');
            $Section = M("Section");
            $add_pid_zero = $Section->where('pid=0')->order('id')->select();
            $add_pid = $Section->where('')->order('id')->select();

            $this->assign('add_pid_zero', $add_pid_zero);
            $this->assign('add_pid', $add_pid);

            $this->assign('message', isset($_REQUEST['message']) ? C($_REQUEST['message']) : '');
            $this->display();
        } else {
            $_POST["times"] = date('Y-m-d H:i:s');
            $BaseConfig = M("Article");
            if ($BaseConfig->create()) {
                if (false !== $BaseConfig->add()) {
                    self :: lists("添加栏目成功");
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

    //全部列表
    public function lists() {
        $article = M("Article");
        $count = $article->table(C('DB_PREFIX')."article".C('DB_SUFFIX')." act")
                       ->join(C('DB_PREFIX')."article_section".C('DB_SUFFIX')." act_sec ON act.cid=act_sec.id")
                       ->where("act_sec.model=1")
                       ->count();
        $page = $this->pagebar($count);
        $articles = $article->table(C('DB_PREFIX')."article".C('DB_SUFFIX')." act")
                       ->join(C('DB_PREFIX')."article_section".C('DB_SUFFIX')." act_sec ON act.cid=act_sec.id")
                       ->where("act_sec.model=1")
                       ->order('act.sort asc')
                       ->page($page)
                       ->select();
        $section = M("ArticleSection");
        $sections = array();
        foreach ($articles as $k => $a) {
            $sections[$k] = $section->where("id=" . $a['cid'])->find();
            $item = $article->where("cid={$articles[$k]["id"]} and add_time={$articles[$k]["add_time"]}")->getField("id,sort,add_time");
            foreach ($item as $a)
                $item = $a;
            $articles[$k]["id"] = $item["id"];
            $articles[$k]["sort"] = $item['sort'];
        }
        
        $this->assign("list", $articles);
        $this->assign("section", $sections);
        $this->assign('message', isset($_REQUEST['message']) ? C($_REQUEST['message']) : '');
        $this->display("lists");
    }

    //文章列表
    public function article_list() {
        $article = M("Article");
        $get = init_request();
        $articles = $article->where('cid=' . $get[0])->page($_GET['p'] . ',15')->select();
        $count = $article->where('cid=' . $get[0])->count();
        $Page = new Page($count, 15); // 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page->show(); // 分页显示输出
        $this->assign('page', $show); // 赋值分页输出
        $section = M("Section");
        $section = $section->select();
        $this->assign('id', $get[0]);
        $this->assign('articles', $articles);
        $this->assign('section', $section);
        $this->assign('message', isset($_REQUEST['message']) ? C($_REQUEST['message']) : '');
        $this->assign("flag", $messge);
        $this->display("Article_list");
    }

    //编辑文章
    public function edit() {
        $id = $_GET['id'];
        unset($_GET['id']);
        $artcs = M("Article");
        if (isset($_POST['save'])) {
            $data = $_POST;
            $data["publish_id"] = $_SESSION['admin_id'];
            $data["type"] = 1;
            $data["add_time"] = time();
            $artcs->create($data);
            $artcs->where("id=$id")->save();
            $this->success("修改成功！", "onepage/lists");
        } else {
            $section = M("ArticleSection");
            $a_sections = $section->where("model=1 and status=1")->select();
            $artcs = M("Article");
            $article = $artcs->where("id=$id")->find();
            $this->assign("id", $id);
            $this->assign("a_sections", $a_sections);
            $this->assign("article", $article);
            $this->display();
        }
    }

    //删除文章
    public function del() {
        $get = init_request();
        $BaseConfig = M("Article");
        $BaseConfig->where('id=' . $get[0])->delete();
        $this->redirect('lists');
    }

    //公司简介
    public function propaganda() {
        $article_edit = M("Article");
        if (!isset($_POST['submit'])) {
            $get = init_request();
            $objArticle = $article_edit->where('id=' . $get[0])->find();
            $this->assign('objArticle', $objArticle);
            $this->display('propa');
            exit;
        } else {
            $data = $article_edit->create();
            $data['cid'] = 0;
            $data['times'] = date('Y-m-d H:i:s');
            if ($article_edit->save($data)) {
                $message = '更新成功';
                $this->assign('message', $message);
            } else {
                $message = '更新失败';
                $this->assign('message', $message);
            }
            $this->display('propa');
        }
    }

    //栏目列表
    function cates($selected = 0, $parent_id = 0, $m = -1) {
        $sec = M("section");
        $res = $sec->where("pid=$parent_id and cid!=3")->order('sort ASC,cid ASC')->select();
        $n = str_pad('', $m, '-', STR_PAD_RIGHT);
        $n = str_replace('-', '&nbsp;&nbsp;', $n);

        $options = '';
        static $i = 0;
        if ($res) {
            $n++;
            foreach ($res as $key => $val) {
                $i++;
                $options .= $val['id'] . "^" . $val['cid'] . "^" . $val['model'] . "^" . $val['sort'] . "^" . $val['id'] . "^" . $val['navigation'] . "^";
                if ($val['pid'] == 0) {
                    $head = "┣ ";
                    $options .= $head . $val['names'] . "#";
                } else
                    $options .= $n . "├  " . $val['names'] . "#";
                $options .= self :: cates($selected, $val['id'], $m + 4);
            }
        }
        return $options;
    }

    public function lift() {
        $str = self :: cates();
        $str = rtrim($str, '#');
        $arr = explode('#', $str);
        $counts = count($arr);
        for ($e = 0; $e < $counts; $e++) {
            $es = $arr[$e];
            $rr = explode('^', $es);
            $aa[] = $rr;
        }
        //dump($aa);
        $this->assign('lists', $aa);
        $this->assign('message', $message);
        $this->display(lift);
    }

    public function edit_singly() {
        if (!isset($_POST['submit'])) {
            $get = init_request();
            $cid = $_GET["get"];
            $message = $_GET["message"];
            $Singly = M("Singly");
            if ($cid) {
                $singlys = $Singly->where('cid=' . $cid)->find();
            } else {
                $singlys = $Singly->where('cid=' . $get[0])->find();
            }
            $this->assign('message', $message);
            $this->assign('list', $singlys);
            $this->display();
        } else {
            $Singly = M("Singly");
            if ($Singly->create()) {
                $cid = $_POST['cid'];
                $ids = $Singly->save();
                if (false !== $ids) {
                    $this->redirect('edit_singly', array('get' => $cid, 'message' => '编辑成功'));
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

    //添加文章
    public function add() {
        if (isset($_POST["save"])) {
            $article = M("Article");
            $data = $_POST;
            $data["publish_id"] = $_SESSION['admin_id'];
            $data["type"] = 1;
            $data["add_time"] = time();
            $article->create($data);
            $article->add();
            $this->success("添加成功！", "lists");
        } else {
            $section = M("ArticleSection");
            $a_sections = $section->where("model=1 and status=1")->select();
            $this->assign("a_sections", $a_sections);
            $this->display();
        }
    }

    public function ajax_save() {
        $id = $_POST['id'];
        unset($_POST['id']);
        $article = M("Article");
        if ($article->table(C('DB_PREFIX') . "article" . C('DB_SUFFIX') . " act")
                ->join(C('DB_PREFIX') . "article_section" . C('DB_SUFFIX') . " act_sec ON act.cid=act_sec.id")
                ->where("act_sec.model=1 and title='{$_POST["title"]}'")
                ->count() > 0) {
            $this->ajaxReturn(0);
            exit;
        }
        $article->create();
        $article->where("id=$id")->save();
        $this->ajaxReturn(1);
    }

    public function ajax_del() {
        $id = $_POST['id'];
        unset($_POST['id']);
        $article = M("Article");
        $article->where("id=$id")->delete();
        $this->ajaxReturn(1);
    }
    
    public function sort_list() {
        $article = M("Article");
        foreach ($_POST["sort"] as $key => $val) {
            $article->where("id={$key}")->setField("sort", $val);
        }
        $this->redirect("lists");
    }
    
    public function deleteall() {
        if (isset($_POST['dosubmit'])) {
            $done = false;
            $Article = M("Article");
            $count = $Article->count();
            $id = $Article->getField("id", true);
            for ($i = 0; $i < $count; $i++) {
                if ($_POST["items_" . $id[$i]]) {
                    $Article->where("id=" . $id[$i])->delete();
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

}

?>