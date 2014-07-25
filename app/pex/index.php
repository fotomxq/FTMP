<?php
/**
 * PEX首页
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-06-28 22:44:12
 * @version 1
 */
//引用全局
require('glob.php');

//引用PEX处理器
require('app-pex.php');

//创建对象
$pex = new AppPex($db, APP_PEX_DIR);

//引用头文件
require('header.php');
//引用菜单
require('menu.php');
?>
<div class="container">

    <div class="row content-type">
        <div class="col-xs-2">类型 : </div>
        <div class="col-xs-10" id="content-type"></div>
    </div>

    <div class="row content-tag">
        <div class="col-xs-2">标签 : </div>
        <div class="col-xs-10" id="content-tag"></div>
    </div>

    <div class="row content-operate">
        <div class="col-xs-2">操作 : </div>
        <div class="col-xs-10" id="content-operate">
            <button type="button" class="btn btn-default" id="operate-clear" data-mode="all">清空</button>
            <button type="button" class="btn btn-default" id="operate-search" data-mode="all">筛选</button>
            <button type="button" class="btn btn-default" id="operate-view-phone" data-mode="normal">手机模式</button>
            <button type="button" class="btn btn-default" id="operate-view-normal" data-mode="phone">普通模式</button>
            <button type="button" class="btn btn-default" id="operate-add-folder" data-mode="normal">建立文件夹</button>
            <button type="button" class="btn btn-default" id="operate-edit" data-mode="normal">编辑</button>
            <button type="button" class="btn btn-default" id="operate-select-all" data-mode="normal">全选</button>
            <button type="button" class="btn btn-default" id="operate-select-reverse" data-mode="normal">反选</button>
            <button type="button" class="btn btn-default" id="operate-select-cancel" data-mode="normal">取消</button>
            <button type="button" class="btn btn-default" id="operate-cut" data-mode="normal">剪切</button>
            <button type="button" class="btn btn-default" id="opreate-copy" data-mode="normal">复制</button>
            <button type="button" class="btn btn-default" id="operate-paste" data-mode="normal">粘贴</button>
            <button type="button" class="btn btn-default" id="operate-delete" data-mode="normal">删除</button>
            <button type="button" class="btn btn-default" id="opreate-revolve" data-mode="normal">旋转所选图片</button>
            <button type="button" class="btn btn-default" id="operate-merge" data-mode="normal">合并文件夹</button>
            <button type="button" class="btn btn-default" id="operate-same" data-mode="normal">查询重复文件</button>
        </div>

    </div>

    <hr>

    <div class="row">
        <div class="col-xs-12" id="content-resource">正在加载数据...</div>
    </div>
</div>

<!--查看文件 -->
<div class="modal fade" id="viewModal" data-key="0">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
                <h4 class="modal-title">查看文件</h4>
            </div>
            <div class="modal-body" id="viewContent"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="view-prev-button">上一个</button>
                <button type="button" class="btn btn-default" id="view-next-button">下一个</button>
                <button type="button" class="btn btn-primary" id="view-open-button">打开文件</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

<!--编辑文件 -->
<div class="modal fade" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
                <h4 class="modal-title">编辑文件</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">文件名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="edit-title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">描述</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="3" id="edit-content"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">类型</label>
                        <div class="col-sm-10" id="edit-type"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">标签</label>
                        <div class="col-sm-10" id="edit-tags"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">确认修改</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>

<!--删除文件 -->
<div class="modal fade" id="delModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
                <h4 class="modal-title">删除文件</h4>
            </div>
            <div class="modal-body">
                <p>请问您要删除这些文件吗？文件ID：</p>
                <p id="delStr"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="delButton">确定删除</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
            </div>
        </div>
    </div>
</div>

<!--发布文件 -->
<div class="modal fade" id="releaseModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
                <h4 class="modal-title">发布文件</h4>
            </div>
            <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">发布</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>

</div>
<?php require('footer.php'); ?>