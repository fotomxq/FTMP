<?php

/**
 * 全局设定
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package sys
 */
//引用配置文件
require('config.php');

/**
 * 引用必备库
 */
//错误处理模块
require(DIR_LIB . DS . 'core-error.php');

//头信息类
require(DIR_LIB . DS . 'core-header.php');

//缓冲器
require(DIR_LIB . DS . 'core-cache.php');
$coreCache = new CoreCache(DIR_CACHE, CACHE_LIMIT_TIME, CACHE_ON);

//Session处理器
require(DIR_LIB . DS . 'core-session.php');
$coreSession = new CoreSession();

//访客提交处理器
require(DIR_LIB . DS . 'plug-vistor-post.php');
$plugVistorPost = new PlugVistorPost($coreSession);

//数据库
require(DIR_LIB . DS . 'core-db.php');
$coreDB = new CoreDB($dbDSN, $dbPasswd, $dbUser, $dbPersistent, $dbEncoding);

//文件操作类
require(DIR_LIB . DS . 'core-file.php');
CoreFile::$ds = DS;

//配置操作类
require(DIR_LIB . DS . 'sys-config.php');
$sysConfig = new SysConfig($coreDB);

//IP类
require(DIR_LIB . DS . 'core-ip.php');
$ipConfigs = $sysConfig->load(array('IP_BAN_ON', 'IP_BAN_LIST', 'IP_WHITE_ON', 'IP_WHITE_LIST'));
$coreIP = new CoreIP($ipConfigs['IP_BAN_LIST'], $ipConfigs['IP_WHITE_LIST']);
if ($ipConfigs['IP_BAN_ON'] == '1') {
    if ($coreIP->isBan() == true) {
        
    }
}
if ($ipConfigs['IP_WHITE_ON'] == '1') {
    if ($coreIP->isWhite() == false) {
        
    }
}

//日志类
require(DIR_LIB . DS . 'sys-log.php');
$sysLog = new sysLog($coreDB, $coreIP->ip, DIR_LOG);
?>
