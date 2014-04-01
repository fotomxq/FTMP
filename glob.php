<?php
/**
 * 全局引用
 * 所有非特殊页面必须引用的页面，包含必备的配置和库引用。
 * 
 * @author fotomxq <fotomxq.me>
 * @version 3
 * @package web
 */

//引用配置文件
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php');

//错误处理模块
require(DIR_LIB.DS.'core-error.php');

//头信息处理器
require(DIR_LIB.DS.'core-header.php');

//缓冲器
require(DIR_LIB.DS.'core-cache.php');
$cache = new CoreCache(CACHE_ON,CACHE_LIMIT_TIME,CACHE_DIR);

//文件处理
require(DIR_LIB.DS.'core-file.php');

//数据库
require(DIR_LIB.DS.'core-db.php');
$db = new CoreDB($dbDSN,$dbUser,$dbPasswd,$dbPersistent,$dbEncoding);
if(!$db){
	die();
}

//过滤器
require(DIR_LIB.DS.'core-filter.php');
$filter = new CoreFilter();

//IP类
require(DIR_LIB.DS.'core-ip.php');
$ip = new CoreIP();
$ipAddr = $ip->getIP();

//日志类
require(DIR_LIB.DS.'core-log.php');
$log = new CoreLog(LOG_ON,LOG_DIR,LOG_TYPE,$ipAddr);

//配置处理器
require(DIR_LIB.DS.'sys-config.php');
$config = new SysConfig($db,TABLE_CONFIG);

//获取网站页面通用数据
$cacheWebDataName = 'WEB-PAGE-DATA';
$webData = $cache->get($cacheWebDataName);
if($webData){
	$webData = json_decode($webData,true);
}else{
	$webData = null;
	$webData['WEB-TITLE'] = $config->get(1);
	$webData['USER-LIMIT-TIME'] = $config->get('USER-LIMIT-TIME');
	$cache->set($cacheWebDataName,json_encode($webData));
}

//用户处理器
require(DIR_LIB.DS.'sys-user.php');
$user = new SysUser($db,TABLE_USER,TABLE_USER_META,USER_SESSION_LOGIN_NAME,(int)$webData['USER-LIMIT-TIME']);

?>