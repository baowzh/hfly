<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LinePriceModel
 *
 * @author Administrator
 */
class LinePriceModel extends Model {

    private $tmp_line_id = 0;

    public function _initialize() {
        $this->tmp_line_id = $_POST["line_id"] ? intval($_POST["line_id"]) : 0;
        parent::_initialize();
    }

    public function update_4() {
        $map = array(
            "line_id" => array('eq', $this->tmp_line_id),
            'price_type' => array('eq', 4),
        );
        $find = $this->where($map)->find();
        if ($find) {          
            $this->create();
            $this->line_id=$this->tmp_line_id;
            $this->price_type = 4;
            $this->price_date = 0;
            $this->price_date_end = 0;
            $this->where("id=".$find["id"])->save();            
        } else {
            unset($this->id);
            $this->create();
            $this->line_id=$this->tmp_line_id;
            $this->price_type = 4;
            $this->price_date = 0;
            $this->price_date_end = 0;
            $this->add();
        }
    }

    public function update_3() {
        for ($day = 1; $day < 8; $day++) {
            $RACKRATE = $_POST['date_RACKRATE_' . $day] ? $_POST['date_RACKRATE_' . $day] : 0;
            $adult = $_POST['date_adult_' . $day] ? $_POST['date_adult_' . $day] : 0;
            $children = $_POST['date_children_' . $day] ? $_POST['date_children_' . $day] : 0;
            if ($RACKRATE || $adult || $children) {
                $map = array(
                    "line_id" => array('eq', $this->tmp_line_id),
                    'price_type' => array('eq', 3),
                    "price_date" => array(eq, $day)
                );
                $find = $this->where($map)->find();
                if ($find) {                    
                    $this->create();
                    $this->line_id=$this->tmp_line_id;
                    $this->price_type = 3;
                    $this->price_date = $day;
                    $this->price_date_end = 0;
                    $this->RACKRATE = $RACKRATE;
                    $this->price_adult = $adult;
                    $this->price_children = $children;
                    $this->where("id=".$find["id"])->save();                    
                } else {
                    unset($this->id);
                    $this->create();
                    $this->line_id=$this->tmp_line_id;
                    $this->price_type = 3;
                    $this->price_date = $day;
                    $this->price_date_end = 0;
                    $this->RACKRATE = $RACKRATE;
                    $this->price_adult = $adult;
                    $this->price_children = $children;
                    $this->add();
                }
            }
        }
    }

    public function update_2() {
        $map = array(
            "line_id" => array('eq', $this->tmp_line_id),
            'price_type' => array('eq', 2),
        );
        $select = $this->where($map)->select();

        foreach ($select as $sv) {
            if (!in_array($sv['id'], $_POST["date_id"])) {
                $map = array(
                    "id" => array('eq', $sv['id']),
                    'price_type' => array('eq', 2),
                );
                $this->where($map)->delete();
            }
        }
        if ($_POST['date_start']) {
            foreach ($_POST['date_start'] as $key => $val) {
                $map = array(
                    "line_id" => array('eq', $this->tmp_line_id),
                    'price_type' => array('eq', 2),
                    "id" => array(eq, $key)
                );
                $find = $this->where($map)->find();
                if ($find) {
                    $this->create();
                    $this->line_id=$this->tmp_line_id;
                    $this->price_type = 2;
                    $this->price_date = strtotime($val);
                    $this->price_date_end = strtotime($_POST['date_end'][$key]);
                    $this->RACKRATE = $_POST['stage_RACKRATE'][$key];
                    $this->price_adult = $_POST['stage_adult'][$key];
                    $this->price_children = $_POST['stage_children'][$key];
                    $this->where("id=".$find["id"])->save();
                } else {
                    unset($this->id);
                    $this->create();
                    $this->line_id=$this->tmp_line_id;
                    $this->price_type = 2;
                    $this->price_date = strtotime($val);
                    $this->price_date_end = strtotime($_POST['date_end'][$key]);
                    $this->RACKRATE = $_POST['stage_RACKRATE'][$key];
                    $this->price_adult = $_POST['stage_adult'][$key];
                    $this->price_children = $_POST['stage_children'][$key];
                    $this->add();
                }
            }
        }
        if ($_POST["date_start_tmp"]) {
            foreach ($_POST['date_start_tmp'] as $key => $val) {
                unset($this->id);
                $this->create();
                $this->line_id=$this->tmp_line_id;
                $this->price_type = 2;
                $this->price_date = strtotime($val);
                $this->price_date_end =strtotime($_POST['date_end_tmp'][$key]);
                $this->RACKRATE = $_POST['stage_RACKRATE_tmp'][$key];
                $this->price_adult = $_POST['stage_adult_tmp'][$key];
                $this->price_children = $_POST['stage_children_tmp'][$key];
                $this->add();
            }
        }
    }

    public function update_1() {
    	
        $empty_val = create_function('$var', 'return !($var==""||$var=="0,0,0");');
        $data=array_filter($_POST["day_val"], $empty_val);      
        if ($data) {
            foreach ($data as $key => $val) {
                $map = array(
                    "line_id" => array('eq', $this->tmp_line_id),
                    'price_type' => array('eq', 1),
                    "price_date" => array(eq, strtotime($key))
                );
                $find = $this->where($map)->find();
                $price=  explode(",", $val);
                if ($find) {                   
                    $this->create();
                    $this->line_id=$this->tmp_line_id;
                    $this->price_type = 1;
                    $this->price_date = strtotime($key);
                    $this->price_date_end = 0;
                    $this->RACKRATE = $price[0];
                    $this->price_adult = $price[1];
                    $this->price_children = $price[2];
                    $this->where("id=".$find["id"])->save();
                } else {
                    unset($this->id);
                    $this->create();
                    $this->line_id=$this->tmp_line_id;
                    $this->price_type = 1;
                    $this->price_date = strtotime($key);
                    $this->price_date_end = 0;
                    $this->RACKRATE = $price[0];
                    $this->price_adult = $price[1];
                    $this->price_children = $price[2];
                    $this->add();
                }
            }
        }
        $map = array(
            "line_id" => array('eq', $this->tmp_line_id),
            'price_type' => array('eq', 1),
        );
        $select = $this->where($map)->select();
        foreach ($select as $sv) {
            $key = date("Ymd", $sv['price_date']);
            if (!array_key_exists($key, $data)) {
                $map = array(
                    'price_type' => array('eq', 1),
                    "line_id" => array('eq', $this->tmp_line_id),
                    "id"=>$sv["id"]
                );
                $this->where($map)->delete();
            }
        }
    }

}

?>
