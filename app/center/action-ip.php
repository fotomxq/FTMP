<?php

/**
 * IP处理器
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-07-15 11:53:13
 * @version 1
 */
//引用全局
require('glob.php');

//引用备份类
require(DIR_LIB . DS . 'sys-backup.php');

//判断当前用户权限
$checkPowers = $user->checkPower($userID, array('NORMAL', 'ADMIN'));

//用户权限检测处理模块
function powerCheck($power) {
    if ($power != true) {
        die();
    }
}

//反馈结果
$res;

//判断动作类型
if (isset($_GET['action']) != true) {
    die();
}
switch ($_GET['action']) {
    case 'list':
        //获取列表
        //核对参数
        $page = isset($_POST['page']) == true ? (int) $_POST['page'] : 1;
        if ($page < 1) {
            $page = 1;
        }
        $max = isset($_POST['max']) == true ? (int) $_POST['max'] : 10;
        if ($max < 1) {
            $max = 1;
        }
        $sort = isset($_POST['sort']) == true ? (int) $_POST['sort'] : 0;
        if ($sort < 0 || $sort > 3) {
            $sort = 0;
        }
        $desc = isset($_POST['desc']) == true ? $_POST['desc'] : true;
        $desc = $desc ? true : false;
        $res = $ip->viewList(null, null, null, $page, $max, $sort, $desc);
        break;
    case 'get-real':
        //获取真实地址
        if (isset($_POST['id'])) {
            $id = (int) $_POST['id'];
        }
        $res = false;
        //$ip->setBan($id,false);
        break;
    case 'set-ban-on':
        //设定拉黑
        if (isset($_POST['id'])) {
            $id = (int) $_POST['id'];
        }
        $res = $ip->setBan($id, true);
        break;
    case 'set-ban-off':
        //设定取消拉黑
        if (isset($_POST['id'])) {
            $id = (int) $_POST['id'];
        }
        $res = $ip->setBan($id, false);
        break;
    default:
        $res = false;
        break;
}

//反馈结果
CoreHeader::toJson($res);
?>