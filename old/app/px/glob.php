<?php

/**
 * 全局执行文件
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package px
 */
//引用全局glob
require('../center/glob.php');
//引用px配置文件
require('config.php');

//如果PX关闭
if (PX_ON == false) {
    die('PX closed.');
}
?>