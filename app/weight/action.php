<?php
/**
 * 体重Action-Ajax处理器
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package app-weight-action
 */
//引用全局
require('glob.php');

//引用体重处理器
require('app-weight.php');

//创建体重处理器对象
$appWeight = new AppWeight($db,$appList['weight']['table'][0],$userID);

if(isset($_GET['type']) == true){
	switch($_GET['type']){
		case 'get':
			if(isset($_GET['start']) == true){
				$start = $filter->getString($_GET['start'],10,0,true,true);
				$end = null;
				if(isset($_GET['end']) == true){
					$end = $filter->getString($_GET['end'],10,0,true,true);
				}
				$res = $appWeight->view($start,$end);
				if($res){
					CoreHeader::toJson($res);
				}
			}
		break;
		case 'set':
		break;
	}
}
?>