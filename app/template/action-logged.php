<?php

/**
 * 应用内判断用户已登录模块
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package app-template
 */
//引用全局设定
require(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'glob.php');

//判断是否已经登录
$userID = $user->logged($ipAddr);

if ($userID < 1) {
    //如果没有登录，跳转到登录页面
    CoreHeader::toURL('index.php?nologin');
}

//获取用户相关信息
$userInfos = $user->viewUser($userID);

//获取用户权限判断组
$userPowers = $user->checkPower($userID, $user->powerValues);

//判断用户是否具备基本权限
if (!$userPowers) {
    CoreHeader::toURL('index.php?power');
}
if (!$userPowers['NORMAL']) {
    die('No Power.');
}
?>