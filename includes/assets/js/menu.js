/**
 * 通用菜单定义
 * @author fotomxq <fotomxq.me>
 * @version 1
 */
$(function(){
    //保存初始化菜单选择
    $('div[class="collapse navbar-collapse"] ul li').each(function(i,dom){
        if($(dom).attr('class') == 'active'){
            $(dom).parent('ul').data('active',i);
        }
    });
    //菜单鼠标特效
    $('div[class="collapse navbar-collapse"] ul li').hover(function(){
        $(this).addClass('active');
    },function(){
        $(this).removeClass('active');
        $(this).parent().parent().find('li:eq('+$(this).parent().data('active')+')').addClass('active');
    });
    //单击菜单效果
    $('div[class="collapse navbar-collapse"] ul li').click(function(){
        $(this).parent().parent().find('li:eq('+$(this).parent().data('active')+')').removeClass('active');
        $(this).parent().data('active',$(this).index());
        $(this).addClass('active');
        if(menuHide){
            for(var i=0;i<menuHide[0].length;i++){
                if($(this).children('a').attr('href')==menuHide[0][i][0]){
                    $(menuHide[0][i][1]).fadeIn('normal');
                }else{
                    $(menuHide[0][i][1]).hide();
                }
            }
        }
    });
});