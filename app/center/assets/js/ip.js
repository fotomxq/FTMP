/**
 * IP页面操作
 */
//ip处理器
var ip = new Object;
//页设定
ip.page = 1;
ip.max = 10;
ip.sort = 0;
ip.desc = 0;
//最大页数
ip.maxPage = 0;
//联合锁定
ip.lock = false;
//重新加载锁定
ip.dataLock = false;
//IP列DOM名称
ip.listDom = '#ip-list';
//初始化IP
ip.start = function() {
    //加载数据
    ip.load();
    //切换页按钮组
    $('a[href="#page-prev"]').click(function() {
        ip.setPage(-1);
    });
    $('a[href="#page-next"]').click(function() {
        ip.setPage(1);
    });
    $('a[href="#page-index"]').click(function() {
        ip.setPage(-9999);
    });
    $('a[href="#page-end"]').click(function() {
        ip.setPage(ip.maxPage);
    });
    //点击栏目修改排序
    $('#center-content').find('th').click(function() {
        if ($(this).attr('data-key')) {
            ip.setSort($(this).attr('data-key') - 1);
        }
    });
}
//加载数据
ip.load = function() {
    if (ip.lock === true) {
        return false;
    }
    ip.lock = true;
    ajax.post('list', {
        'page': ip.page,
        'max': ip.max,
        'sort': ip.sort,
        'desc': ip.desc
    }, function(data) {
        $(ip.listDom).html('');
        ip.lock = false;
        if (!data) {
            return false;
        }
        ip.dataLock = true;
        //添加到列表
        for (var i = 0; i < data.length; i++) {
            var ban;
            if (data[i]['ip_ban'] === '0') {
                ban = '<td>允许</td>';
            } else {
                ban = '<td class="warning">禁止</td>';
            }
            $(ip.listDom).append('<tr><td>' + data[i]['id'] + '</td><td>' + data[i]['ip_addr'] + '</td><td>' + data[i]['ip_real'] + '</td>' + ban + '<td><button type="button" class="btn btn-default" name="real">真实地址</button> <button type="button" class="btn btn-default" name="ban">拉黑</button></td></tr>');
        }
        //修正最大页数
        ip.maxPage = Math.ceil(data[0]['max'] / ip.max);
        $('#page-show').html(ip.page + ' / ' + ip.maxPage);
        //给行添加动态效果
        $(ip.listDom + ' tr').hover(function() {
            $(ip.listDom + ' button[class="btn btn-info"]').attr('class', 'btn btn-default');
            $(ip.listDom + ' button[class="btn btn-warning"]').attr('class', 'btn btn-default');
            $(this).find('button[name="real"]').attr('class', 'btn btn-info');
            $(this).find('button[name="ban"]').attr('class', 'btn btn-warning');
        }, function() {
            $(this).find('button[name="real"]').attr('class', 'btn btn-default');
            $(this).find('button[name="ban"]').attr('class', 'btn btn-default');
        });
        //给按钮添加事件
        $(ip.listDom + ' button[name="real"]').click(function() {
            var id = $(this).parent().parent().children('td:eq(0)').html();
            if (!$(this).parent().parent().children('td:eq(2)').html()) {
                ip.setReal(id, '');
            }
        });
        $(ip.listDom + ' button[name="ban"]').click(function() {
            var id = $(this).parent().parent().children('td:eq(0)').html();
            var banStr = $(this).parent().parent().children('td:eq(3)').html();
            var bool = 1;
            if (banStr === '禁止') {
                bool = 0;
            }
            ip.setBan(id, bool);
        });
    });
}
//设定排序
ip.setSort = function(key) {
    if (ip.desc === 0) {
        ip.desc = 1;
    } else {
        ip.desc = 0;
    }
    ip.sort = key;
    ip.page = 1;
    ip.dataLock = false;
    ip.load();
}
//切换页面
ip.setPage = function(p) {
    ip.page = ip.page + p;
    if (ip.page < 1) {
        ip.page = 1;
    }
    if (ip.page > ip.maxPage) {
        ip.page = ip.maxPage;
    }
    ip.dataLock = false;
    ip.load();
}
//设定拉黑
ip.setBan = function(id, bool) {
    ajax.post('set-ban', {
        'id': id,
        'bool': bool
    }, function(data) {
        message.postBool(data, '设定成功!', '设定失败!');
        if (data === true) {
            ip.dataLock = false;
            ip.load();
        }
    });
}
//获取真实地址
ip.setReal = function(id, real) {
    ajax.post('set-real', {
        'id': id,
        'real': real
    }, function(data) {
        message.postBool(data, '获取真实物理地址成功!', '获取真实物理地址失败!');
        if (data === true) {
            ip.dataLock = false;
            ip.load();
        }
    });
}

//初始化
$(function() {
    //修改ajax方法URL
    ajax.url = 'action-ip.php';
    //初始化消息框架
    message.start();
    //初始化IP
    ip.start();
});