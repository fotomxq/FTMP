-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014-07-01 05:50:07
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
(13, 'WEB-MAINT-ON', '0'),
(14, 'PEX-PASSWD', '30274c47903bd1bac7633bbf09743149ebab805f'),
(15, 'IP-WHITE-LIST', '*'),
(16, 'PEX-SORT', '0'),
(17, 'PEX-DESC', '1');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

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
  `user_ip` bigint(20) NOT NULL COMMENT '当前登录IP ID',
  `user_status` tinyint(4) NOT NULL COMMENT '当前登录状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `sys_user`
--

INSERT INTO `sys_user` (`id`, `user_nicename`, `user_login`, `user_passwd`, `user_date`, `user_ip`, `user_status`) VALUES
(1, 'admin', 'admin@admin.com', 'dd94709528bb1c83d08f3088d4043f4742891f4f', '2014-03-28 17:16:30', 2, 1);

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
(1, 1, 'POWER', 'NORMAL|ADMIN'),
(2, 1, 'APP', 'center|health|life|resources|finance|pex');
