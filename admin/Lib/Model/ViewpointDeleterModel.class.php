<?php


class ViewpointDeleterModel extends Model
{
    
    private $id;
    
    public function __construct($view_id)
    {
        parent::__construct();
        $this->id = $view_id;
    }
    
    
    /**
     * 关联性删除各表中相应项目
     */
    public function deleteFromTable()
    {
        $view = M('Viewpoint');
        if($view->where('id='.$this->id)->find())
          $view->where('id='.$this->id)->delete();
        
        $view_impr = M('ViewpointImpr');
        if($view_impr->where('view_id='.$this->id)->find())
          $view_impr->where('view_id='.$this->id)->delete();
        
        $view_que = M('ViewpointQue');
        if($view_que->where('view_id='.$this->id)->find())
          $view_que->where('view_id='.$this->id)->delete();
        
        $view_ticket = M('ViewpointTicket');
        if($view_ticket->where('viewpoint_id='.$this->id)->find())
          $view_ticket->where('viewpoint_id='.$this->id)->delete();
        
        $view_pic = M('ViewpointPic');
        $pic = $view_pic->where('viewpoint_id='.$this->id)->select();
        if($pic) {
            
            foreach($pic as $p)
              @unlink($_SERVER['DOCUMENT_ROOT'].__ROOT__."/web/File/viewpoint_pic/" . $p['picpath']);
        }
        $view_pic->where('viewpoint_id='.$this->id)->delete();
    }
}

?>
