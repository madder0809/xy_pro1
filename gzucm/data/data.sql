DROP DATABASE IF EXISTS `gzucm`;
CREATE DATABASE `gzucm` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
use `gzucm`;

/*管理员表*/
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `uid` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `username` char(16) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `email` char(32) NOT NULL COMMENT '用户邮箱',
  `mobile` char(15) NOT NULL COMMENT '用户手机',
  `login_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录次数',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `reg_ip` char(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` char(30) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `status` tinyint(1) DEFAULT '1' COMMENT '用户状态',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员表';

INSERT INTO admin_user(username, password) VALUES ('admin', '481c214a9e144466d56525b2280dd122');
INSERT INTO admin_user(username, password) VALUES ('zhangsan', '481c214a9e144466d56525b2280dd122');


DROP TABLE IF EXISTS `auth_group`;
CREATE TABLE `auth_group` ( 
    `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT, 
    `title` char(100) NOT NULL DEFAULT '', 
    `description` char(250) NOT NULL DEFAULT '', 
    `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1正常，0禁用', 
    `rules` char(80) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id， 多个规则,隔开', 
    PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户组表';


DROP TABLE IF EXISTS `auth_group_access`;
CREATE TABLE `auth_group_access` (  
    `uid` mediumint(8) unsigned NOT NULL,  
    `group_id` mediumint(8) unsigned NOT NULL, 
    UNIQUE KEY `uid_group_id` (`uid`,`group_id`),  
    KEY `id` (`uid`), 
    KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户组明细表';


DROP TABLE IF EXISTS `auth_menu`;
CREATE TABLE `auth_menu` (  
    `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,  
    `name` char(80) NOT NULL DEFAULT '',  
    `title` char(20) NOT NULL DEFAULT '',  
    `pid` tinyint(5) NOT NULL, 
    `menu_type` tinyint(1) NOT NULL DEFAULT '0', 
    `type` tinyint(1) NOT NULL DEFAULT '1',
    `status` tinyint(1) NOT NULL DEFAULT '1',  
    `condition` char(100) NOT NULL DEFAULT '',  /* 规则附件条件,满足附加条件的规则,才认为是有效的规则 */
    `sort` tinyint(3) NOT NULL DEFAULT '0',
    `icon` char(30) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='权限规则表 - 菜单表';

INSERT INTO auth_group(id,title,status,rules) VALUES (1,'测试组',1,'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30');
INSERT INTO auth_group_access(uid,group_id) VALUES(2,1);

INSERT INTO `auth_menu`(id, name, title,pid, menu_type,sort) VALUES ('2', '#node', '系统管理', '0', '1', '1');
INSERT INTO `auth_menu`(id, name, title,pid, menu_type,sort) VALUES ('3', 'User/manage', '用户管理', '2', '1','0');
INSERT INTO `auth_menu`(id, name, title,pid, menu_type,sort) VALUES ('4', '#node', '用户信息', '2', '1','0');
INSERT INTO `auth_menu`(id, name, title,pid, menu_type,sort) VALUES ('5', 'Admin/index', '管理员管理', '2', '1','0');
INSERT INTO `auth_menu`(id, name, title,pid, menu_type,sort) VALUES ('6', 'RegSchoolRoll/index', '注册学籍段管理', '2', '1','0');
INSERT INTO `auth_menu`(id, name, title,pid, menu_type,sort) VALUES ('7', 'LoginSchoolRoll/index', '登录学籍段管理', '2', '1','0');
INSERT INTO `auth_menu`(id, name, title,pid, menu_type,sort) VALUES ('8', 'Student/index', '学生信息', '4', '1','0');
INSERT INTO `auth_menu`(id, name, title,pid, menu_type,sort) VALUES ('9', 'Teacher/index', '教师信息', '4', '1','0');
INSERT INTO `auth_menu`(id, name, title,pid, menu_type,sort) VALUES ('10', 'Student/add', '新增', '8', '1','0');
INSERT INTO `auth_menu`(id, name, title,pid, menu_type,sort) VALUES ('11', 'Student/edit', '编辑', '8', '1','0');
INSERT INTO `auth_menu`(id, name, title,pid, menu_type,sort) VALUES ('12', 'Student/delete', '删除', '8', '1','0');
INSERT INTO `auth_menu`(id, name, title,pid, menu_type,sort) VALUES ('13', '#node', '门户管理', '0', '1', '1');
INSERT INTO `auth_menu`(id, name, title,pid, menu_type,sort) VALUES ('14', 'Test/test', '菜单1', '13', '1', '1');
INSERT INTO `auth_menu`(id, name, title,pid, menu_type,sort) VALUES ('15', 'Stu/index', '用户管理1', '3', '1','0');
INSERT INTO `auth_menu`(id, name, title,pid, menu_type,sort) VALUES ('16', 'Teac/index', '用户管理2', '3', '1','0');
INSERT INTO `auth_menu`(id, name, title,pid, menu_type,sort) VALUES ('17', 'Menu/index', '菜单设置', '2', '1','0');


DROP TABLE IF EXISTS `video_info`;
CREATE TABLE `video_info` (
  `id` int(32) NOT NULL AUTO_INCREMENT COMMENT '',
  `filename` varchar(250) NOT NULL COMMENT '文件名',
  `path` varchar(250) NOT NULL COMMENT '路径',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 common='视频信息';

DROP TABLE IF EXISTS `experiment`;
CREATE TABLE `experiment` (
  `id` int(12) NOT NULL AUTO_INCREMENT COMMENT '',
  `subject` varchar(100) NOT NULL COMMENT '科目',
  `class_name` varchar(200) NOT NULL COMMENT '课程名称',
  `class_common` text  COMMENT '课程介绍',
  `lavel` int(3) DEFAULT 0 COMMENT '固定级别',
  `status` varchar(20) NOT NULL COMMENT '状态',
  `release_man` varchar(30) NOT NULL COMMENT '发布者',
  `release_time` varchar(10) NOT NULL COMMENT '发布时间',
  `video_id` text NOT NULL COMMENT '视频资源id',
  `click_count` int(12) DEFAULT 0 COMMENT '点击数',
  `download_count` int(12) DEFAULT 0 COMMENT '下载数',
  `type` int(1) DEFAULT 0 COMMENT '类型：1主要实验课程，2实验视频',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 comment='实验视频';

DROP TABLE IF EXISTS `video_info`;
CREATE TABLE `video_info` (
  `id` int(32) NOT NULL AUTO_INCREMENT COMMENT '',
  `filename` varchar(250) NOT NULL COMMENT '文件名',
  `path` varchar(250) NOT NULL COMMENT '路径',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 comment='视频信息';
