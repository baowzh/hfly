<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LineTravelModel
 *
 * @author Gemini
 */
class LineTravelModel extends Model {

    public function insertdata($insert_id) {
        $data["line_id"] = $insert_id;
        $i = 1;
        $insert_id_arr = array();
        while (isset($_POST['title_' . $i])) {
            $data["title"] = $_POST['title_' . $i];
            $data["day"] = $i;
            $data["dining"] = join(',',$_POST['dining_' . $i]);
            $data["stay"] = $_POST['stay_' . $i];
            $this->data($data)->add();
            $insert_id_arr[$i] = $this->getLastInsID();
            $i++;
        }
        return $insert_id_arr;
    }

    public function update($id) {
        $data["line_id"] = $id;
        $i = 1;
        $update_id_arr = array();
        while (isset($_POST['title_' . $i])) {            
            $data["title"] = $_POST['title_' . $i];
            $data["day"] = $i;
            $data["dining"] = implode(',',$_POST['dining_' . $i]);
            $data["stay"] = $_POST['stay_' . $i];
            $olddata = $this->where("line_id=" . $id . " and day=" . $i)->field("id")->find();
            if ($olddata) {
                $this->where("line_id=" . $id . " and day=" . $i)->save($data);
                $update_id_arr[$i] =$olddata["id"];
            }
            else{
                $this->data($data)->add();
                $update_id_arr[$i] = $this->getLastInsID();
            }            
            $i++;
        }
        $this->where("line_id=" . $id . " and day>=" . $i)->delete();
        return $update_id_arr;
    }

}

?>
