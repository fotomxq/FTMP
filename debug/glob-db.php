<?php
//debug全局引用

//创建了数据库处理器

require('glob.php');

require(DIR_LIB.DS.'core-db.php');

$db = new CoreDB($dbDSN,$dbUser,$dbPasswd,$dbPersistent,$dbEncoding);

if(!$db){
	die('Connent DB faild.');
}

//引用文件处理器

require(DIR_LIB.DS.'core-file.php');
?>