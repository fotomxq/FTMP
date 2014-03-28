<?php
/**
 * 网站首页
 * 
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package web
 */

//引入全局
require('glob.php');
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

    <title>Sign In - <?php echo $webData['WEB-TITLE']; ?></title>
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

    <form class="form-signin" role="form">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="email" class="form-control" placeholder="Email address" required autofocus>
        <input type="password" class="form-control" placeholder="Password" required>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>

    </div><!-- /.container -->

    <script src="includes/assets/js/jquery.js"></script>
    <script src="includes/assets/js/bootstrap.js"></script>
    <script src="includes/assets/js/icheck.js"></script>
  </body>
</html>
