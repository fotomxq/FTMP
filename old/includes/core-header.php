<?php

/**
 * header头信息操作类
 * @author liuzilu <fotomxq@gmail.com>
 * @version 4
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
     * 输出图像
     * <p>JPG类型</p>
     * @param string $src 文件路径
     * @param string $type 类型
     */
    static public function showImg($src, $type) {
        CoreHeader::toImg($type);
        $img = imagecreatefromjpeg($src);
        imagejpeg($img);
        imagedestroy($img);
    }

    /**
     * 输出Json
     * @param array $data 数据组
     */
    static public function toJson($data) {
        CoreHeader::noCache();
        header('Content-Type: text/plain, charset=utf-8');
        die(json_encode($data));
    }

    /**
     * 输出页面UTF-8编码
     * @param string $charset 编码
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

    /**
     * 输出HTML
     * @param  string $data HTML内容
     */
    static public function outHTML($data) {
        CoreHeader::noCache();
        CoreHeader::toPage();
        die($data);
    }

}

?>
