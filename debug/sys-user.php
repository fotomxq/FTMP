<?php
//配置操作测试
require('glob-db.php');

require(DIR_LIB.DS.'sys-config.php');
require(DIR_LIB.DS.'sys-user.php');

//读取用户超时时间
$sysConfig = new SysConfig($db,TABLE_CONFIG);
$limitTime = (int)$sysConfig->get('USER-LIMIT-TIME');

//创建对象
$sysUser = new SysUser($db,TABLE_USER,TABLE_USER_META,USER_SESSION_LOGIN_NAME,$limitTime);

//测试创建用户
$newID = $sysUser->addUser('admin','admin','adminadmin');
if($newID) echo '创建了用户ID : '.$newID.'.<br/>';


//测试删除用户
/*
if($sysUser->delUser(4) == true){
	echo '成功删除用户ID 2.<br/>';
}
*/

//测试编辑用户
/*
if($sysUser->editUser(4,'admincs','admincsadmincs') == true){
	echo '成功编辑用户ID ';
}
*/

//测试添加元数据
/*
$newID = $sysUser->addMeta(1,'POWER','ADMIN');
$newID = $sysUser->addMeta(1,'POWER','NORMAL');
if($newID > 0){
	echo '成功添加了元数据 ID : '.$newID.'.<br/>';
}
*/

//测试修改元数据
/*
if($sysUser->editMeta(1,'POWERX') == true){
	echo '成功修改了元数据 ID : 1.<br/>';
}
*/

//测试删除元数据
/*
if($sysUser->delMeta(1) == true){
	echo '成功删除了元数据 ID : 1.<br/>';
}
*/

//测试检查用户权限
/*
$c = $sysUser->checkPower(1,array('ADMIN','VISITOR'));
if($c){
	echo '检测权限成功.<br/>';
	print_r($c);
	echo '<br/>';
}
*/

//编辑用户权限
/*
if($sysUser->editPower(1,array('ADMIN','VISITOR'))){
	echo '成功编辑用户权限.<br/>';
}
*/

//查看用户
$res = $sysUser->viewUser(1);
print_r($res);
echo '<br/><br/>';

//查看元数据
$res = $sysUser->viewMeta(1,'POWER');
print_r($res);
echo '<br/><br/>';

//查看元数据列表
$res = $sysUser->viewMetaList(1);
print_r($res);
echo '<br/><br/>';

//查看用户列表
$res = $sysUser->viewUserList('1',null,1,10,0,true);
print_r($res);
echo '<br/><br/>';

//测试用户登录

if($sysUser->login('1.1.1.1','admin','adminadmin',false) == true){
	echo '用户成功登录.';
	echo '<br/><br/>';
}

//测试用户登录检测
$res = $sysUser->logged('1.1.1.1');
if($res > 0){
	echo '用户已经登录,ID : '.$res;
	echo '<br/><br/>';
}

//测试用户退出
$sysUser->logout('1.1.1.1');
$res = $sysUser->logged('1.1.1.1');
if($res < 1){
	echo '用户已经登出.';
	echo '<br/><br/>';
}
?>