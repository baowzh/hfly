<?php
import("ORG.Util.Page"); // 导入分页类
import("@.Jeesell.util");
class goodsAction extends CommonAction {
	protected $tableName = 'goods';
	//goods list
	public function lists() {
		if (!isset ($_POST['submit'])) {
			$goods = M('Good');
			if(null !=$this->get[0]){
				$pages=($_GET['p']==null?'0':$_GET['p']);
				$content = $goods->table('jee_goods goods,jee_brands brand')->where('goods.bid = brand.id and goods.cid='.$this->get[0])

				->field('goods.*,brand.names as bnames')->page($pages. ',15')->select();
			}else{
				$pages=($_GET['p']==null?'0':$_GET['p']);
				$content = $goods->table('jee_goods goods,jee_brands brand')->where('goods.bid = brand.id')
				->field('goods.*,brand.names as bnames')->page($pages . ',15')->select();
			}

			$count = $goods->count();
			$Page = new Page($count, 10); // 实例化分页类 传入总记录数和每页显示的记录数
			$show = $Page->show(); // 分页显示输出
			$this->assign('page', $show); // 赋值分页输出
			$this->assign('list', $content);
			$strr = self :: cate();
			$this->assign('option', $strr);
			$this->assign('message', isset ($_REQUEST['message']) ? C($_REQUEST['message']) : '');
			$this->display();
		} else {
			$goods = M('Good');
			$pages=($_GET['p']==null?'0':$_GET['p']);
			$list = $goods->table('jee_goods goods,jee_brands brand')->where("goods.bid = brand.id and goods." . $_POST['findtype'] .
			" = '" . $_POST['values'] . "'")->field('goods.*,brand.names as bnames')->page($pages. ',15')->select();
			$this->assign('list', $list); // 赋值数据集
			$this->display(); // 输出模板
		}
	}
	//goods add
	public function add() {
		if (!isset ($_POST['submit'])) {
			$pid = $this->get[0];
			$categr = self :: cate($pid);
			$this->assign('code', strtoupper(util :: random(14)));
			$this->assign('goodcate', $categr);
			$tag = M('GoodsTag');
			$this->assign('list_goods_tag', $tag->select());
			$listConTag = M('GoodsTagContent');
			$this->assign('list_this_goods_tag', $listConTag->select());
			$type = M('GoodsType');
			$this->assign('list_goods_type', $type->select());
			$list_brand = M('Brand');
			$this->assign('list_brand', $list_brand->select());
			$this->display();
		} else {
			$goods = M('Good');
			//图片上传
			if (!empty ($_FILES)) {
				//print_r($_FILES);
				//exit;
				//如果有文件上传 上传附件
				$up_result = $this->_upload();
				//dump($up_result);exit;
				if (false == $up_result) {
					$this->assign('message', '上传图片失败');
					$this->display();
					exit;
				}
			} else {
				$this->assign('message', '请选图片上传');
				$this->display();
				exit;
			}
			if ($data = $goods->create()) {
				for ($i = 0; $i <= count($up_result); $i++) {
					$data['goodspic' . ($i +1)] = $up_result[$i]['savename'];
				}
				if (false !== $goods->add($data)) {
					$this->redirect('lists', array (
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
	function tree_html($tree) {
		$html = '';
		$len = 0;
		$sublen = 0;
		if (is_array($tree)) {
			foreach ($tree as $key => $t) {
				if (!is_array($t['child'])) {
					echo "b-<br>";
					$len += 5;
					$sublen = 15 + $len;
					$html .= "<option value='" . $t['id'] . "'>" . $t['names'] . "</option>";
				} else {

					$html .= "<option value='" . $t['id'] . "'>" . str_repeat('|', $sublen) . $t['names'] . "</option>";
					$html .= self :: tree_html($t['child']);
				}
			}
		}
		return $html;
	}
	function getTree($parent_id, $cats) {
		$tmpArr = array ();
		$indexArr = array ();
		foreach ($cats as $k => $v) {
			$v["child"] = array ();
			if ($v["pid"] == $parent_id) {
				$i = count($tmpArr);
				$tmpArr[$i] = $v;
				$indexArr[$v["id"]] = & $tmpArr[$i];
			} else {
				$i = count($indexArr[$v["pid"]]["child"]);
				$indexArr[$v["pid"]]["child"][$i] = $v;
				$indexArr[$v["id"]] = & $indexArr[$v["pid"]]["child"][$i];
			}
		}
		return $tmpArr;

	}
	// 文件上传
	protected function _upload() {
		import("@.ORG.UploadFile");
		$upload = new UploadFile();
		//设置上传文件大小
		$upload->maxSize = 3292200;
		//设置上传文件类型
		$upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
		//设置附件上传目录
		$upload->savePath = 'Tpl/default/Public/Uploads/';
		//设置需要生成缩略图，仅对图像文件有效
		$upload->thumb = true;
		// 设置引用图片类库包路径
		$upload->imageClassPath = '@.ORG.Image';
		//设置需要生成缩略图的文件后缀
		$upload->thumbPrefix = 'm_,s_'; //生产2张缩略图
		//设置缩略图最大宽度
		$upload->thumbMaxWidth = '400,100';
		//设置缩略图最大高度
		$upload->thumbMaxHeight = '400,100';
		//设置上传文件规则
		$upload->saveRule = uniqid;
		//删除原图
		$upload->thumbRemoveOrigin = true;
		if (!$upload->upload()) {
			//捕获上传异常
			$this->error($upload->getErrorMsg());
		} else {
			//取得成功上传的文件信息
			$uploadList = $upload->getUploadFileInfo();
			import("@.ORG.Image");
			//给m_缩略图添加水印, Image::water('原文件名','水印图片地址')
			Image :: water($uploadList[0]['savepath'] . 'm_' . $uploadList[0]['savename'], '../Public/Images/logo2.png');
			$_POST['image'] = $uploadList[0]['savename'];
		}
		if ($list !== false) {
			//$this->success('上传图片成功！');
			return $uploadList;
		} else {
			return false;
			//$this->error('上传图片失败!');
		}
	}
	//删除
	public function del() {
		$goods = M('Good');
		$goods->where("id={$this->get [0]}")->delete();
		$this->redirect('lists', array (
			'message' => 'MESSAGE_SUCCESS'
		));
	}

	//管理员状态修改
	public function edit() {
		if (!isset ($_POST['submit'])) {
			$goods = M('Good');
			$goods_obj = $goods->where('id=' . $this->get[0])->find();
			$brands = M("Brand");
			$list_brand = $brands->select();
			$categr = self :: cate($pid);
			$this->assign('goodcate', $categr);
			$type = M('GoodsType');
			$this->assign('list_goods_type', $type->select());
			$this->assign('list_brand', $list_brand);
			$this->assign('goods_obj', $goods_obj);
			$this->display();
		} else {
			$goods = M('Good');
			if ($goods->create()) {
				if (false !== $goods->save()) {
					$this->redirect('lists', array (
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
}
?>