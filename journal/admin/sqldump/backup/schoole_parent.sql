-- phpMyAdmin SQL Dump
-- version 3.3.2-rc1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Ноя 12 2011 г., 16:59
-- Версия сервера: 5.1.40
-- Версия PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `schoole_egppk`
--

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


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
