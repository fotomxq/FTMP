//全局
//图表对象
var ctx;
//图表数据
var weightData = {
					labels : ["1"],
					datasets : [
						{
							fillColor : "rgba(151,187,205,0.5)",
							strokeColor : "rgba(151,187,205,1)",
							pointColor : "rgba(151,187,205,1)",
							pointStrokeColor : "#fff",
							data : [0]
						}
					]
				};

//获取数据模块
function getData(start,end){
	$.getJSON('action.php',{'type':'get','start':start,'end':end},function(data){
		weightData = data;
	});
}

//初始化图表
function makeChart(){
	var weightChart = new Chart(ctx).Line(weightData,{});
}

//初始化
$(function(){
	var weightWidth = $(document).width();
	$('#weightChart').width(weightWidth);
	ctx = $("#weightChart").get(0).getContext("2d");
	//图表显示周
	$('a[href="#chartWeek"]').click(function(){
		var day = new Date();
	});
	//图表显示月
	$('a[href="#chartMonth"]').click(function(){
		var day = new Date();
		var day2 = new Date(day.getFullYear(),day.getMonth(),0);
		var monthDay = day2.getDate();
		
	});
	//图表显示三月
	$('a[href="#chartMonth3"]').click(function(){
		var day = new Date();
	});
	//图表显示年
	$('a[href="#chartYear"]').click(function(){
		var day = new Date();
	});
	//初始化图表
	makeChart(weightData);
});