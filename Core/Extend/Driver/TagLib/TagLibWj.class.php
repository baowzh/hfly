<?php

/**
 * Description of TagLibJc
 * @author Gemini
 */
import('TagLib');
class TagLibWj extends TagLib {

    protected $tags = array(
        // 标签定义： 
        //attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次 
        'lists' => array('attr' => 'name,field,page,row,order,catid,where,id,sql', 'level' => 3),
        'advert' => array('attr' => 'name,order,limit,id,areaid', 'level' => 1),
        'sfor' => array('attr' => 'max,id', 'level' => 1),
        'input' => array('attr' =>array(array("name"=>"_value","required"=>true)), 'close' => 0),
        '_option' => array('attr' =>array(array("name"=>"_value","required"=>true)), 'close' => 1)
    );

    public function _lists($attr, $content) {
        $tag = $this->parseXmlAttr($attr, 'lists');
        $id = !empty($tag['id']) ? $tag['id'] : 'r'; //定义数据查询的结果存放变量
        $key = !empty($tag['key']) ? $tag['key'] : 'i';
        $mod = isset($tag['mod']) ? $tag['mod'] : '2';

        if ($tag['name']) { //根据用户输入的值拼接查询条件
            $sql = '';
            $module = $tag['name'];
            $order = isset($tag['order']) ? $tag['order'] : 'id desc';
            $field = isset($tag['field']) ? $tag['field'] : '*';
            $where = isset($tag['where']) ? $tag['where'] : ' 1 ';
            $page = isset($tag['page']) ? $tag['page'] : '0';
            $row = isset($tag['row']) ? intval($tag['row']) : '10';
            $limit = $page . "," . $row;
            // $where .= ' AND cid in(' . $tag['catid'] . ')';

            $sql = "M(\"{$module}\")
                    ->field(\"{$field}\")
                    ->where(\"{$where}\")
                    ->order(\"{$order}\")
                    ->limit(\"{$limit}\")
                    ->select();";
        } else {
            if (!$tag['sql'])
                return ''; //排除没有指定model名称，也没有指定sql语句的情况
            $sql = "M()->query(\"{$tag['sql']}\")";
        }

        //下面拼接输出语句
        $parsestr = '';
        $parsestr .= '<?php  $_result=' . $sql . '; if ($_result): $' . $key . '=0;';
        $parsestr .= 'foreach($_result as $key=>$' . $id . '):';
        $parsestr .= '++$' . $key . ';$mod = ($' . $key . ' % ' . $mod . ' );?>';
        $parsestr .= $content; //解析在article标签中的内容
        $parsestr .= '<?php endforeach; endif;?>';
        return $parsestr;
    }

    public function _advert($attr, $content) {
    	$areaid = $_SESSION['areaid'];
        $tag = $this->parseXmlAttr($attr, 'advert');
        $id = !empty($tag['id']) ? $tag['id'] : 'ad'; //定义数据查询的结果存放变量
        $adcount = !empty($tag['adcount']) ? $tag['adcount'] : 'adcount'; //定义广告总数变量
        $key = !empty($tag['key']) ? $tag['key'] : 'i';
        $order = isset($tag['order']) ? $tag['order'] : 'ad.id desc';
        $limit = isset($tag['limit']) ? $tag['limit'] : '0,5';
        if($areaid==null){
        	$areaid='0471';
        }
        $where = isset($tag['name']) ? "area.status=1 and area.names_en='{$tag['name']}'" : "area.status=1 and area.names_en=''";
        $time = time();
        $where .= " and ad.areaid='".$areaid. "' and ad.start_time<=$time and (ad.end_time=0 or ad.end_time>=$time)";
        $ad_db = M("advert")->getTableName() . " ad";
        $area_db = M("advert_area")->getTableName() . " area on ad.area_id=area.id";
        $sql = "M(\"advert\")->table(\"{$ad_db}\")
                    ->join(\"{$area_db}\")
                    ->where(\"{$where}\")
                    ->order(\"{$order}\")
                    ->limit(\"{$limit}\")
                    ->field(\"ad.*,area.names\")
                    ->select();";
        $parsestr = '';
        $parsestr .= '<?php $_result=' . $sql . ' if ($_result):$' . $adcount . '=count($_result);$' . $key . '=0; ';
        $parsestr .= 'foreach($_result as $' . $id . '):';
        $parsestr .= '++$' . $key . ';?>';
        $parsestr .= $content;
        $parsestr .= '<?php endforeach; endif;?>';
        return $parsestr;
    }

    public function _sfor($attr, $content) { //简单for
        $tag = $this->parseXmlAttr($attr, 'adcount');
        $max = !empty($tag['max']) ? $tag['max'] : 'max'; //定义广告总数变量
        $id = !empty($tag['id']) ? $tag['id'] : 'i'; //定义广告总数变量
        $parsestr = '<?php for($' . $id . '=0;$i<$' . $max . ';$' . $id . '++): ?>';
        $parsestr .= $content;
        $parsestr .= '<?php endfor;?>';
        return $parsestr;
    }

    public function _input($attr, $content) {
        $tag = $this->parseXmlAttr($attr, 'input');
        $type = isset($tag['type']) ? $tag['type'] : "text";
        $value = isset($tag['value']) ? $tag['value'] : "";
        $_value = isset($tag['_value']) ? $tag['_value'] : "";
        $str = '<input';
        foreach ($tag as $k => $v) {
            if ($k == "_value")
                continue;
            $str .= " $k=\"$v\"";
        }
        if (!isset($tag['_value'])) {
            return $str . ">";
        }
        $_is_var =$is_var= false;
        if (preg_match('/^\{\$(.*)\}$/', $_value, $_match)) {
            $_vars = explode(".", $_match[1]);
            $_var = "$" . $_vars[0];
            for ($_i = 1; $_i < count($_vars); $_i++) {
                $_var .= "['" . $_vars[$_i] . "']";
            }
            $_is_var = true;
        }
        if (preg_match('/^\{\$(.*)\}$/', $value, $match)) {
            $vars = explode(".", $match[1]);
            $var = "$" . $vars[0];
            for ($i = 1; $i < count($vars); $i++) {
                $var .= "['" . $vars[$i] . "']";
            }
            $is_var = true;
        }
        $is_var or $var="'".$value."'";
        switch ($type) {
            case "radio":
                $_is_var or $_var="'".$_value."'";
                $str .= " <?php if($var==$_var) echo 'checked';?>>";
                break;
            case "checkbox":
                $_var = $_is_var ? '(array)' . $_var : 'explode(",", "' . $_value . '")';
                $str .= " <?php if(in_array($var,$_var)) echo 'checked';?>>";
                break;
            default:
                $str .= ">";
        }
        return $str;
    }

    public function __option($attr, $content) {
        $tag = $this->parseXmlAttr($attr, '_option');
        $value = isset($tag['value']) ? $tag['value'] : "";
        $_value = isset($tag['_value']) ? $tag['_value'] : "";
        if (!isset($tag['_value'])) {
            return "";
        }
        $_is_var = $is_var = false;
        if (preg_match('/^\{\$(.*)\}$/', $_value, $_match)) {
            $_vars = explode(".", $_match[1]);
            $_var = "$" . $_vars[0];
            for ($i = 1; $i < count($_vars); $i++) {
                $_var .= "['" . $_vars[$i] . "']";
            }
            $_is_var = true;
        }
        if (preg_match('/^\{\$(.*)\}$/', $value, $match)) {
            $vars = explode(".", $match[1]);
            $var = "$" . $vars[0];
            for ($i = 1; $i < count($vars); $i++) {
                $var .= "['" . $vars[$i] . "']";
            }
            $is_var = true;
        }
        !$_is_var and $_var="'".$_value."'";
        !$is_var and $var="'".$value."'";
        $str="<option value='<?php echo $var;?>' <?php if($var==$_var)echo 'selected';?>>".$content."</option>";
        return $str;
    }


}

?>
