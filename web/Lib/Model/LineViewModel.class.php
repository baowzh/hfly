<?php

/**
 * Description of LineModel
 *
 * @author Gemini
 */
class LineViewModel extends ViewModel {

    protected  $viewModel=true;
    public $viewFields = array(
        'Line' => array('id'=>'id', 'names'=>"names", "code"=>"code",'property'=>"property","_as"=>"line",'_type'=>'LEFT'),
        'LinePic' => array('pic_small' => 's_pic','pic_middle'=>"m_pic",'pic_path'=>'p_pic', '_on' => 'line.id=linePic.line_id','_type'=>'LEFT'),
        'LinePrice' => array('RACKRATE' => 'pack','price_adult'=>'p_adult','price_children'=>"price_children",'_on' => 'line.id=LinePrice.line_id'),
    );
}

?>
