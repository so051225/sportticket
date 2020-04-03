SET NAMES utf8mb4;

CREATE DATABASE `sport_ticket` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `sport_ticket`;

DROP TABLE IF EXISTS `sport_ticket`.`tb_customer`;
CREATE TABLE `sport_ticket`.`tb_customer` (
  `cuid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'customer id',
  `id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'identity card',
  `esport_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'esport id',
  `other_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'other id',
  PRIMARY KEY (`cuid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

DROP TABLE IF EXISTS `sport_ticket`.`tb_site`;
CREATE TABLE `sport_ticket`.`tb_site` (
    `sid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'site id',
    `site_name_zh` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'site name zh',
    `site_name_pt` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'site name pt',
    PRIMARY KEY (`sid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

DROP TABLE IF EXISTS `sport_ticket`.`tb_court`;
CREATE TABLE `sport_ticket`.`tb_court` (
    `cid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'court id',
    `sid` int(11) NOT NULL COMMENT 'site id',
    `display_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'display name',
    `court_no` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'court number',
    -- `fee_weekday` decimal(10,2) NOT NULL DEFAULT 0 COMMENT 'fee for weekday',
    -- `fee_weekend` decimal(10,2) NOT NULL DEFAULT 0 COMMENT 'fee for weekend',
    `is_reserved` tinyint(4) NOT NULL DEFAULT 0 COMMENT '(0 - reserved, 1 - not reserved)',
    PRIMARY KEY (`cid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

DROP TABLE IF EXISTS `sport_ticket`.`tb_order`;
CREATE TABLE `sport_ticket`.`tb_order` (
  `oid` int(11) NOT NULL AUTO_INCREMENT COMMENT 'order id',
  `cuid` int(11) NOT NULL COMMENT 'customer id',
  `id_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'blue card id',
  `sid` int(11) NOT NULL COMMENT 'site id',
  `cid` int(11) NOT NULL COMMENT 'court id',
  `order_no` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'order no',
  `ac_date` date not null COMMENT 'account date',
  `start_time` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'start time',
  `end_time` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'end time',
  `pay_method` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'payment method',
  `amount` decimal(10,2) NOT NULL DEFAULT 0 COMMENT 'order amount',
  `pay_time` datetime(0) NULL DEFAULT NULL COMMENT 'payment time',
  `order_status` tinyint(4) NOT NULL DEFAULT 0 COMMENT '(0 - order success, 1 - order cancel)',
  `cancel_reason` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT 'reason of cancel order',
  `people_count` int(11) NOT NULL DEFAULT 1 COMMENT 'number of people',
  `site_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'site name',
  `court_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'court name',
  PRIMARY KEY (`oid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;
