<?php

/**
 * APP全局设定
 * @author fotomxq <fotomxq.me>
 * @version 2
 * @package web
 */
//引用应用模版全局定义
require(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'glob.php');

//设定引用显示名称
$appPage['title'] = '音乐';

//引用组件
$appPage['glob']['pack'] = array('messenger','icheck','chart','datetimepicker');
$appPage['glob']['css'] = array('icheck-skins-flat','messenger-theme-future');
$appPage['glob']['js'] = array('ftmp-date');
$appPage['temp']['css'] = array('page');
$appPage['temp']['js'] = array('menu');

//设定引用脚本和样式
$appPage['js'] = array('index');

//设定顶部菜单
$appPage['menu-left'] = array(array('url'=>'#urlFm','title'=>'<span class="glyphicon glyphicon-play-circle"></span> FM','active'=>true),array('url'=>'#urlManage','title'=>'<span class="glyphicon glyphicon-signal"></span> 管理'),array('url'=>'#urlAdd','title'=>'<span class="glyphicon glyphicon-plus-sign"></span> 添加'));
$appPage['menu-content-hide'] = true;
$appPage['menu-content'] = array(array('#urlSet','#contentSet'),array('#urlChart','#contentChart'));
?>