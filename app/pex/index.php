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
<div class="pex-content">
    <div class="row">
        <ol class="breadcrumb" id="dirSelect">
            <li class="active"><a href="#dir">照片</a></li>
        </ol>
    </div>
    <div class="row">
        <div class="col-xs-12" id="tagList">
            <a href="#tag-clear"><span class="label label-warning">清空已选</span></a>
        </div>
    </div>
    <div class="pex-content-list">
        <div class="row" id="resourceList"></div>
    </div>
</div>
<!-- 发布资源框架 -->
<div class="modal fade bs-example-modal-lg" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title" id="uploadModalLabel">发布新的资源</h4>
      </div>
        <div class="modal-body">
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-2 control-label">转移文件</label>
                    <div class="col-sm-10">
                        <p class="form-control-static" id="transferList">
                            <a href="#upload-file-tag-clear"><span class="label label-warning">清空已选</span></a>
                        </p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">标题</label>
                    <div class="col-sm-10">
                         <input type="text" class="form-control" id="transferTitle">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">类型</label>
                    <div class="col-sm-10">
                        <?php if($pex->pexType){ foreach($pex->pexType as $v){ ?>
                        <label class="radio-inline">
                            <input type="radio" name="transferTypeOptions" value="<?php echo $v['key']; ?>"> <?php echo $v['title']; ?>
                        </label>
                        <?php } } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">标签</label>
                    <div class="col-sm-10">
                        <p class="form-control-static" id="transferTag"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">模式</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="checkbox" name="transferModeDir" value="1"> 自动建立文件夹，否则发布到当前所属文件夹下
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">描述</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="transferContent" rows="3"></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" id="uploadOkButton" class="btn btn-primary">发布</button>
            <button type="button" id="uploadSelectAllButton" class="btn btn-info">全选文件</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!-- 设置界面 -->
<div class="modal fade" id="setModal" tabindex="-1" role="dialog" aria-labelledby="setModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title" id="setModalLabel">设置</h4>
      </div>
      <div class="modal-body">
            <form class="form-horizontal" role="form">
                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                        <p>注意，所有标签用“|”隔开。</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">照片标签</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="setTagPhoto" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">影片标签</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="setTagMovie" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">漫画标签</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="setTagCartoon" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">文本标签</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="setTagTxt" rows="3"></textarea>
                    </div>
                </div>
            </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="setSaveButton" class="btn btn-primary">保存</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!-- 打开文件界面 -->
<div class="modal fade bs-example-modal-lg" id="openFileModal" tabindex="-1" role="dialog" aria-labelledby="openFileModalLabel" aria-hidden="true" data-id="">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body" id="openFileView"></div>
      <div class="modal-footer">
        <button type="button" id="openFileEdit" class="btn btn-primary">修改</button>
        <button type="button" id="openFileDel" class="btn btn-danger">删除</button>
        <button type="button" id="openFilePrevButton" class="btn btn-info">前一个</button>
        <button type="button" id="openFileNextButton" class="btn btn-info">后一个</button>
        <button type="button" id="openFileButton" class="btn btn-primary">打开</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!-- 修改Fx -->
<div class="modal fade" id="editFileModal" tabindex="-1" role="dialog" aria-labelledby="editFileModalLabel" aria-hidden="true" data-id="">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title" id="editFileModalLabel">修改资源</h4>
      </div>
        <div class="modal-body">
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-sm-2 control-label">标题</label>
                    <div class="col-sm-10">
                         <input type="text" class="form-control" id="editTitle">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">类型</label>
                    <div class="col-sm-10">
                        <p class="form-control-static" id="editType"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">标签</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="editTag">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">描述</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="editContent" rows="3"></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" id="editButton" class="btn btn-primary">保存</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<!-- 删除资源 -->
<div class="modal fade" id="delFileModal" tabindex="-1" role="dialog" aria-labelledby="delFileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title" id="delFileModalLabel">删除资源</h4>
      </div>
      <div class="modal-body" id="delFileContent">确认删除这个资源吗？</div>
      <div class="modal-footer">
        <button type="button" id="delButton" class="btn btn-primary">确认删除</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<?php require('footer.php'); ?>