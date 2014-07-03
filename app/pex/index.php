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
    <div class="row">
    </div>
    <div class="row">
        <div class="col-xs-10">
            <a href="#tag" value=""><span class="label label-default">标签A</span></a>
            <a href="#tag" value=""><span class="label label-info">标签C</span></a>
            <a href="#tag-clear"><span class="label label-warning">清空已选</span></a>
        </div>
        <div class="col-xs-2">
            <a href="#folder-return" class="btn btn-default">返回上级</a>
        </div>
    </div>
    <div class="pex-content-list">
        <div class="row">
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
            <div class="col-xs-3">
                <a href="#">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" style="width: 140px; height: 140px;">
                    <h4>文件X</h4>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- 发布资源框架 -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title" id="myModalLabel">发布新的资源</h4>
      </div>
      <div class="modal-body">
          <div class="row"><h4>等待转移</h4></div>
          <div class="row" id="transferList"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary">发布</button>
      </div>
    </div>
  </div>
</div>
<?php require('footer.php'); ?>