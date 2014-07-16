<?php

/**
 * 页面尾部模版
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-06-26 17:49:46
 * @version 3
 */
//根据应用以及标示生成缓冲
$tempFooterCacheKey = $appPages['key'] . '-TEMPLATE-FOOTER';
$tempFooterCache = $cache->get($tempFooterCacheKey);
if (!$tempFooterCache) {
    $tempFooterCache = '<script src="../../includes/assets/js/jquery.js"></script><script src="../../includes/assets/js/bootstrap.js"></script>';
    //引用全局、模版、应用的JS文件
    if (isset($pageIncludes) == true) {
        if (isset($pageIncludes['glob']) == true) {
            if (isset($pageIncludes['glob']['js']) == true) {
                foreach ($pageIncludes['glob']['js'] as $v) {
                    $tempFooterCache .= '<script src="../../includes/assets/js/' . $v . '"></script>';
                }
            }
        }
        if (isset($pageIncludes['template']) == true) {
            if (isset($pageIncludes['template']['js']) == true) {
                foreach ($pageIncludes['template']['js'] as $v) {
                    $tempFooterCache .= '<script src="../template/assets/js/' . $v . '"></script>';
                }
            }
        }
        if (isset($pageIncludes['app']) == true) {
            if (isset($pageIncludes['app']['js']) == true) {
                foreach ($pageIncludes['app']['js'] as $v) {
                    $tempFooterCache .= '<script src="../' . $appName . '/assets/js/' . $v . '"></script>';
                }
            }
        }
    }
    $tempFooterCache .= '</body></html>';
    $cache->set($tempFooterCacheKey, $tempFooterCache);
}
echo $tempFooterCache;
unset($tempFooterCacheKey, $tempFooterCache);
?>