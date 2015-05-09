<?php
/**
 * 自动创建目录
 * @param $dir
 * @param int $mode
 * @return bool
 */
function _init_mk_dir($dir,$mode=0777){
    if (is_dir($dir) || @mkdir($dir, $mode))
        return true;
    if (!_init_mk_dir(dirname($dir), $mode))
        return false;
    return @mkdir($dir, $mode);
}

/**
 * 运行前初始化一些参数
 */
defined("DS") OR define("DS", DIRECTORY_SEPARATOR);
define("MAIN_FILE", str_replace(array("/", "\\"), DS, $_SERVER["SCRIPT_FILENAME"]), true); //根文件
define("ROOT_PATH", dirname(dirname(__FILE__)) . DS); //根路径
define("THINK_PATH", dirname(__FILE__) . DS);
defined("APP_NAME") or define("APP_NAME", basename(dirname(MAIN_FILE)));
defined("APP_PATH") or define("APP_PATH", ROOT_PATH == dirname(MAIN_FILE).DS ? "." . DS . APP_NAME . DS : "." . DS);
defined("RUNTIME_PATH") or define("RUNTIME_PATH", dirname(THINK_PATH) . DS . "Cache" . DS . APP_NAME . DS);
_init_mk_dir(APP_PATH);
_init_mk_dir(RUNTIME_PATH);
defined("RUNTIME_DEF_FILE") or define("RUNTIME_DEF_FILE", RUNTIME_PATH."runtime_def_file.php");
if (isset($_SERVER["REQUEST_SCHEME"]))
    define("SCHEME", $_SERVER["REQUEST_SCHEME"] . "://", TRUE);
elseif (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "1") {
    define("SCHEME", "https://", TRUE);
} elseif (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
    define("SCHEME", "https://", TRUE);
} elseif ($_SERVER["REMOTE_PORT"] == "443") {
    define("SCHEME", "https://", TRUE);
} else {
    define("SCHEME", "http://", TRUE);
}
define("__HOST__", SCHEME . $_SERVER["HTTP_HOST"]);
if (is_file(dirname(MAIN_FILE) . DS . ".htaccess")) { //如果存在.htaccess
    $file_info = file(dirname(MAIN_FILE) . DS . ".htaccess");
    foreach ($file_info as $v) {
        if (preg_match("/RewriteEngine\s*On/i", $v)) {
            define("REWRITE", "1", true);
            break;
        }
    }
    unset($file_info);
}
defined("REWRITE") or define("REWRITE", "0", true);

define("__Index__", REWRITE ? rtrim(dirname($_SERVER['SCRIPT_NAME']),"/") . "/" : $_SERVER['SCRIPT_NAME'] . "/",true);
define("URL_ROOT", ROOT_PATH == dirname(MAIN_FILE) . DS ? rtrim(dirname($_SERVER['SCRIPT_NAME']), "/") . "/" : rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), "/")."/");
?>
