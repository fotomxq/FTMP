<?php

/**
 * 上传文件插件
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-06-20 11:51:03
 * @version 1
 */

/**
 * 上传新的文件
 * @param string $dir    保存到目录路径,eg:content/dir
 * @param $_FILES $upload 上传文件对象,eg:$_FILES['file']
 * @return array|boolean 文件相关数据,eg:array('name'=>'文件名称','time'=>'上传时间','mime'=>'文件MIME值','sha1'=>'文件SHA1值','size'=>'文件大小')
 */
function PlugUpload($dir, $upload) {
    //检查上传文件
    if (is_uploaded_file($upload) != true) {
        return false;
    }
    if ($upload['error'] > 0) {
        return false;
    }
    //定义基本设定
    $ds = DIRECTORY_SEPARATOR;
    $arr;
    //获取时间
    $dateY = date('Y');
    $dateM = date('m');
    $dateD = date('d');
    $dateH = date('H');
    $dateI = date('i');
    $dateS = date('s');
    //生成目录
    $newDir = $dir . $ds . $dateY . $ds . $dateM . $ds . $dateD;
    if (mkdir($newDir, 0777, true) != true) {
        return false;
    }
    //获取SHA1
    $arr['sha1'] = sha1_file($upload['tmp_name']);
    //生成文件路径
    $newSrc = $newDir . $ds . $dateY . $dateM . $dateD . $dateH . $dateI . $dateS . '_' . $arr['sha1'];
    //转移上传文件
    if (move_uploaded_file($upload['tmp_name'], $newSrc) != true) {
        return false;
    }
    //保存相关参数并返回
    $arr['time'] = $dateY . '-' . $dateM . '-' . $dateD . ' ' . $dateH . ':' . $dateI . ':' . $dateS;
    $arr['size'] = $upload['size'];
    $arr['mime'] = $upload['type'];
    $arr['name'] = $upload['name'];
    return $arr;
}

?>