<?php
/**
 * 首页
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package page
 */
//引用全局页面设定
require('page.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require('page-header.php'); ?>
    </head>
    <body>
        <div class="container">
            <div class="row">&nbsp;</div>
            <div class="row">
                <div class="col-lg-10">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-8">
                        <div class="panel panel-primary">
                            <div class="panel-heading"><?php echo $webTitle; ?></div>
                            <form class="form-horizontal" action="action-login.php" method="post">
                                <div class="form-group">
                                    <label for="inputUser" class="col-lg-2 control-label">用户名</label>
                                    <div class="col-lg-10">
                                        <input type="text" class="form-control" name="username" id="inputUser" placeholder="用户名" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword" class="col-lg-2 control-label">密码</label>
                                    <div class="col-lg-10">
                                        <input type="password" class="form-control" name="password" id="inputPassword" placeholder="密码">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputVCode" class="col-lg-2 control-label">验证码</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" name="vcode" id="inputVCode" placeholder="验证码" autocomplete="off">
                                    </div>
                                    <div class="col-lg-5"><img src="vcode.php" /></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2">&nbsp;</label>
                                    <div class="col-lg-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"> 记住我
                                            </label>
                                        </div>
                                        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-lock"></i>&nbsp;登陆</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require('page-footer.php'); ?>
    </body>
</html>