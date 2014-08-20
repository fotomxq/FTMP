<?php

/**
 * APP-PEX测试
 * @author liuzilu <fotomxq.me>
 * @date    2014-07-25 20:07
 * @version 1
 */

//引用全局
require('glob-db.php');

header('Content-Type: text/plain, charset=utf-8');

//测试中文或其他文字文件或文件夹查看、访问问题
//echo DIR_DATA;
//echo '<br/>';

$dirList = glob(DIR_DATA . '\*');
print_r($dirList);
$fileContent = file_get_contents($dirList[0]);
echo $fileContent;
$c = json_encode($dirList);

print_r($c);
?>