<?php
/**
 * 错误页面
 * 
 * @author liuzilu <fotomxq@gmail.com>
 * @version 2
 */
//错误对应提示
$errors = array(
  0=>'发生未知错误，给您造成的不便深表歉意。',
  'db'=>'无法连接到数据库。',
  'ip-no-white'=>'网站开启了IP白名单限制，您不在白名单内，所以无法访问。请联系管理员解决该问题。',
  'ip-ban'=>'IP被禁止访问，可能是您当前IP曾做出违规操作，如有异议请联系管理员。',
  'maint'=>'系统正在维护中...',
  'app-power'=>'您没有权限访问该应用。',
  'no-login'=>'您还没有登录，请先返回首页登录。');
//错误类型
$errorStr = '';
if(isset($_GET['t']) == true){
  $errorStr = isset($errors[$_GET['t']]) ? $errors[$_GET['t']] : $errors[0];
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
      <p><a href="index.php" target="_self">点击这里返回首页</a></p>
    </div><!-- /.container -->

    <script src="includes/assets/js/jquery.js"></script>
    <script src="includes/assets/js/bootstrap.js"></script>
    <script src="includes/assets/js/icheck.js"></script>
  </body>
</html>
