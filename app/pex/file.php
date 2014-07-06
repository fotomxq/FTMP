<?php

/**
 * 查看图片
 * @authors fotomxq <fotomxq.me>
 * @date    2014-07-06 16:11:00
 * @version 1
 */
//引用全局
require('glob.php');

//引用PEX处理器
require('app-pex.php');

//创建对象
$pex = new AppPex($db, APP_PEX_DIR);

//检查参数
if (isset($_GET['id']) == true) {
    $id = (int) $_GET['id'];
    //获取数据
    $res = $pex->view($id);
    if ($res) {
        if ($res['fx_type'] != 'folder') {
            CoreHeader::toURL('../../content/pex/file/' . $res['fx_src']);
        }
    }
}
?>