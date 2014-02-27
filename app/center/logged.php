<?php

/**
 * 判断是否已经登录，否则跳转到首页
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package center
 */
//引用全局
require('glob.php');
//引用登录模块
require(DIR_LIB . DS . 'plug' . DS . 'login.php');
//判断是否已经登录
$login = new PlugLogin($session, VAR_CENTER_LOGIN_NAME);
$loginStatus = $login->checkStatus(VAR_CENTER_LOGIN_TIMEOUT);
//如果尚未登录，或超时
if ($loginStatus != true) {
    CoreHeader::toURL(WEB_URL . 'app/center/index.php');
}
?>