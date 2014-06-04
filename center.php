<?php
/**
 * 中心页面
 * @author fotomxq <fotomxq.me>
 * @version 6
 * @package web
 */
//引用登录检测模块
require('action-logged.php');

//页面设定
$pageArr['title'] = '中心';
$pageArr['menu-focus'] = 'center';

?>
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="includes/assets/imgs/favicon.png">

    <title><?php echo $pageArr['title'].' - '.$webData['WEB-TITLE']; ?></title>
    <link href="includes/assets/css/bootstrap.css" rel="stylesheet">
    <link href="includes/assets/css/center.css" rel="stylesheet">
    <?php if(isset($pageArr['css']) == true){ foreach($pageArr['css'] as $v){ ?>
    <link href="includes/assets/css/<?php echo $v; ?>.css" rel="stylesheet">
    <?php } } ?>
    <!--[if lt IE 9]>
      <script src="includes/assets/js/html5shiv.js"></script>
      <script src="includes/assets/js/respond.js"></script>
    <![endif]-->
  </head>
  <body>