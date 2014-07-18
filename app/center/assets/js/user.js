//用户处理器
var user = new Object;
//联合锁定
user.lock = false;
user.dataLock = false;
//页相关参数
user.page = 1;
user.max = 10;
user.sort = 0;
user.desc = 1;
user.maxPage = 1;
//初始化
user.start = function() {
    //切换页按钮组
    $('a[href="#page-prev"]').click(function() {
        user.setPage(-1);
    });
    $('a[href="#page-next"]').click(function() {
        user.setPage(1);
    });
    $('a[href="#page-index"]').click(function() {
        user.setPage(1);
    });
    $('a[href="#page-end"]').click(function() {
        user.setPage(user.maxPage);
    });
    //加载数据
    user.load();
}
//获取列表
user.load = function() {
    if (user.dataLock === true) {
        return false;
    }
    if (user.lock === true) {
        return false;
    }
    //
    user.dataLock = true;
}
//编辑用户
user.edit = function(id, login, name, passwd, power, app) {
    if (user.lock === true) {
        return false;
    }
    //
    user.dataLock = false;
}
//删除用户
user.del = function(id) {
    if (user.lock === true) {
        return false;
    }
    //
    user.dataLock = false;
}
//设定排序
user.setSort = function(key) {
    if (user.desc === 0) {
        user.desc = 1;
    } else {
        user.desc = 0;
    }
    user.sort = key;
    user.page = 1;
    user.dataLock = false;
    user.load();
}
//切换页面
user.setPage = function(p) {
    user.page = user.page + p;
    if (user.page < 1) {
        user.page = 1;
        return false;
    }
    if (user.page > user.maxPage) {
        user.page = user.maxPage;
        return false;
    }
    user.dataLock = false;
    user.load();
}

//初始化
$(function() {
    //初始化相关组件
    message.start();
    user.start();
});