//初始化
$(function(){
    //修正页面内展示框高度和宽度
    var h = $('div[class="site-wrapper"]').height()-200;
    $('div[class="pex-content-list"]').css('height',h+'px');
    var w = $('body').width();
    if(w > 700){
        $('div[class="pex-content-list"]').css('width','700px');
    }else{
        $('div[class="pex-content-list"]').css('width',w+'px');
    }
});