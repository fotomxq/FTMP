//通用服务器交互
function actionServer(type,data,func){
    $.post('action.php?action='+type,data,func,'json');
}
//发送消息
function sendMsg(type,message){
    Messenger().post({
        message:message,
        type:type
    });
}

//发布新文件类
var upload = new Object;
//转移文件列数据
upload.transferFileList;
//页码和页长
upload.transferPage = 1;
upload.transferMax = 10;
//初始化
upload.start = function(){
    //刷新等待转移文件列
    upload.transferList();
    //选择类型事件
    $('input[name="transferTypeOptions"]').on('ifChecked',function(){
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
    $('#uploadModal').on('show.bs.modal',function(){
        upload.transferFileModal();
    });
    //清空文件选择事件
    $('a[href="#upload-file-tag-clear"]').click(function(){
        $('a[href="#uploadFileTag"]').attr('select','false');
        $('a[href="#uploadFileTag"] > span').removeClass('label-info');
        $('a[href="#uploadFileTag"] > span').addClass('label-default');
    });
    //全选文件
    $('#uploadSelectAllButton').click(function(){
        $('a[href="#uploadFileTag"]').attr('select','true');
        $('a[href="#uploadFileTag"] > span').removeClass('label-default');
        $('a[href="#uploadFileTag"] > span').addClass('label-info');
    });
}
//刷新显示的部分
upload.transferList = function(){
    actionServer('transfer-list',{
        'page':upload.transferPage,
        'max':upload.transferMax
    },function(data){
        upload.transferFileList = data;
    });
}
//发布转移文件
upload.transferFile = function(key){
    if(upload.transferFileList(key)){
        
    }
}
//激活框体事件
upload.transferFileModal = function(){
    $('input[name="transferTypeOptions"]:eq(0)').iCheck('check');
    $('#transferList').html('');
    if(upload.transferFileList){
        for(var i=0;i<upload.transferFileList.length;i++){
            $('#transferList').prepend('<a href="#uploadFileTag" value="'+i+'" select="false"><span class="label label-default">'+upload.transferFileList[i]+'</span></a>');
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
//刷新资源
resource.ref = function(){
    
}
//编辑资源信息
resource.edit = function(){
    
}
//删除资源
resource.del = function(){
    
}

//标签处理器
var tag = new Object;
//当前查看类别
tag.tagType = 'photo';
//所有标签
tag.data;
//初始化
tag.start = function(){
    //获取所有标签
    tag.getAll();
    //清除所有已选标签按钮事件
    $('a[href="#tag-clear"]').click(function(){
        $('a[href="#tag"]').attr('select','false');
        $('a[href="#tag"] > span').removeClass('label-info');
        $('a[href="#tag"] > span').addClass('label-default');
    });
}
//查看类别下所有标签
tag.getAll = function(){
    actionServer('tag-list',{},function(data){
        tag.data = data;
        tag.ref();
        $('#setTagPhoto').val(tag.joinStr(data['photo']));
        $('#setTagMovie').val(tag.joinStr(data['movie']));
        $('#setTagCartoon').val(tag.joinStr(data['cartoon']));
        $('#setTagTxt').val(tag.joinStr(data['txt']));
    });
}
//修改标签
tag.set = function(){
    var tags = {
        'photo':$('#setTagPhoto').val(),
        'movie':$('#setTagMovie').val(),
        'cartoon':$('#setTagCartoon').val(),
        'txt':$('#setTagTxt').val()
    };
    actionServer('tag-set',{
        tags:tags
    },function(data){
        if(data==true){
            
        }
        sendMsg('success','修改成功!');
        tag.getAll();
    });
}
//合并标签为字符串
tag.joinStr = function(tags){
    if(tags){
        var res = '';
        for(var i=0;i<tags.length;i++){
            if(i < tags.length-1){
                res += tags[i]['tag_name']+'|';
            }else{
                res += tags[i]['tag_name'];
            }
        }
        return res;
    }
    return '';
}
//刷新当前页面下的标签显示
tag.ref = function(){
    $('a[href="#tag"]').remove();
    if(tag.data[tag.tagType]){
        for(var i=0;i<tag.data[tag.tagType].length;i++){
            $('#tagList').prepend('<a href="#tag" value="'+tag.data[tag.tagType][i]['id']+'" select="false"><span class="label label-default">'+tag.data[tag.tagType][i]['tag_name']+'</span></a>');
        }
    }
    $('a[href="#tag"]').click(function(){
        if($(this).attr('select') === 'true'){
            $(this).attr('select','false');
            $(this).children('span').removeClass('label-info');
            $(this).children('span').addClass('label-default');
        }else{
            $(this).attr('select','true');
            $(this).children('span').removeClass('label-default');
            $(this).children('span').addClass('label-info');
        }
        resource.ref();
    });
    resource.ref();
}
//和文件关联标签
tag.addTx = function(){
    
}
//取消关联
tag.delTx = function(){
    
}

//菜单栏
var menu = new Object;
//初始化菜单栏
menu.start = function(){
    $('#menu li').click(function(){
        var href = $(this).children('a').attr('href');
        $('#menu li').removeClass('active');
        switch(href){
            case '#folder-movie':
                resource.type = 'movie';
                $('#menu li:eq(2)').toggleClass('active');
                break;
            case '#folder-cartoon':
                resource.type = 'cartoon';
                $('#menu li:eq(3)').toggleClass('active');
                break;
            case '#folder-txt':
                resource.type = 'txt';
                $('#menu li:eq(4)').toggleClass('active');
                break;
            default:
                resource.type = 'photo';
                $('#menu li:eq(1)').toggleClass('active');
                break;
        }
    });
}

//设置界面类
var set = new Object;
//初始化
set.start = function(){
    //设置确认按钮
    $('#setSaveButton').click(function(){
        tag.set();
        $('#setModal').modal('hide');
    });
}

//初始化
$(function(){
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
        'extraClasses': 'messenger-fixed messenger-on-bottom messenger-on-right',
        'theme': 'flat'
    }
});