/**
 **
 * 体重中心JS文件
 * @author fotomxq <fotomxq.me>
 * @version 1
 */
//数据操作
var wData = new Object();
//从服务器获取数据
wData.get = function(start, end, func) {
    $.getJSON('action.php', {'type': 'get', 'start': start, 'end': end}, func);
}
//获取区间平均数
wData.interval = function(type, show, func) {
    $.getJSON('action.php', {'type': 'interval', 'i': type, 't': show}, func);
}
//获取最近
wData.day = function(max, func) {
    $.getJSON('action.php', {'type': 'day', 'max': max}, func);
}
//获取本周
wData.week = function(func) {
    $.getJSON('action.php', {'type': 'week'}, func);
}
//向服务器提交数据
wData.set = function(date, weight, fat, note, tagDinner, tagSport, tagSleep, tagToilet, tagSick, tagAlcohol) {
    $.post('action.php?type=set', {
        'date': date,
        'weight': weight,
        'fat': fat,
        'note': note,
        'tagDinner': tagDinner,
        'tagSport': tagSport,
        'tagSleep': tagSleep,
        'tagToilet': tagToilet,
        'tagSick': tagSick,
        'tagAlcohol': tagAlcohol
    }, function(data) {
        if (data == 'true') {
            Messenger().post({message: "设置成功!", type: "success"});
        } else {
            Messenger().post({message: "设置失败!", type: "error"});
        }
    });
}

