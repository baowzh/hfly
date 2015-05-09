<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * 对类似数据库表的数据进行类似model类的查询
 *
 * @author gemini
 */
class ArrayModel {

    const PAGE_SIZE = 20;

    private $data_index = array();
    private $data_key = array();
    private $data_val = array();
    private $sys_key = array("_string", "_complex");
    protected $methods = array('field', 'where', 'order', 'limit', 'page',);
    protected $method_counts = array('count', 'sum', 'min', 'max', 'avg');
    protected $options = array();

    /**
     * 数据库数组模型
     * @param array $arr 数组     
     */
    function __construct($arr = array()) {
        $h = $this->Resolve($arr);
        if (!$h) {
            $this->throwException(L("ARR_R_FAIL"), debug_backtrace());
        }
    }

    public function __call($method, $args) {

        if (in_array(strtolower($method), $this->methods, true)) {
            // 连贯操作的实现
            $this->options[strtolower($method)] = $args[0];
            return $this;
        } elseif (in_array(strtolower($method), $this->method_counts, true)) {
            $field = isset($args[0]) ? $args[0] : '*';
            return $this->getCount($field, $method);
        } elseif (strtolower(substr($method, 0, 8)) == 'getoneby') {
            $field = parse_name(substr($method, 8));
            $where[$field] = $args[0];
            return $this->where($where)->find();
        } elseif (strtolower(substr($method, 0, 5)) == 'getby') {
            $field = parse_name(substr($method, 5));
            $where[$field] = $args[0];
            return $this->where($where)->select();
        } else {
            $this->throw_exception(__CLASS__ . ':' . $method . L('_METHOD_NOT_EXIST_'), debug_backtrace());
            return;
        }
    }

    public function select() {
        $index = $this->data_index;
        $this->getCondition($index);
        $this->getOrder($index);
        $this->getLimit($index);
        return $this->getField($index);
    }

    public function find() {
        $index = $this->data_index;
        $this->getCondition($index);
        $this->getOrder($index);
        return current($this->getField($index));
    }

    protected function getCondition(&$index, $where = null) {
        $condition = $where ? $this->create_where($where) : $this->create_where($this->options["where"]);
        if (!$condition) {
            return array_unique($index);
        }
        foreach ($condition as $field => $sub_where) {
            if ($field == "_logic") {
                continue;
            } elseif (in_array($field, $this->sys_key)) {
                $fields_index = $this->getCondition($index, $field, $sub_where);
            } elseif (in_array($field, $this->data_key)) {
                $fields_index = $this->search($index, $field, $sub_where);
            } else {
                continue;
            }
            $index = $condition["_logic"] == "and" ? array_intersect($index, $fields_index) : array_merge($index, $fields_index);
        }
        return $index = array_unique($index);
    }

    protected function create_where($where) {
        if (is_string($where)) {
            $where = trim($where);
            $where = preg_replace("/\s+/", " ", $where);
            $condition = $this->dewherestring($where);
        } elseif (is_array($where)) {
            $condition = $where;
        }
        if (!isset($condition["_logic"])) {
            $condition["_logic"] = (strtolower($v) == "or") ? "or" : "and";
        }
        foreach ($condition as $k => $v) {
            if (in_array($k, $this->sys_key) or $k == "_logic") {
                continue;
            } elseif (is_array($v)) {
                $v[0] = (in_array(strtolower($v[0]), explode(",", "eq,neq,lt,elt,gt,egt,like,bt"))) ? strtolower($v[0]) : "eq";
                $condition[$k] = $v;
            } else {
                unset($condition[$k]);
            }
        }

        return $condition;
    }

