<?php

/**
 * 验证码
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package page
 */
//引入包
require('glob.php');
require(DIR_LIB_PLUG.'plug-vcode.php');
//生成验证码
PlugVCode(5,20,150,30);
?>
