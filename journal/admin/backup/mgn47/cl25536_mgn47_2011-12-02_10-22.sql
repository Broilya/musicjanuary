#SKD101|cl25536_mgn47|25|2011.12.02 10:22:24|345|2|21|17|4|6|24|7|6|2|6|69|48|20|1|24|24|42|18|4

DROP TABLE IF EXISTS `classes`;
CREATE TABLE `classes` (
  `class_id` int(10) unsigned NOT NULL auto_increment,
  `class` varchar(11) NOT NULL default '1',
  `letter` char(2) NOT NULL default '',
  `school_year` int(4) unsigned NOT NULL,
  `teacher_id` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`class_id`),
  UNIQUE KEY `class` (`class`,`letter`,`school_year`),
  KEY `school_year` (`school_year`),
  KEY `teacher_id` (`teacher_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `classes` VALUES
(1, '0ю', '', 1, 1),
(2, '8б', '', 1, 2);

DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id_config` int(11) unsigned NOT NULL auto_increment,
  `desc_config` varchar(150) NOT NULL,
  `key_config` varchar(32) NOT NULL,
  `value_config` varchar(255) NOT NULL,
  `active` tinyint(2) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id_config`),
  UNIQUE KEY `key_config` (`key_config`),
  KEY `active` (`active`)
) ENGINE=MyISAM AUTO_INCREMENT=22 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `config` VALUES
(1, 'Отключения инструкции смс запросов в ученическом разделе', 'SMS_ZAPROS', '1', 0),
(2, 'Префикс для получение оценок', 'SMS_PREFIKS_OZENKI', 'PINKOD', 0),
(3, 'Префикс для получение домашнего задания', 'SMS_PREFIKS_DZ', 'DOMZAD', 0),
(4, 'Колличество дней в неделе', 'DAYS', '0', 1),
(5, 'Префикс  языка', 'LANG', 'ru', 1),
(6, 'Русский', 'INTERFACE', 'ru', 1),
(7, 'Название школы', 'NAME_SCHOOL', 'Демо школа', 1),
(8, 'Номер школы', 'NUM_SCHOOL', '111', 1),
(9, 'Количество дней тестового периода', 'TEST_DAYS', '14', 1),
(10, 'Касса', 'KASSA', '1', 1),
(11, 'Система Город', 'CITYSYSTEM', '2', 1),
(12, 'QuickPay', 'QUICKPAY', '3', 1),
(13, 'СберБанк', 'SBERBANK', '4', 1),
(14, 'Оплата тестового периода', 'TESTPAY', '-1', 1),
(15, 'Дотация', 'DOTATION', '-2', 1),
(16, 'Доступ к сайту', 'SERV_SITE', '1', 1),
(17, 'Отсылка смс с оценками', 'SERV_SMS_GRADE', '2', 1),
(18, 'Отсылка смс с замечаниями', 'SERV_SMS_NOTE', '3', 1),
(19, 'Отсылка смс с домашними заданиям', 'SERV_SMS_WHOME', '4', 1),
(20, 'Отсылка смс с расписанием на зав', 'SERV_SMS_SCHED', '5', 1),
(21, 'Отсылка смс с новостями школы', 'SERV_SMS_NEWS', '6', 1);

DROP TABLE IF EXISTS `disciplines`;
CREATE TABLE `disciplines` (
  `discipline_id` int(10) unsigned NOT NULL auto_increment,
  `discipline` varchar(150) NOT NULL,
  PRIMARY KEY  (`discipline_id`),
  UNIQUE KEY `discipline` (`discipline`)
) ENGINE=MyISAM AUTO_INCREMENT=18 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `disciplines` VALUES
(1, 'Алгебра'),
(2, 'Геометрия'),
(3, 'Физика'),
(4, 'Английский язык'),
(5, 'Немецкий язык'),
(6, 'Русский язык'),
(7, 'Литература'),
(8, 'Информатика'),
(9, 'История'),
(10, 'МХК'),
(11, 'География'),
(12, 'Биология'),
(13, 'Технология'),
(14, 'Физическая культура'),
(15, 'ОБЖ'),
(16, 'Обществознание'),
(17, 'Химия');

DROP TABLE IF EXISTS `information`;
CREATE TABLE `information` (
  `information_id` int(11) NOT NULL auto_increment,
  `information_date` date NOT NULL default '0000-00-00',
  `information_title` varchar(100) default NULL,
  `information_text` varchar(500) default NULL,
  `information_section` enum('teacher','student','all') NOT NULL default 'all',
  `information_classes` int(11) unsigned NOT NULL,
  `date_news` datetime default NULL COMMENT 'дата отсылки новости',
  KEY `information_id` (`information_id`),
  KEY `information_date` (`information_date`),
  KEY `information_section` (`information_section`),
  KEY `information_classes` (`information_classes`),
  KEY `date_news` (`date_news`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `lessons`;
CREATE TABLE `lessons` (
  `lesson_id` int(10) unsigned NOT NULL auto_increment,
  `lesson_date` date NOT NULL,
  `subject_id` int(10) unsigned NOT NULL,
  `topic` varchar(100) default NULL,
  `dz` text,
  `lesson_order` int(2) NOT NULL,
  `active` bigint(20) NOT NULL default '0',
  `schedule_id` int(10) unsigned default NULL,
  `file` varchar(64) default NULL,
  `date_dz` datetime default NULL COMMENT 'дата отсылки домашки',
  `date_sched` datetime default NULL COMMENT 'дата отсылки расписания',
  PRIMARY KEY  (`lesson_id`),
  KEY `lesson_date` (`lesson_date`),
  KEY `subject_id` (`subject_id`),
  KEY `lesson_order` (`lesson_order`),
  KEY `active` (`active`),
  KEY `schedule_id` (`schedule_id`),
  KEY `date_dz` (`date_dz`),
  KEY `date_sched` (`date_sched`)
) ENGINE=MyISAM AUTO_INCREMENT=5 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `lessons` VALUES
(1, '2011-11-21', 36, NULL, NULL, 0, 0, 3, NULL, NULL, NULL),
(2, '2011-11-21', 33, NULL, NULL, 0, 0, 1, NULL, NULL, NULL),
(3, '2011-11-21', 20, NULL, NULL, 0, 0, 8, NULL, NULL, NULL),
(4, '2011-11-28', 34, '', '', 0, 0, 2, NULL, NULL, NULL);

DROP TABLE IF EXISTS `quarters`;
CREATE TABLE `quarters` (
  `quarter_id` int(10) unsigned NOT NULL auto_increment,
  `school_year_id` int(4) unsigned NOT NULL default '0',
  `quarter_name` varchar(50) NOT NULL,
  `quarter_type` tinyint(2) unsigned NOT NULL default '1',
  `current` tinyint(2) unsigned NOT NULL default '0',
  `started` date NOT NULL,
  `finished` date NOT NULL,
  PRIMARY KEY  (`quarter_id`),
  KEY `current` (`current`),
  KEY `school_year_id` (`school_year_id`),
  KEY `started` (`started`),
  KEY `finished` (`finished`),
  KEY `quarter_type` (`quarter_type`)
) ENGINE=MyISAM AUTO_INCREMENT=8 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `quarters` VALUES
(1, 1, '1 период', 1, 0, '2011-09-01', '2011-10-04'),
(2, 1, '2 период', 1, 0, '2011-10-10', '2011-11-15'),
(3, 1, '3 период', 1, 0, '2011-11-21', '2011-12-31'),
(4, 1, '4 период', 1, 0, '2012-01-09', '2012-02-21'),
(7, 1, '6 период', 1, 0, '2012-04-16', '2012-05-31'),
(6, 1, '5 период', 1, 0, '2012-02-27', '2012-04-08');

DROP TABLE IF EXISTS `sch_balance`;
CREATE TABLE `sch_balance` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `student_id` int(10) unsigned NOT NULL,
  `date_add` date default NULL,
  `summa` int(10) NOT NULL default '0',
  `operator_id` smallint(4) NOT NULL default '0',
  `usluga_id` smallint(5) unsigned NOT NULL default '0' COMMENT 'ДопУслуга',
  `nomer` varchar(64) NOT NULL default '',
  `date_edit` datetime NOT NULL,
  `is_use` tinyint(1) unsigned NOT NULL default '0',
  `active` tinyint(1) unsigned NOT NULL default '1',
  `period_id` smallint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `date_edit` (`date_edit`),
  KEY `active` (`active`),
  KEY `is_use` (`is_use`),
  KEY `nomer` (`nomer`),
  KEY `usluga` (`usluga_id`),
  KEY `student_id` (`student_id`),
  KEY `operator_id` (`operator_id`),
  KEY `period_id` (`period_id`),
  KEY `date_add` (`date_add`)
) ENGINE=MyISAM AUTO_INCREMENT=25 /*!40101 DEFAULT CHARSET=utf8 */ COMMENT='Плюсовые - платежи, минусовые - начисления (R)';

INSERT INTO `sch_balance` VALUES
(1, 1, '2011-11-10', 2566, -1, 0, '', '2011-11-10 12:20:24', 0, 1, 0),
(2, 2, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(3, 3, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(4, 4, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(5, 5, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(6, 6, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(7, 7, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(8, 8, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(9, 9, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(10, 10, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(11, 11, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(12, 12, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(13, 13, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(14, 14, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(15, 15, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(16, 16, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(17, 17, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(18, 18, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(19, 19, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(20, 20, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(21, 21, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(22, 22, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(23, 23, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0),
(24, 24, '2011-11-10', 2566, -1, 0, '', '2011-11-10 14:23:12', 0, 1, 0);

DROP TABLE IF EXISTS `sch_classes_in_groups`;
CREATE TABLE `sch_classes_in_groups` (
  `clsgrp_id` int(9) unsigned NOT NULL auto_increment,
  `group_id` smallint(2) unsigned NOT NULL,
  `class_id` int(9) unsigned NOT NULL,
  PRIMARY KEY  (`clsgrp_id`),
  KEY `group_id` (`group_id`),
  KEY `student_id` (`class_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_groups`;
CREATE TABLE `sch_groups` (
  `group_id` smallint(2) unsigned NOT NULL auto_increment,
  `group` varchar(32) default NULL,
  `short` varchar(8) default NULL,
  `active` tinyint(2) unsigned NOT NULL default '1',
  PRIMARY KEY  (`group_id`),
  KEY `active` (`active`)
) ENGINE=MyISAM AUTO_INCREMENT=10 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_groups` VALUES
(1, 'Девочки', 'Дев', 1),
(2, 'Мальчики', 'Мал', 1),
(5, 'Английский язык (Попова)', 'Ан.яз (П', 1),
(6, 'Английский язык (Потапешкина)', 'Ан.яз (П', 1),
(7, 'Немецкий язык', 'Нем.яз', 1),
(8, 'Информатика (Шушарина)', 'Инф. (Ш)', 1),
(9, 'Информатика (Куприянова)', 'Инф. (К)', 1);

DROP TABLE IF EXISTS `sch_operator`;
CREATE TABLE `sch_operator` (
  `id` int(8) NOT NULL auto_increment,
  `name` varchar(32) default NULL,
  `path` varchar(32) NOT NULL default 'data/',
  `path_out` varchar(32) NOT NULL default 'data/',
  `file` varchar(16) default NULL,
  `active` tinyint(1) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `active` (`active`)
) ENGINE=MyISAM AUTO_INCREMENT=5 /*!40101 DEFAULT CHARSET=utf8 */ COMMENT='Название Оператора';

INSERT INTO `sch_operator` VALUES
(1, 'касса', 'data/cassa', 'data/cassa', 'KASSA', 1),
(2, 'Система Город', 'data/citysystem', 'data/citysystem/saldo', 'CITYSYSTEM', 1),
(3, 'QuickPay', 'data/quickpay', 'data/quickpay', 'QUICKPAY', 1),
(4, 'СберБанк', 'data/bv', 'data/bv', 'SBERBANK', 1),
(-1, 'Оплата тестового периода', 'data/', 'data/', 'TESTPAY', 1),
(-2, 'Дотация', 'data/', 'data/', 'DOTATION', 1);

DROP TABLE IF EXISTS `sch_parents`;
CREATE TABLE `sch_parents` (
  `parent_id` int(10) unsigned NOT NULL auto_increment,
  `last_name` varchar(25) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `middle_name` varchar(25) NOT NULL,
  `login` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `relative_id` smallint(2) unsigned NOT NULL default '1',
  `address` varchar(255) default NULL,
  `phone` varchar(25) default NULL,
  `work_phone` varchar(25) default NULL,
  `cell_phone` varchar(25) default NULL,
  `email` varchar(25) default NULL,
  `active` tinyint(2) unsigned NOT NULL default '1',
  PRIMARY KEY  (`parent_id`),
  UNIQUE KEY `login` (`login`),
  KEY `active` (`active`),
  KEY `last_name` (`last_name`),
  KEY `password` (`password`),
  KEY `relative_id` (`relative_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_relatives`;
CREATE TABLE `sch_relatives` (
  `relative_id` smallint(2) unsigned NOT NULL auto_increment,
  `relative` varchar(16) NOT NULL,
  PRIMARY KEY  (`relative_id`),
  UNIQUE KEY `relative` (`relative`)
) ENGINE=MyISAM AUTO_INCREMENT=3 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_relatives` VALUES
(1, 'мать'),
(2, 'отец');

DROP TABLE IF EXISTS `sch_services`;
CREATE TABLE `sch_services` (
  `service_id` int(4) unsigned NOT NULL auto_increment,
  `service_name` varchar(32) NOT NULL,
  `tarif` int(10) unsigned NOT NULL default '0',
  `kod` varchar(16) NOT NULL default '',
  `tarif01` int(10) unsigned NOT NULL,
  `tarif02` int(10) unsigned NOT NULL,
  `tarif03` int(10) unsigned NOT NULL,
  `tarif04` int(10) unsigned NOT NULL,
  `tarif05` int(10) unsigned NOT NULL,
  `tarif06` int(10) unsigned NOT NULL,
  `tarif07` int(10) unsigned NOT NULL,
  `tarif08` int(10) unsigned NOT NULL,
  `tarif09` int(10) unsigned NOT NULL,
  `tarif10` int(10) unsigned NOT NULL,
  `tarif11` int(10) unsigned NOT NULL,
  `tarif12` int(10) unsigned NOT NULL,
  `required` tinyint(2) unsigned NOT NULL default '0' COMMENT 'Обязательный сервис',
  `dotation` tinyint(2) unsigned NOT NULL default '0' COMMENT 'Дотация',
  `active` tinyint(2) unsigned NOT NULL default '1',
  PRIMARY KEY  (`service_id`),
  KEY `required` (`required`),
  KEY `active` (`active`),
  KEY `kod` (`kod`),
  KEY `dotation` (`dotation`)
) ENGINE=MyISAM AUTO_INCREMENT=7 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_services` VALUES
(1, 'Доступ к сайту', 3000, 'SERV_SITE', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1),
(2, 'Отсылка смс с оценками', 2500, 'SERV_SMS_GRADE', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1),
(3, 'Отсылка смс с замечаниями', 2000, 'SERV_SMS_NOTE', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(4, 'Отсылка смс с домашними заданиям', 3000, 'SERV_SMS_WHOME', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(5, 'Отсылка смс с расписанием на зав', 2000, 'SERV_SMS_SCHED', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(6, 'Отсылка смс с новостями школы', 2500, 'SERV_SMS_NEWS', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);

DROP TABLE IF EXISTS `sch_sms_logs`;
CREATE TABLE `sch_sms_logs` (
  `sms_id` bigint(20) unsigned NOT NULL auto_increment,
  `studless_id` varchar(120) default NULL,
  `student_id` int(10) unsigned NOT NULL default '0',
  `type` enum('g','d','z','s','n') NOT NULL default 'g',
  `date` datetime default NULL,
  `text` text,
  PRIMARY KEY  (`sms_id`),
  KEY `student_id` (`student_id`,`date`),
  KEY `type` (`type`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_students_in_groups`;
CREATE TABLE `sch_students_in_groups` (
  `studgr_id` int(9) unsigned NOT NULL auto_increment,
  `group_id` smallint(2) unsigned NOT NULL,
  `student_id` int(9) unsigned NOT NULL,
  PRIMARY KEY  (`studgr_id`),
  KEY `group_id` (`group_id`),
  KEY `student_id` (`student_id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_students_in_groups` VALUES
(1, 2, 2),
(2, 5, 2),
(3, 8, 2),
(4, 1, 3),
(5, 5, 3),
(6, 8, 3),
(7, 2, 4),
(8, 6, 4),
(9, 8, 4),
(10, 1, 5),
(11, 5, 5),
(12, 8, 5),
(13, 1, 6),
(14, 5, 6),
(15, 8, 6),
(16, 2, 7),
(17, 5, 7),
(18, 8, 7),
(19, 2, 8),
(20, 6, 8),
(21, 8, 8),
(22, 2, 9),
(23, 7, 9),
(24, 8, 9),
(25, 2, 10),
(26, 6, 10),
(27, 8, 10),
(28, 2, 11),
(29, 5, 11),
(30, 8, 11),
(31, 1, 12),
(32, 5, 12),
(33, 8, 12),
(34, 1, 13),
(35, 5, 13),
(36, 8, 13),
(37, 2, 14),
(38, 6, 14),
(39, 8, 14),
(40, 1, 15),
(41, 7, 15),
(42, 9, 15),
(43, 1, 16),
(44, 5, 16),
(45, 9, 16),
(46, 1, 17),
(47, 5, 17),
(48, 9, 17),
(49, 2, 18),
(50, 7, 18),
(51, 9, 18),
(52, 2, 19),
(53, 6, 19),
(54, 9, 19),
(55, 2, 20),
(56, 6, 20),
(57, 9, 20),
(58, 2, 21),
(59, 5, 21),
(60, 9, 21),
(61, 2, 22),
(62, 6, 22),
(63, 9, 22),
(64, 2, 23),
(65, 6, 23),
(66, 9, 23),
(67, 2, 24),
(68, 5, 24),
(69, 9, 24);

DROP TABLE IF EXISTS `sch_students_in_parent`;
CREATE TABLE `sch_students_in_parent` (
  `studparent_id` int(9) unsigned NOT NULL auto_increment,
  `parent_id` int(9) unsigned NOT NULL,
  `student_id` int(9) unsigned NOT NULL,
  PRIMARY KEY  (`studparent_id`),
  KEY `student_id` (`student_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_students_in_service`;
CREATE TABLE `sch_students_in_service` (
  `student_id` int(10) unsigned NOT NULL,
  `service_id` int(10) unsigned NOT NULL,
  `date_add` date NOT NULL default '2011-10-01',
  `tarif` int(10) unsigned NOT NULL default '0',
  UNIQUE KEY `student_id_2` (`student_id`,`service_id`),
  KEY `service_id` (`service_id`),
  KEY `date_add` (`date_add`),
  KEY `student_id` (`student_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_students_in_service` VALUES
(1, 1, '2011-11-10', 3000),
(1, 2, '2011-11-10', 2500),
(2, 1, '2011-11-10', 3000),
(2, 2, '2011-11-10', 2500),
(3, 1, '2011-11-10', 3000),
(3, 2, '2011-11-10', 2500),
(4, 1, '2011-11-10', 3000),
(4, 2, '2011-11-10', 2500),
(5, 1, '2011-11-10', 3000),
(5, 2, '2011-11-10', 2500),
(6, 1, '2011-11-10', 3000),
(6, 2, '2011-11-10', 2500),
(7, 1, '2011-11-10', 3000),
(7, 2, '2011-11-10', 2500),
(8, 1, '2011-11-10', 3000),
(8, 2, '2011-11-10', 2500),
(9, 1, '2011-11-10', 3000),
(9, 2, '2011-11-10', 2500),
(10, 1, '2011-11-10', 3000),
(10, 2, '2011-11-10', 2500),
(11, 1, '2011-11-10', 3000),
(11, 2, '2011-11-10', 2500),
(12, 1, '2011-11-10', 3000),
(12, 2, '2011-11-10', 2500),
(13, 1, '2011-11-10', 3000),
(13, 2, '2011-11-10', 2500),
(14, 1, '2011-11-10', 3000),
(14, 2, '2011-11-10', 2500),
(15, 1, '2011-11-10', 3000),
(15, 2, '2011-11-10', 2500),
(16, 1, '2011-11-10', 3000),
(16, 2, '2011-11-10', 2500),
(17, 1, '2011-11-10', 3000),
(17, 2, '2011-11-10', 2500),
(18, 1, '2011-11-10', 3000),
(18, 2, '2011-11-10', 2500),
(19, 1, '2011-11-10', 3000),
(19, 2, '2011-11-10', 2500),
(20, 1, '2011-11-10', 3000),
(20, 2, '2011-11-10', 2500),
(21, 1, '2011-11-10', 3000),
(21, 2, '2011-11-10', 2500),
(22, 1, '2011-11-10', 3000),
(22, 2, '2011-11-10', 2500),
(23, 1, '2011-11-10', 3000),
(23, 2, '2011-11-10', 2500),
(24, 1, '2011-11-10', 3000),
(24, 2, '2011-11-10', 2500);

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE `schedule` (
  `id_schedule` int(10) unsigned NOT NULL auto_increment,
  `date_schedule` int(2) unsigned NOT NULL COMMENT 'День недели 0-6',
  `school_year` int(4) unsigned NOT NULL,
  `quarter_id` int(6) unsigned NOT NULL default '0',
  `discipline_id` int(10) unsigned NOT NULL default '0',
  `class_id` int(10) unsigned NOT NULL default '0',
  `cabinet` varchar(30) default NULL,
  `teacher_id` int(10) unsigned NOT NULL default '0',
  `order_schedule` int(2) unsigned NOT NULL,
  `group_id` smallint(4) unsigned NOT NULL default '0',
  `started` date NOT NULL default '0000-00-00' COMMENT 'дата включения',
  `finished` date NOT NULL default '0000-00-00' COMMENT 'дата отключения',
  PRIMARY KEY  (`id_schedule`),
  KEY `date_schedule` (`date_schedule`),
  KEY `school_year` (`school_year`),
  KEY `discipline_id` (`discipline_id`),
  KEY `class_id` (`class_id`),
  KEY `order_schedule` (`order_schedule`),
  KEY `teacher_id` (`teacher_id`),
  KEY `quarter_id` (`quarter_id`),
  KEY `started` (`started`),
  KEY `finished` (`finished`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `schedule` VALUES
(1, 0, 1, 3, 11, 2, '', 5, 1, 0, '2011-11-21', '2011-12-31'),
(2, 0, 1, 3, 12, 2, '', 10, 2, 0, '2011-11-21', '2011-12-31'),
(3, 0, 1, 3, 13, 2, '', 11, 3, 0, '2011-11-21', '2011-12-31'),
(4, 0, 1, 3, 13, 2, '', 12, 4, 0, '2011-11-21', '2011-12-31'),
(5, 0, 1, 3, 13, 2, '', 11, 5, 0, '2011-11-21', '2011-12-31'),
(6, 0, 1, 3, 13, 2, '', 12, 6, 0, '2011-11-21', '2011-12-31'),
(7, 0, 1, 3, 9, 2, '', 4, 7, 0, '2011-11-21', '2011-12-31'),
(8, 0, 1, 3, 1, 2, '', 7, 8, 0, '2011-11-21', '2011-12-31'),
(9, 3, 1, 0, 17, 2, '', 15, 1, 0, '0000-00-00', '0000-00-00'),
(10, 3, 1, 0, 11, 2, '', 5, 2, 0, '0000-00-00', '0000-00-00'),
(11, 3, 1, 0, 1, 2, '', 7, 3, 0, '0000-00-00', '0000-00-00'),
(12, 3, 1, 0, 14, 2, '', 13, 4, 0, '0000-00-00', '0000-00-00'),
(13, 3, 1, 0, 14, 2, '', 14, 5, 0, '0000-00-00', '0000-00-00'),
(14, 3, 1, 0, 6, 2, '', 3, 6, 0, '0000-00-00', '0000-00-00'),
(15, 3, 1, 0, 17, 2, '', 15, 1, 0, '0000-00-00', '0000-00-00'),
(16, 3, 1, 0, 11, 2, '', 5, 2, 0, '0000-00-00', '0000-00-00'),
(17, 3, 1, 0, 1, 2, '', 7, 3, 0, '0000-00-00', '0000-00-00'),
(18, 3, 1, 0, 14, 2, '', 13, 4, 0, '0000-00-00', '0000-00-00'),
(19, 3, 1, 0, 14, 2, '', 14, 5, 0, '0000-00-00', '0000-00-00'),
(20, 3, 1, 0, 6, 2, '', 3, 6, 0, '0000-00-00', '0000-00-00');

DROP TABLE IF EXISTS `school_years`;
CREATE TABLE `school_years` (
  `school_year_id` int(10) NOT NULL auto_increment,
  `name_year` varchar(50) NOT NULL,
  `current` tinyint(2) unsigned NOT NULL default '0',
  `started` date NOT NULL,
  `finished` date NOT NULL,
  PRIMARY KEY  (`school_year_id`),
  KEY `current` (`current`),
  KEY `started` (`started`),
  KEY `finished` (`finished`)
) ENGINE=MyISAM AUTO_INCREMENT=2 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `school_years` VALUES
(1, '2011 -2012 учебный год', 1, '2011-09-01', '2012-07-04');

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
  `student_id` int(10) unsigned NOT NULL auto_increment,
  `last_name` varchar(25) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `middle_name` varchar(25) NOT NULL,
  `login` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `birthday` date NOT NULL default '0000-00-00',
  `address` varchar(255) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `mother_fio` varchar(50) NOT NULL,
  `mother_work_phone` varchar(25) NOT NULL,
  `mother_cell_phone` varchar(25) NOT NULL,
  `father_fio` varchar(50) NOT NULL,
  `father_work_phone` varchar(25) NOT NULL,
  `father_cell_phone` varchar(25) NOT NULL,
  `pin_code` int(6) unsigned NOT NULL default '0',
  `email` varchar(25) NOT NULL,
  `photo` varchar(50) default NULL,
  `update_photo` int(10) unsigned default '0',
  `send_from` date NOT NULL,
  `send_to` date NOT NULL,
  `mode` smallint(6) unsigned NOT NULL,
  `active` tinyint(2) unsigned NOT NULL default '1',
  `date_last` date NOT NULL default '2011-10-01',
  PRIMARY KEY  (`student_id`),
  UNIQUE KEY `pin_code` (`pin_code`),
  UNIQUE KEY `login` (`login`),
  KEY `active` (`active`),
  KEY `mode` (`mode`),
  KEY `last_name` (`last_name`),
  KEY `password` (`password`),
  KEY `date_last` (`date_last`)
) ENGINE=MyISAM AUTO_INCREMENT=25 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `students` VALUES
(1, 'a', 'a', '', 'a.a', '127214', '0000-00-00', '', '', '', '', '', '', '', '', 999355, '', '111110122420719.jpg', 0, '0000-00-00', '0000-00-00', 0, 1, '2011-10-01'),
(2, 'Балтин', 'Евгений', 'Петрович', '2Балтин', '674956', '0000-00-00', '', '', 'Балтина Ольга Рафаиловна', '', '+7-908-060-27-10', '', '', '', 695308, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(3, 'Белова', 'Ольга', 'Юрьевна', '3Белова', '198431', '0000-00-00', '', '', 'Белова Анна Викторовна', '', '+7-961-576-54-79', '', '', '', 702556, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(4, 'Бобраков', 'Кирилл', 'Евгеньевич', '4Бобраков', '226542', '0000-00-00', '', '', 'Бобракова Галина Александровна', '', '+7-950-749-42-92', '', '', '', 320864, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(5, 'Васильева', 'Кристина', 'Константиновна', '5Васильева', '656471', '0000-00-00', '', '', 'Васильева Елена Владимировна', '', '+7-906-871-09-25', '', '', '', 884374, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(6, 'Гапей', 'Надежда', 'Евгеньевна', '6Гапей', '728893', '0000-00-00', '', '', 'Лаворанко Ольга Николаевна', '', '+7-964-246-90-98', '', '', '', 259652, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(7, 'Гераскин', 'Даниил', 'Евгеньевич', '7Гераскин', '587173', '0000-00-00', '', '', 'Гераскина Юлия Николаевна', '', '+7-904-812-91-22', '', '', '', 774130, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(8, 'Дегтярев', 'Виталий', 'Константинович', '8Дегтярев', '286787', '0000-00-00', '', '', 'Иргешева Ирина Рустамовна', '', '+7-906-851-37-27', '', '', '', 889287, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(9, 'Джамолов', 'Александр', 'Тахирович', '9Джамолов', '576445', '0000-00-00', '', '', 'Джамолов Тахир Зарифитдинович', '', '+7-951-817-89-15', '', '', '', 611635, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(10, 'Дорожкин', 'Степан', 'Андреевич', '10Дорожкин', '349076', '0000-00-00', '', '', 'Дорожкина Екатерина Николаевна', '', '+7-902-891-51-77', '', '', '', 528148, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(11, 'Ишимов', 'Алексей', 'Алексеевич', '11Ишимов', '858621', '0000-00-00', '', '', 'Ишимова Лариса Игнатьевна', '', '+7-908-046-48-14', '', '', '', 386729, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(12, 'Калинина', 'Ирина', 'Евгеньевна', '12Калинина', '695744', '0000-00-00', '', '', 'Калинина Людмила Евгеньевна', '', '+7-951-439-34-97', '', '', '', 650057, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(13, 'Муратова', 'Алена', 'Алексеевна', '13Муратова', '413973', '0000-00-00', '', '', 'Муратова Юлия Александровна', '', '+7-908-589-65-74', '', '', '', 915132, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(14, 'Оберемок', 'Павел', 'Дмитриевич', '14Оберемок', '221284', '0000-00-00', '', '', 'Оберемок Светлана Александровна', '', '+7-904-815-53-16', '', '', '', 613666, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(15, 'Рябинина', 'Валерия', 'Валерьевна', '15Рябинина', '806927', '0000-00-00', '', '', 'Рябинина Наталья Александровна', '', '+7-904-973-80-21', '', '', '', 760035, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(16, 'Самошкина', 'Олеся', 'Витальевна', '16Самошкина', '416433', '0000-00-00', '', '', 'Кузнецова Светлана Геннадьевна', '', '+7-964-247-60-03', '', '', '', 104398, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(17, 'Серикова', 'Ольга', 'Андреевна', '17Серикова', '699707', '0000-00-00', '', '', 'Серикова Лариса Петровна', '', '+7-919-127-52-40', '', '', '', 669134, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(18, 'Синькевич', 'Дмитрий', 'Вячеславович', '18Синькевич', '371691', '0000-00-00', '', '', 'Синькевич Фирдания Рафаиловна', '', '+7-908-041-07-06', '', '', '', 991389, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(19, 'Скрипник', 'Иван', 'Александрович', '19Скрипник', '312253', '0000-00-00', '', '', 'Юркевич Анна Александровна', '', '+7-904-976-76-48', '', '', '', 798138, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(20, 'Степанов', 'Артем', 'Алексеевич', '20Степанов', '682513', '0000-00-00', '', '', 'Степанова Наталья Юрьевна', '', '+7-904-810-24-25', '', '', '', 498233, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(21, 'Тазиев', 'Руслан', 'Маратович', '21Тазиев', '657885', '0000-00-00', '', '', 'Тазиева Наталья Владимировна', '', '+7-908-586-34-04', '', '', '', 868725, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(22, 'Тансыкбаев', 'Валихан', 'Арманович', '22Тансыкбаев', '642856', '0000-00-00', '', '', 'Тансыкбаева Алтын Суингалиевна', '', '+7-904-974-71-63', '', '', '', 411407, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(23, 'Тузов', 'Лев', 'Игоревич', '23Тузов', '300694', '0000-00-00', '', '', 'Тузова Марина Михайловна', '', '+7-922-230-62-98', '', '', '', 245059, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01'),
(24, 'Шаборшин', 'Савва', 'Сергеевич', '24Шаборшин', '756695', '0000-00-00', '', '', 'Федорова Оксана Александровна', '', '+7-951-240-26-32', '', '', '', 829644, '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, '2011-10-01');

DROP TABLE IF EXISTS `students_in_class`;
CREATE TABLE `students_in_class` (
  `class_id` int(10) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `expeled` int(1) NOT NULL default '0',
  UNIQUE KEY `student_id` (`student_id`),
  KEY `class_id` (`class_id`),
  KEY `expeled` (`expeled`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `students_in_class` VALUES
(1, 1, 0),
(2, 2, 0),
(2, 3, 0),
(2, 4, 0),
(2, 5, 0),
(2, 6, 0),
(2, 7, 0),
(2, 8, 0),
(2, 9, 0),
(2, 10, 0),
(2, 11, 0),
(2, 12, 0),
(2, 13, 0),
(2, 14, 0),
(2, 15, 0),
(2, 16, 0),
(2, 17, 0),
(2, 18, 0),
(2, 19, 0),
(2, 20, 0),
(2, 21, 0),
(2, 22, 0),
(2, 23, 0),
(2, 24, 0);

DROP TABLE IF EXISTS `students_on_lesson`;
CREATE TABLE `students_on_lesson` (
  `studless_id` bigint(20) unsigned NOT NULL auto_increment,
  `student_id` int(10) unsigned NOT NULL,
  `lesson_id` int(10) unsigned NOT NULL,
  `grade` char(5) NOT NULL,
  `behavior` int(2) unsigned NOT NULL default '0',
  `quater` int(2) unsigned NOT NULL default '0',
  `subj_id` int(10) unsigned NOT NULL,
  `date_grade` datetime default NULL COMMENT 'дата отсылки оценок',
  `date_note` datetime default NULL COMMENT 'дата отсылки замечаний',
  `note` text COMMENT 'Замечания',
  PRIMARY KEY  (`studless_id`),
  KEY `student_id` (`student_id`),
  KEY `lesson_id` (`lesson_id`),
  KEY `quater` (`quater`),
  KEY `subj_id` (`subj_id`),
  KEY `date_grade` (`date_grade`),
  KEY `date_note` (`date_note`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE `subjects` (
  `subject_id` int(10) unsigned NOT NULL auto_increment,
  `discipline_id` int(10) unsigned NOT NULL,
  `teacher_id` int(10) unsigned NOT NULL,
  `class_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`subject_id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `class_id` (`class_id`),
  KEY `discipline_id` (`discipline_id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `subjects` VALUES
(1, 3, 2, 0),
(2, 6, 3, 0),
(3, 7, 3, 0),
(4, 11, 5, 0),
(5, 1, 7, 0),
(6, 2, 7, 0),
(7, 14, 13, 0),
(8, 13, 11, 0),
(9, 5, 6, 0),
(10, 8, 8, 0),
(11, 13, 12, 0),
(12, 16, 16, 0),
(13, 12, 10, 0),
(14, 17, 15, 0),
(15, 9, 4, 0),
(16, 10, 4, 0),
(17, 14, 14, 0),
(18, 15, 14, 0),
(19, 8, 9, 0),
(20, 1, 7, 2),
(21, 2, 7, 2),
(22, 6, 3, 2),
(23, 7, 3, 2),
(24, 5, 6, 2),
(25, 4, 17, 0),
(26, 4, 18, 0),
(27, 4, 17, 2),
(28, 4, 18, 2),
(29, 8, 8, 2),
(30, 8, 9, 2),
(31, 9, 4, 2),
(32, 10, 4, 2),
(33, 11, 5, 2),
(34, 12, 10, 2),
(35, 3, 2, 2),
(36, 13, 11, 2),
(37, 13, 12, 2),
(38, 14, 13, 2),
(39, 14, 14, 2),
(40, 15, 14, 2),
(41, 16, 16, 2),
(42, 17, 15, 2);

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE `teachers` (
  `teacher_id` int(10) unsigned NOT NULL auto_increment,
  `login` varchar(25) NOT NULL,
  `passwd` varchar(32) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `middle_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `photo` varchar(50) NOT NULL,
  `director` tinyint(2) unsigned NOT NULL default '0',
  PRIMARY KEY  (`teacher_id`),
  UNIQUE KEY `login` (`login`),
  KEY `passwd` (`passwd`),
  KEY `last_name` (`last_name`),
  KEY `director` (`director`)
) ENGINE=MyISAM AUTO_INCREMENT=19 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `teachers` VALUES
(1, '1Тест', 'c4ca4238a0b923820dcc509a6f75849b', 'Тест', 'Тестович', 'Тестов', '', 0),
(2, 'sch47mgn', '1741feba0b55ae8ac005ccc9beae6515', 'Екатерина', 'Владимиривна', 'Федотова', '', 0),
(3, '6ae7514', '79213734b0f21a7440f8135cb4abba59', 'Светлана ', 'Станиславовн', 'Шербан ', '', 0),
(4, '0ddb537', '36a90d5b1d0f8a0c52314de3817ccfa3', 'Татьяна ', 'Анатольевна ', 'Симонова', '', 0),
(5, '750f531', 'b44bf781d26b18ba84ae35a9273b5ef1', 'Алена ', 'Шамильевна ', 'Гареева ', '', 0),
(6, 'dff9635', '13d2c98290b776ed2ca1d25b383cd948', 'Сандрина ', 'Юрьевна', 'Краузе ', '', 0),
(7, '38dyt79', '8f4a773bfa252442e6a255f35717a309', 'Людмила ', 'Михайловна', 'Донцова ', '', 0),
(8, 'b395536 ', '1758de98af80d6ae06412257e3640ef0', 'Ирина ', 'Николаевна', 'Куприянова ', '', 0),
(9, 'ae976e5', '0f096c527ddf1ff77fefd6c5a31c4f68', 'Марина  ', 'Владимировна', 'Шушарина ', '', 0),
(10, '9c92eac', '0948a9536b5968f1c41a636bca642f58', 'Прасковья ', 'Александровн', 'Миронова ', '', 0),
(11, 'd9a0c77', '3134c259a7bdc5d6eea7693266925232', 'Жанна ', 'Леонидовна', 'Копытова ', '', 0),
(12, 'b446a7b', '0ec021482075e1942616d1ad9a970816', 'Геннадий ', 'Владимирович', 'Липодат ', '', 0),
(13, '5sd4fgs', 'c02bd59013f9fab8eaa86d3c12373c9a', 'Любовь ', 'Никитична', 'Ищенко ', '', 0),
(14, '6s5df4s', '62c48652dfec58542d0390a28fd070ea', 'Владимир ', 'Николаевич', 'Шинкарев ', '', 0),
(15, '5eb382d', '668f1bd52334223e883b9ad6ffaa22b8', 'Екатерина ', 'Александровн', 'Недорезова ', '', 0),
(16, '5aeed80', 'db13799b7ac33b767a241e14df79fff6', 'Марина ', 'Борисовна', 'Макашева ', '', 0),
(17, 'bbe8c17', '31395b46123b1b800db9d0cf4c2deb26', 'Галина ', 'Григорьевна ', 'Попова ', '', 0),
(18, '3ab864b', 'b4e58b7b15655e7adf41f846d294d0b6', 'Галина ', 'Евгеньевна', 'Потапешкина  ', '', 0);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL auto_increment,
  `login` char(25) NOT NULL,
  `passwd` char(35) NOT NULL,
  `first_name` char(25) NOT NULL,
  `middle_name` char(25) NOT NULL,
  `last_name` char(25) NOT NULL,
  `access` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `login` (`login`),
  KEY `passwd` (`passwd`),
  KEY `last_name` (`last_name`),
  KEY `access` (`access`)
) ENGINE=MyISAM AUTO_INCREMENT=7 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `users` VALUES
(1, 'admin', '67a4a51b7eff62073bcb99b4604e2be7', '', '', 'СуперАдмин', 1),
(2, 'manager', '1d0258c2440a8d19e716292b231e3190', '', '', 'Оператор', 1),
(5, 'armonsoft', '96e79218965eb72c92a549dd5a330112', 'А', 'А', 'Вензелев', 1),
(6, 'SLIPPERY', 'c4ca4238a0b923820dcc509a6f75849b', '', '', 'Поздняков', 1);

