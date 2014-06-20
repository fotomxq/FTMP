<?php
//sysIP测试文件
require('glob-db.php');

require(DIR_LIB.DS.'sys-ip.php');

$sysIp = new SysIP($db,'sys_ip');

//查询单个IP
$resViewIP = $sysIp->view(1);
print_r($resViewIP);
echo '<br/><br/>';

//查询列表
$resViewListIp = $sysIp->viewList(null,null,null,1,10,0,false);
print_r($resViewListIp);
echo '<br/><br/>';

//查询是否拉黑
//测试参数:1
//测试参数:'::1'
$resIsBan = $sysIp->isBan(1);
if($resIsBan){
	echo '已经拉黑.';
}else{
	echo '没有拉黑.';
}
echo '<br/><br/>';

//修改拉黑状态
if($sysIp->setBan(1,false)){
	echo '修改拉黑状态成功.';
}
echo '<br/><br/>';

//修改真实地址
if($sysIp->setReal(1,'localhost')){
	echo '修改真实地址成功.';
}
echo '<br/><br/>';
?>