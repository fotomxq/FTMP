<?php
/**
 * 网站首页
 * 
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package web
 */

//引入全局
require('glob.php');
?>
<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="includes/assets/imgs/favicon.png">

    <title><?php echo $webData['WEB-TITLE']; ?></title>
    <link href="includes/assets/css/bootstrap.css" rel="stylesheet">
    <link href="includes/assets/css/index.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="includes/assets/js/html5shiv.js"></script>
      <script src="includes/assets/js/respond.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="navbar-wrapper">
      <div class="container">

        <div class="navbar navbar-inverse navbar-static-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">切换导航</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#"><img src="includes/assets/imgs/favicon.png" style="width:25px;max-height:25px;" alt="沈源机械设备"> 沈源机械设备</a>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">首页</a></li>
                <li><a href="#about">新闻</a></li>
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">产品 <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a href="#">产品A</a></li>
                    <li><a href="#">产品B</a></li>
                    <li><a href="#">产品C</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">产品D</li>
                    <li><a href="#">产品E</a></li>
                    <li><a href="#">产品F</a></li>
                  </ul>
                </li>
                <li><a href="#contact">关于</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><img src="includes/assets/imgs/ico-weixin.png" style="width:25px;max-height:25px;" alt="微信"></a></li>
                <li><a href="#"><img src="includes/assets/imgs/ico-qq.png" style="width:25px;max-height:25px;" alt="QQ"></a></li>
                <li><a href="#"><img src="includes/assets/imgs/ico-renren.png" style="width:25px;max-height:25px;" alt="人人网"></a></li>
                <li><a href="#"><img src="includes/assets/imgs/ico-weibo.png" style="width:25px;max-height:25px;" alt="微博"></a></li>
                <li><a href="#"><img src="includes/assets/imgs/ico-douban.png" style="width:25px;max-height:25px;" alt="豆瓣"></a></li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>


    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="item active">
          <img src="includes/assets/imgs/h1.jpg" style="width:900px;max-height:500px;" alt="幻灯片1">
          <div class="container">
            <div class="carousel-caption">
              <h1>幻灯片1</h1>
              <p>公司产品介绍1.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">了解更多</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <img src="includes/assets/imgs/h2.jpg" style="width:900px;max-height:500px;" alt="幻灯片2">
          <div class="container">
            <div class="carousel-caption">
              <h1>幻灯片2</h1>
              <p>公司产品介绍2</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">了解更多</a></p>
            </div>
          </div>
        </div>
        <div class="item">
          <img src="includes/assets/imgs/h3.jpg" style="width:900px;max-height:500px;" alt="幻灯片3">
          <div class="container">
            <div class="carousel-caption">
              <h1>幻灯片3</h1>
              <p>公司介绍信息.</p>
              <p><a class="btn btn-lg btn-primary" href="#" role="button">关于我们</a></p>
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->



    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container marketing">

      <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-lg-4">
          <img src="includes/assets/imgs/img1.png" class="img-circle" data-src="incld" style="width:140px;max-height:140px;" alt="产品展示图片">
          <h2>产品展示</h2>
          <p>在这里，您可以展示所有或主要的产品信息、分类。</p>
          <p><a class="btn btn-default" href="#" role="button">了解详情 &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img src="includes/assets/imgs/img2.png" class="img-circle" style="width:140px;max-height:140px;" alt="产品展示图片">
          <h2>产品展示</h2>
          <p>这个列表是无限制的。</p>
          <p><a class="btn btn-default" href="#" role="button">查看内容 &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img src="includes/assets/imgs/img3.png" class="img-circle" style="width:140px;max-height:140px;" alt="产品展示图片">
          <h2>产品购买</h2>
          <p>或者，您可以让产品订单快速下达。</p>
          <p><a class="btn btn-danger" href="#" role="button">立即购买 &raquo;</a></p>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->


      <!-- START THE FEATURETTES -->

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">产品A.<span class="text-muted">卓越工艺</span></h2>
          <p class="lead">产品A的相关介绍，或者在这里放置您的公司出产流程，让人们更了解贵公司。</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive" src="includes/assets/imgs/img1.png" style="width:500px;max-height:500px;" alt="产品A图片">
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-5">
          <img class="featurette-image img-responsive" src="includes/assets/imgs/img2.png" style="width:500px;max-height:500px;" alt="产品B图片">
        </div>
        <div class="col-md-7">
          <h2 class="featurette-heading">产品B<span class="text-muted">精雕细琢</span></h2>
          <p class="lead">图片越大，越能吸引人们的关注。</p>
        </div>
      </div>

      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7">
          <h2 class="featurette-heading">产品C<span class="text-muted">国际标准</span></h2>
          <p class="lead">内容越精简、越准确，可以得到更多顾客的信任。</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive" src="includes/assets/imgs/img3.png" style="width:500px;max-height:500px;" alt="产品C图片">
        </div>
      </div>

      <hr class="featurette-divider">

      <!-- /END THE FEATURETTES -->

            <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="col-lg-4">
          <img src="includes/assets/imgs/ico-weixin.png" style="width:140px;max-height:140px;" alt="产品展示图片">
          <h3>赞助商A</h3>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img src="includes/assets/imgs/ico-weibo.png" style="width:140px;max-height:140px;" alt="产品展示图片">
          <h3>赞助商B</h3>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
          <img src="includes/assets/imgs/ico-qq.png" style="width:140px;max-height:140px;" alt="产品展示图片">
          <h3>赞助商C</h3>
        </div><!-- /.col-lg-4 -->
      </div><!-- /.row -->

      <hr class="featurette-divider">


      <!-- FOOTER -->
      <footer>
        <p class="pull-right"><a href="#">回到顶部</a></p>
        <p>&copy; 2014 <?php echo $webData['WEB-TITLE']; ?> , 晋ICP备12008324号-1 &middot; <a href="#">联系我们</a> &middot; <a href="#">赞助合作</a> &middot; <a href="#">管理网站</a></p>
      </footer>

    </div><!-- /.container -->

    <script src="includes/assets/js/jquery.js"></script>
    <script src="includes/assets/js/bootstrap.js"></script>
  </body>
</html>
