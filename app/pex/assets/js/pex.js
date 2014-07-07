//通用服务器交互
function actionServer(type, data, func) {
    $.post('action.php?action=' + type, data, func, 'json');
}
//发送消息
function sendMsg(type, message) {
    if (resource.mode != 'phone') {
        Messenger().post({
            message: message,
            type: type
        });
    }
}

//发布新文件类
var upload = new Object;
//转移文件列数据
upload.transferFileList;
//页码和页长
upload.transferPage = 1;
upload.transferMax = 999;
//初始化
upload.start = function() {
    //刷新等待转移文件列
    upload.transferList();
    //选择类型事件
    $('input[name="transferTypeOptions"]').on('ifChecked', function() {
        $('#transferTag').html('');
        if (tag.data[$(this).val()]) {
            var vTag = tag.data[$(this).val()];
            for (var i = 0; i < vTag.length; i++) {
                $('#transferTag').prepend('<a href="#uploadTag" value="' + vTag[i]['id'] + '" select="false"><span class="label label-default">' + vTag[i]['tag_name'] + '</span></a>');
            }
        }
        $('a[href="#uploadTag"]').click(function() {
            if ($(this).attr('select') === 'true') {
                $(this).attr('select', 'false');
                $(this).children('span').removeClass('label-info');
                $(this).children('span').addClass('label-default');
            } else {
                $(this).attr('select', 'true');
                $(this).children('span').removeClass('label-default');
                $(this).children('span').addClass('label-info');
            }
        });
    });
    //如果激活发布框架
    $('#uploadModal').on('show.bs.modal', function() {
        upload.transferFileModal();
    });
    //清空文件选择事件
    $('a[href="#upload-file-tag-clear"]').click(function() {
        $('a[href="#uploadFileTag"]').attr('select', 'false');
        $('a[href="#uploadFileTag"] > span').removeClass('label-info');
        $('a[href="#uploadFileTag"] > span').addClass('label-default');
    });
    //全选文件
    $('#uploadSelectAllButton').click(function() {
        $('a[href="#uploadFileTag"]').attr('select', 'true');
        $('a[href="#uploadFileTag"] > span').removeClass('label-default');
        $('a[href="#uploadFileTag"] > span').addClass('label-info');
    });
    //发布按钮
    $('#uploadOkButton').click(function() {
        upload.transferFile();
    });
    //框体关闭自动获取最新文件列
    $('#uploadModal').on('hide.bs.modal', function() {
        upload.transferList();
    });
}
//刷新显示的部分
upload.transferList = function() {
    actionServer('transfer-list', {
        'page': upload.transferPage,
        'max': upload.transferMax
    }, function(data) {
        upload.transferFileList = data;
    });
}
//发布转移文件
upload.transferFile = function() {
    var title = $('#transferTitle').val();
    var content = $('#transferContent').val();
    var tags = new Array();
    var files = new Array();
    var parent = resource.dir;
    var modeDir = false;
    if ($('a[href="#uploadFileTag"][select="true"]')) {
        $('a[href="#uploadFileTag"][select="true"]').each(function(k, v) {
            files.push(upload.transferFileList[$(this).attr('value')]);
        });
    }
    if ($('a[href="#uploadTag"][select="true"]')) {
        $('a[href="#uploadTag"][select="true"]').each(function(k, v) {
            tags.push($(this).attr('value'));
        });
    }
    if ($('input[name="transferModeDir"]:checked')) {
        modeDir = true;
    }
    actionServer('transfer-add', {
        'title': title,
        'content': content,
        'tags': tags,
        'files': files,
        'parent': parent,
        'mode-dir': modeDir,
        'mode-type': $('input[name="transferTypeOptions"]:checked').val()
    }, function(data) {
        if (data == true) {
            sendMsg('success', '发布成功!');
            $('#transferTitle').val('');
            $('#transferContent').val('');
            $('#uploadModal').modal('hide');
            resource.clear();
        }
        upload.transferList();
    });
}
//激活框体事件
upload.transferFileModal = function() {
    $('input[name="transferTypeOptions"]:eq(0)').iCheck('check');
    $('#transferList').html('');
    if (upload.transferFileList) {
        for (var i = 0; i < upload.transferFileList.length; i++) {
            $('#transferList').prepend('<a href="#uploadFileTag" value="' + i + '" select="false"><span class="label label-default">' + upload.transferFileList[i] + '</span></a>');
        }
        $('a[href="#uploadFileTag"]').click(function() {
            if ($(this).attr('select') === 'true') {
                $(this).attr('select', 'false');
                $(this).children('span').removeClass('label-info');
                $(this).children('span').addClass('label-default');
            } else {
                $(this).attr('select', 'true');
                $(this).children('span').removeClass('label-default');
                $(this).children('span').addClass('label-info');
            }
        });
    }
}

