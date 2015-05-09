/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50161
Source Host           : localhost:3306
Source Database       : lvyou

Target Server Type    : MYSQL
Target Server Version : 50161
File Encoding         : 65001

Date: 2015-05-06 17:20:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `jee_admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `jee_admin_user`;
CREATE TABLE `jee_admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_name` varchar(50) DEFAULT NULL,
  `pwd` varchar(50) DEFAULT NULL,
  `true_name` varchar(50) DEFAULT NULL,
  `tel` varchar(50) DEFAULT NULL,
  `adre` varchar(50) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `last_login_time` int(11) DEFAULT NULL,
  `last_login_ip` varchar(255) DEFAULT NULL,
  `login_count` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_admin_user
-- ----------------------------
INSERT INTO `jee_admin_user` VALUES ('1', 'admin', '7fef6171469e80d32c0559f88b377245', 'admin', '12345678910', '', '0', '2015-05-06 15:37:17', '1430897837', '111.127.63.138', '28', '1');

-- ----------------------------
-- Table structure for `jee_advert`
-- ----------------------------
DROP TABLE IF EXISTS `jee_advert`;
CREATE TABLE `jee_advert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `area_id` int(11) NOT NULL,
  `types` tinyint(1) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `s_pic` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COMMENT='广告管理';

-- ----------------------------
-- Records of jee_advert
-- ----------------------------
INSERT INTO `jee_advert` VALUES ('35', 'fly', '16', '2', '1389024000', '1430150400', '643', null, '#', '1000', '409', '0', '1', '1');
INSERT INTO `jee_advert` VALUES ('37', '12356', '16', '2', '1391616000', '1997020800', '644', null, '#', '1000', '409', '0', '2', '1');
INSERT INTO `jee_advert` VALUES ('41', '首页景点banner宣传', '16', '2', '1430150400', '1930060800', '645', null, '#', '1000', '409', '0', '3', '1');
INSERT INTO `jee_advert` VALUES ('48', '发红包', '16', '2', '1418010286', '1535644800', '647', null, 'http://item.taobao.com/item.htm?id=39113524468', '1000', '409', '0', '0', '1');

