/**
 * ajax简化处理器
 */
var ajax = new Object;
//action地址
ajax.url = 'action.php';
//发送post
ajax.post = function(type, data, func) {
    $.post(ajax.url + '?action=' + type, data, func, 'json');
}
//发送get
ajax.get = function(type, func) {
    $.get('action.php?action=' + type, func, 'json');
}