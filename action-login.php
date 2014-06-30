<?php
/**
 * 登录动作
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-20 11:51:03
 * @version 2
 */

//引入全局
require('glob.php');

//判断登录标记
$loginBool = false;

//判断登录
if($_POST['email'] && $_POST['password']){
	$remember = isset($_POST['remember']);
	$email = $filter->getEmail($_POST['email']);
	$passwd = $_POST['password'];
	if($email && $filter->isString($passwd,6,25) == true){
		if($user->login($sysIP->nowID,$email,$passwd,$remember) == true){
			$loginBool = true;
		}
	}
}

//成功或失败,跳转回到首页
if($loginBool == true){
	CoreHeader::toURL('app'.DS.'center'.DS.'index.php');
}else{
	CoreHeader::toURL('index.php');
}

?>