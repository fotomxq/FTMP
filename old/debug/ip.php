<?php
//IP测试

require('glob.php');

require(DIR_LIB.DS.'core-ip.php');

$ip = new CoreIP();

echo 'IP : '.$ip->getIP();
echo '<br/>';

echo 'IP address : ';
print_r($ip->getIPAddress('218.26.1.182'));
echo '<br/>';

?>