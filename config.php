<?php

/**
 * 配置文件
 * @author fotomxq <fotomxq.me>
 * @version 2
 * @package sys
 */
//////////////////
//数据库定义
//////////////////
//PDO-DSN eg: mysql:host=localhost;dbname=databasename;charset=utf8
$dbDSN = 'mysql:host=localhost;dbname=ftmpersonal;charset=utf8';
//数据库用户名
$dbUser = 'admin';
//数据库密码
$dbPasswd = 'admin';
//是否持久化连接
$dbPersistent = true;
//连接编码
$dbEncoding = 'utf8';
//表名称前缀
define('DB_PREFIX', 'fp_');

//////////////////
//路径定义
//////////////////
//路径分隔符
define('DS', DIRECTORY_SEPARATOR);
//绝对路径
define('DIR_ROOT', __DIR__ . DS);
//用户数据
define('DIR_DATA', DIR_ROOT . 'content');
//库路径
define('DIR_LIB', DIR_ROOT . 'includes');

//////////////////
//目录设定
//////////////////
//备份目录
define('DIR_BACKUP', DIR_DATA . DS . 'backup');
//缓冲目录
define('DIR_CACHE', DIR_DATA . DS . 'cache');
//日志目录
define('DIR_LOG', DIR_DATA . DS . 'log');
//上传文件目录
define('DIR_UPLOAD', DIR_DATA . DS . 'uploads');
//lib-core目录
define('DIR_LIB_CORE', DIR_LIB . DS . 'core' . DS);
//lib-sys目录
define('DIR_LIB_SYS', DIR_LIB . DS . 'sys' . DS);
//lib-plugs目录
define('DIR_LIB_PLUG', DIR_LIB . DS . 'plug' . DS);

//////////////////
//其他设定
//////////////////
//URL
define('WEB_URL', 'http://192.168.1.101/ftmp');
//Debug模式开关
define('DEBUG_ON', true);
//页面编码
define('PAGE_CHARSET','utf-8');

//////////////////
//定义时区
//////////////////
date_default_timezone_set('PRC');
?>
