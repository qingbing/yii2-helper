
-- ----------------------------
--  Table structure for `{{%life_collection}}`
-- ----------------------------
CREATE TABLE `{{%life_collection}}` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `col_name` varchar(50) NOT NULL DEFAULT '' COMMENT '集合名称',
  `data` text DEFAULT NULL COMMENT '数据',
  `expire_at` datetime NOT NULL COMMENT '有效时间',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_colName` (`col_name`),
  KEY `idx_expireAt` (`expire_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='db驱动的生命周期数据存储';