//图表
var chart = new Object();
//图表对象
chart.handle;
//图表对象2
chart.handle2;
//当前显示类型
chart.showType = 'weight';
//当前显示时间区间
chart.showInterval = 'chartDay';
//获取最近记录的条数
chart.dayMax = 10;
//图表ID
chart.id = $('#weightChart');
//上一次从服务器获取的原始数据
chart.dataServer;
//图表数据
chart.data = {
    labels: ["1"],
    datasets: [
        {
            fillColor: "rgba(151,187,205,0.5)",
            strokeColor: "rgba(151,187,205,1)",
            pointColor: "rgba(151,187,205,1)",
            pointStrokeColor: "#fff",
            data: [0]
        }
    ]
};
//图表设定
chart.options = {		
    scaleOverlay : false,
    scaleOverride : false,
    scaleSteps : null,
    scaleStepWidth : null,
    scaleStartValue : null,
    scaleLineColor : "rgba(0,0,0,.1)",
    scaleLineWidth : 1,
    scaleShowLabels : true,
    scaleLabel : "<%=value%>",
    scaleFontFamily : "'Arial'",
    scaleFontSize : 12,	
    scaleFontStyle : "normal",
    scaleFontColor : "#666",	
    scaleShowGridLines : true,
    scaleGridLineColor : "rgba(0,0,0,.05)",
    scaleGridLineWidth : 1,	
    bezierCurve : true,
    pointDot : true,
    pointDotRadius : 3,
    pointDotStrokeWidth : 1,
    datasetStroke : true,
    datasetStrokeWidth : 2,
    datasetFill : false,
    animation : true,
    animationSteps : 60,
    animationEasing : "easeOutQuart",
    onAnimationComplete : null
};
//初始化
chart.run = function() {
    //获取图表操作对象
    chart.handle = chart.id.get(0).getContext("2d");
    chart.handle2 = new Chart(chart.handle);
    //显示类型
    $('#chartWeight').on('ifChanged', function() {
        chart.showType = 'weight';
        chart.refData();
    });
    $('#chartFat').on('ifChanged', function() {
        chart.showType = 'fat';
        chart.refData();
    });
    //图表显示最近
    $('a[href="#chartDay"]').click(function() {
        chart.selectDay();
    });
    //图表显示周
    $('a[href="#chartWeek"]').click(function() {
        chart.selectWeek();
    });
    //图表显示月
    $('a[href="#chartMonth"]').click(function() {
        chart.selectMonth();
    });
    //图表显示年
    $('a[href="#chartYear"]').click(function() {
        chart.selectYear();
    });
    //选定体重类型
    $('#chartWeight').iCheck('check');
    //初始化图表
    chart.selectDay();
}
//刷新图表数据
chart.ref = function() {
    chart.handle2.Line(chart.data, chart.options);
}
//重新刷新数据显示类型
chart.refData = function() {
    switch (chart.showInterval) {
        case 'chartDay':
            chart.selectDay();
            break;
        case 'chartWeek':
            chart.selectWeek();
            break;
        case 'chartMonth':
            chart.selectMonth();
            break;
        case 'chartYear':
            chart.selectYear();
            break;
    }
}
//获取图表数据
chart.get = function(start, end) {
    chart.data = wData.get(start, end);
}
//图表显示最近
chart.selectDay = function() {
    chart.selectRun('chartDay');
    wData.day(chart.dayMax, function(data) {
        if (data) {
            chart.dataServer = data;
            for (var i = 0; i < data.length; i++) {
                chart.data['labels'][i] = data[i]['weight_date'];
                if (chart.showType == 'weight') {
                    chart.data['datasets'][0]['data'][i] = Math.abs(data[i]['weight_weight']);
                } else {
                    chart.data['datasets'][0]['data'][i] = Math.abs(data[i]['weight_fat']);
                }
            }
        }
        chart.ref();
    });
}
//图表显示周
chart.selectWeek = function() {
    chart.selectRun('chartWeek');
    for (var i = 1; i < 8; i++) {
        chart.data['labels'].push('周' + FtmpDate.chsWeeks[i - 1]);
    }
    var wArr = FtmpDate.getSinceWeek();
    var ws = chart.makeDataArr(wArr[0], wArr[1]);
    wData.week(function(data) {
        chart.dataServer = data;
        for (var i = 0; i < 7; i++) {
            if (data[i]) {
                chart.data['datasets'][0]['data'][i] = data[i]['weight_weight'];
            } else {
                chart.data['datasets'][0]['data'][i] = 0;
            }
        }
        chart.ref();
    });
}
//图表显示月
chart.selectMonth = function() {
    chart.selectRun('chartMonth');
    var wArr = FtmpDate.getSinceMonth(0, 0);
    var monthDay = FtmpDate.getMonthDay(0, 0);
    for (i = 1; i <= monthDay; i++) {
        chart.data['labels'].push(i);
    }
    var ws = chart.makeDataArr(wArr[0], wArr[1]);
    wData.get(FtmpDate.getTime(wArr[0], 'yyyy-mm-dd'), FtmpDate.getTime(wArr[1], 'yyyy-mm-dd'), function(data) {
        chart.dataServer = data;
        chart.makeData(ws, data);
        chart.ref();
    });
}
//图表显示年
chart.selectYear = function() {
    chart.selectRun('chartYear');
    var date = new Date();
    for (var i = 1; i < 13; i++) {
        chart.data['labels'].push(i + '月');
    }
    wData.interval('year', chart.showType, function(data) {
        chart.dataServer = data;
        chart.data['datasets'][0]['data'] = data;
        chart.ref();
    });
}
//生成数据配对组
chart.makeDataArr = function(startTime, endTime) {
    var date = new Date();
    date.setTime(startTime);
    var arr = new Array();
    for (t = startTime; t <= endTime; t += 86400000) {
        arr.push(FtmpDate.getTime(t, 'yyyy-mm-dd'));
    }
    return arr;
}
//初始化相关数据
chart.selectRun = function(w) {
    //初始化按钮组
    $('a[href="#chartDay"]').removeClass('active');
    $('a[href="#chartWeek"]').removeClass('active');
    $('a[href="#chartMonth"]').removeClass('active');
    $('a[href="#chartYear"]').removeClass('active');
    $('a[href="#' + w + '"]').addClass('active');
    chart.showInterval = w;
    //初始化数据
    chart.data['labels'] = new Array();
    chart.data['datasets'][0]['data'] = new Array();
}
//根据时间配对数据，自动留空无效数据
chart.makeData = function(dataArr, data) {
    for (var i = 0; i < dataArr.length; i++) {
        chart.data['datasets'][0]['data'][i] = 0;
    }
    for (var i = 0; i < data.length; i++) {
        for (j = 0; j < dataArr.length; j++) {
            if (data[i]['weight_date'] == dataArr[j]) {
                if (chart.showType == 'weight') {
                    chart.data['datasets'][0]['data'][j] = Math.abs(data[i]['weight_weight']);
                } else {
                    chart.data['datasets'][0]['data'][j] = Math.abs(data[i]['weight_fat']);
                }
            }
        }
    }
}

