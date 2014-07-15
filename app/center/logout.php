<?php

/**
 * 退出登录
 * @author liuzilu <fotomxq@gmail.com>
 * @date 2014-07-09 16:34:41
 * @version 1
 */
//引用全局
require('glob.php');

//退出登录
$user->logout($sysIP->nowIP);

//跳转
CoreHeader::toURL('../../index.php');
?>