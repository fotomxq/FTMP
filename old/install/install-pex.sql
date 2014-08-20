-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2014-07-01 05:48:51
-- 服务器版本: 5.6.14
-- PHP 版本: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- 数据库: `ftmp`
--

-- --------------------------------------------------------

--
-- 表的结构 `app_pex_fx`
--

CREATE TABLE IF NOT EXISTS `app_pex_fx` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引',
  `fx_title` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '标题',
  `fx_name` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '名称',
  `fx_parent` bigint(20) NOT NULL COMMENT '上级Id',
  `fx_size` bigint(20) NOT NULL COMMENT '大小',
  `fx_type` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '类型',
  `fx_sha1` varchar(41) COLLATE utf8_bin NOT NULL COMMENT 'Sha1',
  `fx_src` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '路径',
  `fx_create_time` datetime NOT NULL COMMENT '创建时间',
  `fx_visit_time` datetime NOT NULL COMMENT '访问时间',
  `fx_content` text COLLATE utf8_bin COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `app_pex_fx`
--

INSERT INTO `app_pex_fx` (`id`, `fx_title`, `fx_name`, `fx_parent`, `fx_size`, `fx_type`, `fx_sha1`, `fx_src`, `fx_create_time`, `fx_visit_time`, `fx_content`) VALUES
(1, '照片', 'photo', 0, 0, 'folder', 'afffdd08d81dd168981d9a0dcceb2fb24c2ab56a', '', '2014-07-06 00:00:00', '2014-07-06 00:00:00', '照片'),
(2, '影片', 'movie', 0, 0, 'folder', 'afffdd08d81dd168981d9a0dcceb2fb24c2ab56a', '', '2014-07-06 00:00:00', '2014-07-06 00:00:00', '影片'),
(3, '漫画', 'cartoon', 0, 0, 'folder', 'afffdd08d81dd168981d9a0dcceb2fb24c2ab56a', '', '2014-07-06 00:00:00', '2014-07-06 00:00:00', '漫画'),
(4, '文本', 'txt', 0, 0, 'folder', 'afffdd08d81dd168981d9a0dcceb2fb24c2ab56a', '', '2014-07-06 00:00:00', '2014-07-06 00:00:00', '文本');



-- --------------------------------------------------------

--
-- 表的结构 `app_pex_tag`
--

CREATE TABLE IF NOT EXISTS `app_pex_tag` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引',
  `tag_name` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '标签名称',
  `tag_type` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `app_pex_tx`
--

CREATE TABLE IF NOT EXISTS `app_pex_tx` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引',
  `file_id` bigint(20) NOT NULL COMMENT '文件Id',
  `tag_id` bigint(20) NOT NULL COMMENT '标签Id',
  `tx_type` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '类型',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
