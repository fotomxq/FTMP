<?php
/**
 * 页面顶部模版
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-26 17:48:17
 * @version 1
 */
/**
 * 1.注意(必须)定义$appName，用于描述当前使用的APP名称.
 * 2.注意(必须)定义$appPages，用于该应用的通用参数，描述如下:
 *   $appPages = array(
 *                     'title'=>'小标题'
 *                     );
 * 
 * 3.注意(非必须)定义页面通用参数，用于引用CSS\JS等文件，一部分JS位于页面尾部输出，以下是该变量模版:
 *   $pageIncludes = array('glob'=>array( //全局引用
 *                                       'css'=>array('a.css','b.css',...), //全局CSS文件引用
 *                                       'js'=>array('a.js','b.js',...), //全局CSS文件引用
 *                                       'ie'=>array( //全局针对IE引用的文件
 *                                                   'css'=>array(...)
 *                                                   'js'=>array(...)
 *                                                   )
 *                                       ),
 *                         'template'=>array( //模版引用
*                                       'css'=>array(...),
*                                       'js'=>array(...),
*                                       'ie'=>array(
*                                                   'css'=>array(...)
*                                                   'js'=>array(...)
*                                                   )
*                                       ),
 *                         'app'=>array( //APP内引用
*                                       'css'=>array(...),
*                                       'js'=>array(...),
*                                       'ie'=>array(
*                                                   'css'=>array(...)
*                                                   'js'=>array(...)
*                                                   )
*                                       )
 *                         );
 */
?>
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../includes/assets/imgs/favicon.png">
    <title><?php echo $appPages['title'].' - '.$webData['WEB-TITLE']; ?></title>
    <link href="../../includes/assets/css/bootstrap.css" rel="stylesheet">
    <?php
      //引用全局、模版、应用CSS文件
      if(isset($pageIncludes) == true){
        if(isset($pageIncludes['glob']) == true){
          if(isset($pageIncludes['glob']['css']) == true){
            foreach($pageIncludes['glob']['css'] as $v){
              echo '<link href="../../includes/assets/css/'.$v.'" rel="stylesheet">';
            }
          }
        }
        if(isset($pageIncludes['template']) == true){
          if(isset($pageIncludes['template']['css']) == true){
            foreach($pageIncludes['template']['css'] as $v){
              echo '<link href="../template/assets/css/'.$v.'" rel="stylesheet">';
            }
          }
        }
        if(isset($pageIncludes['app']) == true){
          if(isset($pageIncludes['app']['css']) == true){
            foreach($pageIncludes['app']['css'] as $v){
              echo '<link href="../'.$appName.'/assets/css/'.$v.'" rel="stylesheet">';
            }
          }
        }
      }
    ?>

    <!--[if lt IE 9]>
      <script src="../../includes/assets/js/html5shiv.js"></script>
      <script src="../../includes/assets/js/respond.js"></script>
      <?php
        //引用全局、模版、应用对IE支持的CSS、JS文件
        if(isset($pageIncludes) == true){
          if(isset($pageIncludes['glob']) == true){
            if(isset($pageIncludes['glob']['ie']) == true){
              if(isset($pageIncludes['glob']['ie']['css']) == true){
                foreach($pageIncludes['glob']['ie']['css'] as $v){
                  echo '<link href="../../includes/assets/css/'.$v.'" rel="stylesheet">';
                }
              }
              if(isset($pageIncludes['glob']['ie']['js']) == true){
                foreach($pageIncludes['glob']['ie']['js'] as $v){
                  echo '<script src="../../includes/assets/js/'.$v.'"></script>';
                }
              }
            }
          }
          if(isset($pageIncludes['template']) == true){
            if(isset($pageIncludes['template']['css']) == true){
              if(isset($pageIncludes['template']['ie']['css']) == true){
                foreach($pageIncludes['template']['ie']['css'] as $v){
                  echo '<link href="../template/assets/css/'.$v.'" rel="stylesheet">';
                }
              }
              if(isset($pageIncludes['template']['ie']['js']) == true){
                foreach($pageIncludes['template']['ie']['js'] as $v){
                  echo '<script src="../template/assets/js/'.$v.'"></script>';
                }
              }
            }
          }
          if(isset($pageIncludes['app']) == true){
            if(isset($pageIncludes['app']['css']) == true){
              if(isset($pageIncludes['app']['ie']['css']) == true){
                foreach($pageIncludes['app']['ie']['css'] as $v){
                  echo '<link href="../'.$appName.'/assets/css/'.$v.'" rel="stylesheet">';
                }
              }
              if(isset($pageIncludes['app']['ie']['js']) == true){
                foreach($pageIncludes['app']['ie']['js'] as $v){
                  echo '<script src="../'.$appName.'/assets/js/'.$v.'"></script>';
                }
              }
            }
          }
        }
      ?>
    <![endif]-->
  </head>

  <body>