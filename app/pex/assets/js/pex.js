//资源类
var resource = new Object;
//当前所在目录ID
resource.parent = 0;
//页数相关数据
resource.page = 1;
resource.max = 10;
resource.sort = 0;
resource.desc = 1;
//加载锁定
resource.lock = false;
//操作的DOM
resource.dom = $('#content-resource');
//当前选择列
resource.select = new Array();
//当前模式
resource.mode = 'normal';
//原始数据
resource.data = new Array();
//刷新资源
resource.update = function() {
    //锁定
    if (resource.lock === true) {
        message.post('info', '系统繁忙,请稍等片刻...');
        return false;
    }
    resource.lock = true;
    //获取标签
    var tags = info.updateSelect(info.domTag);
    //与服务器通讯
    ajax.post('resource', {
        'parent': resource.parent,
        'tags': tags,
        'page': resource.page,
        'max': resource.max,
        'sort': resource.sort,
        'desc': resource.desc
    }, function(data) {
        //锁定
        resource.lock = false;
        //数据是否存在
        if (!data) {
            if (resource.page > 1) {
                $('#resource-more').remove();
            } else {
                message.post('info', '当前目录下没有任何数据!');
            }
            return false;
        }
        //获取当前已有数据长度
        var dataLen = resource.data.length;
        //保存原始数据
        resource.data = resource.data.concat(data);
        //删除加载更多按钮
        $('#resource-more').remove();
        //输出数据
        $(data).each(function(k, v) {
            var newK = k + dataLen;
            resource.dom.append('<div class="resource-' + resource.mode + '" data-key="' + newK + '" data-type="' + v['fx_type'] + '"><img src="img.php?id=' + v['id'] + '" class="img-rounded"><p>' + v['fx_title'] + '</p></div>');
        });
        //加载更多按钮
        if (data.length === resource.max) {
            resource.dom.append('<div class="resource-' + resource.mode + '" id="resource-more"><img src="assets/imgs/more.png" class="img-rounded"><p>加载更多</p></div>');
            $('#resource-more').click(function() {
                resource.setPage(resource.page + 1);
            });
        }
        //解除所有事件
        resource.dom.children('div[id!="resource-more"]').unbind();
        //根据当前模式建立事件关联
        if (resource.mode === 'normal') {
            //单击选择FX
            resource.dom.children('div[id!="resource-more"]').click(function() {
                if ($(this).attr('data-select') === '1') {
                    $(this).attr('data-select', '0');
                    $(this).attr('style', '');
                } else {
                    $(this).attr('data-select', '1');
                    $(this).attr('style', 'background-color:#D2E2FF;');
                }
            });
            //双击打开FX
            resource.dom.children('div[id!="resource-more"]').dblclick(function() {
                resource.viewFx($(this).attr('data-key'));
            });
        } else if (resource.mode === 'phone') {
            //单击打开FX
            resource.dom.children('div[id!="resource-more"]').click(function() {
                resource.viewFx($(this).attr('data-key'));
            });
        }
    });
}
//查看FX
resource.viewFx = function(key) {
    var t = resource.data[key]['fx_type'];
    if (t === 'folder') {
        alert(resource.dom.children('div:eq(0)').width());
        //resource.setParent(key);
    } else if (t === 'jpg' || t === 'jpeg' || t === 'png' || t === 'gif') {
        var maxWidth = Math.abs($('#viewModal').width() - 20);
        $('#viewContent').html('<img src="img.php?id=' + resource.data[key]['id'] + '" style="max-width:' + maxWidth + 'px;">');
        $('#viewModal').modal('show');
    } else {
        resource.openFx(key);
    }
}
//打开FX
resource.openFx = function(key) {
    location.href = 'file.php?id=' + resource.data[key]['id'];
}
//切换页数
resource.setPage = function(p) {
    p = Math.ceil(p);
    if (p < 1) {
        p = 1;
    }
    if (p > resource.maxPage) {
        p = resource.maxPage;
    }
    if (resource.page === p) {
        return false;
    }
    if (!resource.data && p > resource.page) {
        return false;
    }
    resource.page = p;
    resource.update();
}
//选择目录
resource.setParent = function(key) {
    var id = resource.data[key]['id'];
    resource.parent = id;
    resource.dom.html('');
    resource.page = 1;
    resource.update();
}
//清空并刷新数据
resource.clear = function() {
    resource.dom.html('');
    resource.page = 1;
    resource.update();
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
    //清空标签选择
    $('#operate-clear').click(function() {
        label.clearSelect(info.domTag, 'default')
    });
    //开始搜索
    $('#operate-search').click(function() {
        resource.clear();
    });
    //切换到手机模式
    $('#operate-view-phone').click(function() {
        operate.selectMode('phone');
    });
    //切换到普通模式
    $('#operate-view-normal').click(function() {
        operate.selectMode('normal');
    });
    //强制刷新模式
    operate.selectMode('normal');
}
//选择了文件
operate.selectResource = function() {

}
//切换模式
operate.selectMode = function(mode) {
    resource.mode = mode;
    operate.dom.children('button[data-mode!="' + mode + '"][data-mode!="all"]').hide();
    operate.dom.children('button[data-mode="' + mode + '"]').show();
    resource.clear();
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
                if (key === info.nowType) {
                    info.nowTypeKey = i;
                }
            }
        }
        //创建显示数据
        label.insertArr(info.domType, info.dataType, 'default');
        label.insertSelect(info.domTag, info.dataTag[info.nowType], 'default', 'info');
        //插入Key标记
        $('#content-type span').each(function(k, v) {
            $(this).attr('data-key', k);
        });
        $('#content-tag span').each(function(k, v) {
            $(this).attr('data-key', k);
        });
        //修改当前选择类型标记
        $('#content-type span:eq(' + info.nowTypeKey + ')').attr('class', 'label label-success');
        //修正当前目录
        resource.parent = info.data['type'][info.nowTypeKey]['folder'];
        //创建按钮事件
        $('#content-type span').click(function() {
            info.nowType = info.data['type'][$(this).attr('data-key')]['key'];
            label.insertSelect(info.domTag, info.dataTag[info.nowType], 'default', 'info');
            $('#content-type span[class="label label-success"]').attr('class', 'label label-default');
            $(this).attr('class', 'label label-success');
            //修正当前目录
            resource.parent = info.data['type'][$(this).attr('data-key')]['folder'];
            //清空并刷新数据
            resource.clear();
        });
        //关闭屏幕锁定
        message.stopOff();
        //锁定数据
        info.lock = true;
        //初始化按钮组
        operate.start();
    });
}
//分析刷新当前已选标签
info.updateSelect = function(dom) {
    var doms = dom.children('span[data-select="1"]');
    var tagArr = new Array();
    if (doms) {
        doms.each(function(k, v) {
            tagArr.push(info.data['tag'][info.nowType][$(v).attr('data-key')]['id']);
        });
    }
    return tagArr;
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
});