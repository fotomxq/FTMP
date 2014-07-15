/**
 * IP页面操作
 */
//ip处理器
var ip = new Object;
//页设定
ip.page = 1;
ip.max = 10;
ip.sort = 0;
ip.desc = true;
//最大页数
ip.maxPage = 0;
//联合锁定
ip.lock = false;
//加载数据
ip.load = function(){
    ip.lock = true;
    ajax.post('list',{
        'page':ip.page,
        'max':ip.max,
        'sort':ip.sort,
        'desc':ip.desc
    },function(data){
        if(!data){
            return false;
        }
        //添加到列表
        for(var i=0;i<data.length;i++){
            
        }
        //修正最大页数
    });
}
//切换页面
ip.setPage = function(p){
    ip.page = ip.page + p;
    if(ip.page < 1){
        ip.page = 1;
    }
}

//初始化
$(function(){
    //修改ajax方法URL
    ajax.url = 'action-ip.php';
});