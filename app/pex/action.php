<?php

/**
 * 动作整合
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-30 11:51:18
 * @version 5
 */
//引用全局
require('glob.php');

//引用PEX处理器
require('app-pex.php');

//创建对象
$pex = new AppPex($db, APP_PEX_DIR, $log);

//过滤action变量
$action = $_GET['action'];

//返回变量
$res;

//该数据是否可以缓冲
$cacheOn = false;

//缓冲名称
$cacheName = 'PEX-' . $action;

//判断动作类型
switch ($action) {
    case 'type-default':
        $res = $pex->pexType['photo']['key'];
        break;
    case 'type-all':
        //获取所有类型
        $res = $pex->pexType;
        break;
    case 'tag-all':
        //获取所有标签
        $cacheOn = true;
        $res = $cache->get($cacheName);
        if ($res) {
            $res = json_decode($res, true);
        } else {
            if ($pex->pexType) {
                foreach ($pex->pexType as $v) {
                    $res[$v['key']] = $pex->viewTag($v['key']);
                }
            }
        }
        break;
    default:
        //缺省
        break;
}

//保存缓冲
if($cacheOn){
    $cache->set($cacheName, json_encode($res));
}

//返回JSON
CoreHeader::toJson($res);
