<?php
import("ORG.Util.Page"); // 导入分页类
class areaAction extends CommonAction {
    //全部列表
    public function show_list() {
        $area = M("Area");
        $pid = ($_GET['pid'] == null ? '0' : $_GET['pid']);
        $pages = ($_GET['p'] == null ? '1' : $_GET['p']);
        $list = $area->where("pid=$pid")->page($pages . ',15')->select();
        $count = $area->where("pid=$pid")->count();
        $Page = new Page($count, 15);
        $show = $Page->show();
        
        $this->assign('page', $show);
        $this->assign('pid', $pid);
        $this->assign('list', $list);
        $this->display();
    }
    
    //Edit By yZeng
    public function edit(){
        $id = intval($_GET['id']);
        $areas = M("Area");
        if($id > 0){
            if (!isset($_POST['submit'])){
                $this->assign('id', $id);
                $area = $areas->where("id=".$id)->find();
                $this->assign('area', $area);
                $this->display();
            }
            else{
                $areas->create();
                $areas->where("id=".$id)->save();
                $this->success("保存成功","edit?id=".$id,2);
            }
        }
        else{
            $this->redirect("show_list");
        }
    }
    
    //Edit By yZeng
  /*  public function del(){
        $id = intval($_GET['id']);
        $areas = M("Area");
        if($id > 0){
            if($areas->where("id=".$id)->count()>0){
                $areas->where("id=".$id)->delete();
                $this->success("删除成功","show_list",2);
            }
        }
        else{
            $this->redirect("show_list");
        }
    }*/
	public function deleteall() {
		if (isset($_POST['dosubmit'])) {
			$done = false;
			$Article = M("Area");
			$count = $Article->count();
			$id = $Article->getField("id", true);
			for ($i = 0; $i < $count; $i++) {
				if ($_POST["items_" . $id[$i]]) {
					$picpath = $Article->where("id=" . $id[$i])->getField("pic");
					$Article->where("id=" . $id[$i])->delete();
					@unlink($_SERVER['DOCUMENT_ROOT'] . __ROOT__ . $picpath);
					$done = true;
				}
			}
			if ($done)
				$this->success("删除成功！");
			else
				$this->error("请勾选至少1项。");
		}
		else {
			$this->error("请至少选择一项");
		}
	}

}
?>