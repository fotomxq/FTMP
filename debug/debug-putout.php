<?php

/**
 * 发布执行代码
 * <p>删除注释并混淆代码</p>
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package debug
 */
require('glob.php');

require(DIR_LIB.DS.'core-file.php');

//清理注释和空格处理器
function strip($dir = null) {
    $fileList = null;
    if ($dir == null) {
        $search = '*';
    } else {
        $search = $dir . '/*';
    }
    $fileList = CoreFile::searchDir($search);
    if ($fileList) {
        foreach ($fileList as $v) {
            if (is_dir($v) == true) {
                strip($v);
            } else {
                $content = php_strip_whitespace($v);
                file_put_contents($v, $content);
            }
        }
    }
}

//执行去注释和空格
$dir = '..';
strip($dir);

?>
