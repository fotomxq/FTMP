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
//剪切的文件列
resource.selectCut = new Array();
//剪切原所属目录
resource.cutParent = 0;
//是否清空数据
resource.isClear = true;
//等待转移文件序列
resource.releaseFileList = new Array();
//当前模式
resource.mode = 'normal';
//原始数据
resource.data = new Array();
//联合筛选标记
resource.searchOr = 1;
//上级列队
resource.parentList = new Array();
resource.parentPageList = new Array();
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
    //发布文件
    $('a[href="#release"]').click(function() {
        //是否锁定
        if (resource.lock === true) {
            message.post('info', '系统繁忙,请稍等片刻...');
            return false;
        }
        if ($('#release-type').html() === '') {
            //初始化
            $('#release-title').val('');
            $('#release-content').val('');
            info.insertTypeTag($('#release-type'), $('#release-tags'), info.nowTypeKey, null);
            var optionSave = new Array('在该目录下以标题建立目录', '');
            label.insertSelect($('#release-option-save'), optionSave, 'default', 'primary');
            $('#release-option-save').children('span').attr('data-select', '1');
            $('#release-option-save').children('span').attr('class', 'label label-primary');
        }
        //显示框架
        $('#releaseModal').modal('show');
        if (resource.releaseFileList.length < 1) {
            //加载待转移文件
            $('#release-ready-list').html('正在加载文件...');
            //锁定
            resource.lock = true;
            //和服务器通讯
            ajax.post('release-ready-list', {}, function(data) {
                resource.lock = false;
                if (!data) {
                    resource.releaseFileList = new Array();
                    $('#release-ready-list').html('');
                    message.post('info', '没有文件可以转移，请先通过FTP上传文件到content/pex/transfer目录！');
                    $('#releaseModal').modal('hide');
                } else {
                    resource.releaseFileList = data;
                    label.insertArr($('#release-ready-list'), data, 'default');
                }
            });
        }
    });
    //执行发布文件
    $('#release-button').click(function() {
        resource.release();
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
    //开启屏幕锁定
    message.stop('稍等，正在加载数据...');
    //是否清空数据
    if (resource.isClear === true) {
        resource.data = new Array();
        resource.dom.html('');
        resource.page = 1;
        resource.isClear = false;
    }
    //获取标签
    var tags = info.getSelectTag(info.domTag);
    //与服务器通讯
    ajax.post('resource', {
        'parent': resource.parent,
        'tags': tags,
        'page': resource.page,
        'max': resource.max,
        'sort': resource.sort,
        'desc': resource.desc,
        'or':resource.searchOr
    }, function(data) {
        //解除锁定
        resource.lock = false;
        message.stopOff();
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
            resource.dom.append('<div class="resource-' + resource.mode + '" data-key="' + newK + '" data-type="' + v['fx_type'] + '" data-select="0"><img src="img.php?id=' + v['id'] + '" class="img-rounded"><p>' + v['fx_title'] + '</p></div>');
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
//发布文件
resource.release = function() {
    //是否锁定
    if (resource.lock === true) {
        message.post('info', '系统繁忙,请稍等片刻...');
        return false;
    }
    //过滤参数
    var releaseParent = resource.parent;
    var releaseTitle = $('#release-title').val();
    var releaseContent = $('#release-content').val();
    var releaseTags = info.getSelectTag($('#release-tags'));
    var releaseOptionSave = $('#release-option-save span').attr('data-select');
    if (releaseTitle === '' || releaseTags.length < 1 || releaseParent < 1) {
        message.post('error', '请输入标题，并至少选择一个标签。');
        return false;
    }
    //锁定
    resource.lock = true;
    //与服务器通讯
    ajax.post('release', {
        'parent': releaseParent,
        'title': releaseTitle,
        'content': releaseContent,
        'tags': releaseTags,
        'option-save': releaseOptionSave
    }, function(data) {
        resource.lock = false;
        message.postBool(data, '发布成功！', '无法发布，请稍后重试！');
        if (data === true) {
            $('#release-type').html('');
            resource.releaseFileList = new Array();
            resource.isClear = true;
            resource.update();
        }
        $('#releaseModal').modal('hide');
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
    resource.parentList.push(resource.parent);
    resource.parentPageList.push(resource.page);
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
        if (info.data['type'][i]['type']) {
            for (var j = 0; j < info.data['type'][i]['type'].length; j++) {
                if (info.data['type'][i]['type'][j] === t) {
                    return info.data['type'][i]['key'];
                }
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
    //返回上一级
    $('#operate-return').click(function() {
        if (resource.parentList.length > 0) {
            resource.parent = resource.parentList[resource.parentList.length - 1];
            resource.parentList.pop();
            resource.page = resource.parentPageList[resource.parentPageList.length - 1];
            resource.parentPageList.pop();
            resource.data = new Array();
            resource.dom.html('');
            resource.update();
        }
    });
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
        resource.searchOr = 1;
        resource.isClear = true;
        resource.update();
    });
    //联合筛选
    $('#operate-search-and').click(function(){
        resource.searchOr = 0;
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
    //添加文件夹
    $('#operate-add-folder').click(function() {
        $('#add-folder-title').val('');
        $('#add-folder-content').val('');
        info.insertTypeTag($('#add-folder-type'), $('#add-folder-tags'), 0, null);
        $('#addFolderModal').modal('show');
    });
    //执行添加文件夹
    $('#add-folder-button').click(function() {
        operate.addFolder();
    });
    //全选操作
    $('#operate-select-all').click(function() {
        resource.selectDom(resource.dom.children('div[id!="resource-more"]'), 'all');
    });
    //反选操作
    $('#operate-select-reverse').click(function() {
        var nowSelectDom = resource.dom.children('div[id!="resource-more"][data-select="1"]');
        var nowUnSelectDom = resource.dom.children('div[id!="resource-more"][data-select="0"]');
        resource.selectDom(nowSelectDom, 'reverse');
        resource.selectDom(nowUnSelectDom, 'all');
    });
    //剪切操作
    $('#operate-cut').click(function() {
        if (resource.select.length > 0) {
            resource.selectCut = resource.select;
            resource.cutParent = resource.parent;
            message.post('info', '剪切就绪，请进入相应的文件夹粘贴即可。');
            $('#operate-cut-cancel').show();
            $('#operate-paste').show();
        } else {
            message.post('error', '请先选择文件或文件夹再试！');
        }
    });
    //取消剪切操作
    $('#operate-cut-cancel').click(function() {
        resource.selectCut = new Array();
        resource.cutParent = 0;
        message.post('info', '已取消剪切或复制的文件或文件夹。');
        $('#operate-cut-cancel').hide();
        $('#operate-paste').hide();
    });
    //粘贴操作
    $('#operate-paste').click(function() {
        //是否无剪切内容。此部分内容基本不能出现，否则是逻辑严重异常
        if (resource.selectCut.length < 1) {
            return false;
        }
        //检查剪切到位置是否没有改变
        if (resource.cutParent === resource.parent && resource.cutParent > 0) {
            message.post('error', '无法完成剪切/粘贴，文件位置没有任何改变，请选择其他文件夹再试！');
            return false;
        }
        //和服务器通讯
        ajax.post('cut', {
            'select': resource.selectCut,
            'parent': resource.parent
        }, function(data) {
            message.postBool(data, '粘贴成功！', '无法粘贴文件，请稍后重试！');
            if (data === true) {
                resource.isClear = true;
                resource.update();
                $('#operate-cut-cancel').hide();
                $('#operate-paste').hide();
            }
        });
    });
    //隐藏取消剪切和粘贴按钮
    $('#operate-cut-cancel').hide();
    $('#operate-paste').hide();
    //激活编辑文件框架
    $('#operate-edit').click(function() {
        if (resource.select.length === 1) {
            //获取数据
            var d = resource.data[$(resource.dom.children('div[data-select="1"]')).attr('data-key')];
            //写入标题和内容数据
            $('#editModal').attr('data-id', d['id'])
            $('#edit-title').val(d['fx_title']);
            $('#edit-content').val(d['fx_content']);
            //获取标签组
            var tags = new Array();
            if (d['tags']) {
                for (var i = 0; i < d['tags'].length; i++) {
                    tags.push(d['tags'][i]['tag_id']);
                }
            }
            //设定所属标签组
            info.insertTypeTag(info.domEditType, info.domEditTag, info.nowTypeKey, tags);
            //显示框架
            $('#editModal').modal('show');
        } else {
            message.post('error', '只能选择一个文件进行编辑操作！');
        }
    });
    //执行编辑文件
    $('#edit-button').click(function() {
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
    //设定操作
    $('a[href="#set"]').click(function() {
        for (var i = 0; i < info.dataTypeKey.length; i++) {
            var key = info.dataTypeKey[i];
            var dom = $('#set-tag-' + key);
            var val = '';
            if (info.data['tag'][key]) {
                for (var j = 0; j < info.data['tag'][key].length; j++) {
                    val += info.data['tag'][key][j]['tag_name'] + '|';
                }
                val = val.slice(0, -1);
            }
            dom.val(val);
        }
        ajax.post('set-load', {}, function(data) {
            if (!data) {
                message.post('error', '服务器异常，无法获取设定信息！');
                return false;
            }
            label.insertSelectOnly($('#set-sort'), data['fx-fields'], data['sort'], 'default', 'info');
            label.insertSelectOnly($('#set-desc'), new Array('否', '是'), data['desc'], 'default', 'info');
        });
        $('#setModal').modal('show');
    });
    //执行设定操作
    $('#set-button').click(function() {
        operate.set();
    });
    //强制刷新模式
    operate.selectMode('normal');
}
//执行设定操作
operate.set = function() {
    //获取并过滤参数
    var setPasswd = $('#set-passwd').val();
    var setSort = Math.abs($('#set-sort').children('span[data-select="1"]').attr('data-key')) + 1;
    var setDesc = Math.abs($('#set-desc').children('span[data-select="1"]').attr('data-key')) + 1;
    var setTags = {};
    for (var i = 0; i < info.dataTypeKey.length; i++) {
        setTags[info.dataTypeKey[i]] = $('#set-tag-' + info.dataTypeKey[i]).val();
    }
    //与服务器通讯
    ajax.post('set-save', {
        'set-passwd': setPasswd,
        'set-sort': setSort,
        'set-desc': setDesc,
        'set-tags': setTags
    }, function(data) {
        message.postBool(data, '设定保存成功！', '无法修改设定，请稍后再试！');
        if (data === true) {
            location.href = 'index.php';
        }
    });
}
//执行编辑文件
operate.edit = function() {
    if (resource.lock === true) {
        message.post('info', '系统繁忙,请稍等片刻...');
        return false;
    }
    //获取标签
    var tags = info.getSelectTag($('#edit-tags'));
    if (resource.select.length === 1) {
        //获取参数
        var editID = $('#editModal').attr('data-id');
        var editTitle = $('#edit-title').val();
        var editContent = $('#edit-content').val();
        //过滤参数
        if (!editID || !editTitle || !tags) {
            message.post('error', '请填写文件标题，并最少选择一个标签。');
            return false;
        }
        //和服务器通讯
        ajax.post('edit', {
            'id': editID,
            'title': editTitle,
            'content': editContent,
            'tags': tags
        }, function(data) {
            resource.lock = false;
            message.postBool(data, '修改成功！', '无法修改文件信息，请稍后重试！');
            if (data === true) {
                resource.isClear = true;
                resource.update();
                $('#edit-title').val('');
                $('#edit-content').val('');
                $('#edit-tags span').remove();
                $('#editModal').modal('hide');
            }
        });
        //关闭框架
        $('#delModal').modal('hide');
    }
}
//添加文件夹
operate.addFolder = function() {
    if (resource.lock === true) {
        message.post('info', '系统繁忙,请稍等片刻...');
        return false;
    }
    var parent = resource.parent;
    var addFolderTitle = $('#add-folder-title').val();
    var addFolderContent = $('#add-folder-content').val();
    var tags = info.getSelectTag($('#add-folder-tags'));
    if (parent < 1 || addFolderTitle === '' || tags.length < 1) {
        message('error', '请输入标题，并至少选择一个标签。');
        return false;
    }
    resource.lock = true;
    ajax.post('add-folder', {
        'parent': parent,
        'title': addFolderTitle,
        'content': addFolderContent,
        'tags': tags
    }, function(data) {
        resource.lock = false;
        message.postBool(data, '创建文件夹成功！', '无法创建文件夹，请稍后重试！');
        if (data === true) {
            resource.isClear = true;
            resource.update();
            $('#addFolderModal').modal('hide');
        }
    });
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
    operate.dom.children('[data-mode!="' + mode + '"][data-mode!="all"]').hide();
    operate.dom.children('[data-mode="' + mode + '"]').show();
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
info.dataTypeKey = new Array();
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
                info.dataTypeKey.push(data['type'][i]['key']);
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
        //修正排序规则
        resource.sort = data['sort'];
        resource.desc = data['desc'];
        //修正当前目录
        resource.parent = info.data['type'][info.nowTypeKey]['folder'];
        //创建显示数据
        info.insertTypeTag(info.domType, info.domTag, info.nowTypeKey, null)
        //点击分类类型按钮事件
        info.domType.children('span').click(function() {
            info.nowType = info.data['type'][$(this).attr('data-key')]['key'];
            info.nowTypeKey = $(this).attr('data-key');
            //修正当前目录
            resource.parent = info.data['type'][$(this).attr('data-key')]['folder'];
            resource.parentList = new Array();
            resource.parentList.push(resource.parent);
            resource.parentPageList = new Array();
            resource.parentPageList.push(1);
            //清空并刷新数据
            resource.isClear = true;
            resource.update();
        });
        resource.parentList.push(resource.parent);
        resource.parentPageList.push(1);
        //关闭屏幕锁定
        message.stopOff();
        //锁定数据
        info.lock = true;
        //初始化按钮组
        operate.start();
    });
}
/**
 * 向指定DOM添加标签序列
 * @param DOM typeDom 插入类型Dom
 * @param DOM tagDom 插入标签Dom
 * @param int selectType 正在选择的类型Key
 * @param array selectTags 已选择的标签列
 */
info.insertTypeTag = function(typeDom, tagDom, selectType, selectTags) {
    typeDom.html('');
    label.insertSelect(typeDom, info.dataType, 'default', 'info');
    typeDom.children('span').each(function(k, v) {
        $(this).attr('data-key', k);
    });
    typeDom.children('span[data-key="' + selectType + '"]').attr('data-select', '1');
    typeDom.children('span[data-key="' + selectType + '"]').attr('class', 'label label-info');
    info.insertTag(tagDom, selectType, selectTags);
    typeDom.children('span').click(function() {
        typeDom.children('span').attr('data-select', '0');
        typeDom.children('span').attr('class', 'label label-default');
        $(this).attr('data-select', '1');
        $(this).attr('class', 'label label-info');
        info.insertTag(tagDom, $(this).attr('data-key'), selectTags);
    });
}
/**
 * 向指定DOM添加标签序列
 * @param DOM dom 插入Dom
 * @param int t 类型Key
 * @param array selectTag 正在选择的标签ID组
 */
info.insertTag = function(dom, t, selectTag) {
    dom.html('');
    var key = info.data['type'][t]['key'];
    label.insertSelect(dom, info.dataTag[key], 'default', 'info');
    dom.children('span').each(function(k, v) {
        $(this).attr('data-key', k);
        $(this).attr('data-id', info.data['tag'][key][k]['id']);
    });
    if (selectTag) {
        for (var i = 0; i < selectTag.length; i++) {
            dom.children('span[data-id="' + selectTag[i] + '"]').attr('data-select', '1');
            dom.children('span[data-id="' + selectTag[i] + '"]').attr('class', 'label label-info');
        }
    }
}
/**
 * 获取Dom下已选标签ID
 * @param DOM dom Dom
 * @returns array ID数组
 */
info.getSelectTag = function(dom) {
    var tag = new Array();
    dom.children('span[data-select="1"]').each(function(k, v) {
        tag.push($(this).attr('data-id'));
    });
    return tag;
}
/**
 * 获取DOM下已选标签KEY
 * @param DOM dom DOM
 * @returns array key数组
 */
info.getSelect = function(dom) {
    var arr = new Array();
    dom.children('span[data-select="1"]').each(function(k, v) {
        arr.push($(this).attr('data-key'));
    });
    return arr;
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