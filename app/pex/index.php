<?php
/**
 * PEX首页
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-28 22:44:12
 * @version 1
 */

//引用全局
require('glob.php');

//临时内容：头部分、尾部、菜单为临时，之后需要改为模版形式。
//注意修改标题部分，为全局定义。
require('header.php');
require('menu.php');
?>
<div class="pex-content">
    <div class="row row-first"></div>
    <div class="row">
        <a href="#"><span class="label label-default">标签A</span></a>
        <a href="#"><span class="label label-default">标签B</span></a>
        <a href="#"><span class="label label-info">标签C</span></a>
    </div>
    <hr>
    <div class="pex-content-list">
        <div class="row">
            <div class="col-lg-4">
                <a href="#">
                    <img src="assets/imgs/folder.png" alt="返回" style="width: 140px; height: 140px;">
                    <h4>返回上一级</h4>
                </a>
            </div>
            <div class="col-lg-4">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                <h4>文件X</h4>
            </div>
            <div class="col-lg-4">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                <h4>文件X</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                <h4>文件X</h4>
            </div>
            <div class="col-lg-4">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                <h4>文件X</h4>
            </div>
            <div class="col-lg-4">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                <h4>文件X</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                <h4>文件X</h4>
            </div>
            <div class="col-lg-4">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                <h4>文件X</h4>
            </div>
            <div class="col-lg-4">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                <h4>文件X</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                <h4>文件X</h4>
            </div>
            <div class="col-lg-4">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                <h4>文件X</h4>
            </div>
            <div class="col-lg-4">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                <h4>文件X</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                <h4>文件X</h4>
            </div>
            <div class="col-lg-4">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                <h4>文件X</h4>
            </div>
            <div class="col-lg-4">
                <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                <h4>文件X</h4>
            </div>
        </div>
    </div>
</div>
<?php require('footer.php'); ?>