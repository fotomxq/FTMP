<?php
?>
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../includes/assets/imgs/favicon.png">

    <title>Debug首页</title>

    <!-- Bootstrap core CSS -->
    <link href="../includes/assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="navbar-static-top.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../includes/assets/js/html5shiv.js"></script>
      <script src="../includes/assets/js/respond.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Static navbar -->
    <div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Debug首页</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="debug-putout.php">输出产品</a></li>
            <li><a href="../index.php">退出</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>


    <div class="container">
    	<!-- /提示 -->
    	<h1>Message</h1>
    	<p>该页面会列出所有debug处理页面，同时页面代码可用于其他页面输出处理。</p>
    	<!-- /Debug列表 -->
    	<table class="table table-striped">
    		<thead>
    			<tr>
    				<th>Name</th>
    				<th>Enter</th>
    			</tr>
    		</thead>
    		<tbody>
          <tr>
            <td>用户系统测试</td>
            <td><a class="btn btn-default" href="sys-user.php" target="_self">Start</a></td>
          </tr>
          <tr>
            <td>错误测试</td>
            <td><a class="btn btn-default" href="core-error.php" target="_self">Start</a></td>
          </tr>
          <tr>
            <td>缓冲器测试</td>
            <td><a class="btn btn-default" href="core-cache.php" target="_self">Start</a></td>
          </tr>
          <tr>
            <td>配置操作类测试</td>
            <td><a class="btn btn-default" href="sys-config.php" target="_self">Start</a></td>
          </tr>
    			<tr>
    				<td>日志系统测试</td>
    				<td><a class="btn btn-default" href="log.php" target="_self">Start</a></td>
    			</tr>
    			<tr>
    				<td>数据库测试</td>
    				<td><a class="btn btn-default" href="db.php" target="_self">Start</a></td>
    			</tr>
          <tr>
            <td>IP测试</td>
            <td><a class="btn btn-default" href="ip.php" target="_self">Start</a></td>
          </tr>
    		</tbody>
    	</table>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../includes/assets/js/jquery.js"></script>
    <script src="../includes/assets/js/bootstrap.js"></script>
  </body>
</html>
