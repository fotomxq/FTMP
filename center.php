<?php
/**
 * 中心页面
 * @author fotomxq <fotomxq.me>
 * @version 5
 * @package web
 */

//引用登录检测模块
require('action-logged.php');

//页面设定
$pageArr['title'] = 'Center';
$pageArr['menu-focus'] = 'center';

//引用头和目录页面
require('page-header.php');
require('page-menu.php');
?>
<div class="container">
  <div class="row center-row-fixed">
  	<?php foreach($appList as $k=>$v){ ?>
    <div class="col-md-4">
      <img src="app/<?php echo $k; ?>/assets/imgs/favicon.png" alt="<?php echo $v['name']; ?>">
      <h2><?php echo $v['name']; ?></h2>
      <p><?php echo $v['des']; ?></p>
      <p><a class="btn btn-default" href="app/<?php echo $k; ?>/index.php" role="button">进入 &raquo;</a></p>
    </div>
    <?php } ?>
  </div>
</div>
<?php require('page-footer.php'); ?>
