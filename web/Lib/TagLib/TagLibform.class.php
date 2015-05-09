<?php

/**
 * Description of TagLibJc
 *
 * @author Gemini
 */
import('TagLib');

class TagLibform extends TagLib {

    protected $tags = array(
        // 标签定义：
        //attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        '_option' => array("attr" => "value,_value"),
        '_radio' => array("attr" => "value,_value","close"=>0),
        '_checkbox' => array("attr" => "value,_value,_invalue", "close" => 0),
    );

    public function __option($attr, $content) {
        $tag = $this->parseXmlAttr($attr, '_option');
        $value = !empty($tag['value']) ? $tag['value'] : "";
        $_value = !empty($tag['_value']) ? $tag['_value'] : null;
        if ($value[0] == "$") {
            $valuearr = explode('.', $value);
            $values = $valuearr[0];
            for ($i = 1; $i < count($valuearr); $i++) {
                $values.='["' . $valuearr[$i] . '"]';
            }
        } else {
            $values = '"' . $value . '"';
        }
        if ($_value[0] == "$") {
            $_valuearr = explode('.', $_value);
            $_values = $_valuearr[0];
            for ($i = 1; $i < count($_valuearr); $i++) {
                $_values.='["' . $_valuearr[$i] . '"]';
            }
        } else {
            $_values = '"' . $_value . '"';
        }
        if ($_value !== null) {
            return '<option<?php if(' . $_values . '==' . $values . ') echo \' selected="selected"\';?>  value="<?php echo ' . $values . '?>">' . $content . '</option>';
        }
        else{
            return '<option value="<?php echo ' . $values . '?>">' . $content . '</option>';
        }
    }
    public function __radio($attr, $content){
        $tag = $this->parseXmlAttr($attr, '_option');
        $value = !empty($tag['value']) ? $tag['value'] : "";
        $_value = !empty($tag['_value']) ? $tag['_value'] : null;
        if ($value[0] == "$") {
            $valuearr = explode('.', $value);
            $values = $valuearr[0];
            for ($i = 1; $i < count($valuearr); $i++) {
                $values.='["' . $valuearr[$i] . '"]';
            }
        } else {
            $values = '"' . $value . '"';
        }
        if ($_value[0] == "$") {
            $_valuearr = explode('.', $_value);
            $_values = $_valuearr[0];
            for ($i = 1; $i < count($_valuearr); $i++) {
                $_values.='["' . $_valuearr[$i] . '"]';
            }
        } else {
            $_values = '"' . $_value . '"';
        }
        if($tag){
            $radiostr="<input type=\"radio\"";
            foreach($tag as $k=>$v){
                if(in_array($k, explode(',', '_value'))){
                    continue;
                }
                $radiostr.=' '.$k.'="'.$v.'"';
            }
        }
         if ($_value !== null) {
             return $radiostr.'<?php if('. $_values . '==' . $values .')echo \'checked="checked"\';?>>';
         }
         else{
             return $radiostr.'>';
         }
    }

    public function __checkbox($attr, $content){
        $tag = $this->parseXmlAttr($attr, '_option');
        $value = !empty($tag['value']) ? $tag['value'] : "";
        $_value = !empty($tag['_value']) ? $tag['_value'] : null;
        $_invalue = !empty($tag['_invalue']) ? $tag['_invalue'] : null;
        if ($value[0] == "$") {
            $valuearr = explode('.', $value);
            $values = $valuearr[0];
            for ($i = 1; $i < count($valuearr); $i++) {
                $values.='["' . $valuearr[$i] . '"]';
            }
        } else {
            $values = '"' . $value . '"';
        }
        if ($_value[0] == "$") {
            $_valuearr = explode('.', $_value);
            $_values = $_valuearr[0];
            for ($i = 1; $i < count($_valuearr); $i++) {
                $_values.='["' . $_valuearr[$i] . '"]';
            }
        } else {
            $_values = '"' . $_value . '"';
        }
        if ($_invalue[0] == "$") {
            $_invaluearr = explode('.', $_invalue);
            $_invalues = $_invaluearr[0];
            for ($i = 1; $i < count($_invaluearr); $i++) {
                $_invalues.='["' . $_invaluearr[$i] . '"]';
            }
        } else {
            $_invalues = '"' . $_invalue . '"';
        }
        if($tag){
            $radiostr="<input type=\"checkbox\"";
            foreach($tag as $k=>$v){
                if(in_array($k, explode(',', '_value'))){
                    continue;
                }
                $radiostr.=' '.$k.'="'.$v.'"';
            }
        }
         if ($_value !== null) {
             return $radiostr.'<?php if('. $_values . '==' . $values .')echo \'checked="checked"\';?>>';
         }
         else{
             return $radiostr.'>';
         }
    }

}

?>
