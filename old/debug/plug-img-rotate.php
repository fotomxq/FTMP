<?php

//旋转图片测试
require('glob-db.php');
require(DIR_LIB . DS . 'plug-img-rotate.php');

//旋转图片
$fileName = '../content/pex/file/2014\07\06\20140706213105_4761f13f90ea483feb577071da0de9303179782c.jpg';

PlugImgRotate($fileName, 270);

?>
<img src="<?php echo $fileName; ?>" style="max-width: 1000px;">