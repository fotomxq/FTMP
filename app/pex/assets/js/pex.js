//通用服务器交互
function actionServer(type,data,func){
    $.post('action.php?action='+type,data,func);
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
//查看类别下所有标签
tag.getAll = function(){
    actionServer('tag-list',{
        
    },function(data){
        
    });
}
//添加标签
tag.add = function(){
    
}
//编辑标签
tag.edit = function(){
    
}
//删除标签
tag.del = function(){
    
}
//和文件关联标签
tag.addTx = function(){
    
}
//取消关联
tag.delTx = function(){
    
}

//初始化
$(function(){
    upload.transferList();
});