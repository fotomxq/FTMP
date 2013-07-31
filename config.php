<?php

/**
 * 配置文件
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package sys
 */
//////////////////
//数据库定义
//////////////////
//PDO-DSN eg: mysql:host=localhost;dbname=databasename;charset=utf8
$dbDSN = 'mysql:host=localhost;dbname=ftmpersonal;charset=utf8';
//数据库用户名
$dbUser = 'admin';
//数据库密码
$dbPasswd = 'admin';
//是否持久化连接
$dbPersistent = true;
//连接编码
$dbEncoding = 'UTF8';

//////////////////
//路径定义
//////////////////
//路径分隔符
define('DS', DIRECTORY_SEPARATOR);
//绝对路径
define('DIR_ROOT', __DIR__ . DS);
//用户数据
define('DIR_DATA', DIR_ROOT . 'content');
//库路径
define('DIR_LIB', DIR_ROOT . 'includes');

//////////////////
//目录设定
//////////////////
//备份目录
define('DIR_BACKUP', DIR_DATA . DS . 'backup');
//缓冲目录
define('DIR_CACHE', DIR_DATA . DS . 'cache');
//日志目录
define('DIR_LOG', DIR_DATA . DS . 'log');
//上传文件目录
define('DIR_UPLOAD', DIR_DATA . DS . 'uploads');

//////////////////
//上传文件设定
//////////////////
//允许的文件类型
define('UPLOAD_TYPE', 'jpg,png,gif,wmp,zip,rar,pdf,txt,mp3,mp4,avi,mpeg');
//拒绝的文件类型
define('UPLOAD_BAN_TYPE', 'exe,bat,sh,php,html,htm,msi');
//允许的图片文件类型
define('UPLOAD_IMG_TYPE', 'jpg,png');
//允许的个人简历文件类型
define('UPLOAD_CANDADITES_TYPE', 'doc,docx');
//是否开启总白名单
define('UPLOAD_TYPE_ON', false);
//是否开启黑名单
define('UPLOAD_BAN_TYPE_ON', true);
//是否开启图片白名单
define('UPLOAD_IMG_TYPE_ON', true);
//最大文件大小 (KB)
define('UPLOAD_SIZE_MAX', 51200);
//如果图片超出尺寸是否自动压缩图片
define('UPLOAD_IMG_SIZE_P_ON', true);
//图片最大尺寸
define('UPLOAD_IMG_SIZE_W', 3000);
define('UPLOAD_IMG_SIZE_H', 3000);
//是否直接跳转到文件下载，否则通过脚本下载
define('UPLOAD_DOWN_PHP', true);

//////////////////
//其他设定
//////////////////
//URL
define('WEB_URL', 'http://192.168.1.101/ftmp');
//Debug模式开关
define('DEBUG_ON', true);
//网站开关，超级开关，关闭后后台也无法使用
define('WEB_ON', true);

//////////////////
//定义时区
//////////////////
date_default_timezone_set('PRC');
?>