-- ----------------------------
-- Table structure for `jee_advert_area`
-- ----------------------------
DROP TABLE IF EXISTS `jee_advert_area`;
CREATE TABLE `jee_advert_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(50) NOT NULL,
  `names_en` varchar(50) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='广告展示区域';

-- ----------------------------
-- Records of jee_advert_area
-- ----------------------------
INSERT INTO `jee_advert_area` VALUES ('16', '首页BANNER', 'index_banner', '1', '1');

-- ----------------------------
-- Table structure for `jee_area`
-- ----------------------------
DROP TABLE IF EXISTS `jee_area`;
CREATE TABLE `jee_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `paths` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `levels` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `names` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `names_en` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=817 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_area
-- ----------------------------
INSERT INTO `jee_area` VALUES ('1', '0', ',1,', '1', '1', '亚洲', 'Asia');
INSERT INTO `jee_area` VALUES ('2', '0', ',2,', '1', '2', '欧洲', 'Europe');
INSERT INTO `jee_area` VALUES ('3', '0', ',3,', '1', '3', '非洲', 'Africa');
INSERT INTO `jee_area` VALUES ('4', '0', ',4,', '1', '4', '北美', 'North America');
INSERT INTO `jee_area` VALUES ('5', '0', ',5,', '1', '5', '南美', 'South America');
INSERT INTO `jee_area` VALUES ('6', '0', ',6,', '1', '6', '大洋洲', 'Oceania');
INSERT INTO `jee_area` VALUES ('7', '1', ',1,7,', '2', '1', '中国', 'China');
INSERT INTO `jee_area` VALUES ('8', '1', ',1,8,', '2', '2', '蒙古', 'Mongolia');
INSERT INTO `jee_area` VALUES ('9', '1', ',1,9,', '2', '3', '朝鲜', 'North Korea');
INSERT INTO `jee_area` VALUES ('10', '1', ',1,10,', '2', '4', '韩国', 'South Korea');
INSERT INTO `jee_area` VALUES ('11', '1', ',1,11,', '2', '5', '日本', 'Japan');
INSERT INTO `jee_area` VALUES ('12', '1', ',1,12,', '2', '6', '菲律宾', 'Philippines');
INSERT INTO `jee_area` VALUES ('13', '1', ',1,13,', '2', '7', '越南', 'Vietnam');
INSERT INTO `jee_area` VALUES ('14', '1', ',1,14,', '2', '8', '老挝', 'Laos');
INSERT INTO `jee_area` VALUES ('15', '1', ',1,15,', '2', '9', '柬埔寨', 'Cambodia');
INSERT INTO `jee_area` VALUES ('16', '1', ',1,16,', '2', '10', '缅甸', 'Union Of Myanmar');
INSERT INTO `jee_area` VALUES ('17', '1', ',1,17,', '2', '11', '泰国', 'Thailand');
INSERT INTO `jee_area` VALUES ('18', '1', ',1,18,', '2', '12', '马来西亚', 'Malaysia');
INSERT INTO `jee_area` VALUES ('19', '1', ',1,19,', '2', '13', '文莱', 'Brunei');
INSERT INTO `jee_area` VALUES ('20', '1', ',1,20,', '2', '14', '新加坡', 'Singapore');
INSERT INTO `jee_area` VALUES ('21', '1', ',1,21,', '2', '15', '印度尼西亚', 'Indonesia');
INSERT INTO `jee_area` VALUES ('22', '1', ',1,22,', '2', '16', '东帝汶', 'East Timor');
INSERT INTO `jee_area` VALUES ('23', '1', ',1,23,', '2', '17', '尼泊尔', 'Nepal');
INSERT INTO `jee_area` VALUES ('24', '1', ',1,24,', '2', '18', '不丹', 'Bhutan');
INSERT INTO `jee_area` VALUES ('25', '1', ',1,25,', '2', '19', '孟加拉国', 'Bangladesh');
INSERT INTO `jee_area` VALUES ('26', '1', ',1,26,', '2', '20', '印度', 'India');
INSERT INTO `jee_area` VALUES ('27', '1', ',1,27,', '2', '21', '巴基斯坦', 'Pakistan');
INSERT INTO `jee_area` VALUES ('28', '1', ',1,28,', '2', '22', '斯里兰卡', 'Sri Lanka');
INSERT INTO `jee_area` VALUES ('29', '1', ',1,29,', '2', '23', '马尔代夫', 'Maldives');
INSERT INTO `jee_area` VALUES ('30', '1', ',1,30,', '2', '24', '哈萨克斯坦', 'Kazakhstan');
INSERT INTO `jee_area` VALUES ('31', '1', ',1,31,', '2', '25', '吉尔吉斯斯坦', 'Kyrgyzstan');
INSERT INTO `jee_area` VALUES ('32', '1', ',1,32,', '2', '26', '塔吉克斯坦', 'Tajikistan');
INSERT INTO `jee_area` VALUES ('33', '1', ',1,33,', '2', '27', '乌兹别克斯坦', 'Uzbekistan');
INSERT INTO `jee_area` VALUES ('34', '1', ',1,34,', '2', '28', '土库曼斯坦', 'Turkmenistan');
INSERT INTO `jee_area` VALUES ('35', '1', ',1,35,', '2', '29', '阿富汗', 'Afghanistan');
INSERT INTO `jee_area` VALUES ('36', '1', ',1,36,', '2', '30', '伊拉克', 'Iraq');
INSERT INTO `jee_area` VALUES ('37', '1', ',1,37,', '2', '31', '伊朗', 'Iran');
INSERT INTO `jee_area` VALUES ('38', '1', ',1,38,', '2', '32', '叙利亚', 'Syria');
INSERT INTO `jee_area` VALUES ('39', '1', ',1,39,', '2', '33', '约旦', 'Jordan');
INSERT INTO `jee_area` VALUES ('40', '1', ',1,40,', '2', '34', '黎巴嫩', 'Lebanon');
INSERT INTO `jee_area` VALUES ('41', '1', ',1,41,', '2', '35', '以色列', 'Israel');
INSERT INTO `jee_area` VALUES ('42', '1', ',1,42,', '2', '36', '巴勒斯坦', 'Palestinian');
INSERT INTO `jee_area` VALUES ('43', '1', ',1,43,', '2', '37', '沙特阿拉伯', 'Saudi Arabia');
INSERT INTO `jee_area` VALUES ('44', '1', ',1,44,', '2', '38', '巴林', 'Bahrain');
INSERT INTO `jee_area` VALUES ('45', '1', ',1,45,', '2', '39', '卡塔尔', 'Qatar');
INSERT INTO `jee_area` VALUES ('46', '1', ',1,46,', '2', '40', '科威特', 'Kuwait');
INSERT INTO `jee_area` VALUES ('47', '1', ',1,47,', '2', '41', '阿联酋', 'United Arab Emirates');
INSERT INTO `jee_area` VALUES ('48', '1', ',1,48,', '2', '42', '阿曼', 'Oman');
INSERT INTO `jee_area` VALUES ('49', '1', ',1,49,', '2', '43', '也门', 'Yemen');
INSERT INTO `jee_area` VALUES ('50', '1', ',1,50,', '2', '44', '格鲁吉亚', 'Georgia');
INSERT INTO `jee_area` VALUES ('51', '1', ',1,51,', '2', '45', '亚美尼亚', 'Armenia');
INSERT INTO `jee_area` VALUES ('52', '1', ',1,52,', '2', '46', '阿塞拜疆', 'Azerbaijan');
INSERT INTO `jee_area` VALUES ('53', '1', ',1,53,', '2', '47', '土耳其', 'Turkey');
INSERT INTO `jee_area` VALUES ('54', '1', ',1,54,', '2', '48', '塞浦路斯', 'Cyprus');
INSERT INTO `jee_area` VALUES ('55', '2', ',2,55,', '2', '0', '芬兰', 'Finland');
INSERT INTO `jee_area` VALUES ('56', '2', ',2,56,', '2', '0', '瑞典', 'Sweden');
INSERT INTO `jee_area` VALUES ('57', '2', ',2,57,', '2', '0', '挪威', 'Norway');
INSERT INTO `jee_area` VALUES ('58', '2', ',2,58,', '2', '0', '冰岛', 'Iceland');
INSERT INTO `jee_area` VALUES ('59', '2', ',2,59,', '2', '0', '丹麦', 'Denmark');
INSERT INTO `jee_area` VALUES ('60', '2', ',2,60,', '2', '0', '爱沙尼亚', 'Estonia');
INSERT INTO `jee_area` VALUES ('61', '2', ',2,61,', '2', '0', '拉脱维亚', 'Latvia');
INSERT INTO `jee_area` VALUES ('62', '2', ',2,62,', '2', '0', '立陶宛', 'Lithuania');
INSERT INTO `jee_area` VALUES ('63', '2', ',2,63,', '2', '0', '白俄罗斯', 'Belarus');
INSERT INTO `jee_area` VALUES ('64', '2', ',2,64,', '2', '0', '俄罗斯', 'Russia');
INSERT INTO `jee_area` VALUES ('65', '2', ',2,65,', '2', '0', '乌克兰', 'Ukraine');
INSERT INTO `jee_area` VALUES ('66', '2', ',2,66,', '2', '0', '摩尔多瓦', 'Moldova');
INSERT INTO `jee_area` VALUES ('67', '2', ',2,67,', '2', '0', '波兰', 'Poland');
INSERT INTO `jee_area` VALUES ('68', '2', ',2,68,', '2', '0', '捷克', 'Czech Republic');
INSERT INTO `jee_area` VALUES ('69', '2', ',2,69,', '2', '0', '斯洛伐克', 'Slovakia');
INSERT INTO `jee_area` VALUES ('70', '2', ',2,70,', '2', '0', '匈牙利', 'Hungary');
INSERT INTO `jee_area` VALUES ('71', '2', ',2,71,', '2', '0', '德国', 'Germany');
INSERT INTO `jee_area` VALUES ('72', '2', ',2,72,', '2', '0', '奥地利', 'Austria');
INSERT INTO `jee_area` VALUES ('73', '2', ',2,73,', '2', '0', '瑞士', 'Switzerland');
INSERT INTO `jee_area` VALUES ('74', '2', ',2,74,', '2', '0', '列支敦士登', 'Liechtenstein');
INSERT INTO `jee_area` VALUES ('75', '2', ',2,75,', '2', '0', '英国', 'Britain');
INSERT INTO `jee_area` VALUES ('76', '2', ',2,76,', '2', '0', '爱尔兰', 'Ireland');
INSERT INTO `jee_area` VALUES ('77', '2', ',2,77,', '2', '0', '荷兰', 'Netherlands');
INSERT INTO `jee_area` VALUES ('78', '2', ',2,78,', '2', '0', '比利时', 'Belgium');
INSERT INTO `jee_area` VALUES ('79', '2', ',2,79,', '2', '0', '卢森堡', 'Luxembourg');
INSERT INTO `jee_area` VALUES ('80', '2', ',2,80,', '2', '0', '法国', 'France');
INSERT INTO `jee_area` VALUES ('81', '2', ',2,81,', '2', '0', '摩纳哥', 'Monaco');
INSERT INTO `jee_area` VALUES ('82', '2', ',2,82,', '2', '0', '罗马尼亚', 'Romania');
INSERT INTO `jee_area` VALUES ('83', '2', ',2,83,', '2', '0', '保加利亚', 'Bulgarian');
INSERT INTO `jee_area` VALUES ('84', '2', ',2,84,', '2', '0', '塞尔维亚', 'Serbia');
INSERT INTO `jee_area` VALUES ('85', '2', ',2,85,', '2', '0', '马其顿', 'Macedonia');
INSERT INTO `jee_area` VALUES ('86', '2', ',2,86,', '2', '0', '阿尔巴尼亚', 'Albania');
INSERT INTO `jee_area` VALUES ('87', '2', ',2,87,', '2', '0', '希腊', 'Greece');
INSERT INTO `jee_area` VALUES ('88', '2', ',2,88,', '2', '0', '斯洛文尼亚', 'Slovenia');
INSERT INTO `jee_area` VALUES ('89', '2', ',2,89,', '2', '0', '克罗地亚', 'Croatia');
INSERT INTO `jee_area` VALUES ('90', '2', ',2,90,', '2', '0', '波斯尼亚和黑塞哥维那', 'Bosnia and Herzegovina');
INSERT INTO `jee_area` VALUES ('91', '2', ',2,91,', '2', '0', '意大利', 'Italy');
INSERT INTO `jee_area` VALUES ('92', '2', ',2,92,', '2', '0', '梵蒂冈', 'Vatican');
INSERT INTO `jee_area` VALUES ('93', '2', ',2,93,', '2', '0', '圣马力诺', 'San Marino');
INSERT INTO `jee_area` VALUES ('94', '2', ',2,94,', '2', '0', '马耳他', 'Malta');
INSERT INTO `jee_area` VALUES ('95', '2', ',2,95,', '2', '0', '西班牙', 'Spain');
INSERT INTO `jee_area` VALUES ('96', '2', ',2,96,', '2', '0', '葡萄牙', 'Portugal');
INSERT INTO `jee_area` VALUES ('97', '2', ',2,97,', '2', '0', '安道尔', 'Andorra');
INSERT INTO `jee_area` VALUES ('98', '2', ',2,98,', '2', '0', '黑山', 'Montenegro');
INSERT INTO `jee_area` VALUES ('99', '3', ',3,99,', '2', '0', '阿尔及利亚', 'Algeria');
INSERT INTO `jee_area` VALUES ('100', '3', ',3,100,', '2', '0', '埃及', 'Egypt');
INSERT INTO `jee_area` VALUES ('101', '3', ',3,101,', '2', '0', '埃塞俄比亚', 'Ethiopia');
INSERT INTO `jee_area` VALUES ('102', '3', ',3,102,', '2', '0', '安哥拉', 'Angola');
INSERT INTO `jee_area` VALUES ('103', '3', ',3,103,', '2', '0', '贝宁', 'Benin');
INSERT INTO `jee_area` VALUES ('104', '3', ',3,104,', '2', '0', '博茨瓦纳', 'Botswana');
INSERT INTO `jee_area` VALUES ('105', '3', ',3,105,', '2', '0', '布基纳法索', 'Burkina Faso');
INSERT INTO `jee_area` VALUES ('106', '3', ',3,106,', '2', '0', '布隆迪', 'Burundi');
INSERT INTO `jee_area` VALUES ('107', '3', ',3,107,', '2', '0', '赤道几内亚', 'Equatorial Guinea');
INSERT INTO `jee_area` VALUES ('108', '3', ',3,108,', '2', '0', '多哥', 'Togo');
INSERT INTO `jee_area` VALUES ('109', '3', ',3,109,', '2', '0', '厄立特里亚', 'Eritrea');
INSERT INTO `jee_area` VALUES ('110', '3', ',3,110,', '2', '0', '佛得角', 'Cape Verde');
INSERT INTO `jee_area` VALUES ('111', '3', ',3,111,', '2', '0', '冈比亚', 'Gambia');
INSERT INTO `jee_area` VALUES ('112', '3', ',3,112,', '2', '0', '刚果(布)', 'Congo');
INSERT INTO `jee_area` VALUES ('113', '3', ',3,113,', '2', '0', '刚果(金)民主', 'Congo Democratic');
INSERT INTO `jee_area` VALUES ('114', '3', ',3,114,', '2', '0', '吉布提', 'Djibouti');
INSERT INTO `jee_area` VALUES ('115', '3', ',3,115,', '2', '0', '几内亚', 'Guinea');
INSERT INTO `jee_area` VALUES ('116', '3', ',3,116,', '2', '0', '几内亚比绍', 'Guinea-Bissau');
INSERT INTO `jee_area` VALUES ('117', '3', ',3,117,', '2', '0', '加纳', 'Ghana');
INSERT INTO `jee_area` VALUES ('118', '3', ',3,118,', '2', '0', '加蓬', 'Gabon');
INSERT INTO `jee_area` VALUES ('119', '3', ',3,119,', '2', '0', '津巴布韦', 'Zimbabwe');
INSERT INTO `jee_area` VALUES ('120', '3', ',3,120,', '2', '0', '喀麦隆', 'Cameroon');
INSERT INTO `jee_area` VALUES ('121', '3', ',3,121,', '2', '0', '科摩罗联盟', 'Union of Comoros');
INSERT INTO `jee_area` VALUES ('122', '3', ',3,122,', '2', '0', '科特迪瓦', 'Cote Divoire');
INSERT INTO `jee_area` VALUES ('123', '3', ',3,123,', '2', '0', '肯尼亚', 'Kenya');
INSERT INTO `jee_area` VALUES ('124', '3', ',3,124,', '2', '0', '莱索托', 'Lesotho');
INSERT INTO `jee_area` VALUES ('125', '3', ',3,125,', '2', '0', '利比里亚', 'Liberia');
INSERT INTO `jee_area` VALUES ('126', '3', ',3,126,', '2', '0', '利比亚', 'Libya');
INSERT INTO `jee_area` VALUES ('127', '3', ',3,127,', '2', '0', '卢旺达', 'Rwanda');
INSERT INTO `jee_area` VALUES ('128', '3', ',3,128,', '2', '0', '马达加斯加', 'Madagascar');
INSERT INTO `jee_area` VALUES ('129', '3', ',3,129,', '2', '0', '马拉维', 'Malawi');
INSERT INTO `jee_area` VALUES ('130', '3', ',3,130,', '2', '0', '马里', 'Mali');
INSERT INTO `jee_area` VALUES ('131', '3', ',3,131,', '2', '0', '毛里求斯', 'Mauritius');
INSERT INTO `jee_area` VALUES ('132', '3', ',3,132,', '2', '0', '毛里塔尼亚', 'Mauritania');
INSERT INTO `jee_area` VALUES ('133', '3', ',3,133,', '2', '0', '摩洛哥', 'Morocco');
INSERT INTO `jee_area` VALUES ('134', '3', ',3,134,', '2', '0', '莫桑比克', 'Mozambique');
INSERT INTO `jee_area` VALUES ('135', '3', ',3,135,', '2', '0', '纳米比亚', 'Namibia');
INSERT INTO `jee_area` VALUES ('136', '3', ',3,136,', '2', '0', '南非', 'South Africa');
INSERT INTO `jee_area` VALUES ('137', '3', ',3,137,', '2', '0', '尼日尔', 'Niger');
INSERT INTO `jee_area` VALUES ('138', '3', ',3,138,', '2', '0', '尼日利亚', 'Nigeria');
INSERT INTO `jee_area` VALUES ('139', '3', ',3,139,', '2', '0', '塞拉利昂', 'Sierra Leone');
INSERT INTO `jee_area` VALUES ('140', '3', ',3,140,', '2', '0', '塞内加尔', 'Senegal');
INSERT INTO `jee_area` VALUES ('141', '3', ',3,141,', '2', '0', '塞舌尔', 'Seychelles');
INSERT INTO `jee_area` VALUES ('142', '3', ',3,142,', '2', '0', '圣多美和普林西比', 'Sao Tome and Principe');
INSERT INTO `jee_area` VALUES ('143', '3', ',3,143,', '2', '0', '斯威士兰', 'Swaziland');
INSERT INTO `jee_area` VALUES ('144', '3', ',3,144,', '2', '0', '苏丹', 'Sudan');
INSERT INTO `jee_area` VALUES ('145', '3', ',3,145,', '2', '0', '索马里', 'Somalia');
INSERT INTO `jee_area` VALUES ('146', '3', ',3,146,', '2', '0', '坦桑尼亚', 'Tanzania');
INSERT INTO `jee_area` VALUES ('147', '3', ',3,147,', '2', '0', '突尼斯', 'Tunisia');
INSERT INTO `jee_area` VALUES ('148', '3', ',3,148,', '2', '0', '乌干达', 'Uganda');
INSERT INTO `jee_area` VALUES ('149', '3', ',3,149,', '2', '0', '西撒哈拉', 'Western Sahara');
INSERT INTO `jee_area` VALUES ('150', '3', ',3,150,', '2', '0', '赞比亚', 'Zambia');
INSERT INTO `jee_area` VALUES ('151', '3', ',3,151,', '2', '0', '乍得', 'Chad');
INSERT INTO `jee_area` VALUES ('152', '3', ',3,152,', '2', '0', '中非', 'Central African');
INSERT INTO `jee_area` VALUES ('153', '4', ',4,153,', '2', '0', '安提瓜和巴布达', 'Antigua and Barbuda');
INSERT INTO `jee_area` VALUES ('154', '4', ',4,154,', '2', '0', '巴哈马', 'Bahamas');
INSERT INTO `jee_area` VALUES ('155', '4', ',4,155,', '2', '0', '巴拿马', 'Panama');
INSERT INTO `jee_area` VALUES ('156', '4', ',4,156,', '2', '0', '伯利兹', 'Belize');
INSERT INTO `jee_area` VALUES ('157', '4', ',4,157,', '2', '0', '多米尼克', 'Dominica');
INSERT INTO `jee_area` VALUES ('158', '4', ',4,158,', '2', '0', '多米尼克', 'Dominique');
INSERT INTO `jee_area` VALUES ('159', '4', ',4,159,', '2', '0', '哥斯达黎加', 'Costa Rica');
INSERT INTO `jee_area` VALUES ('160', '4', ',4,160,', '2', '0', '格林纳达', 'Grenada');
INSERT INTO `jee_area` VALUES ('161', '4', ',4,161,', '2', '0', '古巴', 'Cuba');
INSERT INTO `jee_area` VALUES ('162', '4', ',4,162,', '2', '0', '洪都拉斯', 'Honduras');
INSERT INTO `jee_area` VALUES ('163', '4', ',4,163,', '2', '0', '加拿大', 'Canada');
INSERT INTO `jee_area` VALUES ('164', '4', ',4,164,', '2', '0', '美国', 'United States of America');
INSERT INTO `jee_area` VALUES ('165', '4', ',4,165,', '2', '0', '墨西哥', 'Mexico');
INSERT INTO `jee_area` VALUES ('166', '4', ',4,166,', '2', '0', '尼加拉瓜', 'Nicaragua');
INSERT INTO `jee_area` VALUES ('167', '4', ',4,167,', '2', '0', '萨尔瓦多', 'Salvador');
INSERT INTO `jee_area` VALUES ('168', '4', ',4,168,', '2', '0', '圣卢西亚', 'Saint Lucia');
INSERT INTO `jee_area` VALUES ('169', '4', ',4,169,', '2', '0', '特立尼达和多巴哥', 'Trinidad and Tobago');
INSERT INTO `jee_area` VALUES ('170', '4', ',4,170,', '2', '0', '危地马拉', 'Guatemala');
INSERT INTO `jee_area` VALUES ('171', '4', ',4,171,', '2', '0', '牙买加', 'Jamaica');
INSERT INTO `jee_area` VALUES ('172', '4', ',4,172,', '2', '0', '海地', 'Haiti');
INSERT INTO `jee_area` VALUES ('173', '4', ',4,173,', '2', '0', '圣基茨和尼维斯', 'Saint Kitts and Nevis');
INSERT INTO `jee_area` VALUES ('174', '4', ',4,174,', '2', '0', '圣文森特和格林纳丁斯', 'Saint Vincent and the Grenadines');
INSERT INTO `jee_area` VALUES ('175', '4', ',4,175,', '2', '0', '巴巴多斯', 'Barbados');
INSERT INTO `jee_area` VALUES ('176', '5', ',5,176,', '2', '0', '哥伦比亚', 'Columbia');
INSERT INTO `jee_area` VALUES ('177', '5', ',5,177,', '2', '0', '委内瑞拉', 'Venezuela');
INSERT INTO `jee_area` VALUES ('178', '5', ',5,178,', '2', '0', '圭亚那', 'Guyana');
INSERT INTO `jee_area` VALUES ('179', '5', ',5,179,', '2', '0', '苏里南', 'Suriname');
INSERT INTO `jee_area` VALUES ('180', '5', ',5,180,', '2', '0', '厄瓜多尔', 'Ecuador');
INSERT INTO `jee_area` VALUES ('181', '5', ',5,181,', '2', '0', '秘鲁', 'Peru');
INSERT INTO `jee_area` VALUES ('182', '5', ',5,182,', '2', '0', '玻利维亚', 'Bolivia');
INSERT INTO `jee_area` VALUES ('183', '5', ',5,183,', '2', '0', '巴西', 'Brazil');
INSERT INTO `jee_area` VALUES ('184', '5', ',5,184,', '2', '0', '智利', 'Chile');
INSERT INTO `jee_area` VALUES ('185', '5', ',5,185,', '2', '0', '阿根廷', 'Argentina');
INSERT INTO `jee_area` VALUES ('186', '5', ',5,186,', '2', '0', '乌拉圭', 'Uruguay');
INSERT INTO `jee_area` VALUES ('187', '5', ',5,187,', '2', '0', '巴拉圭', 'Paraguay');
INSERT INTO `jee_area` VALUES ('188', '6', ',6,188,', '2', '0', '澳大利亚', 'Australia');
INSERT INTO `jee_area` VALUES ('189', '6', ',6,189,', '2', '0', '新西兰', 'New Zealand');
INSERT INTO `jee_area` VALUES ('190', '6', ',6,190,', '2', '0', '巴布亚新几内亚', 'Papua New Guinea');
INSERT INTO `jee_area` VALUES ('191', '6', ',6,191,', '2', '0', '所罗门群岛', 'Solomon Islands');
INSERT INTO `jee_area` VALUES ('192', '6', ',6,192,', '2', '0', '瓦努阿图', 'Vanuatu');
INSERT INTO `jee_area` VALUES ('193', '6', ',6,193,', '2', '0', '密克罗尼西亚', 'Micronesia');
INSERT INTO `jee_area` VALUES ('194', '6', ',6,194,', '2', '0', '马绍尔群岛', 'Marshall Islands');
INSERT INTO `jee_area` VALUES ('195', '6', ',6,195,', '2', '0', '帕劳', 'Palau');
INSERT INTO `jee_area` VALUES ('196', '6', ',6,196,', '2', '0', '瑙鲁', 'Nauru');
INSERT INTO `jee_area` VALUES ('197', '6', ',6,197,', '2', '0', '基里巴斯', 'Kiribati');
INSERT INTO `jee_area` VALUES ('198', '6', ',6,198,', '2', '0', '图瓦卢', 'Tuvalu');
INSERT INTO `jee_area` VALUES ('199', '6', ',6,199,', '2', '0', '萨摩亚', 'Samoa');
INSERT INTO `jee_area` VALUES ('200', '6', ',6,200,', '2', '0', '斐济', 'Fiji');
INSERT INTO `jee_area` VALUES ('201', '6', ',6,201,', '2', '0', '汤加', 'Tonga');
INSERT INTO `jee_area` VALUES ('202', '6', ',6,202', '2', '0', '库克群岛', 'Cook Islands');
INSERT INTO `jee_area` VALUES ('203', '7', ',1,7,203,', '3', '1', '直辖市', 'ZhiXiaShi');
INSERT INTO `jee_area` VALUES ('204', '7', ',1,7,204,', '3', '2', '特别行政区', 'TeBieXingZhengQu');
INSERT INTO `jee_area` VALUES ('207', '7', ',1,7,207,', '3', '5', '河北', 'HeBei');
INSERT INTO `jee_area` VALUES ('208', '7', ',1,7,208,', '3', '6', '山西', 'ShanXi');
INSERT INTO `jee_area` VALUES ('209', '7', ',1,7,209,', '3', '7', '内蒙古', 'NeiMengGu');
INSERT INTO `jee_area` VALUES ('210', '7', ',1,7,210,', '3', '8', '辽宁', 'LiaoNing');
INSERT INTO `jee_area` VALUES ('211', '7', ',1,7,211,', '3', '9', '吉林', 'JiLin');
INSERT INTO `jee_area` VALUES ('212', '7', ',1,7,212,', '3', '10', '黑龙江', 'HeiLongJiang');
INSERT INTO `jee_area` VALUES ('213', '7', ',1,7,213,', '3', '11', '江苏', 'JiangSu');
INSERT INTO `jee_area` VALUES ('214', '7', ',1,7,214,', '3', '12', '浙江', 'ZheJiang');
INSERT INTO `jee_area` VALUES ('215', '7', ',1,7,215,', '3', '13', '安徽', 'AnHui');
INSERT INTO `jee_area` VALUES ('216', '7', ',1,7,216,', '3', '14', '福建', 'FuJian');
INSERT INTO `jee_area` VALUES ('217', '7', ',1,7,217,', '3', '15', '江西', 'JiangXi');
INSERT INTO `jee_area` VALUES ('218', '7', ',1,7,218,', '3', '16', '山东', 'ShanDong');
INSERT INTO `jee_area` VALUES ('219', '7', ',1,7,219,', '3', '17', '河南', 'HeNan');
INSERT INTO `jee_area` VALUES ('220', '7', ',1,7,220,', '3', '18', '湖北', 'HuBei');
INSERT INTO `jee_area` VALUES ('221', '7', ',1,7,221,', '3', '19', '湖南', 'HuNan');
INSERT INTO `jee_area` VALUES ('222', '7', ',1,7,222,', '3', '20', '广东', 'GuangDong');
INSERT INTO `jee_area` VALUES ('223', '7', ',1,7,223,', '3', '21', '广西', 'GuangXi');
INSERT INTO `jee_area` VALUES ('224', '7', ',1,7,224,', '3', '22', '海南', 'HaiNan');
INSERT INTO `jee_area` VALUES ('225', '7', ',1,7,225,', '3', '23', '四川', 'SiChuan');
INSERT INTO `jee_area` VALUES ('226', '7', ',1,7,226,', '3', '24', '贵州', 'GuiZhou');
INSERT INTO `jee_area` VALUES ('227', '7', ',1,7,227,', '3', '25', '云南', 'YunNan');
INSERT INTO `jee_area` VALUES ('228', '7', ',1,7,228,', '3', '26', '西藏', 'XiCang');
INSERT INTO `jee_area` VALUES ('229', '7', ',1,7,229,', '3', '27', '陕西', 'ShanXi');
INSERT INTO `jee_area` VALUES ('230', '7', ',1,7,230,', '3', '28', '甘肃', 'GanSu');
INSERT INTO `jee_area` VALUES ('231', '7', ',1,7,231,', '3', '29', '青海', 'QingHai');
INSERT INTO `jee_area` VALUES ('232', '7', ',1,7,232,', '3', '30', '宁夏', 'NingXia');
INSERT INTO `jee_area` VALUES ('233', '7', ',1,7,233,', '3', '31', '新疆', 'XinJiang');
INSERT INTO `jee_area` VALUES ('234', '7', ',1,7,234,', '3', '32', '台湾', 'TaiWan');
INSERT INTO `jee_area` VALUES ('235', '204', ',1,7,204,235,', '4', '1', '香港', 'XiangGang');
INSERT INTO `jee_area` VALUES ('236', '204', ',1,7,204,236,', '4', '2', '澳门', 'AoMen');
INSERT INTO `jee_area` VALUES ('237', '203', ',1,7,203,237,', '4', '1', '北京', 'BeiJing');
INSERT INTO `jee_area` VALUES ('238', '203', ',1,7,203,238,', '4', '1', '天津', 'TianJin');
INSERT INTO `jee_area` VALUES ('239', '203', ',1,7,203,239,', '4', '1', '上海', 'ShangHai');
INSERT INTO `jee_area` VALUES ('240', '203', ',1,7,203,240,', '4', '1', '重庆', 'ZhongQing');
INSERT INTO `jee_area` VALUES ('241', '207', ',1,7,207,241,', '4', '501', '石家庄', 'ShiJiaZhuang');
INSERT INTO `jee_area` VALUES ('242', '207', ',1,7,207,242,', '4', '4000', '唐山', 'TangShan');
INSERT INTO `jee_area` VALUES ('243', '207', ',1,7,207,243,', '4', '4000', '秦皇岛', 'QinHuangDao');
INSERT INTO `jee_area` VALUES ('244', '207', ',1,7,207,244,', '4', '4000', '邯郸', 'HanDan');
INSERT INTO `jee_area` VALUES ('245', '207', ',1,7,207,245,', '4', '4000', '邢台', 'XingTai');
INSERT INTO `jee_area` VALUES ('246', '207', ',1,7,207,246,', '4', '4000', '保定', 'BaoDing');
INSERT INTO `jee_area` VALUES ('247', '207', ',1,7,207,247,', '4', '4000', '张家口', 'ZhangJiaKou');
INSERT INTO `jee_area` VALUES ('248', '207', ',1,7,207,248,', '4', '4000', '承德', 'ChengDe');
INSERT INTO `jee_area` VALUES ('249', '207', ',1,7,207,249,', '4', '4000', '沧州', 'CangZhou');
INSERT INTO `jee_area` VALUES ('250', '207', ',1,7,207,250,', '4', '4000', '廊坊', 'LangFang');
INSERT INTO `jee_area` VALUES ('251', '207', ',1,7,207,251,', '4', '4000', '衡水', 'HengShui');
INSERT INTO `jee_area` VALUES ('252', '208', ',1,7,208,252,', '4', '4000', '吕梁', 'LvLiang');
INSERT INTO `jee_area` VALUES ('253', '208', ',1,7,208,253,', '4', '4000', '临汾', 'LinFen');
INSERT INTO `jee_area` VALUES ('254', '208', ',1,7,208,254,', '4', '4000', '忻州', 'XinZhou');
INSERT INTO `jee_area` VALUES ('255', '208', ',1,7,208,255,', '4', '4000', '运城', 'YunCheng');
INSERT INTO `jee_area` VALUES ('256', '208', ',1,7,208,256,', '4', '4000', '晋中', 'JinZhong');
INSERT INTO `jee_area` VALUES ('257', '208', ',1,7,208,257,', '4', '4000', '朔州', 'ShuoZhou');
INSERT INTO `jee_area` VALUES ('258', '208', ',1,7,208,258,', '4', '4000', '晋城', 'JinCheng');
INSERT INTO `jee_area` VALUES ('259', '208', ',1,7,208,259,', '4', '4000', '长治', 'ChangZhi');
INSERT INTO `jee_area` VALUES ('260', '208', ',1,7,208,260,', '4', '4000', '阳泉', 'YangQuan');
INSERT INTO `jee_area` VALUES ('261', '208', ',1,7,208,261,', '4', '4000', '大同', 'DaTong');
INSERT INTO `jee_area` VALUES ('262', '208', ',1,7,208,262,', '4', '4000', '太原', 'TaiYuan');
INSERT INTO `jee_area` VALUES ('263', '209', ',1,7,209,263,', '4', '4000', '阿拉善盟', 'ALaShanMeng');
INSERT INTO `jee_area` VALUES ('264', '209', ',1,7,209,264,', '4', '4000', '兴安盟', 'XingAnMeng');
INSERT INTO `jee_area` VALUES ('265', '209', ',1,7,209,265,', '4', '4000', '呼伦贝尔', 'HuLunBeiEr');
INSERT INTO `jee_area` VALUES ('266', '209', ',1,7,209,266,', '4', '4000', '鄂尔多斯', 'EErDuoSi');
INSERT INTO `jee_area` VALUES ('267', '209', ',1,7,209,267,', '4', '4000', '通辽', 'TongLiao');
INSERT INTO `jee_area` VALUES ('268', '209', ',1,7,209,268,', '4', '4000', '赤峰', 'ChiFeng');
INSERT INTO `jee_area` VALUES ('269', '209', ',1,7,209,269,', '4', '4000', '包头', 'BaoTou');
INSERT INTO `jee_area` VALUES ('270', '209', ',1,7,209,270,', '4', '4000', '呼和浩特', 'HuHeHaoTe');
INSERT INTO `jee_area` VALUES ('271', '209', ',1,7,209,271,', '4', '4000', '乌海', 'WuHai');
INSERT INTO `jee_area` VALUES ('272', '210', ',1,7,210,272,', '4', '4000', '葫芦岛', 'HuLuDao');
INSERT INTO `jee_area` VALUES ('273', '210', ',1,7,210,273,', '4', '4000', '朝阳', 'ChaoYang');
INSERT INTO `jee_area` VALUES ('274', '210', ',1,7,210,274,', '4', '4000', '铁岭', 'TieLing');
INSERT INTO `jee_area` VALUES ('275', '210', ',1,7,210,275,', '4', '4000', '盘锦', 'PanJin');
INSERT INTO `jee_area` VALUES ('276', '210', ',1,7,210,276,', '4', '4000', '辽阳', 'LiaoYang');
INSERT INTO `jee_area` VALUES ('277', '210', ',1,7,210,277,', '4', '4000', '阜新', 'FuXin');
INSERT INTO `jee_area` VALUES ('278', '210', ',1,7,210,278,', '4', '4000', '营口', 'YingKou');
INSERT INTO `jee_area` VALUES ('279', '210', ',1,7,210,279,', '4', '4000', '锦州', 'JinZhou');
INSERT INTO `jee_area` VALUES ('280', '210', ',1,7,210,280,', '4', '4000', '丹东', 'DanDong');
INSERT INTO `jee_area` VALUES ('281', '210', ',1,7,210,281,', '4', '4000', '本溪', 'BenXi');
INSERT INTO `jee_area` VALUES ('282', '210', ',1,7,210,282,', '4', '4000', '抚顺', 'FuShun');
INSERT INTO `jee_area` VALUES ('283', '210', ',1,7,210,283,', '4', '4000', '鞍山', 'AnShan');
INSERT INTO `jee_area` VALUES ('284', '210', ',1,7,210,284,', '4', '4000', '大连', 'DaLian');
INSERT INTO `jee_area` VALUES ('285', '210', ',1,7,210,285,', '4', '4000', '沈阳', 'ShenYang');
INSERT INTO `jee_area` VALUES ('286', '211', ',1,7,211,286,', '4', '4000', '白城', 'BaiCheng');
INSERT INTO `jee_area` VALUES ('287', '211', ',1,7,211,287,', '4', '4000', '松原', 'SongYuan');
INSERT INTO `jee_area` VALUES ('288', '211', ',1,7,211,288,', '4', '4000', '白山', 'BaiShan');
INSERT INTO `jee_area` VALUES ('289', '211', ',1,7,211,289,', '4', '4000', '通化', 'TongHua');
INSERT INTO `jee_area` VALUES ('290', '211', ',1,7,211,290,', '4', '4000', '辽源', 'LiaoYuan');
INSERT INTO `jee_area` VALUES ('291', '211', ',1,7,211,291,', '4', '4000', '四平', 'SiPing');
INSERT INTO `jee_area` VALUES ('292', '211', ',1,7,211,292,', '4', '4000', '吉林', 'JiLin');
INSERT INTO `jee_area` VALUES ('293', '211', ',1,7,211,293,', '4', '4000', '长春', 'ChangChun');
INSERT INTO `jee_area` VALUES ('294', '212', ',1,7,212,294,', '4', '4000', '大兴安岭', 'DaXingAnLing');
INSERT INTO `jee_area` VALUES ('295', '212', ',1,7,212,295,', '4', '4000', '绥化', 'SuiHua');
INSERT INTO `jee_area` VALUES ('296', '212', ',1,7,212,296,', '4', '4000', '黑河', 'HeiHe');
INSERT INTO `jee_area` VALUES ('297', '212', ',1,7,212,297,', '4', '4000', '七台河', 'QiTaiHe');
INSERT INTO `jee_area` VALUES ('298', '212', ',1,7,212,298,', '4', '4000', '佳木斯', 'JiaMuSi');
INSERT INTO `jee_area` VALUES ('299', '212', ',1,7,212,299,', '4', '4000', '牡丹江', 'MuDanJiang');
INSERT INTO `jee_area` VALUES ('300', '212', ',1,7,212,300,', '4', '4000', '伊春', 'YiChun');
INSERT INTO `jee_area` VALUES ('301', '212', ',1,7,212,301,', '4', '4000', '大庆', 'DaQing');
INSERT INTO `jee_area` VALUES ('302', '212', ',1,7,212,302,', '4', '4000', '鸡西', 'JiXi');
INSERT INTO `jee_area` VALUES ('303', '212', ',1,7,212,303,', '4', '4000', '双鸭山', 'ShuangYaShan');
INSERT INTO `jee_area` VALUES ('304', '212', ',1,7,212,304,', '4', '4000', '鹤岗', 'HeGang');
INSERT INTO `jee_area` VALUES ('305', '212', ',1,7,212,305,', '4', '4000', '齐齐哈尔', 'QiQiHaEr');
INSERT INTO `jee_area` VALUES ('306', '212', ',1,7,212,306,', '4', '4000', '哈尔滨', 'HaErBin');
INSERT INTO `jee_area` VALUES ('307', '213', ',1,7,213,307,', '4', '4000', '宿迁', 'XiuQian');
INSERT INTO `jee_area` VALUES ('308', '213', ',1,7,213,308,', '4', '4000', '泰州', 'TaiZhou');
INSERT INTO `jee_area` VALUES ('309', '213', ',1,7,213,309,', '4', '4000', '镇江', 'ZhenJiang');
INSERT INTO `jee_area` VALUES ('310', '213', ',1,7,213,310,', '4', '4000', '扬州', 'YangZhou');
INSERT INTO `jee_area` VALUES ('311', '213', ',1,7,213,311,', '4', '4000', '盐城', 'YanCheng');
INSERT INTO `jee_area` VALUES ('312', '213', ',1,7,213,312,', '4', '4000', '淮安', 'HuaiAn');
INSERT INTO `jee_area` VALUES ('313', '213', ',1,7,213,313,', '4', '4000', '连云港', 'LianYunGang');
INSERT INTO `jee_area` VALUES ('314', '213', ',1,7,213,314,', '4', '4000', '南通', 'NanTong');
INSERT INTO `jee_area` VALUES ('315', '213', ',1,7,213,315,', '4', '4000', '苏州', 'SuZhou');
INSERT INTO `jee_area` VALUES ('316', '213', ',1,7,213,316,', '4', '4000', '常州', 'ChangZhou');
INSERT INTO `jee_area` VALUES ('317', '213', ',1,7,213,317,', '4', '4000', '徐州', 'XuZhou');
INSERT INTO `jee_area` VALUES ('318', '213', ',1,7,213,318,', '4', '4000', '无锡', 'WuXi');
INSERT INTO `jee_area` VALUES ('319', '213', ',1,7,213,319,', '4', '4000', '南京', 'NanJing');
INSERT INTO `jee_area` VALUES ('320', '214', ',1,7,214,320,', '4', '4000', '丽水', 'LiShui');
INSERT INTO `jee_area` VALUES ('321', '214', ',1,7,214,321,', '4', '4000', '台州', 'TaiZhou');
INSERT INTO `jee_area` VALUES ('322', '214', ',1,7,214,322,', '4', '4000', '舟山', 'ZhouShan');
INSERT INTO `jee_area` VALUES ('323', '214', ',1,7,214,323,', '4', '4000', '衢州', 'QuZhou');
INSERT INTO `jee_area` VALUES ('324', '214', ',1,7,214,324,', '4', '4000', '金华', 'JinHua');
INSERT INTO `jee_area` VALUES ('325', '214', ',1,7,214,325,', '4', '4000', '绍兴', 'ShaoXing');
INSERT INTO `jee_area` VALUES ('326', '214', ',1,7,214,326,', '4', '4000', '湖州', 'HuZhou');
INSERT INTO `jee_area` VALUES ('327', '214', ',1,7,214,327,', '4', '4000', '嘉兴', 'JiaXing');
INSERT INTO `jee_area` VALUES ('328', '214', ',1,7,214,328,', '4', '4000', '温州', 'WenZhou');
INSERT INTO `jee_area` VALUES ('329', '214', ',1,7,214,329,', '4', '4000', '宁波', 'NingBo');
INSERT INTO `jee_area` VALUES ('330', '214', ',1,7,214,330,', '4', '4000', '杭州', 'HangZhou');
INSERT INTO `jee_area` VALUES ('331', '215', ',1,7,215,331,', '4', '4000', '宣城', 'XuanCheng');
INSERT INTO `jee_area` VALUES ('332', '215', ',1,7,215,332,', '4', '4000', '池州', 'ChiZhou');
INSERT INTO `jee_area` VALUES ('333', '215', ',1,7,215,333,', '4', '4000', '亳州', 'BoZhou');
INSERT INTO `jee_area` VALUES ('334', '215', ',1,7,215,334,', '4', '4000', '六安', 'LiuAn');
INSERT INTO `jee_area` VALUES ('335', '215', ',1,7,215,335,', '4', '4000', '巢湖', 'ChaoHu');
INSERT INTO `jee_area` VALUES ('336', '215', ',1,7,215,336,', '4', '4000', '宿州', 'XiuZhou');
INSERT INTO `jee_area` VALUES ('337', '215', ',1,7,215,337,', '4', '4000', '阜阳', 'FuYang');
INSERT INTO `jee_area` VALUES ('338', '215', ',1,7,215,338,', '4', '4000', '滁州', 'ChuZhou');
INSERT INTO `jee_area` VALUES ('339', '215', ',1,7,215,339,', '4', '4000', '黄山', 'HuangShan');
INSERT INTO `jee_area` VALUES ('340', '215', ',1,7,215,340,', '4', '4000', '安庆', 'AnQing');
INSERT INTO `jee_area` VALUES ('341', '215', ',1,7,215,341,', '4', '4000', '铜陵', 'TongLing');
INSERT INTO `jee_area` VALUES ('342', '215', ',1,7,215,342,', '4', '4000', '淮北', 'HuaiBei');
INSERT INTO `jee_area` VALUES ('343', '215', ',1,7,215,343,', '4', '4000', '马鞍山', 'MaAnShan');
INSERT INTO `jee_area` VALUES ('344', '215', ',1,7,215,344,', '4', '4000', '淮南', 'HuaiNan');
INSERT INTO `jee_area` VALUES ('345', '215', ',1,7,215,345,', '4', '4000', '蚌埠', 'BangBu');
INSERT INTO `jee_area` VALUES ('346', '215', ',1,7,215,346,', '4', '4000', '芜湖', 'WuHu');
INSERT INTO `jee_area` VALUES ('347', '215', ',1,7,215,347,', '4', '4000', '合肥', 'HeFei');
INSERT INTO `jee_area` VALUES ('348', '216', ',1,7,216,348,', '4', '4000', '宁德', 'NingDe');
INSERT INTO `jee_area` VALUES ('349', '216', ',1,7,216,349,', '4', '4000', '龙岩', 'LongYan');
INSERT INTO `jee_area` VALUES ('350', '216', ',1,7,216,350,', '4', '4000', '南平', 'NanPing');
INSERT INTO `jee_area` VALUES ('351', '216', ',1,7,216,351,', '4', '4000', '漳州', 'ZhangZhou');
INSERT INTO `jee_area` VALUES ('352', '216', ',1,7,216,352,', '4', '4000', '泉州', 'QuanZhou');
INSERT INTO `jee_area` VALUES ('353', '216', ',1,7,216,353,', '4', '4000', '三明', 'SanMing');
INSERT INTO `jee_area` VALUES ('354', '216', ',1,7,216,354,', '4', '4000', '莆田', 'PuTian');
INSERT INTO `jee_area` VALUES ('355', '216', ',1,7,216,355,', '4', '4000', '厦门', 'ShaMen');
INSERT INTO `jee_area` VALUES ('356', '216', ',1,7,216,356,', '4', '4000', '福州', 'FuZhou');
INSERT INTO `jee_area` VALUES ('357', '217', ',1,7,217,357,', '4', '4000', '上饶', 'ShangRao');
INSERT INTO `jee_area` VALUES ('358', '217', ',1,7,217,358,', '4', '4000', '抚州', 'FuZhou');
INSERT INTO `jee_area` VALUES ('359', '217', ',1,7,217,359,', '4', '4000', '宜春', 'YiChun');
INSERT INTO `jee_area` VALUES ('360', '217', ',1,7,217,360,', '4', '4000', '吉安', 'JiAn');
INSERT INTO `jee_area` VALUES ('361', '217', ',1,7,217,361,', '4', '4000', '赣州', 'GanZhou');
INSERT INTO `jee_area` VALUES ('362', '217', ',1,7,217,362,', '4', '4000', '鹰潭', 'YingTan');
INSERT INTO `jee_area` VALUES ('363', '217', ',1,7,217,363,', '4', '4000', '新余', 'XinYu');
INSERT INTO `jee_area` VALUES ('364', '217', ',1,7,217,364,', '4', '4000', '九江', 'JiuJiang');
INSERT INTO `jee_area` VALUES ('365', '217', ',1,7,217,365,', '4', '4000', '萍乡', 'PingXiang');
INSERT INTO `jee_area` VALUES ('366', '217', ',1,7,217,366,', '4', '4000', '景德镇', 'JingDeZhen');
INSERT INTO `jee_area` VALUES ('367', '217', ',1,7,217,367,', '4', '4000', '南昌', 'NanChang');
INSERT INTO `jee_area` VALUES ('368', '218', ',1,7,218,368,', '4', '4000', '菏泽', 'HeZe');
INSERT INTO `jee_area` VALUES ('369', '218', ',1,7,218,369,', '4', '4000', '滨州', 'BinZhou');
INSERT INTO `jee_area` VALUES ('370', '218', ',1,7,218,370,', '4', '4000', '聊城', 'LiaoCheng');
INSERT INTO `jee_area` VALUES ('371', '218', ',1,7,218,371,', '4', '4000', '德州', 'DeZhou');
INSERT INTO `jee_area` VALUES ('372', '218', ',1,7,218,372,', '4', '4000', '临沂', 'LinYi');
INSERT INTO `jee_area` VALUES ('373', '218', ',1,7,218,373,', '4', '4000', '莱芜', 'LaiWu');
INSERT INTO `jee_area` VALUES ('374', '218', ',1,7,218,374,', '4', '4000', '日照', 'RiZhao');
INSERT INTO `jee_area` VALUES ('375', '218', ',1,7,218,375,', '4', '4000', '威海', 'WeiHai');
INSERT INTO `jee_area` VALUES ('376', '218', ',1,7,218,376,', '4', '4000', '泰安', 'TaiAn');
INSERT INTO `jee_area` VALUES ('377', '218', ',1,7,218,377,', '4', '4000', '济宁', 'JiNing');
INSERT INTO `jee_area` VALUES ('378', '218', ',1,7,218,378,', '4', '4000', '潍坊', 'WeiFang');
INSERT INTO `jee_area` VALUES ('379', '218', ',1,7,218,379,', '4', '4000', '烟台', 'YanTai');
INSERT INTO `jee_area` VALUES ('380', '218', ',1,7,218,380,', '4', '4000', '东营', 'DongYing');
INSERT INTO `jee_area` VALUES ('381', '218', ',1,7,218,381,', '4', '4000', '枣庄', 'ZaoZhuang');
INSERT INTO `jee_area` VALUES ('382', '218', ',1,7,218,382,', '4', '4000', '淄博', 'ZiBo');
INSERT INTO `jee_area` VALUES ('383', '218', ',1,7,218,383,', '4', '4000', '青岛', 'QingDao');
INSERT INTO `jee_area` VALUES ('384', '218', ',1,7,218,384,', '4', '4000', '济南', 'JiNan');
INSERT INTO `jee_area` VALUES ('385', '219', ',1,7,219,385,', '4', '4000', '济源', 'JiYuan');
INSERT INTO `jee_area` VALUES ('386', '219', ',1,7,219,386,', '4', '4000', '驻马店', 'ZhuMaDian');
INSERT INTO `jee_area` VALUES ('387', '219', ',1,7,219,387,', '4', '4000', '周口', 'ZhouKou');
INSERT INTO `jee_area` VALUES ('388', '219', ',1,7,219,388,', '4', '4000', '信阳', 'XinYang');
INSERT INTO `jee_area` VALUES ('389', '219', ',1,7,219,389,', '4', '4000', '商丘', 'ShangQiu');
INSERT INTO `jee_area` VALUES ('390', '219', ',1,7,219,390,', '4', '4000', '南阳', 'NanYang');
INSERT INTO `jee_area` VALUES ('391', '219', ',1,7,219,391,', '4', '4000', '三门峡', 'SanMenXia');
INSERT INTO `jee_area` VALUES ('392', '219', ',1,7,219,392,', '4', '4000', '漯河', 'LuoHe');
INSERT INTO `jee_area` VALUES ('393', '219', ',1,7,219,393,', '4', '4000', '许昌', 'XuChang');
INSERT INTO `jee_area` VALUES ('394', '219', ',1,7,219,394,', '4', '4000', '濮阳', 'PuYang');
INSERT INTO `jee_area` VALUES ('395', '219', ',1,7,219,395,', '4', '4000', '焦作', 'JiaoZuo');
INSERT INTO `jee_area` VALUES ('396', '219', ',1,7,219,396,', '4', '4000', '新乡', 'XinXiang');
INSERT INTO `jee_area` VALUES ('397', '219', ',1,7,219,397,', '4', '4000', '鹤壁', 'HeBi');
INSERT INTO `jee_area` VALUES ('398', '219', ',1,7,219,398,', '4', '4000', '安阳', 'AnYang');
INSERT INTO `jee_area` VALUES ('399', '219', ',1,7,219,399,', '4', '4000', '平顶山', 'PingDingShan');
INSERT INTO `jee_area` VALUES ('400', '219', ',1,7,219,400,', '4', '4000', '洛阳', 'LuoYang');
INSERT INTO `jee_area` VALUES ('401', '219', ',1,7,219,401,', '4', '4000', '开封', 'KaiFeng');
INSERT INTO `jee_area` VALUES ('402', '219', ',1,7,219,402,', '4', '4000', '郑州', 'ZhengZhou');
INSERT INTO `jee_area` VALUES ('403', '220', ',1,7,220,403,', '4', '4000', '随州', 'SuiZhou');
INSERT INTO `jee_area` VALUES ('404', '220', ',1,7,220,404,', '4', '4000', '咸宁', 'XianNing');
INSERT INTO `jee_area` VALUES ('405', '220', ',1,7,220,405,', '4', '4000', '黄冈', 'HuangGang');
INSERT INTO `jee_area` VALUES ('406', '220', ',1,7,220,406,', '4', '4000', '孝感', 'XiaoGan');
INSERT INTO `jee_area` VALUES ('407', '220', ',1,7,220,407,', '4', '4000', '荆门', 'JingMen');
INSERT INTO `jee_area` VALUES ('408', '220', ',1,7,220,408,', '4', '4000', '鄂州', 'EZhou');
INSERT INTO `jee_area` VALUES ('409', '220', ',1,7,220,409,', '4', '4000', '襄樊', 'XiangFan');
INSERT INTO `jee_area` VALUES ('410', '220', ',1,7,220,410,', '4', '4000', '宜昌', 'YiChang');
INSERT INTO `jee_area` VALUES ('411', '220', ',1,7,220,411,', '4', '4000', '荆州', 'JingZhou');
INSERT INTO `jee_area` VALUES ('412', '220', ',1,7,220,412,', '4', '4000', '十堰', 'ShiYan');
INSERT INTO `jee_area` VALUES ('413', '220', ',1,7,220,413,', '4', '4000', '黄石', 'HuangShi');
INSERT INTO `jee_area` VALUES ('414', '220', ',1,7,220,414,', '4', '4000', '武汉', 'WuHan');
INSERT INTO `jee_area` VALUES ('415', '221', ',1,7,221,415,', '4', '4000', '娄底', 'LouDi');
INSERT INTO `jee_area` VALUES ('416', '221', ',1,7,221,416,', '4', '4000', '怀化', 'HuaiHua');
INSERT INTO `jee_area` VALUES ('417', '221', ',1,7,221,417,', '4', '4000', '永州', 'YongZhou');
INSERT INTO `jee_area` VALUES ('418', '221', ',1,7,221,418,', '4', '4000', '郴州', 'ChenZhou');
INSERT INTO `jee_area` VALUES ('419', '221', ',1,7,221,419,', '4', '4000', '益阳', 'YiYang');
INSERT INTO `jee_area` VALUES ('420', '221', ',1,7,221,420,', '4', '4000', '张家界', 'ZhangJiaJie');
INSERT INTO `jee_area` VALUES ('421', '221', ',1,7,221,421,', '4', '4000', '常德', 'ChangDe');
INSERT INTO `jee_area` VALUES ('422', '221', ',1,7,221,422,', '4', '4000', '岳阳', 'YueYang');
INSERT INTO `jee_area` VALUES ('423', '221', ',1,7,221,423,', '4', '4000', '邵阳', 'ShaoYang');
INSERT INTO `jee_area` VALUES ('424', '221', ',1,7,221,424,', '4', '4000', '衡阳', 'HengYang');
INSERT INTO `jee_area` VALUES ('425', '221', ',1,7,221,425,', '4', '4000', '湘潭', 'XiangTan');
INSERT INTO `jee_area` VALUES ('426', '221', ',1,7,221,426,', '4', '4000', '株洲', 'ZhuZhou');
INSERT INTO `jee_area` VALUES ('427', '221', ',1,7,221,427,', '4', '4000', '长沙', 'ChangSha');
INSERT INTO `jee_area` VALUES ('428', '222', ',1,7,222,428,', '4', '2', '深圳', 'ShenZhen');
INSERT INTO `jee_area` VALUES ('429', '222', ',1,7,222,429,', '4', '3', '佛山', 'FoShan');
INSERT INTO `jee_area` VALUES ('430', '222', ',1,7,222,430,', '4', '4', '珠海', 'ZhuHai');
INSERT INTO `jee_area` VALUES ('431', '222', ',1,7,222,431,', '4', '7', '汕头', 'ShanTou');
INSERT INTO `jee_area` VALUES ('432', '222', ',1,7,222,432,', '4', '8', '韶关', 'ShaoGuan');
INSERT INTO `jee_area` VALUES ('433', '222', ',1,7,222,433,', '4', '9', '江门', 'JiangMen');
INSERT INTO `jee_area` VALUES ('434', '222', ',1,7,222,434,', '4', '10', '湛江', 'ZhanJiang');
INSERT INTO `jee_area` VALUES ('435', '222', ',1,7,222,435,', '4', '1', '广州', 'GuangZhou');
INSERT INTO `jee_area` VALUES ('436', '222', ',1,7,222,436,', '4', '5', '东莞', 'DongWan');
INSERT INTO `jee_area` VALUES ('437', '222', ',1,7,222,437,', '4', '6', '中山', 'ZhongShan');
INSERT INTO `jee_area` VALUES ('438', '222', ',1,7,222,438,', '4', '11', '惠州', 'HuiZhou');
INSERT INTO `jee_area` VALUES ('439', '222', ',1,7,222,439,', '4', '12', '潮州', 'ChaoZhou');
INSERT INTO `jee_area` VALUES ('440', '222', ',1,7,222,440,', '4', '13', '揭阳', 'JieYang');
INSERT INTO `jee_area` VALUES ('441', '222', ',1,7,222,441,', '4', '14', '汕尾', 'ShanWei');
INSERT INTO `jee_area` VALUES ('442', '222', ',1,7,222,442,', '4', '15', '梅州', 'MeiZhou');
INSERT INTO `jee_area` VALUES ('443', '222', ',1,7,222,443,', '4', '16', '清远', 'QingYuan');
INSERT INTO `jee_area` VALUES ('444', '222', ',1,7,222,444,', '4', '17', '河源', 'HeYuan');
INSERT INTO `jee_area` VALUES ('445', '222', ',1,7,222,445,', '4', '18', '茂名', 'MaoMing');
INSERT INTO `jee_area` VALUES ('446', '222', ',1,7,222,446,', '4', '19', '云浮', 'YunFu');
INSERT INTO `jee_area` VALUES ('447', '222', ',1,7,222,447,', '4', '20', '肇庆', 'ZhaoQing');
INSERT INTO `jee_area` VALUES ('448', '222', ',1,7,222,448,', '4', '21', '阳江', 'YangJiang');
INSERT INTO `jee_area` VALUES ('449', '223', ',1,7,223,449,', '4', '4000', '崇左', 'ChongZuo');
INSERT INTO `jee_area` VALUES ('450', '223', ',1,7,223,450,', '4', '4000', '来宾', 'LaiBin');
INSERT INTO `jee_area` VALUES ('451', '223', ',1,7,223,451,', '4', '4000', '河池', 'HeChi');
INSERT INTO `jee_area` VALUES ('452', '223', ',1,7,223,452,', '4', '4000', '贺州', 'HeZhou');
INSERT INTO `jee_area` VALUES ('453', '223', ',1,7,223,453,', '4', '4000', '百色', 'BaiSe');
INSERT INTO `jee_area` VALUES ('454', '223', ',1,7,223,454,', '4', '4000', '玉林', 'YuLin');
INSERT INTO `jee_area` VALUES ('455', '223', ',1,7,223,455,', '4', '4000', '贵港', 'GuiGang');
INSERT INTO `jee_area` VALUES ('456', '223', ',1,7,223,456,', '4', '4000', '钦州', 'QinZhou');
INSERT INTO `jee_area` VALUES ('457', '223', ',1,7,223,457,', '4', '4000', '防城港', 'FangChengGang');
INSERT INTO `jee_area` VALUES ('458', '223', ',1,7,223,458,', '4', '4000', '北海', 'BeiHai');
INSERT INTO `jee_area` VALUES ('459', '223', ',1,7,223,459,', '4', '4000', '梧州', 'WuZhou');
INSERT INTO `jee_area` VALUES ('460', '223', ',1,7,223,460,', '4', '4000', '桂林', 'GuiLin');
INSERT INTO `jee_area` VALUES ('461', '223', ',1,7,223,461,', '4', '4000', '柳州', 'LiuZhou');
INSERT INTO `jee_area` VALUES ('462', '223', ',1,7,223,462,', '4', '4000', '南宁', 'NanNing');
INSERT INTO `jee_area` VALUES ('463', '224', ',1,7,224,463,', '4', '4000', '海口', 'HaiKou');
INSERT INTO `jee_area` VALUES ('464', '224', ',1,7,224,464,', '4', '4000', '三亚', 'SanYa');
INSERT INTO `jee_area` VALUES ('465', '225', ',1,7,225,465,', '4', '4000', '资阳', 'ZiYang');
INSERT INTO `jee_area` VALUES ('466', '225', ',1,7,225,466,', '4', '4000', '巴中', 'BaZhong');
INSERT INTO `jee_area` VALUES ('467', '225', ',1,7,225,467,', '4', '4000', '雅安', 'YaAn');
INSERT INTO `jee_area` VALUES ('468', '225', ',1,7,225,468,', '4', '4000', '达州', 'DaZhou');
INSERT INTO `jee_area` VALUES ('469', '225', ',1,7,225,469,', '4', '4000', '广安', 'GuangAn');
INSERT INTO `jee_area` VALUES ('470', '225', ',1,7,225,470,', '4', '4000', '宜宾', 'YiBin');
INSERT INTO `jee_area` VALUES ('471', '225', ',1,7,225,471,', '4', '4000', '眉山', 'MeiShan');
INSERT INTO `jee_area` VALUES ('472', '225', ',1,7,225,472,', '4', '4000', '南充', 'NanChong');
INSERT INTO `jee_area` VALUES ('473', '225', ',1,7,225,473,', '4', '4000', '乐山', 'LeShan');
INSERT INTO `jee_area` VALUES ('474', '225', ',1,7,225,474,', '4', '4000', '内江', 'NeiJiang');
INSERT INTO `jee_area` VALUES ('475', '225', ',1,7,225,475,', '4', '4000', '遂宁', 'SuiNing');
INSERT INTO `jee_area` VALUES ('476', '225', ',1,7,225,476,', '4', '4000', '广元', 'GuangYuan');
INSERT INTO `jee_area` VALUES ('477', '225', ',1,7,225,477,', '4', '4000', '绵阳', 'MianYang');
INSERT INTO `jee_area` VALUES ('478', '225', ',1,7,225,478,', '4', '4000', '德阳', 'DeYang');
INSERT INTO `jee_area` VALUES ('479', '225', ',1,7,225,479,', '4', '4000', '泸州', 'LuZhou');
INSERT INTO `jee_area` VALUES ('480', '225', ',1,7,225,480,', '4', '4000', '攀枝花', 'PanZhiHua');
INSERT INTO `jee_area` VALUES ('481', '225', ',1,7,225,481,', '4', '4000', '自贡', 'ZiGong');
INSERT INTO `jee_area` VALUES ('482', '225', ',1,7,225,482,', '4', '4000', '成都', 'ChengDou');
INSERT INTO `jee_area` VALUES ('483', '226', ',1,7,226,483,', '4', '4000', '毕节地区', 'BiJieDiQu');
INSERT INTO `jee_area` VALUES ('484', '226', ',1,7,226,484,', '4', '4000', '铜仁地区', 'TongRenDiQu');
INSERT INTO `jee_area` VALUES ('485', '226', ',1,7,226,485,', '4', '4000', '安顺', 'AnShun');
INSERT INTO `jee_area` VALUES ('486', '226', ',1,7,226,486,', '4', '4000', '遵义', 'ZunYi');
INSERT INTO `jee_area` VALUES ('487', '226', ',1,7,226,487,', '4', '4000', '六盘水', 'LiuPanShui');
INSERT INTO `jee_area` VALUES ('488', '226', ',1,7,226,488,', '4', '4000', '贵阳', 'GuiYang');
INSERT INTO `jee_area` VALUES ('489', '227', ',1,7,227,489,', '4', '4000', '临沧', 'LinCang');
INSERT INTO `jee_area` VALUES ('490', '227', ',1,7,227,490,', '4', '4000', '普洱', 'PuEr');
INSERT INTO `jee_area` VALUES ('491', '227', ',1,7,227,491,', '4', '4000', '丽江', 'LiJiang');
INSERT INTO `jee_area` VALUES ('492', '227', ',1,7,227,492,', '4', '4000', '昭通', 'ZhaoTong');
INSERT INTO `jee_area` VALUES ('493', '227', ',1,7,227,493,', '4', '4000', '保山', 'BaoShan');
INSERT INTO `jee_area` VALUES ('494', '227', ',1,7,227,494,', '4', '4000', '玉溪', 'YuXi');
INSERT INTO `jee_area` VALUES ('495', '227', ',1,7,227,495,', '4', '4000', '曲靖', 'QuJing');
INSERT INTO `jee_area` VALUES ('496', '227', ',1,7,227,496,', '4', '4000', '昆明', 'KunMing');
INSERT INTO `jee_area` VALUES ('497', '228', ',1,7,228,497,', '4', '4000', '林芝', 'LinZhi');
INSERT INTO `jee_area` VALUES ('498', '228', ',1,7,228,498,', '4', '4000', '阿里', 'ALi');
INSERT INTO `jee_area` VALUES ('499', '228', ',1,7,228,499,', '4', '4000', '日喀则', 'RiKaZe');
INSERT INTO `jee_area` VALUES ('500', '228', ',1,7,228,500,', '4', '4000', '山南', 'ShanNan');
INSERT INTO `jee_area` VALUES ('501', '228', ',1,7,228,501,', '4', '4000', '昌都', 'ChangDou');
INSERT INTO `jee_area` VALUES ('502', '228', ',1,7,228,502,', '4', '4000', '那曲', 'NaQu');
INSERT INTO `jee_area` VALUES ('503', '228', ',1,7,228,503,', '4', '4000', '拉萨', 'LaSa');
INSERT INTO `jee_area` VALUES ('504', '229', ',1,7,229,504,', '4', '4000', '商洛', 'ShangLuo');
INSERT INTO `jee_area` VALUES ('505', '229', ',1,7,229,505,', '4', '4000', '安康', 'AnKang');
INSERT INTO `jee_area` VALUES ('506', '229', ',1,7,229,506,', '4', '4000', '榆林', 'YuLin');
INSERT INTO `jee_area` VALUES ('507', '229', ',1,7,229,507,', '4', '4000', '汉中', 'HanZhong');
INSERT INTO `jee_area` VALUES ('508', '229', ',1,7,229,508,', '4', '4000', '延安', 'YanAn');
INSERT INTO `jee_area` VALUES ('509', '229', ',1,7,229,509,', '4', '4000', '渭南', 'WeiNan');
INSERT INTO `jee_area` VALUES ('510', '229', ',1,7,229,510,', '4', '4000', '咸阳', 'XianYang');
INSERT INTO `jee_area` VALUES ('511', '229', ',1,7,229,511,', '4', '4000', '宝鸡', 'BaoJi');
INSERT INTO `jee_area` VALUES ('512', '229', ',1,7,229,512,', '4', '4000', '铜川', 'TongChuan');
INSERT INTO `jee_area` VALUES ('513', '229', ',1,7,229,513,', '4', '4000', '西安', 'XiAn');
INSERT INTO `jee_area` VALUES ('514', '230', ',1,7,230,514,', '4', '4000', '陇南', 'LongNan');
INSERT INTO `jee_area` VALUES ('515', '230', ',1,7,230,515,', '4', '4000', '定西', 'DingXi');
INSERT INTO `jee_area` VALUES ('516', '230', ',1,7,230,516,', '4', '4000', '庆阳', 'QingYang');
INSERT INTO `jee_area` VALUES ('517', '230', ',1,7,230,517,', '4', '4000', '酒泉', 'JiuQuan');
INSERT INTO `jee_area` VALUES ('518', '230', ',1,7,230,518,', '4', '4000', '平凉', 'PingLiang');
INSERT INTO `jee_area` VALUES ('519', '230', ',1,7,230,519,', '4', '4000', '张掖', 'ZhangYe');
INSERT INTO `jee_area` VALUES ('520', '230', ',1,7,230,520,', '4', '4000', '武威', 'WuWei');
INSERT INTO `jee_area` VALUES ('521', '230', ',1,7,230,521,', '4', '4000', '嘉峪关', 'JiaYuGuan');
INSERT INTO `jee_area` VALUES ('522', '230', ',1,7,230,522,', '4', '4000', '天水', 'TianShui');
INSERT INTO `jee_area` VALUES ('523', '230', ',1,7,230,523,', '4', '4000', '白银', 'BaiYin');
INSERT INTO `jee_area` VALUES ('524', '230', ',1,7,230,524,', '4', '4000', '金昌', 'JinChang');
INSERT INTO `jee_area` VALUES ('525', '230', ',1,7,230,525,', '4', '4000', '兰州', 'LanZhou');
INSERT INTO `jee_area` VALUES ('526', '231', ',1,7,231,526,', '4', '4000', '海东', 'HaiDong');
INSERT INTO `jee_area` VALUES ('527', '231', ',1,7,231,527,', '4', '4000', '西宁', 'XiNing');
INSERT INTO `jee_area` VALUES ('528', '232', ',1,7,232,528,', '4', '4000', '中卫', 'ZhongWei');
INSERT INTO `jee_area` VALUES ('529', '232', ',1,7,232,529,', '4', '4000', '固原', 'GuYuan');
INSERT INTO `jee_area` VALUES ('530', '232', ',1,7,232,530,', '4', '4000', '吴忠', 'WuZhong');
INSERT INTO `jee_area` VALUES ('531', '232', ',1,7,232,531,', '4', '4000', '石嘴山', 'ShiZuiShan');
INSERT INTO `jee_area` VALUES ('532', '232', ',1,7,232,532,', '4', '4000', '银川', 'YinChuan');
INSERT INTO `jee_area` VALUES ('533', '233', ',1,7,233,533,', '4', '4000', '阿勒泰', 'ALeTai');
INSERT INTO `jee_area` VALUES ('534', '233', ',1,7,233,534,', '4', '4000', '塔城', 'TaCheng');
INSERT INTO `jee_area` VALUES ('535', '233', ',1,7,233,535,', '4', '4000', '喀什地区', 'KaShiDiQu');
INSERT INTO `jee_area` VALUES ('536', '233', ',1,7,233,536,', '4', '4000', '阿克苏区', 'AKeSuQu');
INSERT INTO `jee_area` VALUES ('537', '233', ',1,7,233,537,', '4', '4000', '和田地区', 'HeTianDiQu');
INSERT INTO `jee_area` VALUES ('538', '233', ',1,7,233,538,', '4', '4000', '哈密地区', 'HaMiDiQu');
INSERT INTO `jee_area` VALUES ('539', '233', ',1,7,233,539,', '4', '4000', '吐鲁番', 'TuLuFan');
INSERT INTO `jee_area` VALUES ('540', '233', ',1,7,233,540,', '4', '4000', '克拉玛依', 'KeLaMaYi');
INSERT INTO `jee_area` VALUES ('541', '233', ',1,7,233,541,', '4', '4000', '乌鲁木齐', 'WuLuMuQi');
INSERT INTO `jee_area` VALUES ('542', '235', ',1,7,235,542,', '4', '4000', '元朗区', 'YuanLangQu');
INSERT INTO `jee_area` VALUES ('543', '235', ',1,7,235,543,', '4', '4000', '荃湾区', 'QuanWanQu');
INSERT INTO `jee_area` VALUES ('544', '235', ',1,7,235,544,', '4', '4000', '大埔区', 'DaPuQu');
INSERT INTO `jee_area` VALUES ('545', '235', ',1,7,235,545,', '4', '4000', '屯门区', 'TunMenQu');
INSERT INTO `jee_area` VALUES ('546', '235', ',1,7,235,546,', '4', '4000', '沙田区', 'ShaTianQu');
INSERT INTO `jee_area` VALUES ('547', '235', ',1,7,235,547,', '4', '4000', '西贡区', 'XiGongQu');
INSERT INTO `jee_area` VALUES ('548', '235', ',1,7,235,548,', '4', '4000', '北区', 'BeiQu');
INSERT INTO `jee_area` VALUES ('549', '235', ',1,7,235,549,', '4', '4000', '葵青区', 'KuiQingQu');
INSERT INTO `jee_area` VALUES ('550', '235', ',1,7,235,550,', '4', '4000', '离岛区', 'LiDaoQu');
INSERT INTO `jee_area` VALUES ('551', '235', ',1,7,235,551,', '4', '4000', '油尖旺区', 'YouJianWangQu');
INSERT INTO `jee_area` VALUES ('552', '235', ',1,7,235,552,', '4', '4000', '湾仔区', 'WanZaiQu');
INSERT INTO `jee_area` VALUES ('553', '235', ',1,7,235,553,', '4', '4000', '黄大仙区', 'HuangDaXianQu');
INSERT INTO `jee_area` VALUES ('554', '235', ',1,7,235,554,', '4', '4000', '深水埗区', 'ShenShuiBuQu');
INSERT INTO `jee_area` VALUES ('555', '235', ',1,7,235,555,', '4', '4000', '南区', 'NanQu');
INSERT INTO `jee_area` VALUES ('556', '235', ',1,7,235,556,', '4', '4000', '观塘区', 'GuanTangQu');
INSERT INTO `jee_area` VALUES ('557', '235', ',1,7,235,557,', '4', '4000', '九龙城区', 'JiuLongChengQu');
INSERT INTO `jee_area` VALUES ('558', '235', ',1,7,235,558,', '4', '4000', '东区', 'DongQu');
INSERT INTO `jee_area` VALUES ('559', '235', ',1,7,235,559,', '4', '4000', '中西区', 'ZhongXiQu');
INSERT INTO `jee_area` VALUES ('560', '234', ',1,7,234,560,', '4', '4000', '澎湖', 'PengHu');
INSERT INTO `jee_area` VALUES ('561', '234', ',1,7,234,561,', '4', '4000', '花莲', 'HuaLian');
INSERT INTO `jee_area` VALUES ('562', '234', ',1,7,234,562,', '4', '4000', '台东', 'TaiDong');
INSERT INTO `jee_area` VALUES ('563', '234', ',1,7,234,563,', '4', '4000', '屏东', 'PingDong');
INSERT INTO `jee_area` VALUES ('564', '234', ',1,7,234,564,', '4', '4000', '高雄', 'GaoXiong');
INSERT INTO `jee_area` VALUES ('565', '234', ',1,7,234,565,', '4', '4000', '台南', 'TaiNan');
INSERT INTO `jee_area` VALUES ('566', '234', ',1,7,234,566,', '4', '4000', '云林', 'YunLin');
INSERT INTO `jee_area` VALUES ('567', '234', ',1,7,234,567,', '4', '4000', '嘉义', 'JiaYi');
INSERT INTO `jee_area` VALUES ('568', '234', ',1,7,234,568,', '4', '4000', '南投', 'NanTou');
INSERT INTO `jee_area` VALUES ('569', '234', ',1,7,234,569,', '4', '4000', '彰化', 'ZhangHua');
INSERT INTO `jee_area` VALUES ('570', '234', ',1,7,234,570,', '4', '4000', '台中', 'TaiZhong');
INSERT INTO `jee_area` VALUES ('571', '234', ',1,7,234,571,', '4', '4000', '苗栗', 'MiaoLi');
INSERT INTO `jee_area` VALUES ('572', '234', ',1,7,234,572,', '4', '4000', '桃园', 'TaoYuan');
INSERT INTO `jee_area` VALUES ('573', '234', ',1,7,234,573,', '4', '4000', '新竹', 'XinZhu');
INSERT INTO `jee_area` VALUES ('574', '234', ',1,7,234,574,', '4', '4000', '宜兰', 'YiLan');
INSERT INTO `jee_area` VALUES ('575', '234', ',1,7,234,575,', '4', '4000', '台北', 'TaiBei');
INSERT INTO `jee_area` VALUES ('576', '234', ',1,7,234,576,', '4', '4000', '嘉义', 'JiaYi');
INSERT INTO `jee_area` VALUES ('577', '234', ',1,7,234,577,', '4', '4000', '新竹', 'XinZhu');
INSERT INTO `jee_area` VALUES ('578', '234', ',1,7,234,578,', '4', '4000', '台南', 'TaiNan');
INSERT INTO `jee_area` VALUES ('579', '234', ',1,7,234,579,', '4', '4000', '台中', 'TaiZhong');
INSERT INTO `jee_area` VALUES ('580', '234', ',1,7,234,580,', '4', '4000', '基隆', 'JiLong');
INSERT INTO `jee_area` VALUES ('581', '234', ',1,7,234,581,', '4', '4000', '高雄', 'GaoXiong');
INSERT INTO `jee_area` VALUES ('582', '234', ',1,7,234,582,', '4', '4000', '台北', 'TaiBei');
INSERT INTO `jee_area` VALUES ('583', '443', ',1,7,222,443,583,', '5', '1', '清新', 'QingXin');
INSERT INTO `jee_area` VALUES ('584', '237', ',1,7,203,237,584,', '5', '0', '富来宫温泉', '');
INSERT INTO `jee_area` VALUES ('585', '237', ',1,7,203,237,585,', '5', '0', '承德', '');
INSERT INTO `jee_area` VALUES ('586', '237', ',1,7,203,237,586,', '5', '0', '门头沟', '');
INSERT INTO `jee_area` VALUES ('587', '237', ',1,7,203,237,587,', '5', '0', '平谷区', '');
INSERT INTO `jee_area` VALUES ('588', '237', ',1,7,203,237,588,', '5', '0', '延庆', '');
INSERT INTO `jee_area` VALUES ('589', '237', ',1,7,203,237,589,', '5', '0', '龙脉温泉', '');
INSERT INTO `jee_area` VALUES ('590', '237', ',1,7,203,237,590,', '5', '0', '九华山庄', '');
INSERT INTO `jee_area` VALUES ('591', '237', ',1,7,203,237,591,', '5', '0', '花水湾温泉', '');
INSERT INTO `jee_area` VALUES ('592', '237', ',1,7,203,237,592,', '5', '0', '温都温泉', '');
INSERT INTO `jee_area` VALUES ('593', '237', ',1,7,203,237,593,', '5', '0', '南宫温泉', '');
INSERT INTO `jee_area` VALUES ('594', '237', ',1,7,203,237,594,', '5', '0', '八达岭温泉', '');
INSERT INTO `jee_area` VALUES ('595', '237', ',1,7,203,237,595,', '5', '0', '张裕爱斐堡', '');
INSERT INTO `jee_area` VALUES ('596', '237', ',1,7,203,237,596,', '5', '0', '故宫', '');
INSERT INTO `jee_area` VALUES ('597', '237', ',1,7,203,237,597,', '5', '0', '慕田峪长城', '');
INSERT INTO `jee_area` VALUES ('598', '237', ',1,7,203,237,598,', '5', '0', '八达岭长城', '');
INSERT INTO `jee_area` VALUES ('599', '237', ',1,7,203,237,599,', '5', '0', '颐和园', '');
INSERT INTO `jee_area` VALUES ('600', '237', ',1,7,203,237,600,', '5', '0', '天坛', '');
INSERT INTO `jee_area` VALUES ('601', '237', ',1,7,203,237,601,', '5', '0', '恭王府', '');
INSERT INTO `jee_area` VALUES ('602', '237', ',1,7,203,237,602,', '5', '0', '鸟巢', '');
INSERT INTO `jee_area` VALUES ('603', '237', ',1,7,203,237,603,', '5', '0', '月坨岛', '');
INSERT INTO `jee_area` VALUES ('604', '237', ',1,7,203,237,604,', '5', '0', '密云', '');
INSERT INTO `jee_area` VALUES ('605', '262', ',1,7,208,262,605,', '5', '0', '晋祠', '');
INSERT INTO `jee_area` VALUES ('606', '256', ',1,7,208,256,606,', '5', '0', '绵山', '');
INSERT INTO `jee_area` VALUES ('607', '254', ',1,7,208,254,607,', '5', '0', '五台山', '');
INSERT INTO `jee_area` VALUES ('608', '256', ',1,7,208,256,608,', '5', '0', '平遥古城', '');
INSERT INTO `jee_area` VALUES ('609', '256', ',1,7,208,256,609,', '5', '0', '乔家大院', '');
INSERT INTO `jee_area` VALUES ('610', '256', ',1,7,208,256,610,', '5', '0', '常家庄园', '');
INSERT INTO `jee_area` VALUES ('611', '256', ',1,7,208,256,611,', '5', '0', '王家大院', '');
INSERT INTO `jee_area` VALUES ('612', '464', ',1,7,224,464,612,', '5', '0', '蜈支洲岛', '');
INSERT INTO `jee_area` VALUES ('613', '464', ',1,7,224,464,613,', '5', '0', '天涯海角', '');
INSERT INTO `jee_area` VALUES ('614', '464', ',1,7,224,464,614,', '5', '0', '南山文化苑', '');
INSERT INTO `jee_area` VALUES ('615', '227', ',1,7,227,615,', '4', '4000', '迪庆', 'DiQing');
INSERT INTO `jee_area` VALUES ('616', '615', ',1,7,227,615,616,', '5', '0', '香格里拉', '');
INSERT INTO `jee_area` VALUES ('617', '227', ',1,7,227,617,', '4', '4000', '西双版纳', 'XiShuangBanNa');
INSERT INTO `jee_area` VALUES ('618', '491', ',1,7,227,491,618,', '5', '0', '泸沽湖', '');
INSERT INTO `jee_area` VALUES ('619', '227', ',1,7,227,619,', '4', '4000', '大理', 'DaLi');
INSERT INTO `jee_area` VALUES ('620', '493', ',1,7,227,493,620,', '5', '0', '腾冲', '');
INSERT INTO `jee_area` VALUES ('621', '227', ',1,7,227,621,', '4', '4000', '德宏', 'DeHong');
INSERT INTO `jee_area` VALUES ('622', '621', ',1,7,227,621,622,', '5', '0', '瑞丽', '');
INSERT INTO `jee_area` VALUES ('623', '225', ',1,7,225,623,', '4', '4000', '阿坝', 'ABa');
INSERT INTO `jee_area` VALUES ('624', '623', ',1,7,225,623,624,', '5', '0', '九寨沟', '');
INSERT INTO `jee_area` VALUES ('625', '473', ',1,7,225,473,625,', '5', '0', '峨眉山', '');
INSERT INTO `jee_area` VALUES ('626', '460', ',1,7,223,460,626,', '5', '0', '龙脊梯田', '');
INSERT INTO `jee_area` VALUES ('627', '460', ',1,7,223,460,627,', '5', '0', '阳朔', '');
INSERT INTO `jee_area` VALUES ('628', '322', ',1,7,214,322,628,', '5', '0', '普陀山', '');
INSERT INTO `jee_area` VALUES ('629', '328', ',1,7,214,328,629,', '5', '0', '雁荡山', '');
INSERT INTO `jee_area` VALUES ('630', '324', ',1,7,214,324,630,', '5', '0', '横店', '');
INSERT INTO `jee_area` VALUES ('631', '327', ',1,7,214,327,631,', '5', '0', '乌镇', '');
INSERT INTO `jee_area` VALUES ('632', '330', ',1,7,214,330,632,', '5', '0', '千岛湖', '');
INSERT INTO `jee_area` VALUES ('633', '330', ',1,7,214,330,633,', '5', '0', '西溪湿地', '');
INSERT INTO `jee_area` VALUES ('634', '416', ',1,7,221,416,634,', '5', '0', '凤凰古城', '');
INSERT INTO `jee_area` VALUES ('635', '420', ',1,7,221,420,635,', '5', '0', '黄石寨', '');
INSERT INTO `jee_area` VALUES ('636', '221', ',1,7,221,636,', '4', '4000', '湘西', 'XiangXi');
INSERT INTO `jee_area` VALUES ('637', '636', ',1,7,221,636,637,', '5', '0', '芙蓉镇', '');
INSERT INTO `jee_area` VALUES ('638', '420', ',1,7,221,420,638,', '5', '0', '天门山', '');
INSERT INTO `jee_area` VALUES ('639', '294', ',1,7,212,294,639,', '5', '0', '漠河', '');
INSERT INTO `jee_area` VALUES ('640', '306', ',1,7,212,306,640,', '5', '0', '亚布力', '');
INSERT INTO `jee_area` VALUES ('641', '306', ',1,7,212,306,641,', '5', '0', '雪乡1111', '');
INSERT INTO `jee_area` VALUES ('642', '299', ',1,7,212,299,642,', '5', '0', '雪乡', '');
INSERT INTO `jee_area` VALUES ('643', '299', ',1,7,212,299,643,', '5', '0', '镜泊湖', '');
INSERT INTO `jee_area` VALUES ('644', '395', ',1,7,219,395,644,', '5', '0', '云台山', '');
INSERT INTO `jee_area` VALUES ('645', '400', ',1,7,219,400,645,', '5', '0', '龙门石窟', '');
INSERT INTO `jee_area` VALUES ('646', '402', ',1,7,219,402,646,', '5', '0', '少林寺', '');
INSERT INTO `jee_area` VALUES ('647', '503', ',1,7,228,503,647,', '5', '0', '布达拉宫', '');
INSERT INTO `jee_area` VALUES ('648', '500', ',1,7,228,500,648,', '5', '0', '羊卓雍措', '');
INSERT INTO `jee_area` VALUES ('649', '355', ',1,7,216,355,649,', '5', '0', '武夷山', '');
INSERT INTO `jee_area` VALUES ('650', '349', ',1,7,216,349,650,', '5', '0', '永定土楼', '');
INSERT INTO `jee_area` VALUES ('651', '351', ',1,7,216,351,651,', '5', '0', '南靖土楼', '');
INSERT INTO `jee_area` VALUES ('652', '513', ',1,7,229,513,652,', '5', '0', '兵马俑', '');
INSERT INTO `jee_area` VALUES ('653', '513', ',1,7,229,513,653,', '5', '0', '华清池', '');
INSERT INTO `jee_area` VALUES ('654', '513', ',1,7,229,513,654,', '5', '0', '华山', '');
INSERT INTO `jee_area` VALUES ('655', '511', ',1,7,229,511,655,', '5', '0', '法门寺', '');
INSERT INTO `jee_area` VALUES ('656', '364', ',1,7,217,364,656,', '5', '0', '庐山', '');
INSERT INTO `jee_area` VALUES ('657', '357', ',1,7,217,357,657,', '5', '0', '三清山', '');
INSERT INTO `jee_area` VALUES ('658', '357', ',1,7,217,357,658,', '5', '0', '婺源', '');
INSERT INTO `jee_area` VALUES ('659', '360', ',1,7,217,360,659,', '5', '0', '井冈山', '');
INSERT INTO `jee_area` VALUES ('660', '17', ',1,17,660,', '3', '0', '普吉岛', '');
INSERT INTO `jee_area` VALUES ('661', '21', ',1,21,661,', '3', '0', '巴厘岛', '');
INSERT INTO `jee_area` VALUES ('662', '12', ',1,12,662,', '3', '0', '长滩岛', '');
INSERT INTO `jee_area` VALUES ('663', '18', ',1,18,663,', '3', '0', '沙巴', '');
INSERT INTO `jee_area` VALUES ('664', '11', ',1,11,664,', '3', '0', '京都', 'kyoto');
INSERT INTO `jee_area` VALUES ('665', '11', ',1,11,665,', '3', '0', '东京', 'tokyo');
INSERT INTO `jee_area` VALUES ('666', '11', ',1,11,666,', '3', '0', '大阪', '');
INSERT INTO `jee_area` VALUES ('667', '10', ',1,10,667,', '3', '0', '济州岛', '');
INSERT INTO `jee_area` VALUES ('668', '10', ',1,10,668,', '3', '0', '首尔', '');
INSERT INTO `jee_area` VALUES ('669', '164', ',4,164,669,', '3', '0', '夏威夷', '');
INSERT INTO `jee_area` VALUES ('670', '47', ',1,47,670,', '3', '0', '迪拜', '');
INSERT INTO `jee_area` VALUES ('671', '17', ',1,17,671,', '3', '0', '曼谷', '');
INSERT INTO `jee_area` VALUES ('672', '17', ',1,17,672,', '3', '0', '芭提雅', '');
INSERT INTO `jee_area` VALUES ('673', '237', ',1,7,203,237,673,', '5', '0', '怀柔', '');
INSERT INTO `jee_area` VALUES ('674', '237', ',1,7,203,237,674,', '5', '0', '平谷', '');
INSERT INTO `jee_area` VALUES ('675', '621', ',1,7,227,621,675,', '5', '0', '芒市', '');
INSERT INTO `jee_area` VALUES ('676', '377', ',1,7,218,377,676,', '5', '0', '曲阜', '');
INSERT INTO `jee_area` VALUES ('677', '237', ',1,7,203,237,677,', '5', '0', '十渡', '');
INSERT INTO `jee_area` VALUES ('678', '246', ',1,7,207,246,678,', '5', '0', '野三坡', '');
INSERT INTO `jee_area` VALUES ('679', '237', ',1,7,203,237,679,', '5', '0', '龙庆峡', '');
INSERT INTO `jee_area` VALUES ('680', '376', ',1,7,218,376,680,', '5', '0', '泰山', '');
INSERT INTO `jee_area` VALUES ('681', '237', ',1,7,203,237,681,', '5', '0', '双龙峡', '');
INSERT INTO `jee_area` VALUES ('682', '237', ',1,7,203,237,682,', '5', '0', '爨底下', '');
INSERT INTO `jee_area` VALUES ('683', '237', ',1,7,203,237,683,', '5', '0', '石花洞', '');
INSERT INTO `jee_area` VALUES ('684', '237', ',1,7,203,237,684,', '5', '0', '云蒙山', '');
INSERT INTO `jee_area` VALUES ('685', '246', ',1,7,207,246,685,', '5', '0', '白洋淀', '');
INSERT INTO `jee_area` VALUES ('686', '261', ',1,7,208,261,686,', '5', '0', '云冈石窟', '');
INSERT INTO `jee_area` VALUES ('687', '355', ',1,7,216,355,687,', '5', '0', '鼓浪屿', '');
INSERT INTO `jee_area` VALUES ('688', '499', ',1,7,228,499,688,', '5', '0', '珠穆朗玛峰', '');
INSERT INTO `jee_area` VALUES ('689', '485', ',1,7,226,485,689,', '5', '0', '黄果树瀑布', '');
INSERT INTO `jee_area` VALUES ('690', '288', ',1,7,211,288,690,', '5', '0', '长白山', '');
INSERT INTO `jee_area` VALUES ('691', '248', ',1,7,207,248,691,', '5', '0', '坝上草原', '');
INSERT INTO `jee_area` VALUES ('692', '248', ',1,7,207,248,692,', '5', '0', '木兰围场', '');
INSERT INTO `jee_area` VALUES ('693', '379', ',1,7,218,379,693,', '5', '0', '蓬莱', '');
INSERT INTO `jee_area` VALUES ('694', '284', ',1,7,210,284,694,', '5', '0', '旅顺', '');
INSERT INTO `jee_area` VALUES ('695', '242', ',1,7,207,242,695,', '5', '0', '月坨岛', '');
INSERT INTO `jee_area` VALUES ('696', '243', ',1,7,207,243,696,', '5', '0', '北戴河', '');
INSERT INTO `jee_area` VALUES ('697', '237', ',1,7,203,237,697,', '5', '0', '朝阳', 'dd');
INSERT INTO `jee_area` VALUES ('698', '237', ',1,7,203,237,698,', '5', '0', '海淀', '');
INSERT INTO `jee_area` VALUES ('699', '237', ',1,7,203,237,699,', '5', '0', '东城', '');
INSERT INTO `jee_area` VALUES ('700', '237', ',1,7,203,237,700,', '5', '0', '丰台', '');
INSERT INTO `jee_area` VALUES ('701', '237', ',1,7,203,237,701,', '5', '0', '西城', '');
INSERT INTO `jee_area` VALUES ('702', '237', ',1,7,203,237,702,', '5', '0', '宣武', '');
INSERT INTO `jee_area` VALUES ('703', '237', ',1,7,203,237,703,', '5', '0', '崇文', '');
INSERT INTO `jee_area` VALUES ('704', '237', ',1,7,203,237,704,', '5', '0', '昌平', '');
INSERT INTO `jee_area` VALUES ('705', '237', ',1,7,203,237,705,', '5', '0', '顺义', '');
INSERT INTO `jee_area` VALUES ('706', '237', ',1,7,203,237,706,', '5', '0', '大兴', '');
INSERT INTO `jee_area` VALUES ('707', '237', ',1,7,203,237,707,', '5', '0', '通州', '');
INSERT INTO `jee_area` VALUES ('708', '237', ',1,7,203,237,708,', '5', '0', '房山', '');
INSERT INTO `jee_area` VALUES ('709', '237', ',1,7,203,237,709,', '5', '0', '石景山', '');
INSERT INTO `jee_area` VALUES ('710', '237', ',1,7,203,237,710,', '5', '0', '密云县', '');
INSERT INTO `jee_area` VALUES ('711', '238', ',1,7,203,238,711,', '5', '0', '南开', '');
INSERT INTO `jee_area` VALUES ('712', '238', ',1,7,203,238,712,', '5', '0', '滨海', '');
INSERT INTO `jee_area` VALUES ('713', '238', ',1,7,203,238,713,', '5', '0', '河西', '');
INSERT INTO `jee_area` VALUES ('714', '238', ',1,7,203,238,714,', '5', '0', '和平', '');
INSERT INTO `jee_area` VALUES ('715', '238', ',1,7,203,238,715,', '5', '0', '河东', '');
INSERT INTO `jee_area` VALUES ('716', '238', ',1,7,203,238,716,', '5', '0', '河北', '');
INSERT INTO `jee_area` VALUES ('717', '238', ',1,7,203,238,717,', '5', '0', '东丽', '');
INSERT INTO `jee_area` VALUES ('718', '238', ',1,7,203,238,718,', '5', '0', '红桥', '');
INSERT INTO `jee_area` VALUES ('719', '238', ',1,7,203,238,719,', '5', '0', '津南', '');
INSERT INTO `jee_area` VALUES ('720', '238', ',1,7,203,238,720,', '5', '0', '西青', '');
INSERT INTO `jee_area` VALUES ('721', '238', ',1,7,203,238,721,', '5', '0', '蓟县大港', '');
INSERT INTO `jee_area` VALUES ('722', '238', ',1,7,203,238,722,', '5', '0', '武清', '');
INSERT INTO `jee_area` VALUES ('723', '238', ',1,7,203,238,723,', '5', '0', '静海', '');
INSERT INTO `jee_area` VALUES ('724', '238', ',1,7,203,238,724,', '5', '0', '北辰', '');
INSERT INTO `jee_area` VALUES ('725', '238', ',1,7,203,238,725,', '5', '0', '宝坻', '');
INSERT INTO `jee_area` VALUES ('726', '238', ',1,7,203,238,726,', '5', '0', '北辰区', '');
INSERT INTO `jee_area` VALUES ('727', '238', ',1,7,203,238,727,', '5', '0', '宁河县', '');
INSERT INTO `jee_area` VALUES ('728', '239', ',1,7,203,239,728,', '5', '0', '浦东', '');
INSERT INTO `jee_area` VALUES ('729', '239', ',1,7,203,239,729,', '5', '0', '徐汇', '');
INSERT INTO `jee_area` VALUES ('730', '239', ',1,7,203,239,730,', '5', '0', '黄浦', '');
INSERT INTO `jee_area` VALUES ('731', '239', ',1,7,203,239,731,', '5', '0', '长宁', '');
INSERT INTO `jee_area` VALUES ('732', '239', ',1,7,203,239,732,', '5', '0', '闵行', '');
INSERT INTO `jee_area` VALUES ('733', '239', ',1,7,203,239,733,', '5', '0', '虹口', '');
INSERT INTO `jee_area` VALUES ('734', '239', ',1,7,203,239,734,', '5', '0', '普陀', '');
INSERT INTO `jee_area` VALUES ('735', '239', ',1,7,203,239,735,', '5', '0', '闸北', '');
INSERT INTO `jee_area` VALUES ('736', '239', ',1,7,203,239,736,', '5', '0', '杨浦', '');
INSERT INTO `jee_area` VALUES ('737', '239', ',1,7,203,239,737,', '5', '0', '静安', '');
INSERT INTO `jee_area` VALUES ('738', '239', ',1,7,203,239,738,', '5', '0', '松江', '');
INSERT INTO `jee_area` VALUES ('739', '239', ',1,7,203,239,739,', '5', '0', '卢湾', '');
INSERT INTO `jee_area` VALUES ('740', '239', ',1,7,203,239,740,', '5', '0', '宝山', '');
INSERT INTO `jee_area` VALUES ('741', '239', ',1,7,203,239,741,', '5', '0', '嘉定', '');
INSERT INTO `jee_area` VALUES ('742', '239', ',1,7,203,239,742,', '5', '0', '奉贤', '');
INSERT INTO `jee_area` VALUES ('743', '239', ',1,7,203,239,743,', '5', '0', '青浦', '');
INSERT INTO `jee_area` VALUES ('744', '239', ',1,7,203,239,744,', '5', '0', '崇明', '');
INSERT INTO `jee_area` VALUES ('745', '239', ',1,7,203,239,745,', '5', '0', '金山', '');
INSERT INTO `jee_area` VALUES ('746', '239', ',1,7,203,239,746,', '5', '0', '南汇', '');
INSERT INTO `jee_area` VALUES ('747', '319', ',1,7,213,319,747,', '5', '0', '白下', '');
INSERT INTO `jee_area` VALUES ('748', '319', ',1,7,213,319,748,', '5', '0', '鼓楼', '');
INSERT INTO `jee_area` VALUES ('749', '319', ',1,7,213,319,749,', '5', '0', '玄武', '');
INSERT INTO `jee_area` VALUES ('750', '319', ',1,7,213,319,750,', '5', '0', '江宁', '');
INSERT INTO `jee_area` VALUES ('751', '319', ',1,7,213,319,751,', '5', '0', '秦淮', '');
INSERT INTO `jee_area` VALUES ('752', '319', ',1,7,213,319,752,', '5', '0', '建邺', '');
INSERT INTO `jee_area` VALUES ('753', '319', ',1,7,213,319,753,', '5', '0', '下关', '');
INSERT INTO `jee_area` VALUES ('754', '319', ',1,7,213,319,754,', '5', '0', '雨花', '');
INSERT INTO `jee_area` VALUES ('755', '319', ',1,7,213,319,755,', '5', '0', '浦口', '');
INSERT INTO `jee_area` VALUES ('756', '319', ',1,7,213,319,756,', '5', '0', '栖霞', '');
INSERT INTO `jee_area` VALUES ('757', '319', ',1,7,213,319,757,', '5', '0', '六合', '');
INSERT INTO `jee_area` VALUES ('758', '319', ',1,7,213,319,758,', '5', '0', '高淳', '');
INSERT INTO `jee_area` VALUES ('759', '435', ',1,7,222,435,759,', '5', '0', '天河', '');
INSERT INTO `jee_area` VALUES ('760', '435', ',1,7,222,435,760,', '5', '0', '越秀', '');
INSERT INTO `jee_area` VALUES ('761', '435', ',1,7,222,435,761,', '5', '0', '白云', '');
INSERT INTO `jee_area` VALUES ('762', '435', ',1,7,222,435,762,', '5', '0', '海珠', '');
INSERT INTO `jee_area` VALUES ('763', '435', ',1,7,222,435,763,', '5', '0', '番禺', '');
INSERT INTO `jee_area` VALUES ('764', '435', ',1,7,222,435,764,', '5', '0', '荔湾', '');
INSERT INTO `jee_area` VALUES ('765', '435', ',1,7,222,435,765,', '5', '0', '花都', '');
INSERT INTO `jee_area` VALUES ('766', '435', ',1,7,222,435,766,', '5', '0', '增城', '');
INSERT INTO `jee_area` VALUES ('767', '435', ',1,7,222,435,767,', '5', '0', '黄埔', '');
INSERT INTO `jee_area` VALUES ('768', '435', ',1,7,222,435,768,', '5', '0', '萝岗', '');
INSERT INTO `jee_area` VALUES ('769', '435', ',1,7,222,435,769,', '5', '0', '南沙', '');
INSERT INTO `jee_area` VALUES ('770', '435', ',1,7,222,435,770,', '5', '0', '芳村', '');
INSERT INTO `jee_area` VALUES ('771', '435', ',1,7,222,435,771,', '5', '0', '从化', '');
INSERT INTO `jee_area` VALUES ('772', '482', ',1,7,225,482,772,', '5', '0', '锦江', '');
INSERT INTO `jee_area` VALUES ('773', '482', ',1,7,225,482,773,', '5', '0', '青羊', '');
INSERT INTO `jee_area` VALUES ('774', '482', ',1,7,225,482,774,', '5', '0', '武侯', '');
INSERT INTO `jee_area` VALUES ('775', '482', ',1,7,225,482,775,', '5', '0', '金牛', '');
INSERT INTO `jee_area` VALUES ('776', '482', ',1,7,225,482,776,', '5', '0', '双流', '');
INSERT INTO `jee_area` VALUES ('777', '482', ',1,7,225,482,777,', '5', '0', '成华', '');
INSERT INTO `jee_area` VALUES ('778', '482', ',1,7,225,482,778,', '5', '0', '高新', '');
INSERT INTO `jee_area` VALUES ('779', '482', ',1,7,225,482,779,', '5', '0', '温江', '');
INSERT INTO `jee_area` VALUES ('780', '482', ',1,7,225,482,780,', '5', '0', '崇州', '');
INSERT INTO `jee_area` VALUES ('781', '482', ',1,7,225,482,781,', '5', '0', '郫县', '');
INSERT INTO `jee_area` VALUES ('782', '482', ',1,7,225,482,782,', '5', '0', '新都', '');
INSERT INTO `jee_area` VALUES ('783', '482', ',1,7,225,482,783,', '5', '0', '青白江', '');
INSERT INTO `jee_area` VALUES ('784', '482', ',1,7,225,482,784,', '5', '0', '邛崃', '');
INSERT INTO `jee_area` VALUES ('785', '482', ',1,7,225,482,785,', '5', '0', '新津', '');
INSERT INTO `jee_area` VALUES ('786', '482', ',1,7,225,482,786,', '5', '0', '龙泉驿', '');
INSERT INTO `jee_area` VALUES ('787', '482', ',1,7,225,482,787,', '5', '0', '大邑', '');
INSERT INTO `jee_area` VALUES ('788', '482', ',1,7,225,482,788,', '5', '0', '蒲江', '');
INSERT INTO `jee_area` VALUES ('789', '414', ',1,7,220,414,789,', '5', '0', '武昌', '');
INSERT INTO `jee_area` VALUES ('790', '414', ',1,7,220,414,790,', '5', '0', '汉口', '');
INSERT INTO `jee_area` VALUES ('791', '414', ',1,7,220,414,791,', '5', '0', '汉阳', '');
INSERT INTO `jee_area` VALUES ('792', '414', ',1,7,220,414,792,', '5', '0', '青山', '');
INSERT INTO `jee_area` VALUES ('793', '414', ',1,7,220,414,793,', '5', '0', '蔡甸', '');
INSERT INTO `jee_area` VALUES ('794', '414', ',1,7,220,414,794,', '5', '0', '江夏', '');
INSERT INTO `jee_area` VALUES ('795', '414', ',1,7,220,414,795,', '5', '0', '阳逻', '');
INSERT INTO `jee_area` VALUES ('796', '414', ',1,7,220,414,796,', '5', '0', '黄陂', '');
INSERT INTO `jee_area` VALUES ('797', '414', ',1,7,220,414,797,', '5', '0', '汉南', '');
INSERT INTO `jee_area` VALUES ('798', '414', ',1,7,220,414,798,', '5', '0', '经济技术开发区', '');
INSERT INTO `jee_area` VALUES ('799', '427', ',1,7,221,427,799,', '5', '0', '市区', '');
INSERT INTO `jee_area` VALUES ('800', '427', ',1,7,221,427,800,', '5', '0', '雨花', '');
INSERT INTO `jee_area` VALUES ('801', '427', ',1,7,221,427,801,', '5', '0', '芙蓉', '');
INSERT INTO `jee_area` VALUES ('802', '427', ',1,7,221,427,802,', '5', '0', '岳麓', '');
INSERT INTO `jee_area` VALUES ('803', '427', ',1,7,221,427,803,', '5', '0', '天心', '');
INSERT INTO `jee_area` VALUES ('804', '427', ',1,7,221,427,804,', '5', '0', '星沙经济技术开发区', '');
INSERT INTO `jee_area` VALUES ('805', '427', ',1,7,221,427,805,', '5', '0', '开福', '');
INSERT INTO `jee_area` VALUES ('806', '427', ',1,7,221,427,806,', '5', '0', '宁乡', '');
INSERT INTO `jee_area` VALUES ('807', '427', ',1,7,221,427,807,', '5', '0', '望城', '');
INSERT INTO `jee_area` VALUES ('808', '428', ',1,7,222,428,808,', '5', '0', '罗湖', '');
INSERT INTO `jee_area` VALUES ('809', '428', ',1,7,222,428,809,', '5', '0', '福田', '');
INSERT INTO `jee_area` VALUES ('810', '428', ',1,7,222,428,810,', '5', '0', '宝安', '');
INSERT INTO `jee_area` VALUES ('811', '428', ',1,7,222,428,811,', '5', '0', '南山', '');
INSERT INTO `jee_area` VALUES ('812', '428', ',1,7,222,428,812,', '5', '0', '龙岗', '');
INSERT INTO `jee_area` VALUES ('813', '428', ',1,7,222,428,813,', '5', '0', '盐田', '');
INSERT INTO `jee_area` VALUES ('814', '428', ',1,7,222,428,814,', '5', '0', '光明新区', '');
INSERT INTO `jee_area` VALUES ('815', '428', ',1,7,222,428,815,', '5', '0', '坪山新区', '');
INSERT INTO `jee_area` VALUES ('816', '220', ',1,7,220,816,', '4', '18', '恩施', 'EnShi');

