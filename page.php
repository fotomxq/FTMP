<?php

/**
 * 全局页面引用文件
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package page
 */
//引用全局定义
require('glob.php');

//设定编码
CoreHeader::toPage(PAGE_CHARSET);

//获取网站名称
$webTitle = $sysOption->load('WEB_TITLE');
?>