<?php
/**
 * 用户个人信息修改页面
 * @author fotomxq <fotomxq.me>
 * @version 2
 * @package web
 */
//引用登录检测模块
require('action-logged.php');

//页面设定
$pageArr['title'] = '用户设置 - '.$userInfos['user_nicename'];
$pageArr['menu-focus'] = 'user';

//引用头和目录页面
require('page-header.php');
require('page-menu.php');
?>
<div class="container">
    <h2>个人信息</h2>
    <div class="row">
        <form class="form-horizontal col-lg-9" role="form" action="action-user.php" method="post">
            <div class="form-group">
                <label for="inputNicename" class="col-sm-2 control-label">昵称</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="nicename" id="inputNicename" placeholder="昵称" value="<?php echo $userInfos['user_nicename']; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="col-sm-2 control-label">密码</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" name="passwd" id="inputPassword" placeholder="留空则不修改">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">用户创建时间</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?php echo $userInfos['user_date']; ?></p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">登录IP地址</label>
                <div class="col-sm-10">
                    <p class="form-control-static"><?php echo $userInfos['user_ip']; ?></p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok"></span> 修改</button>
                    <button type="reset" class="btn btn-default"><span class="glyphicon glyphicon-repeat"></span> 重置</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php require('page-footer.php'); ?>