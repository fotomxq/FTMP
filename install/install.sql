-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014-06-20 04:35:55
-- 服务器版本: 5.6.14
-- PHP 版本: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- 数据库: `ftmp`
--

-- --------------------------------------------------------

--
-- 表的结构 `sys_config`
--

CREATE TABLE IF NOT EXISTS `sys_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `config_name` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '名称',
  `config_value` longtext COLLATE utf8_bin NOT NULL COMMENT '值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `sys_config`
--

INSERT INTO `sys_config` (`id`, `config_name`, `config_value`) VALUES
(1, 'WEB-TITLE', 'FTM Personal'),
(2, 'USER-LIMIT-TIME', '1800'),
(3, 'USER-VCODE-OPEN', '1'),
(4, 'SYNC-VERSION', '1'),
(5, 'UPLOAD-TYPE', 'jpg,png,gif,jpeg,wmp,zip,rar,7z,pdf,doc,docx,ppt,cvs,xls,txt,wma,wmv,mp3,mp4,avi,mpeg'),
(6, 'UPLOAD-BAN-TYPE', 'exe,bat,sh,php,html,htm,msi'),
(7, 'UPLOAD-IMG-TYPE', 'jpg,png,gif'),
(8, 'UPLOAD-SIZE-MAX', '51200'),
(9, 'UPLOAD-IMG-CACHE-ON', 'true'),
(10, 'UPLOAD-DOWN-PHP', 'true'),
(11, 'VISITOR-USER', '1'),
(12, 'VISITOR-USER-GROUP', '1'),
(13, 'WEB-MAINT-ON', '0');

-- --------------------------------------------------------

--
-- 表的结构 `sys_file`
--

CREATE TABLE IF NOT EXISTS `sys_file` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引',
  `file_name` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '原始文件名',
  `file_src` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '路径',
  `file_date` datetime NOT NULL COMMENT '上传时间',
  `file_sha1` varchar(41) COLLATE utf8_bin NOT NULL COMMENT 'SHA1',
  `file_size` bigint(20) NOT NULL COMMENT '大小kb',
  `file_type` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `sys_file`
--

INSERT INTO `sys_file` (`id`, `file_name`, `file_src`, `file_date`, `file_sha1`, `file_size`, `file_type`) VALUES
(2, 'javascript-date.png', '201404/16/78abc5f74b5b8f9cadc9c5b64f47e37b7a212439', '2014-04-16 16:06:02', '78abc5f74b5b8f9cadc9c5b64f47e37b7a212439', 605, 'image/png'),
(3, 'javascript-array.png', '201404/16/e7da6163032650d4bee4ccca0adc095cd241ba13_2969', '2014-04-16 16:34:20', 'e7da6163032650d4bee4ccca0adc095cd241ba13', 409, 'image/png'),
(4, 'javascript-array.png', '201404/16/e7da6163032650d4bee4ccca0adc095cd241ba13_3519', '2014-04-16 16:34:36', 'e7da6163032650d4bee4ccca0adc095cd241ba13', 409, 'image/png'),
(5, 'jquery.png', '201404/16/f08348a7df59eb1af422b28a88920c2f9ea0d08b_3920', '2014-04-16 16:37:06', 'f08348a7df59eb1af422b28a88920c2f9ea0d08b', 378, 'image/png'),
(6, 'jquery.png', '201404/16/f08348a7df59eb1af422b28a88920c2f9ea0d08b_1454', '2014-04-16 16:53:20', 'f08348a7df59eb1af422b28a88920c2f9ea0d08b', 378, 'image/png');

-- --------------------------------------------------------

--
-- 表的结构 `sys_file_server`
--

CREATE TABLE IF NOT EXISTS `sys_file_server` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引',
  `file_id` bigint(20) NOT NULL COMMENT '文件ID',
  `server_id` int(11) NOT NULL COMMENT '服务器ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `sys_ip`
--

CREATE TABLE IF NOT EXISTS `sys_ip` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引',
  `ip_addr` varchar(100) COLLATE utf8_bin NOT NULL COMMENT 'IP地址',
  `ip_real` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '真实地址',
  `ip_ban` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否禁止访问',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sys_ip`
--

INSERT INTO `sys_ip` (`id`, `ip_addr`, `ip_real`, `ip_ban`) VALUES
(1, '::1', 'localhost', 0);

-- --------------------------------------------------------

--
-- 表的结构 `sys_server`
--

CREATE TABLE IF NOT EXISTS `sys_server` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引',
  `server_name` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '服务器镖师',
  `server_des` text COLLATE utf8_bin NOT NULL COMMENT '描述',
  `server_ip` varchar(100) COLLATE utf8_bin NOT NULL COMMENT 'IP地址',
  `server_port` int(11) NOT NULL COMMENT '端口',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sys_server`
--

INSERT INTO `sys_server` (`id`, `server_name`, `server_des`, `server_ip`, `server_port`) VALUES
(1, 'local-text', '本地测试网站', '127.0.0.1', 80);

-- --------------------------------------------------------

--
-- 表的结构 `sys_user`
--

CREATE TABLE IF NOT EXISTS `sys_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `user_nicename` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '昵称',
  `user_login` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '登录用户名',
  `user_passwd` varchar(41) COLLATE utf8_bin NOT NULL COMMENT '登录密码',
  `user_date` datetime NOT NULL COMMENT '用户创建时间',
  `user_ip` varchar(39) COLLATE utf8_bin NOT NULL COMMENT '当前登录IP',
  `user_status` tinyint(4) NOT NULL COMMENT '当前登录状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sys_user`
--

INSERT INTO `sys_user` (`id`, `user_nicename`, `user_login`, `user_passwd`, `user_date`, `user_ip`, `user_status`) VALUES
(1, 'admin', 'admin@admin.com', 'dd94709528bb1c83d08f3088d4043f4742891f4f', '2014-03-28 17:16:30', '::1', 0);

-- --------------------------------------------------------

--
-- 表的结构 `sys_usermeta`
--

CREATE TABLE IF NOT EXISTS `sys_usermeta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `meta_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '标识',
  `meta_value` text COLLATE utf8_bin COMMENT '值',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `sys_usermeta`
--

INSERT INTO `sys_usermeta` (`id`, `user_id`, `meta_name`, `meta_value`) VALUES
(1, 1, 'POWER', 'ADMIN|NORMAL'),
(2, 1, 'APP', 'health');
