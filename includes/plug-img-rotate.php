<?php

/**
 * 旋转图片
 * <p>只支持jpg格式.</p>
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-07-06 21:34:00
 * @version 1
 */
function PlugImgRotate($src, $rotate) {
    $img = @imagecreatefromjpeg($src);
    $img = @imagerotate($img, $rotate, 0);
    @imagejpeg($img, $src, 100);
    @imagedestroy($img);
    return true;
}
