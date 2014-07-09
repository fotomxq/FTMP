<?php

/**
 * 全局设定模版
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-25 09:23:28
 * @version 1
 */
//路径分隔符
if (defined('DS') == false) {
    define('DS', DIRECTORY_SEPARATOR);
}

//引用全局变量
require('..' . DS . '..' . DS . 'glob.php');

//引用处理参数失效模块
require(DIR_APP_TEMPALTE . DS . 'app-error-power.php');

//定义当前应用全局缓冲识别变量
$webDateCache = false;

//检查登录状态
$userID = $user->logged($sysIP->nowID);
if ($userID < 1) {
    //尚未登录
    CoreHeader::toURL('../../' . PAGE_ERRPR . 'no-login');
}

/**
 * 判断用户是否具备该应用权限
 * 变量$appName为应用名称
 */
if (isset($appName) == true) {
    if ($appName === 'TEMPLATE') {
        //如果值为"TEMPLATE"，则表明无需权限；反之根据应用名确定权限。
    } else {
        //判断是否具备应用访问权限
        $checkAppPowers = $user->checkApp($userID, array($appName));
        if ($checkAppPowers[$appName] !== true) {
            AppErrorPower();
        }
        //判断是否具备总访问权限
        $checkPowers = $user->checkPower($userID, array('NORMAL'));
        if ($checkPowers['NORMAL'] !== true) {
            AppErrorPower();
        }
    }
} else {
    //没有定义则判断为参数失效
    AppErrorPower();
}
?>