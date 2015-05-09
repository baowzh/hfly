<?php
/**
 * 文件名称：ViewpointOCollectionModel.class.php
 * 用途说明：景点管理模型类，用以实现景点管理的各项功能。
 * 开发人员：maruiming2010@jeechange.com
 * 创建时间：2013/10/26 14:47:39
 */
class ViewpointCollectionModel extends Model {
    /**
     * 获取用户收藏的景点数
     * @access public
     *
     * @return int 返回查询到的用户收藏的景点数
     */
    public function count($user_id) {
	$Collection = M('ViewpointCollection');
	
	$collections = $Collection
	    ->where("user_id=".$user_id." AND status=1")
	    ->count();
	
	return $collections;
    }
    
    /**
     * 获取用户收藏的景点
     * @access public
     *
     * @return int 返回查询到的符合要求的收藏记录
     */
    public function get_collections($user_id,$page_param,$status=1) {
	$Collection = M('ViewpointCollection');
	
	$collections = $Collection->table(C('DB_PREFIX') . "viewpoint_collection AS collection")
	    ->join(C('DB_PREFIX')."viewpoint AS viewpoint ON viewpoint.id=collection.viewpoint_id")
            ->field("collection.*,viewpoint.names")
	    ->where("collection.user_id=".$user_id." AND collection.status=$status")
	    ->order('collection.id asc')
	    ->page($page_param)
	    ->select();
	 
	return $collections;
    }
}
