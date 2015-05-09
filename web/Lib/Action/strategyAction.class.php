<?php

/**
 * 会员中心
 */
class strategyAction extends usercommonAction {

    //出发年份
    private $year_go = array('2001', '2002', '2003', '2004', '2005', '2006', '2007', '2008', '2009', '2010', '2011', '2012', '2013');
    //出发月份
    private $month_go = array('01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12');

    public function add_strategy() {
        C('TOKEN_ON', false);
        $id = $_SESSION['user_id'];
        if (!$_POST) {
            $this->assign("month", $this->month_go);
            $this->assign("year", $this->year_go);
            $this->display();
        } else {
            $travel_strategy = M('travel_strategy');
            if ($travel_strategy->create()) {
                $travel_strategy->go_time = mktime(0, 0, 0, $_POST['go_month'], 1, $_POST['go_year']);
                $travel_strategy->publish_id = $id;
                $travel_strategy->hit = 0;
                $travel_strategy->create_time = time();
                $travel_strategy->sort = 0;
                $travel_strategy->status = 1;
                $travel_strategy->add();
                $this->success("旅游攻略添加成功!");
            } else {
                $this->error("旅游攻略添加失败," . $travel_strategy->getError());
            }
        }
    }

    public function management_strategy() {
        $id = $_SESSION['user_id'];
        $travel_strategy = M('travel_strategy');
        $strategy = $travel_strategy->where("publish_id = '$id'")->select();
        $this->assign("list", $strategy);
        $this->display();
    }

    public function edit_strategy() {
        $uid = $_SESSION['user_id'];
        $id = $_GET['id'];
        $travel_strategy = M('travel_strategy');
        $file_manager = M('file_manager');
        if (!$_POST) {
            $strategy = $travel_strategy->where("id='$id' AND publish_id='$uid'")->find();
            $strategy['pic_path'] = __ROOT__ . $file_manager->where("id='{$strategy['pic']}'")->getfield('path');
            $strategy['go_year'] = date("Y", $strategy['go_time']);
            $strategy['go_month'] = date("m", $strategy['go_time']);
            $this->assign("month", $this->month_go);
            $this->assign("year", $this->year_go);
            $this->assign("list", $strategy);
            $this->display();
        } else {
            if ($travel_strategy->create()) {
                $travel_strategy->where("id='$id' AND publish_id='$uid'")->save();
                $this->success("编辑成功！");
            } else {
                $this->error("编辑失败！" . $travel_strategy->getError());
            }
        }
    }

    /**
     * 查看攻略
     */
    public function select_strategy() {
        $uid = $_SESSION['user_id'];
        $id = $_GET['id'];
        dump($uid);
        dump($id);
    }
    
    public function coll_strategy(){
        $uid = $_SESSION['user_id'];
        $id = $_GET['id'];
        $travel_keep = M('travel_keep');
        $travel_strategy = M('travel_strategy');
        $keep_table = $travel_keep->getTableName()." keep";
        $stra_table = $travel_strategy->getTableName()." stra";
        $keep = $travel_keep->table($keep_table)->join("$stra_table on keep.pid = stra.id")->field("*,keep.id kid")->where("user_id='$uid'")->select();
        $this->assign("list",$keep);
        $this->display();
    }
    
    public function del_coll_strategy(){
        $id = $_GET['id'];
        $uid = $_SESSION['user_id'];
        $travel_keep = M('travel_keep');
        if($travel_keep->where("id='$id' AND user_id='$uid'")->delete()){
            $this->success("删除成功!");
        }else{
            $this->error("删除失败!");
        }
    }

}

?>
