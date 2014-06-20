<?php
/**
 * 错误页面
 * 
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package web
 */
//错误对应提示
$errors = array(
  0=>'发生未知错误，给您造成的不便深表歉意。',
  'db'=>'无法连接到数据库。',
  'ip-ban'=>'IP被禁止访问，可能是您当前IP曾做出违规操作，如有异议请联系管理员。',
  'maint'=>'系统正在维护中...');
//错误类型
$errorStr = '';
if(isset($_GET['t']) == true){
  $errorStr = isset($errors[$_GET['t']]) == true ? $errors[$_GET['t']] : $errors[0];
}else{
  $errorStr = $errors[0];
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
    <link rel="shortcut icon" href="includes/assets/imgs/favicon.png">

    <title>错误</title>
    <link href="includes/assets/css/bootstrap.css" rel="stylesheet">
    <link href="includes/assets/css/index.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="includes/assets/js/html5shiv.js"></script>
      <script src="includes/assets/js/respond.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="container">
      <h1>错误</h1>
      <p><?php echo $errorStr; ?></p>
    </div><!-- /.container -->

    <script src="includes/assets/js/jquery.js"></script>
    <script src="includes/assets/js/bootstrap.js"></script>
    <script src="includes/assets/js/icheck.js"></script>
  </body>
</html>
