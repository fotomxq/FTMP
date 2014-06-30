<?php
/**
 * 应用内全局设定
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-26 17:43:38
 * @version 1
 */

//路径分隔符
if(defined('DS') == false){
	define('DS', DIRECTORY_SEPARATOR);
}

/**
 * 定义该应用名称
 * 用户访问该应用需要的权限也根据该变量判断
 * @var string
 */
$appName = 'center';

//引用全局
require('..'.DS.'template'.DS.'glob.php');

?>