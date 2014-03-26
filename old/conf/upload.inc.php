<?php

/**
 * 上传文件设定
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package config
 */
//允许的文件类型
define('UPLOAD_TYPE', 'jpg,png,gif,wmp,zip,rar,pdf,txt,mp3,mp4,avi,mpeg');
//拒绝的文件类型
define('UPLOAD_BAN_TYPE', 'exe,bat,sh,php,html,htm,msi');
//允许的图片文件类型
define('UPLOAD_IMG_TYPE', 'jpg,png');
//允许的个人简历文件类型
define('UPLOAD_CANDADITES_TYPE', 'doc,docx');
//是否开启总白名单
define('UPLOAD_TYPE_ON', false);
//是否开启黑名单
define('UPLOAD_BAN_TYPE_ON', true);
//是否开启图片白名单
define('UPLOAD_IMG_TYPE_ON', true);
//最大文件大小 (KB)
define('UPLOAD_SIZE_MAX', 51200);
//如果图片超出尺寸是否自动压缩图片
define('UPLOAD_IMG_SIZE_P_ON', true);
//图片最大尺寸
define('UPLOAD_IMG_SIZE_W', 3000);
define('UPLOAD_IMG_SIZE_H', 3000);
//是否直接跳转到文件下载，否则通过脚本下载
define('UPLOAD_DOWN_PHP', true);
?>