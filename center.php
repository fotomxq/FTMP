<?php
/**
 * 中心页面
 * @author fotomxq <fotomxq.me>
 * @version 4
 * @package web
 */

//引用登录检测模块
require('action-logged.php');
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

    <title>Center - <?php echo $webData['WEB-TITLE']; ?></title>
    <link href="includes/assets/css/bootstrap.css" rel="stylesheet">
    <link href="includes/assets/css/center.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="includes/assets/js/html5shiv.js"></script>
      <script src="includes/assets/js/respond.js"></script>
    <![endif]-->
  </head>

  <body>
    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><?php echo $webData['WEB-TITLE']; ?> Center</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="action-logout.php">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <!-- Begin page content -->
	  <div class="row center-row-fixed">
	  	<?php foreach($appList as $k=>$v){ ?>
	    <div class="col-lg-4">
	      <img src="app/<?php echo $k; ?>/assets/imgs/favicon.png" alt="<?php echo $v['name']; ?>">
	      <h2><?php echo $v['name']; ?></h2>
	      <p><?php echo $v['des']; ?></p>
	      <p><a class="btn btn-default" href="app/<?php echo $k; ?>/index.php" role="button">进入 &raquo;</a></p>
	    </div>
	    <?php } ?>
	  </div><!-- /.row -->

    <div id="footer">
      <div class="container">
        <p class="text-muted"><?php echo $webData['WEB-TITLE']; ?> &copy; 2014</p>
      </div>
    </div>

    <script src="includes/assets/js/jquery.js"></script>
    <script src="includes/assets/js/bootstrap.js"></script>
    <script src="includes/assets/js/icheck.js"></script>
  </body>
</html>
