<?php

/**
 * 配置文件
 * 全局配置文件
 * 
 * @author fotomxq <fotomxq.me>
 * @version 5
 * @package web
 */
//////////////////
//路径定义
//////////////////
//路径分隔符
define('DS', DIRECTORY_SEPARATOR);
//绝对路径
define('DIR_ROOT', dirname(__FILE__) . DS);
//用户数据
define('DIR_DATA', DIR_ROOT . 'content');
//库路径
define('DIR_LIB', DIR_ROOT . 'includes');
//APP路径
define('DIR_APP', DIR_ROOT . 'app');

//////////////////
//上传文件设定
//////////////////
//上传文件目录
define('UPLOAD_DIR',DIR_DATA.DS.'uploads');
//允许的文件类型
define('UPLOAD_TYPE', 'jpg,png,gif,jpeg,wmp,zip,rar,7z,pdf,doc,docx,ppt,cvs,xls,txt,wma,wmv,mp3,mp4,avi,mpeg');
//拒绝的文件类型
define('UPLOAD_BAN_TYPE', 'exe,bat,sh,php,html,htm,msi');
//允许的图片文件类型
define('UPLOAD_IMG_TYPE', 'jpg,png,gif');
//允许的个人简历文件类型
define('UPLOAD_CANDADITES_TYPE', 'pdf');
//是否开启文件上传白名单
define('UPLOAD_TYPE_ON', true);
//是否开启文件上传黑名单
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
//日志系统
//////////////////
//日志开关
define('LOG_ON', true);
//////////////////
//日志目录
define('LOG_DIR', DIR_DATA . DS . 'logs');
//////////////////
//日志记录形式
//0 - 发送到PHP日志记录系统 ; 1 - 年月.log ; 2 - 年月/日.log ; 3 - 年月/日-时.log ; 4 - 年/月/日-时.log
define('LOG_TYPE', 0);

//////////////////
//缓冲器
//////////////////
//缓冲器开关
define('CACHE_ON', true);
//失效时间长度 ( 秒 )
define('CACHE_LIMIT_TIME', 1296000);
//缓冲目录
define('CACHE_DIR', DIR_DATA . DS . 'cache');

//////////////////
//用户系统
//////////////////
//全局登录Session设定
define('USER_SESSION_LOGIN_NAME', 'login');

//////////////////
//在线应聘
//////////////////
//在线应聘开关
define('CANDADITES_ON', true);
//提交应聘时间间隔 (s)
define('CANDADITES_TIME_LIMIT', 86400);

//////////////////
//购物
//////////////////
//在线购物开关
define('ORDER_ON', true);
//提交订单时间间隔 (s)
define('ORDER_TIME_LIMIT', 60);

//////////////////
//评论
//////////////////
//评论开关
define('COMMENT_ON', true);
//提交评论时间间隔 (s)
define('COMMENT_TIME_LIMIT', 60);
//评论审核开关
define('COMMENT_AUDIT_ON', true);

//////////////////
//同步设置
//////////////////
//保存当前数据库版本版本
define('SYNC_VERSION_NAME','SYNC-VERSION');
//自动同步时间，如果为0表明不自动同步
define('SYNC_TIME',0);

//////////////////
//其他设定
//////////////////
//URL
define('WEB_URL', 'http://localhost/ftmp');
//Debug模式开关
define('DEBUG_ON', true);
//网站开关，超级开关，关闭后后台也无法使用
define('WEB_ON', true);
//默认访客用户 (该用户不能被删除，且被用于上传和其他系统创建任务)
define('VISITOR_USER', 1);
//默认访客用户组，作用同上 (如果需要自定义，请勿赋予任何权限)
define('VISITOR_USER_GROUP', 1);
//定义时区
date_default_timezone_set('PRC');
//启动session
@session_start();
//错误页面
define('ERROR_PAGE', 'error.php');
//百度云计算LBS秘匙
define('BAIDU_KEY', 'F44c8a7c7da1d5a1a6bac28a5fd767bc');

//////////////////
//数据表名称
//////////////////
//配置表
define('TABLE_CONFIG', 'sys_config');
//用户表
define('TABLE_USER', 'sys_user');
//用户元表
define('TABLE_USER_META', 'sys_usermeta');
//上传文件表
define('TABLE_FILE', 'sys_file');
//服务器
define('TABLE_SERVER','sys_server');
//文件和服务器关系表
define('TABLE_FILE_SERVER','sys_file_server');

//////////////////
//数据库定义
//////////////////
//PDO-DSN eg: mysql:host=localhost;dbname=databasename;charset=utf8
$dbDSN = 'mysql:host=localhost;dbname=ftmp;charset=utf8';
//数据库用户名
$dbUser = 'admin';
//数据库密码
$dbPasswd = 'admin';
//是否持久化连接
$dbPersistent = true;
//连接编码
$dbEncoding = 'UTF8';

//////////////////
//APP
//////////////////
//APP注册表
$appList = array(
    'health' => array('name' => '健康中心', 'des' => '协助体重和健身。', 'table' => array()),
    'life' => array('name' => '生活中心', 'des' => '一切生活的问题，在这里解决。', 'table' => array('app_life_log')),
    'resources'=>array('name'=>'资源管理器','des'=>'资源管理工具。','table'=>array()),
    'finance'=>array('name'=>'财务管家','des'=>'家庭财务管理的最终解决方案。','table'=>array('app_finance'))
);
?>