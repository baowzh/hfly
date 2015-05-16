<?php

class lineorderAction extends CommonAction {

    public function show_list() {
        $lineOrder = M('linePin');
        $where = array();
        if (!empty($_GET['names'])) {
            $where["orderid"] = array("like", "%{$_GET['names']}%");
            $where['names'] = array("like", "%{$_GET['names']}%");
            $where['_logic'] = 'OR';
            $this->assign("search_key", $_GET['names']);
        }else{
            $where='1=1';
        }
        $count=$lineOrder->where($where) ->count();
        $page=  $this->pagebar($count);
        $list = $lineOrder->where($where)->order("id desc")->page($page)->select();
        $this->assign("list", $list);
        $this->display();
    }

    public function select_win() {
        $id = $_GET['id'];
        $lineOrder = M('linePin');
        $user_table = M('user')->getTableName() . " user";
        $order_table = $lineOrder->getTableName() . " line_pin";
        $line_table = M('line')->getTableName() . " line";
        $order_userinfo = M('order_userinfo');
        $list = $lineOrder->table($order_table)
                ->field("*,line_pin.status o_status,line_pin.id o_id,line_pin.front_money o_front_money,line_pin.amount o_amount")
               // ->join("$user_table on user.id=line_pin.user_id")
                ->join("$line_table on line.id=line_pin.line_id")
                ->where("line_pin.id='$id'")
                ->find();
        $order_userinfo = M('order_userinfo');
        $order_userinfolist = $order_userinfo->where("order_id='$id' and type='LINE'")->select();
        $list['total_money'] = $list['o_amount'];
        $this->assign("list", $list);
        $this->assign("order_userinfolist", $order_userinfolist);
        $this->display();
    }

    public function edit_win() {
        if (!$_POST) {
            $id = $_GET['id'];
            $lineOrder = M('lineOrder');
            $user_table = M('user')->getTableName() . " user";
            $order_table = $lineOrder->getTableName() . " line_pin";
            $line_table = M('line')->getTableName() . " line";
            $order_userinfo = M('order_userinfo');
            $list = $lineOrder->table($order_table)
                    ->field("*,line_pin.status o_status,line_pin.id o_id,line_pin.front_money o_front_money,line_pin.amount o_amount")
                   // ->join("$user_table on user.id=line_pin.user_id")
                    ->join("$line_table on line.id=line_pin.line_id")
                    ->where("line_pin.id='$id'")
                    ->find();
            if (!in_array($list['o_status'], array('1', '2'))) {
                $this->error("订单状态不可编辑!");
            }
            $order_userinfo = M('order_userinfo');
            $order_userinfolist = $order_userinfo->where("order_id='$id' and type='LINE'")->select();
            $list['total_money'] = $list['o_amount'];
            $this->assign("list", $list);
            $this->assign("order_userinfolist", $order_userinfolist);
            $this->display();
        } else {
            $id = $_GET['id'];
            $lineOrder = M('lineOrder');
            if ($data = $lineOrder->create()) {
                $lineOrder->where("id='$id'")->save();
                $this->success("编辑成功！", U('show_list'));
            } else {
                $this->error("编辑失败！");
            }
        }
    }

    //处理状态
    public function set_status() {
        $id = $_GET['id'];
        $lineOrder = M('linePin');
        $orderinfo = $lineOrder->where("id='$id'")->find();
        if ($orderinfo['status'] == 1) {
            $orderinfo = $lineOrder->where("id='$id'")->setField('status', '2');
            $this->success("订单处理成功！");
        } elseif ($orderinfo['status'] == 3) {
            $orderinfo = $lineOrder->where("id='$id'")->setField('status', '4');
            $this->success("订单处理成功！");
        } elseif ($orderinfo['status'] == 5) {
            $orderinfo = $lineOrder->where("id='$id'")->setField('status', '6');
            $this->success("订单处理成功！");
        } else {
            $this->error("订单状态错误！");
        }
    }

}

?>