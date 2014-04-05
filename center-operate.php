<?php
/**
 * 平台管理中心
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package web
 */

//引用登录检测模块
require('action-logged.php');

//页面设定
$pageArr['title'] = 'Center Operate';
$pageArr['menu-focus'] = 'operate';

//引用头和目录页面
require('page-header.php');
require('page-menu.php');
?>
<div class="container">
  <div class="row">
  	<h2>系统配置</h2>
  </div>
</div>  
<?php require('page-footer.php'); ?>
