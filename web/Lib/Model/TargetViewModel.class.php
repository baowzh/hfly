<?php

/**
 * Description of TargetViewModel
 *
 * @author Gemini
 */
class TargetViewModel extends ViewModel {

    protected $viewModel = true;
    public $viewFields = array(
        'LineTarget' => array('area_id' => 'area_id', "_as" => "Target", '_type' => 'LEFT'),
        'Area' => array(
            'names' => 'names',
            'names_en' => "names_en",
            "_as" => "Area",
            '_on' => 'Target.area_id=Area.id',
            '_type' => 'LEFT'
        ),
    );

}

?>