    protected function dewherestring($string) {
        // 匹配类似 name="abcde"   name='aaaa' 等
        $pattern[1] = "/^(?<k>[a-zA-Z0-9_]+)\s*(?<w>\<|\>|=|\<=|>=|\<\>|in|like|)\s*(?<q>['\"]?)(?<v>[^'\"]*)\k<q>$/i";
        // 匹配类似 name="abcde" and id=8 
        $pattern[2] = "/^([^\(\)]+?)( (?<l>and|or) ([^\(\)]+?))+$/i";
        if (preg_match($pattern[1], $string, $matches)) {
            return array($matches["k"][0] => array($matches["w"][0], $matches["v"][0]));
        } elseif (preg_match($pattern[2], $string, $matches)) {
            $condition1 = $this->dewherestring($matches[1][0]);
            $str = trim(ltrim(trim($matches[2][0]), $matches['l'][0]));
            $condition2 = $this->dewherestring($str);
            return array_merge($condition1, $condition2, array("_logic" => $matches['l'][0]));
        } else {
            $this->throwException(L("_ERR_CONDITION_"), "");
        }
    }

    protected function search($index, $field, $sub_where) {
        if ($index) {
            foreach ($index as $i) {
                $string = preg_replace("/[\(\)\{\}\[\]]*\\\+\?\|\'\"\^\$]/", "", $sub_where[1]);

                $val = is_numeric($this->data_val[$field][$i]) ? floatval($this->data_val[$field][$i]) : $this->data_val[$field][$i];
                $string = is_numeric($string) ? floatval($string) : $string;

                switch ($sub_where[0]) {
                    case "eq":
                        if ($val == $string) {
                            $tmp_index[$i] = $i;
                        }
                        break;
                    case "neq":
                        if ($val != $string) {
                            $tmp_index[$i] = $i;
                        }
                        break;
                    case "lt":
                        if ($val < $string) {
                            $tmp_index[$i] = $i;
                        }
                        break;
                    case "elt":
                        if ($val <= $string) {
                            $tmp_index[$i] = $i;
                        }
                        break;
                    case "gt":
                        if ($val > $string) {
                            $tmp_index[$i] = $i;
                        }
                        break;
                    case "egt":
                        if ($val >= $string) {
                            $tmp_index[$i] = $i;
                        }
                        break;
                    case "like":
                        $string = str_replace(".", "", $string);
                        $string = str_replace("_", ".{1}", $string);
                        $string = str_replace("%", ".*", $string);
                        if (preg_match("/^" . $string . "$/i", $this->data_val[$field][$i])) {
                            $tmp_index[$i] = $i;
                        }
                        break;
                    case "bt":
                        if ($val >= $string && $val <= $sub_where[2]) {
                            $tmp_index[$i] = $i;
                        }
                        break;
                }
            }
        }
        return $tmp_index;
    }

    protected function getField(&$index) {

        $field = $this->options["field"] ? explode(",", $this->options["field"]) : $this->data_key;
        if ($field && is_array($field)) {
            foreach ($index as $i) {
                foreach ($field as $f) {
                    $result[$i][$f] = isset($this->data_val[$f][$i]) ? $this->data_val[$f][$i] : null;
                }
            }
        }
        return $result;
    }

    protected function getOrder(&$index) {
        $order = $this->options["order"] ? explode(",", $this->options["order"]) : false;
        if (!$order) {
            return $index;
        }
        foreach ($order as $v) {
            $order_info = explode(" ", $v);
            if (!isset($this->data_val[$order_info[0]])) {
                continue;
            }
            $order_info[1] = (isset($order_info[1]) && strtolower($order_info[1]) == "asc" ) ? "SORT_ASC" : "SORT_DESC";
            $intersect[$order_info[0]] = array_intersect_key($this->data_val[$order_info[0]], $index);
            $EvalString.='$intersect["' . $order_info[0] . '"],' . $order_info[1] . ',';
        }
        $EvalString = 'array_multisort(' . $EvalString . '$index);';
        eval($EvalString);
        return $index;
    }

