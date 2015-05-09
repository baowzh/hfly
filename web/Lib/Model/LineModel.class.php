<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LineAction
 *
 * @author Administrator
 */
class LineModel extends Model {

    private $pic_model;
    private $price_model;

    public function show_line($where, $limit = 4) {
        $line_info = $this->where($where)->limit($limit)->select();
        if ($line_info) {
            $line_infos = array();
            foreach ($line_info as $k => $v) {
                $pic = $this->get_pic($v['id']);
                $price = $this->get_price($v['id']);                
                $line_infos[$k] = is_array($pic) ? $v + $pic : $v;
                $line_infos[$k] = is_array($price) ? $line_infos[$k] + $price : $line_infos[$k];
            }
            return $line_infos;
        } else {
            return false;
        }
    }

    /**
     * 获取图片
     * @param type $line_id
     * @return type 
     */
    public function get_pic($line_id) {
        $pic_model = $this->pic_model ? $this->pic_model : M('LinePic');
        return $pic_model
                        ->where('line_id=' . $line_id)
                        ->order('istitlepage,sort')
                        ->field('names as pic_names,pic_small,pic_middle,pic_big,pic_path')
                        ->find();
    }

    /**
     * 获取价格
     * @param type $line_id
     * @return type 
     */
    public function get_price($line_id) {
        $price_model = $this->price_model ? $this->price_model : M('LinePrice');
        $now_time = strtotime(date("Y-m-d"));
        $price = $price_model
                ->where("price_type=1 and price_date='" . $now_time . "' and line_id=" . $line_id)
                ->field('RACKRATE,price_adult,price_children')
                ->find();
        if (!$price) {
            $price = $price_model
                    ->where("price_type=2 and price_date<='" . $now_time . "' and price_date_end>='" . $now_time . "' and line_id=" . $line_id)
                    ->field('RACKRATE,price_adult,price_children')
                    ->find();
        }
        if (!$price) {
            $day = date('w', $now_time);
            $day = $day > 0 ? $day : 7;
            $price = $price_model
                    ->where("price_type=3 and price_date='" . $day . "' and line_id=" . $line_id)
                    ->field('RACKRATE,price_adult,price_children')
                    ->find();
        }
        if (!$price) {
            $price = $price_model
                    ->where("price_type=4 and line_id=" . $line_id)
                    ->field('RACKRATE,price_adult,price_children')
                    ->find();
        }
        return $price;
    }

    /**
     * 获取热门目的地
     * @param $num int 获取记录的条数
     * @return $hot_target array 热门线路数组
     */
    public function get_hotest_targets($num=5) {
        $LineTarget = M('LineTarget');
        $Line = M("Line");

        /**
         * 读取热门目的地，并返回显示
         */
        $hotest_targets = $LineTarget
                ->table(M("LineTarget")->getTableName() . " line_target")
                ->join(M("Area")->getTableName() . " area ON line_target.area_id=area.id")
                ->where('classify=1')
                ->limit(5)
                ->field("line_target.*, area.names")
                ->select();

        foreach ($hotest_targets as $key=>$value) {
            $hotest_targets[$key]['min_price'] = $Line->
                table(M("Line")->getTableName() . " line")
                ->join(M("LinePrice")->getTableName() . " line_price ON line.id = line_price.line_id")
                ->where("line.target REGEXP '".$value['id']."$' or line.target REGEXP '".$value['id'].",'")
                ->min("price_adult");
        }   
        
        return $hotest_targets;
    }

    /**
     * 获取线路点评
     */
    public function get_line_comments() {
        //路线点评
        $line_order = M("line_order")->getTableName() . " orders";
        $line_impr = M("line_impr")->getTableName() . " impr";
        $line = M("line")->getTableName() . " line";

        $M = M();
        $impr_lists = $M->table($line_impr)->join($line_order . " on impr.order_id=orders.id")
                        ->join($line . " ON line.id=orders.line_id")
                        ->field("*,orders.create_time as order_time,impr.create_time as impr_time")
                        ->limit(10)
                        ->order("impr.create_time desc")->select();
        return $impr_lists;
    }
}