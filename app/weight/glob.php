<?php
/**
 * APP全局设定
 * @author fotomxq <fotomxq.me>
 * @version 5
 * @package web
 */
//引用应用模版全局定义
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'glob.php');

//设定引用显示名称
$appPage['title'] = '体重中心';

//引用组件
$appPage['glob']['pack'] = array('messenger','icheck','chart','datetimepicker');
$appPage['glob']['css'] = array('icheck-skins-flat','messenger-theme-future');
$appPage['glob']['js'] = array('ftmp-date');
$appPage['temp']['css'] = array('page');
$appPage['temp']['js'] = array('menu');

//设定引用脚本和样式
$appPage['js'] = array('index');

//设定顶部菜单
$appPage['menu-left'] = array(array('url'=>'#urlSet','title'=>'<span class="glyphicon glyphicon-pushpin"></span> 设置','active'=>true),array('url'=>'#urlChart','title'=>'<span class="glyphicon glyphicon-stats"></span> 图表'));
$appPage['menu-content-hide'] = true;
$appPage['menu-content'] = array(array('#urlSet','#contentSet'),array('#urlChart','#contentChart'));
?>