#SKD101|test1|28|2012.04.11 12:10:20|88|3|2|3|10|3|2|2|16|1|7|1|1|6|3|3|2|11|9|2|1

DROP TABLE IF EXISTS `sch_balance`;
CREATE TABLE `sch_balance` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(10) unsigned NOT NULL,
  `date_add` date DEFAULT NULL,
  `summa` int(10) DEFAULT NULL,
  `operator_id` smallint(4) DEFAULT NULL,
  `usluga_id` smallint(5) unsigned NOT NULL,
  `nomer` varchar(64) DEFAULT NULL,
  `date_edit` datetime DEFAULT NULL,
  `is_use` tinyint(1) unsigned NOT NULL,
  `active` tinyint(1) unsigned NOT NULL,
  `period_id` smallint(3) unsigned NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_balance` VALUES
(1, 3, '2012-03-18', 15000, 0, 0, '', '2012-03-17 23:23:16', 0, 1, 0),
(2, 2, '2012-03-18', 15000, 0, 0, '', '2012-03-17 23:23:36', 0, 1, 0),
(3, 1, '2012-03-18', 15000, 0, 0, '', '2012-03-17 23:23:44', 0, 1, 0);

DROP TABLE IF EXISTS `sch_classes`;
CREATE TABLE `sch_classes` (
  `class_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class` varchar(20) NOT NULL DEFAULT '1',
  `letter` char(2) NOT NULL DEFAULT '',
  `school_year` int(4) unsigned NOT NULL,
  `teacher_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`class_id`),
  UNIQUE KEY `class` (`class`,`letter`,`school_year`)
) ENGINE=MyISAM AUTO_INCREMENT=3 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_classes` VALUES
(1, '5А', '', 1, 1),
(2, '1а', '', 1, 2);

DROP TABLE IF EXISTS `sch_classes_in_groups`;
CREATE TABLE `sch_classes_in_groups` (
  `clsgrp_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` smallint(2) unsigned NOT NULL,
  `class_id` int(9) unsigned NOT NULL,
  KEY `clsgrp_id` (`clsgrp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_classes_in_groups` VALUES
(1, 1, 2),
(2, 1, 1),
(3, 2, 1);

DROP TABLE IF EXISTS `sch_config`;
CREATE TABLE `sch_config` (
  `id_config` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `desc_config` varchar(150) NOT NULL,
  `key_config` varchar(100) NOT NULL,
  `value_config` varchar(30) NOT NULL,
  `active` tinyint(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_config`)
) ENGINE=MyISAM AUTO_INCREMENT=11 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_config` VALUES
(1, 'РћС‚РєР»СЋС‡РµРЅРёСЏ РёРЅСЃС‚СЂСѓРєС†РёРё СЃРјСЃ Р·Р°РїСЂРѕСЃРѕРІ РІ СѓС‡РµРЅРёС‡РµСЃРєРѕРј СЂР°Р·РґРµР»Рµ', 'SMS_ZAPROS', '0', 0),
(2, 'РџСЂРµС„РёРєСЃ РґР»СЏ РїРѕР»СѓС‡РµРЅРёРµ РѕС†РµРЅРѕРє', 'SMS_PREFIKS_OZENKI', 'PINKOD', 0),
(3, 'РџСЂРµС„РёРєСЃ РґР»СЏ РїРѕР»СѓС‡РµРЅРёРµ РґРѕРјР°С?РЅРµРіРѕ Р·Р°РґР°РЅРёСЏ', 'SMS_PREFIKS_DZ', 'DOMZAD', 0),
(4, 'РљРѕР»Р»РёС‡РµСЃС‚РІРѕ РґРЅРµР№ РІ РЅРµРґРµР»Рµ', 'DAYS', '1', 0),
(5, 'РџСЂРµС„РёРєСЃ  СЏР·С‹РєР°', 'LANG', 'ru', 0),
(6, 'Р СѓСЃСЃРєРёР№', 'INTERFACE', 'ru', 0),
(7, 'РќР°Р·РІР°РЅРёРµ С?РєРѕР»С‹', 'NAME_SCHOOL', 'Demo_versia', 0),
(8, 'РќРѕРјРµСЂ С?РєРѕР»С‹', 'NUM_SCHOOL', '1', 0),
(9, 'РљРѕР»РёС‡РµСЃС‚РІРѕ РґРЅРµР№ С‚РµСЃС‚РѕРІРѕРіРѕ РїРµСЂРёРѕРґР°', 'TEST_DAYS', '30', 0),
(10, 'Р’РµСЂСЃРёСЏ', 'VERSIY', '1.5 betta', 0);

DROP TABLE IF EXISTS `sch_disciplines`;
CREATE TABLE `sch_disciplines` (
  `discipline_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `discipline` varchar(50) NOT NULL,
  PRIMARY KEY (`discipline_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_disciplines` VALUES
(1, 'Физика'),
(2, 'математика'),
(3, 'Литература');

DROP TABLE IF EXISTS `sch_groups`;
CREATE TABLE `sch_groups` (
  `group_id` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `short` varchar(8) DEFAULT NULL,
  `group` varchar(32) DEFAULT NULL,
  `active` tinyint(2) unsigned NOT NULL,
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_groups` VALUES
(1, 'ма', 'мальчики', 0),
(2, 'Де', 'Девочки', 0);

DROP TABLE IF EXISTS `sch_information`;
CREATE TABLE `sch_information` (
  `information_id` int(11) NOT NULL AUTO_INCREMENT,
  `information_date` date NOT NULL DEFAULT '0000-00-00',
  `information_title` varchar(100) DEFAULT NULL,
  `information_text` varchar(500) DEFAULT NULL,
  `information_section` enum('teacher','parent','student','balance','personal','all') DEFAULT NULL,
  `information_classes` int(11) unsigned NOT NULL,
  `date_news` datetime DEFAULT NULL,
  KEY `information_id` (`information_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_information` VALUES
(1, '2012-03-12', 'ывмаып', 'выпвап', 'student', 2, NULL),
(2, '2012-03-12', '	ывмаып', '	ывмаып', 'student', 2, NULL);

DROP TABLE IF EXISTS `sch_lessons`;
CREATE TABLE `sch_lessons` (
  `lesson_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lesson_date` date NOT NULL,
  `subject_id` int(10) unsigned NOT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `dz` text,
  `lesson_order` int(2) NOT NULL,
  `active` bigint(20) NOT NULL DEFAULT '0',
  `schedule_id` int(10) unsigned DEFAULT NULL,
  `file` varchar(64) DEFAULT NULL,
  `date_dz` datetime DEFAULT NULL,
  `date_sched` datetime DEFAULT NULL,
  PRIMARY KEY (`lesson_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_lessons` VALUES
(1, '2012-03-12', 0, 'Физические тела', 'gsdgsd', 0, 0, 1, '0', NULL, NULL),
(2, '2012-03-16', 1, 'Физические тела', 'uyfgugf', 0, 0, 2, '0', NULL, NULL),
(3, '2012-03-16', 0, 'Чтение позиций', 'egreg', 0, 0, 3, NULL, NULL, NULL),
(4, '2012-03-13', 0, 'werwerw', 'werwer', 0, 0, 4, NULL, NULL, NULL),
(5, '2012-03-14', 0, '12', 'dfsf', 0, 0, 5, NULL, NULL, NULL),
(6, '2012-03-17', 0, NULL, NULL, 0, 1, 6, NULL, NULL, NULL),
(7, '2012-03-12', 0, 'Физические тела', '', 0, 0, 7, NULL, NULL, NULL),
(8, '2012-03-12', 10, 'Физические тела', 'ывмвыа', 0, 0, 12, NULL, NULL, NULL),
(9, '2012-03-12', 12, 'Чтение позиций', 'ячсыва', 0, 0, 14, NULL, NULL, NULL),
(10, '2012-03-19', 14, 'Физические тела', 'cfasfsdaf', 0, 0, 12, NULL, NULL, NULL),
(11, '2012-03-13', 14, NULL, NULL, 10000, 1332203828, 0, NULL, NULL, NULL),
(12, '2012-03-12', 0, NULL, NULL, 10000, 1332203858, 0, NULL, NULL, NULL),
(13, '2012-03-19', 11, 'sdasd', 'asdasd', 0, 0, 13, NULL, NULL, NULL),
(14, '2012-03-19', 11, NULL, NULL, 10000, 1332203878, 0, NULL, NULL, NULL),
(15, '2012-03-19', 12, 'Физические тела', 'sadsadf', 0, 0, 17, NULL, NULL, NULL),
(16, '2012-03-26', 14, 'Чтение позиций', 'zsxcxzcxz', 0, 0, 12, NULL, NULL, NULL);

DROP TABLE IF EXISTS `sch_operator`;
CREATE TABLE `sch_operator` (
  `id` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `path` varchar(32) DEFAULT NULL,
  `path_out` varchar(32) DEFAULT NULL,
  `file` varchar(16) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_parents`;
CREATE TABLE `sch_parents` (
  `parent_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `last_name` varchar(25) DEFAULT NULL,
  `first_name` varchar(25) DEFAULT NULL,
  `middle_name` varchar(25) DEFAULT NULL,
  `login` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `relative_id` smallint(2) unsigned NOT NULL DEFAULT '1',
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `work_phone` varchar(25) DEFAULT NULL,
  `cell_phone` varchar(25) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `active` tinyint(2) unsigned NOT NULL DEFAULT '1',
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_quarters`;
CREATE TABLE `sch_quarters` (
  `quarter_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_year_id` bigint(20) unsigned NOT NULL,
  `quarter_name` varchar(50) NOT NULL,
  `quarter_type` int(11) NOT NULL DEFAULT '1',
  `current` int(11) NOT NULL DEFAULT '0',
  `started` date NOT NULL,
  `finished` date NOT NULL,
  PRIMARY KEY (`quarter_id`),
  KEY `current` (`current`),
  KEY `school_year_id` (`school_year_id`),
  KEY `type_quarter` (`quarter_type`)
) ENGINE=MyISAM AUTO_INCREMENT=2 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_quarters` VALUES
(1, 1, '1 четверь', 1, 1, '2011-09-01', '2012-05-30');

DROP TABLE IF EXISTS `sch_relatives`;
CREATE TABLE `sch_relatives` (
  `relative_id` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `relative` varchar(16) DEFAULT NULL,
  KEY `relative_id` (`relative_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_representative`;
CREATE TABLE `sch_representative` (
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
  KEY `representative_id` (`representative_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_schedule`;
CREATE TABLE `sch_schedule` (
  `id_schedule` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date_schedule` int(11) unsigned NOT NULL,
  `school_year` int(4) unsigned NOT NULL,
  `quarter_id` int(6) unsigned NOT NULL DEFAULT '0',
  `discipline_id` int(11) unsigned NOT NULL DEFAULT '0',
  `class_id` int(11) unsigned NOT NULL DEFAULT '0',
  `cabinet` varchar(30) DEFAULT NULL,
  `teacher_id` int(10) unsigned NOT NULL DEFAULT '0',
  `group_id` smallint(4) unsigned NOT NULL DEFAULT '0',
  `started` date NOT NULL DEFAULT '0000-00-00',
  `finished` date NOT NULL DEFAULT '0000-00-00',
  `order_schedule` int(2) unsigned NOT NULL,
  PRIMARY KEY (`id_schedule`)
) ENGINE=MyISAM AUTO_INCREMENT=18 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_schedule` VALUES
(15, 0, 1, 1, 3, 2, '', 1, 0, '2011-09-01', '2012-05-30', 4),
(13, 0, 1, 1, 2, 2, '', 1, 0, '2011-09-01', '2012-05-30', 2),
(14, 0, 1, 1, 3, 2, '', 1, 0, '2011-09-01', '2012-05-30', 3),
(9, 0, 1, 1, 1, 1, '', 0, 0, '2011-09-01', '2012-05-30', 1),
(12, 0, 1, 1, 2, 2, '', 2, 0, '2011-09-01', '2012-05-30', 1),
(16, 0, 1, 1, 2, 2, '', 2, 0, '2011-09-01', '2012-05-30', 5),
(17, 0, 1, 1, 3, 2, '', 1, 0, '2011-09-01', '2012-05-30', 6);

DROP TABLE IF EXISTS `sch_school_years`;
CREATE TABLE `sch_school_years` (
  `school_year_id` int(10) NOT NULL AUTO_INCREMENT,
  `name_year` varchar(50) NOT NULL,
  `current` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `started` date NOT NULL,
  `finished` date NOT NULL,
  PRIMARY KEY (`school_year_id`),
  KEY `current` (`current`)
) ENGINE=MyISAM AUTO_INCREMENT=2 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_school_years` VALUES
(1, '2011 -2012 учебный год', 1, '2011-09-01', '2012-05-30');

DROP TABLE IF EXISTS `sch_schoole_represent`;
CREATE TABLE `sch_schoole_represent` (
  `schrep_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `representative_id` int(9) unsigned NOT NULL,
  `schoole_id` int(9) unsigned NOT NULL,
  `active` tinyint(2) unsigned NOT NULL,
  KEY `schrep_id` (`schrep_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_schools`;
CREATE TABLE `sch_schools` (
  `school_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `school_name` varchar(128) DEFAULT NULL,
  `school_number` varchar(16) DEFAULT NULL,
  `city` varchar(64) DEFAULT NULL,
  `sub_domen` varchar(64) DEFAULT NULL,
  `domen` varchar(64) DEFAULT NULL,
  `username` varchar(64) DEFAULT NULL,
  `basename` varchar(64) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `prefix` varchar(64) DEFAULT 'sch_',
  `comment` varchar(255) DEFAULT NULL,
  `active` tinyint(2) unsigned NOT NULL,
  KEY `schoole_id` (`school_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_schools` VALUES
(1, 'Тестовая', '1', 'город', 'subdomain', 'test2.ru', 'test1', 'test1', 'test1', 'sch_', 'текст', 1);

DROP TABLE IF EXISTS `sch_services`;
CREATE TABLE `sch_services` (
  `service_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `service_name` varchar(32) DEFAULT NULL,
  `tarif` int(10) unsigned NOT NULL,
  `kod` varchar(16) DEFAULT NULL,
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
  `required` tinyint(2) unsigned NOT NULL,
  `dotation` tinyint(2) unsigned NOT NULL,
  `active` tinyint(2) unsigned NOT NULL,
  KEY `service_id` (`service_id`)
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
  `sms_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sstudless_id` varchar(120) DEFAULT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `type` enum('g','d','z','s','n','m') DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `text` text,
  KEY `sms_id` (`sms_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_students`;
CREATE TABLE `sch_students` (
  `student_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `last_name` varchar(25) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `middle_name` varchar(25) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  `address` varchar(255) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `mother_fio` varchar(50) NOT NULL,
  `mother_work_phone` varchar(25) NOT NULL,
  `mother_cell_phone` varchar(25) NOT NULL,
  `father_fio` varchar(50) NOT NULL,
  `father_work_phone` varchar(25) NOT NULL,
  `father_cell_phone` varchar(25) NOT NULL,
  `pin_code` int(6) unsigned NOT NULL,
  `email` varchar(25) NOT NULL,
  `mother_email` varchar(25) NOT NULL,
  `father_email` varchar(25) NOT NULL,
  `photo` varchar(50) DEFAULT NULL,
  `update_photo` int(11) DEFAULT '0',
  `send_from` date NOT NULL,
  `send_to` date NOT NULL,
  `mode` smallint(6) unsigned NOT NULL,
  `active` tinyint(2) unsigned NOT NULL,
  `date_last` date DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `pin_code` (`pin_code`)
) ENGINE=MyISAM AUTO_INCREMENT=4 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_students` VALUES
(1, 'ыфавфы', 'фыафы', 'фыафыа', '1', '1', '0000-00-00', '', '', 'ывавы выа выаыв', '', 'выа', '', '', '', 719189, '', '', '', NULL, 0, '0000-00-00', '0000-00-00', 1, 1, NULL),
(2, 'Иванов', 'Иван', 'Иванович', '2Иванов', '759c127f', '0000-00-00', '', '', '', '', '', '', '', '', 864373, '', '', '', '', 0, '0000-00-00', '0000-00-00', 0, 1, NULL),
(3, 'asdasd', 'Иван', 'Иванович', '3asdasd', '38b49b8a', '0000-00-00', '', '', '', '', '', '', '', '', 173196, '', '', '', '', 0, '2012-03-05', '2012-03-25', 1, 1, NULL);

DROP TABLE IF EXISTS `sch_students_in_class`;
CREATE TABLE `sch_students_in_class` (
  `class_id` int(10) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `expeled` int(1) NOT NULL DEFAULT '0',
  KEY `class_id` (`class_id`,`student_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_students_in_class` VALUES
(1, 1, 0),
(2, 2, 0),
(2, 3, 0);

DROP TABLE IF EXISTS `sch_students_in_groups`;
CREATE TABLE `sch_students_in_groups` (
  `service_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` smallint(2) unsigned NOT NULL,
  `student_id` int(9) unsigned NOT NULL,
  KEY `service_id` (`service_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_students_in_groups` VALUES
(1, 1, 3),
(2, 2, 1);

DROP TABLE IF EXISTS `sch_students_in_parent`;
CREATE TABLE `sch_students_in_parent` (
  `studparent_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(9) unsigned NOT NULL,
  `student_id` int(9) unsigned NOT NULL,
  KEY `studparent_id` (`studparent_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_students_in_service`;
CREATE TABLE `sch_students_in_service` (
  `student_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `service_id` int(10) unsigned NOT NULL,
  `date_add` date DEFAULT NULL,
  `tarif` int(10) unsigned NOT NULL,
  KEY `student_id` (`student_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_students_on_lesson`;
CREATE TABLE `sch_students_on_lesson` (
  `studless_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(10) unsigned NOT NULL,
  `lesson_id` int(10) unsigned NOT NULL,
  `grade` char(3) NOT NULL,
  `behavior` int(2) unsigned DEFAULT NULL,
  `quater` int(2) unsigned NOT NULL,
  `subj_id` int(25) unsigned NOT NULL,
  `date_grade` datetime DEFAULT NULL,
  `date_note` datetime DEFAULT NULL,
  `note` text,
  KEY `studless_id` (`studless_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_students_on_lesson` VALUES
(1, 1, 1, '5', 1, 1, 0, NULL, NULL, ''),
(2, 1, 2, '5', 1, 1, 0, NULL, NULL, ''),
(3, 1, 3, '3', 1, 1, 0, NULL, NULL, ''),
(4, 1, 5, '4', 1, 1, 0, NULL, NULL, ''),
(5, 3, 8, '5', 1, 1, 10, NULL, NULL, 'scdasd'),
(6, 3, 9, '5', 1, 1, 12, NULL, NULL, ''),
(7, 3, 10, '5', 1, 1, 14, NULL, NULL, ''),
(8, 3, 13, '1', 1, 1, 11, NULL, NULL, ''),
(9, 3, 15, '5', 1, 1, 12, NULL, NULL, ''),
(10, 3, 16, '5', 1, 1, 14, NULL, NULL, ''),
(11, 2, 16, '4', 1, 1, 14, NULL, NULL, '');

DROP TABLE IF EXISTS `sch_subjects`;
CREATE TABLE `sch_subjects` (
  `subject_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `discipline_id` int(10) unsigned NOT NULL,
  `teacher_id` int(10) unsigned NOT NULL,
  `class_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_subjects` VALUES
(1, 1, 1, 1),
(11, 2, 1, 2),
(8, 2, 2, 1),
(10, 1, 2, 2),
(7, 2, 2, 0),
(9, 0, 0, 1),
(12, 3, 1, 2),
(13, 0, 0, 1),
(14, 2, 2, 2);

DROP TABLE IF EXISTS `sch_teachers`;
CREATE TABLE `sch_teachers` (
  `teacher_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(25) NOT NULL,
  `passwd` varchar(32) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `middle_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `photo` varchar(50) NOT NULL,
  `director` tinyint(4) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`teacher_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_teachers` VALUES
(1, '1Иванова', 'c4ca4238a0b923820dcc509a6f75849b', 'Татьяна', 'Ивановна', 'Иванова', '', 0),
(2, '12', 'c20ad4d76fe97759aa27a0c99bff6710', 'asda', 'Иванович', 'Иванов', '', 0);

DROP TABLE IF EXISTS `sch_users`;
CREATE TABLE `sch_users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` char(25) NOT NULL,
  `passwd` char(35) NOT NULL,
  `first_name` char(25) NOT NULL,
  `middle_name` char(25) NOT NULL,
  `last_name` char(25) NOT NULL,
  `access` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_users` VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '', '', '', 1);

