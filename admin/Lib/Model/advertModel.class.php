<?php
class advertModel extends Model{
	protected $_auto = array(
	array("start_time", "strtotime", 3, "function"),
	array("end_time", "strtotime", 3, "function"),
	array("start_time", "put_time", 3, "callback"),
	array("end_time", "put_time", 3, "callback"),
	);
	
	protected $_validate = array(
    array('title','require','标题必须！'),
    array('sort','require','排序必须！'),
    array('area_id','require','显示区域必须！'),
    array('url','require','图片链接必须！'),
    array('pic','require','还未上传图片！')
);
	

	public function put_time($data){
		return empty($data)?0:$data;	
	}
}