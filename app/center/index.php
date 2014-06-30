<?php
/**
 * 中心页面
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-26 17:47:04
 * @version 1
 */

//引用全局
require('glob.php');

//设定页面引用
$pageIncludes = array('app'=>array('css'=>array('index.css')));

//设定页面参数
$appPages = array('title'=>'中心');

//用户是否为管理员
$checkPowers = $user->checkPower($userID,array('ADMIN'));

//所有应用名称及所在目录
$apps = array('center');

//获取用户所有可用应用
$checkApps = $user->checkApp($userID,$apps);

//引用头模版
require(DIR_APP_TEMPALTE.DS.'header.php');
?>
<div class="site-wrapper">
  <div class="site-wrapper-inner">
    <div class="cover-container">
    <?php require('menu.php'); ?>
      <div class="inner cover">
      	<div class="row">
	      	<div class="col-lg-4">
	          <a href="#" target="_self"><img class="img-circle" src="../health/assets/imgs/favicon.png" alt="Generic placeholder image" style="width: 100px; height: 100px;"></a>
	          <h2>健康</h2>
	          <p>活着比什么都重要</p>
	        </div>
	        <div class="col-lg-4">
	          <a href="#" target="_self"><img class="img-circle" src="../resources/assets/imgs/favicon.png" alt="Generic placeholder image" style="width: 100px; height: 100px;"></a>
	          <h2>资源</h2>
	          <p>整整齐齐多省心</p>
	        </div>
	        <div class="col-lg-4">
	          <a href="#" target="_self"><img class="img-circle" src="../finance/assets/imgs/favicon.png" alt="Generic placeholder image" style="width: 100px; height: 100px;"></a>
	          <h2>财务</h2>
	          <p>票子都去哪里了</p>
	        </div>
      	</div>
      	<div class="row row-fix">
	      	<div class="col-lg-4">
	          <a href="#" target="_self"><img class="img-circle" src="../home/assets/imgs/favicon.png" alt="Generic placeholder image" style="width: 100px; height: 100px;"></a>
	          <h2>家庭</h2>
	          <p>快看那是我小时候</p>
	        </div>
	        <div class="col-lg-4">
	          <a href="#" target="_self"><img class="img-circle" src="../interpersonal/assets/imgs/favicon.png" alt="Generic placeholder image" style="width: 100px; height: 100px;"></a>
	          <h2>人际</h2>
	          <p>人脉是成功的源泉</p>
	        </div>
	        <div class="col-lg-4">
	          <a href="#" target="_self"><img class="img-circle" src="../log/assets/imgs/favicon.png" alt="Generic placeholder image" style="width: 100px; height: 100px;"></a>
	          <h2>日志</h2>
	          <p>用小本本记住你</p>
	        </div>
      	</div>
      </div>
      <?php require('footer.php'); ?>
    </div>
  </div>
</div>
<?php
//引用尾部模版
require(DIR_APP_TEMPALTE.DS.'footer.php');
?>