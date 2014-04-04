/**
 * FTMP-Date时间处理器
 * @author fotomxq <fotomxq.me>
 * @verson 1
 */
var FtmpDate = new Object();

//中文数字
FtmpDate.chs = ['零','一','二','三','四','五','六','七','八','九','十'];
//中文周数字
FtmpDate.chsWeeks = ['一','二','三','四','五','六','日'];

/**
 * 按照设定的格式获取时间
 * @param  int time 给定的时间戳，如果为0表明为当前时间
 * @param  string format 格式，yyyy-mm-dd hh-ii-ss ll
 * @return string        返回时间
 */
FtmpDate.getTime = function(time,format){
	var date = new Date();
	if(time > 0){
		date.setTime(time);
	}
	var str = format.replace('yyyy',date.getFullYear());
	str = str.replace('mm',FtmpDate.getTimeZ(date.getMonth()+1));
	str = str.replace('dd',FtmpDate.getTimeZ(date.getDate()));
	str = str.replace('hh',FtmpDate.getTimeZ(date.getHours()));
	str = str.replace('ii',FtmpDate.getTimeZ(date.getMinutes()));
	str = str.replace('ss',FtmpDate.getTimeZ(date.getSeconds()));
	str = str.replace('ll',date.getMilliseconds());
	return str;
}

/**
 * 获取加0处理值
 * @param  string s 值
 * @return string 加0后值
 */
FtmpDate.getTimeZ = function(s){
	s = s.toString();
	if(s.length < 2){
		return '0' + s;
	}
	return s;
}

/**
 * 获取两个时间点相差
 * @param  int a 节点A时间(unix时间戳)
 * @param  int endTime   节点B时间(unix时间戳)，如果为0表明现在
 * @param  string format    格式，y-年;w-周;d-日;h-小时;i-分;s-秒;l-毫秒;也可以是yyyy-mm-dd hh-ii-ss ll类似的结构体
 * @return int           相差值
 */
FtmpDate.getDiff = function(a,b,format){
	var dateStart = new Date();
	dateStart.setTime(a);
	var dateEnd = new Date();
	if(b > 0){
		dateEnd.setTime(b);
	}
	var diff = Math.abs(dateStart - dateEnd);
	if(format.length > 1){
		var dateDiff = new Date();
		dateDiff.setTime(diff);
		var str = format.replace('yyyy',dateDiff.getFullYear()-1970);
		str = str.replace('mm',dateDiff.getMonth()+1);
		str = str.replace('dd',dateDiff.getDate());
		str = str.replace('hh',dateDiff.getHours());
		str = str.replace('ii',dateDiff.getMinutes());
		str = str.replace('ss',dateDiff.getSeconds());
		str = str.replace('ll',dateDiff.getMilliseconds());
		return str;
	}else{
		switch(format){
			case 'y':
				return Math.floor(diff / 31536000000);
			break;
			case 'w':
				return Math.floor(diff / 604800000);
			break;
			case 'd':
				return Math.floor(diff / 86400000);
			break;
			case 'h':
				return Math.floor(diff / 3600000);
			break;
			case 'i':
				return Math.floor(diff / 60000);
			break;
			case 's':
				return Math.floor(diff / 1000);
			break;
			case 'l':
				return diff;
			break;
		}
	}
}

/**
 * 获取月份天数
 * @param  int y 年份
 * @param  int m 月份
 * @return int 天数
 */
FtmpDate.getMonthDay = function(y,m){
	if(y == 0){
		var date = new Date();
		y = date.getFullYear();
		m = date.getMonth()+1;
	}
	var dateB = new Date(y,m,0);
	return dateB.getDate();
}

/**
 * 获取本月第一天和最后一天
 * @return array 第一天和最后一天时间戳组
 */
FtmpDate.getSinceMonth = function(){
	var date = new Date();
	var dateB = new Date(date.getFullYear(),date.getMonth(),1);
	var dateC = new Date(date.getFullYear(),date.getMonth()+1,0);
	return [dateB.getTime(),dateC.getTime()];
}

/**
 * 获取N天前的时间
 * @param  int d      天数
 * @param  string format 格式
 * @return string 时间
 */
FtmpDate.getSinceDay = function(d,format){
	var date = new Date();
	var since = date.getTime() - (d * 86400000);
	return FtmpDate.getTime(since,format);
}

/**
 * 获取本周第一天和最后一天
 * @return array 第一天和最后一天时间戳组
 */
FtmpDate.getSinceWeek = function(){
	var date = new Date();
	var l = new Date(date - (date.getDay() - 1) * 86400000);
	var r = new Date((l / 1000 + 6 * 86400) * 1000);
	return [l.getTime(),r.getTime()];
}