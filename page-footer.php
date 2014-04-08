<?php
/**
 * 页面-脚部分
 * @author fotomxq <fotomxq.me>
 * @version 2
 * @package web
 */
if(!isset($pageArr)) die();
?>
    <div id="footer">
      <div class="container">
        <p class="text-muted"><?php echo $webData['WEB-TITLE']; ?> &copy; 2014</p>
      </div>
    </div>
    <script src="includes/assets/js/jquery.js"></script>
    <script src="includes/assets/js/bootstrap.js"></script>
    <?php if(isset($pageArr['js']) == true){ foreach($pageArr['js'] as $v){ ?>
    <script href="includes/assets/js/<?php echo $v; ?>.js"></script>
    <?php } } ?>
  </body>
</html>