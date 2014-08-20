<?php

/**
 * 硬盘信息查询模块
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-07-16 21:23:05
 * @version 1
 */

/**
 * 返回指定目录的磁盘空间剩余大小
 * @param string $src 目录路径
 * @return array 空间大小，单位字节，eg: array('free'=>'剩余空间','total'=>'总大小')
 */
function PlugDiskInfo($src) {
    $res;
    $res['free'] = disk_free_space($src);
    $res['total'] = disk_total_space($src);
    return $res;
}

?>