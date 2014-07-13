//封装屏蔽消息
function msgStop() {
    message.stop('正在加载数据，请稍等...');
}
//解除消息屏蔽
function msgStopOff() {
    message.stopOff();
}

//类型数据
var type = new Object;
//当前选择的类型
type.select = '';
//类型数据
type.data;
//获取类型数据
type.start = function() {
    ajax.get('type-default', function(data) {
        type.select = data;
    });
    ajax.get('type-all', function(data) {
        type.data = data;
        type.select[$(data).eq(0)];
        type.show('#content-type');
    });
}
//刷新到指定的HTML中
type.show = function(htmlID) {
    //插入数据
    $(type.data).each(function(key, item) {console.log(item);
        var html = '<span data-select="false" class="label label-';
        if (type.select === item['key']) {
            html += 'success">' + item['title'] + '</span>';
        } else {
            html += 'default">' + item['title'] + '</span>';
        }
        $(htmlID).append(html);
    });
    //创建选择控制
    $(htmlID + ' .label').click(function() {
        $(htmlID + ' .label').attr('data-select', 'false');
        $(htmlID + ' .label').removeClass('label-success');
        $(htmlID + ' .label').addClass('label-default');
        $(this).attr('data-select', 'true');
        $(this).addClass('label-success');
    });
}

//标签
var tag = new Object;
//所有标签数据
tag.data = new Array();
//正在操作的HTML
tag.htmlID = '';
//加载标签数据
tag.update = function() {
    msgStop();
    ajax.get('tag-all', function(data) {
        msgStopOff();
        tag.data = data;
        tag.show('#content-tag', type.select);
    });
}
//显示对应标签
tag.show = function(htmlID, t) {
    //插入HTML
    if(!tag.data[t]){
        return;
    }
    for (var i = 0; i < tag.data[t].length; i++) {
        var html = '<span data-select="false" class="label label-default">' + v['title'] + '</span>';
        $(htmlID).append(html);
    }
    //创建选择控制
    $(htmlID + ' .label').click(function() {
        $(htmlID + ' .label').attr('data-select', 'false');
        $(htmlID + ' .label').removeClass('label-success');
        $(htmlID + ' .label').addClass('label-default');
        $(this).attr('data-select', 'true');
        $(this).addClass('label-success');
    });
}

//初始化
$(function() {
    //初始化icheck
    $('input').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
    });
    //初始化消息框架
    message.start('messenger-fixed messenger-on-bottom', 'flat');
    //初始化显示类型标签
    type.start();
    //加载所有标签
    tag.update();
});