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
//添加用户框体是否需要清空
user.addClearBoolean = true;
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
        user.addModal();
    });
    //添加、修改、删除用户确认按钮
    $('#add-button').click(function() {
        var selectPowerArr = label.getChange($('#add-powers-select'));
        var selectAppArr = label.getChange($('#add-apps-select'));
        user.add($('#add-login-name').val(), $('#add-nice-name').val(), $('#add-passwd').val(), selectPowerArr, selectAppArr);
    });
    $('#edit-button').click(function() {
        var selectPowerArr = label.getChange($('#edit-powers-select'));
        var selectAppArr = label.getChange($('#edit-apps-select'));
        user.edit(user.data[$('#editModal').attr('data-key')]['id'], $('#edit-nice-name').val(), $('#edit-passwd').val(), selectPowerArr, selectAppArr);
    });
    $('#del-button').click(function() {
        user.del(user.data[$('#delModal').attr('data-key')]['id']);
    });
    //加载数据
    user.load();
}
//获取列表
user.load = function() {
    //联合锁定
    if (user.dataLock === true) {
        return false;
    }
    user.dataLock = false;
    if (user.lock === true) {
        return false;
    }
    user.lock = true;
    //清空数据
    user.listDom.html('');
    //读取数据
    ajax.post('list', {
        'page': user.page,
        'max': user.max,
        'sort': user.sort,
        'desc': user.desc
    }, function(data) {
        //解锁
        user.lock = false;
        //保存数据副本
        user.data = data;
        //判断是否存在内容
        if (!data) {
            message.post('info', '没有内容了.');
            return false;
        }
        //分析数据
        user.maxPage = user.data[0]['max-page'];
        for (var i = 0; i < data.length; i++) {
            var status = '<span class="label label-default">离线</span>';
            if(data[i]['user_status'] === '1'){
                status = '<span class="label label-success">在线</span>';
            }
            user.listDom.append('<tr data-key="' + i + '"><td>' + data[i]['id'] + '</td><td>' + data[i]['user_nicename'] + '</td><td>' + data[i]['user_login'] + '</td><td>' + status + '</td><td><a href="#user-info-modal" class="btn btn-info">详情</a> <a href="#user-edit-modal" class="btn btn-primary">编辑</a> <a href="#user-out" class="btn btn-warning">踢出</a> <a href="#user-del-modal" class="btn btn-danger">删除</a></td></tr>');
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
        $('a[href="#user-out"]').click(function() {
            user.editStatus(user.data[$(this).parent().parent().attr('data-key')]['id']);
        });
        $('a[href="#user-del-modal"]').click(function() {
            user.delModal($(this).parent().parent().attr('data-key'));
        });
    });
}
//激活添加用户框架
user.addModal = function() {
    if (user.addClearBoolean === true) {
        $('#add-login-name').val('');
        $('#add-nice-name').val('');
        $('#add-passwd').val('');
        label.insertChange($('#add-powers-ready'), $('#add-powers-select'), user.powers, new Array(), 'default', 'primary');
        label.insertChange($('#add-apps-ready'), $('#add-apps-select'), user.apps, new Array(), 'default', 'info');
        user.addClearBoolean = false;
    }
    $('#addModal').modal('show');
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
    $('#edit-nice-name').val(user.data[key]['user_nicename']);
    $('#edit-passwd').val('');
    var diffPowersArr = arrayExtend.diff(user.powers, user.data[key]['power']);
    var diffAppsArr = arrayExtend.diff(user.apps, user.data[key]['app']);
    label.insertChange($('#edit-powers-ready'), $('#edit-powers-select'), diffPowersArr, user.data[key]['power'], 'default', 'primary');
    label.insertChange($('#edit-apps-ready'), $('#edit-apps-select'), diffAppsArr, user.data[key]['app'], 'default', 'info');
    $('#editModal').modal('show');
}
//激活删除框架
user.delModal = function(key) {
    $('#delModal').attr('data-key', key);
    $('#del-name').html(user.data[key]['user_nicename']);
    $('#delModal').modal('show');
}
//创建用户
user.add = function(login, name, passwd, power, app) {
    if (user.lock === true) {
        return false;
    }
    ajax.post('add', {
        'login': login,
        'nicename': name,
        'passwd': passwd,
        'power': power,
        'app': app
    }, function(data) {
        if (data > 0 || data === true) {
            message.post('success', '添加用户成功!');
        } else {
            message.post('error', '无法添加用户!');
        }
        $('#addModal').modal('hide');
        user.load();
    });
    user.dataLock = false;
}
//编辑用户
user.edit = function(id, name, passwd, power, app) {
    if (user.lock === true) {
        return false;
    }
    ajax.post('edit', {
        'id': id,
        'nicename': name,
        'passwd': passwd,
        'power': power,
        'app': app
    }, function(data) {
        message.postBool(data, '用户修改成功！', '无法修改用户！');
        $('#editModal').modal('hide');
        user.load();
    });
    user.dataLock = false;
}
//踢用户下线
user.editStatus = function(id) {
    if (user.lock === true) {
        return false;
    }
    ajax.post('edit-status', {
        'id': id
    }, function(data) {
        message.postBool(data, '用户已经下线！', '无法修改用户在线状态！');
    });
    user.dataLock = false;
}
//删除用户
user.del = function(id) {
    if (user.lock === true) {
        return false;
    }
    ajax.post('del', {
        'id': id
    }, function(data) {
        message.postBool(data, '删除用户成功！', '无法删除该用户！');
        $('#delModal').modal('hide');
        user.load();
    });
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
    message.start('messenger-fixed messenger-on-bottom', 'flat');
    ajax.url = 'action-user.php';
    user.start();
});