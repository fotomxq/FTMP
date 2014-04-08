<?php

/**
 * 登录检测模块
 * @author fotomxq <fotomxq.me>
 * @version 5
 * @package web
 * @todo 获取用户可用的APP列表
 */
//引用全局
require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'glob.php');

//判断是否已经登录
$userID = $user->logged($ipAddr);

if ($userID < 1) {
    //如果没有登录，跳转到登录页面
    CoreHeader::toURL('index.php?nologin');
}

//获取用户相关信息
$userInfos = $user->viewUser($userID);
$userInfos['appList'] = $user->viewMeta($userID,'app-list');

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