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
    <link href="../../includes/assets/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link href="../../includes/assets/css/icheck-skins-flat.css" rel="stylesheet">
    <link href="../../includes/assets/css/messenger.css" rel="stylesheet">
    <link href="../../includes/assets/css/messenger-theme-future.css" rel="stylesheet">
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
            <span class="sr-only">导航</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><?php echo $webData['WEB-TITLE']; ?> Weight</a>
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
    <div class="container marketing container-fixed">
    	<h2 class="page-header">Chart</h2>
    	<div class="row row-fixed">
        <label>
          <div class="icheckbox"><input type="radio" id="chartWeight" name="chartSelect"> 体重</div>
        </label>
        <label>
          <div class="icheckbox"><input type="radio" id="chartFat" name="chartSelect"> 体脂 </div>
        </label>
	    	<a class="btn btn-default" href="#chartWeek"><span class="glyphicon glyphicon-credit-card"></span> 最近7天</a>
	    	<a class="btn btn-default" href="#chartMonth"><span class="glyphicon glyphicon-calendar"></span> 本月</a>
	    	<a class="btn btn-default" href="#chartYear"><span class="glyphicon glyphicon-calendar"></span> 年</a>
	    </div>
    	<div class="row">
    		<canvas id="weightChart" width="900" height="300"></canvas>
    	</div>
    	<h2 class="page-header">Set</h2>
	    <div class="row row-fixed">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">日期</span>
            <input class="form-control" type="text" data-date-format="yyyy-mm-dd" id="datetimepicker">
            <span class="input-group-btn">
              <a class="btn btn-default" href="#setDateRepeat"><span class="glyphicon glyphicon-repeat"></span></a>
            </span>
            <span class="input-group-btn">
              <a class="btn btn-default" href="#setDateCalendar"><span class="glyphicon glyphicon-calendar"></span></a>
            </span>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">体重</span>
            <input id="weight" class="form-control" type="text" placeholder="0.00">
            <span class="input-group-addon">KG</span>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">体脂含量</span>
            <input id="fat" class="form-control" type="text" placeholder="0">
            <span class="input-group-addon">%</span>
          </div>
        </div>
	    </div>
      <div class="row row-fixed">
        <div class="col-lg-1">
          <label>
            <div class="icheckbox"><input type="checkbox" id="tagDinner"> 吃饭</div>
          </label>
        </div>
        <div class="col-lg-1">
          <label>
            <div class="icheckbox"><input type="checkbox" id="tagSport"> 运动</div>
          </label>
        </div>
        <div class="col-lg-1">
          <label>
            <div class="icheckbox"><input type="checkbox" id="tagSleep"> 睡觉</div>
          </label>
        </div>
        <div class="col-lg-1">
          <label>
            <div class="icheckbox"><input type="checkbox" id="tagToilet"> 厕所</div>
          </label>
        </div>
        <div class="col-lg-1">
          <label>
            <div class="icheckbox"><input type="checkbox" id="tagSick"> 生病</div>
          </label>
        </div>
        <div class="col-lg-1">
          <label>
            <div class="icheckbox"><input type="checkbox" id="tagAlcohol"> 饮酒</div>
          </label>
        </div>
      </div>
      <div class="row row-fixed">
        <div class="col-lg-8">
          <textarea id="note" class="form-control" rows="3" placeholder="Note..."></textarea>
        </div>
      </div>
      <div class="row row-fixed">
        <div class="col-lg-3">
          <a class="btn btn-default" href="#setDataSubmit"><span class="glyphicon glyphicon-plus"></span> 记录体重</a>
        </div>
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
    <script src="../../includes/assets/js/bootstrap-datetimepicker.js"></script>
    <script src="../../includes/assets/js/messenger.js"></script>
    <script src="../../includes/assets/js/ftmp-date.js"></script>
    <script src="assets/js/index.js"></script>
  </body>
</html>
