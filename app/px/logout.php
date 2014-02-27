<?php

/**
 * 退出登录
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package px
 */
//引用全局
require('glob.php');
//引用登录模块
require(DIR_LIB . DS . 'plug' . DS . 'login.php');
//退出登录
$login = new PlugLogin($session, VAR_PX_LOGIN_NAME);
$login->logout();
//跳转到首页
CoreHeader::toURL(WEB_URL . 'app/center/center.php');
?>