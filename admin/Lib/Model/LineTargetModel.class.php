<?php

/**
 * Description of LineTargetModel
 *
 * @author Gemini
 */
class LineTargetModel extends Model {

    private $area, $target;

    private function _init() {
        $this->area = M('area')->getTableName() . ' area';
        $this->target = $this->getTableName() . ' target';
    }

    public function gettar($where) {
        $this->_init();
        return $this->table($this->target)
                        ->join($this->area . " on target.area_id=area.id")
                        ->where($where)
                        ->field("target.*,area.names,area.names_en")
                        ->order("target.sort")
                        ->select();
    }

}

?>
