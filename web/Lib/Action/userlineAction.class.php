<?php

/**
 * 会员中心
 */
class userlineAction extends usercommonAction {

    public function route_mag() {
        $lineOrder = M('lineOrder');
        $user_table = M('user')->getTableName() . " user";
        $order_table = $lineOrder->getTableName() . " line_order";
        $line_table = M('line')->getTableName() . " line";
        $id = $_SESSION['user_id'];
        
        $where['line_order.user_id'] = array("eq",$id);
        if(!empty($_GET['s'])){
            $where['line_order.status'] = $_GET['s'];
        }
        $count = $lineOrder->table($order_table)->where($where)->count(); // 查询满足要求的总记录数,不带订单状态
        $page = $this->pagebar($count);
        $list = $lineOrder->table($order_table)
                ->field("*,line_order.status o_status,line_order.id o_id,line_order.create_time,line_order.code,line_order.amount")
                ->join("$user_table on user.id=line_order.user_id")
                ->join("$line_table on line.id=line_order.line_id")
                ->order("line_order.create_time desc")
                ->where($where)
                ->page($page)
                ->select();
        foreach ($list as $k => $v) {
            $list[$k]['total_money'] = $v['adult_num'] * $v['adult_money'] + $v['child_num'] * $v['child_money'];
        }
        $this->assign("list", $list);
        $this->display();
    }

    public function route_order() {
        $id = $_GET['id'];
        $user_id = $_SESSION['user_id'];
        $lineOrder = M('lineOrder');
        $user_table = M('user')->getTableName() . " user";
        $order_table = $lineOrder->getTableName() . " line_order";
        $line_table = M('line')->getTableName() . " line";

        $list = $lineOrder->table($order_table)
                ->field("*,line_order.status o_status,line_order.id o_id,line_order.code")
                ->join("$user_table on user.id=line_order.user_id")
                ->join("$line_table on line.id=line_order.line_id")
                ->where("line_order.id='$id' AND line_order.user_id = '$user_id'")
                ->find();
        $guest_list = M('order_userinfo')->field('*')->where("order_id='{$list['o_id']}'")->select();
        $list['total_money'] = $list['adult_num'] * $list['adult_money'] + $list['child_num'] * $list['child_money'];
        $list['earnest'] = $list['front_money'] / 100 * $list['total_money'];
        $this->assign("guest_list", $guest_list);
        $this->assign("list", $list);
        $this->display();
    }

    /**
     * 点评
     */
    public function route_impr() {
        $user_id = $_SESSION['user_id'];
        $id = $_GET['id'];
        $lineOrder = M('lineOrder');
        $lineImpr = M('lineImpr');
        $commImpr = M('commImpr');
        $impr_ag = $lineImpr->where("order_id='$id'")->find();
        if ($impr_ag) {
            $this->error("该订单已评论！", U('userline/route_mag'));
            exit;
        }
        if (!$_POST) {
            $user_table = M('user')->getTableName() . " user";
            $order_table = $lineOrder->getTableName() . " line_order";
            $line_table = M('line')->getTableName() . " line";
            $impr_table = $lineImpr->getTableName() . " impr";

            $order_status = $lineOrder->where("id='$id' and user_id='$user_id'")->getfield('status');
            if ($order_status != 4) {
                $this->error("该订单无法点评!", U('userline/route_mag'));
                exit;
            }
            $list = $lineOrder->table($order_table)
                    ->field("*,line_order.status o_status,line_order.id o_id")
                    ->join("$user_table on user.id=line_order.user_id")
                    ->join("$line_table on line.id=line_order.line_id")
                    ->join("$impr_table on impr.order_id=line_order.id")
                    ->where("line_order.id='$id' AND line_order.user_id = '$user_id'")
                    ->find();

            $imprlist = $commImpr->where("types='LINE'")->select();
            $this->assign("imprlist", $imprlist);
            $this->assign("list", $list);
            $this->display();
        } else {
            $order_table = $lineOrder->getTableName() . " line_order";
            $impr_table = $lineImpr->getTableName() . " impr";

            $order_status = $lineOrder->where("id='$id'")->getfield('status');
            if ($order_status != 4) {
                $this->error("订单状态异常!", U('userline/route_mag'));
                exit;
            }
            $order_info = $lineOrder->table($order_table)
                    ->join("$impr_table on impr.order_id=line_order.id")
                    ->where("line_order.id='$id' AND line_order.user_id = '$user_id'")
                    ->find();
            if (!$order_info) {
                $this->error("添加订单失败！", U('userline/route_mag'));
                exit;
            }
            $impr_ag = $lineImpr->where("order_id='$id'")->find();
            if ($impr_ag) {
                $this->error("该订单已评论！", U('userline/route_mag'));
                exit;
            }
            $impr_arr = array("travel" => $_POST['travel'], "guide" => $_POST['guide'], "traffic" => $_POST['traffic'], "room" => $_POST['room']);
            if ($lineImpr->create()) {
                $impr_id = join(",", $_POST['impr']);
                $lineImpr->impr_id = $impr_id;
                $lineImpr->order_id = $id;
                $lineImpr->point = impr_point($impr_arr);
                $lineImpr->create_time = time();
                $lineImpr->status = 1;
                $lineImpr->add();
                $lineOrder->where("id='$id'")->setField('status', '5');
                $this->success("评论成功！", U("userline/route_mag"));
            } else {
                $this->error("评论失败！", U("userline/route_mag"));
            }
        }
    }

