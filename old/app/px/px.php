<?php

/**
 * px首页
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package px
 */

//引用登录检测模块
require('logged.php');

?>
<!DOCTYPE html>
<html>
    <head>
        <?php require(DIR_LIB . DS . 'page' . DS . 'header-meta.php'); ?>
        <title>PX Tool</title>
        <link href="<?php echo WEB_URL_ASSETS; ?>/app/px/css/px.css" rel="stylesheet">
        <?php require(DIR_LIB . DS . 'page' . DS . 'header-assets.php'); ?>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="px.php">PX Tool</a>
                </div>
                <div class="navbar-collapse collapse">
                    <div class="navbar-form navbar-right">
                        <a href="logout.php" target="_self"  class="btn btn-warning" role="button">退出</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
            </div>
        </div>
    </body>
</html>