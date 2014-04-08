<?php
/**
 * 页面-头部分
 * @author fotomxq <fotomxq.me>
 * @version 2
 * @package web
 */
if(!isset($pageArr)) die();
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