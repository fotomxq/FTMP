<?php

/**
 * 中心页面脚部
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-06-27 11:19:30
 * @version 3
 */
//根据应用以及标示生成缓冲
$centerFooterCacheKey = $appPages['key'] . '-APP-FOOTER';
$centerFooterCache = $cache->get($centerFooterCacheKey);
if (!$centerFooterCache) {
    $centerFooterCache = '<div class="mastfoot"><div class="inner"><p>&copy; ' . $webData['WEB-TITLE'] . '</p></div></div>';
    $cache->set($centerFooterCacheKey, $centerFooterCache);
}
echo $centerFooterCache;
unset($centerFooterCacheKey, $centerFooterCache);
?>