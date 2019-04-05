/*
Navicat MySQL Data Transfer

Source Server         : 4-19
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : 5-10zuoye

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-11-15 14:51:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for soft_article
-- ----------------------------
DROP TABLE IF EXISTS `soft_article`;
CREATE TABLE `soft_article` (
  `article_id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `cat_id` smallint(5) DEFAULT '0',
  `title` varchar(150) DEFAULT NULL,
  `content` longtext,
  `author` varchar(30) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT '1',
  `add_time` date NOT NULL DEFAULT '0000-00-00',
  `file_url` varchar(255) DEFAULT NULL,
  `description` mediumtext NOT NULL,
  `click` int(11) NOT NULL DEFAULT '0',
  `collect` int(11) DEFAULT '0',
  `publish_time` int(11) DEFAULT '0',
  `thumb` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  PRIMARY KEY (`article_id`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;
