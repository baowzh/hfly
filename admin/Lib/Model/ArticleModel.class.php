<?php

/**
 * Description of articleModel
 *
 * @author Administrator
 */
class articleModel extends Model {

    protected $_auto = array(
        array("add_time", "time", 1, "function"),       
        array("publish_id", "get_publish_id", 1, "callback"),
    );

    protected function get_publish_id() {
        return $_SESSION["user_id"];
    }

}

?>
