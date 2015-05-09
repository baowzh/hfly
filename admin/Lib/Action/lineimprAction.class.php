<?php

class lineimprAction extends CommonAction {

    public function show_list() {
        $lineImpr_table = M('line_impr')->getTableName() . " impr";
        $line_order_table = M('line_order')->getTableName() . " orders";
        $line_table = M('line')->getTableName() . " line";
        $count = M()->table($lineImpr_table)->count();
        $page = $this->pagebar($count);
        $list = M()->table($lineImpr_table)->join("$line_order_table on impr.order_id=orders.id")->join("$line_table on orders.line_id=line.id")->field("impr.*,orders.status")->page($page)->select();
        $this->assign("list", $list);
        $this->display();
    }

    public function select_win() {
        $id = $_GET['id'];
        $lineImpr = M('line_impr');
        $line_order = M('line_order');
        $line = M('line');
        $list = $lineImpr->where("id='$id'")->find();
        $list['line_id'] = $line_order->where("id='{$list['order_id']}'")->getfield('line_id');
        $list['names'] = $line->where("id='{$list['line_id']}'")->getfield("names");
        $this->assign("list", $list);
        $this->display();
    }

    public function award() {
        $lineImpr_table = M('line_impr')->getTableName() . " impr";
        $line_order_table = M('line_order')->getTableName() . " orders";
        $line_table = M('line')->getTableName() . " line";
        $user = M('user');
        $bonus_comm = empty($_POST['bonus_comm']) ? 0 : $_POST['bonus_comm'];
        $id = $_GET['id'];
        $list = M()->table($lineImpr_table)->join("$line_order_table on impr.order_id=orders.id")->where("impr.id = '$id'")->join("$line_table on orders.line_id=line.id")->field("impr.*,orders.status,orders.user_id,orders.review_award")->find();
        if (!$_POST) {
            $this->assign("money", (int)$list['review_award']);
            $this->display();
        } else {
            $user->where("id='{$list['user_id']}'")->setInc('award', $bonus_comm); //修改奖金
            M()->table($line_order_table)->where("id='{$list['order_id']}'")->setfield("status", 6);
        }
    }

    public function deleteall() {
        if (!isset($_POST["items"])) {
            $this->error("至少选中一项！");
        }
        $Line = M('line_impr');
//        $picpath = $Line->where("id=$id")->getField("picpath");
        foreach ($_POST["items"] as $id) {
            $Line->where("id=$id")->delete();
        }
        $this->success("删除成功", U("show_list"));
    }

}

?>
