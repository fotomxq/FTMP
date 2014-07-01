<?php
/**
 * 下载文件插件
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-20 11:51:03
 * @version 1
 */

/**
 * 下载文件
 * @param string $src  文件路径
 * @param string $name 文件名称,eg:file.jpg
 * @param int $size 文件大小
 */
function PlugDownload($src,$name,$size){
	if(is_file($src) == true){
		header('Content-type: application/octet-stream');
		header('Accept-Ranges: bytes');
		header('Accept-Length:'.$size);
		header('Content-Disposition: attachment; filename='.$name);
		readfile($src);
		exit;
	}
}
?>