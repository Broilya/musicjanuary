#SKD101|cl25536_el|4|2011.11.11 14:51:10|9|9

DROP TABLE IF EXISTS `sch_representative`;
CREATE TABLE `sch_representative` (
  `representative_id` int(9) unsigned NOT NULL auto_increment,
  `login` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `first_name` varchar(32) default NULL,
  `middl_name` varchar(32) default NULL,
  `last_name` varchar(32) default NULL,
  `phone` varchar(16) default NULL,
  `mobile_phone` varchar(16) default NULL,
  `city` varchar(32) default NULL,
  `active` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY  (`representative_id`),
  UNIQUE KEY `login` (`login`),
  KEY `active` (`active`),
  KEY `city` (`city`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_scholle_represent`;
CREATE TABLE `sch_scholle_represent` (
  `schrep_id` int(9) unsigned NOT NULL auto_increment,
  `representative_id` int(9) unsigned NOT NULL,
  `schoole_id` int(9) unsigned NOT NULL,
  `active` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY  (`schrep_id`),
  KEY `active` (`active`),
  KEY `representative_id` (`representative_id`),
  KEY `schoole_id` (`schoole_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_schoole_represent`;
CREATE TABLE `sch_schoole_represent` (
  `schrep_id` int(9) unsigned NOT NULL auto_increment,
  `representative_id` int(9) unsigned NOT NULL,
  `schoole_id` int(9) unsigned NOT NULL,
  `active` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY  (`schrep_id`),
  KEY `active` (`active`),
  KEY `representative_id` (`representative_id`),
  KEY `schoole_id` (`schoole_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_schools`;
CREATE TABLE `sch_schools` (
  `schoole_id` int(9) unsigned NOT NULL auto_increment,
  `schoole_name` varchar(128) default NULL,
  `schoole_number` varchar(16) default NULL,
  `city` varchar(32) default NULL,
  `sub_domen` varchar(16) NOT NULL default '',
  `domen` varchar(64) NOT NULL default 'el-dn.ru',
  `username` varchar(32) NOT NULL,
  `basename` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `prefix` varchar(8) NOT NULL default 'sch' COMMENT 'префикс таблиц',
  `comment` varchar(255) default NULL,
  `active` tinyint(2) unsigned NOT NULL default '1',
  PRIMARY KEY  (`schoole_id`),
  UNIQUE KEY `sub_domen` (`sub_domen`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `basename` (`basename`),
  KEY `active` (`active`),
  KEY `prefix` (`prefix`),
  KEY `city` (`city`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */ COMMENT='Таблица всех школ';

INSERT INTO `sch_schools` VALUES
(1, 'admin', '0', NULL, 'admin', 'el-dn.ru', 'cl25536_admin', 'cl25536_admin', 'dnevadmin', 'sch', NULL, 1),
(2, 'Тестовая 1', '1', NULL, 'demo', 'el-dn.ru', 'cl25536_demo', 'cl25536_demo', '111111', '', NULL, 1),
(3, 'ФГОУ СПО \"ЭГППК\"', '2', 'Энгельс', 'egppk', 'el-dn.ru', 'cl25536_egppk', 'cl25536_egppk', '111111', '', 'admin:fibk084 586mekg\n:a57d77b 123\nprep:9d28e4b 4cb0e7d39\nstudent:a758899  72853c549 ', 1),
(4, 'МОУ СОШ 15', '15', 'Новочеркаск', 'nov15', 'el-dn.ru', 'cl25536_nov15', 'cl25536_nov15', 'nov15', '', NULL, 1),
(5, 'МОУ СОШ 22', '22', 'Новочеркаск', 'nov22', 'el-dn.ru', 'cl25536_nov22', 'cl25536_nov22', 'nov22', '', NULL, 1),
(6, 'Школа 47', '47', 'Магнитогорск', 'mgn47', 'el-dn.ru', 'cl25536_mgn47', 'cl25536_mgn47', 'mgn47', '', NULL, 1),
(7, 'Гимназия № 1', '1', 'Благовещенск', 'blago1', 'el-dn.ru', 'cl25536_blago1', 'cl25536_blago1', 'dnevblago1', '', NULL, 1),
(8, 'Школа 14', '14', 'Благовещенск', 'blago14', 'el-dn.ru', 'cl25536_blago14', 'cl25536_blago14', 'dnevblago14', '', 'логин - cf32e3b\nпароль - 6845308', 1),
(9, 'Школа 26', '26', 'Благовещенск', 'blago26', 'el-dn.ru', 'cl25536_blago26', 'cl25536_blago26', 'dnevblago26', '', NULL, 1),
(10, 'Школа 8', '8', 'vlad', 'vlad8', 'el-dn.ru', 'cl25536_vlad8', 'cl25536_vlad8', 'dnevvlad8', '', NULL, 1);

