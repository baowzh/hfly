<?php
import("ORG.Util.Page"); // 导入分页类
class goodscategorieAction extends CommonAction {
	public function goodsCatAdd() {
		if (!isset ($_POST['submit'])) {
			$pid = $this->get[0];
			$option = self :: cate($pid);
			$this->assign('option', $option);
			$this->display();
		} else {
			$cate = M('GoodsCategorie');
			$data = $cate->create();
			$cate->add($data);
			$this->redirect('goodsCatList', array (
				'message' => 'MESSAGE_SUCCESS'
			));
		}
	}
	public function goodsCatList() {
		$categr = $this->gettree(-1);
		$this->assign('goodcate', $categr);
		$this->assign('message', isset ($_REQUEST['message']) ? C($_REQUEST['message']) : '');
		$this->display();
	}
	function edit() {
		if (!isset ($_POST['submit'])) {
			$GoodsCategorie = M('GoodsCategorie');
			$condition['id'] = $this->get[0];
			$get_GoodsCategorie = $GoodsCategorie->where($condition)->find();
			$pid_condition['id'] = $get_GoodsCategorie['pid'];
			$pid_names = $GoodsCategorie->where($pid_condition)->getField('names');

			$option = self :: cate($pid);
			$this->assign('option', $option);

			$this->assign('goodsCategorie', $get_GoodsCategorie);
			$this->assign('pid_names', $pid_names);
			$this->display();
		} else {
			$GoodsCategorie = M('GoodsCategorie');
			if ($GoodsCategorie->create()) {
				if (false !== $GoodsCategorie->save()) {
					$this->redirect('goodsCatList', array (
						'message' => 'MESSAGE_SUCCESS'
					));
				} else {
					$this->assign('message', '添加失败');
					$this->display();
				}
			} else {
				$this->assign('message', '添加失败');
				$this->display();
			}
		}
	}

	function del() {
		$GoodsCategorie = D('GoodsCategorie');
		//检测是否有下级
		if ($GoodsCategorie->check_child($this->get[0]) > 0) {
			$this->assign('message', '请先删除该类的子类');
			$this->display();
		} else
			if ($GoodsCategorie->check_goods($id) > 0) {
				$this->assign('message', "请先删除该类的商品");
				$this->display();
			} else {
				$condition['id']= $this->get[0];
				$GoodsCategorie->where($condition)->delete();
				$this->assign('message', "删除成功");
				$this->redirect('goodsCatList', array (
						'message' => 'MESSAGE_SUCCESS'
					));
			}
	}

	function gettree($params) {
		extract($params);
		$header = "
				<script language=\"JavaScript\">
				var gridTree;
				function showGridTree(){
				gridTree=new TableTree4J(\"gridTree\",\"__TMPL__Public/TableTree4J/\");
				gridTree.tableDesc=\"<table border='1' class='GridView' width='100%' id='table1' cellspacing='0' cellpadding='0' style='border-collapse: collapse'  bordercolordark='#C0C0C0' bordercolorlight='#C0C0C0' >\";
				var headerDataList=new Array(\"分类名称\",\"排序\",\"添加子类\",\"编辑\",\"删除\",\" 查看商品\");
				var widthList=new Array(\"25%\",\"15%\",\"15%\",\"15%\",\"15%\",\"15%\");
				gridTree.setHeader(headerDataList,-1,widthList,true,\"GridHead\",\"This is a tipTitle of head href!\",\"header status text\",\"\",\"\");
				gridTree.gridHeaderColStyleArray=new Array(\"\",\"\",\"\",\"centerClo\");
				gridTree.gridDataCloStyleArray=new Array(\"\",\"\",\"\",\"centerClo\");
				";
		$_SESSION["result"] = null;
		$g = D('GoodsCategorie');
		$header .= $g->bind_categories_tree();
		$header .= "
				gridTree.printTableTreeToElement(\"gridTreeDiv\");
			}
			</script>

			";
		return $header;
	}
	//下拉选择
	function cate($selected = 0, $parent_id = -1, $m = -1) {
		$sec = M('GoodsCategorie');
		$res = $sec->where("pid=$parent_id")->select();
		$n = str_pad('', $m, '-', STR_PAD_RIGHT);
		$n = str_replace('-', '&nbsp;&nbsp;', $n);

		$options = '';
		static $i = 0;
		if ($i == 0) {
			$options .= '<option value="" >≡- 请选择   -≡</option>\n';
		}
		if ($res) {

			foreach ($res as $key => $val) {
				$i++;
				$options .= "<option value='{$val['id']}'";
				if ($val['id'] == $selected) {
					$options .= ' selected ';
				}

				if ($val['pid'] == 0) {
					$head = "┣ ";
					$options .= ">" . $head . $val['names'] . "\n";
				} else {
					$options .= ">" . $n . "├  " . $val['names'] . "</option>\n";
				}
				$options .= self :: cate($selected, $val['id'], $m +3);
			}
		}
		return $options;
	}
}
?>