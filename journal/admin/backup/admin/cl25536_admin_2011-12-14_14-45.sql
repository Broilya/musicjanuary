#SKD101|cl25536_admin|28|2011.12.14 14:45:23|56|10|21|4|6|4|2|1|6|2

DROP TABLE IF EXISTS `all_representative`;
CREATE TABLE `all_representative` (
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

DROP TABLE IF EXISTS `all_schoole_represent`;
CREATE TABLE `all_schoole_represent` (
  `schrep_id` int(9) unsigned NOT NULL auto_increment,
  `representative_id` int(9) unsigned NOT NULL,
  `schoole_id` int(9) unsigned NOT NULL,
  `active` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY  (`schrep_id`),
  KEY `active` (`active`),
  KEY `representative_id` (`representative_id`),
  KEY `schoole_id` (`schoole_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `all_schools`;
CREATE TABLE `all_schools` (
  `school_id` int(9) unsigned NOT NULL auto_increment,
  `school_name` varchar(128) default NULL,
  `school_number` varchar(16) default NULL,
  `city` varchar(32) default NULL,
  `sub_domen` varchar(16) NOT NULL default '',
  `domen` varchar(64) NOT NULL default 'el-dn.ru',
  `username` varchar(32) NOT NULL,
  `basename` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `prefix` varchar(8) NOT NULL default 'sch' COMMENT 'префикс таблиц',
  `comment` varchar(255) default NULL,
  `active` tinyint(2) unsigned NOT NULL default '1',
  PRIMARY KEY  (`school_id`),
  UNIQUE KEY `sub_domen` (`sub_domen`),
  KEY `active` (`active`),
  KEY `prefix` (`prefix`),
  KEY `city` (`city`),
  KEY `username` (`username`),
  KEY `basename` (`basename`)
) ENGINE=MyISAM AUTO_INCREMENT=11 /*!40101 DEFAULT CHARSET=utf8 */ COMMENT='Таблица всех школ';

INSERT INTO `all_schools` VALUES
(1, 'admin', '0', 'Барнаул', 'admin', 'el-dn.ru', 'cl25536_admin', 'cl25536_admin', 'dnevadmin', 'sch_', '', 1),
(2, 'Тестовая 1', '1', NULL, 'demo', 'el-dn.ru', 'cl25536_demo', 'cl25536_demo', '111111', 'sch_', NULL, 1),
(3, 'ФГОУ СПО \"ЭГППК\"', '2', 'Энгельс', 'egppk', 'el-dn.ru', 'cl25536_egppk', 'cl25536_egppk', '111111', 'sch_', 'admin:fibk084 586mekg\n:a57d77b 123\nprep:9d28e4b 4cb0e7d39\nstudent:a758899  72853c549 ', 1),
(4, 'МОУ СОШ № 15', '15', 'Новочеркаск', 'nov15', 'el-dn.ru', 'cl25536_nov15', 'cl25536_nov15', 'nov15', 'sch_', 'fgdfgfgfdg', 1),
(5, 'МОУ СОШ 22', '22', 'Новочеркаск', 'nov22', 'el-dn.ru', 'cl25536_nov22', 'cl25536_nov22', 'nov22', 'sch_', NULL, 1),
(6, 'Школа 47', '47', 'Магнитогорск', 'mgn47', 'el-dn.ru', 'cl25536_mgn47', 'cl25536_mgn47', 'mgn47', 'sch_', NULL, 1),
(7, 'Гимназия № 1', '1', 'Благовещенск', 'blago1', 'el-dn.ru', 'cl25536_blago1', 'cl25536_blago1', 'dnevblago1', 'sch_', NULL, 1),
(8, 'Школа 14', '14', 'Благовещенск', 'blago14', 'el-dn.ru', 'cl25536_blago14', 'cl25536_blago14', 'dnevblago14', 'sch_', 'логин - cf32e3b\r\nпароль - 6845308\r\nй', 1),
(9, 'Школа 26', '26', 'Благовещенск', 'blago26', 'el-dn.ru', 'cl25536_blago26', 'cl25536_blago26', 'dnevblago26', 'sch_', NULL, 1),
(10, 'Школа 8', '8', 'vlad', 'vlad8', 'el-dn.ru', 'cl25536_vlad8', 'cl25536_vlad8', 'dnevvlad8', 'sch_', '', 1);

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
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */ COMMENT='Плюсовые - платежи, минусовые - начисления (R)';

DROP TABLE IF EXISTS `sch_classes`;
CREATE TABLE `sch_classes` (
  `class_id` int(10) unsigned NOT NULL auto_increment,
  `class` varchar(11) NOT NULL default '1',
  `letter` char(2) NOT NULL default '',
  `school_year` int(4) unsigned NOT NULL,
  `teacher_id` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`class_id`),
  UNIQUE KEY `class` (`class`,`letter`,`school_year`),
  KEY `school_year` (`school_year`),
  KEY `teacher_id` (`teacher_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_classes_in_groups`;
CREATE TABLE `sch_classes_in_groups` (
  `clsgrp_id` int(9) unsigned NOT NULL auto_increment,
  `group_id` smallint(2) unsigned NOT NULL,
  `class_id` int(9) unsigned NOT NULL,
  PRIMARY KEY  (`clsgrp_id`),
  KEY `group_id` (`group_id`),
  KEY `student_id` (`class_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_config`;
CREATE TABLE `sch_config` (
  `id_config` int(11) unsigned NOT NULL auto_increment,
  `desc_config` varchar(150) NOT NULL,
  `key_config` varchar(32) NOT NULL,
  `value_config` varchar(255) NOT NULL,
  `active` tinyint(2) unsigned NOT NULL default '1',
  PRIMARY KEY  (`id_config`),
  UNIQUE KEY `key_config` (`key_config`),
  KEY `active` (`active`)
) ENGINE=MyISAM AUTO_INCREMENT=22 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_config` VALUES
(1, 'Отключения инструкции смс запросов в ученическом разделе', 'SMS_ZAPROS', '1', 0),
(2, 'Префикс для получение оценок', 'SMS_PREFIKS_OZENKI', 'PINKOD', 0),
(3, 'Префикс для получение домашнего задания', 'SMS_PREFIKS_DZ', 'DOMZAD', 0),
(4, 'Колличество дней в неделе', 'DAYS', '0', 1),
(5, 'Префикс  языка', 'LANG', 'ru', 1),
(6, 'Русский', 'INTERFACE', 'ru', 1),
(7, 'Название школы', 'NAME_SCHOOL', 'admin', 1),
(8, 'Номер школы', 'NUM_SCHOOL', '0', 1),
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

DROP TABLE IF EXISTS `sch_disciplines`;
CREATE TABLE `sch_disciplines` (
  `discipline_id` int(10) unsigned NOT NULL auto_increment,
  `discipline` varchar(150) NOT NULL,
  PRIMARY KEY  (`discipline_id`),
  UNIQUE KEY `discipline` (`discipline`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_groups`;
CREATE TABLE `sch_groups` (
  `group_id` smallint(2) unsigned NOT NULL auto_increment,
  `group` varchar(32) default NULL,
  `short` varchar(8) default NULL,
  `active` tinyint(2) unsigned NOT NULL default '1',
  PRIMARY KEY  (`group_id`),
  KEY `active` (`active`)
) ENGINE=MyISAM AUTO_INCREMENT=5 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_groups` VALUES
(1, 'Девочки', 'Дев', 1),
(2, 'Мальчики', 'Мал', 1),
(3, 'Английский', 'Англ', 1),
(4, 'Немецкий', 'Нем', 1);

DROP TABLE IF EXISTS `sch_information`;
CREATE TABLE `sch_information` (
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

DROP TABLE IF EXISTS `sch_lessons`;
CREATE TABLE `sch_lessons` (
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
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

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
) ENGINE=MyISAM AUTO_INCREMENT=1451 /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_quarters`;
CREATE TABLE `sch_quarters` (
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
) ENGINE=MyISAM AUTO_INCREMENT=5 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_quarters` VALUES
(1, 1, '1 четверть', 1, 0, '2010-09-01', '2011-11-06'),
(2, 1, '2 четверть', 1, 1, '2011-11-14', '2011-12-31'),
(3, 1, '3 четверть', 1, 0, '2012-01-09', '2012-03-25'),
(4, 1, '4 четверть', 1, 0, '2012-01-09', '2012-04-01');

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

DROP TABLE IF EXISTS `sch_schedule`;
CREATE TABLE `sch_schedule` (
  `id_schedule` int(10) unsigned NOT NULL auto_increment,
  `date_schedule` int(2) unsigned NOT NULL COMMENT 'День недели 0-6',
  `school_year` int(4) unsigned NOT NULL,
  `quarter_id` int(6) unsigned NOT NULL default '0',
  `discipline_id` int(10) unsigned NOT NULL default '0',
  `class_id` int(10) unsigned NOT NULL default '0',
  `cabinet` varchar(30) default NULL,
  `teacher_id` int(10) unsigned NOT NULL default '0',
  `order_schedule` int(2) unsigned NOT NULL,
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
  KEY `finished` (`finished`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_school_years`;
CREATE TABLE `sch_school_years` (
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

INSERT INTO `sch_school_years` VALUES
(1, '2011 -2012 учебный год', 1, '2011-09-01', '2012-05-31');

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
  KEY `studless_id` (`studless_id`),
  KEY `student_id` (`student_id`,`date`),
  KEY `type` (`type`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_students`;
CREATE TABLE `sch_students` (
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
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_students_in_class`;
CREATE TABLE `sch_students_in_class` (
  `class_id` int(10) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `expeled` int(1) NOT NULL default '0',
  UNIQUE KEY `student_id` (`student_id`),
  KEY `class_id` (`class_id`),
  KEY `expeled` (`expeled`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_students_in_groups`;
CREATE TABLE `sch_students_in_groups` (
  `studgr_id` int(9) unsigned NOT NULL auto_increment,
  `group_id` smallint(2) unsigned NOT NULL,
  `student_id` int(9) unsigned NOT NULL,
  PRIMARY KEY  (`studgr_id`),
  KEY `group_id` (`group_id`),
  KEY `student_id` (`student_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_students_in_parent`;
CREATE TABLE `sch_students_in_parent` (
  `studparent_id` int(9) unsigned NOT NULL auto_increment,
  `parent_id` int(9) unsigned NOT NULL,
  `student_id` int(9) unsigned NOT NULL,
  PRIMARY KEY  (`studparent_id`),
  KEY `student_id` (`student_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2354 /*!40101 DEFAULT CHARSET=utf8 */;

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

DROP TABLE IF EXISTS `sch_students_on_lesson`;
CREATE TABLE `sch_students_on_lesson` (
  `studless_id` bigint(20) unsigned NOT NULL auto_increment,
  `student_id` int(10) unsigned NOT NULL,
  `lesson_id` int(10) unsigned NOT NULL,
  `grade` char(5) NOT NULL,
  `behavior` int(2) unsigned NOT NULL default '0',
  `quater` int(2) unsigned NOT NULL default '0',
  `subj_id` varchar(25) NOT NULL,
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

DROP TABLE IF EXISTS `sch_subjects`;
CREATE TABLE `sch_subjects` (
  `subject_id` int(10) unsigned NOT NULL auto_increment,
  `discipline_id` int(10) unsigned NOT NULL,
  `teacher_id` int(10) unsigned NOT NULL,
  `class_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`subject_id`),
  UNIQUE KEY `disciplines_id` (`discipline_id`,`teacher_id`,`class_id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `class_id` (`class_id`),
  KEY `discipline_id` (`discipline_id`)
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_teachers`;
CREATE TABLE `sch_teachers` (
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
) ENGINE=MyISAM /*!40101 DEFAULT CHARSET=utf8 */;

DROP TABLE IF EXISTS `sch_users`;
CREATE TABLE `sch_users` (
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
) ENGINE=MyISAM AUTO_INCREMENT=3 /*!40101 DEFAULT CHARSET=utf8 */;

INSERT INTO `sch_users` VALUES
(1, 'admin', '67a4a51b7eff62073bcb99b4604e2be7', '', '', 'СуперАдмин', 1),
(2, 'manager', 'd41d8cd98f00b204e9800998ecf8427e', '', '', 'Оператор', 1);

