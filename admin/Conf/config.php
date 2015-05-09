<?php
$config = require(ROOT_PATH . "config/config.php");
$config_sys = require(ROOT_PATH . "config/config_sys.php");
$config_base = require(ROOT_PATH . "config/config_base.php");
$config_pic = require(ROOT_PATH . "config/config_pic.php");
$config_api = require(ROOT_PATH . "config/config_api.php");
$array = array(
    'SHOW_ERROR_MSG' => true, //错误提示开关
    "SESSION_AUTO_START" => false, //关闭自动开启session，请不要改动此项，否则会导致用户无法登录     
    'URL_MODEL' => '1', // 0:普通模式，1:pathinfo模式，2:伪静态模式，请根据您的服务器环境进行选择
    'URL_ROUTER_ON' => true,
    'DEFAULT_MODULE' => 'index',
    'TOKEN_ON' => false,
    'LAYOUT_ON' => 1, //开启布局模板    
    'DEFAULT_THEME' => "default",
    'DEFAULT_ACTION' => "index",
    'URL_ROUTE_RULES' => array(
        array('/', 'Index/index', 'id'),
    ),
    'TAGLIB_LOAD' => true,
    'TAGLIB_PRE_LOAD' => 'Wj',
    'TAGLIB_BUILD_IN' => 'cx,Wj',
    'LOG_RECORD' => true, // 开启日志记录
    'LOG_RECORD_LEVEL' => array('EMERG', 'ALERT', 'CRIT', 'ERR', 'WARN', 'NOTICE', 'INFO', 'DEBUG', 'SQL'),
    'TOKEN_RESET' => true, // 令牌错误后是否重置   
    'ADMINSTRATOR' => '1', //超级权限管理员，此用户不受角色规则限制，不可删除
    'VAR_PAGE' => 'p',   
    'MESSAGE_SUCCESS' => '操作成功',
    'MESSAGE_ERROR' => '操作失败',
    'MESSAGE_HAS_AUDIT' => '用户已审核',
    'MESSAGE_NOT_DEL' => '用户已审核，删除失败',
    'CONFIG_PATH'=>"local",//获取config配置文件的url，local为获取本地的配置文件，请不要改动此项
);
return array_merge($config, $config_sys, $config_base, $config_api, $array, $config_pic);
?>