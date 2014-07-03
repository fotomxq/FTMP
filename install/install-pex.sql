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
  `fx_name` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '原始文件名',
  `fx_parent` bigint(20) NOT NULL COMMENT '上一级ID',
  `fx_size` bigint(20) NOT NULL COMMENT '大小',
  `fx_type` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '类型,folder为文件,其他为MIME',
  `fx_sha1` varchar(41) COLLATE utf8_bin NOT NULL COMMENT 'SHA1',
  `fx_src` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '保存路径',
  `fx_create_time` datetime NOT NULL COMMENT '创建时间',
  `fx_visit_time` datetime NOT NULL COMMENT '访问时间',
  `fx_content` text COLLATE utf8_bin NOT NULL COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;



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
