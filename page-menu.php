<?php
/**
 * 页面-菜单部分
 * @author fotomxq <fotomxq.me>
 * @version 5
 * @package web
 */
if(!isset($pageArr)) die();
?>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">导航栏</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><img src="includes/assets/imgs/favicon.png" class="logo"> <?php echo $webData['WEB-TITLE'].' '.$pageArr['title']; ?></a>
        </div>
        <div class="collapse navbar-collapse">
            <?php if(isset($pageArr['menu-left']) == true){ ?>
          <ul class="nav navbar-nav">
            <?php foreach($pageArr['menu-left'] as $v){ ?>
            <li<?php if($v['active']){ echo ' class="active"'; }?>><a href="<?php echo $v['url']; ?>"<?php if($v['target']){ echo ' target="'.$v['target'].'"'; }?>><?php echo $v['title']; ?></a></li>
            <?php } ?>
          </ul>
          <?php } ?>
          <ul class="nav navbar-nav navbar-right">
            <li<?php if($pageArr['menu-focus'] == 'center'){echo ' class="active"';} ?>><a href="center.php"><span class="glyphicon glyphicon-home"></span> 中心</a></li>
            <li<?php if($pageArr['menu-focus'] == 'user'){echo ' class="active"';} ?>><a href="center-user.php"><span class="glyphicon glyphicon-user"></span> 用户</a></li>
            <?php if($userPowers[$user->powerValues[1]] == true){ ?>
            <li<?php if($pageArr['menu-focus'] == 'operate'){echo ' class="active"';} ?>><a href="center-operate.php"><span class="glyphicon glyphicon-wrench"></span> 设置</a></li>
            <?php } ?>
            <li><a href="action-logout.php"><span class="glyphicon glyphicon-remove-sign"></span> 退出</a></li>
          </ul>
        </div>
      </div>
    </div>