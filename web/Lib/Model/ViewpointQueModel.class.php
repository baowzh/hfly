<?php
/**
 * 文件名称：ViewpointOCollectionModel.class.php
 * 用途说明：景点管理模型类，用以实现景点管理的各项功能。
 * 开发人员：maruiming2010@jeechange.com
 * 创建时间：2013/10/26 14:47:39
 */
class ViewpointQueModel extends Model {
	/**
	 * 获取用户问答数
	 * @access public
	 *
	 * @return int 返回查询到的用户问答数
	 */
	public function count($user_id) {
		$Question = M('ViewpointQue');

        $questions = $Question->where("user_id=".$user_id." AND status=1")
        				->count();
     	
       	return $questions;
    }

    /**
	 * 获取用户的问答记录
	 * @access public
	 *
	 * @return int 返回查询到的符合要求的问答记录
	 */
	public function get_questions($user_id,$page_param) {
		$Question = M('ViewpointQue');

		$questions = $Question->table(C('DB_PREFIX') . "viewpoint_que AS viewpoint_que")
					->join(C('DB_PREFIX')."viewpoint as viewpoint ON viewpoint_que.view_id=viewpoint.id")
					->where("user_id=".$user_id)
					->order('publish_time asc')
					->page($page_param)
					->field("*, viewpoint_que.status as status")
					->select();
		
		return $questions;
	}
}