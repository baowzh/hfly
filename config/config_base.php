<?php

return array(
    "sites" => array(//网站设置
        "webname" => "内蒙古旅游网", //网站名称
      #  "domain" => "http://www.lvyou.com/", //网站域名
    	"domain" => "http://127.0.0.1/myweb/",
        "logo" => "/web/Tpl/green2/Public/images/logo.jpg", //网站logo
        "keywords" => "微金担保，担保，微金", //网站关键字
        "description" => "网站描述网站描述网站描述网站描述网站描述网站描述", //网站描述
        "service_code" => "4001234567", //客服电话
        "bqq" => "123456789", //企业qq
        "record_code" => "12047609", //备案号
        "count_code" => "123456789", //统计代码
    ),
    "affix" => array(//附件设置
        "extend" => "doc,docx,xls,ppt,wps,zip,rar,txt,jpg,jpeg,gif,bmp,swf,png", //允许上传的后缀
        "minsize" => "1", //最小上传的大小，单位k,0表示无限制
        "maxsize" => "8192", //最大上传的大小，单位k，0表示无限制
        "get_load" => "1", //是否允许下载附件
    ),
    "filter" => array(//过滤设置
        "words" => "admin,胡哥,亚麻跌,weijin,wjhz,wjhzcn,微金,叼你妈,你妈逼,胡萝卜,太上黄,微金", //过滤词汇
        "re_words" => "****", //用来替换的词汇
        "used" => "1", //是否开启
    ),
    "act" => array(//活动对应ID
        "invite_friend" => array(
        "i_id"=>'1',
        "i_type"=>'6'
    	), //邀请朋友
    ),
    "grow_up" => array(
        "login" => "100", //登陆每日获得
    ),
	"autobid" => array(
        "level" => 3, //自动投标等级
		"level_name" => "白金会员", //自动投标等级名称
    ),
);
?>

