<?php

/**
 * 应用内全局设定
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-06-26 17:43:38
 * @version 3
 */
//路径分隔符
if (defined('DS') == false) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * 定义该应用名称
 * 用户访问该应用需要的权限也根据该变量判断
 * @var string
 */
$appName = 'center';

//引用全局
require('..' . DS . 'template' . DS . 'glob.php');

//设定页面引用
$pageIncludes = array(
    'glob' => array(
        'css' => array('messenger.css', 'messenger-theme-flat.css', 'icheck-skins-flat.css'),
        'js' => array('messenger.js', 'icheck.js')
    )
);

//用户是否为管理员
$checkPowers = $user->checkPower($userID, array('ADMIN'));

//所有应用名称及所在目录
$apps = array('center', 'pex');
?>