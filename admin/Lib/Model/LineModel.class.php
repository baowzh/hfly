<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LineModel
 *
 * @author Gemini
 */
class LineModel extends Model {

    protected $_validate = array(
        array("names", "require", "线路名称必须填写", 1),
        array("code", "require", "线路编号必须填写", 1),
        array("trip_days", "/^[1-9]\d*$/", "请输入一个有效且大于1的数字作为天数", 1),
        array("traffic", "require", "请填写往返交通方式", 1),
       // array("target", "check_call", "至少选择一个目的地地址", 1, 'callback', 3),
        array("front_money", "/^[1-9]\d*$/", "请用0到100之间的数作为订金的百分比", 1),
        array("sort", "/^[0-9]\d*$/", "请输入一个有效数字作为排序字段", 1),
        array("linebelongto", "require", "线路归属地区必须填写", 1)
    );
    protected $_auto = array(
        array('target', 'implode_call', 3, 'callback'),
        array('target_topic', 'target_topic_call', 3, 'callback'),
    );

    protected function implode_call($data) {
        return implode(',', $data);
    }

    protected function check_call($data) {
        return !empty($data);
    }

    protected function target_topic_call() {
        $topic_id = M("line_target")->where("id in (" . join(",", $_POST["target"]) . ")")->group("topic_id")->getField("id,topic_id");        
        return join(",", $topic_id);       
    }

}

?>
