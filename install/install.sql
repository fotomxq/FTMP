-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014-02-13 04:35:47
-- 服务器版本: 5.6.14
-- PHP 版本: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- 数据库: `ftmp`
--

-- --------------------------------------------------------

--
-- 表的结构 `center_app`
--

CREATE TABLE IF NOT EXISTS `center_app` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `app_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT 'APP标识名称',
  `app_title` varchar(300) COLLATE utf8_bin NOT NULL COMMENT 'APP显示名称',
  `app_dir` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '所属目录名称',
  `app_table_list` text COLLATE utf8_bin COMMENT '数据表列表',
  `app_des` text COLLATE utf8_bin COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `center_app`
--

INSERT INTO `center_app` (`id`, `app_name`, `app_title`, `app_dir`, `app_table_list`, `app_des`) VALUES
(1, 'px', 'PX工具', 'px', 'px_file|px_sort|px_tag|px_tag_bind', 'PX工具集合，帮助您整理相关资料，需要输入密码才能进入。');

-- --------------------------------------------------------

--
-- 表的结构 `center_log`
--

CREATE TABLE IF NOT EXISTS `center_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `log_time` datetime NOT NULL COMMENT '创建时间',
  `log_ip` varchar(39) COLLATE utf8_bin NOT NULL COMMENT 'IP',
  `log_message` text COLLATE utf8_bin NOT NULL COMMENT '消息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `center_reg`
--

CREATE TABLE IF NOT EXISTS `center_reg` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `reg_app` int(11) NOT NULL COMMENT '注册APP ID',
  `reg_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '标识名称',
  `reg_value` text COLLATE utf8_bin COMMENT '值',
  `reg_default` text COLLATE utf8_bin COMMENT '默认值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `center_user`
--

CREATE TABLE IF NOT EXISTS `center_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_name` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '名字',
  `user_username` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '用户名',
  `user_password` varchar(41) COLLATE utf8_bin NOT NULL COMMENT '用户密码SHA1',
  `user_create_time` datetime NOT NULL COMMENT '创建时间',
  `user_login_time` datetime NOT NULL COMMENT '最后一次登录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `center_user`
--

INSERT INTO `center_user` (`id`, `user_name`, `user_username`, `user_password`, `user_create_time`, `user_login_time`) VALUES
(1, '刘子路', 'fotomxq@163.com', '0e5d798a3fce20e99035e6f39fea27fc2e12283f ', '2014-02-12 00:00:00', '2014-02-12 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `px_file`
--

CREATE TABLE IF NOT EXISTS `px_file` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `file_title` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '文件名称',
  `file_create_time` datetime NOT NULL COMMENT '创建时间',
  `file_sha1` varchar(41) COLLATE utf8_bin NOT NULL COMMENT '文件SHA1',
  `file_size` bigint(20) NOT NULL COMMENT '文件大小',
  `file_type` varchar(15) COLLATE utf8_bin NOT NULL COMMENT '文件类型',
  `file_sort` bigint(20) NOT NULL COMMENT '文件所属分类ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `px_sort`
--

CREATE TABLE IF NOT EXISTS `px_sort` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `sort_title` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '分类标题',
  `sort_create_time` datetime NOT NULL COMMENT '分类创建时间',
  `sort_size` bigint(20) NOT NULL COMMENT '分类内容总量',
  `sort_parent` bigint(20) NOT NULL COMMENT '分类所属上一级ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `px_tag`
--

CREATE TABLE IF NOT EXISTS `px_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `tag_title` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '标签名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `px_tag_bind`
--

CREATE TABLE IF NOT EXISTS `px_tag_bind` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `tag_id` bigint(20) NOT NULL COMMENT '标签ID',
  `file_id` bigint(20) NOT NULL COMMENT '文件ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
