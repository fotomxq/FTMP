<?php
/**
 * 菜单页面
 * @authors fotomxq <fotomxq.me>
 * @date    2014-06-28 23:04:30
 * @version 2
 */
?>
<ul class="nav nav-pills pull-right" id="menu">
  <li><a href="#release" data-toggle="modal" data-target="#uploadModal">发布</a></li>
  <li class="active"><a href="#folder-photo">照片</a></li>
  <li><a href="#folder-movie">影片</a></li>
  <li><a href="#folder-cartoon">漫画</a></li>
  <li><a href="#folder-txt">文本</a></li>
  <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">
          操作 <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role="menu">
          <li><a href="#mode-operate">操作模式</a></li>
          <li><a href="#mode-view">预览模式</a></li>
          <li><a href="#mode-phone">手机模式</a></li>
          <li class="divider"></li>
          <li><a href="#clear-cache">清理缓冲</a></li>
      </ul>
  </li>
  <li><a href="#set" data-toggle="modal" data-target="#setModal">设置</a></li>
  <li><a href="../center/index.php" target="_self">中心</a></li>
</ul>