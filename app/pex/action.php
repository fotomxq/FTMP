<?php

/**
 * 动作整合
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-30 11:51:18
 * @version 3
 */
//引用全局
require('glob.php');

//引用PEX处理器
require('app-pex.php');

//创建对象
$pex = new AppPex($db, APP_PEX_DIR);

//判断动作类型
if (isset($_GET['action']) == true) {
    switch ($_GET['action']) {
        case 'upload':
            //上传文件
            break;
        case 'transfer-list':
            //获取等待转移列
            $page = isset($_POST['page']) == true ? (int) $_POST['page'] : 1;
            $max = isset($_POST['max']) == true ? (int) $_POST['max'] : 10;
            $res = $pex->transferList($page, $max);
            CoreHeader::toJson($res);
            break;
        case 'transfer-add':
            //发布转移文件
            if (isset($_POST['title']) == true && isset($_POST['parent']) == true && isset($_POST['mode-type']) == true && isset($_POST['mode-dir']) == true && isset($_POST['content']) == true && isset($_POST['tags']) == true && isset($_POST['files']) == true) {
                $res = false;
                $title = $_POST['title'];
                $parent = (int) $_POST['parent'];
                $content = $_POST['content'];
                $tags = $_POST['tags'];
                $files = $_POST['files'];
                $modeDir = $_POST['mode-dir'];
                $modeType = $_POST['mode-type'];
                //构建文件夹
                if ($modeDir == true) {
                    $parent = $pex->pexType[$modeType]['folder'];
                    $parent = $pex->addFolder($title, $parent, $content);
                    if ($parent < 1) {
                        $res = false;
                        CoreHeader::toJson($res);
                    }
                    //创建标签关系
                    if ($tags) {
                        foreach ($tags as $tagV) {
                            if (!$pex->addTx($parent, $tagV, 1)) {
                                $res = false;
                                CoreHeader::toJson($res);
                            }
                        }
                    }
                }
                //创建文件
                if ($files) {
                    foreach ($files as $v) {
                        $src = APP_PEX_DIR . DS . 'transfer' . DS . $v;
                        $resFile = $pex->transferFile($src, $title, $parent, $content);
                        if ($resFile > 0) {
                            //创建标签关系
                            if ($tags) {
                                foreach ($tags as $tagV) {
                                    if (!$pex->addTx($resFile, $tagV, 0)) {
                                        $res = false;
                                        CoreHeader::toJson($res);
                                    }
                                }
                            }
                        } else {
                            $res = false;
                            CoreHeader::toJson($res);
                        }
                    }
                    $res = true;
                }
                CoreHeader::toJson($res);
            }
            break;
        case 'folder-add':
            //添加目录
            if (isset($_POST['title']) == true && isset($_POST['parent']) == true && isset($_POST['content']) == true) {
                $title = $_POST['title'];
                $parent = (int) $_POST['parent'];
                $content = $_POST['content'];
                $res = $pex->addFolder($title, $parent, $content);
                CoreHeader::toJson($res);
            }
            break;
        case 'fx-view':
            //查看FX详情
            if (isset($_POST['id']) == true) {
                $id = (int) $_POST['id'];
                $res = $pex->view($id);
                CoreHeader::toJson($res);
            }
            break;
        case 'fx-list':
            //获取FX列
            if (isset($_POST['parent']) == true && isset($_POST['page']) == true && isset($_POST['max']) == true && isset($_POST['sort']) == true && isset($_POST['desc']) == true) {
                $parent = (int) $_POST['parent'];
                $page = $_POST['page'] > 0 ? (int) $_POST['page'] : 1;
                $max = $_POST['max'] > 0 ? (int) $_POST['max'] : 10;
                $sort = (int) $_POST['sort'];
                $desc = $_POST['desc'] == true ? true : false;
                $tags = isset($_POST['tags']) == true ? $_POST['tags'] : null;
                $res = $pex->viewList($parent, $tags, $page, $max, $sort, $desc);
                CoreHeader::toJson($res);
            }
            break;
        case 'fx-edit':
            //编辑FX信息
            if (isset($_POST['id']) == true && isset($_POST['title']) == true && isset($_POST['name']) == true && isset($_POST['content']) == true) {
                $id = (int) $_POST['id'];
                $title = $_POST['title'];
                $name = (int) $_POST['name'];
                $content = $_POST['content'];
                $res = $pex->editFx($id, $where, $name, $content);
                CoreHeader::toJson($res);
            }
            break;
        case 'fx-cut':
            //剪切FX
            if (isset($_POST['id']) == true && isset($_POST['parent']) == true) {
                $id = (int) $_POST['id'];
                $parent = (int) $_POST['parent'];
                $res = $pex->cutFile($id, $parent);
                CoreHeader::toJson($res);
            }
            break;
        case 'fx-update-time':
            //更新FX访问时间
            if (isset($_POST['id']) == true) {
                $id = (int) $_POST['id'];
                $res = $pex->updateFxTime($id);
                CoreHeader::toJson($res);
            }
            break;
        case 'fx-del':
            //删除FX
            if (isset($_POST['id']) == true) {
                $id = (int) $_POST['id'];
                $res = $pex->delFx($id);
                CoreHeader::toJson($res);
            }
            break;
        case 'tag-list':
            //获取所有类型的所有标签
            $res;
            if ($pex->pexType) {
                foreach ($pex->pexType as $v) {
                    $res[$v['key']] = $pex->viewTag($v['key']);
                }
            }
            CoreHeader::toJson($res);
            break;
        case 'tag-add':
            //添加新的标签
            if (isset($_POST['name']) == true && isset($_POST['type']) == true) {
                $name = $_POST['name'];
                $type = $_POST['type'];
                $newID = $pex->addTag($name, $type);
                die($newID);
            }
            break;
        case 'tag-edit':
            //编辑标签名称
            if (isset($_POST['id']) == true && isset($_POST['name']) == true) {
                $id = (int) $_POST['id'];
                $name = $_POST['name'];
                $res = $pex->editTag($id, $name);
                CoreHeader::toJson($res);
            }
            break;
        case 'tag-tx-add':
            //添加标签关系
            if (isset($_POST['fileID']) == true && isset($_POST['tagID']) == true && isset($_POST['type']) == true) {
                $fileID = (int) $_POST['fileID'];
                $tagID = (int) $_POST['tagID'];
                $type = $_POST['type'] == 'file' ? 'file' : 'folder';
                $newID = $pex->addTx($fileID, $tagID, $type);
                die($newID);
            }
            break;
        case 'tag-tx-del':
            //删除标签关系
            if (isset($_POST['txID']) == true) {
                $txID = (int) $_POST['txID'];
                $res = $pex->delTx($txID);
                CoreHeader::toJson($res);
            }
            break;
        case 'tag-del':
            //删除标签
            if (isset($_POST['tagID']) == true) {
                $tagID = (int) $_POST['tagID'];
                $res = $pex->delTag($tagID);
                CoreHeader::toJson($res);
            }
            break;
        case 'tag-set':
            //修改标签，自动判断添加、修改、删除操作
            if (isset($_POST['tags']) == true) {
                $tagRes;
                $res = false;
                $tags = $_POST['tags'];
                foreach ($pex->pexType as $v) {
                    $vList = explode('|', $tags[$v['key']]);
                    if (!$pex->setTag($vList, $v['key'])) {
                        CoreHeader::toJson($res);
                    }
                }
                CoreHeader::toJson($res);
            }
            break;
        case 'cache-clear':
            //清理缓冲
            $pexCache = new CoreCache(CACHE_ON, CACHE_LIMIT_TIME, APP_PEX_DIR . DS . 'cache');
            $res = $pexCache->clearImg();
            CoreHeader::toJson($res);
            break;
    }
}
?>