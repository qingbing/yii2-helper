-- ----------------------------
--  Table structure for `{{%key_value}}`
-- ----------------------------
CREATE TABLE IF NOT EXISTS `{{%key_value}}` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `group` VARCHAR (50) NOT NULL COMMENT '键值对类别',
  `key` VARCHAR (50) NOT NULL COMMENT '键-值（键）',
  `value` VARCHAR (50) NOT NULL DEFAULT '' COMMENT '键-值（值）',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否启用',
  `sort_order` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_group_key`(`group`, `key`),
  KEY `idx_is_enable`(`is_enable`),
  KEY `idx_key`(`key`),
  KEY `idx_sort_order`(`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='公用键值对-对应表(只支持SQL维护)';
