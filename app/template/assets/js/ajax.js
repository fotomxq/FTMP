/**
 * ajax简化处理器
 */
var ajax = new Object;
//发送post
ajax.post = function(type, data, func) {
    $.post('action.php?action=' + type, data, func, 'json');
}
//发送get
ajax.get = function(type, func) {
    $.get('action.php?action=' + type, func, 'json');
}