-- ----------------------------
-- Table structure for `jee_article`
-- ----------------------------
DROP TABLE IF EXISTS `jee_article`;
CREATE TABLE `jee_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `publish_id` int(11) NOT NULL,
  `cid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `pic` varchar(200) DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `link` varchar(255) DEFAULT NULL,
  `source` varchar(100) NOT NULL DEFAULT '本站',
  `source_url` varchar(255) NOT NULL DEFAULT '#',
  `content` text,
  `add_time` int(11) NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COMMENT='文章管理';

-- ----------------------------
-- Records of jee_article
-- ----------------------------
INSERT INTO `jee_article` VALUES ('29', '1', '1', '关于我们', null, '1', null, 'tripec', '', '是一款针对旅游电商行业基于PHP开发的应用平台。 <br />\r\n集成了对线路、酒店、景点等最核心旅游产品的管理，完美实现对旅游产品线上业务的支持。 <br />\r\n让旅游电商更加方便快捷，为旅游产品供应商、旅游服务提供商提供在线解决方案。', '1394158442', '11', '1', '1');
INSERT INTO `jee_article` VALUES ('25', '1', '3', '报名方式有哪些？', '/Upload/images/articles/201403/1394433921.JPG', '1', null, '新浪', '', '<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;text-align:center;\">\r\n	<br />\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	&nbsp; &nbsp; &nbsp; &nbsp; 1月14日，澳大利亚旅游局在香港举办了年度媒体聚会，新上任澳旅局大中华区总经理艾维立(Tony Everitt)先生率领大中华区及香港团队亮相，会上并宣布今年澳大利亚将以「餐厅澳大利亚」概念作为推广主轴。\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	<br />\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<b>澳洲旅游局大中华区总经理艾维立</b><b>(Tony Everitt)</b>表示，香港市场非常活跃。2013年1月至11月，到访澳大利亚的香港旅客数量增长幅度达8%，香港旅客在澳大利亚的花费亦成长达10%，达到8.8亿澳币。澳大利亚2014年的第一个活动选择在香港举行，正是因为看到香港市场的潜力，同时，澳大利亚距离香港非常近，是离最近的西方目的地。\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	<br />\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	&nbsp; &nbsp; &nbsp; &nbsp;这次活动中，艾维立(Tony Everitt)很兴奋的介绍，2014年接下来要推广的「餐厅澳大利亚」概念，也就是视整个澳大利亚是一个餐厅，聚焦于宣传当地人、生产、地方的独特性，打造澳大利亚美食美酒目的地的形象。其中，澳大利亚拥有众多的移民者，因此多元文化与创意美食到处可见。而澳大利亚当地优美的自然环境，好山、好水、好天气，产出丰富新鲜多样的好食材。地方上，澳大利亚提供很多户外餐饮机会，而且有非常多地方的独特自然景观。\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	<br />\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	&nbsp; &nbsp; &nbsp; &nbsp; 未来此概念将由一个全新的全国性推广计划启动，同时，新计划将打造一个平台，让所有的澳大利亚旅游业者、食品业者和酒类业者一同参与，展示自己的故事，新计划还将是「澳大利亚尽是不同」宣传计划中的部分元素。同时，该新概念也将在中国市场推出。艾维立表示，会发展这个新概念，是因为市场调查发现，没有去过澳大利亚的人对于当地美食美酒完全没听说，但是去过澳大利亚的人都非常推荐当地的美酒美食，因此，澳大利亚需要将真实情况被让多人知道。\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	<br />\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	&nbsp; &nbsp; &nbsp; &nbsp; 澳大利亚各地配合新概念，都将加强进行当地美酒美食宣传。<b>西澳大利亚旅游局北亚区国际市场总监倪建华</b>指出，西澳将聚焦于玛格丽特河和天鹅谷两酒区，同时，持续推广每年11月举行的大型玛格丽特河美食节，未来还可能邀请中国厨师和美食专家前往参加，不再以国内市场为重心，改而面向国际市场。另一方面，也将推广尖峰石阵附近的一个龙虾窝棚，旅客可以在现场了解如何抓龙虾，如何分类，并品尝龙虾餐。\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	<br />\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<b>新南威尔士州旅游局北亚区局长董沁仪</b>则表示，当地的特色在于众多的户外、露天、海滨餐饮场所，而且很多悉尼、墨尔本着名的厨师都到当地开餐厅。同时，多元文化刺激下，很多美食都是文化融合的展现。2013年前9个月到访新南威尔士州的香港旅客数量成长了7%。由于观察到市场上旅客停留时间小幅下滑，未来将聚焦于推广单一目的地产品，希望旅客停留在悉尼更久，便有机会前往新南威尔士州游玩，进行深度旅游。另外，也将持续推广当地活动，如3月的Royal Easter Show和5月的Vivid Sydney。\r\n</p>', '1429545774', '5', '1', '1');
INSERT INTO `jee_article` VALUES ('24', '1', '3', '在线咨询可以预定么？', '/Upload/images/articles/201401/1389856548.jpg', '1', null, '来自腾讯微博', '', '<p style=\"font-family:Simsun;font-size:14px;\">\r\n	&nbsp; 占地十多平方公里的乃古石林景区里，怪石林立，突兀峥嵘，姿态各异，石柱壁峰之间，山花香溢，灵禽和鸣，一派生机盎然。奇峰、溶洞、湖泊等喀斯特地貌奇观一样不少。或登高远眺、或攀援而上、或细细品味、或穿梭起伏。徜徉其间，自有别样滋味。\r\n</p>\r\n<p style=\"font-family:Simsun;font-size:14px;\">\r\n	&nbsp;&nbsp;&nbsp; 在当地彝族撒尼人的方言中，“乃古”有古老和黑色的意思。乃古石林，不仅仅是因为它黑色沉默的外表，在崇尚黑色的彝族人心目中，这一片气势恢宏的石头森林还有着更为神秘的气质引人前来“朝圣”。据了解，乃古石林与已经对外开放的大小石林相比，其不同之处在于，大小石林主要由石灰岩形成，乃古石林主要由白云质灰岩形成。而不同的岩石形成的石林地貌在颜色和形态上都有所差异。发育乃古石林的岩石主要为2.7亿年前的白云质灰岩（中二叠统栖霞组）。通常白云质灰岩较纯灰岩抗溶蚀能力强，因而在世界上极少能够形成石林，然而乃古石林却是个例外，发育了完美的剑状喀斯特石林地貌，在世界上实属罕见。其整体呈灰黑色，石柱高大密集，远望似高墙古堡，古朴粗旷、雄伟壮观。\r\n</p>', '1429545786', '1', '1', '1');
INSERT INTO `jee_article` VALUES ('26', '1', '3', '如何预定流程？', '/Upload/images/articles/201403/1394434140.jpg', '1', null, '腾讯', '', '<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	上海半岛酒店与上海汽车博物馆（中国首家专业汽车博物馆）昨(9)日建立战略合作伙伴，未来一年古典汽车爱好者将可在上海半岛酒店内欣赏到珍贵的古董车。\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	<br />\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	&nbsp; &nbsp; &nbsp; &nbsp; 今年全年在上海半岛酒店精品廊将设置固定老爷车展示区，轮流展出上海汽车博物馆中最为经典的老爷车。今年预计展出的古董车包括1951年出产的捷豹XK120汽车、1960年出产的菲亚特500汽车、1941年出产的别克超级系列56-S型汽车以及1931年出产的克赖斯勒Imperial 汽车。\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	<br />\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	&nbsp; &nbsp; &nbsp; 上海半岛酒店对汽车史的贡献颇具传奇色彩，也是上海唯一拥有定制车队的豪华酒店，其车队包括四辆加长定制版劳斯莱斯幻影、六辆半岛宝马7系豪华轿车，以及一辆得到完美修复的1934年古董劳斯莱斯幻影II老爷车以及最新加入阵容的两辆定制版MINI Cooper S Clubman汽车，所有豪华汽车均为半岛酒店标志性的墨绿色。\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	<br />\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	&nbsp; &nbsp; &nbsp; &nbsp;作为一家历史悠久的酒店品牌，半岛酒店注重质量与文化的最佳融合，香港上海大酒店主席米高•嘉道理也是一位热情的老爷车收藏家，与上海和古董车都有着特殊的渊源，也希望藉此让更多宾客了解酒店品牌的文化精髓。\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	<br />\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	&nbsp; &nbsp; &nbsp; &nbsp;另据<b>半岛酒店集团中国区区域传讯总监吕以民</b>介绍，在上海半岛酒店的半岛学堂也为宾客提供游览体验中国汽车城的定制行程。宾客入住酒店前一周即可向酒店预订，乘坐半岛制定宝马7系豪华轿车进行上海汽车博物馆巡礼，享受专属私人导览服务，并安排宾客在贵宾休息室内享用私人午餐。\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	<br />\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	&nbsp; &nbsp; &nbsp; 上海汽车博物馆现收藏展示各类经典古董车80余辆，涉及国内外20余个品牌，藏车历史跨越汽车发展百年。是国内首家专业汽车博物馆。在博物馆内可欣赏到汽车发展百年间呈现的经典车型，还可了解到每一辆古董车背后的历史与精彩的故事。\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	<br />\r\n</p>', '1429545796', '4', '1', '1');
INSERT INTO `jee_article` VALUES ('27', '1', '3', '网上预定有优惠么？', '/Upload/images/articles/201403/1394434041.jpg', '1', null, '新浪', '', '<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	「出境旅游优质服务供应商计划」（简称QSC计划）及《出境游优质服务供应商认定与测评标准》发布会日前于北京举行。《出境游优质服务供应商认定与测评标准》是由国家旅游局发布实施的海外旅游服务质量认证标准，该项认证的实施和深入开展，将为中国游客在境外旅行增添有效保障。\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	<br />\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	&nbsp; &nbsp; &nbsp; &nbsp; 为配合旅游法的实施，提升出境旅游服务质量，国家旅游局发布了《出境游优质服务供应商认定与测评标准》，通过实施「出境旅游优质服务供应商计划」，对境外接待中国游客的供应商进行QSC优质服务认证。这项认证计划为中国游客在境外旅行增添保障，也将帮助中方旅行社构建和优化境外供应商服务体系。QSC按照严格的评价体系，从接待服务能力、诚信经营、能够为中国游客提供中文服务和其他便利服务等各个方面，对境外地接旅行社、酒店、购物商店、旅游景点、餐馆等类型的供应商进行优质服务认证。\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	<br />\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	&nbsp; &nbsp; &nbsp; &nbsp; 据悉，有超过40个国家和地区的约500家购物商店、旅行社、酒店、景点和餐馆等类型的供应商先后提出申请。截止到目前，包括DFS集团全球14家位于市中心的一站式精品商城、泰国最大的免税店King Power位于曼谷和帕堤亚的两家商店及一批旅行社、景点和餐馆等来自20多个国家和地区的121家供应商已通过首批认证。\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	<br />\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<b>中国康辉旅行社集团总裁董如平</b>表示，国家旅游局实施「出境旅游优质服务供应商计划」和发布《出境旅游优质服务供应商认定与测评标准》，也是中方旅行社非常欢迎的和迫切需要的，中方旅行社也会按照此标准的要求，向境外接待中国游客的地接社、酒店、购物商店、餐馆等供应商提出要求。同时，选择获得QSC认证的优质供应商作为的业务合作伙伴，将增强出境旅游产品的可辨识度。\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	<br />\r\n</p>\r\n<p style=\"font-family:Arial, Helvetica, sans-serif;font-size:12px;background-color:#FFFFFF;\">\r\n	&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;<b>新西兰旅游局亚洲区代理总经理</b><b>David Craig</b>说道，新西兰是离中国遥远的小国，旅游局也深刻了解，选择新西兰的中国游客在努力工作、历经长途飞行之后，才到达这个目的地。因此，新西兰非常重视中国游客的体验。他指出，新西兰去年接待约25万中国游客，随着人数不断增长，为游客提供产品保障益加重要，而QSC计划的实施与新西兰旅游局为保障旅游产品质量而推出 “Qualmark”认证的理念是非常一致的。「新西兰旅游局强力支持QSC计划，并已经为新西兰的优质供应商申请参加QSC认证出具保荐函。\r\n</p>', '1429545805', '2', '1', '1');
INSERT INTO `jee_article` VALUES ('28', '1', '2', '独立成团是什么意思？', '/Upload/images/articles/201403/1394441849.jpg', '1', null, '糖罐', '', '多少风徐徐', '1429545816', '3', '1', '1');
INSERT INTO `jee_article` VALUES ('30', '1', '2', '什么是自由行？', '', '1', null, '什么是自由行？', '', '<a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\">什么是自由行？</a>', '1429545828', '0', '1', '1');
INSERT INTO `jee_article` VALUES ('31', '1', '2', '什么是双飞、双卧？', '', '1', null, '什么是双飞、双卧？', '', '<a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\">什么是双飞、双卧？</a>', '1429545841', '0', '1', '1');
INSERT INTO `jee_article` VALUES ('32', '1', '2', '什么是参团？', '', '1', null, '什么是参团？', '', '<a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\">什么是参团？</a>', '1429545849', '0', '1', '1');
INSERT INTO `jee_article` VALUES ('33', '1', '2', '单房差是什么？', '', '1', null, '单房差是什么？', '', '单房差是什么？<br />', '1429545871', '2', '1', '1');
INSERT INTO `jee_article` VALUES ('34', '1', '4', '付款方式有哪些？', '', '1', null, '付款方式有哪些？', '', '<a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\">付款方式有哪些？</a>', '1429545884', '1', '1', '1');
INSERT INTO `jee_article` VALUES ('35', '1', '4', '可以使用支付宝么？', '', '1', null, '可以使用支付宝么？', '', '<a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\">可以使用支付宝么？</a>', '1429545892', '0', '1', '1');
INSERT INTO `jee_article` VALUES ('36', '1', '4', '如何网上支付？', '', '1', null, '如何网上支付？', '', '<a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\">如何网上支付？</a>', '1429545901', '2', '1', '1');
INSERT INTO `jee_article` VALUES ('37', '1', '4', '是否可以提供发票？', '', '1', null, '是否可以提供发票？', '', '<a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\">是否可以提供发票？</a>', '1429545912', '2', '1', '1');
INSERT INTO `jee_article` VALUES ('38', '1', '4', '是否可以使用支票进行支付？', '', '1', null, '是否可以使用支票进行支付？', '', '<a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\">是否可以使用支票进行支付？</a>', '1429545929', '0', '1', '1');
INSERT INTO `jee_article` VALUES ('39', '1', '5', '是正规的旅游合同么？', '', '1', null, '是正规的旅游合同么？', '', '<a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\">是正规的旅游合同么？</a>', '1429545940', '0', '1', '1');
INSERT INTO `jee_article` VALUES ('40', '1', '5', '如何签订旅游合同？', '', '1', null, '如何签订旅游合同？', '', '<a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\">如何签订旅游合同？</a>', '1429545949', '1', '1', '1');
INSERT INTO `jee_article` VALUES ('41', '1', '5', '不签合同可以么？', '', '1', null, '不签合同可以么？', '', '<a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\"><a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\">不签合同可以么？</a></a>', '1429545978', '0', '1', '1');
INSERT INTO `jee_article` VALUES ('42', '1', '5', '能传真签合同么？', '', '1', null, '能传真签合同么？', '', '<a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\">能传真签合同么？</a>', '1429545987', '0', '1', '1');
INSERT INTO `jee_article` VALUES ('43', '1', '6', '投诉处理中心', '', '1', null, '投诉处理中心', '', '<a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\">投诉处理中心</a>', '1429546001', '0', '1', '1');
INSERT INTO `jee_article` VALUES ('44', '1', '6', '注册会员及积分使用', '', '1', null, '注册会员及积分使用', '', '<a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\">注册会员及积分使用</a>', '1429546010', '1', '1', '1');
INSERT INTO `jee_article` VALUES ('45', '1', '6', '出国签证办理问题', '', '1', null, '出国签证办理问题', '', '<a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\">出国签证办理问题</a>', '1429546019', '1', '1', '1');
INSERT INTO `jee_article` VALUES ('46', '1', '6', '旅游保险问题解答', '', '1', null, '旅游保险问题解答', '', '<a href=\"http://www.lvyou.com/travel/travel/type/3/current_city/nanning\">旅游保险问题解答</a>', '1429546027', '0', '1', '1');
INSERT INTO `jee_article` VALUES ('47', '1', '1', '用户协议', null, '1', null, '用户协议', '', '用户协议', '1429547221', '0', '1', '1');
INSERT INTO `jee_article` VALUES ('48', '1', '1', '隐私保护', null, '1', null, '隐私保护', '', '隐私保护', '1429547237', '1', '1', '1');
INSERT INTO `jee_article` VALUES ('49', '1', '1', '免责声明', null, '1', null, '免责声明', '', '免责声', '1429547268', '0', '1', '1');
INSERT INTO `jee_article` VALUES ('50', '1', '1', '签署合同', null, '1', null, '签署合同', '', '签署合同', '1429547280', '0', '1', '1');
INSERT INTO `jee_article` VALUES ('51', '1', '1', '联系我们', null, '1', null, '联系我们', '', '联系我们', '1429547288', '1', '1', '1');
INSERT INTO `jee_article` VALUES ('52', '1', '7', '胡杨林属于哪个省，胡杨林旅游介绍', '', '1', null, '顶顶顶', '', '<a href=\"http://www.lvyou.com/\">胡杨林属于哪个省，胡杨林旅游介绍</a>', '1429922250', '7', '1', '1');
INSERT INTO `jee_article` VALUES ('53', '1', '7', '胡杨林属于哪个省，胡杨林旅游介绍胡杨林属于哪个省，胡杨林旅游介绍胡杨林属于哪个省，胡杨林旅游介绍', '', '1', null, '胡杨林属于哪个省，胡杨林旅游介绍', '', '<a href=\"http://www.lvyou.com/\">胡杨林属于哪个省，胡杨林旅游介绍</a><a href=\"http://www.lvyou.com/\">胡杨林属于哪个省，胡杨林旅游介绍</a><a href=\"http://www.lvyou.com/\">胡杨林属于哪个省，胡杨林旅游介绍</a><a href=\"http://www.lvyou.com/\">胡杨林属于哪个省，胡杨林旅游介绍</a>', '1429922326', '7', '1', '1');

