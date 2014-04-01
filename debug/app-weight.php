<?php
//体重类测试

require('glob-db.php');

require(DIR_APP.DS.'weight'.DS.'app-weight.php');

//假设用户ID
$userID = 1;

//创建对象
$appWeight = new AppWeight($db,$appList['weight']['table'][0],$userID);

//查询记录
$res = $appWeight->view('2014-03-29','2014-04-01');
echo '今天的记录 : ';
print_r($res);
echo '<br/>';

//添加记录
$weight = 65.5;
$id = $appWeight->set($weight,'2014-04-01',0.44);
if($id > 0){
	echo '添加成功,ID : '.$id.'.';
}
?>