<?php

/**
 * 超级工具
 * @author liuzilu <fotomxq.me>
 * @date    2014-08-03 10:29:00
 * @version 1
 */
//引用配置文件
require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php');

//错误处理模块
require(DIR_LIB . DS . 'core-error.php');

//头信息处理器
require(DIR_LIB . DS . 'core-header.php');

//缓冲器需要的函数
require(DIR_LIB . DS . 'plug-img-scale.php');

//缓冲器
require(DIR_LIB . DS . 'core-cache.php');
$cache = new CoreCache(CACHE_ON, CACHE_LIMIT_TIME, CACHE_DIR);

//文件处理
require(DIR_LIB . DS . 'core-file.php');

//设定时区
date_default_timezone_set('PRC');

//数据库
require(DIR_LIB . DS . 'core-db.php');
$db = new CoreDB($dbDSN, $dbUser, $dbPasswd, $dbPersistent, $dbEncoding);
if (!$db) {
    CoreHeader::toURL(PAGE_ERRPR . 'db');
}

//过滤器
require(DIR_LIB . DS . 'core-filter.php');
$filter = new CoreFilter();

//IP类
require(DIR_LIB . DS . 'sys-ip.php');
$sysIP = new SysIP($db, TABLE_IP, $apiKeys);

//日志类
require(DIR_LIB . DS . 'core-log.php');
$log = new CoreLog(LOG_ON, LOG_DIR, LOG_TYPE, $ipAddr);

//配置处理器
require(DIR_LIB . DS . 'sys-config.php');
$config = new SysConfig($db, TABLE_CONFIG);

//获取操作密匙
$configToolPasswd = $config->get('TOOL-PASSWD');

//计算出现在的密码
$nowTime = date('YmdH');
$nowPasswd = $configToolPasswd . $nowTime;
$nowPasswdSha1 = substr(sha1($nowPasswd), 0, 6);

//用户请求
if (!isset($_GET['p']) || !isset($_GET['action'])) {
    die();
}
if ($_GET['action'] == 'passwd' && $_GET['p'] == $configToolPasswd) {
    die($nowPasswdSha1);
}
if ($_GET['p'] != $nowPasswdSha1) {
    die();
}
switch ($_GET['action']) {
    case 'stop-maint':
        $res = $config->save('WEB-MAINT-ON', '0');
        if ($res) {
            die('ok.');
        }
        break;
    case 'add-ip':
        $configIpWhite = $config->get('IP-WHITE-LIST');
        $configIpWhiteList = array();
        if ($configIpWhite) {
            $configIpWhiteList = explode(',', $configIpWhite);
        }
        if (!in_array($sysIP->nowAddr, $configIpWhiteList)) {
            $configIpWhiteList[] = $sysIP->nowAddr;
            $configIpWhiteStr = implode(',', $configIpWhiteList);
            $res = $config->save('IP-WHITE-LIST', $configIpWhiteStr);
        } else {
            $res = true;
        }
        if ($res) {
            die('ok.');
        }
        break;
}
die('faild');
?>