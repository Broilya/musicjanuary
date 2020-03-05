-- phpMyAdmin SQL Dump
-- version 3.3.2-rc1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Ноя 21 2011 г., 22:51
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
-- Структура таблицы `sch_classes_in_groups`
--

DROP TABLE IF EXISTS `sch_classes_in_groups`;
CREATE TABLE IF NOT EXISTS `sch_classes_in_groups` (
  `clsgrp_id` int(9) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` smallint(2) unsigned NOT NULL,
  `class_id` int(9) unsigned NOT NULL,
  PRIMARY KEY (`clsgrp_id`),
  KEY `group_id` (`group_id`),
  KEY `student_id` (`class_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Дамп данных таблицы `sch_classes_in_groups`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