//设定
var set = new Object();
//日期ID
set.dateID = $('#datetimepicker');
//体重ID
set.weightID = $('#weight');
//体脂ID
set.fatID = $('#fat');
//日志ID
set.noteID = $('#note');
//标签
set.tagDinner = $('#tagDinner');
set.tagSport = $('#tagSport');
set.tagSleep = $('#tagSleep');
set.tagToilet = $('#tagToilet');
set.tagSick = $('#tagSick');
set.tagAlcohol = $('#tagAlcohol');
//初始化设定相关组件
set.run = function() {
    //初始化日期选择
    set.refDate();
    set.dateID.datetimepicker({
        pickerPosition: 'bottom-left',
        todayBtn: true,
        todayHighlight: true,
        autoclose: true,
        minView: 'month',
        endDate: FtmpDate.getTime(0, 'yyyy-mm-dd')
    });
    //如果更改日期，则刷新相关选项
    set.dateID.on('changeDate', function() {
        set.refSet();
    });
    //手动修改值，刷新日期
    set.dateID.blur(function(){
         set.dateID.datetimepicker('update');
    });
    //初始化日期相关按钮
    $('a[href="#setDateRepeat"]').click(function() {
        set.refDate();
        set.dateID.datetimepicker('update');
        set.refSet();
    });
    //初始化icheck组件
    $('input').iCheck({
        labelHover: false,
        cursor: true,
        checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red',
        increaseArea: '20%'
    });
    //刷新选项默认值
    set.refSet();
    //提交信息
    $('a[href="#setDataSubmit"]').click(function() {
        set.submit();
    });
}
//初始化日期
set.refDate = function() {
    set.dateID.val(FtmpDate.getTime(0, 'yyyy-mm-dd'));
};
//刷新选项值
set.refSet = function() {
    var setDate = set.dateID.val();
    set.weightID.val('');
    set.fatID.val('');
    set.noteID.val('');
    set.setCheck(set.tagDinner, false);
    set.setCheck(set.tagSport, false);
    set.setCheck(set.tagSleep, false);
    set.setCheck(set.tagToilet, false);
    set.setCheck(set.tagSick, false);
    set.setCheck(set.tagAlcohol, false);
    wData.get(setDate, '', function(data) {
        if (data) {
            set.weightID.val(data['weight_weight']);
            set.fatID.val(data['weight_fat']);
            set.noteID.val(data['weight_note']);
            set.setCheck(set.tagDinner, data['weight_tag_dinner']);
            set.setCheck(set.tagSport, data['weight_tag_sport']);
            set.setCheck(set.tagSleep, data['weight_tag_sleep']);
            set.setCheck(set.tagToilet, data['weight_tag_toilet']);
            set.setCheck(set.tagSick, data['weight_tag_sick']);
            set.setCheck(set.tagAlcohol, data['weight_tag_alcohol']);
            chart.refData();
        }
    });
}
//设定选定状态
set.setCheck = function(id, bool) {
    if (bool == true || bool == '1') {
        id.iCheck('check');
    } else {
        id.iCheck('uncheck');
    }
}
//选中后的值
set.getCheck = function(id) {
    if (id.prop("checked")) {
        return '1';
    }
    return '';
}
//提交
set.submit = function() {
    var date = set.dateID.val();
    var weight = set.weightID.val();
    if (date && weight) {
        var fat = set.fatID.val();
        var note = set.noteID.val();
        var tagDinner = set.getCheck(set.tagDinner);
        var tagSport = set.getCheck(set.tagSport);
        var tagSleep = set.getCheck(set.tagSleep);
        var tagToilet = set.getCheck(set.tagToilet);
        var tagSick = set.getCheck(set.tagSick);
        var tagAlcohol = set.getCheck(set.tagAlcohol);
        wData.set(date, weight, fat, note, tagDinner, tagSport, tagSleep, tagToilet, tagSick, tagAlcohol);
        Messenger().post({message: "正在提交数据...", type: "info"});
    } else {
        Messenger().post({message: "请设置日期和体重!", type: "error"});
    }
}

//初始化
$(function() {
    //初始化设定组
    set.run();
    //初始化图表
    chart.run();
});