-- ----------------------------
-- Table structure for `jee_article_section`
-- ----------------------------
DROP TABLE IF EXISTS `jee_article_section`;
CREATE TABLE `jee_article_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0',
  `names` varchar(50) NOT NULL,
  `e_names` varchar(50) NOT NULL,
  `memo` varchar(50) DEFAULT NULL,
  `model` smallint(1) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='文章分类管理';

-- ----------------------------
-- Records of jee_article_section
-- ----------------------------
INSERT INTO `jee_article_section` VALUES ('1', '0', '关于我们', 'about', '关于我们', '1', '0', '1');
INSERT INTO `jee_article_section` VALUES ('2', '0', '常见问题', 'help', '帮助中心', '0', '0', '1');
INSERT INTO `jee_article_section` VALUES ('3', '0', '预定和报名指南', 'News', '最新资讯', '0', '0', '1');
INSERT INTO `jee_article_section` VALUES ('4', '0', '付款和发票', 'pay', '付款和发票', '0', '0', '1');
INSERT INTO `jee_article_section` VALUES ('5', '0', '签署旅游合同', 'hetong', 'hetong', '0', '0', '1');
INSERT INTO `jee_article_section` VALUES ('6', '0', '其他事项', 'other', 'other', '0', '0', '1');
INSERT INTO `jee_article_section` VALUES ('7', '0', '旅游知识', 'know', '旅游知识', '0', '0', '1');
INSERT INTO `jee_article_section` VALUES ('8', '7', '青旅快讯', 'qlkx', 'dddd', '0', '0', '1');

-- ----------------------------
-- Table structure for `jee_base_config`
-- ----------------------------
DROP TABLE IF EXISTS `jee_base_config`;
CREATE TABLE `jee_base_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sort` int(11) DEFAULT NULL,
  `config_key` varchar(200) DEFAULT NULL,
  `config_value` varchar(200) DEFAULT NULL,
  `memo` varchar(200) DEFAULT NULL,
  `isdel` int(11) DEFAULT '0' COMMENT '0:允许删除,1：不允许删除',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=gb2312;

-- ----------------------------
-- Records of jee_base_config
-- ----------------------------
INSERT INTO `jee_base_config` VALUES ('1', '1', 'HOTEL_RListCount', '15', '频道页中，酒店推荐列表所列出的最大条数', '0');
INSERT INTO `jee_base_config` VALUES ('2', '1', 'HOTEL_IListCount', '8', '频道页中，酒店点评列表所列出的最大条数', '0');
INSERT INTO `jee_base_config` VALUES ('5', '1', 'Viewpoint_CHListCount', '7', '', '0');
INSERT INTO `jee_base_config` VALUES ('6', '1', 'Viewpoint_CListCount', '7', '', '0');

-- ----------------------------
-- Table structure for `jee_cash_coupon`
-- ----------------------------
DROP TABLE IF EXISTS `jee_cash_coupon`;
CREATE TABLE `jee_cash_coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `serial_num` varchar(32) NOT NULL DEFAULT '' COMMENT '代金券序列号',
  `coupon_value` int(11) NOT NULL DEFAULT '0' COMMENT '代金券额',
  `creator_id` int(11) NOT NULL COMMENT '代金券创建者',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '代金券创建时间',
  `expire_time` int(11) NOT NULL DEFAULT '0' COMMENT '代金券过期时间',
  `use_userid` int(11) DEFAULT NULL COMMENT '使用者',
  `use_time` int(11) DEFAULT NULL COMMENT '代金券使用时间',
  `status` smallint(2) unsigned NOT NULL DEFAULT '0' COMMENT '代金券使用状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `serial_num` (`serial_num`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 COMMENT='代金券表';

