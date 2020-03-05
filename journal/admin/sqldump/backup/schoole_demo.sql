--

-- --------------------------------------------------------

--
-- Структура таблицы `classes`
--

DROP TABLE IF EXISTS `classes`;
CREATE TABLE IF NOT EXISTS `classes` (
  `class_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class` varchar(11) NOT NULL DEFAULT '1',
  `letter` char(2) NOT NULL DEFAULT '',
  `school_year` int(4) unsigned NOT NULL,
  `teacher_id` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`class_id`),
  UNIQUE KEY `class` (`class`,`letter`,`school_year`),
  KEY `school_year` (`school_year`),
  KEY `teacher_id` (`teacher_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `classes`
--


-- --------------------------------------------------------

--
-- Структура таблицы `config`
--

DROP TABLE IF EXISTS `config`;
CREATE TABLE IF NOT EXISTS `config` (
  `id_config` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `desc_config` varchar(150) NOT NULL,
  `key_config` varchar(32) NOT NULL,
  `value_config` varchar(255) NOT NULL,
  `active` tinyint(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_config`),
  UNIQUE KEY `key_config` (`key_config`),
  KEY `active` (`active`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Дамп данных таблицы `config`
--

INSERT INTO `config` VALUES(1, 'Отключения инструкции смс запросов в ученическом разделе', 'SMS_ZAPROS', '1', 0);
INSERT INTO `config` VALUES(2, 'Префикс для получение оценок', 'SMS_PREFIKS_OZENKI', 'PINKOD', 0);
INSERT INTO `config` VALUES(3, 'Префикс для получение домашнего задания', 'SMS_PREFIKS_DZ', 'DOMZAD', 0);
INSERT INTO `config` VALUES(4, 'Колличество дней в неделе', 'DAYS', '0', 1);
INSERT INTO `config` VALUES(5, 'Префикс  языка', 'LANG', 'ru', 1);
INSERT INTO `config` VALUES(6, 'Русский', 'INTERFACE', 'ru', 1);
INSERT INTO `config` VALUES(7, 'Название школы', 'NAME_SCHOOL', 'ФГОУ СПО "ЭГППК"', 1);
INSERT INTO `config` VALUES(8, 'Номер школы', 'NUM_SCHOOL', '2', 1);
INSERT INTO `config` VALUES(9, 'Количество дней тестового периода', 'TEST_DAYS', '14', 1);
INSERT INTO `config` VALUES(10, 'Касса', 'KASSA', '1', 1);
INSERT INTO `config` VALUES(11, 'Система Город', 'CITYSYSTEM', '2', 1);
INSERT INTO `config` VALUES(12, 'QuickPay', 'QUICKPAY', '3', 1);
INSERT INTO `config` VALUES(13, 'СберБанк', 'SBERBANK', '4', 1);
INSERT INTO `config` VALUES(14, 'Оплата тестового периода', 'TESTPAY', '-1', 1);
INSERT INTO `config` VALUES(15, 'Дотация', 'DOTATION', '-2', 1);
INSERT INTO `config` VALUES(16, 'Доступ к сайту', 'SERV_SITE', '1', 1);
INSERT INTO `config` VALUES(17, 'Отсылка смс с оценками', 'SERV_SMS_GRADE', '2', 1);
INSERT INTO `config` VALUES(18, 'Отсылка смс с замечаниями', 'SERV_SMS_NOTE', '3', 1);
INSERT INTO `config` VALUES(19, 'Отсылка смс с домашними заданиям', 'SERV_SMS_WHOME', '4', 1);
INSERT INTO `config` VALUES(20, 'Отсылка смс с расписанием на зав', 'SERV_SMS_SCHED', '5', 1);
INSERT INTO `config` VALUES(21, 'Отсылка смс с новостями школы', 'SERV_SMS_NEWS', '6', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `disciplines`
--

DROP TABLE IF EXISTS `disciplines`;
CREATE TABLE IF NOT EXISTS `disciplines` (
  `discipline_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `discipline` varchar(150) NOT NULL,
  PRIMARY KEY (`discipline_id`),
  UNIQUE KEY `discipline` (`discipline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `disciplines`
--


-- --------------------------------------------------------

--
-- Структура таблицы `information`
--

DROP TABLE IF EXISTS `information`;
CREATE TABLE IF NOT EXISTS `information` (
  `information_id` int(11) NOT NULL AUTO_INCREMENT,
  `information_date` date NOT NULL DEFAULT '0000-00-00',
  `information_title` varchar(100) DEFAULT NULL,
  `information_text` varchar(500) DEFAULT NULL,
  `information_section` enum('teacher','student','balance','all') NOT NULL DEFAULT 'all',
  `information_classes` int(11) unsigned NOT NULL,
  `date_news` datetime DEFAULT NULL COMMENT 'дата отсылки новости',
  KEY `information_id` (`information_id`),
  KEY `information_date` (`information_date`),
  KEY `information_section` (`information_section`),
  KEY `information_classes` (`information_classes`),
  KEY `date_news` (`date_news`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `information`
--


-- --------------------------------------------------------

--
-- Структура таблицы `lessons`
--

DROP TABLE IF EXISTS `lessons`;
CREATE TABLE IF NOT EXISTS `lessons` (
  `lesson_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lesson_date` date NOT NULL,
  `subject_id` int(10) unsigned NOT NULL,
  `topic` varchar(100) DEFAULT NULL,
  `dz` text,
  `lesson_order` int(2) NOT NULL,
  `active` bigint(20) NOT NULL DEFAULT '0',
  `schedule_id` int(10) unsigned DEFAULT NULL,
  `file` varchar(64) DEFAULT NULL,
  `date_dz` datetime DEFAULT NULL COMMENT 'дата отсылки домашки',
  `date_sched` datetime DEFAULT NULL COMMENT 'дата отсылки расписания',
  PRIMARY KEY (`lesson_id`),
  KEY `lesson_date` (`lesson_date`),
  KEY `subject_id` (`subject_id`),
  KEY `lesson_order` (`lesson_order`),
  KEY `active` (`active`),
  KEY `schedule_id` (`schedule_id`),
  KEY `date_dz` (`date_dz`),
  KEY `date_sched` (`date_sched`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `lessons`
--


-- --------------------------------------------------------

--
-- Структура таблицы `quarters`
--

DROP TABLE IF EXISTS `quarters`;
CREATE TABLE IF NOT EXISTS `quarters` (
  `quarter_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `school_year_id` int(4) unsigned NOT NULL DEFAULT '0',
  `quarter_name` varchar(50) NOT NULL,
  `quarter_type` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `current` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `started` date NOT NULL,
  `finished` date NOT NULL,
  PRIMARY KEY (`quarter_id`),
  KEY `current` (`current`),
  KEY `school_year_id` (`school_year_id`),
  KEY `started` (`started`),
  KEY `finished` (`finished`),
  KEY `quarter_type` (`quarter_type`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `quarters`
--

INSERT INTO `quarters` VALUES(1, 1, '1 четверть', 1, 0, '2011-09-01', '2011-10-28');
INSERT INTO `quarters` VALUES(2, 1, '2 четверть', 1, 1, '2011-10-31', '2011-12-31');
INSERT INTO `quarters` VALUES(3, 1, '3 четверть', 1, 0, '2012-01-09', '2012-03-25');
INSERT INTO `quarters` VALUES(4, 1, '4 четверть', 1, 0, '2012-01-09', '2012-04-01');
INSERT INTO `quarters` VALUES(5, 2, '1 четверть', 1, 0, '2010-09-01', '2010-11-01');
INSERT INTO `quarters` VALUES(6, 3, '', 1, 0, '0000-00-00', '0000-00-00');

-- --------------------------------------------------------

--
-- Структура таблицы `schedule`
--

DROP TABLE IF EXISTS `schedule`;
CREATE TABLE IF NOT EXISTS `schedule` (
  `id_schedule` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_schedule` int(2) unsigned NOT NULL COMMENT 'День недели 0-6',
  `school_year` int(4) unsigned NOT NULL,
  `quarter_id` int(6) unsigned NOT NULL DEFAULT '0',
  `discipline_id` int(10) unsigned NOT NULL DEFAULT '0',
  `class_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cabinet` varchar(30) DEFAULT NULL,
  `teacher_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_schedule` int(2) unsigned NOT NULL,
  `group_id` smallint(4) unsigned NOT NULL DEFAULT '0',
  `started` date NOT NULL DEFAULT '0000-00-00' COMMENT 'дата включения',
  `finished` date NOT NULL DEFAULT '0000-00-00' COMMENT 'дата отключения',
  PRIMARY KEY (`id_schedule`),
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `schedule`
--


-- --------------------------------------------------------

--
-- Структура таблицы `school_years`
--

DROP TABLE IF EXISTS `school_years`;
CREATE TABLE IF NOT EXISTS `school_years` (
  `school_year_id` int(10) NOT NULL AUTO_INCREMENT,
  `name_year` varchar(50) NOT NULL,
  `current` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `started` date NOT NULL,
  `finished` date NOT NULL,
  PRIMARY KEY (`school_year_id`),
  KEY `current` (`current`),
  KEY `started` (`started`),
  KEY `finished` (`finished`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `school_years`
--

INSERT INTO `school_years` VALUES(1, '2011 -2012 учебный год', 1, '2011-09-01', '2012-07-04');
INSERT INTO `school_years` VALUES(3, '2010 -2011 учебный год', 0, '2010-09-01', '2011-05-31');

-- --------------------------------------------------------

--
-- Структура таблицы `sch_balance`
--

DROP TABLE IF EXISTS `sch_balance`;
CREATE TABLE IF NOT EXISTS `sch_balance` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(10) unsigned NOT NULL,
  `date_add` date DEFAULT NULL,
  `summa` int(10) NOT NULL DEFAULT '0',
  `operator_id` smallint(4) NOT NULL DEFAULT '0',
  `usluga_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'ДопУслуга',
  `nomer` varchar(64) NOT NULL DEFAULT '',
  `date_edit` datetime NOT NULL,
  `is_use` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `period_id` smallint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `date_edit` (`date_edit`),
  KEY `active` (`active`),
  KEY `is_use` (`is_use`),
  KEY `nomer` (`nomer`),
  KEY `usluga` (`usluga_id`),
  KEY `student_id` (`student_id`),
  KEY `operator_id` (`operator_id`),
  KEY `period_id` (`period_id`),
  KEY `date_add` (`date_add`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Плюсовые - платежи, минусовые - начисления (R)' AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `sch_balance`
--


-- --------------------------------------------------------

--
-- Структура таблицы `sch_groups`
--

DROP TABLE IF EXISTS `sch_groups`;
CREATE TABLE IF NOT EXISTS `sch_groups` (
  `group_id` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(32) DEFAULT NULL,
  `short` varchar(8) DEFAULT NULL,
  `active` tinyint(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`group_id`),
  KEY `active` (`active`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `sch_groups`
--

INSERT INTO `sch_groups` VALUES(1, 'Девочки', 'Дев', 1);
INSERT INTO `sch_groups` VALUES(2, 'Мальчики', 'Мал', 1);
INSERT INTO `sch_groups` VALUES(3, 'Английский', 'Англ', 1);
INSERT INTO `sch_groups` VALUES(4, 'Немецкий', 'Нем', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sch_operator`
--

DROP TABLE IF EXISTS `sch_operator`;
CREATE TABLE IF NOT EXISTS `sch_operator` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) DEFAULT NULL,
  `path` varchar(32) NOT NULL DEFAULT 'data/',
  `path_out` varchar(32) NOT NULL DEFAULT 'data/',
  `file` varchar(16) DEFAULT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Название Оператора' AUTO_INCREMENT=5 ;

--
-- Дамп данных таблицы `sch_operator`
--

INSERT INTO `sch_operator` VALUES(1, 'касса', 'data/cassa', 'data/cassa', 'KASSA', 1);
INSERT INTO `sch_operator` VALUES(2, 'Система Город', 'data/citysystem', 'data/citysystem/saldo', 'CITYSYSTEM', 1);
INSERT INTO `sch_operator` VALUES(3, 'QuickPay', 'data/quickpay', 'data/quickpay', 'QUICKPAY', 1);
INSERT INTO `sch_operator` VALUES(4, 'СберБанк', 'data/bv', 'data/bv', 'SBERBANK', 1);
INSERT INTO `sch_operator` VALUES(-1, 'Оплата тестового периода', 'data/', 'data/', 'TESTPAY', 1);
INSERT INTO `sch_operator` VALUES(-2, 'Дотация', 'data/', 'data/', 'DOTATION', 1);

-- --------------------------------------------------------
--
-- Структура таблицы `sch_parents`
--

DROP TABLE IF EXISTS `sch_parents`;
CREATE TABLE IF NOT EXISTS `sch_parents` (
  `parent_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `last_name` varchar(25) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `middle_name` varchar(25) NOT NULL,
  `login` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `relative_id` smallint(2) unsigned NOT NULL DEFAULT '1',
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `work_phone` varchar(25) DEFAULT NULL,
  `cell_phone` varchar(25) DEFAULT NULL,
  `email` varchar(25) DEFAULT NULL,
  `active` tinyint(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`parent_id`),
  UNIQUE KEY `login` (`login`),
  KEY `active` (`active`),
  KEY `last_name` (`last_name`),
  KEY `password` (`password`),
  KEY `relative_id` (`relative_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `sch_parents`
--


-- --------------------------------------------------------

--
-- Структура таблицы `sch_relatives`
--

DROP TABLE IF EXISTS `sch_relatives`;
CREATE TABLE IF NOT EXISTS `sch_relatives` (
  `relative_id` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `relative` varchar(16) NOT NULL,
  PRIMARY KEY (`relative_id`),
  UNIQUE KEY `relative` (`relative`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `sch_relatives`
--

INSERT INTO `sch_relatives` VALUES(1, 'мать');
INSERT INTO `sch_relatives` VALUES(2, 'отец');

-- --------------------------------------------------------

--
-- Структура таблицы `sch_students_in_parent`
--

DROP TABLE IF EXISTS `sch_students_in_parent`;
CREATE TABLE IF NOT EXISTS `sch_students_in_parent` (
  `studparent_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(9) unsigned NOT NULL,
  `student_id` int(9) unsigned NOT NULL,
  PRIMARY KEY (`studparent_id`),
  KEY `student_id` (`student_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `sch_students_in_parent`
--

-- --------------------------------------------------------

--
-- Структура таблицы `sch_representative`
--

DROP TABLE IF EXISTS `sch_representative`;
CREATE TABLE IF NOT EXISTS `sch_representative` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `sch_representative`
--


-- --------------------------------------------------------

--
-- Структура таблицы `sch_schoole_represent`
--

DROP TABLE IF EXISTS `sch_schoole_represent`;
CREATE TABLE IF NOT EXISTS `sch_schoole_represent` (
  `schrep_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `representative_id` int(9) unsigned NOT NULL,
  `schoole_id` int(9) unsigned NOT NULL,
  `active` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`schrep_id`),
  KEY `active` (`active`),
  KEY `representative_id` (`representative_id`),
  KEY `schoole_id` (`schoole_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `sch_schoole_represent`
--


-- --------------------------------------------------------

--
-- Структура таблицы `sch_schools`
--

DROP TABLE IF EXISTS `sch_schools`;
CREATE TABLE IF NOT EXISTS `sch_schools` (
  `schoole_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `schoole_name` varchar(128) DEFAULT NULL,
  `schoole_number` varchar(16) DEFAULT NULL,
  `city` varchar(32) DEFAULT NULL,
  `sub_domen` varchar(16) NOT NULL DEFAULT '',
  `domen` varchar(64) NOT NULL DEFAULT 'el-dn.ru',
  `username` varchar(32) NOT NULL,
  `basename` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `prefix` varchar(8) NOT NULL DEFAULT 'sch' COMMENT 'префикс таблиц',
  `comment` varchar(255) DEFAULT NULL,
  `active` tinyint(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`schoole_id`),
  UNIQUE KEY `sub_domen` (`sub_domen`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `basename` (`basename`),
  KEY `active` (`active`),
  KEY `prefix` (`prefix`),
  KEY `city` (`city`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Таблица всех школ' AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `sch_schools`
--

INSERT INTO `sch_schools` VALUES(1, 'admin', '0', NULL, 'admin', 'el-dn.ru', 'cl25536_el', 'cl25536_el', '111111', 'sch', NULL, 1);
INSERT INTO `sch_schools` VALUES(2, 'Тестовая 1', '1', NULL, 'demo', 'el-dn.ru', 'cl25536_demo', 'cl25536_demo', '111111', '', NULL, 1);
INSERT INTO `sch_schools` VALUES(3, 'ФГОУ СПО "ЭГППК"', '2', 'Энгельс', 'egppk', 'el-dn.ru', 'cl25536_egppk', 'cl25536_egppk', '111111', '', 'admin:fibk084 586mekg\n:a57d77b 123\nprep:9d28e4b 4cb0e7d39\nstudent:a758899  72853c549 ', 1);
INSERT INTO `sch_schools` VALUES(4, 'МОУ СОШ 15', '15', 'Новочеркаск', 'nov15', 'el-dn.ru', 'cl25536_nov15', 'cl25536_nov15', 'nov15', '', NULL, 1);
INSERT INTO `sch_schools` VALUES(5, 'МОУ СОШ 22', '22', 'Новочеркаск', 'nov22', 'el-dn.ru', 'cl25536_nov22', 'cl25536_nov22', 'nov22', '', NULL, 1);
INSERT INTO `sch_schools` VALUES(6, 'Школа 47', '47', 'Магнитогорск', 'mgn47', 'el-dn.ru', 'cl25536_mgn47', 'cl25536_mgn47', 'mgn47', '', NULL, 1);
INSERT INTO `sch_schools` VALUES(7, 'Гимназия № 1', '1', 'Благовещенск', 'blago1', 'el-dn.ru', 'cl25536_blago1', 'cl25536_blago1', 'dnevblago1', '', NULL, 1);
INSERT INTO `sch_schools` VALUES(8, 'Школа 14', '14', 'Благовещенск', 'blago14', 'el-dn.ru', 'cl25536_blago14', 'cl25536_blago14', 'dnevblago14', '', 'логин - cf32e3b\nпароль - 6845308', 1);
INSERT INTO `sch_schools` VALUES(9, 'Школа 26', '26', 'Благовещенск', 'blago26', 'el-dn.ru', 'cl25536_blago26', 'cl25536_blago26', 'dnevblago26', '', NULL, 1);
INSERT INTO `sch_schools` VALUES(10, 'Школа 8', '8', 'vlad', 'vlad8', 'el-dn.ru', 'cl25536_vlad8', 'cl25536_vlad8', 'dnevvlad8', '', NULL, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sch_services`
--

DROP TABLE IF EXISTS `sch_services`;
CREATE TABLE IF NOT EXISTS `sch_services` (
  `service_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `service_name` varchar(32) NOT NULL,
  `tarif` int(10) unsigned NOT NULL DEFAULT '0',
  `kod` varchar(16) NOT NULL DEFAULT '',
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
  `required` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'Обязательный сервис',
  `dotation` tinyint(2) unsigned NOT NULL DEFAULT '0' COMMENT 'Дотация',
  `active` tinyint(2) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`service_id`),
  KEY `required` (`required`),
  KEY `active` (`active`),
  KEY `kod` (`kod`),
  KEY `dotation` (`dotation`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `sch_services`
--

INSERT INTO `sch_services` VALUES(1, 'Доступ к сайту', 3000, 'SERV_SITE', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1);
INSERT INTO `sch_services` VALUES(2, 'Отсылка смс с оценками', 2500, 'SERV_SMS_GRADE', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1);
INSERT INTO `sch_services` VALUES(3, 'Отсылка смс с замечаниями', 2000, 'SERV_SMS_NOTE', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `sch_services` VALUES(4, 'Отсылка смс с домашними заданиям', 3000, 'SERV_SMS_WHOME', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `sch_services` VALUES(5, 'Отсылка смс с расписанием на зав', 2000, 'SERV_SMS_SCHED', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);
INSERT INTO `sch_services` VALUES(6, 'Отсылка смс с новостями школы', 2500, 'SERV_SMS_NEWS', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sch_sms_logs`
--

DROP TABLE IF EXISTS `sch_sms_logs`;
CREATE TABLE IF NOT EXISTS `sch_sms_logs` (
  `sms_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `studless_id` varchar(120) DEFAULT NULL,
  `student_id` int(10) unsigned NOT NULL DEFAULT '0',
  `type` enum('g','d','z','s','n') NOT NULL DEFAULT 'g',
  `date` datetime DEFAULT NULL,
  `text` text,
  PRIMARY KEY (`sms_id`),
  KEY `student_id` (`student_id`,`date`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `sch_sms_logs`
--


-- --------------------------------------------------------

--
-- Структура таблицы `sch_students_in_groups`
--

DROP TABLE IF EXISTS `sch_students_in_groups`;
CREATE TABLE IF NOT EXISTS `sch_students_in_groups` (
  `studgr_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` smallint(2) unsigned NOT NULL,
  `student_id` int(9) unsigned NOT NULL,
  PRIMARY KEY (`studgr_id`),
  KEY `group_id` (`group_id`),
  KEY `student_id` (`student_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `sch_students_in_groups`
--


-- --------------------------------------------------------

--
-- Структура таблицы `sch_students_in_service`
--

DROP TABLE IF EXISTS `sch_students_in_service`;
CREATE TABLE IF NOT EXISTS `sch_students_in_service` (
  `student_id` int(10) unsigned NOT NULL,
  `service_id` int(10) unsigned NOT NULL,
  `date_add` date NOT NULL DEFAULT '2011-10-01',
  `tarif` int(10) unsigned NOT NULL DEFAULT '0',
  UNIQUE KEY `student_id_2` (`student_id`,`service_id`),
  KEY `service_id` (`service_id`),
  KEY `date_add` (`date_add`),
  KEY `student_id` (`student_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sch_students_in_service`
--


-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `student_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `last_name` varchar(25) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `middle_name` varchar(25) NOT NULL,
  `login` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `birthday` date NOT NULL DEFAULT '0000-00-00',
  `address` varchar(255) NOT NULL,
  `phone` varchar(25) NOT NULL,
  `mother_fio` varchar(50) NOT NULL,
  `mother_work_phone` varchar(25) NOT NULL,
  `mother_cell_phone` varchar(25) NOT NULL,
  `father_fio` varchar(50) NOT NULL,
  `father_work_phone` varchar(25) NOT NULL,
  `father_cell_phone` varchar(25) NOT NULL,
  `pin_code` int(6) unsigned NOT NULL DEFAULT '0',
  `email` varchar(25) NOT NULL,
  `photo` varchar(50) DEFAULT NULL,
  `update_photo` int(10) unsigned DEFAULT '0',
  `send_from` date NOT NULL,
  `send_to` date NOT NULL,
  `mode` smallint(6) unsigned NOT NULL,
  `active` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `date_last` date NOT NULL DEFAULT '2011-10-01',
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `pin_code` (`pin_code`),
  UNIQUE KEY `login` (`login`),
  KEY `active` (`active`),
  KEY `mode` (`mode`),
  KEY `last_name` (`last_name`),
  KEY `password` (`password`),
  KEY `date_last` (`date_last`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `students`
--


-- --------------------------------------------------------

--
-- Структура таблицы `students_in_class`
--

DROP TABLE IF EXISTS `students_in_class`;
CREATE TABLE IF NOT EXISTS `students_in_class` (
  `class_id` int(10) unsigned NOT NULL,
  `student_id` int(10) unsigned NOT NULL,
  `expeled` int(1) NOT NULL DEFAULT '0',
  UNIQUE KEY `student_id` (`student_id`),
  KEY `class_id` (`class_id`),
  KEY `expeled` (`expeled`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `students_in_class`
--


-- --------------------------------------------------------

--
-- Структура таблицы `students_on_lesson`
--

DROP TABLE IF EXISTS `students_on_lesson`;
CREATE TABLE IF NOT EXISTS `students_on_lesson` (
  `studless_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(10) unsigned NOT NULL,
  `lesson_id` int(10) unsigned NOT NULL,
  `grade` char(5) NOT NULL,
  `behavior` int(2) unsigned NOT NULL DEFAULT '0',
  `quater` int(2) unsigned NOT NULL DEFAULT '0',
  `subj_id` int(10) unsigned NOT NULL,
  `date_grade` datetime DEFAULT NULL COMMENT 'дата отсылки оценок',
  `date_note` datetime DEFAULT NULL COMMENT 'дата отсылки замечаний',
  `note` text COMMENT 'Замечания',
  PRIMARY KEY (`studless_id`),
  KEY `student_id` (`student_id`),
  KEY `lesson_id` (`lesson_id`),
  KEY `quater` (`quater`),
  KEY `subj_id` (`subj_id`),
  KEY `date_grade` (`date_grade`),
  KEY `date_note` (`date_note`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `students_on_lesson`
--


-- --------------------------------------------------------

--
-- Структура таблицы `subjects`
--

DROP TABLE IF EXISTS `subjects`;
CREATE TABLE IF NOT EXISTS `subjects` (
  `subject_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `discipline_id` int(10) unsigned NOT NULL,
  `teacher_id` int(10) unsigned NOT NULL,
  `class_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`subject_id`),
  KEY `teacher_id` (`teacher_id`),
  KEY `class_id` (`class_id`),
  KEY `discipline_id` (`discipline_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `subjects`
--


-- --------------------------------------------------------

--
-- Структура таблицы `teachers`
--

DROP TABLE IF EXISTS `teachers`;
CREATE TABLE IF NOT EXISTS `teachers` (
  `teacher_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(25) NOT NULL,
  `passwd` varchar(32) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `middle_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `photo` varchar(50) NOT NULL,
  `director` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`teacher_id`),
  UNIQUE KEY `login` (`login`),
  KEY `passwd` (`passwd`),
  KEY `last_name` (`last_name`),
  KEY `director` (`director`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `teachers`
--


-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` VALUES(1, 'admin', '67a4a51b7eff62073bcb99b4604e2be7', '', '', 'СуперАдмин', 1);
INSERT INTO `users` VALUES(2, 'manager', MD5('manager'), '', '', 'Оператор', 1);
INSERT INTO `users` VALUES(4, 'arthur', '68830aef4dbfad181162f9251a1da51b', 'Артур', '', '', 1);
INSERT INTO `users` VALUES(5, 'armonsoft', '96e79218965eb72c92a549dd5a330112', 'А', 'А', 'Вензелев', 1);
INSERT INTO `users` VALUES(6, 'SLIPPERY', 'c4ca4238a0b923820dcc509a6f75849b', '', '', 'Поздняков', 1);

