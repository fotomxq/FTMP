<?php

/**
 * 全局设定
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-08-20 17:07:07
 * @version 1
 */
//引入配置文件
require(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config.php');

//错误处理器
require(DIR_LIB . DS . 'core-error.php');
//设定错误输出函数
set_error_handler('CoreErrorHandle');

//头信息处理
require(DIR_LIB . DS . 'core-header.php');

//缓冲器
require(DIR_LIB . DS . 'core-cache.php');
$cache = new CoreCache(CACHE_ON, CACHE_LIMIT_TIME, CACHE_DIR);

//文件处理
require(DIR_LIB . DS . 'core-file.php');

//过滤器
require(DIR_LIB . DS . 'core-filter.php');
$filter = new CoreFilter();

//日志类
require(DIR_LIB . DS . 'core-log.php');
$log = new CoreLog(LOG_ON, LOG_DIR, LOG_TYPE, $ipAddr);

//数据库
require(DIR_LIB . DS . 'core-db.php');
$db = new CoreDB($dbDSN, $dbUser, $dbPasswd, $dbPersistent, $dbEncoding);
if (!$db) {
    CoreHeader::toURL(PAGE_ERRPR . 'db');
}
?>