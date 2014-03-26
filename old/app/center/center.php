<?php
/**
 * 中心首页
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package center
 */
//引用登录检测模块
require('logged.php');

//获取APP列表
$sql = 'SELECT `app_title`,`app_dir`,`app_des` FROM `center_app`;';
$appList = $db->prepareAttr($sql, null, 3);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require(DIR_LIB . DS . 'page' . DS . 'header-meta.php'); ?>
        <title>FTM Personal Center</title>
        <link href="<?php echo WEB_URL_ASSETS; ?>/app/center/css/center.css" rel="stylesheet">
        <?php require(DIR_LIB . DS . 'page' . DS . 'header-assets.php'); ?>
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="center.php">FTMP</a>
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
                <?php if($appList){ foreach($appList as $v){ ?>
                <div class="col-md-4">
                    <h2><?php echo $v['app_title']; ?></h2>
                    <p><?php echo $v['app_des']; ?></p>
                    <p><a class="btn btn-default" href="../<?php echo $v['app_dir']; ?>/index.php" role="button">启动 &raquo;</a></p>
                </div>
                <?php } } ?>
                <div class="col-md-4">
                    <h2>设置中心</h2>
                    <p>在这里修改全局设置、编辑用户和用户组、查看日志、查看IP记录、管理应用等内容。</p>
                    <p><a class="btn btn-default" href="#" role="button">设置 &raquo;</a></p>
                </div>
            </div>
        </div>
    </body>
</html>