<?php
/**
 * 通用模版-全局设定
 * @author fotomxq <fotomxq.me>
 * @version 3
 * @package app-template
 */
//引用登录检测模块
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'glob.php');

//判断是否已经登录
$userID = $user->logged($ipAddr);
if($userID < 1){
	//如果没有登录，跳转到登录页面
	CoreHeader::toURL(WEB_URL.'/index.php');
}

//定义APP模版引用位置
define(DIR_APP_TEMPLATE,DIR_APP.DS.'template');

/**
 * 定义模版相关变量
 * array(
 * 'title' - 应用显示标题,
 * 'js' - 引用应用本地JS文件,
 * 'css' - 引用应用本地CSS文件,
 * 'glob'=>array( - 全局引用
 * 		'pack' - 引用组件
 * 					'messager' - 消息通知插件(注意要在下面引用对应的全局css主题文件才能正常使用),
 * 				 	'datetimepicker' - 日期选择插件,
 * 				 	'icheck' - 复选框美化插件(注意要在下面引用对应的全局css主题文件才能正常使用),
 * 				 	'chart' - 图表插件
 * 		,
 * 		'js' - 引用全局JS文件,
 * 		'css' - 引用全局CSS文件
 * 		),
 * 'temp'=>array( - 模版引用
 * 		'js' - 应用模版下的脚本,
 * 		'css' - 应用模版下的样式
 * 	 	),
 * 'menu-left'=>array( - 顶部左侧菜单
 * 		array( - 链接元素
 * 			'title' - 标题,
 * 		 	'url' - URL,
 * 		 	'active' - 是否激活状态(boolean),
 * 		 	'target' - 打开方式,如'_blank'
 * 		)
 * ),
 * 'menu-content-hide'=>true/false - 是否开启菜单跳转隐藏功能，自动隐藏其他无关内容
 * 'menu-content'=>array(array('#url...','#content...'),...) - 菜单跳转URL对应的内容，如果menu-content-hide开启有效
 * );
 */
$appPage;
?>