//资源处理器
var resource = new Object;
//当前所属类型
resource.type = 'photo';
//显示页数和页长
resource.page = 1;
resource.max = 10;
//排序方式
resource.sort = 0;
resource.desc = true;
//显示模式
resource.mode = 'operate';
//当前打开Id
resource.openId = 0;
//当前操作目录
resource.dir = 1;
//当前选择的资源
resource.selectArr = new Array();
//初始化
resource.start = function() {
    //打开文件事件
    $('#openFileButton').click(function(){
        window.open('file.php?id='+resource.openId);
    });
    //进入操作模式
    $('a[href="#mode-operate"]').click(function() {
        resource.selectMode('operate');
        sendMsg('info','进入操作模式');
    });
    //进入预览模式
    $('a[href="#mode-view"]').click(function() {
        resource.selectMode('view');
        sendMsg('info','进入预览模式');
    });
    //进入手机模式
    $('a[href="#mode-phone"]').click(function() {
        resource.selectMode('phone');
        sendMsg('info','进入手机模式');
    });
    //编辑资源确认按钮
    $('#editButton').click(function(){
        var tags = new Array();
        actionServer('fx-edit', {
            'id': $('#editFileModal').attr('data-id'),
            'title':$('#editTitle').val(),
            'content':$('#editContent').val(),
            'tags':tags
        }, function(data) {
            if (data == true) {
                $('#editFileModal').modal('hide');
                resource.clear();
                sendMsg('success','修改资源成功!');
            }
        });
    });
    //删除资源按钮
    $('#delButton').click(function() {
        actionServer('fx-del', {
            'id': resource.selectArr
        }, function(data) {
            if (data == true) {
                $('#delFileModal').modal('hide');
                resource.clear();
                sendMsg('success','删除资源成功!');
            }
        });
    });
}
//刷新资源
resource.ref = function() {
    //从服务器获取数据并刷新
    actionServer('fx-list', {
        'page': resource.page,
        'max': resource.max,
        'parent': resource.dir,
        'tags': tag.selected,
        'sort': resource.sort,
        'desc': resource.desc
    }, function(data) {
        if (data) {
            for (var i = 0; i < data.length; i++) {
                var dataHtml = 'data-id="' + data[i]['id'] + '" data-type="' + data[i]['fx_type'] + '" data-title="' + data[i]['fx_title'] + '" data-select="false" data-content="' + data[i]['fx_content'] + '"';
                if (resource.mode == 'phone') {
                    $('#resourceList').append('<div class="col-xs-12"><a href="#resource" '+dataHtml+'><img src="img.php?id=' + data[i]['id'] + '" style="max-width: 300px; max-height: 300px;"></a></div>');
                } else if (resource.mode == 'view') {
                    $('#resourceList').append('<div class="col-xs-6"><a href="#resource" '+dataHtml+'><img src="img.php?id=' + data[i]['id'] + '" style="max-width: 400px; max-height: 400px;"></a></div>');
                } else {
                    $('#resourceList').append('<div class="col-xs-3"><a href="#resource" '+dataHtml+'><img src="img.php?id=' + data[i]['id'] + '" style="max-width: 140px; max-height: 140px;"><h4>' + data[i]['fx_title'] + '</h4></a></div>');
                }
            }
            resource.selectMode(resource.mode);
        }
    });
}
//切换显示模式
resource.selectMode = function(mode) {
    resource.mode = mode;
    $('a[href="#resource"]').unbind();
    if (resource.mode == 'operate') {
        $('a[href="#resource"]').bind('click', function() {
            if ($(this).attr('data-select') == 'true') {
                $(this).attr('data-select', 'false');
                $(this).parent('div').css('background-color', '');
            } else {
                $(this).attr('data-select', 'true');
                $(this).parent('div').css('background-color', 'rgb(216, 216, 216)');
            }
        });
        $('a[href="#resource"]').bind('dblclick', function() {
            if ($(this).attr('data-type') == 'folder') {
                resource.selectDir($(this).attr('data-id'));
            } else {
                resource.open($(this).attr('data-id'));
            }
        });
    } else {
        $('a[href="#resource"]').bind('click', function() {
            if ($(this).attr('data-type') == 'folder') {
                resource.selectDir($(this).attr('data-id'));
            } else {
                resource.open($(this).attr('data-id'));
            }
        });
    }
}
//查看资源
resource.open = function(id) {
    resource.openId = id;
    $('#openFileView').html('<img src="img.php?id='+resource.openId+'" style="max-width:800px;max-height:800px;">');
    $('#openFileModal').modal('show');
}
//进入下一页资源
resource.nextPage = function() {
    resource.page = resource.page+1;
    resource.ref();
}
//清空资源显示
resource.clear = function() {
    resource.page = 1;
    $('#resourceList').html('');
    resource.ref();
}
//切换资源
resource.selectType = function(type) {
    resource.type = type;
    tag.tagType = type;
    tag.ref();
    resource.selectDir(0);
}
//切换目录
resource.selectDir = function(dir) {
    //更新目录导航
    $('#dirSelect').html('');
    var appendTitle = '';
    switch (resource.type) {
        case 'photo':
            appendTitle = '照片';
            resource.dir = 1;
            break;
        case 'movie':
            appendTitle = '影片';
            resource.dir = 2;
            break;
        case 'cartoon':
            appendTitle = '漫画';
            resource.dir = 3;
            break;
        case 'txt':
            appendTitle = '文本';
            resource.dir = 4;
            break;
    }
    if (dir > 4) {
        resource.addDir(appendTitle, resource.dir, false);
        resource.dir = dir;
        resource.addDir($('a[href="#resource"][data-id="'+dir+'"]').attr('data-title'), resource.dir, true);
    } else {
        resource.addDir(appendTitle, resource.dir, true);
    }
    resource.clear();
}
//插入目录导航段
resource.addDir = function(title, value, active) {
    var activeHtml = '';
    if (active == true) {
        activeHtml = 'class="active"';
    }
    $('#dirSelect').append('<li ' + activeHtml + ' value="' + value + '"><a href="#dir">' + title + '</a></li>');
    $('a[href="#dir"]').unbind();
    $('a[href="#dir"]').bind('click',function(){
        resource.selectDir($(this).parent('li').attr('value'));
    });
}
//更新所选项
resource.selectUpdate = function() {
    resource.selectArr = new Array();
    if ($('a[href="#resource"][data-select="true"]')) {
        $('a[href="#resource"][data-select="true"]').each(function(k, v) {
            resource.selectArr.push($(this).attr('data-id'));
        });
    }
}
//编辑资源信息
resource.edit = function(id) {
    if ($('a[href="#resource"][data-id="' + id + '"]')) {
        actionServer('tx-list', {
            'id': id
        }, function(data) {
            $('#editTitle').val($('a[href="#resource"][data-id="' + id + '"]').attr('data-title'));
            if ($('a[href="#resource"][data-id="' + id + '"]').attr('data-type') == 'folder') {
                $('#editType').html('文件夹');
            } else {
                $('#editType').html('文件类型 : ' + $('a[href="#resource"][data-id="' + id + '"]').attr('data-type'));
            }
            if(data){
                var tagHtml = '';
                for (var i = 0; i < data.length; i++) {
                    tagHtml += data[i]['tag_name'];
                    if (i < data.length - 1) {
                        tagHtml += '|';
                    }
                }
                $('#editTag').val(tagHtml);
            }
            $('#editContent').val($('a[href="#resource"][data-id="' + id + '"]').attr('data-content'));
            $('#editFileModal').attr('data-id', id);
            $('#editFileModal').modal('show');
        });
    }
}
//删除资源
resource.del = function(id) {
    var html = '';
    for (var i = 0; i < resource.selectArr.length; i++) {
        html += resource.selectArr[i] + ',';
    }
    if (html) {
        $('#delFileContent').html('您确定要删除ID : ' + html + '文件吗？');
    }
    $('#delFileModal').modal('show');
}

