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
//是否清空数据
resource.isClear = true;
//当前模式
resource.mode = 'normal';
//原始数据
resource.data = new Array();
//初始化
resource.start = function() {
    //打开文件
    $('#view-open-button').click(function() {
        resource.openFx($('#viewModal').attr('data-key'));
    });
    //上下切换文件
    $('#view-prev-button').click(function() {
        var key = Math.abs($('#viewModal').attr('data-key'));
        key = key - 1;
        if (key > -1) {
            resource.viewFx(key);
        }
    });
    $('#view-next-button').click(function() {
        var key = Math.abs($('#viewModal').attr('data-key'));
        key = key + 1;
        if (key < resource.dom.children('div[id!="resource-more"]').length) {
            resource.viewFx(key);
        }
    });
}
//刷新资源
resource.update = function() {
    //锁定
    if (resource.lock === true) {
        message.post('info', '系统繁忙,请稍等片刻...');
        return false;
    }
    resource.lock = true;
    //是否清空数据
    if (resource.isClear === true) {
        resource.data = new Array();
        resource.dom.html('');
        resource.page = 1;
        resource.isClear = false;
    }
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
        //重新设定已选
        resource.select = new Array();
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
                resource.selectDom($(this), 'auto');
                //刷新已选列
                resource.select = new Array();
                resource.dom.children('div[id!="resource-more"][data-select="1"]').each(function(k, v) {
                    resource.select.push(resource.data[$(this).attr('data-key')]['id']);
                });
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
//选择和已选切换
resource.selectDom = function(dom, t) {
    if (t === 'auto') {
        if (dom.attr('data-select') === '1') {
            dom.attr('data-select', '0');
            dom.attr('style', '');
        } else {
            dom.attr('data-select', '1');
            dom.attr('style', 'background-color:#D2E2FF;');
        }
    } else if (t === 'all') {
        dom.attr('data-select', '1');
        dom.attr('style', 'background-color:#D2E2FF;');
    } else if (t === 'reverse') {
        dom.attr('data-select', '0');
        dom.attr('style', '');
    }
}
//查看FX
resource.viewFx = function(key) {
    var t = resource.data[key]['fx_type'];
    if (t === 'folder') {
        resource.setParent(key);
    } else if (resource.isType(t) === 'photo' || resource.isType(t) === 'cartoon') {
        var maxWidth = Math.ceil($('#viewContent').width()) - 20;
        $('#viewContent').html('<img src="img.php?id=' + resource.data[key]['id'] + '" style="max-width:' + maxWidth + 'px;">');
        $('#viewModal').attr('data-key', key);
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
    resource.isClear = true;
    resource.update();
}
/**
 * 获取文件类型属于哪个分类类型下
 * @param string t 文件类型
 * @returns string 分类类型Key
 */
resource.isType = function(t) {
    for (var i = 0; i < info.data['type'].length; i++) {
        for (var j = 0; j < info.data['type'][i]['type'].length; j++) {
            if (info.data['type'][i]['type'][j] === t) {
                return info.data['type'][i]['key'];
            }
        }
    }
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
        resource.isClear = true;
        resource.update();
    });
    //切换到手机模式
    $('#operate-view-phone').click(function() {
        operate.selectMode('phone');
    });
    //切换到普通模式
    $('#operate-view-normal').click(function() {
        operate.selectMode('normal');
    });
    //全选操作
    $('#operate-select-all').click(function() {
        resource.selectDom(resource.dom.children('div[id!="resource-more"]'), 'all');
    });
    //反选操作
    $('#operate-select-reverse').click(function() {
        resource.selectDom(resource.dom.children('div[id!="resource-more"]'), 'reverse');
    });
    //激活编辑文件框架
    $('#operate-edit').click(function() {
        if (resource.select.length === 1) {
            //获取数据
            var d = resource.data[$(resource.dom.children('div[data-select="1"]')).attr('data-key')];
            //写入标题和内容数据
            $('#edit-title').val(d['fx_title']);
            $('#edit-content').val(d['fx_content']);
            //设定所属标签组
            info.editTypeUpdate(info.nowType, info.domEditType.children('span[data-key="' + info.nowTypeKey + '"]'));
            if (d['tags'].length > 0) {
                //如果标签存在
                var tags = new Array();
                for (var i = 0; i < d['tags'].length; i++) {
                }
            }
            //显示框架
            $('#editModal').modal('show');
        } else {
            message.post('error', '只能选择一个文件进行编辑操作！');
        }
    });
    //执行编辑文件
    $('#editButton').click(function() {
        operate.edit();
    });
    //激活删除文件框架
    $('#operate-delete').click(function() {
        $('#delStr').html('');
        if (resource.select.length > 0) {
            var str = '';
            for (var i = 0; i < resource.select.length; i++) {
                str += '<span class="label label-warning">' + resource.select[i] + '</span> ';
            }
            $('#delStr').html(str);
            $('#delModal').modal('show');
        }
    });
    //执行删除文件按钮
    $('#delButton').click(function() {
        operate.del();
    });
    //强制刷新模式
    operate.selectMode('normal');
}
//执行编辑文件
operate.edit = function() {
    if (resource.lock === true) {
        message.post('info', '系统繁忙,请稍等片刻...');
        return false;
    }
    //获取标签
    var tags = new Array();
    $('#edit-tags span[data-select="1"]').each(function(k, v) {
        tags.push($(this).attr('data-id'));
    });
    if (resource.select.length === 1) {
        //和服务器通讯
        ajax.post('edit', {
            'title': $('#edit-title').val(),
            'tags': tags
        }, function(data) {
            resource.lock = false;
            message.postBool(data, '删除成功！', '无法删除文件，请稍后重试！');
            if (data === true) {
                resource.isClear = true;
                resource.update();
                $('#edit-title').val('');
                $('#edit-content').val('');
                $('#edit-tags span').remove();
            }
        });
        //关闭框架
        $('#delModal').modal('hide');
    }
}
//执行删除文件
operate.del = function() {
    if (resource.lock === true) {
        message.post('info', '系统繁忙,请稍等片刻...');
        return false;
    }
    if (resource.select.length > 0) {
        resource.lock = true;
        ajax.post('del', {
            'del': resource.select
        }, function(data) {
            resource.lock = false;
            message.postBool(data, '删除成功！', '无法删除文件，请稍后重试！');
            if (data === true) {
                resource.isClear = true;
                resource.update();
            }
            $('#delModal').modal('hide');
        });
    }
}
//切换模式
operate.selectMode = function(mode) {
    resource.mode = mode;
    operate.dom.children('button[data-mode!="' + mode + '"][data-mode!="all"]').hide();
    operate.dom.children('button[data-mode="' + mode + '"]').show();
    resource.isClear = true;
    resource.update();
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
info.domEditType = $('#edit-type');
info.domEditTag = $('#edit-tags');
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
        label.insertArr(info.domEditType, info.dataType, 'default');
        label.insertSelect(info.domEditTag, info.dataTag[info.nowType], 'default', 'info');
        //插入Key标记
        info.domType.children('span').each(function(k, v) {
            $(this).attr('data-key', k);
        });
        info.domTag.children('span').each(function(k, v) {
            $(this).attr('data-key', k);
        });
        $(info.domEditType).children('span').each(function(k, v) {
            $(this).attr('data-key', k);
        });
        $(info.domEditTag).children('span').each(function(k, v) {
            $(this).attr('data-key', k);
            $(this).attr('data-id', info.data['tag'][info.nowType][k]['id']);
        });
        //修改当前选择类型标记
        info.domType.children('span:eq(' + info.nowTypeKey + ')').attr('class', 'label label-success');
        info.domEditType.children('span:eq(' + info.nowTypeKey + ')').attr('class', 'label label-success');
        //修正当前目录
        resource.parent = info.data['type'][info.nowTypeKey]['folder'];
        //点击分类类型按钮事件
        info.domType.children('span').click(function() {
            info.nowType = info.data['type'][$(this).attr('data-key')]['key'];
            info.nowTypeKey = $(this).attr('data-key');
            label.insertSelect(info.domTag, info.dataTag[info.nowType], 'default', 'info');
            info.domType.children('span[class="label label-success"]').attr('class', 'label label-default');
            $(this).attr('class', 'label label-success');
            //插入key标记
            info.domTag.children('span').each(function(k, v) {
                $(this).attr('data-key', k);
            });
            //修正编辑框架标签组
            info.editTypeUpdate(info.nowType, info.domEditType.children('span[data-key="' + $(this).attr('data-key') + '"]'));
            //修正当前目录
            resource.parent = info.data['type'][$(this).attr('data-key')]['folder'];
            //清空并刷新数据
            resource.isClear = true;
            resource.update();
        });
        //点击编辑分类按钮事件
        info.domEditType.children('span').click(function() {
            var key = info.data['type'][$(this).attr('data-key')]['key'];
            info.editTypeUpdate(key, $(this));
        });
        //关闭屏幕锁定
        message.stopOff();
        //锁定数据
        info.lock = true;
        //初始化按钮组
        operate.start();
    });
}
//向编辑标签组初始化序列
info.editTypeUpdate = function(key, dom) {
    label.insertSelect(info.domEditTag, info.dataTag[key], 'default', 'info');
    info.domEditType.children('span[class="label label-success"]').attr('class', 'label label-default');
    dom.attr('class', 'label label-success');
    //插入key和ID标记
    info.domEditTag.children('span').each(function(k, v) {
        $(this).attr('data-key', k);
        $(this).attr('data-id', info.data['tag'][key][k]['id']);
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
    //初始化资源按钮组
    resource.start();
});