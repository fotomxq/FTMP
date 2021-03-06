<?php
/**
 * 中心页面
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-06-26 17:47:04
 * @version 10
 */
//引用全局
require('glob.php');

//设定页面引用
$pageIncludes['app'] = array(
    'css' => array('index.css'),
    'js' => array('index.js')
);

//设定页面参数
$appPages = array('title' => '中心', 'key' => 'CENTER-INDEX');

//获取用户所有可用应用
$checkApps = $user->checkApp($userID, $apps);

//隐藏PEX跳转处理
$pexConfigPasswd = $config->get(14);
if (isset($_GET['pex']) == true) {
    $pexPasswdSha1 = sha1($_GET['pex']);
    if ($pexPasswdSha1 == $pexConfigPasswd) {
        CoreHeader::toURL('../pex/index.php');
    }
}

//引用头模版
require(DIR_APP_TEMPALTE . DS . 'header.php');
?>
<div class="site-wrapper">
    <div class="site-wrapper-inner">
        <div class="cover-container">
            <?php require('menu.php'); ?>
            <div class="inner cover center-content" id="center-content">
                <div class="row">
                    <div class="col-lg-4">
                        <a href="#" target="_self"><img class="img-circle" src="../health/assets/imgs/favicon.png" alt="Generic placeholder image" style="width: 100px; height: 100px;"></a>
                        <h2>健康</h2>
                        <p>活着比什么都重要</p>
                    </div>
                    <div class="col-lg-4">
                        <a href="#" target="_self"><img class="img-circle" src="../resources/assets/imgs/favicon.png" alt="Generic placeholder image" style="width: 100px; height: 100px;"></a>
                        <h2>资源</h2>
                        <p>整整齐齐多省心</p>
                    </div>
                    <div class="col-lg-4">
                        <a href="#" target="_self"><img class="img-circle" src="../finance/assets/imgs/favicon.png" alt="Generic placeholder image" style="width: 100px; height: 100px;"></a>
                        <h2>财务</h2>
                        <p>票子都去哪里了</p>
                    </div>
                </div>
                <div class="row row-fix">
                    <div class="col-lg-4">
                        <a href="#" target="_self"><img class="img-circle" src="../home/assets/imgs/favicon.png" alt="Generic placeholder image" style="width: 100px; height: 100px;"></a>
                        <h2>家庭</h2>
                        <p>快看那是我小时候</p>
                    </div>
                    <div class="col-lg-4">
                        <a href="#" target="_self"><img class="img-circle" src="../interpersonal/assets/imgs/favicon.png" alt="Generic placeholder image" style="width: 100px; height: 100px;"></a>
                        <h2>人际</h2>
                        <p>人脉是成功的源泉</p>
                    </div>
                    <div class="col-lg-4">
                        <a href="#" target="_self"><img class="img-circle" src="../log/assets/imgs/favicon.png" alt="Generic placeholder image" style="width: 100px; height: 100px;"></a>
                        <h2>日志</h2>
                        <p>用小本本记住你</p>
                    </div>
                </div>
                <div class="row row-fix">
                    <?php if ($checkApps['pex']) { ?>
                        <div class="col-lg-4">
                            <a href="../pex/index.php" target="_self"><img class="img-circle" src="../pex/assets/imgs/favicon.png" alt="Generic placeholder image" style="width: 100px; height: 100px;"></a>
                            <h2>PEX</h2>
                            <p>你懂得！</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php require('footer.php'); ?>
        </div>
    </div>
</div>
<!-- 用户设定 -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
                <h4 class="modal-title" id="userModalLabel">用户设定</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户昵称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="user-name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">新的密码</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="user-passwd">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">当前权限</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="user-powers"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">当前应用</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="user-apps"></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a type="button" href="logout.php" class="btn btn-danger">退出登录</a>
                <button type="button" id="user-save-button" class="btn btn-primary">保存</button>
            </div>
        </div>
    </div>
</div>
<!-- 系统设定 -->
<div class="modal fade" id="systemModal" tabindex="-1" role="dialog" aria-labelledby="systemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
                <h4 class="modal-title" id="systemModalLabel">系统设定</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户超时时间(秒)</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="system-user-limit-time">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">IP白名单</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="3" id="system-ip-white-list"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">系统状态</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="system-maint"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">磁盘空间</label>
                        <div class="col-sm-10">
                            <p class="form-control-static" id="disk-info"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">还原数据</label>
                        <div class="col-sm-8">
                            <p class="form-control-static" id="system-database-return"></p>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" id="system-backup-return-button" class="btn btn-danger">还原</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="btn-group">
                    <button type="button" class="btn btn-info">管理</button>
                    <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li> <a href="ip.php" target="_self">IP管理</a></li>
                        <li><a href="log.php" target="_self">日志查看</a></li>
                        <li><a href="user.php" target="_self">用户管理</a></li>
                    </ul>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-warning">维护</button>
                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li><a id="system-clear-cache" href="#">清除缓冲</a></li>
                        <li><a id="system-maint-button" href="#">切换维护模式</a></li>
                        <li class="divider"></li>
                        <li><a id="system-backup-button" href="#">备份站点</a></li>
                        <li><a id="system-backup-only-sql-button" href="#">备份数据库</a></li>
                        <li><a id="system-backup-only-file-button" href="#">备份文件数据</a></li>
                    </ul>
                </div>
                <button type="button" id="system-save-button" class="btn btn-primary">保存</button>
            </div>
        </div>
    </div>
</div>
<?php
//引用尾部模版
require(DIR_APP_TEMPALTE . DS . 'footer.php');
?>