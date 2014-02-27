<?php
/**
 * PX工具首页
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package px
 */
//引用全局
require('glob.php');
//初始化或清理登录状态
$session->clear($pxSessionVarName);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require(DIR_LIB . DS . 'page' . DS . 'header-meta.php'); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PX Login</title>
        <link href="<?php echo WEB_URL_ASSETS; ?>/px/css/index.css" rel="stylesheet">
        <?php require(DIR_LIB . DS . 'page' . DS . 'header-assets.php'); ?>
    </head>
    <body>
        <div class="container">
            <form class="form-signin" role="form" action="login.php" method="post">
                <h2 class="form-signin-heading">登录PX</h2>
                <input type="password" name="password" class="form-control" placeholder="密码" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
            </form>
        </div>
    </body>
</html>