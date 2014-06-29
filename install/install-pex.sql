
-- --------------------------------------------------------

--
-- 表的结构 `app_pex_file`
--

CREATE TABLE IF NOT EXISTS `app_pex_file` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引',
  `file_name` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '文件名',
  `file_title` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '标题',
  `file_sha1` varchar(41) COLLATE utf8_bin NOT NULL COMMENT 'SHA1',
  `file_time` datetime NOT NULL COMMENT '上传时间',
  `file_src` varchar(500) COLLATE utf8_bin NOT NULL COMMENT '路径',
  `file_size` bigint(20) NOT NULL COMMENT '文件大小',
  `file_type` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '文件类型META',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `app_pex_folder`
--

CREATE TABLE IF NOT EXISTS `app_pex_folder` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引',
  `folder_name` varchar(300) COLLATE utf8_bin NOT NULL COMMENT '名称',
  `folder_parent` bigint(20) NOT NULL COMMENT '上一级Id',
  `folder_create_time` datetime NOT NULL COMMENT '创建时间',
  `folder_visit_time` datetime NOT NULL COMMENT '最后一次访问时间',
  `folder_size` bigint(20) NOT NULL COMMENT '文件夹大小',
  `folder_folder_count` bigint(20) NOT NULL COMMENT '包含文件夹数量',
  `folder_file_count` bigint(20) NOT NULL COMMENT '包含文件数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `app_pex_fx`
--

CREATE TABLE IF NOT EXISTS `app_pex_fx` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引',
  `file_id` bigint(20) NOT NULL COMMENT '文件Id',
  `folder_id` bigint(20) NOT NULL COMMENT '文件夹Id',
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
