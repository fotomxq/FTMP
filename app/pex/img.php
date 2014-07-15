<?php

/**
 * 查看图片
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-07-06 14:52:00
 * @version 3
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
    //获取图片大小
    $size = isset($_GET['size']) == true ? $_GET['size'] : 600;
    $sizeW = $size;
    $sizeH = 1500;
    //获取数据
    $res = $pex->view($id);
    if ($res) {
        if ($res['fx_type'] == 'folder') {
            $resParent = $pex->viewList($res['id'], null, 1, 1, 0, false);
            if ($resParent) {
                if ($resParent[0]['fx_type'] == 'txt') {
                    CoreHeader::toURL('assets/imgs/folder-txt.png');
                } elseif ($resParent[0]['fx_type'] == 'mp4') {
                    CoreHeader::toURL('assets/imgs/folder-movie.png');
                } elseif ($resParent[0]['fx_type'] == 'jpg' || $resParent[0]['px_type'] == 'png' || $resParent[0]['px_type'] == 'gif') {
                    CoreHeader::toURL('assets/imgs/folder-photo.png');
                } else {
                    CoreHeader::toURL('assets/imgs/folder.png');
                }
            } else {
                CoreHeader::toURL('assets/imgs/folder.png');
            }
        } else {
            if ($res['fx_type'] == 'jpg' || $res['fx_type'] == 'jpeg' || $res['fx_type'] == 'png' || $res['fx_type'] == 'gif') {
                $src = APP_PEX_DIR . DS . 'file' . DS . $res['fx_src'];
                if (is_file($src) == true) {
                    if ($res['fx_type'] == 'gif') {
                        CoreHeader::toURL('../../content/pex/file/' . $res['fx_src']);
                    } else {
                        if ($sizeW == 0 || $sizeH == 0) {
                            CoreHeader::toURL('../../content/pex/file/' . $res['fx_src']);
                        } else {
                            $pexCache = new CoreCache(CACHE_ON, CACHE_LIMIT_TIME, APP_PEX_DIR . DS . 'cache');
                            $src = $pexCache->img($src, $sizeW, $sizeH);
                            CoreHeader::showImg($src, 'jpeg');
                        }
                    }
                } else {
                    CoreHeader::toURL('assets/imgs/photo.png');
                }
            } elseif ($res['fx_type'] == 'mp4') {
                CoreHeader::toURL('assets/imgs/movie.png');
            } elseif ($res['fx_type'] == 'txt') {
                CoreHeader::toURL('assets/imgs/txt.png');
            } else {
                CoreHeader::toURL('assets/imgs/file.png');
            }
        }
    }
}
?>