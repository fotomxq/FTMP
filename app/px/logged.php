<?php

/**
 * 判断已登录模块
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package px
 */
//引用全局
require('glob.php');
//引用登录模块
require(DIR_LIB . DS . 'plug' . DS . 'login.php');
//判断是否已经登录
$login = new PlugLogin($session, VAR_PX_LOGIN_NAME);
$loginStatus = $login->checkStatus(VAR_PX_LOGIN_TIMEOUT);
//如果没有登录，或超时
if ($loginStatus != true) {
    CoreHeader::toURL(WEB_URL . 'app/center/center.php');
}
?>