    /**
     * 撤销
     */
    public function del_order() {
        $id = $_GET['id'];
        $lineOrder = M('lineOrder');
        $award = $lineOrder->where("id='$id' and user_id='{$_SESSION['user_id']}'")->getfield("used_award");
        $card = $lineOrder->where("id='$id' and user_id='{$_SESSION['user_id']}'")->getfield("used_card");
        M('user')->where("id='{$_SESSION['user_id']}'")->setInc('award', $award);
        $coupon = D('cash_coupon');
        $coupon->back_coupon($card,$_SESSION['user_id']);
        $order_status = $lineOrder->where("id='$id'")->getField('status');
        if (!($order_status == 1 || $order_status == 2)) {
            $this->error("撤销订单错误");
        }
        if ($lineOrder->where("id='$id'")->setField("status", "7")) {
            $this->success("撤销订单成功！");
        } else {
            $this->error("撤销订单失败！");
        }
    }

//线路点评
    public function route_review() {
        $lineImpr = M('lineImpr');
        $lineOrder = M('lineOrder');
        $commImpr = M('commImpr');
        $user_table = M('user')->getTableName() . " user";
        $order_table = $lineOrder->getTableName() . " line_order";
        $line_table = M('line')->getTableName() . " line";
        $impr_table = $lineImpr->getTableName() . " impr";
        $id = $_SESSION['user_id'];

        $count = $lineImpr->table($impr_table)
                ->join("$order_table on line_order.id = impr.order_id")
                ->join("$line_table on line.id = line_order.line_id")
                ->join("$user_table on line_order.user_id = user.id")
                ->where("user.id='$id'")
                ->count(); // 查询满足要求的总记录数,不带订单状态
        $page = $this->pagebar($count);
        $list = $lineImpr->table($impr_table)
                ->join("$order_table on line_order.id = impr.order_id")
                ->join("$line_table on line.id = line_order.line_id")
                ->join("$user_table on line_order.user_id = user.id")
                ->page($page)
                ->where("user.id='$id'")
                ->select();
        foreach ($list as $k => $v) {

            $arr = explode(",", $v['impr_id']);
            foreach ($arr as $s => $b) {
                $list[$k]['impr_name'][] = $commImpr->where("types='LINE' AND id='$b'")->getField('names');
            }
        }
        $this->assign("list", $list);
        $this->display();
    }

    public function route_questions() {
        $id = $_SESSION['user_id'];
        $line_que = M('line_que');
        $line = M('line');
        $count = $line_que->where("user_id='$id'")->count(); // 查询满足要求的总记录数,不带订单状态
        $page = $this->pagebar($count);
        $que_list = $line_que->table($line_que->getTableName() . " que")->join($line->getTableName() . " line on line.id=que.line_id")->where("que.user_id='$id'")->page($page)->select();
        $this->assign("list", $que_list);
        $this->display();
    }

    public function route_coll() {
        $id = $_SESSION['user_id'];
        $line_keep = M('line_keep');
        $keep_table = $line_keep->getTableName() . " keep";
        $line_table = M('line')->getTableName() . " line";
        $count = $line_keep->where("user_id = '$id'")->count(); // 查询满足要求的总记录数,不带订单状态
        $page = $this->pagebar($count);
        $list = $line_keep->table($keep_table)
                ->field("*,keep.id kid")
                ->join("$line_table on line.id=keep.line_id")
                ->page($page)
                ->where("keep.user_id = '$id'")
                ->select();
        $this->assign("list", $list);
        $this->display();
    }

    public function route_coll_del() {
        $id = $_GET['id'];
        $uid = $_SESSION['user_id'];
        $line_keep = M('line_keep');
        if ($line_keep->where("user_id = '$uid' AND id = '$id'")->delete()) {
            $this->success("删除成功！");
        } else {
            $this->success("删除失败！");
        }
    }

}

?>
