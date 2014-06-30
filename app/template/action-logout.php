<?php
/**
 * 登录动作
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-20 11:51:03
 * @version 1
 */

//引入全局
require('glob.php');

//判断登录标记
$loginBool = false;

//退出登录
$user->logout($sysIP->nowID);

//跳转到登录主页
CoreHeader::toURL('../../index.php');

?>