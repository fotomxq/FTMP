<?php
/**
 * APP全局设定
 * @author fotomxq <fotomxq.me>
 * @version 7
 * @package web
 */
//引用应用模版全局定义
require(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'action-logged.php');

//判断用户是否具备访问该应用的权限
$userAppPowers = $user->checkApp($userID, array('finance'));
if ($userAppPowers['finance'] != true) {
    die('No App Power.');
}

//设定引用显示名称
$appPage['title'] = '帐务中心';

//引用组件
$appPage['glob']['pack'] = array('messenger','icheck','chart','datetimepicker');
$appPage['glob']['css'] = array('icheck-skins-flat','messenger-theme-future');
$appPage['glob']['js'] = array('ftmp-date','menu');
$appPage['temp']['css'] = array('page');

//设定引用脚本和样式
$appPage['js'] = array('index');

//设定顶部菜单
$appPage['menu-left'] = array(
    array('url'=>'#urlSet','title'=>'<span class="glyphicon glyphicon-pushpin"></span> 记账','active'=>true),
    array('url'=>'#urlChart','title'=>'<span class="glyphicon glyphicon-stats"></span> 图表'),
    array('url'=>'#urlSearch','title'=>'<span class="glyphicon glyphicon-list-alt"></span> 查账'),
    array('url'=>'#urlBudget','title'=>'<span class="glyphicon glyphicon-tasks"></span> 预算'));
$appPage['menu-content-hide'] = true;
$appPage['menu-content'] = array(array('#urlSet','#contentSet'),array('#urlChart','#contentChart'));
?>