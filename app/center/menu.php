<?php
/**
 * 中心页面头部
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-27 11:20:47
 * @version 1
 */
?>
<div class="masthead clearfix">
	<div class="inner">
		  <h3 class="masthead-brand"><?php echo $webData['WEB-TITLE']; ?> 中心</h3>
		  <ul class="nav masthead-nav">
			    <li class="active"><a href="../center/index.php" target="_self">首页</a></li>
			    <li><a href="#">个人用户</a></li>
			    <?php if($checkPowers['ADMIN'] === true){ ?><li><a href="#">系统设置</a></li><?php } ?>
		  </ul>
	</div>
</div>