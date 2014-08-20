<?php

//SysServer类测试

require('glob-db.php');

require(DIR_LIB.DS.'sys-server.php');

$sysServer = new SysServer($db,TABLE_SERVER);

?>