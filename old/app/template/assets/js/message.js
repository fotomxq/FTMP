/**
 * 消息处理器
 */
var message = new Object;
//屏蔽操作提示框ID
message.stopHtmlID = 'message-stop';
//解除所有屏蔽提示的列队数
message.stopListNum = 0;
//是否已经创建屏幕屏蔽框
message.isStopModal = false;
//初始化
message.start = function(extra, theme) {
    Messenger.options = {
        'extraClasses': extra,
        'theme': theme
    }
}
//发送一个消息
message.post = function(type, message) {
    Messenger().post({
        message: message,
        type: type
    });
}
//快速发送一个boolean消息
message.postBool = function(bool, success, faild) {
    if (bool === true) {
        message.post('success', success);
    } else {
        message.post('error', faild);
    }
}
//创建屏蔽操作的提示框
message.stop = function(msg) {
    htmlID = '#' + message.stopHtmlID;
    if (message.stopListNum === 0 && message.isStopModal === false) {
        message.isStopModal = true;
        var topFix = $(document).height() / 2;
        $('body').append('<div id="' + message.stopHtmlID + '" style="width:100%;height:100%;position:absolute;z-index:99;top:0px;left:0px;background-color:#000;text-align:center;color:#FFF;padding-top:' + topFix + 'px;">' + msg + '</div>');
    }
    $(htmlID).fadeTo('fast', 0.5);
    message.stopListNum += 1;
}
//取消屏蔽
message.stopOff = function() {
    message.stopListNum -= 1;
    if (message.stopListNum === 0) {
        $('#' + message.stopHtmlID).stop();
        $('#' + message.stopHtmlID).fadeOut('fast');
    }
}