//标签处理器
var tag = new Object;
//当前查看类别
tag.tagType = 'photo';
//所有标签
tag.data;
//当前选择列
tag.selected = new Array();
//初始化
tag.start = function() {
    //获取所有标签
    tag.getAll();
    //清除所有已选标签按钮事件
    $('a[href="#tag-clear"]').click(function() {
        tag.selectClear();
    });
}
//清空标签选择
tag.selectClear = function() {
    $('a[href="#tag"]').attr('select', 'false');
    $('a[href="#tag"] > span').removeClass('label-info');
    $('a[href="#tag"] > span').addClass('label-default');
    tag.select();
    resource.clear();
}
//刷新标签选择
tag.select = function() {
    tag.selected = new Array();
    if ($('a[href="#tag"][select="true"]')) {
        $('a[href="#tag"][select="true"]').each(function(k, v) {
            tag.selected.push($(this).attr('value'));
        });
    }
}
//查看类别下所有标签
tag.getAll = function() {
    actionServer('tag-list', {}, function(data) {
        tag.data = data;
        $('#setTagPhoto').val(tag.joinStr(data['photo']));
        $('#setTagMovie').val(tag.joinStr(data['movie']));
        $('#setTagCartoon').val(tag.joinStr(data['cartoon']));
        $('#setTagTxt').val(tag.joinStr(data['txt']));
        tag.ref();
        tag.selectClear();
    });
}
//修改标签
tag.set = function() {
    var tags = {
        'photo': $('#setTagPhoto').val(),
        'movie': $('#setTagMovie').val(),
        'cartoon': $('#setTagCartoon').val(),
        'txt': $('#setTagTxt').val()
    };
    actionServer('tag-set', {
        tags: tags
    }, function(data) {
        if (data == true) {
            sendMsg('success', '修改成功!');
        }
        tag.getAll();
    });
}
//合并标签为字符串
tag.joinStr = function(tags) {
    if (tags) {
        var res = '';
        for (var i = 0; i < tags.length; i++) {
            if (i < tags.length - 1) {
                res += tags[i]['tag_name'] + '|';
            } else {
                res += tags[i]['tag_name'];
            }
        }
        return res;
    }
    return '';
}
//刷新当前页面下的标签显示
tag.ref = function() {
    $('a[href="#tag"]').remove();
    if (tag.data[tag.tagType]) {
        for (var i = 0; i < tag.data[tag.tagType].length; i++) {
            $('#tagList').prepend('<a href="#tag" value="' + tag.data[tag.tagType][i]['id'] + '" select="false"><span class="label label-default">' + tag.data[tag.tagType][i]['tag_name'] + '</span></a>');
        }
    }
    $('a[href="#tag"]').click(function() {
        if ($(this).attr('select') === 'true') {
            $(this).attr('select', 'false');
            $(this).children('span').removeClass('label-info');
            $(this).children('span').addClass('label-default');
        } else {
            $(this).attr('select', 'true');
            $(this).children('span').removeClass('label-default');
            $(this).children('span').addClass('label-info');
        }
        tag.select();
        resource.clear();
    });
}
//和文件关联标签
tag.addTx = function() {

}
//取消关联
tag.delTx = function() {

}

