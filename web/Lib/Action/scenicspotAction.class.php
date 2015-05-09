<?php
/**
 * 文件名称：scenicspot.class.php
 * 用途说明：景点管理类，用以实现景点管理的各项功能。
 * 开发人员：maruiming2010@jeechange.com
 * 创建时间：2013/10/23 14:47:39
 */

class scenicspotAction extends usercommonAction {
    /**
     * 景点管理默认页，罗列各个景点
     */
    public function index() {

	   $this->display();
    }

    /**
     * 景点订单页面，展示订单详情
     */
    public function order() {

	   $this->display();
    }

    /**
     * 景点点评，景点获得的总体评价
     */
    public function comment() {

	   $this->display();
    }

    /**
     * 我的点评，我对景点的点评
     */
    public function my_comment() {

       $this->display();
    }

    /**
     * 景点问答，对景点的相关问题的咨询及回复
     * faq: Frequently Asked Questions
     */
    public function faq() {

	   $this->display();
    }

    public function collection() {

	   $this->display();
    }
    
}

















