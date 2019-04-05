/*
Navicat MySQL Data Transfer

Source Server         : 4-19
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : 5-10zuoye

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-11-15 14:51:29
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for soft_article_cat
-- ----------------------------
DROP TABLE IF EXISTS `soft_article_cat`;
CREATE TABLE `soft_article_cat` (
  `cat_id` int(10) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(20) DEFAULT NULL,
  `cat_type` smallint(6) DEFAULT '0',
  `parent_id` smallint(6) DEFAULT NULL,
  `cat_desc` varchar(255) DEFAULT NULL,
  `keywords` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;
