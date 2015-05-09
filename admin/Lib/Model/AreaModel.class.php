<?php

class AreaModel extends Model {

    //自动验证
    protected $_validate = array();
    //自动填充设置
    protected $_auto = array();

    public function get_list($pid) {
        $map['pid'] = array('eq', $pid);
        $list = $this->where($map)->findAll();
        $obj = array();
        foreach ($list as $k => $li) {
            $list_json[] = array('id' => iconv('gb2312', 'UTF-8', $li['id']),
                'names' => $li['names']
            );
        }
        return json_encode($list_json);
    }

}

?>