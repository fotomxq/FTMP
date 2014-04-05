<?php
/**
 * 用户个人信息修改页面
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package web
 */

//引用登录检测模块
require('action-logged.php');

//页面设定
$pageArr['title'] = 'Center User';
$pageArr['menu-focus'] = 'user';

//引用头和目录页面
require('page-header.php');
require('page-menu.php');
?>
<div class="container">
  <div class="row">
    <h2>个人信息</h2>
  </div>
</div>
<?php require('page-footer.php'); ?>