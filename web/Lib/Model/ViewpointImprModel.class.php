<?php
/**
 * 文件名称：ViewpointImprModel.class.php
 * 用途说明：景点管理模型类，用以实现景点管理的各项功能。
 * 开发人员：maruiming2010@jeechange.com
 * 创建时间：2013/10/23 14:47:39
 */
class ViewpointImprModel extends Model {
	/**
	 * 通过景点id获取用户对该景点的评论
	 */
	public function get_comment_by_order_id($order_id) {
		$Comment = M('ViewpointImpr');

		$comment = $Comment->where("user_id=".$_SESSION['user_id']." AND order_id=".$order_id)
					       ->find();
		
		return $comment;
	}
}