<?php

/**
 * Description of LineTypeModel
 *
 * @author Gemini
 */
class LineTypeModel extends Model {
    
    //获取类型列表
    public function getTypeList(){
        return $this->where("status=1")->order("sort")->select();        
    }
}

?>
