<?php
/**
 * 通用模版-Header
 * @author fotomxq <fotomxq.me>
 * @version 3
 * @package app-template
 */

if(isset($appPage) != true) die();

if(isset($appPage['glob']) == true){
  if(array_search('messenger',$appPage['glob']['pack']) !== false){
    array_push($appPage['glob']['css'],'messenger');
    array_push($appPage['glob']['js'],'messenger');
  }
  if(array_search('datetimepicker',$appPage['glob']['pack']) !== false){
    array_push($appPage['glob']['js'],'bootstrap-datetimepicker');
  }
  if(array_search('icheck',$appPage['glob']['pack']) !== false){
    array_push($appPage['glob']['js'],'icheck');
  }
  if(array_search('chart',$appPage['glob']['pack']) !== false){
    array_push($appPage['glob']['js'],'chart');
  }
}
?>
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/imgs/favicon.png">

    <title><?php echo $appPage['title']; ?> - <?php echo $webData['WEB-TITLE']; ?></title>
    <link href="../../includes/assets/css/bootstrap.css" rel="stylesheet">
    <?php
    if(isset($appPage['glob']) == true){
      if(isset($appPage['glob']['css']) == true){
        foreach($appPage['glob']['css'] as $v){
          echo '<link href="../../includes/assets/css/'.$v.'.css" rel="stylesheet">';
        }
      }
    }
    if(isset($appPage['temp']) == true){
      if(isset($appPage['temp']['css']) == true){
        foreach($appPage['temp']['css'] as $v){
          echo '<link href="../template/assets/css/'.$v.'.css" rel="stylesheet">';
        }
      }
    }
    if(isset($appPage['css']) == true){
      foreach($appPage['css'] as $v){
        echo '<link href="assets/css/'.$v.'.css" rel="stylesheet">';
      }
    }
    ?>
    <script>
        <?php if($appPage['menu-content']){ ?>var menuHide = [<?php echo json_encode($appPage['menu-content']); ?>];<?php } ?>
    </script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../includes/assets/js/html5shiv.js"></script>
      <script src="../../includes/assets/js/respond.js"></script>
    <![endif]-->
  </head>
  <body>