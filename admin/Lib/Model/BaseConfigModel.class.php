<?php
class BaseConfigModel extends Model {

    public function CheckVerify($verify) {
        if (md5($verify) != Session::get('verify')) return false;
        return true;
    }

    //自动验证
    protected $_validate = array(
    );

    //自动填充设置
    protected $_auto = array(
    );
    
    
}
?>