<?php

/**
 * 动作整合
 * @author liuzilu <fotomxq.me>
 * @date    2014-06-30 11:51:18
 * @version 11
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
        $res = $cache->get($cacheName);
        if ($res) {
            $res = json_decode($res, true);
        } else {
            $cacheOn = true;
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
            $res['sort'] = $config->get('PEX-SORT');
            $res['desc'] = $config->get('PEX-DESC');
        }
        break;
    case 'resource':
        //获取资源记录
        $res = null;
        //过滤参数
        if (!isset($_POST['parent']) || !isset($_POST['page']) || !isset($_POST['max']) || !isset($_POST['sort']) || !isset($_POST['desc']) || !isset($_POST['or'])) {
            break;
        }
        $parent = (int) $_POST['parent'];
        $page = (int) $_POST['page'];
        $max = (int) $_POST['max'];
        $sort = (int) $_POST['sort'];
        $desc = $_POST['desc'] == '1' ? true : false;
        $tags = isset($_POST['tags']) ? $_POST['tags'] : null;
        $or = $_POST['or'] == '1' ? true : false;
        //生成缓冲名称
        $cacheName .= '-' . $parent . '-' . $page . '-' . $max . '-' . $sort . '-' . $_POST['desc'] . '-' . implode('-', $tags) . '-' . $_POST['or'];
        //获取缓冲数据
        $res = $cache->get($cacheName);
        if ($res) {
            $res = json_decode($res, true);
        } else {
            //启动缓冲
            $cacheOn = true;
            //获取数据
            $res = $pex->viewList($parent, $tags, $page, $max, $sort, $desc, $or);
            //获取资源对应的标签组
            if ($res) {
                foreach ($res as $k => $v) {
                    $res[$k]['tags'] = $pex->viewTx($v['id']);
                }
            }
        }
        break;
    case 'release-ready-list':
        //获取待转移文件
        $cacheName .= '-RELEASE-READY-LIST-NUM';
        $res = $cache->get($cacheName);
        if ($res) {
            $res = json_decode($res, true);
        } else {
            $cacheOn = true;
            $res = $pex->transferListNum();
        }
        break;
    case 'release':
        //发布资源
        $res = false;
        //过滤参数
        if (!isset($_POST['title']) || !isset($_POST['content']) || !isset($_POST['tags']) || !isset($_POST['parent']) || !isset($_POST['option-save']) || !isset($_POST['option-folder'])) {
            break;
        }
        $parent = (int) $_POST['parent'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $tags = $_POST['tags'];
        $optionSave = $_POST['option-save'] == '1' ? true : false;
        $optionFolderRelease = $_POST['option-folder'] == '1' ? true : false;
        //设定脚本时间
        ini_set('max_execution_time', 1800);
        set_time_limit(1800);
        //文件夹发布模式
        if ($optionFolderRelease) {
            //发布资源
            $res = $pex->transferFolder($parent, $tags);
        } else {
            //根据选项创建文件夹
            if ($optionSave) {
                $parent = $pex->addFolder($title, $parent, $content);
                $res = $pex->setTx($parent, $tags, 1);
                if (!$res) {
                    break;
                }
            }
            if ($parent < 1) {
                break;
            }
            //转移文件
            $transferList = $pex->transferList(1, 9999);
            if (!$transferList) {
                break;
            }
            foreach ($transferList as $v) {
                $src = DIR_DATA . DS . 'pex' . DS . 'transfer' . DS . $v;
                $res = $pex->transferFile($src, $title, $parent, $content);
                if (!$res) {
                    break;
                }
                if ($res) {
                    $res = $pex->setTx($res, $tags, 0);
                }
                if (!$res) {
                    break;
                }
            }
        }
        //清理缓冲
        if ($res) {
            $cache->clear();
        }
        break;
    case 'add-folder':
        //创建文件夹
        $res = false;
        //过滤参数
        if (!isset($_POST['title']) || !isset($_POST['parent']) || !isset($_POST['content']) || !isset($_POST['tags'])) {
            break;
        }
        $addParent = (int) $_POST['parent'];
        $addTitle = $_POST['title'];
        $addContent = $_POST['content'];
        $addTags = $_POST['tags'];
        //添加文件夹
        $res = $pex->addFolder($addTitle, $addParent, $addContent);
        if ($res > 0) {
            $res = $pex->setTx($res, $addTags, 1);
        }
        //清理缓冲
        if ($res) {
            $cache->clear();
        }
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
    case 'cut':
        //剪切
        $res = false;
        //过滤参数
        if (!isset($_POST['select']) || !isset($_POST['parent'])) {
            break;
        }
        $select = $_POST['select'];
        $parent = (int) $_POST['parent'];
        if (is_array($select)) {
            foreach ($select as $v) {
                $id = (int) $v;
                $res = $pex->cutFile($id, $parent);
                if (!$res) {
                    break;
                }
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
    case 'set-load':
        //获取系统设定
        $res['sort'] = $config->get('PEX-SORT');
        $res['desc'] = $config->get('PEX-DESC');
        $res['fx-fields'] = $pex->getFxAllField();
        break;
    case 'set-save':
        //保存系统设定
        //过滤参数
        $setPasswd = isset($_POST['set-passwd']) ? $_POST['set-passwd'] : false;
        $setTags = isset($_POST['set-tags']) ? $_POST['set-tags'] : false;
        $setSort = isset($_POST['set-sort']) ? $_POST['set-sort'] : false;
        $setDesc = isset($_POST['set-desc']) ? $_POST['set-desc'] : false;
        $bool = null;
        //设定密码
        if ($setPasswd) {
            $bool[] = $config->set('PEX-PASSWD', sha1($setPasswd));
        }
        //设定标签
        if ($setTags && $pex->pexType) {
            foreach ($pex->pexType as $typeV) {
                if ($setTags[$typeV['key']]) {
                    $tagArr = explode('|', $setTags[$typeV['key']]);
                    $bool[] = $pex->setTag($tagArr, $typeV['key']);
                }
            }
        }
        //设定排序字段
        if ($setSort) {
            $setSort = ceil($setSort);
            if ($setSort < 1) {
                $setSort = 1;
            }
            if ($setSort > 11) {
                $setSort = 11;
            }
            $setSort = $setSort - 1;
            $bool[] = $config->save('PEX-SORT', $setSort);
        }
        //设定排序方式
        if ($setDesc) {
            if ($setDesc != '2') {
                $setDesc = '1';
            }
            $setDesc = $setDesc - 1;
            $bool[] = $config->save('PEX-DESC', $setDesc);
        }
        //整合判断失败
        $res = true;
        foreach ($bool as $v) {
            if (!$v) {
                $res = false;
            }
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