    protected function getLimit(&$index) {
        $limits = $this->options["limit"] ? explode(",", $this->options["limit"]) : false;
        $pages = $this->options["page"] ? explode(",", $this->options["page"]) : false;
        $limit_start = $limit_size = null;
        if (isset($limits[0])) {
            $limit_start = intval($limits[0]);
            $limit_size = isset($limits[1]) ? intval($limits[1]) : PAGE_SIZE;
        } elseif (isset($pages[0])) {
            $limit_size = isset($pages[1]) ? intval($pages[1]) : PAGE_SIZE;
            $limit_start = intval($pages[0]) * $limit_size;
        }
        if ($limit_start !== null) {
            $index = array_slice($index, $limit_start, $limit_size, TRUE);
        }
        return $index;
    }

    private function throwException($msg, $debug_backtrace) {
        throw_exception($msg);
    }

    private function getCount($field, $method) {
        $index = $this->data_index;
        switch (strtolower($method)) {
            case "count":
                $this->getCondition($index);
                return count($index);
                break;
            case "sum":
                if (!in_array($field, $this->data_key)) {
                    return 0;
                    break;
                }
                $this->getCondition($index);
                $sum = 0;
                foreach ($index as $v) {
                    $sum+=$this->data_val[$field][$v];
                }
                return $sum;
                break;
            case "min":
                if (!in_array($field, $this->data_key)) {
                    return 0;
                    break;
                }
                $this->getCondition($index);
                $min = null;
                foreach ($index as $v) {
                    if ($min === null || $min > ($this->data_val[$field][$v])) {
                        $min = $this->data_val[$field][$v];
                    }
                }
                return $min;
                break;
            case "max":
                if (!in_array($field, $this->data_key)) {
                    return 0;
                    break;
                }
                $this->getCondition($index);
                $max = null;
                foreach ($index as $v) {
                    if ($max === null || $max < ($this->data_val[$field][$v])) {
                        $max = $this->data_val[$field][$v];
                    }
                }
                return $max;
                break;
            case "avg":
                if (!in_array($field, $this->data_key)) {
                    return 0;
                    break;
                }
                $this->getCondition($index);
                $sum = 0;
                foreach ($index as $v) {
                    $sum+=$this->data_val[$field][$v];
                }
                return $sum / count($index);
                break;
        }
    }

    /**
     *    
     * @param type $arr
     * @return boolean 
     */
    private function Resolve($arr) {

        $now_index = 0;
        $status = true;
        if (!$status || !is_array($arr) || !$arr) {
            return false;
        }
        reset($arr);
        $keys = is_array(current($arr)) ? array_keys(current($arr)) : false;
        $status = $this->set_db_key($keys);
        if ($status) {
            do {
                $now_list = current($arr);               
                $status = $this->set_now_list($now_list, $now_index);
                $status ? $now_index++ : null;
            } while (next($arr) && $status);
        }
        if (!$status) {
            $this->data_key = $this->data_val = $this->data_index = array();
        }
        return $status;
    }

    private function set_db_key($keys) {
        if (is_array($keys) && count($keys) > 0) {
            foreach ($keys as $key) {
                if ($this->key_is_legal($key, true)) {
                    $this->data_key[] = $key;
                } else {
                    return false;
                    break;
                }
            }
            return TRUE;
        } else {
            return false;
        }
    }

    private function set_now_list($now_list, $now_index) {
        if (!is_array($now_list) || count($now_list) != count($this->data_key)) {
            return FALSE;
        }        
        $status = TRUE;
        foreach ($now_list as $key => $val) {  
            
            if ($this->key_is_legal($key) && $this->val_is_legal($val)) {
                $this->data_val[$key][$now_index] = $val;
                $this->data_index[$now_index] = $now_index;
            } else {
                $status = false;
                break;
            }
        }

        return $status;
    }

    private function key_is_legal($key, $new = false) {
        if (!$new) {
            return in_array($key, $this->data_key);
        }
        $legal = preg_match("/^[a-zA-Z0-9_]{1,127}$/", $key);
        return ($legal && !in_array($key, $this->data_key));
    }

    private function val_is_legal($val) {        
        $val_type=gettype($val);       
        return in_array(strtolower($val_type),array("string","integer","boolean","null","double"));
    }

}

?>
