<?php

/**
 * 日志处理器
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-07-17 15:53:32
 * @version 1
 */
//引用全局
require('glob.php');

//判断当前用户权限
$checkPowers = $user->checkPower($userID, array('NORMAL', 'ADMIN'));

//用户权限检测处理模块
function powerCheck($power) {
    if ($power != true) {
        die();
    }
}

powerCheck($checkPowers['ADMIN']);

//反馈结果
$res;

//判断动作类型
if (isset($_GET['action']) != true) {
    die();
}
switch ($_GET['action']) {
    case 'list':
        //获取日志列
        $offset = isset($_POST['offset']) ? (int) $_POST['offset'] : 0;
        $res = $log->view($offset);
        break;
    default:
        break;
}

//反馈结果
CoreHeader::toJson($res);
?>