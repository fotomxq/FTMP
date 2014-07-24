//资源类
var resource = new Object;
//页数相关数据
resource.page = 1;
resource.pageMax = 10;
resource.max = 10;
resource.sort = 0;
resource.desc = 1;
//操作的DOM
resource.dom = $('#content-resource');
//当前选择列
resource.select = new Array();
//当前模式
resource.mode = 'normal';
//刷新资源
resource.update = function(){
    console.log('resource-update');
}
//切换页数
resource.setPage = function(p){
    resource.page = p;
    resource.page = Math.ceil(resource.page);
    if(resource.page < 1){
        resource.page = 1;
    }
    if(resource.page > resource.maxPage){
        resource.page = resource.maxPage;
    }
    resource.update();
    console.log('resource-set-page');
}
//清空并刷新数据
resource.clear = function(){
    resource.dom.html('');
    resource.page = 1;
    resource.update();
    console.log('resource-clear');
}

//操作类
var operate = new Object;
//操作按钮组所属DOM
operate.dom = $('#content-operate');
//初始化
operate.start = function() {
    //如果点击标签
    $(info.domTag).children('span').click(function() {
        if (label.getSelect(info.domTag)) {
            $('#operate-clear').show();
        }
    });
    //按钮事件
    $('#operate-clear').click(function() {
        label.clearSelect(info.domTag, 'default')
    });
    $('#operate-search').click(function() {
        resource.update();
    });
    $('#operate-view-phone').click(function() {
        operate.selectMode('phone');
    });
    $('#operate-view-normal').click(function() {
        operate.selectMode('normal');
    });
    //强制刷新模式
    operate.selectMode('normal');
}
//选择了文件
operate.selectResource = function(){
    
}
//切换模式
operate.selectMode = function(mode) {
    resource.mode = mode;
    operate.dom.children('button[data-mode!="'+mode+'"][data-mode!="all"]').hide();
    operate.dom.children('button[data-mode="'+mode+'"]').show();
}

//非记录信息类
var info = new Object;
//数据锁定
info.lock = false;
//原始数据
info.data;
//类型数据列
info.dataType = new Array();
//标签数据列
info.dataTag = new Array();
//Dom
info.domType = $('#content-type');
info.domTag = $('#content-tag');
//当前类型
info.nowType = '';
info.nowTypeKey = 0;
//获取数据
info.update = function() {
    //是否锁定
    if (info.lock === true) {
        message.post('info', '服务器繁忙,请稍后重试...');
        return false;
    }
    //锁定屏幕
    message.stop('正在加载数据，请稍等...');
    //和服务器连接
    ajax.post('info', {}, function(data) {
        info.data = data;
        //是否无数据
        if (!data) {
            message.post('error', '无法获取服务器信息,请稍后重试!');
        }
        //如果无选择类型，则给定默认值
        if (!info.nowType) {
            info.nowType = data['type-default'];
        }
        //分析数据
        if (data['type']) {
            for (var i = 0; i < data['type'].length; i++) {
                var key = data['type'][i]['key'];
                info.dataType.push(data['type'][i]['title']);
                if (data['tag']) {
                    if (data['tag'][key]) {
                        info.dataTag[key] = new Array();
                        for (var j = 0; j < data['tag'][key].length; j++) {
                            info.dataTag[key].push(data['tag'][key][j]['tag_name']);
                        }
                    }
                }
                if(key === info.nowType){
                    info.nowTypeKey = i;
                }
            }
        }
        //创建显示数据
        label.insertArr(info.domType, info.dataType, 'default');
        label.insertSelect(info.domTag, info.dataTag[info.nowType], 'default', 'info');
        //插入Key标记
        $('#content-type span').each(function(k,v){
            $(this).attr('data-key',k);
        });
        $('#content-tag span').each(function(k,v){
            $(this).attr('data-key',k);
        });
        //修改当前选择类型标记
        $('#content-type span:eq('+info.nowTypeKey+')').attr('class','label label-success');
        //创建按钮事件
        $('#content-type span').click(function(){
            info.nowType = info.data['type'][$(this).attr('data-key')]['key'];
            label.insertSelect(info.domTag, info.dataTag[info.nowType], 'default', 'info');
            $('#content-type span[class="label label-success"]').attr('class','label label-default');
            $(this).attr('class','label label-success');
            resource.clear();
        });
        //关闭屏幕锁定
        message.stopOff();
        //锁定数据
        info.lock = true;
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
    //初始化类型和标签信息
    info.update();
    //初始化按钮组
    operate.start();
});