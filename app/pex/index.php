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
        <div class="col-xs-2">查看类型 : </div>
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
            <button type="button" class="btn btn-default" id="operate-select-all" data-mode="normal">全选</button>
            <button type="button" class="btn btn-default" id="operate-select-reverse" data-mode="normal">反选</button>
            <button type="button" class="btn btn-default" id="operate-select-cancel" data-mode="normal">取消</button>
            <button type="button" class="btn btn-default" id="operate-rename" data-mode="normal">重命名</button>
            <button type="button" class="btn btn-default" id="operate-cut" data-mode="normal">剪切</button>
            <button type="button" class="btn btn-default" id="opreate-copy" data-mode="normal">复制</button>
            <button type="button" class="btn btn-default" id="operate-paste" data-mode="normal">粘贴</button>
            <button type="button" class="btn btn-default" id="operate-delete" data-mode="normal">删除</button>
            <button type="button" class="btn btn-default" id="opreate-revolve" data-mode="normal">旋转所选图片</button>
            <button type="button" class="btn btn-default" id="operate-merge" data-mode="normal">合并文件夹</button>
        </div>

    </div>
</div>

<div class="row" id="content-resource">
</div>

</div>
<?php require('footer.php'); ?>