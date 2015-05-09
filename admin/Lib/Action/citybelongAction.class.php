<?php
import("ORG.Util.Page");

class citybelongAction extends CommonAction {

    //添加
    public function add() {
        $types = $_GET['t'];
        $this->assign('types', $types);
        $area = M("Area");
        $area_level[0] = $area->where("levels=1")->select();
        $area_level[1] = $area->where("pid=1")->select();
        $area_level[2] = $area->where("pid=7")->select();
        $area_level[3] = $area->where("pid=203")->select();
        $this->assign('areas', $area_level);

        if (!isset($_POST['submit'])) {
            $this->display();
        } else {
            $CityBelong = M('CityBelong');
            if (isset($_POST['cid']) AND isset($_POST['cid1'])) {
                $cid = $_POST['cid'];
            } else if (isset($_POST['cid1']) AND isset($_POST['cid2'])) {
                $cid = $_POST['cid1'];
            } else {
                $cid = $_POST['cid2'];
            }
            $cityold = $CityBelong->where('cid=' . $cid . ' and types="' . $_POST['types'] . '"')->count();

            if ($cityold > 0) {
                $this->assign("message", "您已经添加了该城市，不能重复添加");
                $this->display();
                exit;
            }

            $CityBelong->create();
            $CityBelong->cid = $cid;
            $CityBelong->add();
            $this->redirect("show_list");
        }
    }

    public function citySelect() {
        $area = M('Area');
        if (isset($_GET['ciy'])) {
            $areas = $area->where("pid=" . $_GET['ciy'])->select();
            $this->ajaxReturn($areas);
        }
    }

    //点击了列表下方的删除按钮之后
    public function deleteall() {
        if (isset($_POST['dosubmit'])) {
            $done = false;
            $Hotel = M("CityBelong");
            $count = $Hotel->count();
            $id = $Hotel->getField("id", true);
            for ($i = 0; $i < $count; $i++) {
                if ($_POST["items_" . $id[$i]]) {
                    $Hotel->where("id=" . $id[$i])->delete();
                    $done = true;
                }
            }
            if ($done)
                $this->success("删除成功！");
            else
                $this->error("请勾选至少1项。");
        }
        else {
            $this->redirect("show_list");
        }
    }

    //编辑
    public function ajax_show_area() {
        $pid = $_POST['pid'];
        $Area = D("Area");
        $result_arr = $Area->get_list($pid);
        echo $result_arr;
        exit;
    }

    //删除    
    public function ajax_del() {
        header('Content-Type:text/html;charset=utf-8');
        $id = $_GET['id'];
        $CityBelong = M('CityBelong');
        $CityBelong->where("id=$id")->delete();
        echo 1;
        exit;
    }

    public function ajax_order() {
        $CityBelong = M('CityBelong');
        $types = $_GET['t'];
        foreach ($_POST as $k => $v) {
            $kid = explode("_", $k);
            if ($kid[0] == "sort" && preg_match("/^\d+$/", $kid[1])) {
                $CityBelong->where("id=" . $kid[1])->setField('sort', $v);
            }
        }
        $list = $CityBelong->table(C('DB_PREFIX') . "city_belong" . C('DB_SUFFIX') . " city")
                ->join(C('DB_PREFIX') . "area" . C('DB_SUFFIX') . " area ON city.cid=area.id")
                ->limit('0,15')->where("types='$types'")
                ->field("city.*,area.names")
                ->order("city.sort")
                ->select();
        foreach ($list as $vo) {
            $url = U('CityBelong/show_list', array('t' => $types, 'id' => $vo['id']));
            $data.="<tr class=\"ulbc\" id=\"tr_{$vo['id']}\">
                    <td><input type=\"checkbox\" value=\"{$vo['id']}\" /></td>
                <td><input type=\"text\" name=\"sort_{$vo['id']}\" value=\"{$vo['sort']}\" style=\"width:60px; text-align:center;\" /></td>
                <td style=\"text-align: left;\">{$vo['names']}</td>            
                <td>
                    <a href=\"{$url}\">编辑</a>                
                    <a href=\"#\" onclick= \"javascript:if(confirm( '确定要删除该条记录吗？ '))ajax_del({$vo['id']});\">删除</a>
                </td>
            </tr>";
        };
        $this->ajaxReturn($data, "排序成功", 1);
    }

