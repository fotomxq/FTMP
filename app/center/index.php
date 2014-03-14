<?php
/**
 * 登录首页
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package center
 * @todo 加入验证码
 * @todo 输入次数过多自动锁定
 */
require('glob.php');

//如果已经登录，跳转到中心首页
$centerLoginSession = $session->get(VAR_CENTER_LOGIN_NAME);
if ($centerLoginSession == true) {
    CoreHeader::toURL(WEB_URL . 'app/center/center.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require(DIR_LIB . DS . 'page' . DS . 'header-meta.php'); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>FTM Personal Login</title>
        <link href="<?php echo WEB_URL_ASSETS; ?>/app/center/css/index.css" rel="stylesheet">
        <?php require(DIR_LIB . DS . 'page' . DS . 'header-assets.php'); ?>
    </head>
    <body>
        <div class="container">
            <form class="form-signin" role="form" action="login.php" method="post">
                <h2 class="form-signin-heading">登录FTMP，享受生活</h2>
                <input type="email" name="username" class="form-control" placeholder="用户名" required autofocus>
                <input type="password" name="password" class="form-control" placeholder="密码" required>
                <label class="checkbox">
                    <input type="checkbox" value="remember-me"> 记住我
                </label>
                <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
            </form>
        </div>
    </body>
</html>