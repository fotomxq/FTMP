<?php
/**
 * 平台管理中心
 * @author fotomxq <fotomxq.me>
 * @version 2
 * @package web
 */
//引用登录检测模块
require('action-logged.php');

//判断用户是否具备权限
if($userPowers[$user->powerValues[1]] == false) die('No Power.');

//页面设定
$pageArr['title'] = '系统设置';
$pageArr['menu-focus'] = 'operate';
$pageArr['menu-left'] = array(array('url'=>'#urlAll','title'=>'全局'));
$pageArr['js'] = array('icheck','center-operate');

//引用头和目录页面
require('page-header.php');
require('page-menu.php');
?>
<div class="container">
    <h2 id="urlAll">全局</h2>
    <div class="row"><div class="col-sm-2"></div><div class="col-sm-10"> <p>部分设置需要在config.php文件内修改.</p></div></div>
    <div class="row">
        <form class="form-horizontal" role="form">
            <div class="form-group">
                <label for="inputConfigWebTitle" class="col-sm-2 control-label">平台名称</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputConfigWebTitle" placeholder="名称" value="<?php echo $config->get('WEB-TITLE'); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="inputConfigUserLimitTime">用户登录超时时间</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputConfigUserLimitTime" placeholder="秒" value="<?php echo $config->get('USER-LIMIT-TIME'); ?>">
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
    <h2 id="urlUserList">用户管理</h2>
    <div class="row">
    </div>
    <h2 id="urlUser">用户</h2>
    <div class="row">
    </div>
</div>  
<?php require('page-footer.php'); ?>
