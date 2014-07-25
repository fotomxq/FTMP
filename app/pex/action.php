<?php

/**
 * 动作整合
 * @author fotomxq <fotomxq.me>
 * @date    2014-06-30 11:51:18
 * @version 6
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
        $res = null;
        //启动缓冲
        $cacheOn = true;
        //过滤参数
        if (!isset($_POST['parent']) || !isset($_POST['page']) || !isset($_POST['max']) || !isset($_POST['sort']) || !isset($_POST['desc'])) {
            break;
        }
        $parent = (int) $_POST['parent'];
        $page = (int) $_POST['page'];
        $max = (int) $_POST['max'];
        $sort = (int) $_POST['sort'];
        $desc = $_POST['desc'] == '1' ? true : false;
        $tags = isset($_POST['tags']) ? $_POST['tags'] : null;
        //生成缓冲名称
        $cacheName .= '-' . $parent . '-' . $page . '-' . $max . '-' . $sort . '-' . $_POST['desc'] . '-' . implode('-', $tags);
        //获取缓冲数据
        $res = $cache->get($cacheName);
        if ($res) {
            $res = json_decode($res, true);
        } else {
            //获取数据
            $res = $pex->viewList($parent, $tags, $page, $max, $sort, $desc);
            //获取资源对应的标签组
            if ($res) {
                foreach ($res as $k => $v) {
                    $res[$k]['tags'] = $pex->viewTx($v['id']);
                }
            }
        }
        break;
    case 'release':
        //发布资源
        break;
    case 'edit':
        //编辑资源
        $res = false;
        //过滤参数
        if (!isset($_POST['id']) || !isset($_POST['title']) || !isset($_POST['content'])) {
            break;
        }
        $editID = (int) $_POST['id'];
        $editTitle = $_POST['title'];
        $editContent = $_POST['content'];
        $editTags = isset($_POST['tags']) ? $_POST['tags'] : null;
        //获取文件信息
        $fileInfo = $pex->view($editID);
        if ($fileInfo) {
            //编辑文件
            $res = $pex->editFx($editID, $editTitle, $editContent);
            if ($res) {
                //编辑文件标签
                $res = $pex->setTx($fileInfo['id'], $editTags, $fileInfo['tx_type']);
            }
        }
        //清理缓冲
        if ($res) {
            $cache->clear();
        }
        break;
    case 'del':
        //删除资源
        $res = false;
        //过滤参数
        if (!isset($_POST['del'])) {
            break;
        }
        $del = $_POST['del'];
        if (is_array($del)) {
            //如果是数组
            foreach ($del as $v) {
                $res = $pex->delFx($v);
                if (!$res) {
                    break;
                }
            }
        } else {
            //如果是单个
            $del = (int) $del;
            $res = $pex->delFx($del);
        }
        //清理缓冲
        if ($res) {
            $cache->clear();
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

//清理数据
unset($cacheName);

//返回JSON
CoreHeader::toJson($res);
