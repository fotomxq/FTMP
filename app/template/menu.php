<?php
/**
 * 通用模版-Munu
 * @author fotomxq <fotomxq.me>
 * @version 7
 * @package app-template
 */
if(isset($appPage) != true) die();
?>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">导航</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><img src="assets/imgs/favicon.png" class="logo"> <?php echo $appPage['title']; ?></a>
        </div>
        <div class="collapse navbar-collapse">
          <?php if(isset($appPage['menu-left']) == true){ ?>
          <ul class="nav navbar-nav">
            <?php foreach($appPage['menu-left'] as $v){ ?>
            <li<?php if($v['active']){ echo ' class="active"'; }?>><a href="<?php echo $v['url']; ?>"<?php if($v['target']){ echo ' target="'.$v['target'].'"'; }?>><?php echo $v['title']; ?></a></li>
            <?php } ?>
          </ul>
          <?php } ?>
            <ul class="nav navbar-nav navbar-right">
                <?php if(count($appList) > 1){ ?>
                <li><a href="../../center.php"><span class="glyphicon glyphicon-home"></span> 中心</a></li>
                <?php }else{ ?>
                <li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
                <li><a href="../../center-user.php"><span class="glyphicon glyphicon-user"></span> 用户</a></li>
                <li><a href="../../center-operate.php"><span class="glyphicon glyphicon-wrench"></span> 设置</a></li>
                <?php } ?>
                <li><a href="../../action-logout.php"><span class="glyphicon glyphicon-remove-sign"></span> 退出</a></li>
            </ul>
        </div>
      </div>
    </div>