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
    case 'view':
        if (isset($_POST['id'])) {
            $id = (int) $_POST['id'];
            $res = $sysIP->view($id);
        }
        break;
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
        $desc = $_POST['desc'] ? true : false;
        //缓冲标识符
        $cacheActionIPListKey = $cache->getName('CENTER-ACTION-IP', array($page, $max, $sort, $desc));
        $cacheActionIPListContent = $cache->get($cacheActionIPListKey);
        if ($cacheActionIPListContent) {
            $res = json_decode($cacheActionIPListContent);
        }
        $res = $sysIP->viewList(null, null, null, $page, $max, $sort, $desc);
        $cache->set($cacheActionIPListKey, json_encode($res));
        unset($cacheActionIPListKey, $cacheActionIPListContent);
        break;
    case 'set-real':
        //获取真实地址
        if (isset($_POST['id']) && isset($_POST['real'])) {
            $id = (int) $_POST['id'];
            $real = $_POST['real'];
            $res = $sysIP->setReal($id, $real);
        }
        break;
    case 'set-ban':
        //设定拉黑
        if (isset($_POST['id']) && isset($_POST['bool'])) {
            $id = (int) $_POST['id'];
            $bool = (int) $_POST['bool'];
            $res = $sysIP->setBan($id, $bool);
        }
        break;
    default:
        $res = false;
        break;
}

//反馈结果
CoreHeader::toJson($res);
?>