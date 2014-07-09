//通用服务器交互
function actionServer(type, data, func) {
    $.post('action.php?action=' + type, data, func, 'json');
}
//发送消息
function sendMsg(type, message) {
    Messenger().post({
        message: message,
        type: type
    });
}

//用户设置
var user = new Object;
//当前用户昵称
user.nicename = '';
//初始化
user.start = function() {
    //当窗口激活
    $('#userModal').on('show.bs.modal', function() {
        actionServer('user-info', {}, function(data) {
            if (data) {
                $('#user-name').val(data['user_nicename']);
                user.nicename = data['user_nicename'];
                for (var i = 0; i < data['meta'].length; i++) {
                    if (data['meta'][i]['meta_name'] === 'POWER') {
                        $('#user-powers').html(data['meta'][i]['meta_value']);
                    }
                    if (data['meta'][i]['meta_name'] === 'APP') {
                        $('#user-apps').html(data['meta'][i]['meta_value']);
                    }
                }
            } else {
                $('#userModal').modal('hide');
            }
        });
    });
    //保存用户信息
    $('#user-save-button').click(function() {
        user.save();
    });
}
//保存用户信息
user.save = function() {
    var nicename = $('#user-name').val();
    var passwd = $('#user-passwd').val();
    if (!nicename) {
        sendMsg('info', '请输入用户昵称!');
    }
    if (passwd) {
        if (passwd.length < 6 || passwd.length > 20) {
            sendMsg('info', '用户密码不能少于6个字符或大于20个字符!');
        }
    }
    actionServer('user-info-save', {
        'nicename': nicename,
        'passwd': passwd
    }, function(data) {
        if (data === true) {
            sendMsg('success', '保存成功!');
        } else {
            sendMsg('error', '无法保存用户信息.');
        }
        $('#userModal').modal('hide');
    });
}

//系统设置
var system = new Object;
//备份或还原数据库状态
system.isBackup = false;
//当前状态
system.maint = false;
//初始化
system.start = function() {
    //当窗口激活
    $('#systemModal').on('show.bs.modal', function() {
        system.updateData();
    });
    //备份数据库按钮
    $('#system-database-button').click(function() {
        system.backup();
    });
    //维护切换按钮
    $('#system-maint-button').click(function(){
        system.maint();
    });
    //保存参数
    $('#system-save-button').click(function(){
        system.save();
    });
}
//获取相关参数
system.updateData = function() {
    actionServer('system-info',{},function(data){
        if(data){
            if(data['system-maint'] === '1'){
                system.maint = true;
                $('#system-maint').html('系统正在维护...');
            }else{
                system.maint = false;
                $('#system-maint').html('系统正常访问...');
            }
            $('#system-user-limit-time').val(data['user-limit-time']);
            $('#system-database-return').html('');
            if(data['backup-list']){
                //////////////////////
            }
        }
    });
}
//保存参数
system.save = function() {
    var userLimitTime = $('#system-user-limit-time').val();
    if (userLimitTime < 120) {
        sendMsg('error', '用户访问时间限制不能低于120秒.');
        return false;
    }
    actionServer('system-save', {
        'user-limit-time': userLimitTime
    }, function(data) {
        if (data === true) {
            sendMsg('success', '系统参数保存成功!');
        } else {
            sendMsg('error', '系统参数保存失败.');
        }
        $('#systemModal').modal('hide');
    });
}
//切换维护模式
system.maint = function() {
    actionServer('system-maint',{},function(data){
        if(data === 1){
            system.maint = true;
            sendMsg('info','系统进入维护状态...');
        }else{
            system.maint = false;
            sendMsg('info','系统退出维护状态.');
        }
        $('#systemModal').modal('hide');
    });
}
//备份数据库
system.backup = function() {
    sendMsg('info', '请稍等，正在备份数据库...');
    if (system.isBackup === true) {
        sendMsg('info', '数据库繁忙，请稍等片刻...');
        return false;
    }
    actionServer('database-backup', {}, function(data) {
        if (data === true) {
            sendMsg('success', '数据库备份成功!');
        } else {
            sendMsg('error', '数据库备份失败!');
        }
        $('#systemModal').modal('hide');
        system.isBackup = false;
    });
    system.isBackup = true;
}
//还原数据库
system.re = function() {
    sendMsg('info', '请稍等，正在还原数据库...');
    if (system.isBackup === true) {
        sendMsg('info', '数据库繁忙，请稍等片刻...');
        return false;
    }
    actionServer('database-return', {
        'file-name': '123.zip'
    }, function(data) {
        if (data === true) {
            sendMsg('success', '数据库还原成功!');
        } else {
            sendMsg('error', '数据库还原失败!');
        }
        $('#systemModal').modal('hide');
        system.isBackup = false;
    });
    system.isBackup = true;
}

//页面初始化
$(function() {
    user.start();
    system.start();
    //初始化icheck
    $('input').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
    //设定提示框架
    Messenger.options = {
        'extraClasses': 'messenger-fixed messenger-on-bottom',
        'theme': 'flat'
    }
});