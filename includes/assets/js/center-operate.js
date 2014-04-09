/**
 * 中心设置页面
 * @author fotomxq <fotomxq.me>
 * @version 1
 */
//提交数据封装
var odata = new Object();
//当前用户列表数据
odata.userList;
//当前用户数据
odata.userInfos = new Array();
//当前内存总量
odata.statMemTol;
//当前内存使用量
odata.statMemUse;
//当前CPU使用百分比
odata.statCpuUse;
//当前硬盘总量
odata.statHDTol;
//当前硬盘使用量
odata.statHDUse;
//提交封装
odata.submit = function(type,post,func){
    $.post('action-operate.php?type='+type,post,func,'json');
}
//创建消息封装
odata.message = function(msg,type){
    Messenger().post({message: msg, type: type});
}

//提交网站参数封装
var operateWebSet = new Object();
//提交网站参数
operateWebSet.submit = function(){
    
}

//用户操作封装
var operateUser = new Object();
//当前用户页数
operateUser.listPage = 1;
//当前用户表总页数
operateUser.listMaxPage = 1;
//用户列表DOM-ID
operateUser.tableID = $('#userList tbody');
//用户列表搜索框DOM-ID
operateUser.tableSearchID = $('#userListSearch');
//用户列表操作DOM
operateUser.tableOperateDom = '<div class="btn-group"><a href="#userListView" class="btn btn-default"><span class="glyphicon glyphicon-eye-open"></span></a><a href="#userListEdit" class="btn btn-info"><span class="glyphicon glyphicon-pencil"></span></a><a href="#userListTrash" class="btn btn-warning"><span class="glyphicon glyphicon-trash"></span></a></div>';
//初始化
operateUser.run = function(){
    operateUser.getUserList();
    //搜索按钮
    $('a[href="#userListSearch"]').click(function(){
        operateUser.getUserList();
    });
    //初始化所有icheck
    $('input[type="checkbox"]').iCheck({
        checkboxClass:'icheckbox_flat',
        radioClass: 'iradio_flat'
    });
    //修改用户确认按钮
    $('#modalUserEditAction').click(function(){
        $('#modalUserEdit').modal('hide');
        operateUser.userEdit();
    });
    //删除用户确认按钮
    $('#modalUserDelAction').click(function(){
        $('#modalUserDel').modal('hide');
        operateUser.userDel($('#modalUserDel').data('id'));
    });
    //页码按钮组
    $('#userPageIndex').click(function(){
        if(operateUser.listPage != operateUser.listMaxPage){
            operateUser.listPage = 1;
            operateUser.getUserList();
        }
    });
    $('#userPagePrev').click(function(){
        if(operateUser.listPage > operateUser.listMaxPage){
            operateUser.listPage -= 1;
            operateUser.getUserList();
        }
    });
    $('#userPageNext').click(function(){
        if(operateUser.listPage < operateUser.listMaxPage){
            operateUser.listPage += 1;
            operateUser.getUserList();
        }
    });
    $('#userPageEnd').click(function(){
        if(operateUser.listPage != operateUser.listMaxPage){
            operateUser.listPage = operateUser.listMaxPage;
            operateUser.getUserList();
        }
    });
}
//获取用户列表
operateUser.getUserList = function(){
    operateUser.tableID.children('tr').unbind();
    operateUser.tableID.html('');
    //设定页数
    odata.submit('user-list-max-page',{'search':operateUser.tableSearchID.val()},function(data){
        if(data){
            operateUser.listMaxPage = data;
            $('#userPageCount').html(operateUser.listPage+' / '+data);
            if(operateUser.listMaxPage < 2 || operateUser.listPage == operateUser.listMaxPage){
                $('#userPageEnd').attr('disabled','disabled');
                $('#userPageNext').attr('disabled','disabled');
            }else{
                $('#userPageEnd').removeAttr('disabled');
                $('#userPageNext').removeAttr('disabled');
            }
            if(operateUser.listPage < 2){
                $('#userPageIndex').attr('disabled','disabled');
                $('#userPagePrev').attr('disabled','disabled');
            }else{
                $('#userPageIndex').removeAttr('disabled');
                $('#userPagePrev').removeAttr('disabled');
            }
        }
    });
    //设定内容
    odata.submit('user-list',{'page':operateUser.listPage,'search':operateUser.tableSearchID.val()},function(data){
        odata.userList = data;
        if(data){
            //遍历所有数据
            for(var i=0;i<data.length;i++){
                var isself = '';
                if(data['id']==operateUser.tableID.attr('user-id')){
                    isself = ' <span class="label label-info">你自己</span>';
                }
                operateUser.tableID.append('<tr><td>'+data[i]['id']+'</td><td>'+data[i]['user_login']+isself+'</td><td>'+data[i]['user_nicename']+'</td><td>'+data[i]['user_date']+'</td><td>'+data[i]['user_ip']+'</td><td>'+operateUser.tableOperateDom+'</td></tr>');
                operateUser.tableID.children('tr:last').data('data',data[i]);
                operateUser.tableID.children('tr').children('td:last').children().fadeTo('fast',0.1);
            }
            //TR特效
            operateUser.tableID.children('tr').hover(function(){
                $(this).addClass('active');
                $(this).children('td:last').children().stop();
                $(this).children('td:last').children().fadeTo('fast',1);
            },function(){
                if($(this).attr('selected') != 'selected'){
                    $(this).removeClass('active');
                }
                $(this).children('td:last').children().stop();
                $(this).children('td:last').children().fadeTo('fast',0.1);
            });
            //选定TR
            operateUser.tableID.children('tr').click(function(){
                if($(this).attr('selected') == 'selected'){
                    $(this).removeAttr('selected');
                    $(this).removeClass('active');
                }else{
                    $(this).attr('selected','selected');
                    $(this).addClass('active');
                }
            });
            //查看用户信息
            $('a[href="#userListView"]').click(function(){
                operateUser.getUserInfo($(this).parent().parent().parent().data('data')['id'],this,function(data){
                    html = '<p>用户ID : '+data['id']+'</p><p>用户名 : '+data['user_login']+'</p>';
                    html += '<p>权限 : ' + data['infosArr']['power'].join(',') + '</p>';
                    html += '<p>应用 : ' + data['infosArr']['app'].join(',') + '</p>';
                    $('#modalUserView').find('div[class="modal-body"]').html(html);
                    $('#modalUserView').data('id',data['id']);
                    $('#modalUserView').modal('show');
                });
            });
            //编辑用户
            $('a[href="#userListEdit"]').click(function(){
                operateUser.getUserInfo($(this).parent().parent().parent().data('data')['id'],this,function(data){
                    $('#inputModalEditUserNicename').val(data['user_nicename']);
                    $('#inputModalEditUserLogin').val(data['user_login']);
                    $('#modalUserEdit').data('id',data['id']);
                    $('#modalUserEdit').modal('show');
                });
            });
            //删除用户
            $('a[href="#userListTrash"]').click(function(){
                $('#modalUserDel').data('id',$(this).parent().parent().parent().data('data')['id']);
                $('#modalUserDel').modal('show');
            });
        }
    });
}
//获取用户信息
operateUser.getUserInfo = function(userID,dom,func){
    if(odata.userInfos['id'+userID]){
        func(odata.userInfos['id'+userID]);
    }else{
        odata.submit('user-info',{'id':userID},function(data){
            if(data){
                var contentInfos = new Array();
                contentInfos['power'] = new Array();
                contentInfos['app'] = new Array();
                if(data['infos']){
                    for(var i=0;i<data['infos'].length;i++){
                        switch(data['infos'][i]['meta_name']){
                            case 'POWER':
                                contentInfos['power'].push(data['infos'][i]['meta_value']);
                                break;
                            case 'APP':
                                contentInfos['app'].push(data['infos'][i]['meta_value']);
                                break;
                        }
                    }
                }
                data['infosArr'] = contentInfos;
                odata.userInfos['id'+userID] = data;
                func(data);
            }
        });
    }
}
//添加新的用户
operateUser.userAdd = function(){
    
}
//编辑用户信息
operateUser.userEditInfo = function(){
    
}
//编辑用户元数据
operateUser.userEditMeta = function(){
    
}
//删除元数据
operateUser.userDelMeta = function(){
    
}
//删除用户
operateUser.userDel = function(userID){
    odata.submit('user-del',{'id':userID},function(data){
        if(data == '1'){
            odata.message('删除成功!','success');
        }else if(data == '2'){
            odata.message('删除失败!','error');
        }else{
            odata.message('不能删除你自己!','error');
        }
    });
}

//统计封装
var stat = new Object();
//内存保存统计个数
stat.memNum;
//CPU保存统计个数
stat.cpuNum;
//内存列
stat.memList;
//CPU列
stat.cpuList;
//刷新所有图表
stat.ref = function(){
    
}

$(function(){
    operateUser.run();
});