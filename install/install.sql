-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014-03-14 01:31:03
-- 服务器版本: 5.6.14
-- PHP 版本: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ftmp`
--

-- --------------------------------------------------------

--
-- 表的结构 `center_app`
--

CREATE TABLE IF NOT EXISTS `center_app` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `app_name` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '应用名称',
  `app_des` text COLLATE utf8_bin COMMENT '应用描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `center_file`
--

CREATE TABLE IF NOT EXISTS `center_file` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引',
  `file_name` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '文件名',
  `file_type` varchar(10) COLLATE utf8_bin DEFAULT NULL COMMENT '文件类型',
  `file_size` bigint(20) NOT NULL COMMENT '文件大小',
  `file_sha1` varchar(41) COLLATE utf8_bin NOT NULL COMMENT '文件SHA1值',
  `file_upload_time` datetime NOT NULL COMMENT '文件上传时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `center_file_storage`
--

CREATE TABLE IF NOT EXISTS `center_file_storage` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `file_id` bigint(20) NOT NULL COMMENT '文件ID',
  `storage_id` int(11) NOT NULL COMMENT '保存点ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `center_log`
--

CREATE TABLE IF NOT EXISTS `center_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `log_app` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '应用名称',
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `center_storage`
--

CREATE TABLE IF NOT EXISTS `center_storage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `st_name` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '名称',
  `st_connect` text COLLATE utf8_bin NOT NULL COMMENT '连接参数',
  `st_max_size` bigint(20) NOT NULL COMMENT '配额大小KB',
  `st_size` bigint(20) NOT NULL COMMENT '当前使用KB',
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
-- 表的结构 `center_user_info`
--

CREATE TABLE IF NOT EXISTS `center_user_info` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `user_id` bigint(20) NOT NULL COMMENT '用户ID',
  `app_id` int(10) NOT NULL COMMENT 'APP ID',
  `info_name` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '标识名',
  `info_value` text COLLATE utf8_bin COMMENT '值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `px_post`
--

CREATE TABLE IF NOT EXISTS `px_post` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `post_title` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '标题',
  `file_id` bigint(20) DEFAULT NULL COMMENT '文件ID',
  `post_parent` bigint(20) NOT NULL COMMENT '上一级ID',
  `post_size` bigint(20) NOT NULL COMMENT '大小',
  `post_upload_time` datetime NOT NULL COMMENT '上传时间',
  `post_read_time` datetime NOT NULL COMMENT '最后访问时间',
  `post_count` bigint(20) NOT NULL COMMENT '访问次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `weight_post`
--

CREATE TABLE IF NOT EXISTS `weight_post` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `user_id` bigint(20) NOT NULL COMMENT '用户ID',
  `weight_kg` float NOT NULL COMMENT '重量KG',
  `weight_time` datetime NOT NULL COMMENT '记录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
