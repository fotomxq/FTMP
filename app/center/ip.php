<?php

/**
 * 查看IP页面
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-06-26 17:43:38
 * @version 1
 */
//引用全局
require('glob.php');

//设定页面引用
$pageIncludes['app'] = array(
    'css' => array('index.css'),
    'js' => array('ip.js')
);
$pageIncludes['template'] = array(
    'js' => array('message.js', 'ajax.js')
);

//设定页面参数
$appPages = array('title' => 'IP查询', 'key' => 'CENTER-IP');

//引用头模版
require(DIR_APP_TEMPALTE . DS . 'header.php');
?>
<div class="site-wrapper">
    <div class="site-wrapper-inner">
        <div class="cover-container">
            <div class="masthead clearfix">
                <div class="inner">
                    <h3 class="masthead-brand"><?php echo $webData['WEB-TITLE'] . ' ' . $appPages['title']; ?> </h3>
                    <ul class="nav masthead-nav"> 
                        <li class="active">
                            <a href="index.php" target="_self">首页</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="inner cover center-content" id="center-content">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>地址</th>
                            <th>是否拉黑</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <a href="#" class="btn btn-info">真实地址</a>
                                <a href="#" class="btn btn-danger">拉黑</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <ul class="pager">
                    <li><a href="#">上一页</a></li>
                    <li><a href="#">下一页</a></li>
                </ul>
            </div>
            <?php require('footer.php'); ?>
        </div>
    </div>
</div>
<?php
//引用尾部模版
require(DIR_APP_TEMPALTE . DS . 'footer.php');
?>