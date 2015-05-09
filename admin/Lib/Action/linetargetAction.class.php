<?php

/**
 * Description of LineTargetAction
 *
 * @author Gemini
 */
class linetargetAction extends CommonAction {

    public function index() {
        $table_city = M('city_belong')->getTableName() . " city";
        $table_area = M('area')->getTableName() . " area";
        $table_type = M('line_type')->getTableName() . " types";
        $table_target = M('line_target')->getTableName() . " target";
        if (!empty($_GET['title'])) {
            if ($_GET['s_type'] == 1) {
                $where['types.names'] = array('like', "%{$_GET['title']}%");
                $where['area.names'] = array('like', "%{$_GET['title']}%");
                $where['_logic'] = 'or';
            }else{
                $where['start_id']=array('in',M('area')->where(array('names'=>array('like',"%{$_GET['title']}%")))->getField("id as iid,id"));
            }
            $this->assign("title", $_GET['title']);
            $this->assign("s_type", $_GET['s_type']);
        } else {
            $where = "1=1";
        }
        $start_city = M()->table($table_city)
                        ->join($table_area . " on city.cid=area.id")
                        ->where('city.types="LINE"')->getField('city.cid,area.names');
        $count = M()->table($table_target)
                ->where($where)
                ->join($table_area . " on target.area_id=area.id")
                ->join($table_type . " on target.type_id=types.id")
                ->count();
        $page = $this->pagebar($count);
        $target_arr = M()->table($table_target)
                ->join($table_area . " on target.area_id=area.id")
                ->join($table_type . " on target.type_id=types.id")
                ->where($where)
                ->page($page)
                ->order("target.sort")
                ->field("target.id,target.start_id,target.area_id,types.names tnames,area.names cnames,target.sort,target.classify")
                ->select();
        $this->assign("start_city", $start_city);
        $this->assign("target_list", $target_arr);
        $this->display();
    }

    public function add_target() {
        if (!$_POST) {
            $table_city = M('city_belong')->getTableName() . " city";
            $table_area = M('area')->getTableName() . " area";
            $table_type = M('line_type');
            $line_type = $table_type->getField('id,names');
            $start_city = M()->table($table_city)
                            ->join($table_area . " on city.cid=area.id")
                            ->where('city.types="LINE"')->getField('area.id,area.names');

            $area = M("Area");
            $area_level[0] = $area->where("levels=1")->select();
            $area_level[1] = $area->where("pid=1")->select();
            $area_level[2] = $area->where("pid=7")->select();
            $area_level[3] = $area->where("pid=203")->select();
            $this->assign("topic_id", $topic_id);
            $this->assign("area_id", $area_level);
            $this->assign("line_type", $line_type);
            $this->assign("start_city", $start_city);
            $this->display();
        } else {
            $lineTarget = M('line_target');
            if ($lineTarget->create()) {
                if (!empty($_POST['cid3'])) {
                    $lineTarget->area_id = $_POST['cid3'];
                } elseif (!empty($_POST['cid2'])) {
                    $lineTarget->area_id = $_POST['cid2'];
                } elseif (!empty($_POST['cid1'])) {
                    $lineTarget->area_id = $_POST['cid1'];
                } elseif (!empty($_POST['cid0'])) {
                    $lineTarget->area_id = $_POST['cid0'];
                }
                $lineTarget->add();
                $this->success("添加成功！", U('index'));
            } else {
                $this->error("添加失败！");
            }
        }
    }

    public function citySelect() {
        $area = M('Area');
        if (isset($_GET['ciy'])) {
            $areas = $area->where("pid=" . $_GET['ciy'])->select();
            $this->ajaxReturn($areas);
        }
    }

    public function del_target() {
        $id = $_GET['id'];
        $lineTarget = M('line_target');
        if ($lineTarget->where("id='$id'")->delete()) {
            $this->success("删除成功");
        } else {
            $this->error("删除失败");
        }
    }

    public function edit_target() {
        $id = $_GET['id'];
        $table_city = M('city_belong')->getTableName() . " city";
        $table_area = M('area')->getTableName() . " area";
        $table_type = M('line_type');
        $start_city = M()->table($table_city)
                        ->join($table_area . " on city.cid=area.id")
                        ->where('city.types="LINE"')->getField('area.id,area.names');
        $target_city = M('line_target')->where('id=' . intval($id))->find();
        $line_type = $table_type->getField('id,names');

        if (!$_POST) {
            $area_le = M()->table($table_area)->where("id='{$target_city['area_id']}'")->find();
            $paths = explode(',', $area_le['paths']);
            $area = M("Area");
            $area_level[0] = $area->where("levels=1")->select();
            $area_level[1] = $area->where("pid=$paths[1]")->select();
            $area_level[2] = $area->where("pid=$paths[2] ")->select();
            $area_level[3] = $area->where("pid=$paths[3]")->select();
            $this->assign("area_path", $paths);
            $this->assign("target_city", $target_city);
            $this->assign("start_city", $start_city);
            $this->assign("area_id", $area_level);
            $this->assign("line_type", $line_type);
            $this->display();
        } else {
            $target = M('line_target');
            if ($data = $target->create()) {
                if (!empty($_POST['cid3'])) {
                    $data['area_id'] = $_POST['cid3'];
                } elseif (!empty($_POST['cid2'])) {
                    $data['area_id'] = $_POST['cid2'];
                } elseif (!empty($_POST['cid1'])) {
                    $data['area_id'] = $_POST['cid1'];
                } elseif (!empty($_POST['cid0'])) {
                    $data['area_id'] = $_POST['cid0'];
                }
                $target->where('id=' . intval($id))->save($data);
                $this->success("编辑成功", U('index'));
            } else {
                $this->error("编辑失败");
            }
        }
    }

    public function deleteall() {
        if (!isset($_POST["items"])) {
            $this->error("至少选中一项！");
        }
        $Line = M('line_target');
        //        $picpath = $Line->where("id=$id")->getField("picpath");
        foreach ($_POST["items"] as $id) {
            $Line->where("id=$id")->delete();
        }
        $this->success("删除成功", U("index"));
    }

}
?>