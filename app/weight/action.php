<?php
/**
 * 体重Action-Ajax处理器
 * @author fotomxq <fotomxq.me>
 * @version 2
 * @package app-weight-action
 */
//引用全局
require('glob.php');

//引用体重处理器
require('app-weight.php');

//创建体重处理器对象
$appWeight = new AppWeight($db,$appList['weight']['table'][0],$userID);
//缓冲标记
$appWeightCacheName = 'WEIGHT-DATA';
//获取缓冲
$appWeightData = $cache->get($appWeightCacheName);
if($appWeightData){
	$appWeightData = json_decode($appWeightData,true);
}

if(isset($_GET['type']) == true){
	switch($_GET['type']){
		//获取时间段内的值
		case 'get':
			if(isset($_GET['start']) == true){
				$start = $filter->getString($_GET['start'],10,0,true,true);
				$end = null;
				if(isset($_GET['end']) == true){
					if($_GET['end']){
						$end = $filter->getString($_GET['end'],10,0,true,true);
					}
				}
				$cacheName = $start.'-'.$end;
				$res;
				if(isset($appWeightData[$cacheName])){
					$res = $appWeightData[$cacheName];
				}else{
					$res = $appWeight->view($start,$end);
					$cache->set($cacheName,json_encode($res));
				}
				if($res){
					CoreHeader::toJson($res);
				}
			}
		break;
		//获取某个区间的值
		case 'interval':
			if(isset($_GET['i']) == true && isset($_GET['t']) == true){
				$type = $_GET['t'] == 'weight' ? 3 : 4;
				switch($_GET['i']){
					case 'year':
						$nowDateY = date('Y');
						$cacheName = 'INTERVAL-YEAR';
						$arr;
						if(isset($appWeightData[$cacheName])){
							$arr = $appWeightData[$cacheName];
						}else{
							for($i=1;$i<13;$i++){
								$j = $i;
								if(strlen($i) < 2){
									$j = '0'.$i;
								}
								$dateLeft = $nowDateY.'-'.$j.'-01';
								$dateRight = $nowDateY.'-'.$j.date('t',$dateLeft);
								$avg = $appWeight->view($dateLeft,$dateRight,$type);
								$arr[$i-1] = round($avg,2);
							}
							$cache->set($cacheName,json_encode($arr));
						}
						if($arr){
							CoreHeader::toJson($arr);
						}
					break;
				}
			}
		break;
		//设定值
		case 'set':
			if(isset($_POST['weight']) == true){
				$weight = (float)$_POST['weight'];
				$date = isset($_POST['date']) == true ? $_POST['date'] : null;
				$fat = isset($_POST['fat']) == true ? $_POST['fat'] : null;
				$note = isset($_POST['note']) == true ? $_POST['note'] : null;
				$tagDinner = isset($_POST['tagDinner']) == true ? $_POST['tagDinner'] : false;
				$tagSport = isset($_POST['tagSport']) == true ? $_POST['tagSport'] : false;
				$tagSleep = isset($_POST['tagSleep']) == true ? $_POST['tagSleep'] : false;
				$tagToilet = isset($_POST['tagToilet']) == true ? $_POST['tagToilet'] : false;
				$tagSick = isset($_POST['tagSick']) == true ? $_POST['tagSick'] : false;
				$tagAlcohol = isset($_POST['tagAlcohol']) == true ? $_POST['tagAlcohol'] : false;
				$res = $appWeight->set($weight,$date,$fat,$note,$tagDinner,$tagSport,$tagSleep,$tagToilet,$tagSick,$tagAlcohol);
				if($res == true){
					$cache->clear($appWeightCacheName);
					CoreHeader::outHTML('true');
				}
			}
			CoreHeader::outHTML('false');
		break;
	}
}
?>