<?php
/**
 * Pex应用全局设定
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-28 22:40:09
 * @version 1
 */

//应用名称
$appName = 'pex';

//引用模版全局
require('../template/glob.php');

//设定页面引用
$pageIncludes = array('app'=>array('css'=>array('pex.css'),'js'=>array('pex.js')));

//设定页面参数
$appPages = array('title'=>'PEX');
?>