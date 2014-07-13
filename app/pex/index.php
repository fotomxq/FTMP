<?php
/**
 * PEX首页
 * @authors fotomxq <fotomxq.me>
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
?>
<div class="blog-masthead">
    <div class="container">
        <nav class="blog-nav">
            <a class="blog-nav-item active" href="index.php">首页</a>
            <a class="blog-nav-item" href="#">类型</a>
            <a class="blog-nav-item" href="#">操作</a>
            <a class="blog-nav-item" href="#">设置</a>
            <a class="blog-nav-item" href="../center/index.php">中心</a>
            <a class="blog-nav-item" href="../center/logout.php">退出</a>
        </nav>
    </div>
</div>

<div class="container">

    <div class="row content-type">
        <div class="col-xs-2">查看类型 : </div>
        <div class="col-xs-10" id="content-type"></div>
    </div>

    <div class="row content-tag">
        <div class="col-xs-2">标签 : </div>
        <div class="col-xs-10" id="content-tag"></div>
    </div>

    <div class="row content-resource">
    </div>

</div>
<?php require('footer.php'); ?>