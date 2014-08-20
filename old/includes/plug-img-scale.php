<?php

/**
 * 菜单页面
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-07-06 18:33:00
 * @version 1
 */

/**
 * 缩放GD图像
 * @param GD $img 图像对象
 * @param int $maxW 最宽
 * @param int $maxH 最高
 * @return GD 新的图像
 */
function PlugImgScale(&$img, $maxW, $maxH) {
    $srcW = imagesx($img);
    $srcH = imagesy($img);
    if ($srcW > 10 && $srcH > 10) {
        $newW;
        $newH;
        $cutW = $srcW - $maxW;
        $cutH = $srcH - $maxH;
        if ($cutW > 0 || $cutH > 0) {
            $p = 1;
            if ($cutW > $cutH) {
                $p = $cutW / $srcW;
            } else {
                $p = $cutH / $srcH;
            }
            $p = 1 - $p;
            $newW = floor($srcW * $p);
            $newH = floor($srcH * $p);
            if ($newW == 0) {
                $newW = 1;
            }
            if ($newH == 0) {
                $newH = 1;
            }
        } else {
            $newW = $srcW;
            $newH = $srcH;
        }
        $newImg = imagecreatetruecolor($newW, $newH);
        imagecopyresampled($newImg, $img, 0, 0, 0, 0, $newW, $newH, $srcW, $srcH);
        return $newImg;
    }
    return $img;
}

?>
