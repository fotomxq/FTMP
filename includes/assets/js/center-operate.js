/**
 * 中心设置页面
 * @author fotomxq <fotomxq.me>
 * @version 2
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
    //添加用户按钮
    $('a[href="#userAdd"]').click(function(){
        $('#modalUserAdd').modal('show');
    });
    //添加用户确认按钮
    $('#modalUserAddAction').click(function(){
        $('#modalUserAdd').modal('hide');
        operateUser.userAdd();
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
    //批量删除按钮
    $('a[href="#userListDelAction"]').click(function(){
        var idList = new Array();
        operateUser.tableID.children('tr[selected="selected"]').each(function(i,n){
            idList.push($(this).children('td:first').html());
        });
        $('#modalUserDel').data('id',idList);
        $('#modalUserDel').modal('show');
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
                if(data[i]['id'] == $('#userList').attr('user-id')){
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
                if(operateUser.tableID.children('tr[selected="selected"]').length > 0){
                    $('a[href="#userListDelAction"]').removeClass('disabled');
                }else{
                    $('a[href="#userListDelAction"]').addClass('disabled');
                }
            });
            //查看用户信息
            $('a[href="#userListView"]').click(function(){
                operateUser.getUserInfo($(this).parent().parent().parent().data('data')['id'],this,function(data){
                    html = '<p>用户ID : '+data['id']+'</p><p>用户名 : '+data['user_login']+'</p>';
                    html += '<p>权限 : ' + data['infosArr']['power'].join('|') + '</p>';
                    html += '<p>应用 : ' + data['infosArr']['app'].join('|') + '</p>';
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
                    for(var i=0;i<data['infosArr']['power'].length;i++){
                        $('input[name="modalEditPowers[]"][data-value="'+data['infosArr']['power'][i]+'"]').iCheck('check');
                    }
                    for(var i=0;i<data['infosArr']['app'].length;i++){
                        $('input[name="modalEditApps[]"][data-value="'+data['infosArr']['app'][i]+'"]').iCheck('check');
                    }
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
                if(data['infos']){
                    data['infosArr'] = new Array();
                    for(var i=0;i<data['infos'].length;i++){
                        if(data['infos'][i]['meta_name'] == $('#contentUser').attr('data-power-meta-name')){
                            data['infosArr']['power'] = data['infos'][i]['meta_value'].split('|');
                        }
                        if(data['infos'][i]['meta_name'] == $('#contentUser').attr('data-app-meta-name')){
                            data['infosArr']['app'] = data['infos'][i]['meta_value'].split('|');
                        }
                    }
                }
                odata.userInfos['id'+userID] = data;
                func(data);
            }
        });
    }
}
//添加新的用户
operateUser.userAdd = function(){
    //获取数据
    var addPowers = new Array();
    var addApps = new Array();
    $('input[name="modalAddPowers[]"]').each(function(i,dom){
        if($(dom).prop("checked")){
            addPowers.push($(this).attr('data-value'));
        }
    });
    $('input[name="modalAddApps[]"]').each(function(i,dom){
        if($(dom).prop("checked")){
            addApps.push($(this).attr('data-value'));
        }
    });
    //提交数据
    odata.submit('user-add',{
        'nicename':$('#inputModalAddUserNicename').val(),
        'login':$('#inputModalAddUserLogin').val(),
        'passwd':$('#inputModalAddUserPasswd').val(),
        'powers':addPowers,
        'app':addApps
    },function(data){
        if(data == '1'){
            //移除内容
            $('#inputModalAddUserNicename').val('');
            $('#inputModalAddUserLogin').val('');
            $('#inputModalAddUserPasswd').val('');
            $('input[name="modalAddPowers[]"]').each(function(i,dom){
                $(dom).iCheck('uncheck');
            });
            $('input[name="modalAddApps[]"]').each(function(i,dom){
                $(dom).iCheck('uncheck');
            });
            odata.message('添加成功!','success');
            operateUser.getUserList();
        }else{
            odata.message('添加失败，请重新确认相关选项!','error');
        }
    });
}
//编辑用户信息
operateUser.userEdit = function(){
    //获取数据
    var editPowers = new Array();
    var editApps = new Array();
    $('input[name="modalEditPowers[]"]').each(function(i,dom){
        if($(dom).prop("checked")){
            editPowers.push($(this).attr('data-value'));
        }
    });
    $('input[name="modalEditApps[]"]').each(function(i,dom){
        if($(dom).prop("checked")){
            editApps.push($(this).attr('data-value'));
        }
    });
    //提交数据
    odata.submit('user-edit',{
        'id':$('#modalUserEdit').data('id'),
        'nicename':$('#inputModalEditUserNicename').val(),
        'login':$('#inputModalEditUserLogin').val(),
        'passwd':$('#inputModalEditUserPasswd').val(),
        'powers':editPowers,
        'app':editApps
    },function(data){
        if(data == '1'){
            odata.message('修改成功!','success');
            odata.userInfos['id'+$('#modalUserEdit').data('id')] = false;
        }else{
            odata.message('修改失败!','error');
        }
    });
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
        operateUser.getUserList();
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