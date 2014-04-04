
-- --------------------------------------------------------

--
-- 表的结构 `weight`
--

CREATE TABLE IF NOT EXISTS `weight` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '索引ID',
  `user_id` int(11) NOT NULL COMMENT '用户ID',
  `weight_date` date NOT NULL COMMENT '日期',
  `weight_weight` float NOT NULL COMMENT '体重',
  `weight_fat` float NOT NULL COMMENT '脂肪百分比',
  `weight_tag_dinner` tinyint(4) NOT NULL COMMENT '饭后',
  `weight_tag_sport` tinyint(4) NOT NULL COMMENT '运动',
  `weight_tag_sleep` tinyint(4) NOT NULL COMMENT '睡觉',
  `weight_tag_toilet` tinyint(4) NOT NULL COMMENT '厕所',
  `weight_tag_sick` tinyint(4) NOT NULL COMMENT '生病',
  `weight_tag_alcohol` tinyint(4) NOT NULL COMMENT '喝',
  `weight_note` text COLLATE utf8_bin COMMENT '笔记',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;
