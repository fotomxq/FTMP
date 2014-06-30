<?php
/**
 * PEX首页
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-28 22:44:12
 * @version 1
 */

//引用全局
require('glob.php');
require('header.php');
?>
<div class="pex-content">
    <div class="row pex-tag">
        <a href="#"><span class="label label-default">标签A</span></a>
        <a href="#"><span class="label label-default">标签B</span></a>
        <a href="#"><span class="label label-info">标签C</span></a>
    </div>
    <div class="pex-content-list">
        <div class="row">
            <div class="col-xs-3">
                <a href="#">
                    <img src="assets/imgs/folder.png" alt="返回" style="width: 140px; height: 140px;">
                    <h4>返回上一级</h4>
                </a>
            </div>
            <div class="col-xs-3">
                <a href="#">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                    <h4>文件X</h4>
                </a>
            </div>
            <div class="col-xs-3">
                <a href="#">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                    <h4>文件X</h4>
                </a>
            </div>
            <div class="col-xs-3">
                <a href="#">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                    <h4>文件X</h4>
                </a>
            </div>
        </div>
    </div>
</div>
<?php require('footer.php'); ?>