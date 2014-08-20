<?php

/**
 * 中心页面头部
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-06-27 11:20:47
 * @version 5
 */
//根据应用以及标示生成缓冲
$centerMenuCacheKey = $appPages['key'] . '-MENU';
$centerMenuCache = $cache->get($centerMenuCacheKey);
if (!$centerMenuCache) {
    $centerMenuCache = '<div class="masthead clearfix"><div class="inner"><h3 class="masthead-brand">' . $appPages['title'] . '</h3><ul class="nav masthead-nav"> <li class="active"><a href="../center/index.php" target="_self">首页</a></li><li><a href="#" data-toggle="modal" data-target="#userModal">个人用户</a></li>';
    if ($checkPowers['ADMIN'] === true) {
        $centerMenuCache .= '<li><a href="#" data-toggle="modal" data-target="#systemModal">系统设置</a></li>';
    }
    $centerMenuCache.= '</ul></div></div>';
    $cache->set($centerMenuCacheKey, $centerMenuCache);
}
echo $centerMenuCache;
unset($centerMenuCacheKey, $centerMenuCache);
?>