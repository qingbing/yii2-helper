-- ----------------------------
--  Table structure for `{{%route_systems}}`
-- ----------------------------
CREATE TABLE `portal_systems` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `code` varchar(50) NOT NULL COMMENT '系统别名',
  `name` varchar(100) NOT NULL COMMENT '系统名称',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `uri_prefix` varchar(100) NOT NULL DEFAULT '' COMMENT '系统调用时访问URI前缀',
  `type` varchar(20) NOT NULL DEFAULT 'inner' COMMENT '系统类型[inner->当前系统；transfer->当前系统转发；outer->外部系统]',
  `proxy` varchar(50) NOT NULL DEFAULT '' COMMENT '参数验证通过后的代理组件ID',
  `ext` json DEFAULT NULL COMMENT '扩展字段数据',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '系统是否启用状态[0:未启用; 1:已启用]，未启用抛异常',
  -- 记录
  `is_allow_new_interface` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否允许未注册接口[0:不允许; 1:允许]',
  `is_record_field` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否记录新接口文档[0:抛异常; 1:继续调用]',
  -- 验证
  `is_open_validate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启接口校验[0:不启用; 1:已启用]',
  `is_strict_validate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '开启严格校验[0:未启用; 1:已启用],启用是每个字段都必须在{interface_fields}中定义',
  -- 常规
  `sort_order` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '显示排序',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_code` (`code`),
  UNIQUE KEY `uk_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统信息表';

-- ----------------------------
--  Data for `{{%route_systems}}`
-- ----------------------------

insert into `portal_systems` ( `code`, `name`, `description`, `uri_prefix`, `type`, `proxy`, `ext`, `is_enable`, `is_allow_new_interface`, `is_record_field`, `is_open_validate`, `is_strict_validate`, `sort_order`) values
( 'program', '程序员后台', '程序员配置后台程序', '', 'inner', '', null, '1', '1', '1', '1', '0', '127'),
( 'portal', '后台门户', '后台各系统统一入口转发', '', 'inner', '', null, '1', '1', '1', '1', '0', '127'),
( 'admin', '管理员后台', '管理员配置后台程序', '', 'inner', '', null, '1', '1', '1', '1', '0', '127'),
( 'site', '前台网站', '网站主页', '', 'inner', '', null, '1', '1', '1', '1', '0', '127'),
( 'configure', '常用配置', '', 'http://configure.yii.us', 'inner', '', '{\"uuid\": \"transmit-portal\", \"tokenUrl\": \"web/token/index\", \"publicKey\": \"MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCrKZhf2ksgP57L29CZ7rl42QVOJiEAvbiv5Q6N8s+rPVHXo/1gR1s/mqdxYHd9UEnm1m7dO2+jG3cglQQpw2pa8GyoaijRKtCV2NaRWLfjvz4IcuVTdOA1facqFOA1JVLQYyqzneOt5RSBHSBKsyqHM4A3mwxriPWFoIWMmmsluwIDAQAB\", \"enableToken\": true, \"urlExpireTtl\": 120}', '1', '1', '1', '1', '1', '100');
