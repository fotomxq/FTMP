<?php

/**
 * 日志查看页面
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-07-17 14:58:11
 * @version 1
 */
//引用全局
require('glob.php');

//设定页面引用
$pageIncludes['app'] = array(
    'css' => array('index.css', 'js.css'),
    'js' => array('log.js')
);
$pageIncludes['template'] = array(
    'js' => array('message.js', 'ajax.js')
);

//设定页面参数
$appPages = array('title' => '日志查询', 'key' => 'CENTER-LOG');

//引用头模版
require(DIR_APP_TEMPALTE . DS . 'header.php');
?>
<div class="site-wrapper">
    <div class="site-wrapper-inner">
        <div class="cover-container">
            <div class="masthead clearfix">
                <div class="inner">
                    <h3 class="masthead-brand"><?php echo $appPages['title']; ?></h3>
                    <ul class="nav masthead-nav"> 
                        <li class="active">
                            <a href="index.php" target="_self">首页</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="inner cover center-content" id="log-content">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>消息</th>
                        </tr>
                    </thead>
                    <tbody id="log-list" data-log-type="<?php echo LOG_TYPE; ?>" data-log-on="<?php echo LOG_ON ? '1' : '0'; ?>">
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
                <ul class="pager">
                    <li><a href="#page-index">首页</a></li>
                    <li><a href="#page-prev">上一个文件</a></li>
                    <li id="page-show"></li>
                    <li><a href="#page-next">下一个文件</a></li>
                    <li><a href="#page-end">末页</a></li>
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