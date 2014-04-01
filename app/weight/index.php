<?php
/**
 * 体重记录首页
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package app-weight-page
 */

//引用全局
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
    <link rel="shortcut icon" href="assets/imgs/favicon.png">

    <title>Weight - <?php echo $webData['WEB-TITLE']; ?></title>
    <link href="../../includes/assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/index.css" rel="stylesheet">

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
          <a class="navbar-brand" href="#"><?php echo $webData['WEB-TITLE']; ?> Weight</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
          	<li><a href="../../center.php">Center</a></li>
            <li><a href="action-logout.php">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <!-- Begin page content -->
    <div class="container marketing">
    	<h2 class="page-header">Chart</h2>
    	<div class="row row-fixed">
	    	<a class="btn btn-default" href="#chartWeek"><span class="glyphicon glyphicon-credit-card"></span> 周</a>
	    	<a class="btn btn-default" href="#chartMonth"><span class="glyphicon glyphicon-calendar"></span> 月</a>
	    	<a class="btn btn-default" href="#chartMonth3"><span class="glyphicon glyphicon-calendar"></span> 三月</a>
	    	<a class="btn btn-default" href="#chartYear"><span class="glyphicon glyphicon-calendar"></span> 年</a>
	    </div>
    	<div class="row">
    		<canvas id="weightChart" width="900" height="300"></canvas>
    	</div>
    	<h2 class="page-header">Set</h2>
	    <div class="row">
	    	<a class="btn btn-default" href="#"><span class="glyphicon glyphicon-plus"></span> 记录体重</a>
	    </div>
	</div>

    <div id="footer">
      <div class="container">
        <p class="text-muted"><?php echo $webData['WEB-TITLE']; ?> &copy; 2014</p>
      </div>
    </div>

    <script src="../../includes/assets/js/jquery.js"></script>
    <script src="../../includes/assets/js/bootstrap.js"></script>
    <script src="../../includes/assets/js/chart.js"></script>
    <script src="../../includes/assets/js/icheck.js"></script>
    <script src="assets/js/index.js"></script>
  </body>
</html>
