<?php
//日志测试

require('glob.php');

require(DIR_LIB.DS.'core-log.php');

echo '日志是否开启 : '.LOG_ON;
echo '<br/>';
echo '日志目录 : '.LOG_DIR;
echo '<br/>';
echo '日志形式 : '.LOG_TYPE;
echo '<br/>';

//基本消息
$message = 'Debug Message by FTMCMS.';
$ip = '0.0.0.0';

//Test-A 默认日志形式
$log = new CoreLog(LOG_ON,LOG_DIR,LOG_TYPE);
if($log->add('debug-log',$message,$ip)){
	echo 'Test A Success.';
}else{
	echo 'Test A Faild.';
}
echo '<br/>';

//Test-B 日志形式2
$log = new CoreLog(LOG_ON,LOG_DIR,2);
if($log->add('debug-log',$message,$ip)){
	echo 'Test B Success.';
}else{
	echo 'Test B Faild.';
}
echo '<br/>';
?>