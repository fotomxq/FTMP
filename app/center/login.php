<?php

/**
 * 验证登录页面
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package center
 * @todo 1-验证输入，2-访问数据库用户表，3-查询并判断用户登录成功，4-最后注册session
 * @todo 加入读取数据库用户、密码
 * @todo 加入验证码
 */

//引用全局
require('glob.php');

//引用过滤器
require(DIR_LIB . DS . 'core' . DS . 'filter.php');

//引用登录模块
require(DIR_LIB . DS . 'plug' . DS . 'login.php');

//验证提交信息
if (isset($_POST['username']) == true && isset($_POST['password']) == true) {
    //暂时没有验证
    $userInputUsername = $_POST['username'];
    $userInputPassword = $_POST['password'];
    $userInputVcode = 1234;
    $dbUsername = $_POST['username'];
    $dbPassword = $_POST['password'];
    $dbVcode = 1234;

    //更新登录状态
    $login = new PlugLogin($session, VAR_CENTER_LOGIN_NAME);
    $userInputs = array($userInputPassword, $userInputVcode);
    $checkVars = array($dbPassword, $dbVcode);
    $loginBool = $login->login($userInputs, $checkVars);
    if ($loginBool == true) {
        //跳转到首页
        CoreHeader::toURL(WEB_URL . 'app/center/center.php');
    }
} else {
    CoreHeader::toURL(WEB_URL . 'app/center/index.php');
}
?>
