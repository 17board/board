DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '自增id',
  `uid` int(10) unsigned NOT NULL DEFAULT 0 COMMENT 'uid用于产品内部各模块使用，不对外暴露',
  `username` varchar(32) NOT NULL COMMENT '用户名，登录的唯一标识，字符范围[a-zA-Z0-9_]',
  `password` char(32) NOT NULL COMMENT '用户密码，md5加密后的字符串',
  `nickname` varchar(64) NOT NULL DEFAULT '' COMMENT '用户昵称，用于交流时的展现，允许任何可见字符',
  `email` varchar(256) NOT NULL DEFAULT '' COMMENT '用户邮件，用于找回密码使用',
  `avatar` varchar(256) NOT NULL DEFAULT '' COMMENT '用户头像',
  `role` tinyint(2) unsigned NOT NULL DEFAULT 0 '' COMMENT '角色',
  `privilege` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '权限',
  `register_time` int(10) unsigned NOT NULL COMMENT '账号注册时间戳',
  `login_time` int(10) unsigned NOT NULL COMMENT '账号最后一次登录时间',
  `ip` int(10) unsigned NOT NULL COMMENT '最后一次登录的ip，十进制整数形式',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uid` (`uid`),
  UNIQUE KEY `uname` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='账号表';

DROP TABLE IF EXISTS `tbl_project`;
CREATE TABLE `tbl_project` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '自增id，作为项目id使用',
  `name` varchar(32) NOT NULL COMMENT '项目名称',
  `type` int(4) NOT NULL COMMENT '项目类型，类型由配置文件配置',
  `status` int(4) NOT NULL DEFAULT 0 COMMENT '项目当前状态 0-初始化 1-废弃 2-进行中 3-结束 4-延期 5-延期结束',
  `create_time` int(10) NOT NULL COMMENT '项目创建时间戳',
  `begin_time` int(10) NOT NULL COMMENT '项目开始时间戳',
  `end_time` int(10) NOT NULL COMMENT '项目结束时间戳',
  `create_uid` int(10) NOT NULL COMMENT '创建者uid',
  `member` varchar(1024) NOT NULL DEFAULT '' COMMENT '项目组成员组成的uid集合',
  `op_time` int(10) unsigned NOT NULL COMMENT '最后操作时间，修改、删除的时间',
  `op_uid` int(10) unsigned NOT NULL COMMENT '最后操作这条记录的用户',
  PRIMARY KEY  (`id`),
  KEY `key_t_s` (`type`, `status`),
  KEY `key_uid` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='项目表';

DROP TABLE IF EXISTS `tbl_feature`;
CREATE TABLE `tbl_feature` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '自增id',
  `project_id` int(10) unsigned NOT NULL COMMENT '所属的项目的id',
  `deleted` int(4) unsigned NOT NULL DEFAULT 0 COMMENT '删除标记',
  `sort` int(4) unsigned NOT NULL COMMENT '排序的字段',
  `content` varchar(4096) NOT NULL DEFAULT '' COMMENT 'feature的内容描述',
  `create_time` int(10) unsigned NOT NULL COMMENT 'feature创建的时间戳',
  `create_uid` int(10) unsigned NOT NULL COMMENT '创建者的uid',
  `op_time` int(10) unsigned NOT NULL COMMENT '最后操作时间，修改、删除的时间',
  `op_uid` int(10) unsigned NOT NULL COMMENT '最后操作这条记录的用户',
  PRIMARY KEY  (`id`),
  KEY `key_p_d_s` (`project_id`, `deleted`, `sort`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='大功能表';

DROP TABLE IF EXISTS `tbl_story`;
CREATE TABLE `tbl_story` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '自增id',
  `feature_id` int(10) unsigned NOT NULL COMMENT '所属的feature的id',
  `deleted` int(4) unsigned NOT NULL DEFAULT 0 COMMENT '删除标记',
  `content` varchar(4096) NOT NULL DEFAULT '' COMMENT 'story的内容描述',
  `create_time` int(10) unsigned NOT NULL COMMENT 'story创建的时间戳',
  `begin_time` int(10) unsigned NOT NULL COMMENT 'story计划开始的时间戳',
  `end_time` int(10) unsigned NOT NULL COMMENT 'story计划结束的时间戳',
  `create_uid` int(10) unsigned NOT NULL COMMENT '创建者的uid',
  `owner_uids` varchar(1024) unsigned NOT NULL COMMENT '负责人的uid集合，用_连接多个uid',
  `floor_count` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '该story下讨论版包含的评论个数，包括已经删除的，可以用来分配floor',
  `discuss_count` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '去掉已删除的讨论后的评论总数',
  `op_time` int(10) unsigned NOT NULL COMMENT '最后操作时间，修改、删除的时间',
  `op_uid` int(10) unsigned NOT NULL COMMENT '最后操作这条记录的用户',
  PRIMARY KEY  (`id`),
  KEY `key_f_d_b` (`feature_id`, `deleted`, `begin_time`)
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='小功能表';

DROP TABLE IF EXISTS `tbl_discuss`;
CREATE TABLE `tbl_discuss` (
  `id` int(10) unsigned NOT NULL auto_increment COMMENT '自增id，作为项目id使用',
  `story_id` int(10) unsigned NOT NULL COMMENT '所属的某个story的id',
  `uid` int(10) unsigned NOT NULL COMMENT '发贴者的uid',
  `create_time` int(10) unsigned NOT NULL COMMENT '发贴时间',
  `content` varchar(32768) NOT NULL DEFAULT '' COMMENT '发贴内容，允许img标签，富文本',
  `floor` int(10) unsigned NOT NULL COMMENT '楼层数',
  `deleted` int(4) unsigned NOT NULL DEFAULT 0 COMMENT '是否删除标记',
  `to_discuss_id` int(10) unsigned NOT NULL DEFAULT 0 COMMENT '回复的楼层id',
  `op_time` int(10) unsigned NOT NULL COMMENT '最后操作时间，修改、删除的时间',
  `op_uid` int(10) unsigned NOT NULL COMMENT '最后操作这条记录的用户',
  PRIMARY KEY  (`id`),
  KEY `key_s_d_c` (`story_id`, `deleted`, `create_time`),
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='讨论表';

