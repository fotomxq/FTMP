<?php

/**
 * header头信息操作类
 * @author fotomxq <fotomxq.me>
 * @version 2
 * @package core
 */
class CoreHeader {

    /**
     * 输出图片
     * @param string $type 图片类型 eg:png|jpeg|gif
     */
    static public function toImg($type = 'png') {
        header('Content-type: image/' . $type . ';charset=utf-8');
    }

    /**
     * 输出Json
     */
    static public function toJson() {
        header('Content-Type: text/plain, charset=utf-8');
    }

    /**
     * 输出页面UTF-8编码
     */
    static public function toPage($charset = 'utf-8') {
        header('Content-type: text/html; charset=' . $charset);
    }

    /**
     * 跳转URL
     * @param string $url URL
     */
    static public function toURL($url) {
        header('Location:' . $url);
    }

    /**
     * 拒绝缓冲
     */
    static public function noCache() {
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-cache, must-revalidate');
        header('Pragma: no-cache');
    }

    /**
     * 下载文件
     * @param int $size 大小
     * @param string $fileName 文件名
     * @param string $fileSrc 文件源
     */
    static public function downloadFile($size, $fileName, $fileSrc) {
        $file = fopen($fileSrc, "r");
        header("Content-type: application/octet-stream");
        header("Accept-Ranges: bytes");
        header("Accept-Length: " . $size);
        header("Content-Disposition: attachment; filename=" . $fileName);
        echo fread($file, $size);
        fclose($file);
    }

}

?>
