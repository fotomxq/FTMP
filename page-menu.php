<?php
/**
 * 页面-菜单部分
 * @author fotomxq <fotomxq.me>
 * @version 1
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
          <a class="navbar-brand" href="index.php"><?php echo $webData['WEB-TITLE'].' '.$pageArr['title']; ?></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-right">
            <li<?php if($pageArr['menu-focus'] == 'center'){echo ' class="active"';} ?>><a href="center.php">Center</a></li>
            <li<?php if($pageArr['menu-focus'] == 'user'){echo ' class="active"';} ?>><a href="center-user.php">User</a></li>
            <li<?php if($pageArr['menu-focus'] == 'operate'){echo ' class="active"';} ?>><a href="center-operate.php">Operate</a></li>
            <li><a href="action-logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </div>