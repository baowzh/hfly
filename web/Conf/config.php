<?php
$config = require("config/config.php");
$config_sys = require("config/config_sys.php");
$config_base = require("config/config_base.php");
$config_api = require("config/config_api.php");
$array = array(
    'SHOW_ERROR_MSG' => true, //错误提示开关
    "SESSION_AUTO_START" => false, //关闭自动开启session，请不要改动此项，否则会导致用户无法登录     
    'URL_MODEL' => '1', // 0:普通模式，1:pathinfo模式，2:伪静态模式，请根据您的服务器环境进行选择
    'URL_ROUTER_ON' => true,
    'DEFAULT_MODULE' => 'index',
    'DEFAULT_THEME' => 'green2',
    'LAYOUT_ON' => 1, //开启布局模板
    'TOKEN_ON' => false,
    'TMPL_PARSE_STRING' => array(
        '__Index__' => __Index__
    ),
    'TAGLIB_LOAD' => true,
    'TAGLIB_PRE_LOAD' => 'Wj',
    'TAGLIB_BUILD_IN' => 'cx,Wj',
    'LOG_RECORD' => true, // 开启日志记录
    'LOG_RECORD_LEVEL' => array('EMERG', 'ALERT', 'CRIT', 'ERR', 'WARN', 'NOTICE', 'INFO', 'DEBUG', 'SQL'),
    
    'TOKEN_ON' => true, // 开启令牌验证
    'TOKEN_NAME' => '__hash__', // 令牌验证的表单隐藏字段名称
    'TOKEN_TYPE' => 'md5', // 令牌验证哈希规则
    'TOKEN_RESET' => true, // 令牌错误后是否重置

    'MESSAGE_SUCCESS' => '操作成功',
    'MESSAGE_ERROR' => '操作失败',
    'MESSAGE_HAS_AUDIT' => '用户已审核',
    'MESSAGE_NOT_DEL' => '用户已审核，删除失败',
    'TMPL_CACHE_ON' => false, // 模板缓存开关
    'TMPL_CACHE_ON' => false, // 模板编译缓存开关
    'ACTION_CACHE_ON' => false, // Action 缓存开关
    'HTML_CACHE_ON' => false, // 静态缓存开关 
);
return array_merge($config, $config_sys, $config_base, $config_api, $array);
?>