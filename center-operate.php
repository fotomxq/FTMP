<?php
/**
 * 平台管理中心
 * @author fotomxq <fotomxq.me>
 * @version 4
 * @package web
 * @todo 添加开关JS设定
 * @todo 添加验证码开关设定
 * @todo 完成统计部分
 */
//引用登录检测模块
require('action-logged.php');

//判断用户是否具备权限
if ($userPowers[$user->powerValues[1]] == false)
    die('No Power.');

//页面设定
$pageArr['title'] = '系统';
$pageArr['menu-focus'] = 'operate';
$pageArr['menu-left'] = array(
    array('url' => '#urlAll', 'title' => '<span class="glyphicon glyphicon-globe"></span> 全局','active'=>true),
    array('url' => '#urlUser', 'title' => '<span class="glyphicon glyphicon-user"></span> 用户'),
    array('url' => '#urlStat', 'title' => '<span class="glyphicon glyphicon-stats"></span> 统计')
);
$pageArr['js'] = array('icheck', 'center-operate','menu','messenger','icheck');
$pageArr['css'] = array('messenger','messenger-theme-future','icheck-skins-flat');
$pageArr['menu-content-hide'] = true;
$pageArr['menu-content'] = array(array('#urlAll','#contentAll'),array('#urlUser','#contentUser'),array('#urlStat','#contentStat'));

//引用头和目录页面
require('page-header.php');
require('page-menu.php');
?>
<div class="container container-fixed">
    <div id="contentAll">
        <h2 id="urlAll"><span class="glyphicon glyphicon-globe"></span> 全局</h2><hr/>
        <div class="row row-fixed"><div class="col-sm-2"></div><div class="col-sm-10"> <p>部分设置需要在config.php文件内修改.</p></div></div>
        <div class="row row-fixed">
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="inputConfigWebTitle" class="col-sm-2 control-label">平台名称</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="configWebTitle" id="inputConfigWebTitle" placeholder="名称" value="<?php echo $config->get('WEB-TITLE'); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="inputConfigUserLimitTime">用户登录超时时间</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="inputUserLimitTime" id="inputConfigUserLimitTime" placeholder="秒" value="<?php echo $config->get('USER-LIMIT-TIME'); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">可用应用</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?php foreach($appList as $k=>$v){ echo $k.' - '.$v['name'].' | '; } ?></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">用户所有权限</label>
                    <div class="col-sm-10">
                        <p class="form-control-static"><?php echo implode(' | ',$user->powerValues); ?></p>
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
    <div id="contentUser" data-power-meta-name="<?php echo $user->powerMetaName; ?>" data-app-meta-name="<?php echo $user->appMetaName; ?>">
        <h2 id="urlUser"><span class="glyphicon glyphicon-user"></span> 用户</h2><hr/>
        <div class="row row-fixed">
            <div class="col-lg-9"></div>
            <div class="col-lg-3">
                <div class="input-group">
                    <input type="text" class="form-control" id="userListSearch">
                    <span class="input-group-btn"><a href="#userListSearch" class="btn btn-default"><span class="glyphicon glyphicon-user"></span> 搜索</a></span>
                </div>
            </div>
        </div>
        <div class="row row-fixed">
            <div class="col-lg-12">
                <table class="table table-bordered" id="userList" user-id="<?php echo $userID; ?>">
                    <thead>
                        <tr>
                            <td><span class="glyphicon glyphicon-th-list"></span> ID</td>
                            <td><span class="glyphicon glyphicon-user"></span> 用户名</td>
                            <td><span class="glyphicon glyphicon-user"></span> 昵称</td>
                            <td><span class="glyphicon glyphicon-calendar"></span> 创建时间</td>
                            <td><span class="glyphicon glyphicon-user"></span> 登录IP</td>
                            <td><span class="glyphicon glyphicon-cog"></span> 操作</td>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div class="row row-fixed">
            <div class="col-lg-12">
                <a href="#userAdd" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> 添加用户</a>
                <a href="#userListDelAction" class="btn btn-warning disabled"><span class="glyphicon glyphicon-trash"></span> 批量删除</a>
                <div class="btn-group"><button type="button" class="btn btn-default" id="userPageIndex">首页</button><button type="button" class="btn btn-default" id="userPagePrev">上一页</button><button type="button" class="btn btn-default" disabled="disabled" id="#userPageCount">1/1</button><button type="button" class="btn btn-default" id="userPageNext">下一页</button><button type="button" class="btn btn-default" id="userPageEnd">末页</button></div> 
            </div>
        </div>
    </div>
    <div id="contentStat">
        <h2 id="urlStat"><span class="glyphicon glyphicon-stats"></span> 统计</h2><hr/>
        <div class="row row-fixed">
        </div>
    </div>
</div>
<!-- modal-user-view -->
<div class="modal fade" id="modalUserView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">查看用户信息</h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
</div>
<!-- modal-user-add -->
<div class="modal fade" id="modalUserAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">添加用户</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form">
            <div class="form-group">
                <label for="inputModalAddUserNicename" class="col-sm-2 control-label">昵称</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputModalAddUserNicename" placeholder="昵称">
                </div>
            </div>
            <div class="form-group">
                <label for="inputModalAddUserLogin" class="col-sm-2 control-label">用户名</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputModalAddUserLogin" placeholder="用户名">
                </div>
            </div>
            <div class="form-group">
                <label for="inputModalAddUserPasswd" class="col-sm-2 control-label">密码</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputModalAddUserPasswd" placeholder="密码">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">权限</label>
                <div class="col-sm-10">
                    <div class="form-control-static">
                        <?php foreach($user->powerValues as $v){ ?>
                        <label>
                          <input type="checkbox" name="modalAddPowers[]" data-value="<?php echo $v; ?>"> <?php echo $v; ?>
                        </label>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">应用</label>
                <div class="col-sm-10">
                    <div class="form-control-static">
                        <?php foreach($appList as $k=>$v){ ?>
                        <label>
                          <input type="checkbox" name="modalAddApps[]" data-value="<?php echo $k; ?>"> <?php echo $v['name']; ?>
                        </label>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="modalUserAddAction">添加用户</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!-- modal-user-edit -->
<div class="modal fade" id="modalUserEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">编辑用户</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form">
            <div class="form-group">
                <label for="inputModalEditUserNicename" class="col-sm-2 control-label">昵称</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputModalEditUserNicename" placeholder="昵称" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="inputModalEditUserLogin" class="col-sm-2 control-label">用户名</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputModalEditUserLogin" placeholder="用户名" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="inputModalEditUserPasswd" class="col-sm-2 control-label">密码</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputModalEditUserPasswd" placeholder="密码，留空则不修改" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">权限</label>
                <div class="col-sm-10">
                    <div class="form-control-static">
                        <?php foreach($user->powerValues as $v){ ?>
                        <label>
                          <input type="checkbox" name="modalEditPowers[]" data-value="<?php echo $v; ?>"> <?php echo $v; ?>
                        </label>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">应用</label>
                <div class="col-sm-10">
                    <div class="form-control-static">
                        <?php foreach($appList as $k=>$v){ ?>
                        <label>
                          <input type="checkbox" name="modalEditApps[]" data-value="<?php echo $k; ?>"> <?php echo $v['name']; ?>
                        </label>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="modalUserEditAction">修改</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!-- modal-user-del -->
<div class="modal fade" id="modalUserDel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">删除用户</h4>
      </div>
      <div class="modal-body">
        您确定要删除该用户吗？
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" id="modalUserDelAction">删除</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<?php require('page-footer.php'); ?>
