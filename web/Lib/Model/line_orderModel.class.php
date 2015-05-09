<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of line_orderModel
 *
 * @author Administrator
 */
class line_orderModel extends Model {

    protected $_auto = array(
        array('create_time', "time", 1, "function"),
        array('go_time', 'time', 1, 'function')
    );

}

?>
