<?php
/**
 * APP全局设定
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package web
 */
//引用登录检测模块
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'glob.php');

//判断是否已经登录
$userID = $user->logged($ipAddr);
if($userID < 1){
	//如果没有登录，跳转到登录页面
	CoreHeader::toURL('../../index.php');
}
?>