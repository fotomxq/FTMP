<?php
/**
 * Debug首页
 * @author fotomxq <fotomxq.me>
 * @version 2
 * @package debug
 */

//debug列表
$debugList = array(
  array('title'=>'文件管理器测试','link'=>'sys-file.php'),
  array('title'=>'体重处理器测试','link'=>'app-weight.php'),
  array('title'=>'用户系统测试','link'=>'sys-user.php'),
  array('title'=>'错误测试','link'=>'core-error.php'),
  array('title'=>'缓冲器测试','link'=>'core-cache.php'),
  array('title'=>'配置操作类测试','link'=>'sys-config.php'),
  array('title'=>'日志系统测试','link'=>'log.php'),
  array('title'=>'数据库测试','link'=>'db.php'),
  array('title'=>'IP测试','link'=>'ip.php')
  );
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
    	<h1>DEBUG</h1>
    	<p>该页面会列出所有debug处理页面，同时页面代码可用于其他页面输出处理。按照建立顺序倒叙排列。</p>
    	<!-- /Debug列表 -->
    	<table class="table table-striped">
    		<thead>
    			<tr>
    				<th>Name</th>
    				<th>Enter</th>
    			</tr>
    		</thead>
    		<tbody>
          <?php foreach($debugList as $v){ ?>
          <tr>
            <td><?php echo $v['title']; ?></td>
            <td><a class="btn btn-default" href="<?php echo $v['link']; ?>" target="_self">Start</a></td>
          </tr>
          <?php } ?>
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
