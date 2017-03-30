<?php
if(!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS cdb_agent_center_agents;

CREATE TABLE cdb_agent_center_agents (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS cdb_agent_center_codes;

CREATE TABLE cdb_agent_center_codes (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL COMMENT '代理的用户id',
  `code` char(255) NOT NULL DEFAULT '' COMMENT '邀请码',
  `name` char(255) DEFAULT NULL COMMENT '渠道名称',
  `summary` text COMMENT '渠道简介',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS cdb_agent_center_map;

CREATE TABLE cdb_agent_center_map (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) unsigned NOT NULL,
  `custom_id` int(11) unsigned NOT NULL,
  `invite_code_id` int(11) unsigned NOT NULL,
  `created_at` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `custom_id` (`custom_id`),
  KEY `agent_id` (`agent_id`),
  KEY `invite_code_id` (`invite_code_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

EOF;

runquery($sql);

$finish = TRUE;
