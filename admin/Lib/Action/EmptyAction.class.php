<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 13-7-25
 * Time: 上午11:54
 * To change this template use File | Settings | File Templates.
 */
class EmptyAction  extends Action{
    public function _initialize() {
        R(strtolower(MODULE_NAME),strtolower(ACTION_NAME));
        exit;
    }
}
