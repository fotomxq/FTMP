//用户处理器
var user = new Object;
//联合锁定
user.lock = false;
user.dataLock = false;
//当前数据
user.data;
//页相关参数
user.page = 1;
user.max = 10;
user.sort = 0;
user.desc = 1;
user.maxPage = 1;
//可用权限
user.powers = new Array();
//可用应用
user.apps = new Array();
//列表DOM
user.listDom = $('#user-list');
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
    //消息框架编辑、删除按钮
    $('#info-edit-button').click(function() {
        $('#infoModal').modal('hide');
        user.editModal($('#infoModal').attr('data-key'));
    });
    $('#info-del-button').click(function() {
        $('#infoModal').modal('hide');
        user.delModal($('#infoModal').attr('data-key'));
    });
    //将可用权限和应用存入数组
    $('#add-powers-ready span').each(function(k, v) {
        user.powers.push($(this).html());
    });
    $('#add-apps-ready span').each(function(k, v) {
        user.apps.push($(this).html());
    });
    //添加用户按钮
    $('a[href="#add-user-modal"]').click(function() {
        $('#add-login-name').val('');
        $('#add-nice-name').val('');
        $('#add-passwd').val('');
        label.insertChange($('#add-powers-ready'), $('#add-powers-select'), user.powers, new Array(), 'default', 'primary');
        label.insertChange($('#add-apps-ready'), $('#add-apps-select'), user.apps, new Array(), 'default', 'info');
        $('#addModal').modal('show');
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
    user.listDom.html('');
    //读取数据
    ajax.post('list', {
        'page': user.page,
        'max': user.max,
        'sort': user.sort,
        'desc': user.desc
    }, function(data) {
        user.data = data;
        if (!data) {
            message.post('info', '没有内容了.');
            return false;
        }
        user.maxPage = user.data[0]['max-page'];
        for (var i = 0; i < data.length; i++) {
            user.listDom.append('<tr data-key="' + i + '"><td>' + data[i]['id'] + '</td><td>' + data[i]['user_nicename'] + '</td><td>' + data[i]['user_login'] + '</td><td>' + data[i]['user_date'] + '</td><td>' + data[i]['ip_address'] + '</td><td><a href="#user-info-modal" class="btn btn-info">详情</a> <a href="#user-edit-modal" class="btn btn-primary">编辑</a> <a href="#user-del-modal" class="btn btn-danger">删除</a></td></tr>');
        }
        //显示页数
        $('#page-show').html(user.page + ' / ' + user.maxPage);
        //创建编辑和删除按钮事件
        $('a[href="#user-info-modal"]').click(function() {
            user.infoModal($(this).parent().parent().attr('data-key'));
        });
        $('a[href="#user-edit-modal"]').click(function() {
            user.editModal($(this).parent().parent().attr('data-key'));
        });
        $('a[href="#user-del-modal"]').click(function() {
            user.delModal($(this).parent().parent().attr('data-key'));
        });
    });
    user.dataLock = true;
}
//激活查看框架
user.infoModal = function(key) {
    $('#infoModal').attr('data-key', key);
    $('#info-login').html(user.data[key]['user_login']);
    $('#info-nicename').html(user.data[key]['user_nicename']);
    $('#info-create-date').html(user.data[key]['user_date']);
    $('#info-ip').html(user.data[key]['ip_address'] + ' ( ID: ' + user.data[key]['user_ip'] + ' )');
    label.insertArr($('#info-app'), user.data[key]['app'], 'info');
    label.insertArr($('#info-power'), user.data[key]['power'], 'info');
    $('#infoModal').modal('show');
}
//激活编辑框架
user.editModal = function(key) {
    $('#editModal').attr('data-key', key);
    $('#edit-login-name').val(user.data[key]['user_login']);
    $('#edit-nice-name').val(user.data[key]['user_nicename']);
    $('#edit-passwd').val('');
    label.insertChange($('#edit-powers-ready'), $('#edit-powers-select'), user.powers, user.data[key]['power'], 'default', 'primary');
    label.insertChange($('#edit-apps-ready'), $('#edit-apps-select'), user.apps, user.data[key]['app'], 'default', 'info');
    $('#editModal').modal('show');
}
//激活删除框架
user.delModal = function(key) {
    $('#delModal').attr('data-key', key);
    $('#del-name').html(user.data[key]['user_nicename']);
    $('#delModal').modal('show');
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
    ajax.url = 'action-user.php';
    user.start();
});