<?php
/**
 * 页面-菜单部分
 * @author fotomxq <fotomxq.me>
 * @version 2
 * @package web
 */
if(!isset($pageArr)) die();
?>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><img src="includes/assets/imgs/favicon.png" class="logo"> <?php echo $webData['WEB-TITLE'].' '.$pageArr['title']; ?></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li<?php if($pageArr['menu-focus'] == 'center'){echo ' class="active"';} ?>><a href="center.php"><span class="glyphicon glyphicon-home"></span> Center</a></li>
            <li<?php if($pageArr['menu-focus'] == 'user'){echo ' class="active"';} ?>><a href="center-user.php"><span class="glyphicon glyphicon-credit-card"></span> User</a></li>
            <li<?php if($pageArr['menu-focus'] == 'operate'){echo ' class="active"';} ?>><a href="center-operate.php"><span class="glyphicon glyphicon-certificate"></span> Operate</a></li>
            <li><a href="action-logout.php"><span class="glyphicon glyphicon-remove-sign"></span> Logout</a></li>
          </ul>
        </div>
      </div>
    </div>