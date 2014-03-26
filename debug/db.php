<?php
//数据库测试

require('glob.php');

require(DIR_LIB.DS.'core-db.php');

echo 'DNS : '.$dbDSN;
echo '<br/>';
echo 'User : '.$dbUser;
echo '<br/>';
echo 'Passwd : '.$dbPasswd;
echo '<br/>';
echo 'Persistent : '.$dbPersistent;
echo '<br/>';
echo 'Encoding : '.$dbEncoding;
echo '<br/>';

$db = new CoreDB($dbDSN,$dbUser,$dbPasswd,$dbPersistent,$dbEncoding);

if(!$db){
	die('Connect DB faild.');
}else{
	echo 'Connect DB Success.';
}
?>