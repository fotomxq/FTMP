<?php
/**
 * 页面尾部模版
 * @author liuzilu <fotomxq@gmail.com>
 * @date    2014-06-26 17:49:46
 * @version 1
 */
?>
    <script src="../../includes/assets/js/jquery.js"></script>
    <script src="../../includes/assets/js/bootstrap.js"></script>
    <?php
    //引用全局、模版、应用的JS文件
    if(isset($pageIncludes) == true){
    	if(isset($pageIncludes['glob']) == true){
    		if(isset($pageIncludes['glob']['js']) == true){
    			foreach($pageIncludes['glob']['js'] as $v){
    				echo '<script src="../../includes/assets/js/'.$v.'"></script>';
    			}
    		}
    	}
    	if(isset($pageIncludes['template']) == true){
    		if(isset($pageIncludes['template']['js']) == true){
    			foreach($pageIncludes['template']['js'] as $v){
    				echo '<script src="../template/assets/js/'.$v.'"></script>';
    			}
    		}
    	}
    	if(isset($pageIncludes['app']) == true){
    		if(isset($pageIncludes['app']['js']) == true){
    			foreach($pageIncludes['app']['js'] as $v){
    				echo '<script src="../'.$appName.'/assets/js/'.$v.'"></script>';
    			}
    		}
    	}
    }
    ?>
  </body>
</html>
<?php
//保存缓冲模版，其他保存缓冲可参数该部分代码
/*
if($webDateCache == false){
	$cache->set($cacheWebDataName, json_encode($webData));
}
*/

//
?>