//菜单栏
var menu = new Object;
//初始化菜单栏
menu.start = function() {
    //选择类型
    $('#menu li').click(function() {
        var href = $(this).children('a').attr('href');
        switch (href) {
            case '#folder-photo':
                resource.type = 'photo';
                $('#menu li').removeClass('active');
                $('#menu li:eq(1)').toggleClass('active');
                resource.selectType('photo');
                break;
            case '#folder-movie':
                resource.type = 'movie';
                $('#menu li').removeClass('active');
                $('#menu li:eq(2)').toggleClass('active');
                resource.selectType('movie');
                break;
            case '#folder-cartoon':
                resource.type = 'cartoon';
                $('#menu li').removeClass('active');
                $('#menu li:eq(3)').toggleClass('active');
                resource.selectType('cartoon');
                break;
            case '#folder-txt':
                resource.type = 'txt';
                $('#menu li').removeClass('active');
                $('#menu li:eq(4)').toggleClass('active');
                resource.selectType('txt');
                break;
            default:
                break;
        }
    });
    //单击Logo事件
    $('#logo').click(function(){
        window.location.href = 'index.php';
    });
    //清理缓冲
    $('a[href="#clear-cache"]').click(function(){
        actionServer('cache-clear',{},function(data){
            sendMsg('info','清理缓冲成功!');
        });
    });
    //旋转所有图片
    $('a[href="#rotate-img"]').click(function(){
        actionServer('rotate-img',{
            'dir':resource.dir
        },function(data){
            sendMsg('info','旋转成功!');
        });
    });
    //编辑FX
    $('a[href="#operate-fx-edit"]').click(function() {
        resource.selectUpdate();
        if (resource.selectArr.length > 0) {
            resource.edit(resource.selectArr[resource.selectArr.length-1]);
        } else {
            sendMsg('error', '请选择文件或文件夹!');
        }
    });
    //删除FX
    $('a[href="#operate-fx-del"]').click(function() {
        resource.selectUpdate();
        if (resource.selectArr.length > 0) {
            resource.del(resource.selectArr);
        } else {
            sendMsg('error', '请选择文件或文件夹!');
        }
    });
}

//设置界面类
var set = new Object;
//初始化
set.start = function() {
    //设置确认按钮
    $('#setSaveButton').click(function() {
        tag.set();
        $('#setModal').modal('hide');
    });
}

//初始化
$(function() {
    //初始化发布框架
    upload.start();
    //初始化菜单栏
    menu.start();
    //初始化设置界面
    set.start();
    //初始化icheck
    $('input').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
    //标签初始化
    tag.start();
    //设定提示框架
    Messenger.options = {
        'extraClasses': 'messenger-fixed messenger-on-bottom',
        'theme': 'flat'
    }
    //初始化资源
    resource.start();
});