<?php

/**
 * Description of TagLibJc
 *
 * @author Gemini
 */
import('TagLib');
class TagLibTourapp extends TagLib {

    protected $tags = array(
        // 标签定义： 
        //attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次 
        'lists' => array('attr' => 'name,field,page,row,order,catid,where,id,sql', 'level' => 3),
    );

    public function _lists($attr, $content) {

        $tag = $this->parseXmlAttr($attr, 'lists');
        $id = !empty($tag['id']) ? $tag['id'] : 'r';  //定义数据查询的结果存放变量
        $key = !empty($tag['key']) ? $tag['key'] : 'i';        
        $mod = isset($tag['mod']) ? $tag['mod'] : '2';

        if ($tag['name']) {   //根据用户输入的值拼接查询条件
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

}

?>
