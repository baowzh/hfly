<?php

/**
 * Description of recommendViewModel
 *
 * @author Gemini
 */
class RecommendViewModel extends ViewModel {

    protected $viewModel = true;
    public $viewFields = array(
        'LineRecommend'=>array('id'=>'id','type_id'=>'type_id','area_id'=>'area_id','sort'=>'sort','status'=>'status','_as'=>'Recommend','_type'=>'LEFT'),
        'Area'=>array('names'=>'area_name','names_en'=>'area_name_en','_as'=>'Area','_on'=>'Recommend.area_id=Area.id')
    );

}

?>
