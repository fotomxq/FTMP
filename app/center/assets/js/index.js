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

//联合锁定处理器
var postLock = false;

//用户设置
var user = new Object;
//当前用户昵称
user.nicename = '';
//数据未修改锁定
user.dataLock = false;
//初始化
user.start = function() {
    //当窗口激活
    $('#userModal').on('show.bs.modal', function() {
        if(postLock === true){
            return false;
        }
        if(user.dataLock === true){
            return false;
        }
        postLock = true;
        actionServer('user-info', {}, function(data) {
            postLock = false;
            if (data) {
                user.dataLock = true;
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
    if(postLock === true){
        return false;
    }
    var nicename = $('#user-name').val();
    var passwd = $('#user-passwd').val();
    if (!nicename) {
        sendMsg('info', '请输入用户昵称!');
        return false;
    }
    if (passwd) {
        if (passwd.length < 6 || passwd.length > 20) {
            sendMsg('info', '用户密码不能少于6个字符或大于20个字符!');
            return false;
        }
    }
    postLock = true;
    actionServer('user-info-save', {
        'nicename': nicename,
        'passwd': passwd
    }, function(data) {
        postLock = false;
        if (data === true) {
            user.dataLock = false;
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
system.maintStatus = false;
//数据锁定状态
system.dataLock = false;
//初始化
system.start = function() {
    //当窗口激活
    $('#systemModal').on('show.bs.modal', function() {
        system.updateData();
    });
    //备份数据库按钮
    $('#system-backup-button').click(function() {
        system.backup('both');
    });
    //维护切换按钮
    $('#system-maint-button').click(function(){
        system.maint();
    });
    //保存参数
    $('#system-save-button').click(function(){
        system.save();
    });
    //还原数据库按钮
    $('#system-backup-return-button').click(function(){
        system.re();
    });
    //仅备份数据库按钮
    $('#system-backup-only-sql-button').click(function(){
        system.backup('sql');
    });
    //仅备份文件按钮
    $('#system-backup-only-file-button').click(function(){
        system.backup('file');
    });
}
//获取相关参数
system.updateData = function() {
    if(postLock === true){
        return false;
    }
    if(system.dataLock === true){
        return false;
    }
    postLock = true;
    actionServer('system-info',{},function(data){
        postLock = false;
        if(data){
            system.dataLock = true;
            if(data['system-maint'] === '1'){
                system.maintStatus = true;
                $('#system-maint').html('系统正在维护...');
            }else{
                system.maintStatus = false;
                $('#system-maint').html('系统正常访问...');
            }
            $('#system-user-limit-time').val(data['user-limit-time']);
            $('#system-database-return').html('');
            if(data['backup-list']){
                $('#system-database-return').html('');
                for(var i=0;i<data['backup-list'].length;i++){
                    $('#system-database-return').append('<span class="label label-default" data-select="false">'+data['backup-list'][i]+'</span>');
                }
                $('#system-database-return span').click(function(){
                    $('#system-database-return span[data-select="true"]').removeClass('label-success');
                    $('#system-database-return span[data-select="true"]').addClass('label-default');
                    $('#system-database-return span[data-select="true"]').attr('data-select','false');
                    $(this).removeClass('label-default');
                    $(this).addClass('label-success');
                    $(this).attr('data-select','true');
                });
            }
        }
    });
}
//保存参数
system.save = function() {
    if(postLock === true){
        return false;
    }
    var userLimitTime = $('#system-user-limit-time').val();
    if (userLimitTime < 120) {
        sendMsg('error', '用户访问时间限制不能低于120秒.');
        return false;
    }
    postLock = true;
    actionServer('system-save', {
        'user-limit-time': userLimitTime
    }, function(data) {
        postLock = false;
        if (data === true) {
            system.dataLock = false;
            sendMsg('success', '系统参数保存成功!');
        } else {
            sendMsg('error', '系统参数保存失败.');
        }
        $('#systemModal').modal('hide');
    });
}
//切换维护模式
system.maint = function() {
    if(postLock === true){
        return false;
    }
    postLock = true;
    actionServer('system-maint',{},function(data){
        postLock = false;
        if(data === 1){
            system.maintStatus = true;
            system.dataLock = false;
            sendMsg('info','系统进入维护状态...');
        }else{
            system.maintStatus = false;
            sendMsg('info','系统退出维护状态.');
        }
        $('#systemModal').modal('hide');
    });
}
//备份数据库
system.backup = function(type) {
    if(postLock === true){
        return false;
    }
    if (system.isBackup === true) {
        sendMsg('info', '数据库繁忙，请稍等片刻...');
        return false;
    } else {
        sendMsg('info', '请稍等，正在备份数据库...');
    }
    postLock = true;
    actionServer('database-backup', {
        'type':type
    }, function(data) {
        postLock = false;
        if (data === true) {
            system.dataLock = false;
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
    if(postLock === true){
        return false;
    }
    if(!$('#system-database-return span[data-select="true"]').html()){
        sendMsg('info', '请选择备份文件，然后再进行还原操作.');
        return false;
    }
    if (system.isBackup === true) {
        sendMsg('info', '数据库繁忙，请稍等片刻...');
        return false;
    } else {
        sendMsg('info', '请稍等，正在还原数据库...');
    }
    postLock = true;
    actionServer('database-return', {
        'file-name': $('#system-database-return span[data-select="true"]').html()
    }, function(data) {
        postLock = false;
        if (data === true) {
            system.dataLock = false;
            sendMsg('success', '数据库还原成功!');
        } else {
            sendMsg('error', '数据库还原失败，请尝试自行解压备份文件，清空表执行所有SQL文件和将content替换即可!');
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