//日志操作对象
var log = new Object;
//偏移位置
log.offset = 0;
log.max = 9999;
//日志存储类型
log.saveType = 0;
//联合锁定
log.lock = false;
//初始化日志
log.start = function() {
    //获取相关参数
    log.saveType = $('#log-list').attr('data-log-type');
    if (log.saveType === '0') {
        log.lock = true;
        $('#log-content').html('<p>当前日志以系统日志方式存储，请进入服务器设定的日志目录查看。</p>');
    } else {
        log.load();
    }
    //切换页按钮组
    $('a[href="#page-prev"]').click(function() {
        log.setPage(-1);
    });
    $('a[href="#page-next"]').click(function() {
        log.setPage(1);
    });
    $('a[href="#page-index"]').click(function() {
        log.setPage(1);
    });
    $('a[href="#page-end"]').click(function() {
        log.setPage(log.max);
    });
}
//从服务器获取日志信息
log.load = function() {
    if (log.lock === true) {
        return false;
    }
    log.lock = true;
    ajax.post('list', {
        'offset': log.offset
    }, function(data) {
        log.lock = false;
        if (!data) {
            return false;
        }
    });
}
//换页
log.setPage = function(p){
    log.offset = log.offset + p;
    if (log.offset < 1) {
        log.offset = 1;
        return false;
    }
    log.load();
}

//初始化
$(function() {
    //初始化相关组件
    message.start();
    ajax.url = 'action-log.php';
    //初始化日志
    log.start();
});