-- ----------------------------
-- Records of jee_cash_coupon
-- ----------------------------
INSERT INTO `jee_cash_coupon` VALUES ('1', '10E3A61CC5CF0CF0B5', '10', '9', '1392258706', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('2', '10CF9C8A787DC92F3B', '10', '9', '1392258706', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('3', '10B07DA55187ACD394', '10', '9', '1392258706', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('4', '1012DCA85032F7EE1C', '10', '9', '1392258706', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('5', '10F2AA10A9EC6E7930', '10', '9', '1392258706', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('6', '100D64733C2E77E753', '10', '9', '1392258706', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('7', '105F914577C168356E', '10', '9', '1392258706', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('8', '10C62036A73BDE8DF4', '10', '9', '1392258706', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('9', '10C929F0B3FE11B5D8', '10', '9', '1392258706', '1609344000', '7', '1393559138', '1');
INSERT INTO `jee_cash_coupon` VALUES ('10', '10201AFCBA528122D0', '10', '9', '1392258706', '1609344000', '7', '1393558752', '1');
INSERT INTO `jee_cash_coupon` VALUES ('11', '1073D1F9A3C302FE8F', '10', '9', '1392258706', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('12', '1048E9D00941741FB3', '10', '9', '1392258706', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('13', '106B47B965695B690A', '10', '9', '1392258707', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('14', '103C7A5365ADD496B5', '10', '9', '1392258707', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('15', '10528D5B3569D5D522', '10', '9', '1392258707', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('16', '109BBF9B25D47C5473', '10', '9', '1392258707', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('17', '10234F4F6FEDC04085', '10', '9', '1392258708', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('18', '10089783AD922D4C17', '10', '9', '1392258708', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('19', '1060D3B9B66F0CAE25', '10', '9', '1392258708', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('20', '100A143B6F9162E678', '10', '9', '1392258708', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('21', '10928D6DF596911F3C', '10', '9', '1392258708', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('22', '102D129B3E25BBE5A5', '10', '9', '1392258708', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('23', '10313ED8FCD7EEE9AC', '10', '9', '1392258708', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('24', '10210C502464E2995A', '10', '9', '1392258708', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('25', '10048EBF9D8BDD55CD', '10', '9', '1392258708', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('26', '10DDCC6D55919F6A0B', '10', '9', '1392258708', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('27', '10395702ACDF25DD7F', '10', '9', '1392258708', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('28', '1004757357A70A289A', '10', '9', '1392258709', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('29', '101190EAA742055D6E', '10', '9', '1392258709', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('30', '10C5062E1640847DBD', '10', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('31', '20EF77F9A1024E4455', '20', '9', '1392258710', '1609344000', null, '1393402831', '1');
INSERT INTO `jee_cash_coupon` VALUES ('32', '202886E6F869206FD6', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('33', '20EBB87349BB3D8889', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('34', '205D64EBB9660E7B7B', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('35', '203E8D5E4E86D837EB', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('36', '208B4DD5DDE5D6E0F3', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('37', '201057886974DD6C9E', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('38', '2073ACCCE98825DD27', '20', '9', '1392258710', '1609344000', '9', '1392605288', '1');
INSERT INTO `jee_cash_coupon` VALUES ('39', '20570A42809FE8C07E', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('40', '206FB2E7C29E2F1DF2', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('41', '20D5C5A19C54197E42', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('42', '2052EA6568E26C0520', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('43', '20BF59BCFEA00EC9AA', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('44', '20B25F7F1861807F74', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('45', '2085E154A3C43A578F', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('46', '20E889958B4F4E6E61', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('47', '207AB4EB6C7D9B5B66', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('48', '20B314CEADAAD8CC97', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('49', '209C27E796769D4B17', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('50', '20A2728BAA15A36CA2', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('51', '20AA473A98F52439B4', '20', '9', '1392258710', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('52', '20BE01B6AF014493D4', '20', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('53', '2074D6B1D18C806D82', '20', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('54', '2084A34A6C406A1A21', '20', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('55', '203874DBC176DDFD1C', '20', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('56', '207B2E1BE898FFDD49', '20', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('57', '203D4BBC399618B3BA', '20', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('58', '20AD7D14AB983B5D47', '20', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('59', '202972A9339BEC2FDE', '20', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('60', '202378DEA877DAAC64', '20', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('61', '305A3DD6F092DA7C39', '30', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('62', '30CD51ACDD5D91FE19', '30', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('63', '3004C69E72401746DB', '30', '9', '1392258711', '1609344000', null, '1393486418', '1');
INSERT INTO `jee_cash_coupon` VALUES ('64', '30A9A68F00065A7921', '30', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('65', '30D2B9E04C2594BC9F', '30', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('66', '30E73A9D1D11E0D0CA', '30', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('67', '30B45BD1EC52171F32', '30', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('68', '30244E7F578DABA23D', '30', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('69', '30E1AAC2B57CB5889E', '30', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('70', '303F2C7A3074104253', '30', '9', '1392258711', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('71', '3048F91348401E1AD1', '30', '9', '1392258712', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('72', '306A54B3C2C240F05A', '30', '9', '1392258712', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('73', '30A3295C44F3032269', '30', '9', '1392258712', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('74', '307F3B5D9AC9CC2BEC', '30', '9', '1392258712', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('75', '30659143FD3860C01C', '30', '9', '1392258712', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('76', '30BD1720E608FC521B', '30', '9', '1392258712', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('77', '3067C30ABCC5A7DBE5', '30', '9', '1392258712', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('78', '305B97BE2937D4686C', '30', '9', '1392258712', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('79', '30C0603148E85454AB', '30', '9', '1392258712', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('80', '303739A1E58909BE7B', '30', '9', '1392258712', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('81', '30E366D4614D03638A', '30', '9', '1392258712', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('82', '30714637A1D0A5099E', '30', '9', '1392258712', '1609344000', null, '1393470924', '1');
INSERT INTO `jee_cash_coupon` VALUES ('83', '30E54AA271DE09DDB4', '30', '9', '1392258712', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('84', '3044C9CB51C9D73E87', '30', '9', '1392258712', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('85', '305775FE418A9F378B', '30', '9', '1392258712', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('86', '3015AD0CDB7D41174F', '30', '9', '1392258713', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('87', '30DE1EA24041B1EB77', '30', '9', '1392258713', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('88', '306A55F334F912ABD9', '30', '9', '1392258713', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('89', '30A76B192475BB2366', '30', '9', '1392258713', '1609344000', null, null, '0');
INSERT INTO `jee_cash_coupon` VALUES ('90', '30B02F8072FCCC1BD2', '30', '9', '1392258713', '1609344000', null, null, '0');

-- ----------------------------
-- Table structure for `jee_city_belong`
-- ----------------------------
DROP TABLE IF EXISTS `jee_city_belong`;
CREATE TABLE `jee_city_belong` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `types` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT 'HOTEL,LINE,VIEWPOINT',
  `isdefault` int(11) DEFAULT '0',
  `isshow` smallint(2) NOT NULL DEFAULT '0' COMMENT '是否在频道页显示（1：是 0：否）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_city_belong
-- ----------------------------
INSERT INTO `jee_city_belong` VALUES ('1', '237', '4', 'HOTEL', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('2', '462', '1', 'HOTEL', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('3', '435', '2', 'HOTEL', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('4', '432', '3', 'HOTEL', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('5', '429', '8', 'HOTEL', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('6', '241', '5', 'HOTEL', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('7', '462', '2', 'LINE', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('8', '241', '3', 'LINE', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('9', '285', '1', 'LINE', '1', '0');
INSERT INTO `jee_city_belong` VALUES ('11', '241', '4', 'Viewpoint', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('15', '239', '2', 'Viewpoint', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('16', '243', '3', 'Viewpoint', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('17', '342', '5', 'Viewpoint', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('18', '230', '6', 'HOTEL', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('19', '668', '10', 'HOTEL', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('21', '661', '9', 'HOTEL', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('22', '665', '7', 'HOTEL', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('23', '462', '1', 'Viewpoint', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('24', '460', '6', 'Viewpoint', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('25', '330', '7', 'Viewpoint', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('26', '460', '7', 'LINE', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('27', '453', '2', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('28', '451', '4', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('29', '435', '6', 'LINE', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('30', '250', '22', 'HOTEL', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('31', '429', '8', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('32', '450', '9', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('33', '452', '10', 'HOTEL', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('34', '454', '13', 'HOTEL', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('35', '455', '14', 'HOTEL', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('36', '456', '15', 'HOTEL', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('37', '457', '16', 'HOTEL', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('38', '458', '17', 'HOTEL', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('39', '459', '18', 'HOTEL', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('40', '460', '19', 'HOTEL', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('41', '461', '20', 'HOTEL', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('42', '452', '10', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('43', '461', '11', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('44', '459', '12', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('45', '458', '13', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('46', '457', '14', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('47', '456', '15', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('48', '454', '16', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('49', '235', '17', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('50', '237', '1', 'LINE', '0', '1');
INSERT INTO `jee_city_belong` VALUES ('51', '454', '8', 'Viewpoint', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('52', '662', '9', 'Viewpoint', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('53', '660', '10', 'Viewpoint', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('54', '671', '11', 'Viewpoint', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('55', '672', '12', 'Viewpoint', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('56', '661', '13', 'Viewpoint', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('57', '237', '14', 'Viewpoint', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('58', '71', '111', 'Viewpoint', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('59', '80', '112', 'HOTEL', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('60', '71', '111', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('61', '75', '112', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('62', '77', '113', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('63', '91', '113', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('64', '95', '114', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('65', '73', '115', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('66', '96', '116', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('67', '181', '121', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('68', '26', '113', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('69', '665', '20', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('70', '666', '20', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('71', '664', '20', 'LINE', '0', '0');
INSERT INTO `jee_city_belong` VALUES ('73', '240', '0', 'LINE', '0', '0');

-- ----------------------------
-- Table structure for `jee_comm_impr`
-- ----------------------------
DROP TABLE IF EXISTS `jee_comm_impr`;
CREATE TABLE `jee_comm_impr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `types` varchar(10) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `names` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_comm_impr
-- ----------------------------
INSERT INTO `jee_comm_impr` VALUES ('1', 'HOTEL', '繁华地区', '1');
INSERT INTO `jee_comm_impr` VALUES ('2', 'HOTEL', '优雅时尚', '2');
INSERT INTO `jee_comm_impr` VALUES ('3', 'HOTEL', '蛋不疼', '3');
INSERT INTO `jee_comm_impr` VALUES ('4', 'HOTEL', '舒适', '1');
INSERT INTO `jee_comm_impr` VALUES ('5', 'HOTEL', '蛋疼', '7');
INSERT INTO `jee_comm_impr` VALUES ('6', 'HOTEL', '浪漫', '6');
INSERT INTO `jee_comm_impr` VALUES ('7', 'HOTEL', '很有特色', '2');
INSERT INTO `jee_comm_impr` VALUES ('9', 'HOTEL', '宽敞明亮', '8');
INSERT INTO `jee_comm_impr` VALUES ('10', 'HOTEL', '服务周到', '11');
INSERT INTO `jee_comm_impr` VALUES ('11', 'LINE', '实惠', '1');
INSERT INTO `jee_comm_impr` VALUES ('13', 'LINE', '休闲', '2');
INSERT INTO `jee_comm_impr` VALUES ('14', 'LINE', '舒心', '3');
INSERT INTO `jee_comm_impr` VALUES ('15', 'HOTEL', '奢华高贵', '1');
INSERT INTO `jee_comm_impr` VALUES ('18', 'VIEWPOINT', '试一下~·', '1');
INSERT INTO `jee_comm_impr` VALUES ('30', 'HOTEL', '干净卫生', '17');
INSERT INTO `jee_comm_impr` VALUES ('32', 'VIEWPOINT', '静逸闲适', '6');
INSERT INTO `jee_comm_impr` VALUES ('33', 'VIEWPOINT', '哪里都疼', '7');
INSERT INTO `jee_comm_impr` VALUES ('34', 'LINE', '舒适', '4');
INSERT INTO `jee_comm_impr` VALUES ('35', 'LINE', '开心', '1');
INSERT INTO `jee_comm_impr` VALUES ('36', 'LINE', '好吗', '1');
INSERT INTO `jee_comm_impr` VALUES ('37', 'LINE', '知道', '7');
INSERT INTO `jee_comm_impr` VALUES ('38', 'IMPRESSION', '非常好', '1');
INSERT INTO `jee_comm_impr` VALUES ('39', 'IMPRESSION', '很好', '2');
INSERT INTO `jee_comm_impr` VALUES ('40', 'IMPRESSION', '一般', '3');
INSERT INTO `jee_comm_impr` VALUES ('41', 'IMPRESSION', '差', '4');
INSERT INTO `jee_comm_impr` VALUES ('42', 'IMPRESSION', '非常差', '5');

-- ----------------------------
-- Table structure for `jee_convert_money_list`
-- ----------------------------
DROP TABLE IF EXISTS `jee_convert_money_list`;
CREATE TABLE `jee_convert_money_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `types` varchar(20) NOT NULL,
  `totypes` varchar(20) NOT NULL,
  `addtime` datetime NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_convert_money_list
-- ----------------------------

-- ----------------------------
-- Table structure for `jee_draw_money`
-- ----------------------------
DROP TABLE IF EXISTS `jee_draw_money`;
CREATE TABLE `jee_draw_money` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '提现单ID号',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '提现用户ID号',
  `band_name` varchar(20) NOT NULL COMMENT '银行账户姓名',
  `band_code` varchar(24) NOT NULL COMMENT '银行账号',
  `person_code` varchar(23) DEFAULT NULL COMMENT '身份证号',
  `money` int(8) NOT NULL DEFAULT '0' COMMENT '提款金额',
  `phone_num` varchar(13) DEFAULT NULL COMMENT '手机号码',
  `remarks` varchar(300) NOT NULL COMMENT '备注',
  `bf_draw` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '提款前账户中的金额',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '下单时间',
  `status` smallint(2) NOT NULL DEFAULT '0' COMMENT '提款单状态',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_draw_money
-- ----------------------------
INSERT INTO `jee_draw_money` VALUES ('1', '1', '曾艺', '1234514534157514545', '456456466542454654', '564534', '541564654455', '哈哈哈哈哈', '6845468.00', '1381911716', '0');
INSERT INTO `jee_draw_money` VALUES ('2', '1', '曾艺', '454654564654654545645', '4546456451546455645', '69782', '56761486642', '防守打法的', '6845468.00', '1381913161', '0');
INSERT INTO `jee_draw_money` VALUES ('3', '1', '曾艺', '1684216545375312352', '454645645546455645', '71203', '56761486642', 'dfsd', '6845468.00', '1381914837', '1');
INSERT INTO `jee_draw_money` VALUES ('4', '1', '曾艺', '1234514534157514545', '', '54245', '', 'fdsf', '6845468.00', '1381915539', '0');
INSERT INTO `jee_draw_money` VALUES ('5', '1', '曾艺', '1234514534157514545', '454645645546455645', '54245', '13554987514', '随碟附送发送到', '6845468.00', '1381915616', '1');
INSERT INTO `jee_draw_money` VALUES ('6', '1', '曾艺', '1684216545375312352', '456456466542454654', '750', '13554987514', '试一下', '6845468.00', '1381975678', '0');
INSERT INTO `jee_draw_money` VALUES ('7', '1', 'Mio', '6222022102003799253', '450103199106040019', '6200', '13878103554', '真实信息喔~~！', '6845468.00', '1381979174', '0');
INSERT INTO `jee_draw_money` VALUES ('8', '1', '5fd45', '6222022102003799253', '454645645546455645', '2450', '13554987514', 'sadf', '6838118.00', '1381980331', '0');
INSERT INTO `jee_draw_money` VALUES ('9', '1', '曾艺', '6222022102003799253', '456456466542454654', '8000', '56761486642', 'ddsf', '6830118.00', '1381980417', '0');
INSERT INTO `jee_draw_money` VALUES ('10', '7', 'metrix', '6222022102003799253', '456456466542454654', '100', '56761486642', '随碟附送发送到', '620.00', '1390285975', '0');
INSERT INTO `jee_draw_money` VALUES ('11', '7', 'metrix', '6222022102003799253', '456456466542454654', '100', '56761486642', '随碟附送发送到', '620.00', '1390286111', '0');
INSERT INTO `jee_draw_money` VALUES ('12', '7', 'metrix', '6222022102003799253', '456456466542454654', '100', '56761486642', '随碟附送发送到', '0.00', '1391581033', '0');
INSERT INTO `jee_draw_money` VALUES ('13', '7', 'metrix', '6222022102003799253', '456456466542454654', '100', '56761486642', '随碟附送发送到', '0.00', '1391581038', '0');
INSERT INTO `jee_draw_money` VALUES ('14', '7', 'test_acount', '653432423423423', '45234234234324324', '100', '18944545324', 'dfdsfsdfdfsdfdsf', '6450.00', '1392169504', '0');
INSERT INTO `jee_draw_money` VALUES ('15', '7', '', '', '', '0', '', '', '6450.00', '1392193939', '0');
INSERT INTO `jee_draw_money` VALUES ('16', '7', 'admin', '', '', '10', '', '', '6440.00', '1392193975', '0');

-- ----------------------------
-- Table structure for `jee_education_background`
-- ----------------------------
DROP TABLE IF EXISTS `jee_education_background`;
CREATE TABLE `jee_education_background` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `education` varchar(64) DEFAULT NULL COMMENT '教育背景',
  `status` int(11) DEFAULT '1' COMMENT '记录状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_education_background
-- ----------------------------
INSERT INTO `jee_education_background` VALUES ('4', '高中', null);
INSERT INTO `jee_education_background` VALUES ('5', '职业中专', null);
INSERT INTO `jee_education_background` VALUES ('6', '专科', null);
INSERT INTO `jee_education_background` VALUES ('7', '本科', null);
INSERT INTO `jee_education_background` VALUES ('8', '硕士', null);
INSERT INTO `jee_education_background` VALUES ('9', '博士', null);
INSERT INTO `jee_education_background` VALUES ('10', '博士后', null);

-- ----------------------------
-- Table structure for `jee_email`
-- ----------------------------
DROP TABLE IF EXISTS `jee_email`;
CREATE TABLE `jee_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `send_id` int(11) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `receive` text NOT NULL,
  `send_time` int(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `att_id` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='短信发送记录';

-- ----------------------------
-- Records of jee_email
-- ----------------------------

-- ----------------------------
-- Table structure for `jee_email_log`
-- ----------------------------
DROP TABLE IF EXISTS `jee_email_log`;
CREATE TABLE `jee_email_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_id` int(11) DEFAULT NULL,
  `send_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` text,
  `create_time` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `att_id` varchar(255) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `code` varchar(6) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=796 DEFAULT CHARSET=utf8 COMMENT='短信发送记录';

-- ----------------------------
-- Records of jee_email_log
-- ----------------------------
INSERT INTO `jee_email_log` VALUES ('727', '0', null, null, '20674657@qq.com', '1377225321', '微金担保用户激活', '<p  style=\'font-size: 20px; font-weight: bold; font-family: 黑体;\'>亲爱的<a style=\'color: #609FFF; font-weight: bold;\'></a>,<p>\r\n                                                   <p>您距离成功注册微金担保平台只差一步了。<p>\r\n                                                   <p>完成注册，即能享受微金担保平台为您提供的丰富的投资理财信息！<p>\r\n                                                   <p><a href=\'#\'>点这里完成邮箱注册</a><p>\r\n                                                   <p>如果点击无效,请复制下方网页地址到浏览器地址栏中打开:<p>\r\n                                                   <p>为什么我会收到这封邮件?<p>\r\n                                                   <p>您在注册微金担保平台时,填写了此电子邮箱作为账户名,我们发送这封邮件,以确认您是邮箱的主人。<p>\r\n                                                   <p>如果你没有注册微金担保平台,请忽略此邮件。可能是有人在注册时填错了自己的邮箱。<p>\r\n                                                   <p>（请注意，该电子邮件地址不接受回复邮件，要解决问题或了解您的帐户详情，请访问<a href=\'#\'>担保帮助</a>）<p>', '', 'user_active', '0', 'd41d8cd98f00b204e9800998ecf8427e', '1');
INSERT INTO `jee_email_log` VALUES ('728', '0', '0', '0', '286499262@qq.com', '1381909725', 'TripEC用户激活', '点击激活 http://127.0.0.1/tripec/index.php/register/user_active_byemail/code/ukV7xN/username/admin', '', 'user_active', 'ukV7xN', 'de32a6d0545a65e323e391af7cf2cb46', '1');
INSERT INTO `jee_email_log` VALUES ('729', '0', '0', '0', 'jeeliu@vip.qq.com', '1389173332', 'TripEC用户激活', '点击激活 http://demo_v1.tripec.cn/index.php/register/user_active_byemail/code/HAjBRP/username/jeeliu', '', 'user_active', 'HAjBRP', '4a750f12b35dca499cad645f8fd9cd55', '1');
INSERT INTO `jee_email_log` VALUES ('730', '0', '0', '0', 'maruiming2010@qq.com', '1391658713', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/AQaPES/username/dama_test_1', '', 'user_active', 'AQaPES', '8e5f19854f4fb44883c034e19949a522', '1');
INSERT INTO `jee_email_log` VALUES ('731', '0', '0', '0', 'maruiming2010@qq.com', '1391659555', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/nYcrw2/username/dama_test_2', '', 'user_active', 'nYcrw2', '6614253244584162053bc8c1d3f7766c', '1');
INSERT INTO `jee_email_log` VALUES ('732', '0', '0', '0', 'maruiming2010@qq.com', '1391659669', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/eUJnkS/username/dama_test_2', '', 'user_active', 'eUJnkS', '50fbe923231502f62ab42c71450af143', '1');
INSERT INTO `jee_email_log` VALUES ('733', '0', '0', '0', 'maruiming2010@qq.com', '1391659726', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/WXZEsQ/username/dama_test_2', '', 'user_active', 'WXZEsQ', '782ddda9c11088c5fd275e96fc87460e', '1');
INSERT INTO `jee_email_log` VALUES ('734', '0', '0', '0', 'maruiming2010@qq.com', '1391659781', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/BR9uA2/username/dama_test_2', '', 'user_active', 'BR9uA2', '0a2ace9f495886407940e0cc2f503d1c', '1');
INSERT INTO `jee_email_log` VALUES ('735', '0', '0', '0', 'maruiming2010@qq.com', '1391659810', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/C6Z9sk/username/dama_test_2', '', 'user_active', 'C6Z9sk', 'b01bfd7aeace8da594de442dba095898', '1');
INSERT INTO `jee_email_log` VALUES ('736', '0', '0', '0', 'maruiming2010@qq.com', '1391659831', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/2HzEYn/username/dama_test_2', '', 'user_active', '2HzEYn', 'a29f3c94902a76dd7340d71a667952e5', '1');
INSERT INTO `jee_email_log` VALUES ('737', '0', '0', '0', 'maruiming2010@qq.com', '1391659849', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/ZrhISH/username/dama_test_2', '', 'user_active', 'ZrhISH', '8fa3b9b358c13c379f3e991718fa3d46', '1');
INSERT INTO `jee_email_log` VALUES ('738', '0', '0', '0', 'maruiming2010@qq.com', '1391659881', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/CzmJkx/username/dama_test_2', '', 'user_active', 'CzmJkx', '0909f550f312564d208a44af14561fbc', '1');
INSERT INTO `jee_email_log` VALUES ('739', '0', '0', '0', 'maruiming2010@qq.com', '1391659914', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/FbrXyi/username/dama_test_2', '', 'user_active', 'FbrXyi', '1f419efa21e148bd42720ccf04cba6ce', '1');
INSERT INTO `jee_email_log` VALUES ('740', '0', '0', '0', 'maruiming2010@qq.com', '1391659955', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/ch4kDF/username/dama_test_2', '', 'user_active', 'ch4kDF', 'c46e8f743b796a721132bcd1cae92716', '1');
INSERT INTO `jee_email_log` VALUES ('741', '0', '0', '0', 'maruiming2010@qq.com', '1391659976', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/zF6ajH/username/dama_test_2', '', 'user_active', 'zF6ajH', '9fb61b66af9cb10ff9109c46e541fa56', '1');
INSERT INTO `jee_email_log` VALUES ('742', '0', '0', '0', 'maruiming2010@qq.com', '1391660014', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/YWH8ta/username/dama_test_2', '', 'user_active', 'YWH8ta', '13c078adc33f4bea1b0520745683eff4', '1');
INSERT INTO `jee_email_log` VALUES ('743', '0', '0', '0', 'maruiming2010@qq.com', '1391660044', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/SzRP5v/username/dama_test_2', '', 'user_active', 'SzRP5v', '119fee87f0c12cd7a97969bb407a5afc', '1');
INSERT INTO `jee_email_log` VALUES ('744', '0', '0', '0', 'maruiming2010@qq.com', '1391660071', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/VFKZy3/username/dama_test_2', '', 'user_active', 'VFKZy3', '09add01fa2ae605fcff9921415de0dd4', '1');
INSERT INTO `jee_email_log` VALUES ('745', '0', '0', '0', 'maruiming2010@qq.com', '1391660094', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/jNVZAp/username/dama_test_2', '', 'user_active', 'jNVZAp', 'e6870b2d72569d14a6626265662fc303', '1');
INSERT INTO `jee_email_log` VALUES ('746', '0', '0', '0', 'maruiming2010@qq.com', '1391660307', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/hQvJtV/username/dama_test_2', '', 'user_active', 'hQvJtV', 'a71d6b76b8ee3686a46b3b45ac301e66', '1');
INSERT INTO `jee_email_log` VALUES ('747', '0', '0', '0', 'maruiming2010@qq.com', '1391667250', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/NGfvgZ/username/dama_test_2', '', 'user_active', 'NGfvgZ', '4a02299a5cfca5b962aa989062468b23', '1');
INSERT INTO `jee_email_log` VALUES ('748', '0', '0', '0', 'maruiming2010@qq.com', '1391667404', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/TgwakY/username/dama_test_2', '', 'user_active', 'TgwakY', 'ff75698fd698d66dd9426a4aac85adf7', '1');
INSERT INTO `jee_email_log` VALUES ('749', '0', '0', '0', 'maruiming2010@qq.com', '1391667430', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/UIn4ei/username/dama_test_2', '', 'user_active', 'UIn4ei', '949a4a229935d8b12bad2247c9a93213', '1');
INSERT INTO `jee_email_log` VALUES ('750', '0', '0', '0', 'maruiming2010@qq.com', '1391667484', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/g8YAdH/username/dama_test_2', '', 'user_active', 'g8YAdH', '13743a4796bd2c8d58d56f001292da5e', '1');
INSERT INTO `jee_email_log` VALUES ('751', '0', '0', '0', 'maruiming2010@qq.com', '1391667520', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/6Fs9BY/username/dama_test_2', '', 'user_active', '6Fs9BY', '4d3a55000fc7b07560ce3c7fe40d5286', '1');
INSERT INTO `jee_email_log` VALUES ('752', '0', '0', '0', 'maruiming2010@qq.com', '1391667552', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/BCVefQ/username/dama_test_2', '', 'user_active', 'BCVefQ', 'c1bfeb9aeadeab910dd95646ec4d6c01', '1');
INSERT INTO `jee_email_log` VALUES ('753', '0', '0', '0', 'maruiming2010@qq.com', '1391667572', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/xWJQe7/username/dama_test_2', '', 'user_active', 'xWJQe7', 'f592e8cd233174fdfebe2d7467a8b305', '1');
INSERT INTO `jee_email_log` VALUES ('754', '0', '0', '0', 'maruiming2010@qq.com', '1391667586', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/4uBdje/username/dama_test_2', '', 'user_active', '4uBdje', 'ba44fcbcc2cc677774e9133f88ac6cba', '1');
INSERT INTO `jee_email_log` VALUES ('755', '0', '0', '0', 'maruiming2010@qq.com', '1391667614', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/Snr268/username/dama_test_2', '', 'user_active', 'Snr268', 'df88ebe2021617a79132833d79e65430', '1');
INSERT INTO `jee_email_log` VALUES ('756', '0', '0', '0', 'maruiming2010@qq.com', '1391667657', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/crVZTd/username/dama_test_2', '', 'user_active', 'crVZTd', '1dff1257e27a0296302e742987522295', '1');
INSERT INTO `jee_email_log` VALUES ('757', '0', '0', '0', 'maruiming2010@qq.com', '1391667676', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/rx4eZv/username/dama_test_2', '', 'user_active', 'rx4eZv', 'bcfd26ac2a12283f13cd346881ee5166', '1');
INSERT INTO `jee_email_log` VALUES ('758', '0', '0', '0', 'maruuiming2010@qq.com', '1391674044', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/HIv87G/username/dama_test_3', '', 'user_active', 'HIv87G', '39ec299160726e7d3e7a77a63bf16ba2', '0');
INSERT INTO `jee_email_log` VALUES ('759', '0', '0', '0', 'maruiming2010@qq.com', '1391674128', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/vgKCqZ/username/dama_test_3', '', 'user_active', 'vgKCqZ', '69de8031c08ea77a52ac1e8f6bcfacfc', '0');
INSERT INTO `jee_email_log` VALUES ('760', '0', '0', '7', '286136168@qq.com', '1391678735', 'TripEC找回密码', '您已经选择通过邮箱修改了您的密码，新的密码是：如果此操作并非处于您本人的意愿，请及时与本站工作人员联系，谢谢！', '', 'retrieve_password', 'xURz9F', '8d4db9fd5930a321be960c5ced4f9b0e', '1');
INSERT INTO `jee_email_log` VALUES ('761', '0', '0', '7', '286136168@qq.com', '1391678978', 'TripEC找回密码', '您已经选择通过邮箱修改了您的密码，新的密码是：如果此操作并非处于您本人的意愿，请及时与本站工作人员联系，谢谢！', '', 'retrieve_password', 'PDsI2M', '620adfee2cf8e90361058f1651443a8d', '0');
INSERT INTO `jee_email_log` VALUES ('762', '0', '0', '7', 'maruiming2010@qq.com', '1391679174', 'TripEC找回密码', '您已经选择通过邮箱修改了您的密码，新的密码是：如果此操作并非处于您本人的意愿，请及时与本站工作人员联系，谢谢！', '', 'retrieve_password', 'QGxmHu', '6d033ac91459d2a9ac5c0211f7d6fb7a', '1');
INSERT INTO `jee_email_log` VALUES ('763', '0', '0', '7', 'maruiming2010@qq.com', '1391679574', 'TripEC找回密码', '您已经选择通过邮箱修改了您的密码，新的密码是：fc46iwyy。请妥善保管好您的新密码。如果此操作并非处于您本人的意愿，请及时与本站工作人员联系，谢谢！', '', 'retrieve_password', 'phWJa6', 'fe14770880a8de9fc330663a8294c40b', '1');
INSERT INTO `jee_email_log` VALUES ('764', '0', '0', '7', 'maruiming2010@qq.com', '1391680058', 'TripEC找回密码', '您已经选择通过邮箱修改了您的密码，新的密码是：1llgCxJS。请妥善保管好您的新密码。如果此操作并非处于您本人的意愿，请及时与本站工作人员联系，谢谢！', '', 'retrieve_password', 'NpnM2x', '6c8b8e56324ac51a1b739612e1161e75', '1');
INSERT INTO `jee_email_log` VALUES ('765', '0', '0', '7', 'maruiming2010@qq.com', '1391680528', 'TripEC找回密码', '您已经选择通过邮箱修改了您的密码，新的密码是：nAHuib5F。请妥善保管好您的新密码。如果此操作并非处于您本人的意愿，请及时与本站工作人员联系，谢谢！', '', 'retrieve_password', 'qcPBHZ', '6c7c15433c060058ba7e8969e80cd3bf', '0');
INSERT INTO `jee_email_log` VALUES ('766', '0', '0', '0', '286499262@qq.com', '1392168590', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/aSNB56/username/mio', '', 'user_active', 'aSNB56', '7dd31bcb375066b200c8319d5ea0651f', '1');
INSERT INTO `jee_email_log` VALUES ('767', '0', '0', '0', '286499262@qq.com', '1392169443', 'TripEC用户激活', '点击激活 http://localhost/tripec/index.php/register/user_active_byemail/code/edAfTw/username/tangguan', '', 'user_active', 'edAfTw', '899510c43faacf672461a64fb07efad0', '1');
INSERT INTO `jee_email_log` VALUES ('768', '0', '0', '0', 'jeeliu@vip.qq.com', '1393164108', 'TripEC用户激活', '点击激活 http://demo_v1.tripec.cn/index.php/register/user_active_byemail/code/rMiqf3/username/jeeliu', '', 'user_active', 'rMiqf3', '856c82f9cdfc4ffdde53a2621c5721c8', '1');
INSERT INTO `jee_email_log` VALUES ('769', '0', '0', '0', 'jeeliu@vip.qq.com', '1393487284', 'TripEC用户激活', '点击激活 http://demo_v1.tripec.cn/index.php/register/user_active_byemail/code/GFsNtB/username/jeeliu', '', 'user_active', 'GFsNtB', 'aed751f4d2a0723a2e3abe98f7bd1160', '1');
INSERT INTO `jee_email_log` VALUES ('770', '0', '0', '0', '286136168@qq.com', '1393489169', 'TripEC用户激活', '点击激活 http://demo_v1.tripec.cn/index.php/register/user_active_byemail/code/ZGC93J/username/admin123', '', 'user_active', 'ZGC93J', '2263ffed1014f0a8bf1986d1c3c7f120', '1');
INSERT INTO `jee_email_log` VALUES ('771', '0', '0', '0', '286136168@qq.com', '1393492121', 'TripEC用户激活', '点击激活 http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/RWi4Fh/username/admin1234', '', 'user_active', 'RWi4Fh', 'db3c5e66add18f412ca3e1e368795c5f', '1');
INSERT INTO `jee_email_log` VALUES ('772', '0', '0', '0', '286136168@qq.com', '1393492380', 'TripEC用户激活', '点击激活 http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/ijdhyb/username/admin123', '', 'user_active', 'ijdhyb', '074d0966216e231ce2968ed71c2e9615', '1');
INSERT INTO `jee_email_log` VALUES ('773', '0', '0', '0', '286136168@qq.com', '1393492593', 'TripEC用户激活', '点击激活 http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/BPYad6/username/admin123', '', 'user_active', 'BPYad6', '45f7755df6f736bc040afa2efd9c59c8', '1');
INSERT INTO `jee_email_log` VALUES ('774', '0', '0', '0', 'jeeliu@vip.qq.com', '1393493184', 'TripEC用户激活', '点击激活 http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/RZzPyN/username/jeeliu', '', 'user_active', 'RZzPyN', '688af16fc15f52adf8bb99dbbeb9e835', '1');
INSERT INTO `jee_email_log` VALUES ('775', '0', '0', '0', '286136168@qq.com', '1393556216', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/Public/images/logo.jpg?nXxM\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的286136168@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/nbBRgG/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/nbBRgG/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'nbBRgG', '284e8d28553f0b5d2b80fd66f91dbc5e', '1');
INSERT INTO `jee_email_log` VALUES ('776', '0', '0', '0', '286136168@qq.com', '1393556993', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的286136168@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/Ja27QH/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/Ja27QH/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'Ja27QH', 'cd49378bf5a3d5c994d1161536352ff1', '1');
INSERT INTO `jee_email_log` VALUES ('777', '0', '0', '0', '286136168@qq.com', '1393557927', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的286136168@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/HuMrDN/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/HuMrDN/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'HuMrDN', '45c5c93335cee6c256283be30d1f5b3c', '1');
INSERT INTO `jee_email_log` VALUES ('778', '0', '0', '0', '286136168@qq.com', '1393557994', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的286136168@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/uWKAGQ/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/uWKAGQ/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'uWKAGQ', '9ba41b9006b894e01cfa4c347ad746dd', '1');
INSERT INTO `jee_email_log` VALUES ('779', '0', '0', '0', '286136168@qq.com', '1393558684', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的286136168@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/tYm93b/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/tYm93b/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'tYm93b', 'e8a5a2a6082a16c01fe663f204246151', '1');
INSERT INTO `jee_email_log` VALUES ('780', '0', '0', '0', '286136168@qq.com', '1393560260', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的286136168@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/ZjkKMg/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/ZjkKMg/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'ZjkKMg', 'd541206e308463012f97b6ed44abf264', '1');
INSERT INTO `jee_email_log` VALUES ('781', '0', '0', '0', '286136168@qq.com', '1393561263', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的286136168@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/izVYek/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/izVYek/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'izVYek', '91490847dba48435ea16b1d085665c5c', '1');
INSERT INTO `jee_email_log` VALUES ('782', '0', '0', '0', '286136168@qq.com', '1393561429', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的286136168@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/VjrmsJ/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/VjrmsJ/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'VjrmsJ', '27f666654859e5c66fd3bc7a757fc844', '1');
INSERT INTO `jee_email_log` VALUES ('783', '0', '0', '0', '286136168@qq.com', '1393564542', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的286136168@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/JUrm7p/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/JUrm7p/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'JUrm7p', '93af6dc7a088e012cc19858f497489cb', '1');
INSERT INTO `jee_email_log` VALUES ('784', '0', '0', '0', '286136168@qq.com', '1393565085', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的286136168@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/pKznhX/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/pKznhX/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'pKznhX', '234acf006969df8664b90eb562cebe6b', '1');
INSERT INTO `jee_email_log` VALUES ('785', '0', '0', '0', '286136168@qq.com', '1393565173', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的286136168@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/Mtx8Nf/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/Mtx8Nf/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'Mtx8Nf', '3766ca0d457fae97b7a0c9f6127ada7b', '1');
INSERT INTO `jee_email_log` VALUES ('786', '0', '0', '0', '286136168@qq.com', '1393565229', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的286136168@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/mA9YCM/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/mA9YCM/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'mA9YCM', '283c33b72fa391c067d043187aa26be0', '1');
INSERT INTO `jee_email_log` VALUES ('787', '0', '0', '0', '286136168@qq.com', '1393565775', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的286136168@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/P2NqzF/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/P2NqzF/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'P2NqzF', '509ed41b2669697ab4933db3fbee3184', '1');
INSERT INTO `jee_email_log` VALUES ('788', '0', '0', '0', '286136168@qq.com', '1393566122', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的286136168@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/GSYk6e/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/GSYk6e/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'GSYk6e', 'aed4e29de5fbef28e2cf63b62edc6382', '1');
INSERT INTO `jee_email_log` VALUES ('789', '0', '0', '0', '286136168@qq.com', '1393566653', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的286136168@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/Asn5Tr/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/Asn5Tr/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'Asn5Tr', '4005798289af1a2fa01a10a52fb031a5', '1');
INSERT INTO `jee_email_log` VALUES ('790', '0', '0', '0', '286136168@qq.com', '1393566697', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的286136168@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/c8iYkT/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/c8iYkT/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'c8iYkT', '8e0bcf102a4cbb540db9e29e58c89070', '1');
INSERT INTO `jee_email_log` VALUES ('791', '0', '0', '0', '286136168@qq.com', '1393566980', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/QyGuHV/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/QyGuHV/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'QyGuHV', '019d94c89b999874f42a05051853e1ac', '1');
INSERT INTO `jee_email_log` VALUES ('792', '0', '0', '0', '286136168@qq.com', '1393567273', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/mQ4fxq/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/mQ4fxq/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'mQ4fxq', '596bf5b6f6bfaf18ef536f3c9a7eb521', '1');
INSERT INTO `jee_email_log` VALUES ('793', '0', '0', '0', '286136168@qq.com', '1393567308', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/Kv8ncF/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/Kv8ncF/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'Kv8ncF', '4aa1135bac5e69abf6c759038c3d8245', '1');
INSERT INTO `jee_email_log` VALUES ('794', '0', '0', '0', '286136168@qq.com', '1393568510', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/uyx4gi/username/admin123\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/uyx4gi/username/admin123</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'uyx4gi', 'ee00228d198c98f205bb124816f3b188', '0');
INSERT INTO `jee_email_log` VALUES ('795', '0', '0', '0', '20674657@qq.com', '1394589085', 'TripEC用户激活', '<blockquote style=\"margin-top: 0px; margin-bottom: 0px; margin-left: 0.5em;\">\r\n    <div>&nbsp;</div>\r\n    <div>\r\n        <div class=\"FoxDiv20140228095023530167\" id=\"FMOriginalContent\"><title>tripec</title>\r\n            <table width=\"700\" border=\"0\" align=\"center\" cellspacing=\"0\" style=\"width:700px;\">\r\n                <tbody>\r\n                <tr>\r\n                    <td>\r\n                        <div style=\"background-color:#f5f5f5;margin:0 auto;width:700px;\">\r\n                            <div style=\"padding:22px 40px 10px;\">\r\n                                <a target=\"_blank\" href=\"http://demo-v1.tripec.cn\">\r\n                                    <img src=\"http://demo-v1.tripec.cn/web/Tpl/green2/Public/images/logo.jpg\" width=\"223\" height=\"41\" border=\"0\" alt=\"tripec\">\r\n                                </a>\r\n                            </div>\r\n                            <div style=\"background-color:#fff;margin:0 15px;padding:30px 25px;\">\r\n                                <p style=\"font-size:14px;margin:0 0 15px 0;font-weight:bold;\">\r\n                                    亲爱的20674657@qq.com，\r\n                                </p>\r\n                                <p style=\"font-size:14px;margin:15px 0 20px 0;font-weight:bold;\">\r\n                                    您距离成功注册tripec只差一步了。\r\n                                    <span style=\"color:#ff6600;\">完成注册，即能领取新人体验金！</span>\r\n                                </p>\r\n                                <div>\r\n                                    <a href=\"http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/at4Mjr/username/tczfyz\" style=\"padding:6px 20px;font-size:14px;background:#f09512;border-radius:2px;color:#fff;text-decoration:none;font-weight: bold;\">\r\n                                        继续注册\r\n                                    </a>\r\n                                </div>\r\n                                <p style=\"margin:30px 0 3px 0;font-size:12px;\">如果点击无效，请复制下方网页地址到浏览器地址栏中打开：</p>\r\n\r\n                                <p style=\"color:#808080;margin:3px 0 0 0;font-size:12px;\">http://demo-v1.tripec.cn/index.php/register/user_active_byemail/code/at4Mjr/username/tczfyz</p>\r\n                            </div>\r\n                            <div style=\"padding:20px 40px;\">\r\n                                <p style=\"color:#666;font-weight:bold;margin:0 0 10px 0;font-size:12px;\">\r\n                                    为什么我会收到这封邮件？\r\n                                </p>\r\n                                <p style=\"color:#666;margin:0 0 3px 0;font-size:12px;\">\r\n                                    您在注册tripec时，填写了此电子邮箱作为账户名，我们发送这封邮件，以确认您的确是邮箱的主人。\r\n                                </p>\r\n                                <p style=\"color:#666;margin:3px 0 0 0;font-size:12px;\">\r\n                                    如果您没有注册tripec，请忽略此邮件。可能是有人在注册时填错了自己的邮箱。\r\n                                </p>\r\n                            </div>\r\n                            <div style=\"padding:33px 0 20px 40px;margin:0;color:#999;\">\r\n                                <p style=\"margin:0;font-size:12px;\">\r\n                                    此为系统邮件，请勿回复&nbsp;&nbsp;Copyright&nbsp;tripec&nbsp;2004-2014&nbsp;All&nbsp;Right&nbsp;Reserved\r\n                                </p>\r\n                            </div>\r\n                        </div>\r\n                    </td>\r\n                </tr>\r\n                </tbody>\r\n            </table>\r\n        </div>\r\n    </div>\r\n</blockquote>', '', 'user_active', 'at4Mjr', '9ffcc32388a0e1d3c795217711216a0c', '1');

-- ----------------------------
-- Table structure for `jee_file_manager`
-- ----------------------------
DROP TABLE IF EXISTS `jee_file_manager`;
CREATE TABLE `jee_file_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(100) NOT NULL,
  `suffix` varchar(50) NOT NULL,
  `mime` varchar(30) NOT NULL,
  `path` varchar(255) NOT NULL,
  `size` int(11) DEFAULT NULL,
  `sort` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=650 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_file_manager
-- ----------------------------
INSERT INTO `jee_file_manager` VALUES ('456', '1392889431.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394182113.jpg', '45272', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('457', '1392889448.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394182124.jpg', '53979', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('458', '1388988022.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394182139.jpg', '48079', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('459', '1389772503.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394182156.jpg', '97904', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('460', '1388990200.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394182165.jpg', '81008', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('461', '1388990228.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394182208.jpg', '78251', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('462', '1388994561.jpeg', 'jpeg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394182225.jpeg', '111691', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('463', '1388995779.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394182628.jpg', '63944', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('464', '1388991547.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394182803.jpg', '33493', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('465', 'b_1388990170.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394182840.jpg', '45259', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('466', '1388991400.png', 'png', 'application/octet-stream', '/Upload/images/line_pic/201403/1394182850.png', '192601', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('467', '1388995721.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394182917.jpg', '223699', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('468', '1388988068.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394182967.jpg', '83767', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('469', '1388994465.jpeg', 'jpeg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394182977.jpeg', '63526', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('470', '1388995748.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183017.jpg', '28775', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('471', '1388996478.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183036.jpg', '70206', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('472', '1388998934.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183046.jpg', '126614', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('473', '1388997323.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183060.jpg', '99524', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('474', '1388991478.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183087.jpg', '82014', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('475', '1388991415.jpeg', 'jpeg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183099.jpeg', '11123', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('476', '1388995748.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183127.jpg', '28775', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('477', '1388991514.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183459.jpg', '105783', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('478', '1388995779.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183472.jpg', '63944', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('479', '1388998934.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183525.jpg', '126614', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('480', '1388994483.jpeg', 'jpeg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183551.jpeg', '69154', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('481', '1388987967.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183563.jpg', '66751', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('482', '1388987985.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183571.jpg', '78294', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('483', '1388991514.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183626.jpg', '105783', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('484', '1388988038.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183655.jpg', '80153', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('485', '1388988038.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183684.jpg', '80153', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('486', '1388994405.jpeg', 'jpeg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183745.jpeg', '51619', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('487', '1388991381.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183759.jpg', '123943', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('488', '1388997293.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183772.jpg', '91148', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('489', '1388987985.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183788.jpg', '78294', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('490', '1388990245.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183803.jpg', '104432', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('491', '20090715100310-1451282176.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394183999.jpg', '5547', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('492', '1388994434.jpeg', 'jpeg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184032.jpeg', '55202', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('493', '1388994391.jpeg', 'jpeg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184041.jpeg', '77341', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('494', '1389772900.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184079.jpg', '114004', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('495', '1388998923.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184090.jpg', '79905', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('496', '1389773626.JPG', 'JPG', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184105.JPG', '37080', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('497', '1388991381.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184118.jpg', '123943', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('498', '1388990200.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184127.jpg', '81008', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('499', '1388991381.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184153.jpg', '123943', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('500', '1388994497.jpeg', 'jpeg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184170.jpeg', '69154', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('501', '1388998923.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184198.jpg', '79905', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('502', '1388997279.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184208.jpg', '99349', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('503', '1388996521.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184216.jpg', '35642', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('504', '1386656657.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184242.jpg', '27766', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('505', '1386561833.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184254.jpg', '88427', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('506', 'b_1389773412.JPG', 'JPG', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184340.JPG', '28416', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('507', 'b_1388987949.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184356.jpg', '22889', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('508', '1388987998.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184369.jpg', '62713', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('509', 'b_1388988068.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184391.jpg', '25048', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('510', '1388998729.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184412.jpg', '28357', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('511', '1388994450.jpeg', 'jpeg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184441.jpeg', '69843', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('512', '1388997338.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184493.jpg', '85621', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('513', '1388995730.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184507.jpg', '97702', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('514', '1388991461.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184536.jpg', '53500', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('515', '1388990200.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184572.jpg', '81008', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('516', '1388994497.jpeg', 'jpeg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184638.jpeg', '69154', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('517', '1388994519.jpeg', 'jpeg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184724.jpeg', '65101', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('518', '1388991430.png', 'png', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184742.png', '312001', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('519', '1388994465.jpeg', 'jpeg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184761.jpeg', '63526', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('520', '1389773626.JPG', 'JPG', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184772.JPG', '37080', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('521', '1388991547.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394184783.jpg', '33493', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('522', '1383877502.gif', 'gif', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414367.gif', '105', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('523', '1386734479.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414432.jpg', '87842', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('524', '1388740021.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414456.jpg', '70073', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('525', '1389775848.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414471.jpg', '406559', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('526', '1389776505.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414483.jpg', '6509', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('527', '1389249271.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414513.jpg', '42257', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('528', '1388976946.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414524.jpg', '64108', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('529', '1388978556.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414535.jpg', '54234', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('530', '1389776696.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414549.jpg', '239169', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('531', '1388978583.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414571.jpg', '41229', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('532', '1389254804.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414596.jpg', '63390', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('533', '1389776707.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414613.jpg', '13757', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('534', '1388978571.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414621.jpg', '78674', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('535', '1389249297.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414634.jpg', '71979', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('536', '1388978556.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414652.jpg', '54234', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('537', '1388977124.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414659.jpg', '67374', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('538', '1388978556.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414667.jpg', '54234', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('539', '1389776707.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414690.jpg', '13757', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('540', '1389775892.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414703.jpg', '239169', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('541', '1389253913.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414711.jpg', '4175', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('542', '1389776683.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414731.jpg', '126984', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('543', '1389254815.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414735.jpg', '62998', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('544', '1388978556.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414743.jpg', '54234', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('545', '1388974744.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414752.jpg', '59436', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('546', '1389776505.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414777.jpg', '6509', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('547', '1388980579.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414787.jpg', '44561', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('548', '1388977095.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414795.jpg', '64108', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('549', '1388974370.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414826.jpg', '53411', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('550', '1388977109.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414837.jpg', '64108', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('551', '1388980579.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414847.jpg', '44561', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('552', '1388978139.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414874.jpg', '76388', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('553', '1388978139.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414883.jpg', '76388', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('554', '1389248656.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414900.jpg', '14561', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('555', '1388978571.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414908.jpg', '78674', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('556', '1389776683.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414929.jpg', '126984', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('557', '1389921373.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414939.jpg', '244960', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('558', '1389254102.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414964.jpg', '63367', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('559', '1388978571.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414971.jpg', '78674', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('560', '1389776251.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414978.jpg', '236847', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('561', '1388974744.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414991.jpg', '59436', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('562', '1388976946.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394414999.jpg', '64108', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('563', '1389248656.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394415007.jpg', '14561', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('564', '1389253913.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394415020.jpg', '4175', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('565', '1389776696.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394415127.jpg', '239169', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('566', '1389254091.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394415136.jpg', '58050', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('567', '1389775892.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394415155.jpg', '239169', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('568', '1389775881.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394415164.jpg', '173176', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('569', '1388977124.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394415998.jpg', '67374', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('570', '1389776518.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394416009.jpg', '172443', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('571', '1389775848.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_room_type/201403/1394416485.jpg', '406559', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('572', '1389775892.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_room_type/201403/1394416968.jpg', '239169', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('573', '1389776518.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_room_type/201403/1394417746.jpg', '172443', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('574', '1389254815.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394417765.jpg', '62998', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('575', '1389775881.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394417775.jpg', '173176', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('576', '1389776683.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394418095.jpg', '126984', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('577', '1388978571.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394418119.jpg', '78674', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('578', '1389254815.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_room_type/201403/1394418576.jpg', '62998', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('579', '1388978571.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_room_type/201403/1394418789.jpg', '78674', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('580', '1389253913.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_room_type/201403/1394418824.jpg', '4175', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('581', '1389776683.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_room_type/201403/1394419042.jpg', '126984', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('582', '1388978571.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_room_type/201403/1394419713.jpg', '78674', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('583', '1389775892.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394419733.jpg', '239169', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('584', '1389254804.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394419749.jpg', '63390', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('585', '1388974744.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_pic/201403/1394420118.jpg', '59436', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('586', '1389776251.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_room_type/201403/1394420212.jpg', '236847', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('587', '1389248656.jpg', 'jpg', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394421826.jpg', '14561', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('588', '1389776529.jpg', 'jpg', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394422052.jpg', '250932', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('589', '1388977102.jpg', 'jpg', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394422062.jpg', '67374', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('590', '1393493079.jpg', 'jpg', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394422101.jpg', '73067', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('591', '1393493079.jpg', 'jpg', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394422115.jpg', '73067', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('592', '1392797616.JPG', 'JPG', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394422127.JPG', '94441', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('593', '1393492953.jpg', 'jpg', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394422153.jpg', '402950', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('594', '2012-10-221329879409800x600.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_room_type/201403/1394422543.jpg', '100687', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('595', '34e7724671c68b79f4a7c5490d17d734.jpg', 'jpg', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394422844.jpg', '201008', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('596', '2011-02-221321944604800x600.jpg', 'jpg', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394422858.jpg', '172388', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('597', '1393492953.jpg', 'jpg', 'application/octet-stream', '/Upload/images/hotel_room_type/201403/1394423083.jpg', '402950', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('598', '1009201001646.jpg', 'jpg', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394423203.jpg', '48083', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('599', '2011-01-191313733104800x600.jpg', 'jpg', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394423875.jpg', '146504', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('600', '20110812224240694.jpg', 'jpg', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394423889.jpg', '78039', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('601', '1392797245.jpg', 'jpg', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394423903.jpg', '49931', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('602', 'f9dcd100baa1cd11414dd6c7b812c8fcc2ce2d59.jpg', 'jpg', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394423989.jpg', '96108', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('603', '2011-02-221321944604800x600.jpg', 'jpg', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394431995.jpg', '172388', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('604', '2012-10-221329879409800x600.jpg', 'jpg', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394432019.jpg', '100687', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('605', '1392797616.JPG', 'JPG', 'application/octet-stream', '/Upload/images/articles/201403/1394433921.JPG', '94441', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('606', '1392797600.jpg', 'jpg', 'application/octet-stream', '/Upload/images/articles/201403/1394433982.jpg', '43976', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('607', '1393493079.jpg', 'jpg', 'application/octet-stream', '/Upload/images/articles/201403/1394434041.jpg', '73067', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('608', '2012-10-221329879409800x600.jpg', 'jpg', 'application/octet-stream', '/Upload/images/articles/201403/1394434140.jpg', '100687', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('609', '1389856189.jpg', 'jpg', 'application/octet-stream', '/Upload/images/articles/201403/1394434781.jpg', '522596', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('610', '1389840213.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201403/1394435088.jpg', '449023', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('611', '1389842853.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201403/1394435151.jpg', '31546', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('612', '2011-02-221321944604800x600.jpg', 'jpg', 'application/octet-stream', '/Upload/images/viewpoint_pic/201403/1394435246.jpg', '172388', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('622', '22.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201403/1394504926.jpg', '19628', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('621', '11.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201403/1394504893.jpg', '21125', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('615', '1389859545.jpg', 'jpg', 'application/octet-stream', '/Upload/images/articles/201403/1394441849.jpg', '32768', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('616', '1389859545.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201403/1394444265.jpg', '32768', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('617', '首页-banner3.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201403/1394458804.jpg', '42445', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('618', '首页-banner1.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201403/1394459031.jpg', '121383', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('619', '首页-banner2.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201403/1394459124.jpg', '210588', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('620', '首页-banner3.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201403/1394459328.jpg', '42445', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('623', '33.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201403/1394504958.jpg', '23648', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('624', '44.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201403/1394504981.jpg', '20708', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('625', '1394459328.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201403/1394505945.jpg', '42445', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('626', '1394459328.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201403/1394506058.jpg', '42445', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('627', '86620b4c98c9559fc8d65eac.jpg_r_390x260x90_546f8621.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394785838.jpg', '82581', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('628', '810eb3d31812bbbd93835fbb.jpg_r_390x260x90_019fbd24.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394786445.jpg', '62615', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('629', 'a199d38b1e08af5493835fbb.jpg_r_390x260x90_fed0cc39.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394786473.jpg', '77777', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('630', 'b9b60d4d0e9d018893835fbb.jpg_r_390x260x90_cc52ca0f.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394786493.jpg', '70520', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('631', 'd20578eee4ff35a993835fbb.jpg_r_390x260x90_768872c7.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394787059.jpg', '65505', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('632', 'f6c396e34657d9bc93835fbb.jpg_r_390x260x90_eb184123.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394787084.jpg', '25884', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('633', '4_13945302868647_index.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201403/1394787691.jpg', '61907', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('634', '1.jpg', 'jpg', 'application/octet-stream', '/Upload/images/articles/201504/1429918576.jpg', '432657', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('635', '2.jpg', 'jpg', 'application/octet-stream', '/Upload/images/articles/201504/1429918759.jpg', '596874', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('636', '2013123195310735.jpg', 'jpg', 'application/octet-stream', '/Upload/images/articles/201504/1429918768.jpg', '96700', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('637', '2013122023135589.jpg', 'jpg', 'application/octet-stream', '/Upload/images/articles/201504/1429918971.jpg', '29238', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('638', '2013123195310735.jpg', 'jpg', 'application/octet-stream', '/Upload/images/articles/201504/1429993035.jpg', '96700', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('639', '20131223154755865.jpg', 'jpg', 'application/octet-stream', '/Upload/images/articles/201504/1429993046.jpg', '52538', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('640', '20131223154755865.jpg', 'jpg', 'application/octet-stream', '/Upload/images/articles/201504/1429993065.jpg', '52538', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('641', '201312320127713.jpg', 'jpg', 'application/octet-stream', '/Upload/images/articles/201504/1429993106.jpg', '101949', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('642', '2013122024258104.jpg', 'jpg', 'application/octet-stream', '/Upload/images/articles/201504/1430166403.jpg', '47043', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('643', '1.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201504/1430166567.jpg', '432657', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('644', '2.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201504/1430166575.jpg', '596874', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('645', '3.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201504/1430166582.jpg', '202853', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('646', '4.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201504/1430166639.jpg', '592678', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('647', '4.jpg', 'jpg', 'application/octet-stream', '/Upload/images/names/201504/1430166652.jpg', '592678', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('648', '201312320127713.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201505/1430588178.jpg', '101949', '0', '0');
INSERT INTO `jee_file_manager` VALUES ('649', '2013123195310735.jpg', 'jpg', 'application/octet-stream', '/Upload/images/line_pic/201505/1430588193.jpg', '96700', '0', '0');

-- ----------------------------
-- Table structure for `jee_fit_person`
-- ----------------------------
DROP TABLE IF EXISTS `jee_fit_person`;
CREATE TABLE `jee_fit_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_fit_person
-- ----------------------------
INSERT INTO `jee_fit_person` VALUES ('3', '合家出游', '4', '1');
INSERT INTO `jee_fit_person` VALUES ('5', '亲子出游', '6', '1');
INSERT INTO `jee_fit_person` VALUES ('7', '情侣/爱人', '1', '1');
INSERT INTO `jee_fit_person` VALUES ('8', '独自出游', '2', '1');
INSERT INTO `jee_fit_person` VALUES ('9', '三五好友', '3', '1');
INSERT INTO `jee_fit_person` VALUES ('10', '成群结队', '5', '1');

-- ----------------------------
-- Table structure for `jee_goods_tag_content`
-- ----------------------------
DROP TABLE IF EXISTS `jee_goods_tag_content`;
CREATE TABLE `jee_goods_tag_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gtid` int(11) DEFAULT NULL,
  `gid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='标签与产品关系表';

-- ----------------------------
-- Records of jee_goods_tag_content
-- ----------------------------

-- ----------------------------
-- Table structure for `jee_goods_type`
-- ----------------------------
DROP TABLE IF EXISTS `jee_goods_type`;
CREATE TABLE `jee_goods_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(255) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `states` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='产品类型表';

-- ----------------------------
-- Records of jee_goods_type
-- ----------------------------

-- ----------------------------
-- Table structure for `jee_incomes`
-- ----------------------------
DROP TABLE IF EXISTS `jee_incomes`;
CREATE TABLE `jee_incomes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `code_id` varchar(25) NOT NULL,
  `money` decimal(13,2) NOT NULL DEFAULT '0.00',
  `now_money` decimal(13,2) NOT NULL DEFAULT '0.00',
  `types` tinyint(1) NOT NULL DEFAULT '0',
  `in_type` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_incomes
-- ----------------------------

-- ----------------------------
-- Table structure for `jee_industry_background`
-- ----------------------------
DROP TABLE IF EXISTS `jee_industry_background`;
CREATE TABLE `jee_industry_background` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `industry` varchar(64) DEFAULT NULL COMMENT '行业名',
  `parent_industry` int(11) DEFAULT NULL COMMENT '所属行业',
  `status` int(11) DEFAULT '1' COMMENT '记录状态',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_industry_background
-- ----------------------------
INSERT INTO `jee_industry_background` VALUES ('1', '商贸', null, null);
INSERT INTO `jee_industry_background` VALUES ('2', '农业', null, null);
INSERT INTO `jee_industry_background` VALUES ('3', '建筑', null, null);
INSERT INTO `jee_industry_background` VALUES ('4', '金属', null, null);
INSERT INTO `jee_industry_background` VALUES ('5', '机械', null, null);
INSERT INTO `jee_industry_background` VALUES ('6', '服装', null, null);
INSERT INTO `jee_industry_background` VALUES ('7', '家电', null, null);
INSERT INTO `jee_industry_background` VALUES ('8', '化工', null, null);
INSERT INTO `jee_industry_background` VALUES ('9', '食品', null, null);
INSERT INTO `jee_industry_background` VALUES ('10', '管理', null, null);
INSERT INTO `jee_industry_background` VALUES ('11', '营销', null, null);
INSERT INTO `jee_industry_background` VALUES ('12', '电力', null, null);
INSERT INTO `jee_industry_background` VALUES ('13', '站长', null, null);

-- ----------------------------
-- Table structure for `jee_line`
-- ----------------------------
DROP TABLE IF EXISTS `jee_line`;
CREATE TABLE `jee_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `code` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `seo_id` int(11) DEFAULT '0',
  `line_type` int(11) DEFAULT NULL,
  `trip_days` int(11) DEFAULT NULL,
  `traffic` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `target_type` int(11) DEFAULT NULL,
  `target_topic` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `target` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `topic` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `deal_type` int(11) DEFAULT NULL,
  `compnay` varchar(50) DEFAULT NULL,
  `ly_type` varchar(50) DEFAULT NULL,
  `ps` varchar(255) DEFAULT NULL,
  `award` int(11) DEFAULT NULL,
  `front_money` int(11) DEFAULT NULL,
  `cmoney` int(11) DEFAULT NULL,
  `bonus_comm` int(11) DEFAULT NULL,
  `property` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `edit_model` int(11) DEFAULT '1' COMMENT '编辑模式(1,按天，2,可视化)',
  `hits` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_line
-- ----------------------------
INSERT INTO `jee_line` VALUES ('69', '桂林市区、世界梯田之冠龙脊梯田2日跟团游', '1000000016', '0', '2', '3', '双飞', '240', '1', null, '541', '1', '1', '旅游公司', '独立成团', '呼和浩特→ 大青山→ 西姆拉人草原→ 黄河大桥→ 响沙湾→森林公园→ 呼和浩特', '20', '500', '150', '50', '4', '1', '0', '1', null);
INSERT INTO `jee_line` VALUES ('70', '内蒙古一日起', '000002', '0', '1', '1', '汽车', '240', '1', null, '541', '1', null, '招商旅行社', '组团', '很好', null, '300', '100', null, '1', '50', '0', '1', null);
INSERT INTO `jee_line` VALUES ('71', '5天4晚 内蒙古全景家庭首选 希拉穆仁草原，银肯响沙湾，成吉思汗陵，魅力呼和浩特 包团 自由行', '000041', '0', '2', '5', '自理', '240', '1', null, '541', '2', null, '汇丰自发', '自由行', '选择包团自由行的好处：\r\n1、	全程独立用车,独立成团；\r\n2、	行程中随意停车观光摄影（非限制停车地方）；\r\n3、	每天的出发时间，结束时间完全自定；\r\n4、	景区游览时间，游览节奏自定，只要当天抵达酒店即可；\r\n5、	拒绝低质团餐，吃什么自定，吃的舒服消费也少；\r\n6、	行程当天免费接送机/站；\r\n7、	全程无导游干扰，司机提供贴心服务；\r\n8、	完善的旅行社保障制度，司机按照客人最终回访满意度获取相应的奖惩；\r\n', null, '280', '0', null, '4', '50', '0', '2', null);

-- ----------------------------
-- Table structure for `jee_line_impr`
-- ----------------------------
DROP TABLE IF EXISTS `jee_line_impr`;
CREATE TABLE `jee_line_impr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `impr_id` varchar(100) DEFAULT NULL,
  `travel` int(11) DEFAULT NULL,
  `guide` int(11) DEFAULT NULL,
  `traffic` int(11) DEFAULT NULL,
  `room` int(11) DEFAULT NULL,
  `point` int(11) DEFAULT NULL,
  `content` varchar(100) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_line_impr
-- ----------------------------

-- ----------------------------
-- Table structure for `jee_line_info`
-- ----------------------------
DROP TABLE IF EXISTS `jee_line_info`;
CREATE TABLE `jee_line_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lid` int(11) NOT NULL,
  `General` text CHARACTER SET utf8 COLLATE utf8_bin COMMENT '可视化模式的行程安排',
  `special_info` text CHARACTER SET utf8 COLLATE utf8_bin,
  `order_info` text CHARACTER SET utf8 COLLATE utf8_bin,
  `tip` text CHARACTER SET utf8 COLLATE utf8_bin,
  `contain` text CHARACTER SET utf8 COLLATE utf8_bin COMMENT '包含费用',
  `notcontain` text CHARACTER SET utf8 COLLATE utf8_bin COMMENT '不包含费用',
  `selfpay` text CHARACTER SET utf8 COLLATE utf8_bin COMMENT '自费项目',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_line_info
-- ----------------------------
INSERT INTO `jee_line_info` VALUES ('69', '69', 0xE79A84E8A686E79B96E694BEE588B0E79A84E8A686E79B96E694BEE588B0E794B5E9A5ADE99485E59CB0E696B9, 0x3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE789B9E889B2E4BB8BE7BB8D3C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE789B9E889B2E4BB8BE7BB8D3C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE789B9E889B2E4BB8BE7BB8D3C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE789B9E889B2E4BB8BE7BB8D3C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE789B9E889B2E4BB8BE7BB8D3C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE789B9E889B2E4BB8BE7BB8D3C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE789B9E889B2E4BB8BE7BB8D3C2F7370616E3E, 0x3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE9A284E5AE9AE99C803C2F7370616E3E, 0x3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE6B8A9E9A6A8E68F90E7A4BA3C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE6B8A9E9A6A8E68F90E7A4BA3C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE6B8A9E9A6A8E68F90E7A4BA3C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE6B8A9E9A6A8E68F90E7A4BA3C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE6B8A9E9A6A8E68F90E7A4BA3C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE6B8A9E9A6A8E68F90E7A4BA3C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE6B8A9E9A6A8E68F90E7A4BA3C2F7370616E3E3C7370616E207374796C653D22636F6C6F723A233737373737373B666F6E742D66616D696C793A5461686F6D612C2056657264616E612C2048656C7665746963612C20417269616C2C2073616E732D73657269663B6C696E652D6865696768743A6E6F726D616C3B6261636B67726F756E642D636F6C6F723A234646464646463B223EE6B8A9E9A6A8E68F90E7A4BA3C2F7370616E3E, '', '', '');
INSERT INTO `jee_line_info` VALUES ('70', '70', '', 0xE698AFE5AFB9E696B9E698AFE590A6E5A3ABE5A4A7E5A4ABE9A1BAE4B8B0E698AF20E5A3ABE5A4A7E5A4ABE5A3ABE5A4A7E5A4ABE698AFE5AFB9E696B9E698AFE590A6E5A3ABE5A4A7E5A4ABE9A1BAE4B8B0E698AF20E5A3ABE5A4A7E5A4ABE5A3ABE5A4A7E5A4ABE698AFE5AFB9E696B9E698AFE590A6E5A3ABE5A4A7E5A4ABE9A1BAE4B8B0E698AF20E5A3ABE5A4A7E5A4ABE5A3ABE5A4A7E5A4ABE698AFE5AFB9E696B9E698AFE590A6E5A3ABE5A4A7E5A4ABE9A1BAE4B8B0E698AF20E5A3ABE5A4A7E5A4ABE5A3ABE5A4A7E5A4AB, 0xE698AFE5AFB9E696B9E698AFE590A6E5A3ABE5A4A7E5A4ABE9A1BAE4B8B0E698AF20E5A3ABE5A4A7E5A4ABE5A3ABE5A4A7E5A4ABE698AFE5AFB9E696B9E698AFE590A6E5A3ABE5A4A7E5A4ABE9A1BAE4B8B0E698AF20E5A3ABE5A4A7E5A4ABE5A3ABE5A4A7E5A4ABE698AFE5AFB9E696B9E698AFE590A6E5A3ABE5A4A7E5A4ABE9A1BAE4B8B0E698AF20E5A3ABE5A4A7E5A4ABE5A3ABE5A4A7E5A4ABE698AFE5AFB9E696B9E698AFE590A6E5A3ABE5A4A7E5A4ABE9A1BAE4B8B0E698AF20E5A3ABE5A4A7E5A4ABE5A3ABE5A4A7E5A4AB, 0xE698AFE5AFB9E696B9E698AFE590A6E5A3ABE5A4A7E5A4ABE9A1BAE4B8B0E698AF20E5A3ABE5A4A7E5A4ABE5A3ABE5A4A7E5A4ABE698AFE5AFB9E696B9E698AFE590A6E5A3ABE5A4A7E5A4ABE9A1BAE4B8B0E698AF20E5A3ABE5A4A7E5A4ABE5A3ABE5A4A7E5A4ABE698AFE5AFB9E696B9E698AFE590A6E5A3ABE5A4A7E5A4ABE9A1BAE4B8B0E698AF20E5A3ABE5A4A7E5A4ABE5A3ABE5A4A7E5A4ABE698AFE5AFB9E696B9E698AFE590A6E5A3ABE5A4A7E5A4ABE9A1BAE4B8B0E698AF20E5A3ABE5A4A7E5A4ABE5A3ABE5A4A7E5A4AB, '', '', '');

-- ----------------------------
-- Table structure for `jee_line_keep`
-- ----------------------------
DROP TABLE IF EXISTS `jee_line_keep`;
CREATE TABLE `jee_line_keep` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `line_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `create_time` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_line_keep
-- ----------------------------

-- ----------------------------
-- Table structure for `jee_line_pic`
-- ----------------------------
DROP TABLE IF EXISTS `jee_line_pic`;
CREATE TABLE `jee_line_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `line_id` int(11) NOT NULL,
  `names` varchar(100) DEFAULT NULL COMMENT '图片标题',
  `pic_path` varchar(100) DEFAULT NULL COMMENT '原图',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `istitlepage` tinyint(1) DEFAULT NULL COMMENT '是否设置封面(1是2否)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=230 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_line_pic
-- ----------------------------
INSERT INTO `jee_line_pic` VALUES ('228', '69', '桂林市区、世界梯田之冠龙脊梯田2日跟团游', '/Upload/images/line_pic/201505/1430588178.jpg', null, '2');
INSERT INTO `jee_line_pic` VALUES ('229', '69', '桂林市区、世界梯田之冠龙脊梯田2日跟团游', '/Upload/images/line_pic/201505/1430588193.jpg', null, '2');

-- ----------------------------
-- Table structure for `jee_line_pin`
-- ----------------------------
DROP TABLE IF EXISTS `jee_line_pin`;
CREATE TABLE `jee_line_pin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) DEFAULT '0',
  `state` tinyint(4) DEFAULT '0',
  `orderid` varchar(20) DEFAULT '0' COMMENT '支付订单号',
  `lid` int(11) DEFAULT '0',
  `lcode` varchar(50) DEFAULT NULL,
  `cmoney` int(11) DEFAULT '0',
  `num` int(11) DEFAULT '0',
  `price` int(11) DEFAULT '0',
  `payclass` int(11) DEFAULT '0',
  `tuan_name` varchar(50) DEFAULT NULL,
  `start` varchar(50) DEFAULT NULL,
  `ends` varchar(50) DEFAULT NULL,
  `people` int(11) DEFAULT '0',
  `woman` int(11) DEFAULT '0',
  `chd` int(11) DEFAULT '0',
  `mins` int(11) DEFAULT '0',
  `maxs` int(11) DEFAULT '0',
  `must` tinyint(4) DEFAULT '0',
  `cheap` int(11) DEFAULT '0',
  `name` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `phones` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `desc` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_line_pin
-- ----------------------------
INSERT INTO `jee_line_pin` VALUES ('87', '1', '0', '14306874631962', '69', '1000000016', '0', '0', '0', '0', null, null, '2015-05-07', '0', '0', '0', '0', '0', '0', '0', '傻乎乎', '18598765432', '18598765432', 'kjbzc@qq.com', '18598765432185987654321859876543218598765432');
INSERT INTO `jee_line_pin` VALUES ('89', '0', '1', '14306881333428', '69', '1000000016', '150', '4', '600', '0', '测试', '2015-05-06', '2015-05-20', '1', '2', '1', '6', '13', '1', '0', '唐先生', '18598765432', null, 'kjbzc@qq.com', '是一家三口，来自上海，是大学教授，年龄在35岁左右，希望拼到两个年龄差不多的家庭，地域工作不限，不接受单身或者小情侣；同时我们需要把住宿调整为ｘｘｘｘ，补差价ｘｘｘ元，我的微');
INSERT INTO `jee_line_pin` VALUES ('90', '0', '0', '14308748095340', '70', '000002', '100', '2', '200', '0', 'yiti ', '2015-05-12', '2015-05-14', '1', '1', '0', '2', '8', '1', '0', 'kjkj ', '1335555555', null, '879111@qq.com', 'dsfsf ');

-- ----------------------------
-- Table structure for `jee_line_price`
-- ----------------------------
DROP TABLE IF EXISTS `jee_line_price`;
CREATE TABLE `jee_line_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `line_id` int(11) DEFAULT NULL,
  `price_type` int(11) DEFAULT NULL COMMENT '价格类型，1指定日期，2起始日期和结束日期，3指定星期，4基本',
  `price_date` int(11) DEFAULT NULL COMMENT '当前价格日期',
  `price_date_end` int(11) DEFAULT NULL COMMENT '价格类型为阶段类型时的结束时间',
  `RACKRATE` decimal(20,2) DEFAULT NULL COMMENT '门市价',
  `price_adult` decimal(20,2) DEFAULT NULL COMMENT '成人价',
  `price_children` decimal(20,2) DEFAULT NULL COMMENT '儿童价',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_line_price
-- ----------------------------
INSERT INTO `jee_line_price` VALUES ('101', '69', '4', '0', '0', '888.00', '666.00', '333.00');
INSERT INTO `jee_line_price` VALUES ('102', '69', '1', '1432224000', '0', '600.00', '300.00', '200.00');
INSERT INTO `jee_line_price` VALUES ('103', '70', '4', '0', '0', '800.00', '700.00', '600.00');
INSERT INTO `jee_line_price` VALUES ('104', '70', '2', '1428249600', '1429545600', '800.00', '700.00', '600.00');
INSERT INTO `jee_line_price` VALUES ('105', '70', '2', '1430928000', '1433001600', '900.00', '800.00', '700.00');

-- ----------------------------
-- Table structure for `jee_line_que`
-- ----------------------------
DROP TABLE IF EXISTS `jee_line_que`;
CREATE TABLE `jee_line_que` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `line_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `question1` varchar(600) NOT NULL,
  `question2` varchar(1000) DEFAULT '',
  `answer` varchar(1600) DEFAULT NULL,
  `publish_time` int(11) NOT NULL,
  `answer_time` int(11) DEFAULT NULL,
  `status` smallint(2) DEFAULT '1',
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_line_que
-- ----------------------------
INSERT INTO `jee_line_que` VALUES ('21', '69', null, '符合规范刚好覆盖和法国恢复规划返回风格化', '', '顶顶顶顶', '1430589805', '1430592971', '2', '0');
INSERT INTO `jee_line_que` VALUES ('22', '69', null, '电饭锅电饭锅豆腐干豆腐哥个梵蒂冈放到地方', '', null, '1430589811', null, '1', '0');
INSERT INTO `jee_line_que` VALUES ('23', '69', null, '反反复复放电饭锅', '', null, '1430590279', null, '1', '0');
INSERT INTO `jee_line_que` VALUES ('24', '69', null, '反反复复放电饭锅', '', null, '1430590280', null, '1', '0');
INSERT INTO `jee_line_que` VALUES ('25', '69', null, '反反复复放电饭锅', '', null, '1430590280', null, '1', '0');
INSERT INTO `jee_line_que` VALUES ('26', '69', null, '反反复复放电饭锅', '', null, '1430590281', null, '1', '0');
INSERT INTO `jee_line_que` VALUES ('27', '69', null, '反反复复放电饭锅', '', null, '1430590281', null, '1', '0');
INSERT INTO `jee_line_que` VALUES ('28', '69', null, '反反复复放电饭锅', '', null, '1430590281', null, '1', '0');
INSERT INTO `jee_line_que` VALUES ('29', '69', null, '是东方闪电士大夫稍等', '', null, '1430590408', null, '1', '0');
INSERT INTO `jee_line_que` VALUES ('30', '69', null, '灌灌灌灌灌灌灌灌灌灌', '', null, '1430590413', null, '1', '0');
INSERT INTO `jee_line_que` VALUES ('31', '69', null, '士大夫士大夫的所发生的', '', null, '1430590907', null, '1', '0');
INSERT INTO `jee_line_que` VALUES ('32', '69', null, '士大夫士大夫的所发生的广告', '', '凤飞飞', '1430590910', '1430593055', '2', '0');
INSERT INTO `jee_line_que` VALUES ('33', '69', null, '非法的覆盖放到电饭锅的', '', null, '1430594087', null, '1', '0');
INSERT INTO `jee_line_que` VALUES ('34', '69', null, '天赋也太容易让讨厌人体艺术乳贴try人体艺术天然人', '', null, '1430594096', null, '1', '0');
INSERT INTO `jee_line_que` VALUES ('35', '69', null, '第三方第三方是的范德萨', '', null, '1430594114', null, '1', '0');
INSERT INTO `jee_line_que` VALUES ('36', '69', null, '的所发生的士大夫士大夫', '', null, '1430594158', null, '1', '0');

-- ----------------------------
-- Table structure for `jee_line_recommend`
-- ----------------------------
DROP TABLE IF EXISTS `jee_line_recommend`;
CREATE TABLE `jee_line_recommend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `sort` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_line_recommend
-- ----------------------------

-- ----------------------------
-- Table structure for `jee_line_tao`
-- ----------------------------
DROP TABLE IF EXISTS `jee_line_tao`;
CREATE TABLE `jee_line_tao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) DEFAULT '0',
  `line_id` int(11) NOT NULL,
  `names` varchar(100) DEFAULT NULL COMMENT '图片标题',
  `opentime` varchar(50) DEFAULT NULL,
  `endtime` varchar(50) DEFAULT NULL,
  `man_price` int(11) DEFAULT NULL,
  `man_price_yufu` int(11) DEFAULT NULL,
  `er_price` int(11) DEFAULT '0',
  `er_price_yufu` int(11) DEFAULT NULL,
  `count_ren` int(11) DEFAULT NULL,
  `place` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=231 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_line_tao
-- ----------------------------
INSERT INTO `jee_line_tao` VALUES ('230', '0', '69', '1日游', '2015-05-13', '2015-06-30', '1500', '150', '1000', '150', '10', '2', '50');

-- ----------------------------
-- Table structure for `jee_line_target`
-- ----------------------------
DROP TABLE IF EXISTS `jee_line_target`;
CREATE TABLE `jee_line_target` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_id` int(11) NOT NULL COMMENT '目的地主题id',
  `type_id` int(11) DEFAULT NULL,
  `area_id` int(11) NOT NULL COMMENT '目的地城市ID',
  `travel_num` int(11) DEFAULT '0',
  `classify` int(11) DEFAULT NULL COMMENT '目的地分类',
  `sort` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COMMENT='目的地城市';

-- ----------------------------
-- Records of jee_line_target
-- ----------------------------
INSERT INTO `jee_line_target` VALUES ('60', '240', '1', '541', '0', '0', '0');

-- ----------------------------
-- Table structure for `jee_line_topic_type`
-- ----------------------------
DROP TABLE IF EXISTS `jee_line_topic_type`;
CREATE TABLE `jee_line_topic_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_line_topic_type
-- ----------------------------
INSERT INTO `jee_line_topic_type` VALUES ('1', '古镇游', '1', '1');
INSERT INTO `jee_line_topic_type` VALUES ('2', '山水游', '2', '1');
INSERT INTO `jee_line_topic_type` VALUES ('3', '海岛游', '3', '1');
INSERT INTO `jee_line_topic_type` VALUES ('4', '乐园游', '4', '1');
INSERT INTO `jee_line_topic_type` VALUES ('5', '购物游', '5', '1');

-- ----------------------------
-- Table structure for `jee_line_travel`
-- ----------------------------
DROP TABLE IF EXISTS `jee_line_travel`;
CREATE TABLE `jee_line_travel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `line_id` int(11) NOT NULL COMMENT '路线id',
  `day` int(11) DEFAULT NULL COMMENT '第几天',
  `title` varchar(255) DEFAULT NULL,
  `dining` varchar(10) DEFAULT NULL COMMENT '用餐(1,2,3)',
  `stay` varchar(50) DEFAULT NULL COMMENT '住宿',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_line_travel
-- ----------------------------
INSERT INTO `jee_line_travel` VALUES ('100', '69', '1', '哈尔滨 → 亚雪驿站 → 雪乡(双峰林场)', '2', '农家乐');
INSERT INTO `jee_line_travel` VALUES ('101', '69', '2', '111', '2', '222');
INSERT INTO `jee_line_travel` VALUES ('102', '69', '3', '12123333333', null, '3333');
INSERT INTO `jee_line_travel` VALUES ('103', '70', '1', '希拉穆仁', '1,2,3', '标间');
INSERT INTO `jee_line_travel` VALUES ('104', '71', '1', '', null, '');

-- ----------------------------
-- Table structure for `jee_line_travel_section`
-- ----------------------------
DROP TABLE IF EXISTS `jee_line_travel_section`;
CREATE TABLE `jee_line_travel_section` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `line_id` int(11) DEFAULT NULL,
  `travel_id` int(11) DEFAULT NULL,
  `names` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_line_travel_section
-- ----------------------------
INSERT INTO `jee_line_travel_section` VALUES ('99', '69', '100', '1', '途径【亚雪驿站】', '第1天第1段内容....');
INSERT INTO `jee_line_travel_section` VALUES ('100', '69', '101', '1', '222', '第2天第1段内容....');
INSERT INTO `jee_line_travel_section` VALUES ('101', '69', '100', '2', '121212222', '第1天第2段内容....');
INSERT INTO `jee_line_travel_section` VALUES ('102', '69', '102', '1', '333', '第3天第1段内容....');
INSERT INTO `jee_line_travel_section` VALUES ('103', '70', '103', '1', '矩鞍环', '第1天第1段内容....哈市的机会撒大家好');
INSERT INTO `jee_line_travel_section` VALUES ('104', '70', '103', '2', '个人', '第1天第2段内容....热特然特特额');
INSERT INTO `jee_line_travel_section` VALUES ('105', '70', '103', '3', '阿斯达', '第1天第3段内容....阿斯达ADS啊');
INSERT INTO `jee_line_travel_section` VALUES ('106', '71', '104', '1', '', '第1天第1段内容....');

-- ----------------------------
-- Table structure for `jee_line_type`
-- ----------------------------
DROP TABLE IF EXISTS `jee_line_type`;
CREATE TABLE `jee_line_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `page_names` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `describe` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '类型描述',
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_line_type
-- ----------------------------
INSERT INTO `jee_line_type` VALUES ('1', '包团自由行', 'around', '1', '玩转周边快乐无限，周末假期精彩生活！', '1');
INSERT INTO `jee_line_type` VALUES ('2', '纯玩团', 'tourin', '2', '游遍祖国大好河山，尝尽中华缤纷美味！', '1');
INSERT INTO `jee_line_type` VALUES ('3', '会议策划', 'tourout', '3', '尽享异域风情，快乐不容错过！', '1');
INSERT INTO `jee_line_type` VALUES ('4', '团队策划', 'rec', '4', null, '1');
INSERT INTO `jee_line_type` VALUES ('5', '自驾游', 'zjy', '5', null, '1');

-- ----------------------------
-- Table structure for `jee_liuyan`
-- ----------------------------
DROP TABLE IF EXISTS `jee_liuyan`;
CREATE TABLE `jee_liuyan` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(5) NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `content` text NOT NULL,
  `contents` text,
  `admin_name` varchar(20) DEFAULT NULL,
  `user_time` datetime NOT NULL,
  `admin_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_liuyan
-- ----------------------------

-- ----------------------------
-- Table structure for `jee_mention`
-- ----------------------------
DROP TABLE IF EXISTS `jee_mention`;
CREATE TABLE `jee_mention` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `dedution` decimal(10,2) NOT NULL,
  `addtime` datetime NOT NULL,
  `memo` varchar(200) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_mention
-- ----------------------------

-- ----------------------------
-- Table structure for `jee_node`
-- ----------------------------
DROP TABLE IF EXISTS `jee_node`;
CREATE TABLE `jee_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `remark` varchar(255) DEFAULT NULL,
  `sort` smallint(6) unsigned DEFAULT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_node
-- ----------------------------
INSERT INTO `jee_node` VALUES ('35', 'admin', '系统入口', '1', '系统入口', '0', '35', '1');
INSERT INTO `jee_node` VALUES ('36', 'section', '栏目管理', '1', '栏目管理', '0', '35', '2');
INSERT INTO `jee_node` VALUES ('37', 'ad', '广告管理', '1', '广告管理', '0', '35', '2');
INSERT INTO `jee_node` VALUES ('38', 'lists', '栏目的列表', '1', '栏目的列表', '0', '36', '3');
INSERT INTO `jee_node` VALUES ('39', 'index', '主页', '1', '主页', '0', '35', '2');

-- ----------------------------
-- Table structure for `jee_notice`
-- ----------------------------
DROP TABLE IF EXISTS `jee_notice`;
CREATE TABLE `jee_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `start_time` int(11) DEFAULT NULL,
  `end_time` int(11) DEFAULT NULL,
  `create_time` int(11) NOT NULL,
  `content` text,
  `hits` int(11) NOT NULL DEFAULT '0',
  `sort` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='公告管理';

-- ----------------------------
-- Records of jee_notice
-- ----------------------------
INSERT INTO `jee_notice` VALUES ('2', 'tangguan', null, null, '0', '546546546546546546546546546546546546546546546546', '11', '0', '1');

-- ----------------------------
-- Table structure for `jee_order`
-- ----------------------------
DROP TABLE IF EXISTS `jee_order`;
CREATE TABLE `jee_order` (
  `id` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `addtime` datetime NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_order
-- ----------------------------

-- ----------------------------
-- Table structure for `jee_order_userinfo`
-- ----------------------------
DROP TABLE IF EXISTS `jee_order_userinfo`;
CREATE TABLE `jee_order_userinfo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL COMMENT '订单表ID号（非订单号）',
  `names` varchar(16) NOT NULL COMMENT '用户姓名',
  `old_type` smallint(2) DEFAULT '1',
  `credentials` smallint(2) NOT NULL COMMENT '证件类型',
  `content` varchar(120) DEFAULT NULL COMMENT '信息内容',
  `type` varchar(10) NOT NULL COMMENT '信息所属分类（酒店、景点或线路）',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_order_userinfo
-- ----------------------------
INSERT INTO `jee_order_userinfo` VALUES ('1', '1', '啊啊', '1', '0', '456746876841703402', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('2', '1', '窝窝', '1', '0', '545130541330765750', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('3', '2', '', '1', '1', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('4', '3', '哈哈', '1', '0', '115875614687651065', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('5', '3', '呼呼', '1', '0', '456174640546132102', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('6', '4', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('7', '25', '', '1', '0', '', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('8', '25', '', '1', '0', '', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('9', '25', '', '2', '0', '', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('10', '25', '', '2', '0', '', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('11', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('12', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('13', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('14', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('15', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('16', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('17', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('18', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('19', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('20', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('21', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('22', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('23', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('24', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('25', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('26', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('27', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('28', '5', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('29', '6', '测试', '1', '0', '45174564051487564567564', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('30', '6', '玩一玩', '1', '0', '54414614764735135754650', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('31', '26', '', '1', '0', '', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('32', '7', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('33', '27', '', '1', '0', '', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('34', '8', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('35', '9', '啊啊啊', '1', '0', '15681545681747565', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('36', '9', '哦哦哦', '1', '0', '21981468146176465', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('37', '28', '哈哈哈', '1', '0', '450104199109300038', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('38', '29', '张三', '1', '0', '450104199109300033', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('39', '29', '李四', '2', '0', '450104199109300034', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('40', '29', '王五', '2', '0', '450104199109300035', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('41', '30', 'sadasd', '1', '0', '4501041991096300033', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('42', '31', '测试人A1', '1', '0', '450104199109300033', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('43', '32', '成人', '1', '0', '450104199109300033', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('44', '32', '小孩', '2', '0', '450104199109300032', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('45', '10', '哈哈', '1', '0', '1156146570564', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('46', '10', '啊啊', '1', '0', '5461565431545', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('47', '33', '', '1', '0', '', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('48', '11', '哈哈', '1', '0', '54147676845675', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('49', '11', '吼吼', '1', '0', '871617658768167', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('50', '34', '', '1', '0', '', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('51', '12', '哇哇', '1', '0', '149814561767684568', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('52', '13', 'aa', '1', '2', '15674616176174', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('53', '13', 'uu', '1', '0', '5156876140541574545', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('54', '14', '晨晨', '1', '0', '0000000000000000', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('55', '15', '糖罐', '1', '0', '45616846545641654456', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('56', '15', '测试人员', '1', '0', '1126146146514651454', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('57', '16', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('58', '16', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('59', '16', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('60', '16', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('61', '16', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('62', '17', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('63', '17', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('64', '18', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('65', '18', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('66', '19', '3e3', '1', '0', '233333332r', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('67', '19', 'ff', '1', '0', '333333333333333', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('68', '20', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('69', '20', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('70', '20', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('71', '20', '', '1', '0', '', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('72', '21', 'dg', '1', '0', '456781464768175', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('73', '22', 'xcvxv', '1', '0', '156414561746', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('74', '23', '3e3', '1', '0', '333333333333333', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('75', '36', '成人', '1', '0', '450104199109300033', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('76', '36', '小哈', '2', '0', '11111111111111111111', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('77', '37', '成人', '1', '0', '450104199109300033', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('78', '37', '普通人', '1', '0', '450104199109300022', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('79', '38', 'jee', '1', '0', 'dddd', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('80', '38', 'yanz', '1', '0', 'ggggg', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('81', '38', 'jon', '2', '0', '559', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('82', '38', 'jone', '2', '0', '555', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('83', '39', '普通1', '1', '0', '1111', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('84', '39', '普通2', '1', '0', '111', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('85', '39', '普通3', '1', '0', '111', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('86', '39', '儿童1', '2', '0', '1111', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('87', '39', '儿童2', '2', '0', '1111', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('88', '40', '何斌', '1', '0', '45010419999999999', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('89', '41', '啊啊', '1', '0', '16517686654521324', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('90', '41', '呵呵', '2', '0', '35416425416765024', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('91', '42', '何斌', '1', '0', '111111111', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('92', '43', 'hbbb', '1', '0', '13333', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('93', '44', '哈哈', '1', '0', '450104199109300022', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('94', '45', 'sadasd', '1', '0', '1111', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('95', '46', 'asdasd', '1', '0', '213123', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('96', '47', '何斌', '1', '0', '333', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('97', '48', '何斌', '1', '0', 'asdasdas', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('98', '49', 'asdasd', '1', '0', '123123', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('99', '50', 'asdasd', '1', '0', '46666666666666666', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('100', '51', 'asda', '1', '0', '123123', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('101', '52', 'asdasd', '1', '0', '123123', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('102', '24', '何斌', '1', '0', '566666', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('103', '30', '何斌', '1', '0', '33333', 'HOTEL');
INSERT INTO `jee_order_userinfo` VALUES ('104', '53', 'sadasd', '1', '0', '111111', 'LINE');
INSERT INTO `jee_order_userinfo` VALUES ('105', '54', 'hebin', '1', '0', '123213', 'LINE');

-- ----------------------------
-- Table structure for `jee_paycart`
-- ----------------------------
DROP TABLE IF EXISTS `jee_paycart`;
CREATE TABLE `jee_paycart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_paycart
-- ----------------------------
INSERT INTO `jee_paycart` VALUES ('1', '国内发行银联卡', '1');
INSERT INTO `jee_paycart` VALUES ('2', '万事达（Master）', '1');
INSERT INTO `jee_paycart` VALUES ('3', '威士（VISA）', '1');
INSERT INTO `jee_paycart` VALUES ('4', '运通（AMEX）', '1');
INSERT INTO `jee_paycart` VALUES ('5', '大来（Diners Club）', '1');
INSERT INTO `jee_paycart` VALUES ('6', 'JCB卡', '1');

-- ----------------------------
-- Table structure for `jee_payment_api`
-- ----------------------------
DROP TABLE IF EXISTS `jee_payment_api`;
CREATE TABLE `jee_payment_api` (
  `api_id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `names_en` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `merchantid` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `merchantkey` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `UDID` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payment_pwd` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `payment_in` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fee` double NOT NULL,
  `sort` int(11) NOT NULL,
  `status` smallint(6) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `configs` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '映射',
  PRIMARY KEY (`api_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_payment_api
-- ----------------------------
INSERT INTO `jee_payment_api` VALUES ('1', '网银在线', 'wangyin', 'https://pay3.chinabank.com.cn/PayGate?encoding=UTF-8', '22883787', 'tripecwangyin2014', '132413245656', '15245613213', '1235461332', '13245613213', '0', '1', '网银在线', 'orm:\r\n    send:\r\n        MerchantKey: key\r\n        MerchantID: v_mid\r\n        OrderId: v_oid         \r\n        amount: v_amount\r\n        AutoReceive: v_url\r\n        Receive: v_url\r\n        bank: pmode_id\r\n        remark1: remark1\r\n        remark2: remark2\r\n        sendmd5info: v_md5info\r\n    return:\r\n        MerchantKey: key\r\n        OrderId: v_oid\r\n        status: v_pstatus        \r\n        info: v_pstring\r\n        bank: v_pmode\r\n        amount: v_amount\r\n        remark1: remark1\r\n        remark2: remark2\r\n        returnmd5info: v_md5str\r\n        returnmd5check: v_md5check\r\n    status:\r\n        success: 20\r\n        error: 30\r\n        success_echo: ok\r\n        error_echo: error\r\nstatic:   \r\n   v_moneytype: \"CNY\"\r\n   remark2: \"[url:=http://demo-v1.tripec.cn/index.php/paymentapi/autoreceive/paymentname/wangyin]\"\r\nrules:\r\n   send:\r\n        v_oid: \r\n            0: \"#Ymd#-%v_mid%-%v_oid%\"\r\n        v_md5info: \r\n            0: \"%v_amount%%v_moneytype%%v_oid%%v_mid%%v_url%%key%\"\r\n            1: md5\r\n            2: strtoupper        \r\n   return:\r\n       v_md5check: \r\n           0: \"%v_oid%%v_pstatus%%v_amount%%v_moneytype%%key%\"\r\n           1: md5\r\n           2: strtoupper \r\n       v_oid:\r\n           0: \"%v_oid%\"\r\n           1: \"explode=\'-\',\'###\'\"\r\n           2: \"end\"                       \r\nrequired: \r\n   v_mid\r\n   v_oid\r\n   v_amount\r\n   v_url\r\n   v_md5info\r\n   v_moneytype\r\noptional:\r\n   pmode_id\r\n   remark1\r\n   remark2');

-- ----------------------------
-- Table structure for `jee_payment_bank`
-- ----------------------------
DROP TABLE IF EXISTS `jee_payment_bank`;
CREATE TABLE `jee_payment_bank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `api_id` int(11) NOT NULL,
  `names` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `types` tinyint(1) DEFAULT NULL,
  `key_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `mark` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `style` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `pic` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_payment_bank
-- ----------------------------
INSERT INTO `jee_payment_bank` VALUES ('1', '1', '工商银行', '1', '', '1025', 'icbc', 'web/Tpl/green2/Public/images/banks/gsyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('3', '1', '中国银行', '1', '', '104', 'bocsh', 'web/Tpl/green2/Public/images/banks/zgyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('4', '1', '建设银行', '1', '', '105', 'ccb', 'web/Tpl/green2/Public/images/banks/jsyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('5', '1', '招商银行', '2', '', '308', 'cmb', 'web/Tpl/green2/Public/images/banks/zsyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('6', '1', '浦发银行', '1', '', '314', 'spdb', 'web/Tpl/green2/Public/images/banks/pfyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('8', '1', '交通银行', '2', '', '301', 'bocom', 'web/Tpl/green2/Public/images/banks/jtyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('9', '1', '邮政储蓄银行', '1', '', '3230', 'psbc', 'web/Tpl/green2/Public/images/banks/yzcx.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('10', '1', '中信银行', '1', '', '313', 'cncb', 'web/Tpl/green2/Public/images/banks/zxyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('11', '1', '民生银行', '1', '', '305', 'cmbc', 'web/Tpl/green2/Public/images/banks/msyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('12', '1', '华夏银行', '2', '', '3112', 'hxb', 'web/Tpl/green2/Public/images/banks/hxyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('13', '1', '光大银行', '1', '', '312', 'ceb', 'web/Tpl/green2/Public/images/banks/gdyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('14', '1', '兴业银行', '2', '', '309', 'cib', 'web/Tpl/green2/Public/images/banks/xyyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('15', '1', '光大银行', '2', '', '3121', 'ceb', 'web/Tpl/green2/Public/images/banks/gdyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('16', '1', '工商银行', '2', '', '1025', 'icbc', 'web/Tpl/green2/Public/images/banks/gsyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('17', '1', '招商银行', '1', '', '3080', 'cmd', 'web/Tpl/green2/Public/images/banks/zsyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('18', '1', '农业银行', '1', '', '103', 'abc', 'web/Tpl/green2/Public/images/banks/nyyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('19', '1', '交通银行', '1', '', '301', 'bocom', 'web/Tpl/green2/Public/images/banks/jtyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('20', '1', '华夏银行', '1', '', '311', 'hxb', 'web/Tpl/green2/Public/images/banks/hxyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('21', '1', '兴业银行', '1', '', '309', 'cib', 'web/Tpl/green2/Public/images/banks/xyyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('22', '1', '广发银行', '1', '', '306', 'gdb', 'web/Tpl/green2/Public/images/banks/gfyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('23', '1', '平安银行', '1', '', '307', 'pab', 'web/Tpl/green2/Public/images/banks/payh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('24', '1', '南京银行', '1', '', '316', 'njb', 'web/Tpl/green2/Public/images/banks/njyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('25', '1', '杭州银行', '1', '', '324', 'hzb', 'web/Tpl/green2/Public/images/banks/hzyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('26', '1', '宁波银行', '1', '', '302', 'nbb', 'web/Tpl/green2/Public/images/banks/nbyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('27', '1', '上海银行', '1', '', '326', 'shb', 'web/Tpl/green2/Public/images/banks/shyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('28', '1', '浙江泰隆银行', '1', '', '329', 'zztlb', 'web/Tpl/green2/Public/images/banks/tlyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('29', '1', '建设银行', '2', '', '1054', 'ccb', 'web/Tpl/green2/Public/images/banks/jsyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('30', '1', '中国银行', '2', '', '106', 'bocsH', 'web/Tpl/green2/Public/images/banks/zgyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('31', '1', '民生银行', '2', '', '3051', 'cmbc', 'web/Tpl/green2/Public/images/banks/msyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('32', '1', '邮政储蓄银行', '2', '', '3231', 'psbc', 'web/Tpl/green2/Public/images/banks/yzcx.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('33', '1', '杭州银行', '2', '', '3241', 'hzb', 'web/Tpl/green2/Public/images/banks/hzyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('34', '1', '上海银行', '2', '', '3261', 'shb', 'web/Tpl/green2/Public/images/banks/shyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('35', '1', '平安银行', '2', '', '307', 'pab', 'web/Tpl/green2/Public/images/banks/payh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('36', '1', '其他银行', '1', '', '327', 'other', 'web/Tpl/green2/Public/images/banks/qtyh.jpg', '1');
INSERT INTO `jee_payment_bank` VALUES ('37', '1', '其他银行', '2', '', '327', 'other', 'web/Tpl/green2/Public/images/banks/qtyh.jpg', '1');

-- ----------------------------
-- Table structure for `jee_payment_bill`
-- ----------------------------
DROP TABLE IF EXISTS `jee_payment_bill`;
CREATE TABLE `jee_payment_bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OrderId` varchar(50) NOT NULL,
  `POrderId` varchar(50) NOT NULL,
  `MerchantID` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `apiName` varchar(50) DEFAULT NULL,
  `AutoReceive` varchar(255) DEFAULT NULL,
  `Receive` varchar(255) DEFAULT NULL,
  `bank` varchar(15) DEFAULT NULL,
  `remark1` varchar(255) DEFAULT NULL,
  `remark2` varchar(255) DEFAULT NULL,
  `start_time` int(11) DEFAULT NULL,
  `finish_time` int(11) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_payment_bill
-- ----------------------------
INSERT INTO `jee_payment_bill` VALUES ('1', '201402081425551245674', '20140208144231874261', '20140208', '2000.00', 'wangyin', 'http://demo_v1.tripec.cn/index.php/test/return_test', 'http://localhost/tripec/index.php/test/return_test', 'ICBC', '测试', '测试2', '1391841751', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:26.0) Gecko/20100101 Firefox/26.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('2', '201402081425551245675', '20140210140910160727', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/test/return_test', 'http://localhost/tripec/index.php/test/return_test', '1025', '测试', '测试2', '1392012550', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:26.0) Gecko/20100101 Firefox/26.0', '1');
INSERT INTO `jee_payment_bill` VALUES ('3', '201402081425551245676', '20140210161155521323', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/test/return_test', 'http://demo_v1.tripec.cn/index.php/test/return_test', '1025', '测试', '测试2', '1392019915', null, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)', '0');
INSERT INTO `jee_payment_bill` VALUES ('4', '20140210164320654321', '20140210164418755605', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/test/return_test', 'http://demo_v1.tripec.cn/index.php/test/return_test', '1025', '测试', '测试2', '1392021858', null, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)', '0');
INSERT INTO `jee_payment_bill` VALUES ('5', '201402081425551245677', '20140210164703726625', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/test/return_test', 'http://demo_v1.tripec.cn/index.php/test/return_test', '1025', '测试', '测试2', '1392022023', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '0');
INSERT INTO `jee_payment_bill` VALUES ('6', '201402081425551245678', '20140210165628356827', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/test/return_test', 'http://demo_v1.tripec.cn/index.php/test/return_test', '1025', '测试', '测试2', '1392022588', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '0');
INSERT INTO `jee_payment_bill` VALUES ('7', '201402081425551245679', '20140210170851408164', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/test/return_test', 'http://demo_v1.tripec.cn/index.php/test/return_test', '1025', '测试', '[url:=http://demo_v1.tripec.cn/index.php/paymentapi/autoreceive/paymentname/wangyin]', '1392023331', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '1');
INSERT INTO `jee_payment_bill` VALUES ('8', '2014020814255512456999', '20140211103023781470', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/test/return_test', 'http://demo_v1.tripec.cn/index.php/test/return_test', '1025', '测试', '[url:=http://demo_v1.tripec.cn/index.php/paymentapi/autoreceive/paymentname/wangyin]', '1392085823', null, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)', '0');
INSERT INTO `jee_payment_bill` VALUES ('9', '201402081425551245888', '20140211141302576024', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/test/return_test', 'http://demo_v1.tripec.cn/index.php/test/return_test', '327', '测试', '[url:=http://demo_v1.tripec.cn/index.php/paymentapi/autoreceive/paymentname/wangyin]', '1392099182', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('10', '20140211150003379', '20140211150006763364', '20140208', '4742.00', 'wangyin', 'http://localhost/tripec/index.php/hotel/payResult', 'http://localhost/tripec/index.php/hotel/show_payResult', '301', null, null, '1392102006', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('11', '20140211150101861', '20140211150122672203', '20140208', '4742.00', 'wangyin', 'http://localhost/tripec/index.php/hotel/payResult', 'http://localhost/tripec/index.php/hotel/show_payResult', '313', null, null, '1392102082', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('12', '20140211150304978', '20140211150325269798', '20140208', '4742.00', 'wangyin', 'http://localhost/tripec/index.php/hotel/payResult', 'http://localhost/tripec/index.php/hotel/show_payResult', '311', null, null, '1392102205', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('13', '20140211155004802', '20140211155021832591', '20140208', '4742.00', 'wangyin', 'http://localhost/tripec/index.php/hotel/payResult', 'http://localhost/tripec/index.php/hotel/show_payResult', '103', null, null, '1392105021', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('14', '20140211155141276', '20140211155155476283', '20140208', '4742.00', 'wangyin', 'http://localhost/tripec/index.php/hotel/payResult', 'http://localhost/tripec/index.php/hotel/show_payResult', '103', null, null, '1392105115', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('15', '20140211155307762', '20140211155323121097', '20140208', '4742.00', 'wangyin', 'http://localhost/tripec/index.php/hotel/payResult', 'http://localhost/tripec/index.php/hotel/show_payResult', '301', null, null, '1392105203', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('16', '20140211165718979', '20140211165728585967', '20140208', '786.00', 'wangyin', 'http://localhost/tripec/index.php/hotel/payResult', 'http://localhost/tripec/index.php/hotel/show_payResult', '329', null, null, '1392109048', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('17', '20140211173421164', '20140211173433757961', '20140208', '4742.00', 'wangyin', 'http://localhost/tripec/index.php/hotel/payResult', 'http://localhost/tripec/index.php/hotel/show_payResult', '302', null, null, '1392111273', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('18', '20140211173500244', '20140211173513830935', '20140208', '786.00', 'wangyin', 'http://localhost/tripec/index.php/hotel/payResult', 'http://localhost/tripec/index.php/hotel/show_payResult', '309', null, null, '1392111313', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('19', '20140211173730263', '20140211173733918124', '20140208', '786.00', 'wangyin', 'http://localhost/tripec/index.php/hotel/payResult', 'http://localhost/tripec/index.php/hotel/show_payResult', '1025', null, null, '1392111453', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('20', '88888888', '20140212111833724099', '20140208', '77.60', 'wangyin', 'http://127.0.0.1/tripec/index.php/paymentapi/manage', 'http://127.0.0.1/tripec/index.php/paymentapi/manage', null, null, null, '1392175113', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('21', '20140212120516786', '20140212120532735272', '20140208', '63.53', 'wangyin', 'http://localhost/tripec/index.php/hotel/payResult', 'http://localhost/tripec/index.php/hotel/show_payResult', '305', null, null, '1392177932', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('22', '20140212141216701', '20140212141223692456', '20140208', '63.53', 'wangyin', 'http://localhost/tripec/index.php/hotel/payResult', 'http://localhost/tripec/index.php/hotel/show_payResult', '327', null, null, '1392185543', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('23', '20140212150600240', '20140212150603802548', '20140208', '77.60', 'wangyin', 'http://127.0.0.1/tripec/index.php/paymentapi/manage', 'http://127.0.0.1/tripec/index.php/paymentapi/manage', '1025', null, null, '1392188764', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('24', '20140212151504893', '20140212151508474285', '20140208', '77.60', 'wangyin', 'http://127.0.0.1/tripec/index.php/paymentapi/manage', 'http://127.0.0.1/tripec/index.php/paymentapi/manage', '1025', null, null, '1392189308', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('25', '20140212154206076', '20140212154210799715', '20140208', '77.60', 'wangyin', 'http://127.0.0.1/tripec/index.php/paymentapi/manage', 'http://127.0.0.1/tripec/index.php/paymentapi/manage', '1025', null, null, '1392190930', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('26', '20140212155236381', '20140212155239020223', '20140208', '77.60', 'wangyin', 'http://127.0.0.1/index.php/lineorder/test_return', 'http://127.0.0.1/index.php/lineorder/test_return', '1025', null, null, '1392191559', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('27', '20140212171957904', '20140212173102870627', '20140208', '436.00', 'wangyin', 'http://localhost/tripec/index.php/hotel/payResult', 'http://localhost/tripec/index.php/hotel/show_payResult', '1025', null, null, '1392197462', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('28', '20140212173915734', '20140212173915742581', '20140208', '77.60', 'wangyin', 'http://127.0.0.1/index.php/lineorder/test_return', 'http://127.0.0.1/index.php/lineorder/test_return', '1025', null, null, '1392197955', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('29', '20140213094108706', '20140213094109349170', '20140208', '77.60', 'wangyin', 'http://127.0.0.1/index.php/lineorder/front', 'http://127.0.0.1/index.php/lineorder/back', '1025', null, null, '1392255669', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('30', '20140213094924011', '20140213094925321278', '20140208', '77.60', 'wangyin', 'http://127.0.0.1/index.php/lineorder/front', 'http://127.0.0.1/index.php/lineorder/back', '103', null, null, '1392256165', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('31', '20140213095045096', '20140213095047447813', '20140208', '0.01', 'wangyin', 'http://127.0.0.1/index.php/lineorder/front', 'http://127.0.0.1/index.php/lineorder/back', '103', null, null, '1392256247', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('32', '20140213110805569', '20140213110805017381', '20140208', '0.01', 'wangyin', 'http://127.0.0.1/index.php/lineorder/front', 'http://127.0.0.1/index.php/lineorder/back', '103', null, null, '1392260885', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('33', '20140213114553736', '20140213114554428162', '20140208', '0.01', 'wangyin', 'http://127.0.0.1/index.php/lineorder/front', 'http://127.0.0.1/index.php/lineorder/back', '103', null, null, '1392263154', null, 'Mozilla/5.0 (Windows NT 5.1; rv:25.0) Gecko/20100101 Firefox/25.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('34', '20140213114812369', '20140213114812238590', '20140208', '0.01', 'wangyin', 'http://127.0.0.1/index.php/lineorder/front', 'http://127.0.0.1/index.php/lineorder/back', '103', null, null, '1392263292', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.72 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('35', '201402081425551245222', '20140213115332326931', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/test/return_test', 'http://demo_v1.tripec.cn/index.php/test/return_test', '1025', '测试', '[url:=http://demo_v1.tripec.cn/index.php/paymentapi/autoreceive/paymentname/wangyin]', '1392263612', null, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; InfoPath.2; .NET4.0C; SE 2.X MetaSr 1.0)', '0');
INSERT INTO `jee_payment_bill` VALUES ('36', '201402081425551245323', '20140213115446687516', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/test/return_test', 'http://demo_v1.tripec.cn/index.php/test/return_test', '103', '测试', '[url:=http://demo_v1.tripec.cn/index.php/paymentapi/autoreceive/paymentname/wangyin]', '1392263686', null, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; InfoPath.2; .NET4.0C; SE 2.X MetaSr 1.0)', '1');
INSERT INTO `jee_payment_bill` VALUES ('37', '20140213133506486', '20140213133520537424', '20140208', '122.80', 'wangyin', 'http://localhost/tripec/index.php/hotel/payResult', 'http://localhost/tripec/index.php/hotel/show_payResult', '3241', null, null, '1392269720', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('38', '20140213141556676', '20140213141556451478', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/front', 'http://demo_v1.tripec.cn/index.php/lineorder/back', '103', null, null, '1392272156', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('39', '20140213142109918', '20140213142110517242', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/front', 'http://demo_v1.tripec.cn/index.php/lineorder/back', '103', null, null, '1392272470', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('40', '20140213154302308', '20140213154302013311', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/front', 'http://demo_v1.tripec.cn/index.php/lineorder/back', '103', null, null, '1392277382', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('41', '20140213155008618', '20140213155009884218', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1392277809', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('42', '20140213160324572', '20140213160324745658', '20140208', '480.00', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '', null, null, '1392278604', null, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('43', '20140213160604498', '20140213160605010915', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '1025', null, null, '1392278765', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('44', '20140213160613205', '20140213160613692289', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1392278773', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('45', '20140213161334646', '20140213161334094170', '20140208', '480.00', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '1025', null, null, '1392279214', null, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('46', '20140213161435506', '20140213161436120081', '20140208', '480.00', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '3230', null, null, '1392279276', null, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('47', '20140213161450057', '20140213161452537120', '20140208', '480.00', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '105', null, null, '1392279292', null, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('48', '20140213161504813', '20140213161505168691', '20140208', '480.00', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '1025', null, null, '1392279305', null, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.107 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('49', '20140213162108058', '20140213162108260890', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1392279668', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1');
INSERT INTO `jee_payment_bill` VALUES ('50', '20140213163456389', '20140213163456465787', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1392280496', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1');
INSERT INTO `jee_payment_bill` VALUES ('51', '20140213164602239', '20140213164603522689', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1392281163', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1');
INSERT INTO `jee_payment_bill` VALUES ('52', '20140213165245923', '20140213165245943201', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1392281565', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1');
INSERT INTO `jee_payment_bill` VALUES ('53', '20140213165918961', '20140213165919603578', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1392281959', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('54', '20140213170048512', '20140213170048245739', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1392282048', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1');
INSERT INTO `jee_payment_bill` VALUES ('55', '20140213171228271', '20140213171323063139', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/hotel/payResult', 'http://demo_v1.tripec.cn/index.php/hotel/show_payResult', '103', null, null, '1392282803', null, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; InfoPath.2; .NET4.0C; SE 2.X MetaSr 1.0)', '1');
INSERT INTO `jee_payment_bill` VALUES ('56', '20140213172836099', '20140213172839619204', '20140208', '200.00', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '314', null, null, '1392283719', null, 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('57', '20140213173430141', '20140213173432270953', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/hotel/payResult', 'http://demo_v1.tripec.cn/index.php/hotel/show_payResult', '1025', null, null, '1392284072', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('58', '20140213175055206', '20140213175057329875', '20140208', '-100.00', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '', null, null, '1392285058', null, 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('59', '20140214093126733', '20140214093138284376', '20140208', '502.56', 'wangyin', 'http://demo_v1.tripec.cn/index.php/hotel/payResult', 'http://demo_v1.tripec.cn/index.php/hotel/show_payResult', '104', null, null, '1392341498', null, 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('60', '20140214093403506', '20140214093323602368', '20140208', '4188.00', 'wangyin', 'http://127.0.0.1/tripec/index.php/hotel/payResult', 'http://127.0.0.1/tripec/index.php/hotel/show_payResult', '104', null, null, '1392341603', null, 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('61', '20140214111328075', '20140214111328341187', '20140208', '-100.00', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '311', null, null, '1392347608', null, 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('62', '20140214113125392', '20140214113126028708', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1392348686', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1');
INSERT INTO `jee_payment_bill` VALUES ('63', '20140225150201827', '20140225150201090675', '20140208', '151.20', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '301', null, null, '1393311721', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.72 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('64', '20140225150214445', '20140225150215927552', '20140208', '151.20', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1393311735', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.72 Safari/537.36', '0');
INSERT INTO `jee_payment_bill` VALUES ('65', '20140225152124491', '20140225152125814040', '20140208', '96.00', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '1025', null, null, '1393312885', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('66', '20140225152200326', '20140225152201763182', '20140208', '96.00', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '1025', null, null, '1393312921', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('67', '20140226162307223', '20140226162308668629', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1393402988', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1');
INSERT INTO `jee_payment_bill` VALUES ('68', '20140226163713366', '20140226163713467474', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1393403833', null, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; InfoPath.2; .NET4.0C; SE 2.X MetaSr 1.0)', '1');
INSERT INTO `jee_payment_bill` VALUES ('69', '20140226164400106', '20140226164401261300', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1393404241', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('70', '20140226164602952', '20140226164602316595', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1393404362', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('71', '20140226164719929', '20140226164719567168', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '314', null, null, '1393404439', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('72', '20140226165944616', '20140226165944815472', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1393405184', null, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; InfoPath.2; .NET4.0C; SE 2.X MetaSr 1.0)', '1');
INSERT INTO `jee_payment_bill` VALUES ('73', '20140227111027956', '20140227111027176215', '20140208', '67.60', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1393470627', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('74', '20140227111039135', '20140227111039370078', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1393470639', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1');
INSERT INTO `jee_payment_bill` VALUES ('75', '20140227141925109', '20140227141926841965', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1393481966', null, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; InfoPath.2; .NET4.0C; SE 2.X MetaSr 1.0)', '1');
INSERT INTO `jee_payment_bill` VALUES ('76', '20140227142943326', '20140227142943062251', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1393482583', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1');
INSERT INTO `jee_payment_bill` VALUES ('77', '20140227143412352', '20140227143412253423', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1393482852', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1');
INSERT INTO `jee_payment_bill` VALUES ('78', '20140227151917602', '20140227151917157870', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1393485557', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('79', '20140227152024995', '20140227152024175937', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1393485624', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1');
INSERT INTO `jee_payment_bill` VALUES ('80', '20140227153252514', '20140227153253418073', '20140208', '0.01', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '103', null, null, '1393486373', null, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; InfoPath.2; .NET4.0C; SE 2.X MetaSr 1.0)', '1');
INSERT INTO `jee_payment_bill` VALUES ('81', '20140228131136834', '20140228131143048619', '20140208', '0.01', 'wangyin', 'http://demo-v1.tripec.cn/index.php/hotel/payResult', 'http://demo-v1.tripec.cn/index.php/hotel/show_payResult', '103', null, null, '1393564303', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('82', '20140228141527196', '20140228141533566408', '20140208', '0.01', 'wangyin', 'http://demo-v1.tripec.cn/index.php/hotel/payResult', 'http://demo-v1.tripec.cn/index.php/hotel/show_payResult', '1025', null, null, '1393568133', null, 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('83', '20140310221041497', '20140310221041704691', '20140208', '200.00', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '1025', null, null, '1394460641', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0', '0');
INSERT INTO `jee_payment_bill` VALUES ('84', '20150408233809867', '20150408233809843243', '20140208', '75.60', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '1025', null, null, '1428507489', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.99 Safari/537.36 LBBROWSER', '0');
INSERT INTO `jee_payment_bill` VALUES ('85', '20150408233824041', '20150408233824373895', '20140208', '75.60', 'wangyin', 'http://demo_v1.tripec.cn/index.php/lineorder/back', 'http://demo_v1.tripec.cn/index.php/lineorder/front', '308', null, null, '1428507504', null, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.99 Safari/537.36 LBBROWSER', '0');

-- ----------------------------
-- Table structure for `jee_payment_merchant`
-- ----------------------------
DROP TABLE IF EXISTS `jee_payment_merchant`;
CREATE TABLE `jee_payment_merchant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `merchant_name` varchar(50) NOT NULL,
  `MerchantID` varchar(20) DEFAULT NULL,
  `MerchantKey` varchar(64) DEFAULT NULL,
  `api_lists` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_payment_merchant
-- ----------------------------
INSERT INTO `jee_payment_merchant` VALUES ('1', 'tripec', '20140208', 'aabbccddeeffgg', 'wangyin', '1');

-- ----------------------------
-- Table structure for `jee_recommend`
-- ----------------------------
DROP TABLE IF EXISTS `jee_recommend`;
CREATE TABLE `jee_recommend` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `obj_id` int(11) NOT NULL DEFAULT '0' COMMENT '目标项目的ID',
  `type` varchar(50) NOT NULL COMMENT '推荐项目类型（酒店、景点、路线等）',
  `rec_type` smallint(2) NOT NULL DEFAULT '1' COMMENT '推荐类型（1：特价推荐 2：热门推荐）',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '特价或热门价',
  `pic` varchar(150) NOT NULL COMMENT '图片路径',
  `content` varchar(1000) DEFAULT NULL COMMENT '推荐内容',
  `sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` smallint(2) NOT NULL DEFAULT '1' COMMENT '状态（1：前台可见 2：前台不可见）',
  `add_time` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_recommend
-- ----------------------------
INSERT INTO `jee_recommend` VALUES ('21', '14', 'HOTEL', '1', '600.00', '/Upload/images/hotel_recommend/201401/1389340548.jpg', '', '1', '1', '1389340558');
INSERT INTO `jee_recommend` VALUES ('22', '18', 'HOTEL', '2', '6600.00', '/Upload/images/hotel_recommend/201401/1389340615.jpg', '', '2', '1', '1389340622');
INSERT INTO `jee_recommend` VALUES ('23', '10', 'HOTEL', '2', '622.00', '/Upload/images/hotel_recommend/201401/1389341796.jpg', '', '4', '1', '1389341799');
INSERT INTO `jee_recommend` VALUES ('24', '20', 'HOTEL', '1', '504.00', '/Upload/images/hotel_recommend/201401/1389341819.jpg', '', '3', '1', '1389341821');
INSERT INTO `jee_recommend` VALUES ('7', '4', 'Viewpoint', '2', '520.00', '/Upload/images/hotel_recommend/201312/1387953614.jpg', '好啊好好~~', '1', '1', '1387953626');
INSERT INTO `jee_recommend` VALUES ('8', '5', 'Viewpoint', '2', '400.00', '/Upload/images/hotel_recommend/201312/1387953596.jpg', '没有内容', '5', '1', '1387953601');
INSERT INTO `jee_recommend` VALUES ('9', '7', 'Viewpoint', '2', '60.00', '/Upload/images/hotel_recommend/201312/1387953680.jpg', '这里是一大波僵尸旅馆', '4', '1', '1387953683');
INSERT INTO `jee_recommend` VALUES ('10', '8', 'Viewpoint', '2', '200.00', '/Upload/images/hotel_recommend/201312/1387953565.jpg', '来这里简直是作死！', '3', '1', '1387953568');
INSERT INTO `jee_recommend` VALUES ('11', '4', 'Viewpoint', '1', '300.00', '/Upload/images/hotel_recommend/201312/1387959260.jpg', '哈哈哈哈', '9', '1', '1387959273');
INSERT INTO `jee_recommend` VALUES ('12', '10', 'Viewpoint', '1', '322600.00', '/Upload/images/hotel_recommend/201312/1387959944.jpg', '黄圣欢后援团团长发布', '2', '1', '1387959965');
INSERT INTO `jee_recommend` VALUES ('13', '11', 'Viewpoint', '1', '200.00', '/Upload/images/hotel_recommend/201312/1387953565.jpg', '来这里简直是作死！', '3', '1', '1387953568');
INSERT INTO `jee_recommend` VALUES ('14', '12', 'Viewpoint', '1', '300.00', '/Upload/images/hotel_recommend/201312/1387959260.jpg', '哈哈哈哈', '9', '1', '1387959273');
INSERT INTO `jee_recommend` VALUES ('15', '14', 'Viewpoint', '1', '322600.00', '/Upload/images/hotel_recommend/201312/1387959944.jpg', '黄圣欢后援团团长发布', '2', '1', '1387959965');
INSERT INTO `jee_recommend` VALUES ('16', '9', 'Viewpoint', '1', '0.00', '/Upload/images/hotel_recommend/201401/1389943385.jpg', 'ds4f5ds45f441', '0', '1', '1389943387');

-- ----------------------------
-- Table structure for `jee_recreation`
-- ----------------------------
DROP TABLE IF EXISTS `jee_recreation`;
CREATE TABLE `jee_recreation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_recreation
-- ----------------------------
INSERT INTO `jee_recreation` VALUES ('1', '卡拉OK厅', '1');
INSERT INTO `jee_recreation` VALUES ('2', '健身室', '1');
INSERT INTO `jee_recreation` VALUES ('3', '按摩室', '1');
INSERT INTO `jee_recreation` VALUES ('4', '桑拿浴室', '1');
INSERT INTO `jee_recreation` VALUES ('5', '室内游泳池', '1');
INSERT INTO `jee_recreation` VALUES ('6', '夜总会送餐服务', '1');

-- ----------------------------
-- Table structure for `jee_remittance`
-- ----------------------------
DROP TABLE IF EXISTS `jee_remittance`;
CREATE TABLE `jee_remittance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `bankname` varchar(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `addtime` datetime NOT NULL,
  `memo` varchar(200) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_remittance
-- ----------------------------

-- ----------------------------
-- Table structure for `jee_role`
-- ----------------------------
DROP TABLE IF EXISTS `jee_role`;
CREATE TABLE `jee_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) DEFAULT NULL,
  `status` tinyint(1) unsigned DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_role
-- ----------------------------
INSERT INTO `jee_role` VALUES ('15', '1', null, '1', '1d');
INSERT INTO `jee_role` VALUES ('18', '1111122', null, '1', '21');

-- ----------------------------
-- Table structure for `jee_role_user`
-- ----------------------------
DROP TABLE IF EXISTS `jee_role_user`;
CREATE TABLE `jee_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_role_user
-- ----------------------------
INSERT INTO `jee_role_user` VALUES ('15', '21');
INSERT INTO `jee_role_user` VALUES ('15', '31');
INSERT INTO `jee_role_user` VALUES ('15', '25');
INSERT INTO `jee_role_user` VALUES ('15', '27');
INSERT INTO `jee_role_user` VALUES ('18', '29');
INSERT INTO `jee_role_user` VALUES ('15', '30');

-- ----------------------------
-- Table structure for `jee_seo`
-- ----------------------------
DROP TABLE IF EXISTS `jee_seo`;
CREATE TABLE `jee_seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `relate_id` int(11) DEFAULT NULL,
  `relate_table` varchar(50) DEFAULT NULL,
  `seo_title` varchar(200) DEFAULT NULL,
  `seo_keywords` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COMMENT='seo表';

-- ----------------------------
-- Records of jee_seo
-- ----------------------------
INSERT INTO `jee_seo` VALUES ('29', '20', 'article', '认证体系', '认证体系', '认证体系');
INSERT INTO `jee_seo` VALUES ('2', '3', 'notice', 'seo标题', 'seo标题,seo标题,seo标题', 'seo标题,seo标题,seo标题2222222');
INSERT INTO `jee_seo` VALUES ('3', '4', 'notice', 'seo标题', 'seo标题,seo标题,seo标题', 'sfsdfsfasfas');
INSERT INTO `jee_seo` VALUES ('16', '7', 'notice', 'seo', 'se0sseo', 'seoseo');
INSERT INTO `jee_seo` VALUES ('18', '9', 'article', '模式介绍', '模式介绍', '了解微金  品牌理念');
INSERT INTO `jee_seo` VALUES ('20', '11', 'article', '使命愿景', '使命愿景', '了解微金  品牌理念');
INSERT INTO `jee_seo` VALUES ('17', '8', 'article', '公司简介', '了解微金', '了解微金');
INSERT INTO `jee_seo` VALUES ('21', '12', 'article', '邮箱设置帮助', '邮箱设置帮助', '邮箱设置帮助');
INSERT INTO `jee_seo` VALUES ('14', '7', 'article', '测试页脚信息', '测试 页脚 信息', '测试 页脚 信息');
INSERT INTO `jee_seo` VALUES ('15', '6', 'notice', 'sesese', 'seseo', 'seseseo');
INSERT INTO `jee_seo` VALUES ('19', '10', 'article', '资金安全', '资金安全', '资金安全 品牌理念');
INSERT INTO `jee_seo` VALUES ('22', '13', 'article', '会员等级和特权', '会员等级和特权', '会员等级和特权');
INSERT INTO `jee_seo` VALUES ('23', '14', 'article', '礼金', '礼金', '礼金');
INSERT INTO `jee_seo` VALUES ('33', '2', 'notice', '1354', '354', '5');
INSERT INTO `jee_seo` VALUES ('25', '16', 'article', '如何充值', '如何充值', '如何充值');
INSERT INTO `jee_seo` VALUES ('26', '17', 'article', '封存金额', '封存金额', '封存金额');
INSERT INTO `jee_seo` VALUES ('27', '18', 'article', '用户成长体系介绍', '用户成长体系介绍', '用户成长体系介绍');
INSERT INTO `jee_seo` VALUES ('28', '19', 'article', '体系介绍', '体系介绍', '体系介绍');
INSERT INTO `jee_seo` VALUES ('30', '21', 'article', '什么是债权转让？', '债权转让', '债权转让');

-- ----------------------------
-- Table structure for `jee_seo_info`
-- ----------------------------
DROP TABLE IF EXISTS `jee_seo_info`;
CREATE TABLE `jee_seo_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `keyword` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `detail` varchar(400) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_seo_info
-- ----------------------------
INSERT INTO `jee_seo_info` VALUES ('1', 'f', 'f', 'f');
INSERT INTO `jee_seo_info` VALUES ('2', 'cfdg', 'ddf aa', 'gggd');
INSERT INTO `jee_seo_info` VALUES ('3', 'SEO标题是什么？', 'SEO关键词是什么？', 'SEO描述是什么？');

-- ----------------------------
-- Table structure for `jee_service_dinner`
-- ----------------------------
DROP TABLE IF EXISTS `jee_service_dinner`;
CREATE TABLE `jee_service_dinner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_service_dinner
-- ----------------------------
INSERT INTO `jee_service_dinner` VALUES ('1', '中餐厅', '1');
INSERT INTO `jee_service_dinner` VALUES ('2', '西餐厅', '1');
INSERT INTO `jee_service_dinner` VALUES ('3', '咖啡厅', '1');
INSERT INTO `jee_service_dinner` VALUES ('4', '大堂吧', '1');
INSERT INTO `jee_service_dinner` VALUES ('5', '酒吧', '1');
INSERT INTO `jee_service_dinner` VALUES ('6', '日式餐厅', '1');
INSERT INTO `jee_service_dinner` VALUES ('7', '限时送餐服务', '1');

-- ----------------------------
-- Table structure for `jee_service_item`
-- ----------------------------
DROP TABLE IF EXISTS `jee_service_item`;
CREATE TABLE `jee_service_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_service_item
-- ----------------------------
INSERT INTO `jee_service_item` VALUES ('1', '商务中心服务', '1');
INSERT INTO `jee_service_item` VALUES ('2', '大堂吧', '1');
INSERT INTO `jee_service_item` VALUES ('3', '礼宾服务', '1');
INSERT INTO `jee_service_item` VALUES ('4', '大堂免费报纸', '1');
INSERT INTO `jee_service_item` VALUES ('5', '多功能厅', '1');
INSERT INTO `jee_service_item` VALUES ('6', '会议厅', '1');
INSERT INTO `jee_service_item` VALUES ('7', '公共音响系统', '1');
INSERT INTO `jee_service_item` VALUES ('8', '多媒体演示系统', '1');
INSERT INTO `jee_service_item` VALUES ('9', '外币兑换', '1');
INSERT INTO `jee_service_item` VALUES ('10', '旅游票务服务', '1');
INSERT INTO `jee_service_item` VALUES ('11', '商场', '1');
INSERT INTO `jee_service_item` VALUES ('12', '洗衣服务', '1');
INSERT INTO `jee_service_item` VALUES ('13', '行李存放服务', '1');
INSERT INTO `jee_service_item` VALUES ('14', '叫醒服务', '1');
INSERT INTO `jee_service_item` VALUES ('15', '自动取款机', '1');

-- ----------------------------
-- Table structure for `jee_singly`
-- ----------------------------
DROP TABLE IF EXISTS `jee_singly`;
CREATE TABLE `jee_singly` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) NOT NULL,
  `title` varchar(36) DEFAULT NULL,
  `text` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_singly
-- ----------------------------

-- ----------------------------
-- Table structure for `jee_sms`
-- ----------------------------
DROP TABLE IF EXISTS `jee_sms`;
CREATE TABLE `jee_sms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id (当值为0时 表示发送的对象为全部会员)',
  `title` varchar(50) NOT NULL,
  `content` varchar(5000) NOT NULL,
  `sort` int(11) NOT NULL DEFAULT '1',
  `createtime` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_sms
-- ----------------------------

-- ----------------------------
-- Table structure for `jee_sms_log`
-- ----------------------------
DROP TABLE IF EXISTS `jee_sms_log`;
CREATE TABLE `jee_sms_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sms_id` int(11) DEFAULT NULL,
  `send_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `phone` char(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `content` text,
  `type` varchar(50) DEFAULT NULL,
  `code` varchar(6) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=550 DEFAULT CHARSET=utf8 COMMENT='短信发送记录';

-- ----------------------------
-- Records of jee_sms_log
-- ----------------------------
INSERT INTO `jee_sms_log` VALUES ('547', '0', null, '7', '15077166892', '1377223882', '你的提现验证码为911608,【微金担保】', 'withdraw', '911608', '1');
INSERT INTO `jee_sms_log` VALUES ('548', '0', null, '7', '15077166892', '1377223919', '你的提现验证码为234795,【微金担保】', 'withdraw', '234795', '1');
INSERT INTO `jee_sms_log` VALUES ('549', '0', null, '7', '15077166892', '1377224006', '你的提现验证码为906468,【微金担保】', 'withdraw', '906468', '2');

-- ----------------------------
-- Table structure for `jee_special_service`
-- ----------------------------
DROP TABLE IF EXISTS `jee_special_service`;
CREATE TABLE `jee_special_service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_special_service
-- ----------------------------
INSERT INTO `jee_special_service` VALUES ('1', '宽带上网', '1');
INSERT INTO `jee_special_service` VALUES ('2', '机场接送', '1');
INSERT INTO `jee_special_service` VALUES ('3', '餐厅服务', '1');
INSERT INTO `jee_special_service` VALUES ('4', '游泳池', '1');
INSERT INTO `jee_special_service` VALUES ('5', '停车场', '1');
INSERT INTO `jee_special_service` VALUES ('6', '健身室', '1');

-- ----------------------------
-- Table structure for `jee_status_type`
-- ----------------------------
DROP TABLE IF EXISTS `jee_status_type`;
CREATE TABLE `jee_status_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `status_name` varchar(64) NOT NULL COMMENT '状态名',
  `apllication_scope` varchar(64) DEFAULT NULL COMMENT '使用范围',
  `status` int(11) DEFAULT NULL COMMENT '记录状态：0禁用，1启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='状态类型表';

-- ----------------------------
-- Records of jee_status_type
-- ----------------------------
INSERT INTO `jee_status_type` VALUES ('9', '待处理', null, '1');
INSERT INTO `jee_status_type` VALUES ('1', '待付款', null, '1');
INSERT INTO `jee_status_type` VALUES ('2', '已付款', null, '1');
INSERT INTO `jee_status_type` VALUES ('3', '已取票', null, '1');
INSERT INTO `jee_status_type` VALUES ('4', '已点评', null, '1');
INSERT INTO `jee_status_type` VALUES ('5', '已结束', null, '1');
INSERT INTO `jee_status_type` VALUES ('6', '已取消', null, '1');

-- ----------------------------
-- Table structure for `jee_system_info`
-- ----------------------------
DROP TABLE IF EXISTS `jee_system_info`;
CREATE TABLE `jee_system_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `info` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_system_info
-- ----------------------------
INSERT INTO `jee_system_info` VALUES ('18', 'admin', '系统入口', '0', '1', '系统入口');
INSERT INTO `jee_system_info` VALUES ('19', 'index', '后台主页', '18', '2', '后台主页');
INSERT INTO `jee_system_info` VALUES ('20', 'index', '后台首页', '19', '3', '后台首页');
INSERT INTO `jee_system_info` VALUES ('21', 'main', 'Main页面', '19', '3', 'Main页面');
INSERT INTO `jee_system_info` VALUES ('22', 'logout', '注销登陆', '19', '3', '注销登陆');
INSERT INTO `jee_system_info` VALUES ('25', 'section', '栏目管理', '18', '2', '栏目管理');
INSERT INTO `jee_system_info` VALUES ('26', 'add', '增加栏目', '25', '3', '增加栏目');
INSERT INTO `jee_system_info` VALUES ('27', 'lists', '栏目列表', '25', '3', '栏目列表');
INSERT INTO `jee_system_info` VALUES ('28', 'ad', '广告管理', '18', '2', '广告管理');
INSERT INTO `jee_system_info` VALUES ('29', 'ad_list', '广告列表', '28', '3', '广告列表');
INSERT INTO `jee_system_info` VALUES ('30', '1', '1', '18', '2', '1');

-- ----------------------------
-- Table structure for `jee_ticket_collector`
-- ----------------------------
DROP TABLE IF EXISTS `jee_ticket_collector`;
CREATE TABLE `jee_ticket_collector` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) NOT NULL,
  `cellphone` varchar(16) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_ticket_collector
-- ----------------------------
INSERT INTO `jee_ticket_collector` VALUES ('1', 'dama', '23423423423', '7', '1');

-- ----------------------------
-- Table structure for `jee_ticket_contactor`
-- ----------------------------
DROP TABLE IF EXISTS `jee_ticket_contactor`;
CREATE TABLE `jee_ticket_contactor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_name` varchar(256) NOT NULL,
  `contact_phone` varchar(16) DEFAULT NULL,
  `contact_email` varchar(256) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_ticket_contactor
-- ----------------------------
INSERT INTO `jee_ticket_contactor` VALUES ('1', '刘杰', null, 'jeeliu@vip.qq.com', '11', '0');

-- ----------------------------
-- Table structure for `jee_ticket_type`
-- ----------------------------
DROP TABLE IF EXISTS `jee_ticket_type`;
CREATE TABLE `jee_ticket_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(64) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_ticket_type
-- ----------------------------

-- ----------------------------
-- Table structure for `jee_user`
-- ----------------------------
DROP TABLE IF EXISTS `jee_user`;
CREATE TABLE `jee_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `pay_password` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '支付密码',
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `amount` decimal(20,2) DEFAULT '0.00' COMMENT '账户余额',
  `award` decimal(13,2) NOT NULL DEFAULT '0.00',
  `create_time` int(11) DEFAULT NULL,
  `login_time` int(11) DEFAULT NULL,
  `login_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `hits` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_user
-- ----------------------------
INSERT INTO `jee_user` VALUES ('7', 'admin', '21232f297a57a5a743894a0e4a801fc3', '21232f297a57a5a743894a0e4a801fc3', '66666@qq.com', '18598765432', '6614.02', '5.00', '2014', '1428507394', '127.0.0.1', '253', '1');
INSERT INTO `jee_user` VALUES ('3', 'binge', 'eb26611c281e691251465c33c07735bd', 'eb26611c281e691251465c33c07735bd', 'binge@qq.com', '189', '0.00', '0.00', '2014', null, null, null, '1');
INSERT INTO `jee_user` VALUES ('4', 'lige', '7348db7e62dba8252569af16e5fe61a5', '7348db7e62dba8252569af16e5fe61a5', 'lige@qq.com', '189', '0.00', '0.00', '2014', null, null, null, '1');
INSERT INTO `jee_user` VALUES ('5', 'xiaoma', 'd86ac8d11918df21b8b0d4918df597f0', 'd86ac8d11918df21b8b0d4918df597f0', 'xiaoma@qq.com', '18977141727', '0.00', '0.00', '2014', null, null, null, '1');
INSERT INTO `jee_user` VALUES ('14', 'tczfyz', '5052ad3518ecdd3a9068233ce503a297', '5052ad3518ecdd3a9068233ce503a297', '20674657@qq.com', '', '0.00', '0.00', '1394590898', '1394590898', '180.153.211.190', '1', '1');
INSERT INTO `jee_user` VALUES ('11', 'jeeliu', 'ada6d0540518ab73fa55bc428c8d3683', 'ada6d0540518ab73fa55bc428c8d3683', 'jeeliu@vip.qq.com', '18977141727', '0.00', '0.00', '1393493319', '1394540624', '14.29.115.213', '3', '1');
INSERT INTO `jee_user` VALUES ('8', 'mio', '78c925a3a4b36984d1bcbbb01457eec6', 'd0d839fa8643a1be1a9c8085b68e7698', '286499261@qq.com', '', '600.00', '0.00', '1392168622', '1392168622', '127.0.0.1', '1', '1');
INSERT INTO `jee_user` VALUES ('9', 'tangguan', '93c7c8014cddd7a971affb210f7f7e95', 'a25078146bf7ae8ab684ba3b494202b4', '286499262@qq.com', '', '0.00', '30.00', '1392169470', '1430149498', '127.0.0.1', '11', '1');

-- ----------------------------
-- Table structure for `jee_user_bill`
-- ----------------------------
DROP TABLE IF EXISTS `jee_user_bill`;
CREATE TABLE `jee_user_bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `code_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `money` decimal(10,2) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `mark` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_user_bill
-- ----------------------------
INSERT INTO `jee_user_bill` VALUES ('1', '7', '20140123120647648', '108.00', '0.00', 'ODYE', '2', '1390450007');
INSERT INTO `jee_user_bill` VALUES ('2', '7', '20140123120647990', '98.00', '0.00', 'ODYH', '2', '1390450022');
INSERT INTO `jee_user_bill` VALUES ('3', '7', '20140124140052147', '234.00', '0.00', 'ODYH', '2', '1390543269');
INSERT INTO `jee_user_bill` VALUES ('4', '7', '20140126170816332', '7.00', '0.00', 'ODYE', '2', '1390727296');
INSERT INTO `jee_user_bill` VALUES ('5', '7', '20140126170816447', '917.00', '0.00', 'ODYH', '2', '1390727605');
INSERT INTO `jee_user_bill` VALUES ('6', '7', '20140126172318882', '720.00', '0.00', 'ODYH', '2', '1390728208');
INSERT INTO `jee_user_bill` VALUES ('7', '7', '20140205145322361', '170.00', '0.00', 'ODYH', '2', '1391583220');
INSERT INTO `jee_user_bill` VALUES ('8', '7', '20140205150329721', '174.00', '0.00', 'ODYH', '2', '1391583971');
INSERT INTO `jee_user_bill` VALUES ('9', '7', '20140205152304154', '234.00', '0.00', 'ODYH', '2', '1391585000');
INSERT INTO `jee_user_bill` VALUES ('10', '7', '20140212151504893', '77.60', '0.00', 'LINE', '0', '1392189305');
INSERT INTO `jee_user_bill` VALUES ('11', '7', '20140212153711235', '77.60', '0.00', 'LINE', '0', '1392190631');
INSERT INTO `jee_user_bill` VALUES ('12', '7', '20140212154002432', '77.60', '0.00', 'LINE', '0', '1392190802');
INSERT INTO `jee_user_bill` VALUES ('13', '7', '20140212154206076', '77.60', '0.00', 'LINE', '0', '1392190927');
INSERT INTO `jee_user_bill` VALUES ('14', '7', '20140212155236381', '77.60', '0.00', 'LINE', '0', '1392191556');
INSERT INTO `jee_user_bill` VALUES ('15', '9', '20140212161337958', '32.00', '0.00', 'ODYE', '2', '1392192817');
INSERT INTO `jee_user_bill` VALUES ('16', '9', '20140212161811366', '63.00', '0.00', 'ODYE', '2', '1392193091');
INSERT INTO `jee_user_bill` VALUES ('17', '9', '20140212162032970', '63.00', '0.00', 'ODYE', '2', '1392193232');
INSERT INTO `jee_user_bill` VALUES ('18', '9', '20140212162100910', '302.40', '662.60', 'ODYE', '2', '1392193260');
INSERT INTO `jee_user_bill` VALUES ('19', '9', '20140212171409298', '23.00', '0.00', 'ODYE', '2', '1392196450');
INSERT INTO `jee_user_bill` VALUES ('20', '9', '20140212171847427', '16.00', '0.00', 'ODYE', '2', '1392196727');
INSERT INTO `jee_user_bill` VALUES ('21', '9', '20140212171957560', '83.00', '0.00', 'ODYE', '2', '1392196797');
INSERT INTO `jee_user_bill` VALUES ('22', '7', '20140212173915734', '77.60', '0.00', 'LINE', '0', '1392197955');
INSERT INTO `jee_user_bill` VALUES ('23', '7', '20140213094108706', '77.60', '0.00', 'LINE', '0', '1392255669');
INSERT INTO `jee_user_bill` VALUES ('24', '7', '20140213094924011', '77.60', '0.00', 'LINE', '0', '1392256164');
INSERT INTO `jee_user_bill` VALUES ('25', '7', '20140213095045096', '0.01', '0.00', 'LINE', '0', '1392256245');
INSERT INTO `jee_user_bill` VALUES ('26', '7', '20140213103220416', '0.01', '0.00', 'LINE', '0', '1392258740');
INSERT INTO `jee_user_bill` VALUES ('27', '7', '20140213110805569', '0.01', '0.00', 'LINE', '0', '1392260885');
INSERT INTO `jee_user_bill` VALUES ('28', '7', '20140213114553736', '0.01', '0.00', 'LINE', '0', '1392263153');
INSERT INTO `jee_user_bill` VALUES ('29', '7', '20140213114812369', '0.01', '0.00', 'LINE', '0', '1392263292');
INSERT INTO `jee_user_bill` VALUES ('30', '7', '20140213141556676', '0.01', '0.00', 'LINE', '0', '1392272156');
INSERT INTO `jee_user_bill` VALUES ('31', '7', '20140213141625560', '0.01', '0.00', 'LINE', '0', '1392272185');
INSERT INTO `jee_user_bill` VALUES ('32', '7', '20140213142109918', '0.01', '0.00', 'LINE', '0', '1392272469');
INSERT INTO `jee_user_bill` VALUES ('33', '7', '20140213154302308', '0.01', '0.00', 'LINE', '0', '1392277382');
INSERT INTO `jee_user_bill` VALUES ('34', '7', '20140213155008618', '0.01', '0.00', 'LINE', '0', '1392277808');
INSERT INTO `jee_user_bill` VALUES ('35', '7', '20140213160324572', '480.00', '0.00', 'LINE', '0', '1392278604');
INSERT INTO `jee_user_bill` VALUES ('36', '7', '20140213160604498', '0.01', '0.00', 'LINE', '0', '1392278764');
INSERT INTO `jee_user_bill` VALUES ('37', '7', '20140213160613205', '0.01', '0.00', 'LINE', '0', '1392278773');
INSERT INTO `jee_user_bill` VALUES ('38', '7', '20140213161334646', '480.00', '0.00', 'LINE', '0', '1392279214');
INSERT INTO `jee_user_bill` VALUES ('39', '7', '20140213161435506', '480.00', '0.00', 'LINE', '0', '1392279275');
INSERT INTO `jee_user_bill` VALUES ('40', '7', '20140213161450057', '480.00', '0.00', 'LINE', '0', '1392279291');
INSERT INTO `jee_user_bill` VALUES ('41', '7', '20140213161504813', '480.00', '0.00', 'LINE', '0', '1392279305');
INSERT INTO `jee_user_bill` VALUES ('42', '7', '20140213162108058', '0.01', '0.00', 'LINE', '0', '1392279668');
INSERT INTO `jee_user_bill` VALUES ('43', '7', '20140213163456389', '0.01', '0.00', 'LINE', '0', '1392280496');
INSERT INTO `jee_user_bill` VALUES ('44', '7', '20140213164602239', '0.01', '0.00', 'LINE', '0', '1392281163');
INSERT INTO `jee_user_bill` VALUES ('45', '7', '20140213165245923', '0.01', '0.00', 'LINE', '0', '1392281565');
INSERT INTO `jee_user_bill` VALUES ('46', '7', '20140213165918961', '0.01', '0.00', 'LINE', '0', '1392281958');
INSERT INTO `jee_user_bill` VALUES ('47', '7', '20140213170048512', '0.01', '0.00', 'LINE', '0', '1392282048');
INSERT INTO `jee_user_bill` VALUES ('48', '7', '20140213171228271', '0.01', '6614.02', 'ODYH', '2', '1392282800');
INSERT INTO `jee_user_bill` VALUES ('49', '7', '20140213172836099', '200.00', '0.00', 'LINE', '0', '1392283716');
INSERT INTO `jee_user_bill` VALUES ('50', '7', '20140213175055206', '-100.00', '0.00', 'LINE', '0', '1392285055');
INSERT INTO `jee_user_bill` VALUES ('51', '7', '20140214110049460', '0.01', '0.00', 'LINE', '0', '1392346850');
INSERT INTO `jee_user_bill` VALUES ('52', '7', '20140214110156115', '0.01', '0.00', 'LINE', '0', '1392346916');
INSERT INTO `jee_user_bill` VALUES ('53', '7', '20140214110358447', '0.01', '0.00', 'LINE', '0', '1392347038');
INSERT INTO `jee_user_bill` VALUES ('54', '7', '20140214111328075', '-100.00', '0.00', 'LINE', '0', '1392347608');
INSERT INTO `jee_user_bill` VALUES ('55', '7', '20140214112745862', '0.01', '0.00', 'LINE', '0', '1392348465');
INSERT INTO `jee_user_bill` VALUES ('56', '7', '20140214113125392', '0.01', '0.00', 'LINE', '0', '1392348685');
INSERT INTO `jee_user_bill` VALUES ('57', '7', '20140225150201827', '151.20', '0.00', 'LINE', '0', '1393311721');
INSERT INTO `jee_user_bill` VALUES ('58', '7', '20140225150214445', '151.20', '0.00', 'LINE', '0', '1393311734');
INSERT INTO `jee_user_bill` VALUES ('59', '7', '20140225152124491', '96.00', '0.00', 'LINE', '0', '1393312884');
INSERT INTO `jee_user_bill` VALUES ('60', '7', '20140225152200326', '96.00', '0.00', 'LINE', '0', '1393312920');
INSERT INTO `jee_user_bill` VALUES ('61', '7', '20140226162307223', '0.01', '0.00', 'LINE', '0', '1393402987');
INSERT INTO `jee_user_bill` VALUES ('62', '7', '20140226163713366', '0.01', '0.00', 'LINE', '0', '1393403833');
INSERT INTO `jee_user_bill` VALUES ('63', '7', '20140226164400106', '0.01', '0.00', 'LINE', '0', '1393404240');
INSERT INTO `jee_user_bill` VALUES ('64', '7', '20140226164602952', '0.01', '0.00', 'LINE', '0', '1393404362');
INSERT INTO `jee_user_bill` VALUES ('65', '7', '20140226164719929', '0.01', '0.00', 'LINE', '0', '1393404439');
INSERT INTO `jee_user_bill` VALUES ('66', '7', '20140226165944616', '0.01', '0.00', 'LINE', '0', '1393405184');
INSERT INTO `jee_user_bill` VALUES ('67', '7', '20140227111027956', '67.60', '0.00', 'LINE', '0', '1393470627');
INSERT INTO `jee_user_bill` VALUES ('68', '7', '20140227111039135', '0.01', '0.00', 'LINE', '0', '1393470639');
INSERT INTO `jee_user_bill` VALUES ('69', '7', '20140227141925109', '0.01', '0.00', 'LINE', '0', '1393481965');
INSERT INTO `jee_user_bill` VALUES ('70', '7', '20140227142943326', '0.01', '0.00', 'LINE', '0', '1393482583');
INSERT INTO `jee_user_bill` VALUES ('71', '7', '20140227143412352', '0.01', '0.00', 'LINE', '0', '1393482852');
INSERT INTO `jee_user_bill` VALUES ('72', '7', '20140227151917602', '0.01', '0.00', 'LINE', '0', '1393485557');
INSERT INTO `jee_user_bill` VALUES ('73', '7', '20140227152024995', '0.01', '0.00', 'LINE', '0', '1393485624');
INSERT INTO `jee_user_bill` VALUES ('74', '7', '20140227153252514', '0.01', '0.00', 'LINE', '0', '1393486372');
INSERT INTO `jee_user_bill` VALUES ('75', '11', '20140310221041497', '200.00', '0.00', 'LINE', '0', '1394460641');
INSERT INTO `jee_user_bill` VALUES ('76', '7', '20150408233809867', '75.60', '0.00', 'LINE', '0', '1428507489');
INSERT INTO `jee_user_bill` VALUES ('77', '7', '20150408233824041', '75.60', '0.00', 'LINE', '0', '1428507504');

-- ----------------------------
-- Table structure for `jee_user_info`
-- ----------------------------
DROP TABLE IF EXISTS `jee_user_info`;
CREATE TABLE `jee_user_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `true_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `identity_no` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `avatar_path` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `tel` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `address` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `post_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `industry` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `education` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `income` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `marital_status` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_user_info
-- ----------------------------

-- ----------------------------
-- Table structure for `jee_user_recharge`
-- ----------------------------
DROP TABLE IF EXISTS `jee_user_recharge`;
CREATE TABLE `jee_user_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `code_id` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '流水号',
  `money` decimal(10,2) NOT NULL COMMENT '充值金额',
  `api_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '接口名称',
  `bank_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '银行代号',
  `browser` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '客户端信息',
  `start_time` int(11) NOT NULL COMMENT '发起充值时间',
  `finish_time` int(11) NOT NULL COMMENT '完成充值时间',
  `status` smallint(6) NOT NULL COMMENT '状态：1：充值成功 2：充值失败 0：等待处理',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=122 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_user_recharge
-- ----------------------------
INSERT INTO `jee_user_recharge` VALUES ('1', '1', '7', '20140123120647990', '98.00', '20001', '10006', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.76 Safari/537.36', '1390450007', '0', '1');
INSERT INTO `jee_user_recharge` VALUES ('2', '2', '7', '20140124140052147', '234.00', '20001', '10006', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.76 Safari/537.36', '1390543252', '0', '1');
INSERT INTO `jee_user_recharge` VALUES ('3', '6', '7', '20140126170816447', '917.00', '20001', '10008', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1390727296', '0', '1');
INSERT INTO `jee_user_recharge` VALUES ('4', '3', '7', '20140126172318882', '720.00', '20000', '10002', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1390728198', '0', '1');
INSERT INTO `jee_user_recharge` VALUES ('5', '9', '7', '20140205145322361', '170.00', '20000', '10003', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1391583202', '0', '1');
INSERT INTO `jee_user_recharge` VALUES ('6', '8', '7', '20140205150304344', '174.00', '20000', '10001', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1391583784', '0', '1');
INSERT INTO `jee_user_recharge` VALUES ('7', '8', '7', '20140205150329721', '174.00', '20000', '10005', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1391583809', '0', '1');
INSERT INTO `jee_user_recharge` VALUES ('8', '4', '7', '20140205151506653', '234.00', '20001', '10010', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1391584506', '0', '1');
INSERT INTO `jee_user_recharge` VALUES ('9', '4', '7', '20140205151552269', '234.00', '20000', '10001', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1391584552', '0', '1');
INSERT INTO `jee_user_recharge` VALUES ('10', '4', '7', '20140205151704285', '234.00', '20000', '10005', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1391584624', '0', '1');
INSERT INTO `jee_user_recharge` VALUES ('11', '4', '7', '20140205152304154', '234.00', '20000', '10002', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1391584984', '0', '1');
INSERT INTO `jee_user_recharge` VALUES ('12', '10', '7', '20140211143020511', '4742.00', 'wangyin', '305', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392100220', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('13', '10', '7', '20140211144526886', '4742.00', 'wangyin', '301', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392101126', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('14', '10', '7', '20140211144640975', '4742.00', 'wangyin', '301', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392101200', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('15', '10', '7', '20140211145135474', '4742.00', 'wangyin', '301', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392101495', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('16', '10', '7', '20140211145201871', '4742.00', 'wangyin', '301', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392101521', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('17', '10', '7', '20140211145242813', '4742.00', 'wangyin', '301', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392101562', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('18', '10', '7', '20140211145824922', '4742.00', 'wangyin', '312', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392101904', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('19', '10', '7', '20140211150003379', '4742.00', 'wangyin', '301', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392102003', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('20', '10', '7', '20140211150101861', '4742.00', 'wangyin', '313', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392102061', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('21', '10', '7', '20140211150304978', '4742.00', 'wangyin', '311', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392102184', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('22', '10', '7', '20140211154821579', '4742.00', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392104901', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('23', '10', '7', '20140211155004802', '4742.00', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392105004', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('24', '10', '7', '20140211155141276', '4742.00', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392105101', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('25', '10', '7', '20140211155307762', '4742.00', 'wangyin', '301', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392105187', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('26', '11', '7', '20140211165718979', '786.00', 'wangyin', '329', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392109038', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('27', '10', '7', '20140211173421164', '4742.00', 'wangyin', '302', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392111261', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('28', '11', '7', '20140211173500244', '786.00', 'wangyin', '309', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392111300', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('29', '11', '7', '20140211173730263', '786.00', 'wangyin', '1025', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392111450', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('30', '13', '9', '20140212120516786', '63.53', 'wangyin', '305', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392177916', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('31', '13', '9', '20140212141216701', '63.53', 'wangyin', '327', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392185536', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('32', '15', '9', '20140212171410812', '182.80', 'wangyin', '311', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392196450', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('33', '15', '9', '20140212171847362', '189.80', 'wangyin', '301', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392196727', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('34', '15', '9', '20140212171957904', '436.00', 'wangyin', '1025', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392196797', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('35', '15', '9', '20140213133506486', '122.80', 'wangyin', '3241', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.27 Safari/537.36', '1392269706', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('36', '1', '7', '20140213171228271', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1392282748', '0', '1');
INSERT INTO `jee_user_recharge` VALUES ('37', '19', '2', '20140213173222914', '0.01', 'wangyin', '1025', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0', '1392283942', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('38', '19', '2', '20140213173430141', '0.01', 'wangyin', '1025', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:27.0) Gecko/20100101 Firefox/27.0', '1392284070', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('39', '18', '7', '20140214093126733', '502.56', 'wangyin', '104', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392341486', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('40', '18', '7', '20140214093403506', '4188.00', 'wangyin', '104', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392341643', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('41', '17', '7', '20140214093525950', '4188.00', 'wangyin', '302', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392341725', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('42', '17', '7', '20140214093717247', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392341837', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('43', '17', '7', '20140214093724433', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392341844', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('44', '17', '7', '20140214094250141', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392342170', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('45', '17', '7', '20140214094459674', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392342299', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('46', '17', '7', '20140214094507384', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392342307', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('47', '17', '7', '20140214094700744', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392342420', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('48', '17', '7', '20140214094825724', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392342505', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('49', '17', '7', '20140214094847166', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392342527', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('50', '17', '7', '20140214095109458', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392342669', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('51', '17', '7', '20140214095359832', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392342839', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('52', '17', '7', '20140214095605581', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392342965', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('53', '17', '7', '20140214095625773', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392342985', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('54', '17', '7', '20140214095924405', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392343164', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('55', '17', '7', '20140214100530473', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392343530', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('56', '17', '7', '20140214100601239', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392343561', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('57', '17', '7', '20140214100617228', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392343577', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('58', '17', '7', '20140214100645166', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392343605', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('59', '17', '7', '20140214100924729', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392343764', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('60', '17', '7', '20140214100945757', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392343785', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('61', '17', '7', '20140214101002605', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392343802', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('62', '17', '7', '20140214101018228', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392343818', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('63', '17', '7', '20140214101044143', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392343844', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('64', '17', '7', '20140214101100902', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392343860', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('65', '17', '7', '20140214101117760', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392343877', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('66', '17', '7', '20140214101216129', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392343936', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('67', '17', '7', '20140214101451667', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344091', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('68', '17', '7', '20140214101600388', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344160', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('69', '17', '7', '20140214101639598', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344199', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('70', '17', '7', '20140214101709547', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344229', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('71', '17', '7', '20140214101758809', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344278', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('72', '17', '7', '20140214101813487', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344293', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('73', '17', '7', '20140214101828555', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344308', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('74', '17', '7', '20140214101840353', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344320', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('75', '17', '7', '20140214101926338', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344366', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('76', '17', '7', '20140214101943821', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344383', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('77', '17', '7', '20140214102431978', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344671', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('78', '17', '7', '20140214102529290', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344729', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('79', '17', '7', '20140214102655316', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344815', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('80', '17', '7', '20140214102735902', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344855', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('81', '17', '7', '20140214102758607', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344878', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('82', '17', '7', '20140214102919142', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344959', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('83', '17', '7', '20140214102953720', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392344993', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('84', '17', '7', '20140214103210587', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392345130', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('85', '17', '7', '20140214103228788', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392345148', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('86', '17', '7', '20140214103249368', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392345169', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('87', '17', '7', '20140214103326129', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392345206', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('88', '17', '7', '20140214103351568', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392345231', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('89', '17', '7', '20140214103406263', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392345246', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('90', '17', '7', '20140214103611924', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392345371', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('91', '17', '7', '20140214103626507', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392345386', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('92', '17', '7', '20140214103708766', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392345428', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('93', '17', '7', '20140214103721969', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392345441', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('94', '17', '7', '20140214103750735', '4188.00', 'wangyin', '3112', 'Mozilla/5.0 (Windows NT 5.1; rv:26.0) Gecko/20100101 Firefox/26.0', '1392345470', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('95', '33', '7', '20140214110049460', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1392346850', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('96', '33', '7', '20140214110156115', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1392346916', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('97', '33', '7', '20140214110358447', '0.01', 'wangyin', '104', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1392347038', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('98', '33', '7', '20140214112745862', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1392348466', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('99', '33', '7', '20140214113125392', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1392348685', '1392348719', '1');
INSERT INTO `jee_user_recharge` VALUES ('100', '39', '7', '20140226165944616', '0.01', 'wangyin', '103', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; InfoPath.2; .NET4.0C; SE 2.X MetaSr 1.0)', '1393405184', '1393405222', '1');
INSERT INTO `jee_user_recharge` VALUES ('101', '42', '7', '20140227111027956', '67.60', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393470627', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('102', '42', '7', '20140227111039135', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393470639', '1393470924', '1');
INSERT INTO `jee_user_recharge` VALUES ('103', '43', '7', '20140227141925109', '0.01', 'wangyin', '103', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; InfoPath.2; .NET4.0C; SE 2.X MetaSr 1.0)', '1393481965', '1393482045', '1');
INSERT INTO `jee_user_recharge` VALUES ('104', '44', '7', '20140227142943326', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393482583', '1393482622', '1');
INSERT INTO `jee_user_recharge` VALUES ('105', '45', '7', '20140227143412352', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393482852', '1393482886', '1');
INSERT INTO `jee_user_recharge` VALUES ('106', '49', '7', '20140227151917602', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393485557', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('107', '49', '7', '20140227152024995', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393485624', '1393485665', '1');
INSERT INTO `jee_user_recharge` VALUES ('108', '52', '7', '20140227153252514', '0.01', 'wangyin', '103', 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; InfoPath.2; .NET4.0C; SE 2.X MetaSr 1.0)', '1393486372', '1393486418', '1');
INSERT INTO `jee_user_recharge` VALUES ('109', '30', '7', '20140228114920552', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393559360', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('110', '30', '7', '20140228120349189', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393560229', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('111', '30', '7', '20140228120414324', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393560254', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('112', '30', '7', '20140228125406657', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393563246', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('113', '30', '7', '20140228125514358', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393563314', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('114', '30', '7', '20140228125933536', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393563573', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('115', '30', '7', '20140228125947955', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393563587', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('116', '30', '7', '20140228130135847', '0.01', 'wangyin', '1025', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393563695', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('117', '30', '7', '20140228130205188', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393563725', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('118', '30', '7', '20140228131136834', '0.01', 'wangyin', '103', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393564296', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('119', '30', '7', '20140228141527196', '0.01', 'wangyin', '1025', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17 SE 2.X MetaSr 1.0', '1393568127', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('120', '54', '7', '20150408233809867', '75.60', 'wangyin', '1025', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.99 Safari/537.36 LBBROWSER', '1428507489', '0', '0');
INSERT INTO `jee_user_recharge` VALUES ('121', '54', '7', '20150408233824041', '75.60', 'wangyin', '308', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.99 Safari/537.36 LBBROWSER', '1428507504', '0', '0');

-- ----------------------------
-- Table structure for `jee_user_tmp`
-- ----------------------------
DROP TABLE IF EXISTS `jee_user_tmp`;
CREATE TABLE `jee_user_tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_user_tmp
-- ----------------------------
INSERT INTO `jee_user_tmp` VALUES ('45', 'jeeliu', 'jeeliu@vip.qq.com', 'ada6d0540518ab73fa55bc428c8d3683', '1393493184');
INSERT INTO `jee_user_tmp` VALUES ('36', 'dama_test_3', 'maruiming2010@qq.com', '9b84b555bac7ad2ca5159daf03072a74', '1391674129');
INSERT INTO `jee_user_tmp` VALUES ('35', 'dama_test_3', 'maruuiming2010@qq.com', '9b84b555bac7ad2ca5159daf03072a74', '1391674045');
INSERT INTO `jee_user_tmp` VALUES ('38', 'tangguan', '286499262@qq.com', 'a25078146bf7ae8ab684ba3b494202b4', '1392169445');
INSERT INTO `jee_user_tmp` VALUES ('61', 'admin123', '286136168@qq.com', '8bb44997f672371e821680078fb84369', '1393566697');
INSERT INTO `jee_user_tmp` VALUES ('62', 'tczfyz', '20674657@qq.com', '5052ad3518ecdd3a9068233ce503a297', '1394589086');

-- ----------------------------
-- Table structure for `jee_viewpoint`
-- ----------------------------
DROP TABLE IF EXISTS `jee_viewpoint`;
CREATE TABLE `jee_viewpoint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `names` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `seo_id` int(11) DEFAULT '0',
  `city_id` int(11) DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  `view_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `fit_person` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `pic` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `tickets_address` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `contact` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `view_info` varchar(2000) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `traffic_info` varchar(2000) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `order_info` varchar(2000) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `buy_info` varchar(2000) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `position` varchar(21) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL COMMENT '经纬度坐标',
  `special_shopping` varchar(2000) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `special_food` varchar(2000) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `hits` int(11) NOT NULL DEFAULT '0',
  `property` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of jee_viewpoint
-- ----------------------------
INSERT INTO `jee_viewpoint` VALUES ('4', '锡林郭勒克什克腾旗草原', '0', '462', '3', null, null, '/Upload/images/articles/201504/1429918759.jpg', '售票窗口', null, '<span class=\"\\&quot;\\\\&quot;\\\\\\\\\\\\&quot;\\&quot;\" font_orange\\\\\\\\\\\\\\\"\\\\\\\"=\"\\&quot;\\\\&quot;\\\\&quot;\\&quot;\"><b>居庸关特色景观——云台</b></span> <span class=\"\\&quot;\\\\&quot;\\\\\\\\\\\\&quot;\\&quot;\" font_brown\\\\\\\\\\\\\\\"\\\\\\\"=\"\\&quot;\\\\&quot;\\\\&quot;\\&quot;\">居庸关是万里长城最负盛名的雄关之一，其地绝险，自古即为北京西北的屏障。居庸关建在一条崇山夹峙，长达约20公里的沟谷之中，这条沟谷就是京畿著名的\\\\\\\\\\\\\\\" 关沟\\\\\\\\\\\\\\\"。\r\n          居庸关城两侧皆高山耸立，峭壁陡不可攀，关城雄踞其中，扼控着南下北京的通 道。这种绝险的地势，决定了它在军事上的重要性，古代军事家，称其为\\\\\\\\\\\\\\\"控扼南北之古今 巨防\\\\\\\\\\\\\\\"。唐代边塞诗人高适，在描叙居庸关路险关雄时写道：\\\\\\\\\\\\\\\"绝坡水连下，群峰云其高。\\\\\\\\\\\\\\\"</span>', null, '1.景区开放时间 旺季：4月1日—10月31日08:00—17:00     淡季：11月1日—次年3月31日8:30—16:00<br />\r\n      2.取票地点：2号停车场售票处<br />\r\n      3.特殊人群预订标准：<br />\r\n      A.免费政策：1.2米以下儿童免票；离休人员凭离休证免票；北京市户籍65岁以上老年人持红色优待卡免票（大型活动期间除外）；残疾人员凭有效证件免票<br />', null, '108.393918,22.81234', null, '', '4', '0', '1', '4');
INSERT INTO `jee_viewpoint` VALUES ('5', '呼和浩特草原沙漠', '0', '462', '3', null, null, '/Upload/images/articles/201504/1430166403.jpg', null, null, '居庸关城两侧皆高山耸立，峭壁陡不可攀，关城雄踞其中，扼控着南下北京的通 道。这种绝险的地势，决定了它在军事上的重要性，古代军事家，称其为\"控扼南北之古今 巨防\"。唐代边塞诗人高适，在描叙居庸关路险关雄时写道：\"绝坡水连下，群峰云其高。\"', null, '<span>居庸关城两侧皆高山耸立，峭壁陡不可攀，关城雄踞其中，扼控着南下北京的通 道。这种绝险的地势，决定了它在军事上的重要性，古代军事家，称其为\\\"控扼南北之古今 巨防\\\"。唐代边塞诗人高适，在描叙居庸关路险关雄时写道：\\\"绝坡水连下，群峰云其高。\\\"</span>', null, '116.593675,40.015618', null, '<span>居庸关城两侧皆高山耸立，峭壁陡不可攀，关城雄踞其中，扼控着南下北京的通 道。这种绝险的地势，决定了它在军事上的重要性，古代军事家，称其为\\\"控扼南北之古今 巨防\\\"。唐代边塞诗人高适，在描叙居庸关路险关雄时写道：\\\"绝坡水连下，群峰云其高。\\\"</span>', '1', '0', '2', '4');
INSERT INTO `jee_viewpoint` VALUES ('7', '呼伦贝尔草原沙漠原始森林', '0', '462', '5', null, null, '/Upload/images/articles/201504/1429918576.jpg', '', null, '', null, null, null, '108.361049,22.81195', null, '', '2', '0', '3', '4');
INSERT INTO `jee_viewpoint` VALUES ('9', '额济纳胡杨林', '0', '462', '2', null, null, '/Upload/images/articles/201504/1429918768.jpg', '', null, '', null, null, null, '108.393817,22.795802', null, '', '5', '0', '4', '2');
INSERT INTO `jee_viewpoint` VALUES ('10', '石门森林公园1', '0', '462', '2', null, null, '/Upload/images/articles/201504/1429993046.jpg', '', null, '', '', null, '', '108.393918,22.81234', '', '', '7', '0', '5', '2');
INSERT INTO `jee_viewpoint` VALUES ('11', '武鸣花花大世界', '0', '462', '3', '7', '5,7', '', '', '', '', '', null, '', '108.284255,23.013051', '', '', '6', '0', '6', '2');
INSERT INTO `jee_viewpoint` VALUES ('12', '龙脊梯田', '0', '462', '2', '6', '5', '', '', '', '', '', null, '', '110.054458,25.782666', '', '', '8', '0', '7', '2');
INSERT INTO `jee_viewpoint` VALUES ('14', '杭州西湖', '0', '330', '2', null, null, '', '', null, '', '', null, '', '120.134145,30.266483', '', '', '9', '0', '8', '3');
INSERT INTO `jee_viewpoint` VALUES ('16', '大圩', '0', '462', '2', '6', '3', '', '', '', '山好水好，风景更好！可以让你回味无穷~~！', '', null, '', '110.34038,25.178177', '', '', '10', '0', '9', '3');
INSERT INTO `jee_viewpoint` VALUES ('13', '广西大学', '0', '462', '2', '4', '', '', '', '', '人美声甜，学校风气浓重，氛围好。美女多！', '', '', '', '108.393817,22.795802', '', '', '11', '0', '10', '3');
INSERT INTO `jee_viewpoint` VALUES ('24', '嘉和城温泉谷', '0', '462', '2', null, null, '/Upload/images/articles/201504/1429993106.jpg', '景区售票处', null, '<p>\r\n	<span style=\"\\\" color:#333333;font-family:arial,\"=\"\" sans-serif;font-size:12px;background-color:#ffffff;\\\"=\"\">嘉和城温泉谷位于南宁市东北方向南梧大道嘉和城内，距离南宁国际会展中心约13公里，连接国际锦标级18洞嘉和城温泉高尔夫球场，由广西嘉和置业集团有限公司投资兴建，是嘉和休闲旅游产业链的龙头项目。总投资约5亿元人民币，分三期建设。首期建成的温泉休闲中心占地600亩，是依据第四代温泉全新理念设计，打造动静结合，集多国风情的温泉休闲疗养、水上乐园、温泉SPA、温泉泳池、商务雅苑、餐饮、康体等为一体的大型复合温泉休闲中心，让人们不出国门就能在家门口享受世界各地著名温泉精粹的顶级温泉。</span> \r\n</p>\r\n<p>\r\n	<span style=\"\\\" color:#333333;font-family:arial,\"=\"\" sans-serif;font-size:12px;background-color:#ffffff;\\\"=\"\"><br />\r\n</span> \r\n</p>\r\n<p>\r\n	<span style=\"\\\" color:#333333;font-family:arial,\"=\"\" sans-serif;font-size:12px;background-color:#ffffff;\\\"=\"\"><br />\r\n</span> \r\n</p>', '', null, '<div class=\\\"left_con_r_b\\\" style=\\\"padding:0px 20px;color:#333333;font-family:Arial, sans-serif;font-size:12px;\\\">\r\n	<div class=\\\"clearfix\\\">\r\n		<span class=\\\"left_con_float\\\"><b>1.开放时间:</b></span><span class=\\\"left_con_float\\\">\r\n		<p>\r\n			9:30—24:00。夜场票时间 （19:00—24:00）\r\n		</p>\r\n</span>\r\n	</div>\r\n</div>\r\n<div class=\\\"left_con_r_b\\\" style=\\\"padding:0px 20px;color:#333333;font-family:Arial, sans-serif;font-size:12px;\\\">\r\n	<div class=\\\"clearfix\\\">\r\n		<span class=\\\"left_con_float\\\"><b>2.取票地点:</b></span><span class=\\\"left_con_float\\\">景区售票处。<span style=\\\"color:#FF0000;\\\"><br />\r\n</span></span>\r\n	</div>\r\n</div>\r\n<div class=\\\"left_con_r_b\\\" style=\\\"padding:0px 20px;color:#333333;font-family:Arial, sans-serif;font-size:12px;\\\">\r\n	<div class=\\\"clearfix\\\">\r\n		<span class=\\\"left_con_float\\\"><b>3.入园凭证:</b></span><span class=\\\"left_con_float\\\">\r\n		<p>\r\n			<span style=\\\"font-family:Verdana, Arial;\\\">游玩当天凭同程网预订成功短信，到取票点报4位数确认码或手机号码换票入园。</span>\r\n		</p>\r\n</span>\r\n	</div>\r\n</div>\r\n<div class=\\\"left_con_r_b\\\" style=\\\"padding:0px 20px;color:#333333;font-family:Arial, sans-serif;font-size:12px;\\\">\r\n	<div class=\\\"clearfix\\\">\r\n		<span class=\\\"left_con_float\\\"><b>4.特惠政策:</b></span><span class=\\\"left_con_float\\\">\r\n		<p>\r\n			免费政策：儿童1.4米以下（不含1.4米）免票,\r\n		</p>\r\n		<p>\r\n			优惠政策：1.4米以上（含1.4米）按成人收取；景区无老年票，学生票。\r\n		</p>\r\n</span>\r\n	</div>\r\n</div>\r\n<div class=\\\"left_con_r_b\\\" style=\\\"padding:0px 20px;color:#333333;font-family:Arial, sans-serif;font-size:12px;\\\">\r\n	<div class=\\\"clearfix\\\">\r\n		<span class=\\\"left_con_float\\\"><b>5.退改规则:</b></span><span class=\\\"left_con_float\\\">\r\n		<p>\r\n			<span style=\\\"font-size:9pt;\\\">在线支付：<br />\r\n1、改期：如需修改订单，请在游玩日期的前一天下午15:30点之前致电同程网客服。<br />\r\n2、在线支付景点，预定付款后未使用的订单，均支持随时退款、过期退款、全额退款。退款方式：致电同程网 4007 777 777转3，申请退款退票处理。<br />\r\n3、客人提出退款申请后，同程网工作人员将在3个工作日内进行审核；审核通过后，同程将为您进行退款。退款申请将在2个工作日内提交至银行，各银行会根据其业务流程，在7-10个工作日内退款至您的支付账户。请您注意查收。（此服务不收取任何手续费）<br />\r\n到付门票：<br />\r\na.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><span style=\\\"font-size:9pt;\\\">如需修改出游日期，请登录同程网个人中心自行修改，或重新预订门票。</span>\r\n	', '108.460524,22.907502', '', '', '50', '1', '0', null);
INSERT INTO `jee_viewpoint` VALUES ('25', '凤凰古城', '0', '462', '2', '9', 'on,on', '', '电子票', '联系方式', '<span style=\\\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\\\">少林寺全称登封市嵩山少林景区。 少林寺是我国久负盛名的佛教寺院，声誉显赫的禅宗祖庭，少林功夫的发祥地，位于登封市西12公里处的嵩山五乳峰下，是嵩山风景区的主要</span>', '<span style=\\\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\\\">少林寺全称登封市嵩山少林景区。 少林寺是我国久负盛名的佛教寺院，声誉显赫的禅宗祖庭，少林功夫的发祥地，位于登封市西12公里处的嵩山五乳峰下，是嵩山风景区的主要</span>', null, '<span style=\\\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\\\">少林寺全称登封市嵩山少林景区。 少林寺是我国久负盛名的佛教寺院，声誉显赫的禅宗祖庭，少林功夫的发祥地，位于登封市西12公里处的嵩山五乳峰下，是嵩山风景区的主要</span>', '108.297234,22.806493', '<span style=\\\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\\\">少林寺全称登封市嵩山少林景区。 少林寺是我国久负盛名的佛教寺院，声誉显赫的禅宗祖庭，少林功夫的发祥地，位于登封市西12公里处的嵩山五乳峰下，是嵩山风景区的主要</span>', '<span style=\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\">少林寺全称登封市嵩山少林景区。 少林寺是我国久负盛名的佛教寺院，声誉显赫的禅宗祖庭，少林功夫的发祥地，位于登封市西12公里处的嵩山五乳峰下，是嵩山风景区的主要</span>', '50', '0', '0', null);
INSERT INTO `jee_viewpoint` VALUES ('26', '少林寺', '0', '462', '2', '7', 'on', '', '厨房', '400000000', '<span style=\\\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\\\">少林寺全称登封市嵩山少林景区。 少林寺是我国久负盛名的佛教寺院，声誉显赫的禅宗祖庭，少林功夫的发祥地，位于登封市西12公里处的嵩山五乳峰下，是嵩山风景区的主要</span>', '<span style=\\\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\\\">少林寺全称登封市嵩山少林景区。 少林寺是我国久负盛名的佛教寺院，声誉显赫的禅宗祖庭，少林功夫的发祥地，位于登封市西12公里处的嵩山五乳峰下，是嵩山风景区的主要</span>', null, '<span style=\\\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\\\">少林寺全称登封市嵩山少林景区。 少林寺是我国久负盛名的佛教寺院，声誉显赫的禅宗祖庭，少林功夫的发祥地，位于登封市西12公里处的嵩山五乳峰下，是嵩山风景区的主要</span>', '108.297234,22.806493', '<span style=\\\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\\\">少林寺全称登封市嵩山少林景区。 少林寺是我国久负盛名的佛教寺院，声誉显赫的禅宗祖庭，少林功夫的发祥地，位于登封市西12公里处的嵩山五乳峰下，是嵩山风景区的主要</span>', '<span style=\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\">少林寺全称登封市嵩山少林景区。 少林寺是我国久负盛名的佛教寺院，声誉显赫的禅宗祖庭，少林功夫的发祥地，位于登封市西12公里处的嵩山五乳峰下，是嵩山风景区的主要</span>', '50', '0', '0', null);
INSERT INTO `jee_viewpoint` VALUES ('27', '武当山', '0', '462', '2', '6', 'on,on,on', '', '取票点', '3154522', '<span style=\\\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\\\">武当山，又名太和山，位于湖北省十堰市境内，景区总面积312平方公里。武当山是我国著名的道教圣地、太极拳的发祥地、国家重点风景名胜区、全国十大避暑胜地</span>', '<span style=\\\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\\\">武当山，又名太和山，位于湖北省十堰市境内，景区总面积312平方公里。武当山是我国著名的道教圣地、太极拳的发祥地、国家重点风景名胜区、全国十大避暑胜地</span>', null, '<span style=\\\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\\\">武当山，又名太和山，位于湖北省十堰市境内，景区总面积312平方公里。武当山是我国著名的道教圣地、太极拳的发祥地、国家重点风景名胜区、全国十大避暑胜地</span>', '108.297234,22.806493', '<span style=\\\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\\\">武当山，又名太和山，位于湖北省十堰市境内，景区总面积312平方公里。武当山是我国著名的道教圣地、太极拳的发祥地、国家重点风景名胜区、全国十大避暑胜地</span>', '<span style=\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\">武当山，又名太和山，位于湖北省十堰市境内，景区总面积312平方公里。武当山是我国著名的道教圣地、太极拳的发祥地、国家重点风景名胜区、全国十大避暑胜地</span>', '50', '0', '0', null);
INSERT INTO `jee_viewpoint` VALUES ('28', '大明湖', '0', '462', '2', '6', 'on,on,on', '', '电子票', '4501002', '<span style=\\\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\\\">大明湖公园位于济南市区的偏北方向。 面积甚大，几乎占了旧城的四分之一。 大明湖景色优美秀丽， 湖上鸢飞鱼跃，荷花满塘，画舫穿行，岸边杨柳荫浓，繁花似锦，游人</span>', '<span style=\\\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\\\">大明湖公园位于济南市区的偏北方向。 面积甚大，几乎占了旧城的四分之一。 大明湖景色优美秀丽， 湖上鸢飞鱼跃，荷花满塘，画舫穿行，岸边杨柳荫浓，繁花似锦，游人</span>', null, '<span style=\\\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\\\">大明湖公园位于济南市区的偏北方向。 面积甚大，几乎占了旧城的四分之一。 大明湖景色优美秀丽， 湖上鸢飞鱼跃，荷花满塘，画舫穿行，岸边杨柳荫浓，繁花似锦，游人</span>', '108.297234,22.806493', '<span style=\\\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\\\">大明湖公园位于济南市区的偏北方向。 面积甚大，几乎占了旧城的四分之一。 大明湖景色优美秀丽， 湖上鸢飞鱼跃，荷花满塘，画舫穿行，岸边杨柳荫浓，繁花似锦，游人</span>', '<span style=\"color:#666666;font-family:宋体, arial;background-color:#FFFFFF;\">大明湖公园位于济南市区的偏北方向。 面积甚大，几乎占了旧城的四分之一。 大明湖景色优美秀丽， 湖上鸢飞鱼跃，荷花满塘，画舫穿行，岸边杨柳荫浓，繁花似锦，游人</span>', '50', '0', '0', null);
