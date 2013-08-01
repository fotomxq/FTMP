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
require(DIR_LIB_CORE . 'core-error.php');

//头信息类
require(DIR_LIB_CORE . 'core-header.php');

//文件操作类
require(DIR_LIB_CORE . 'core-file.php');
CoreFile::$ds = DS;

//缓冲器
require(DIR_LIB_CORE . 'core-cache.php');
$coreCache = new CoreCache(DIR_CACHE, CACHE_LIMIT_TIME, CACHE_ON);

//Session处理器
require(DIR_LIB_CORE . 'core-session.php');
$coreSession = new CoreSession();

//数据库
require(DIR_LIB_CORE . 'core-db.php');
$coreDB = new CoreDB($dbDSN, $dbUser, $dbPasswd, $dbPersistent, $dbEncoding);

//sys基础类
require(DIR_LIB_SYS . 'sys-base.php');

//配置操作类
require(DIR_LIB_SYS . 'sys-option.php');
$sysOption = new SysOption($coreDB);

//IP类
require(DIR_LIB_CORE . 'core-ip.php');
$ipConfigs = $sysOption->load(array('IP_BAN_ON', 'IP_BAN_LIST', 'IP_WHITE_ON', 'IP_WHITE_LIST'));
$coreIP = new CoreIP($ipConfigs['IP_BAN_LIST'], $ipConfigs['IP_WHITE_LIST']);
if ($ipConfigs['IP_BAN_ON'] == '1') {
    if ($coreIP->isBan() == true) {
        CoreHeader::toURL('error.php?e=ip');
    }
}
if ($ipConfigs['IP_WHITE_ON'] == '1') {
    if ($coreIP->isWhite() == false) {
        CoreHeader::toURL('error.php?e=ip');
    }
}

//日志类
require(DIR_LIB_SYS . 'sys-log.php');
$sysLog = new sysLog($coreDB, $coreIP->ip, DIR_LOG);
?>
