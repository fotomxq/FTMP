<?php

//SysFile类测试

require('glob-db.php');

require(DIR_LIB.DS.'sys-file.php');

$sysFile = new SysFile($db,UPLOAD_DIR,TABLE_FILE);

//上传新的文件
echo 'sysFile::upload()<br/>';
if(isset($_FILES['upload'])){
	if($sysFile->upload($_FILES['upload'])){
		echo '上传成功!';
	}else{
		echo '上传失败!';
	}
}
echo '<br/><br/>';

//移动文件入库
$f = DIR_DATA.DS.'jquery.png';
echo 'sysFile::move()<br/>'.$f.'<br/>';
$on = false;
if($on){
	if($sysFile->move($f)){
		echo '入库成功！';
	}else{
		echo '入库失败！';
	}
}
echo '<br/><br/>';

//查询ID
echo 'sysFile::view()<br/>';
print_r($sysFile->view(1));
echo '<br/><br/>';

//查询列
echo 'sysFile::search()<br/>';
//print_r($sysFile->search('1',null));
echo '<br/><br/>';

//检查重复文件
echo 'sysFile::checkRepeat()<br/>';
print_r($sysFile->checkRepeat());
echo '<br/><br/>';

//检查丢失文件
echo 'sysFile::checkInfos()<br/>';
$o = $sysFile->checkInfos();
print_r($o);
echo '<br/><br/>';

//优化丢失文件
echo 'sysFile::optimizationFile()<br/>';
echo '<br/><br/>';

//删除文件
echo 'sysFile::del()<br/>';
if($sysFile->del(1)){
	echo '删除文件成功.';
}
echo '<br/><br/>';

?>
<form enctype="multipart/form-data" action="sys-file.php" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
    Send this file: <input name="upload" type="file" />
    <input type="submit" value="Send File" />
</form>