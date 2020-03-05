DROP TABLE IF EXISTS `sch_representative`;
DROP TABLE IF EXISTS `sch_schoole_represent`;
DROP TABLE IF EXISTS `sch_schools`;

DROP TABLE IF EXISTS `all_representative`;
CREATE TABLE `all_representative` (
  `representative_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `first_name` varchar(32) DEFAULT NULL,
  `middl_name` varchar(32) DEFAULT NULL,
  `last_name` varchar(32) DEFAULT NULL,
  `phone` varchar(16) DEFAULT NULL,
  `mobile_phone` varchar(16) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `active` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`representative_id`),
  UNIQUE KEY `login` (`login`),
  KEY `active` (`active`),
  KEY `city` (`city`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `all_schoole_represent`;
CREATE TABLE `all_schoole_represent` (
  `schrep_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `representative_id` int(9) unsigned NOT NULL,
  `schoole_id` int(9) unsigned NOT NULL,
  `active` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`schrep_id`),
  KEY `active` (`active`),
  KEY `representative_id` (`representative_id`),
  KEY `schoole_id` (`schoole_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `all_schools`;
CREATE TABLE `all_schools` (
  `school_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `school_name` varchar(128) DEFAULT NULL,
  `school_number` varchar(16) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `sub_domen` varchar(16) NOT NULL DEFAULT '',
  `domen` varchar(64) NOT NULL DEFAULT 'el-dn.ru',
  `username` varchar(32) NOT NULL,
  `basename` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `prefix` varchar(8) NOT NULL DEFAULT 'sch' COMMENT 'префикс таблиц',
  `comment` varchar(255) DEFAULT NULL,
  `active` tinyint(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`school_id`),
  UNIQUE KEY `sub_domen` (`sub_domen`),
  KEY `active` (`active`),
  KEY `prefix` (`prefix`),
  KEY `city` (`city`),
  KEY `username` (`username`),
  KEY `basename` (`basename`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */ COMMENT='Таблица всех школ';

INSERT INTO `all_schools` VALUES
(1, 'admin', '0', NULL, 'admin', 'el-dn.ru', 'cl25536_admin', 'cl25536_admin', 'dnevadmin', 'sch', NULL, 1),
(2, 'Тестовая 1', '1', NULL, 'demo', 'el-dn.ru', 'cl25536_demo', 'cl25536_demo', '111111', '', NULL, 1),
(3, 'ФГОУ СПО \"ЭГППК\"', '2', 'Энгельс', 'egppk', 'el-dn.ru', 'cl25536_egppk', 'cl25536_egppk', '111111', '', 'admin:fibk084 586mekg\n:a57d77b 123\nprep:9d28e4b 4cb0e7d39\nstudent:a758899  72853c549 ', 1),
(4, 'МОУ СОШ 15', '15', 'Новочеркаск', 'nov15', 'el-dn.ru', 'cl25536_nov15', 'cl25536_nov15', 'nov15', 'sch_', 'fgdfgfgfdg', 1),
(5, 'МОУ СОШ 22', '22', 'Новочеркаск', 'nov22', 'el-dn.ru', 'cl25536_nov22', 'cl25536_nov22', 'nov22', '', NULL, 1),
(6, 'Школа 47', '47', 'Магнитогорск', 'mgn47', 'el-dn.ru', 'cl25536_mgn47', 'cl25536_mgn47', 'mgn47', '', NULL, 1),
(7, 'Гимназия № 1', '1', 'Благовещенск', 'blago1', 'el-dn.ru', 'cl25536_blago1', 'cl25536_blago1', 'dnevblago1', '', NULL, 1),
(8, 'Школа 14', '14', 'Благовещенск', 'blago14', 'el-dn.ru', 'cl25536_blago14', 'cl25536_blago14', 'dnevblago14', '', 'логин - cf32e3b\nпароль - 6845308', 1),
(9, 'Школа 26', '26', 'Благовещенск', 'blago26', 'el-dn.ru', 'cl25536_blago26', 'cl25536_blago26', 'dnevblago26', '', NULL, 1),
(10, 'Школа 8', '8', 'vlad', 'vlad8', 'el-dn.ru', 'cl25536_vlad8', 'cl25536_vlad8', 'dnevvlad8', '', NULL, 1);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` char(25) NOT NULL,
  `passwd` char(35) NOT NULL,
  `first_name` char(25) NOT NULL,
  `middle_name` char(25) NOT NULL,
  `last_name` char(25) NOT NULL,
  `access` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `login` (`login`),
  KEY `passwd` (`passwd`),
  KEY `last_name` (`last_name`),
  KEY `access` (`access`)
) ENGINE=MyISAM AUTO_INCREMENT=3 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `users` VALUES
(1, 'admin', '67a4a51b7eff62073bcb99b4604e2be7', '', '', 'СуперАдмин', 1),
(2, 'manager', 'd41d8cd98f00b204e9800998ecf8427e', '', '', 'Оператор', 1);
