<?php
/**
 * 退出操作
 * @author fotomxq <fotomxq.me>
 * @version 2
 * @package web
 */

//引用全局
require('glob.php');

//记录日志
$log->add('action-logout','Logout ID : '.$userID);
//退出登录
$user->logout($ipAddr);
//跳转页面
CoreHeader::toURL('index.php');
?>