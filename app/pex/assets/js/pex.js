//通用服务器交互
function actionServer(type,data,func){
    $.post('action.php?action='+type,data,func,'json');
}

//发布新文件类
var upload = new Object;
//转移文件列数据
upload.transferFileList;
//页码和页长
upload.transferPage = 1;
upload.transferMax = 10;
//刷新显示的部分
upload.transferList = function(){
    actionServer('transfer-list',{
        'page':upload.transferPage,
        'max':upload.transferMax
    },function(data){
        transferFileList = data;
    });
}
//发布转移文件
upload.transferFile = function(key){
    if(upload.transferFileList(key)){
        
    }
}

//资源处理器
var resource = new Object;
//当前所属类型
resource.type = 'photo';
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
//查看类别下所有标签
tag.getAll = function(){
    actionServer('tag-list',{},function(data){
        tag.data = data;
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
        tag.getAll();
    });
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
    //刷新等待转移文件列
    upload.transferList();
    //初始化菜单栏
    menu.start();
    //初始化设置界面
    set.start();
    //获取所有标签
    tag.getAll();
});