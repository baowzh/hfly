<?php
import ( "ORG.Util.Page" ); // 导入分页类
class  goodsCategorieModel extends Model{
function add_goods_categories($names,$pid,$sort,$states,$showinnav,$rectype,$keyinfo,$memo,$id='') {
	if($id){
		$sql = "REPLACE INTO  ".DB_TABLEPRE."goods_categories (id,names,pid,sort,states,showinnav,rectype,keyinfo,memo) VALUES"
		." ($id,'$names',$pid,$sort,$states,$showinnav,'$rectype','$keyinfo','$memo')";
	}else{
		$sql ="INSERT INTO  ".DB_TABLEPRE."goods_categories (names,pid,sort,states,showinnav,rectype,keyinfo,memo) VALUES "
		."('$names',$pid,$sort,$states,$showinnav,'$rectype','$keyinfo','$memo')";
	}

	if($this->db->query($sql)){
		$id = $this->db->insert_id();
		return $id;
	}else{
		return false;
	}
}

function edit_goods_categories($names,$pid,$sort,$states,$showinnav,$rectype,$keyinfo,$memo,$id='') {
	$this->cate_states_tree($id,$states,1);
	$sql ="update ".DB_TABLEPRE."goods_categories set names='$names',pid=$pid,sort=$sort,states=$states,showinnav=$showinnav,rectype='$rectype',keyinfo='$keyinfo',memo='$memo' where id=$id";
	$this->db->query($sql);
	return true;
}

function cate_states_tree($id,$states,$layer) {
	$sql = "select pid,id,names from ".DB_TABLEPRE."goods_categories";
	$query = $this->db->query($sql);
	while ($row = $this->db->fetch_array($query)) {
		$tree[] = $row;
	}
	//
	$tree = $this->getTree($tree,$id);
	$cat_sql = "update ".DB_TABLEPRE."goods_categories set states=".$states;
	$goods_sql = "update ".DB_TABLEPRE."goods set states=".$states;
	$this->cate_onoff($tree,$cat_sql,$goods_sql);
	//echo "<PRE>";var_dump($tree);exit;
}
function getTree($data, $pId){
	$tree = '';
	foreach($data as $k => $v){
		if($v['pid'] == $pId){
			$v['pid'] = $this->getTree($data, $v['id']);
			$tree[] = $v;
		}
	}
	return $tree;
}
function cate_onoff($data,$cat_sql,$goods_sql) {

	foreach($data as $d){
		if($d['pid'] != -1){
			//		echo "<PRE>";var_dump($d);
			$query_sql = $cat_sql." where id =".$d['id'];
			$this->db->query($query_sql);
			$query_sql2 = $goods_sql." where cid =".$d['id'];
			$re = $this->db->query($query_sql2);
			if($re)echo "yes<BR>";
			$this->cate_onoff($d['pid'],$sql,$goods_sql);
		}
	}
}
function tree_html($tree){
	$html = '';
	if(is_array($tree)) {
		foreach($tree as $key => $t){
			if($t['pid'] == "-1"){
				$html .= "--{$t['names']}--";
			}
			else{
				$html .= "<BR>".$t['names'];
				$html .= $this->tree_html($t['pid']);
				$html = $html."<BR>";
			}
		}
	}

	return $html;
}
function delete_goods_categories($id){
	$sql = "delete from ".DB_TABLEPRE."goods_categories where id = $id";
	$this->db->query($sql);
	return;
}

function get_total_num(){
	$sql='SELECT COUNT(*) FROM '.DB_TABLEPRE.'goods_categories';
	return $this->db->result_first($sql);
}

function get_list(){
	$list=array();
	$sql='SELECT * FROM '.DB_TABLEPRE.'goods_categories';

	$query=$this->db->query($sql);
	while($obj=$this->db->fetch_array($query)){
		$list[]=$obj;
	}
	return $list;
}

function bind_categories_tree($pid=-1)
{
	$cate = M('GoodsCategorie');
	foreach ($cate->where("pid=$pid")->select() as $key => $row)
	{
		$_SESSION["result"] .= "
		var dataList=new Array(\"".$row["names"]."\",\"".$row["sort"]."\",\"<a href='__URL__/goodsCatAdd?".$row["id"]."'>添加子类</a>\",\"<a href='__URL__/edit?".$row["id"]."'>编辑</a> \",\"<a href='#' onclick=confirms('__URL__/del?".$row["id"]."','您确认要删除么')>删除</a> \",\"<a href='__APP__/Goods/lists?".$row["id"]."'>查看商品</a> \");
		gridTree.addGirdNode(dataList,".$row["id"].",".$row["pid"].",null,".$row["sort"].");
		";
		//if($row["pid"]!=-1)
		//{
		//echo $result."<br/>";
		self::bind_categories_tree($row["id"]);
		//}
	}

	$result=$_SESSION["result"];
	return $result;

}


function check_child($id){
	$GoodsCategorie = M('GoodsCategorie');
	$conditon['pid'] = $id;
	return $GoodsCategorie->where($conditon)->count();
}

function check_goods($id){
	$goods = M('Good');
	$conditon['cid'] = $id;
	return $goods->where($conditon)->count();
}

function get_categories_childlist($pid)
{
	$sql = "select * from ".DB_TABLEPRE."goods_categories where pid = $pid";
	$query = $this->db->query($sql);
	$count=$this->db->num_rows($query);
	for ($i=0;$i<$count;$i++)
	{
		$row=$this->db->fetch_array($query);
		$_SESSION["result"] .= ($row["id"].",");
		self::get_categories_childlist($row["id"]);
	}

	$result=$_SESSION["result"].$pid;

	return $result;
}

function get_categories_child_array($pid)
{
	$_SESSION["result"]=null;
	$list=array();
	$sql='SELECT * FROM '.DB_TABLEPRE.'goods_categories where id in('.self::get_categories_childlist($pid).')';
	$query=$this->db->query($sql);
	while($obj=$this->db->fetch_array($query)){
		$list[]=$obj;
	}
	return $list;
}
}
?>