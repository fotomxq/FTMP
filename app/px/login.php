<?php

/**
 * 验证登录
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package px
 */
//引用全局
require('glob.php');
//引用登录模块
require(DIR_LIB . DS . 'plug' . DS . 'login.php');
//验证登录
if (isset($_POST['password']) == true) {
    $login = new PlugLogin($session, VAR_PX_LOGIN_NAME);
    $userInputs = array($_POST['password']);
    $checkVars = array($pxPassword);
    $loginStatus = $login->login($userInputs, $checkVars);
    if ($loginStatus === true) {
        CoreHeader::toURL(WEB_URL . 'app/px/px.php');
    } else {
        CoreHeader::toURL(WEB_URL . 'app/center/index.php');
    }
} else {
    CoreHeader::toURL(WEB_URL . 'app/center/index.php');
}
?>