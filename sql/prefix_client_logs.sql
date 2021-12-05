-- ----------------------------
--  Table structure for `{{%client_logs}}`
-- ----------------------------
CREATE TABLE `{{%client_logs}}` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `trace_id` varchar(32) NOT NULL DEFAULT '' COMMENT '客户端日志ID',
  `system_code` varchar(50) NOT NULL DEFAULT '' COMMENT '系统别名',
  `called_system_code` varchar(50) NOT NULL DEFAULT '' COMMENT '访问系统别名',
  `full_url` varchar(200) NOT NULL DEFAULT '' COMMENT '接口URL',
  `method` varchar(10) NOT NULL DEFAULT '' COMMENT '请求方法[get post put...]',

  `request_time` datetime NOT NULL DEFAULT '1000-01-01 00:00:00' COMMENT '访问时间',

  `request_data` json DEFAULT NULL COMMENT '接口发送信息',
  `response_code` int(5) unsigned NOT NULL DEFAULT '0' COMMENT 'http状态返回码',
  `response_data` json DEFAULT NULL COMMENT '接口返回信息',

  `use_time` float(10,6) unsigned NOT NULL DEFAULT '0.000000' COMMENT '接口耗时',
  `ip` varchar(15) NOT NULL DEFAULT '' COMMENT '登录IP',
  `uid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_traceId` (`trace_id`),
  KEY `idx_fullUrl` (`full_url`),
  KEY `idx_useTime` (`use_time`),
  KEY `idx_requestTime` (`request_time`),
  KEY `idx_ip` (`ip`),
  KEY `idx_uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='三方服务访问表'