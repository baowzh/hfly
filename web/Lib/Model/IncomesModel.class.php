<?php
/**
 * 文件名称：IncomesModel.class.php
 * 用途说明：用户个人资料类
 * 开发人员：maruiming2010@jeechange.com
 * 创建时间：2013/11/04 15:23:21
 */
class IncomesModel extends Model {
    public function count($user_id) {
	$Incomes = M('Incomes');

	$count = $Incomes->where("user_id=".$user_id." AND status=1")->count();
	
	return $count;
    }

    
    public function get_list($page_param, $user_id) {
	$Incomes = M('Incomes');

	$list = $Incomes->where("user_id=".$user_id." AND status=1")
	    ->order('adddate')
	    ->page($page_param)
	    ->select();
	
	return $list;
    }
}


















