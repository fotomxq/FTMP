<?php
//缓冲器测试

require('glob.php');

require(DIR_LIB.DS.'core-cache.php');

//建立对象
$coreCache = new CoreCache(CACHE_ON,CACHE_LIMIT_TIME,CACHE_DIR);

//基础变量
$testName = 'testname';
$testValue = 'testValue...';

//测试缓冲建立
echo '测试缓冲建立 : ';

if($coreCache->set($testName,$testValue) == true){
	echo 'OK.';
}else{
	echo 'Faild.';
}

echo '<br/>---------------------<br/><br/>';

//测试缓冲获取
echo '测试获取缓冲 : ';
$cache = $coreCache->get($testName);
echo $cache;
echo '<br/>---------------------<br/><br/>';

//强制清理缓冲
echo '强制清理缓冲 : ';
if($coreCache->clear() == true){
	echo 'OK.';
}else{
	echo 'Faild.';
}
?>