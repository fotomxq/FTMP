<?php

/**
 * 动作整合
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-30 11:51:18
 * @version 1
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
            if (isset($_POST['title']) == true && isset($_POST['parent']) == true && isset($_POST['content']) == true && isset($_POST['tag']) == true) {
                
            }
            $isGroup = isset($_POST['group']) == true ? true : false;
            break;
        case 'folder-add':
            break;
        case 'fx-view':
            break;
        case 'fx-list':
            break;
        case 'fx-edit':
            break;
        case 'fx-cut':
            break;
        case 'fx-update-time':
            break;
        case 'fx-del':
            break;
        case 'tag-list':
            
            break;
        case 'tag-add':
            break;
        case 'tag-edit':
            break;
        case 'tag-tx-add':
            break;
        case 'tag-tx-del':
            break;
        case 'tag-del':
            break;
    }
}
?>