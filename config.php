<?php

/**
 * 配置文件
 * 全局配置文件
 * 
 * @author fotomxq <fotomxq.me>
 * @version 7
 */
//////////////////
//路径定义
//////////////////
//路径分隔符
if(defined('DS') == false){
	define('DS', DIRECTORY_SEPARATOR);
}
//绝对路径
define('DIR_ROOT', dirname(__FILE__) . DS);
//用户数据
define('DIR_DATA', DIR_ROOT . 'content');
//库路径
define('DIR_LIB', DIR_ROOT . 'includes');
//APP路径
define('DIR_APP', DIR_ROOT . 'app');
//上传文件目录
define('UPLOAD_DIR',DIR_DATA.DS.'uploads');
//日志目录
define('LOG_DIR', DIR_DATA . DS . 'logs');
//缓冲目录
define('CACHE_DIR', DIR_DATA . DS . 'cache');
//应用模版目录
define('DIR_APP_TEMPALTE', DIR_APP.DS.'template');

//////////////////
//日志系统
//////////////////
//日志开关
define('LOG_ON', true);
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

//////////////////
//用户系统
//////////////////
//全局登录Session设定
define('USER_SESSION_LOGIN_NAME', 'login');

//////////////////
//其他设定
//////////////////
//Debug模式开关
define('DEBUG_ON', true);
//网站开关，超级开关，关闭后后台也无法使用
define('WEB_ON', true);
//定义时区
date_default_timezone_set('PRC');
//启动session
@session_start();
//错误页面
define('ERROR_PAGE', 'error.php');

//////////////////
//数据表名称
//////////////////
//配置表
define('TABLE_CONFIG', 'sys_config');
//用户表
define('TABLE_USER', 'sys_user');
//用户元表
define('TABLE_USER_META', 'sys_usermeta');
//IP数据表
define('TABLE_IP','sys_ip');

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
//页面地址定义
//////////////////
//错误页面
define('PAGE_ERRPR','error.php?t=');
?>