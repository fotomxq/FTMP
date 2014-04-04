<?php
/**
 * APP全局设定
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package web
 */
//引用应用模版全局定义
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'glob.php');

//设定引用显示名称
$appPage['title'] = 'Music';

//引用组件
$appPage['glob']['pack'] = array('messenger','icheck','chart','datetimepicker');
$appPage['glob']['css'] = array('icheck-skins-flat','messenger-theme-future');
$appPage['glob']['js'] = array('ftmp-date');
$appPage['temp']['css'] = array('page');

//设定引用脚本和样式
$appPage['js'] = array('index');
?>