    //全部列表
    public function show_list() {
        $types = $_GET['t'];
        $CityBelong = M("CityBelong");

        if (!empty($_GET['names'])) {            
            $where['area.names'] = array("like", "%{$_GET['names']}%");            
            $this->assign("search_key", $_GET['names']);
        } else {
            $where = '1=1';
        }
        $count = $CityBelong->where("types='$types'")->count();
        $page = $this->pagebar($count);
        $list = $CityBelong->table($CityBelong->getTableName() . " city")
                ->join(M('area')->getTableName() . " area ON city.cid=area.id")
                ->page($page)->where("types='$types'")
                ->where($where)
                ->field("city.*,area.names")
                ->order("city.sort,id desc")
                ->select();
	
        $this->assign('list', $list);
        $this->assign('types', $types);

        $this->display();
    }

    public function sort_list() {
        $CityBelong = M("CityBelong");
        $types = $_GET['t'];
        foreach ($_POST["sort"] as $key => $val) {
            $CityBelong->where("id={$key}")->setField("sort", $val);
        }
        $this->redirect("show_list", "t=" . $types);
    }

    public function add_areas() {
        $id = $_GET['id'];
        $this->assign("id", $id);
        if (!isset($_POST["submit"])) {
            $CityBelong = M("CityBelong");
            $city = $CityBelong->table(C('DB_PREFIX') . "city_belong" . C('DB_SUFFIX') . " city")
                            ->join(C('DB_PREFIX') . "area" . C('DB_SUFFIX') . " area ON city.cid=area.id")
                            ->where("city.id=$id")->find();
            $this->assign("city", $city);
            $this->display();
        } else {
            $hotel_citybelong = M("HotelCitybelong");
            $hotel_citybelong->create();
            $hotel_citybelong->add();
            $this->success("添加成功", U("list_areas", array("city" => $id)));
        }
    }

    public function list_areas() {
        $id = $_GET['city'];
        $this->assign("id", $id);

        $CityBelong = M("CityBelong");
        $city = $CityBelong->table(C('DB_PREFIX') . "city_belong" . C('DB_SUFFIX') . " city")
                ->join(C('DB_PREFIX') . "area" . C('DB_SUFFIX') . " area ON city.cid=area.id")
                ->where("city.id=$id")
                ->field("*, city.id as city_id")
                ->find();
        $block = array();
        for ($i = 1; $i <= 6; $i++) {
            $block[$i] = $CityBelong->table(C('DB_PREFIX') . "city_belong" . C('DB_SUFFIX') . " city")
                    ->join(M("HotelCitybelong")->getTableName() . " block ON block.city_id = city.id")
                    ->where("city.id=$id AND block.area_type=$i")
                    ->field("*, block.id as block_id")
                    ->select();
        }

        $this->assign("city", $city);
        $this->assign("block", $block);
        $this->display();
    }

    public function ajax_save_areas() {
        header('Content-Type:text/html;charset=utf-8');
        $id = $_GET['id'];
        $names = $_POST['area_names'];
        $hotel_block = M('HotelCitybelong');
        $hotel_block->create();
        $hotel_block->id = $id;
        $hotel_block->names = $names;
        $hotel_block->save();
        echo 1;
        exit;
    }

    public function ajax_del_areas() {
        header('Content-Type:text/html;charset=utf-8');
        $id = $_GET['id'];
        $hotel_block = M('HotelCitybelong');
        $hotel_block->where("id=$id")->delete();
        echo 1;
        exit;
    }

    //点击了列表下方的删除按钮之后
    public function areas_deleteall() {
        if (isset($_POST['dosubmit'])) {
            $done = false;
            $Hotel = M("HotelCitybelong");
            $count = $Hotel->count();
            $id = $Hotel->getField("id", true);
            for ($i = 0; $i < $count; $i++) {
                if ($_POST["items_" . $id[$i]]) {
                    $Hotel->where("id=" . $id[$i])->delete();
                    $done = true;
                }
            }
            if ($done)
                $this->success("删除成功！");
            else
                $this->error("请勾选至少1项。");
        }
        else {
            $this->redirect("show_list");
        }
    }

}
