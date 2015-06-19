<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LineTravelSectionModel
 *
 * @author Gemini
 */
class LineTravelSectionModel extends Model {

    public function insdata($insert_id, $insert_id_arr) {
        $data["line_id"] = $insert_id;
        foreach ($insert_id_arr as $k => $v) {
            $i = 1;
            while (isset($_POST['activity_title_' . $k . '_' . $i])) {
                $data["travel_id"] = $v;
                $data["names"] = $i;
                $data["title"] = $_POST['activity_title_' . $k . '_' . $i];
                $data["content"] = $_POST['activity_text_' . $k . '_' . $i];
                $this->data($data)->add();
                $i++;
            }
        }
    }

    public function getSection($data) {
        $secData = array();
        foreach ($data as $v) {
            $secData[$v['id']] = $this->where('travel_id=' . $v['id'])->order("names")->select();
        }
        return $secData;
    }

    public function update($id, $data_id) {
        $data["line_id"] = $id;
        foreach ($data_id as $k => $v) {
            $i = 1;
            while (isset($_POST['activity_title_' . $k . '_' . $i])) {
                $data["travel_id"] = $v;
                $data["names"] = $i;
                $data["title"] = $_POST['activity_title_' . $k . '_' . $i];
                $data["content"] = $_POST['activity_text_' . $k . '_' . $i];
                //print_r($data["content"]);
                //exit();
                $olddata = $this->where("line_id=" . $id . " and travel_id=" . $v . " and names=" . $i)->field("id")->find();
                if ($olddata) {
                    $this->where("line_id=" . $id . " and travel_id=" . $v . " and names=" . $i)->save($data);
                } else {
                    $this->data($data)->add();
                }                
                $i++;
            }
            $this->where("line_id=" . $id . " and travel_id=" . $v . " and names>=" . $i)->delete();
        }
        $this->where("line_id=" . $id . " and travel_id>" . $v)->delete();
    }

}

?>
