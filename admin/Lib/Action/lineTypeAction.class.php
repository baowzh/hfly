<?php

/**
 * Description of LineTypeAction
 *
 * @author Gemini
 */
class linetypeAction extends CommonAction {

    public function index() {
        $linetype = M("LineType");
        $types = $linetype->order("sort")->select();
        $this->assign("types", $types);
        $this->display();
    }

    public function add() {
        if (isset($_POST["submit"])) {
            $linetype = M("LineType");
            if ($linetype->create()) {
                $LineType->names = $_POST['names'];
                $LineType->page_names = $_POST['page_names'];
                $LineType->sort = $_POST['sort'];
                $LineType->status = $_POST['status'];
                $linetype->add();
                $this->redirect("index");
            } else {
                $this->assign("message", $linetype->getError());
            }
        }
        $this->display();
    }

    public function ajax_save() {
        header('Content-Type:text/html;charset=utf-8');
        $id = $_GET['id'];
        $names = $_POST['names'];
        $page_names = $_POST['page_names'];
        $sort = $_POST['sort'];
        $LineType = M('LineType');
        $LineType->create();
        $LineType->id = $id;
        $LineType->names = $names;
        $LineType->page_names = $page_names;
        $LineType->sort = $sort;
        $LineType->save();
        echo 1;
        exit;
    }

    public function ajax_del() {
        header('Content-Type:text/html;charset=utf-8');
        $LineType = M('LineType');
        $id = $_GET['id'];
        $LineType->where("id=$id")->delete();
        echo 1;
        exit;
    }

}

?>
