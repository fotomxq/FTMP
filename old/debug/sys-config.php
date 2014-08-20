<?php
//配置操作测试
require('glob-db.php');

require(DIR_LIB.DS.'sys-config.php');

//创建对象
$sysConfig = new SysConfig($db,TABLE_CONFIG);

$testName = 'TEST';
$testValue = 'XYXY';

//获取值
echo 'Get ID 1 : '.$sysConfig->get(1);
echo '<br/>';

echo 'Get Name \'WEB-TITLE\' : '.$sysConfig->get('WEB-TITLE');
echo '<br/><br/>----------------------------<br/>';

//修改值
$default = $sysConfig->get(1);
echo '准备修改ID1值为\''.$testValue.'\' : ';
if($sysConfig->save(1,$testValue)){
	echo 'OK.';
}else{
	echo '修改失败。';
}
echo '<br/>';

echo 'Edit Get ID 1 : '.$sysConfig->get(1);
echo '<br/><br/>----------------------------<br/>';

$sysConfig->save(1,$default);

//添加值
$newID = $sysConfig->add($testName,$testValue);
if($newID > 0){
	echo 'add ok.ID : '.$newID;
}else{
	echo 'add faild.';
}
echo '<br/>';

echo 'Add Get TestName : '.$sysConfig->get($testName);
echo '<br/><br/>----------------------------<br/>';

//删除值
if($sysConfig->del($testName) == true){
	echo 'Del OK ,by Name : '.$testName;
}else{
	echo 'Del Falid.';
}

?>