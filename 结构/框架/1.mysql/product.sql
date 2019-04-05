/*
Navicat MySQL Data Transfer

Source Server         : 4-19
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : 5-10zuoye

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-11-15 14:51:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类id',
  `sn` varchar(60) DEFAULT NULL COMMENT '产品编码',
  `name` varchar(120) DEFAULT NULL COMMENT '产品名称',
  `remark` text COMMENT '简单描述',
  `content` text NOT NULL COMMENT '产品描述',
  `original_img` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `addtime` date DEFAULT '0000-00-00',
  `click_count` int(11) DEFAULT NULL COMMENT '点击量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
