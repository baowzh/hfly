<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of seoModel
 *
 * @author Administrator
 */
class seoModel extends Model {

    public function set_seo($id, $table) {
        $data = array(
            "relate_id" => $id,
            "relate_table" => $table,
            "seo_title" => isset($_POST["seo_title"])?$_POST["seo_title"]:$_POST["title"],
            "seo_keywords" => $_POST["seo_keywords"],
            "seo_description" => $_POST["seo_description"],
        );
        $condition = array("relate_id" => $id, "relate_table" => $table);
        $old = $this->where($condition)->find();
        if ($old) {
            $this->where("id=" . $old["id"])->save($data);
        } else {
            $this->add($data);
        }
        return;
    }

    public function get_seo($id, $table) {
        $condition = array("relate_id" => $id, "relate_table" => $table);
        return $this->where($condition)->find();
    }

}

?>
