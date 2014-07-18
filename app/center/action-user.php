<?php

/**
 * 用户处理器
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-07-18 13:03:46
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
        //获取用户列表
        $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
        $max = isset($_POST['max']) ? (int) $_POST['max'] : 10;
        $sort = isset($_POST['sort']) ? (int) $_POST['sort'] : 0;
        $desc = isset($_POST['desc']) ? (int) $_POST['desc'] : 0;
        $desc = $desc == '1' ? true : false;
        $res = $user->viewUserList('1', null, $page, $max, $sort, $desc);
        break;
    case 'add':
        //添加用户
        if (!isset($_POST['login']) || !isset($_POST['nicename']) || !isset($_POST['passwd']) || !isset($_POST['power']) || !isset($_POST['app'])) {
            break;
        }
        break;
    case 'edit':
        //编辑用户
        if (isset($_POST['id']) || !isset($_POST['login']) || !isset($_POST['nicename']) || !isset($_POST['passwd']) || !isset($_POST['power']) || !isset($_POST['app'])) {
            
        }
        break;
    case 'del':
        //删除用户
        if (!isset($_POST['id'])) {
            break;
        }
        $id = (int) $_POST['id'];
        $res = $user->del();
        break;
    default:
        //默认返回
        break;
}

//反馈结果
CoreHeader::toJson($res);
?>