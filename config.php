<?php

/**
 * 全局配置文件
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package config
 */
//////////////////
//路径定义
//////////////////
//路径分隔符
define('DS', DIRECTORY_SEPARATOR);
//绝对路径
define('DIR_ROOT', dirname(__FILE__) . DS);
//库路径
define('DIR_LIB', DIR_ROOT . 'libs');
//配置目录路径
define('DIR_CONFIG', DIR_ROOT . 'conf');
//上传目录路径
define('DIR_UPLOAD', DIR_ROOT . 'upload');
//缓冲目录路径
define('DIR_CACHE', DIR_ROOT . 'cache');
//主题目录路径
define('DIR_THEME', DIR_ROOT . 'theme');

//////////////////
//缓冲器
//////////////////
//缓冲器开关
define('CACHE_ON', true);
//失效时间长度 ( 秒 )
define('CACHE_LIMIT_TIME', 86400);

//////////////////
//URL
//////////////////
//URL
define('WEB_URL', 'http://localhost/ftmp/');
//assets
define('WEB_URL_ASSETS', WEB_URL . 'theme');

//////////////////
//其他设置
//////////////////
//网站开关，超级开关，关闭后后台也无法使用
define('WEB_ON', true);
//定义时区
date_default_timezone_set('PRC');
?>