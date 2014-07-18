<?php
/**
 * 用户管理页面
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-07-18 08:15:09
 * @version 1
 */
//引用全局
require('glob.php');

//设定页面引用
$pageIncludes['app'] = array(
    'css' => array('index.css', 'user.css'),
    'js' => array('user.js')
);
$pageIncludes['template'] = array(
    'js' => array('message.js', 'ajax.js')
);

//设定页面参数
$appPages = array('title' => '用户管理', 'key' => 'CENTER-USER');

//引用头模版
require(DIR_APP_TEMPALTE . DS . 'header.php');
?>
<div class="site-wrapper">
    <div class="site-wrapper-inner">
        <div class="cover-container">
            <div class="masthead clearfix">
                <div class="inner">
                    <h3 class="masthead-brand"><?php echo $appPages['title']; ?></h3>
                    <ul class="nav masthead-nav"> 
                        <li class="active">
                            <a href="index.php" target="_self">首页</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="inner cover center-content" id="user-content" data-powers="" data-apps="">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th data-key="1">#</th>
                            <th data-key="2">用户名</th>
                            <th data-key="3">创建日期</th>
                            <th data-key="4">访问IP</th>
                            <th>权限</th>
                            <th>应用</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody id="user-list">
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <a href="#user-edit-modal" class="btn btn-info">编辑</a>
                                <a href="#user-del-modal" class="btn btn-danger">删除</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <ul class="pager">
                    <li><a href="#page-index">首页</a></li>
                    <li><a href="#page-prev">上一页</a></li>
                    <li id="page-show"></li>
                    <li><a href="#page-next">下一页</a></li>
                    <li><a href="#page-end">末页</a></li>
                </ul>
            </div>
            <?php require('footer.php'); ?>
        </div>
    </div>
</div>
<!-- 创建用户 -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
                <h4 class="modal-title" id="addModalLabel">创建用户</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">登录名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="add-login-name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户昵称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="add-nice-name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="add-passwd">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="add-passwd-2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">可选权限</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="add-powers-ready"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">当前权限</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="add-powers-select"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">可选应用</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="add-apps-ready"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">当前应用</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="add-apps-select"></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="add-button" class="btn btn-primary">创建</button>
            </div>
        </div>
    </div>
</div>
<!-- 修改用户 -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
                <h4 class="modal-title" id="editModalLabel">修改用户</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">登录名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="edit-login-name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户昵称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="edit-nice-name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">新的密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="edit-passwd">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">可选权限</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="edit-powers-ready"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">当前权限</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="edit-powers-select"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">可选应用</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="edit-apps-ready"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">当前应用</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="edit-apps-select"></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="edit-button" class="btn btn-primary">保存</button>
            </div>
        </div>
    </div>
</div>
<!-- 删除用户 -->
<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="delModalLabel" aria-hidden="true" data-id="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
                <h4 class="modal-title" id="delModalLabel">删除用户</h4>
            </div>
            <div class="modal-body">
                <p>您确定要删除<span class="label label-warning">username</span>用户吗？</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="del-button" class="btn btn-danger">删除</button>
            </div>
        </div>
    </div>
</div>
<?php
//引用尾部模版
require(DIR_APP_TEMPALTE . DS . 'footer.php');
?>