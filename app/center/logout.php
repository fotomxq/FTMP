<?php

/**
 * 退出登录页面
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package page
 */
require('glob.php');
//引用登录模块
require(DIR_LIB . DS . 'plug' . DS . 'login.php');
//退出登录
$login = new PlugLogin($session, VAR_CENTER_LOGIN_NAME);
$login->logout();
//跳转到登录首页
CoreHeader::toURL(WEB_URL . 'app/center/index.php');
?>