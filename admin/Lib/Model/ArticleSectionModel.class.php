<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ArticleSectionModel
 *
 * @author Administrator
 */
class ArticleSectionModel extends Model {

    public function get_section($id = 0) {
        $top_section = $this->where("pid=0")->select();
        if (!$top_section)
            return '';
        $section_str = '';
        foreach ($top_section as $top) {
            if ($id == $top["id"]) {
                $section_str.="<option value=\"{$top['id']}\" selected=\"selected\">{$top['names']}</option>";
            } else {
                $section_str.="<option value=\"{$top['id']}\">{$top['names']}</option>";
            }
            $section_str.=$this->sub_section($top['id'], $id);
        }
        return $section_str;
    }

    public function sub_section($pid, $id, $loop = "&nbsp;") {
        $sub_section = $this->where("pid=$pid")->select();
        if (!$sub_section)
            return '';
        $section_str = '';
        $count = count($sub_section);
        $i = 1;
        foreach ($sub_section as $sub) {
            $select = $id == $sub["id"] ? " selected=\"selected\"" : "";
            $node = $count == $i ? $loop . "└" : $loop . "├";
            $section_str.="<option value=\"{$sub['id']}\"{$select}>{$node}{$sub['names']}</option>";
            $section_str.=$this->sub_section($sub['id'], $id, $loop . "&nbsp;");
            $i++;
        }
        return $section_str;
    }

    public function get_section_table() {
        $top_section = $this->where("pid=0")->order("sort asc")->select();
        if (!$top_section)
            return '';
        $section_str = '';
        $_count = 0;
        foreach ($top_section as $top) {
            switch($top['model']){
                case 1:$mod = "单页模型";$url="onepage/lists";break;
                case 0:$mod = "文章模型";$url="article/lists";break;
            }
            $section_str.="<tr><td><input type=\"checkbox\" type=\"select_all\" class='item' name=\"id[]\" value=\"{$top['id']}\"></td>";
            $section_str.="<td style='text-align:left;width:240px'>{$top['names']}</td>";
            $section_str.="<td width=\"200\" style=\"display:none;\"><img border='0' style='max-width:180px;max-height:180px;' src='".__ROOT__.$top['pic_path']."'></td>";
            $count = M("article")->where("cid=" . $top['id'])->count();
            $section_str.="<td><a href=\"" . U($url, array("id" => $top["id"])) . "\">" . intval($count) . "</a></td>";
            $section_str.="<td>".$mod."</td>";
            $section_str.=$top["status"] == 1 ? "<td>启用</td>" : "<td>停用</td>";
            $section_str.="<td><a href=\"" . U("classify_edit", array("id" => $top["id"])) . "\">编辑</a> | ";
            $section_str.="<a href=\"" . U("classify_del", array("id" => $top["id"])) . "\" onClick=\"return atr_confirm(this.href,'确认要删除吗');\">删除</a></td></tr>";
            $dt = $this->sub_section_table($top['id']);
            $section_str.= $dt['section_str'];
            $_count+=intval($count);
            $_count+=$dt['count'];
        }
        $data['count'] = $_count;
        $data['section_str'] = $section_str;
        return $data;
    }

    public function sub_section_table($pid, $loop = "&nbsp;&nbsp;") {
        $sub_section = $this->where("pid=$pid")->order("sort asc")->select();
        if (!$sub_section)
            return '';
        $section_str = '';
        $count = count($sub_section);
        $i = 1;
        $_count = 0;
        foreach ($sub_section as $sub) {
            switch($sub['model']){
                case 1:$mod = "单页模型";$url="onepage/lists";break;
                case 0:$mod = "文章模型";$url="article/lists";break;
            }
            $section_str.="<tr><td><input type=\"checkbox\" type=\"select_all\" name=\"id[]\" class='item' value=\"{$sub['id']}\"></td>";
            $node = $count == $i ? "└─" : "├─";
            $section_str.="<td style='text-align:left;width:240px'>{$loop}{$node} {$sub['names']}</td>";
            $section_str.="<td width=\"200\" style=\"display:none;\"><img border='0' style='max-width:180px;max-height:180px;' src='".__ROOT__.$sub['pic_path']."'></td>";
            $articlecount = M("article")->where("cid=" . $sub['id'])->count();
            $section_str.="<td><a href=\"" . U($url, array("id" => $sub["id"])) . "\">" . intval($articlecount) . "</a></td>";
            $section_str.="<td>{$mod}</td>";
            $section_str.=$sub["status"] == 1 ? "<td>启用</td>" : "<td>停用</td>";
            $section_str.="<td><a href=\"" . U("classify_edit", array("id" => $sub["id"])) . "\">编辑</a> | ";
            $section_str.="<a href=\"" . U("classify_del", array("id" => $sub["id"])) . "\" onClick=\"return atr_confirm(this.href,'确认要删除吗');\">删除</a></td></tr>";
            $dt = $this->sub_section_table($sub['id'], $loop . "&nbsp;&nbsp;");
            $section_str.= $dt['section_str'];
            $_count+=intval($articlecount);
            $_count+=$dt['count'];
            $i++;
        }
        $data['count'] = $_count;
        $data['section_str'] = $section_str;
        return $data;
    }

    public function get_option($id, $select_id = "0") {
        $top_section = $this->where("id=$id")->find();
        if (!$top_section)
            return '';

        if ($top_section["id"] == $select_id) {
            $section_str.="<option value=\"{$top_section['id']}\" selected=\"selected\">{$top_section['names']}</option>";
        } else {
            $section_str.="<option value=\"{$top_section['id']}\">{$top_section['names']}</option>";
        }
        $section_str.=$this->sub_section($top_section['id'], $select_id);
        return $section_str;
    }    
   

    public function get_ids($id) {
        $reids = array($id => $id);
        $ids = $this->where("pid=$id")->field("id")->select();
        if (!$ids) {
            return $reids;
        }
        foreach ($ids as $v) {
            $subid = $this->get_ids($v['id']);
            $reids = (array) $reids + (array) $subid;
        }
        return $reids;
    }

    public function section_bar($cid) {
        $pid = $this->where("id=$cid")->getField("pid");
        $section_name = $this->where("id=$cid")->getField("names");
        $section_link = "<a href=\"" . U("content/article_list",array("section"=>$cid)) . "\">{$section_name}</a>";
        if ($pid == 0) {
            return "<a href=\"" . U("content/classify_management") . "\">文章列表</a>-" . $section_link;
        } else {
            return $this->section_bar($pid) . "-" . $section_link;
        }
    }

}

?>
