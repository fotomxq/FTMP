<?php

/**
 * 所有应用引用处理
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package center
 * @tudo 添加获取应用assets函数处理,修改目录路径
 */
//引用全局配置
require('../../config.php');
//引用中心配置
require('config.php');

//如果平台关闭
if (WEB_ON == false) {
    die('FTM closed.');
}

//引用error
require(DIR_LIB . DS . 'core' . DS . 'error.php');

//引用Session
require(DIR_LIB . DS . 'core' . DS . 'session.php');
$session = new CoreSession();

//引用ip
require(DIR_LIB . DS . 'core' . DS . 'ip-get.php');

//引用header
require(DIR_LIB . DS . 'core' . DS . 'header.php');

//引用数据库处理
require(DIR_CONFIG . DS . 'db.inc.php');
require(DIR_LIB . DS . 'core' . DS . 'db.php');
//连接数据库
$db = new CoreDB($dbDSN, $dbUser, $dbPasswd, $dbPersistent, $dbEncoding);
if (!$db) {
    die('Mysql connect failure.');
}

//引用文件处理
require(DIR_LIB . DS . 'core' . DS . 'file.php');

//引用缓冲处理
require(DIR_LIB . DS . 'core' . DS . 'cache.php');

//引用
?>