<?php

/**
 * 动作整合
 * @author fotomxq <fotomxq.me>
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
    case 'info':
        //获取所有非记录信息
        $cacheOn = true;
        $res = $cache->get($cacheName);
        if ($res) {
            $res = json_decode($res, true);
        } else {
            $res['type-default'] = $pex->pexType['photo']['key'];
            $res['type'] = $pex->pexType;
            $i = 0;
            $lsType;
            foreach ($res['type'] as $k => $v) {
                $lsType[$i] = $v;
                $i++;
            }
            $res['type'] = $lsType;
            if ($pex->pexType) {
                foreach ($pex->pexType as $v) {
                    $res['tag'][$v['key']] = $pex->viewTag($v['key']);
                }
            }
        }
        break;
    case 'resource':
        //获取资源记录
        break;
    case 'edit':
        //编辑资源
        $res = false;
        if (!$_POST['id']) {
            break;
        }
        break;
    case 'del':
        //删除资源
        $res = false;
        if (!$_POST['del']) {
            break;
        }
        $del = $_POST['del'];
        if (is_array($del)) {
            foreach ($del as $v) {
                $res = $pex->delFx($v);
                if (!$res) {
                    break;
                }
            }
        } else {
            $del = (int) $del;
            $res = $pex->delFx($del);
        }
        break;
    default:
        //缺省
        break;
}

//保存缓冲
if ($cacheOn) {
    $cache->set($cacheName, json_encode($res));
}

//返回JSON
CoreHeader::toJson($res);
