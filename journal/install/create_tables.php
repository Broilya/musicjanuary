<?php


db_query("CREATE TABLE IF NOT EXISTS sch_config (
  id_config int(11) NOT NULL,
  desc_config varchar(150) NOT NULL,
  key_config varchar(100) NOT NULL,
  value_config varchar(30) NOT NULL,
  active tinyint(2)  unsigned NOT NULL,
  PRIMARY KEY (id_config)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

db_query("INSERT INTO `sch_config` (`id_config`, `desc_config`, `key_config`, `value_config`, `active`) VALUES
(1, 'Отключения инструкции смс запросов в ученическом разделе', 'SMS_ZAPROS', '0', '1'),
(2, 'Префикс для получение оценок', 'SMS_PREFIKS_OZENKI', 'PINKOD', '1'),
(3, 'Префикс для получение домашнего задания', 'SMS_PREFIKS_DZ', 'DOMZAD', '1'),
(4, 'Колличество дней в неделе', 'DAYS', '1', '1'),
(5, 'Префикс  языка', 'LANG', 'ru', '1'),
(6, 'Русский', 'INTERFACE', 'ru', '1'),
(7, 'Название школы', 'NAME_SCHOOL', 'Demo_versia', '1'),
(8, 'Номер школы', 'NUM_SCHOOL', '1', '1'),
(9, 'Количество дней тестового периода', 'TEST_DAYS', '30', '1'),
(10, 'Версия', 'VERSIY', '1.7 beta', '0')

");



db_query("CREATE TABLE IF NOT EXISTS sch_schedule (
  id_schedule int(11) NOT NULL AUTO_INCREMENT,
  date_schedule int(11) unsigned NOT NULL,
  school_year int(4) unsigned NOT NULL,
  quarter_id int(6)  unsigned NOT NULL,
  discipline_id int(11) unsigned NOT NULL,
  class_id int(11) unsigned NOT NULL,
  cabinet varchar(30) NOT NULL,
  order_schedule int(2) unsigned NOT NULL,
  teacher_id int(10) unsigned NOT NULL,
  group_id smallint(4)  unsigned NOT NULL,
  started date,
  finished date,
  
  PRIMARY KEY (`id_schedule`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

db_query("CREATE TABLE IF NOT EXISTS sch_classes (
  class_id int(10) unsigned NOT NULL auto_increment,
  class varchar(20) NOT NULL default '1',
  letter char(2) NOT NULL default '',
  school_year int(4) unsigned NOT NULL,
  teacher_id int(11) unsigned NOT NULL,
  PRIMARY KEY  (class_id),
  UNIQUE KEY class (class,letter,school_year)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

db_query("CREATE TABLE IF NOT EXISTS sch_disciplines (
  discipline_id int(10) unsigned NOT NULL auto_increment,
  discipline varchar(50) NOT NULL,
  PRIMARY KEY  (discipline_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8");



db_query("CREATE TABLE IF NOT EXISTS sch_lessons (
  lesson_id int(10) unsigned NOT NULL auto_increment,
  lesson_date date NOT NULL,
  subject_id int(10) unsigned NOT NULL,
  topic varchar(255) NOT NULL,
  dz varchar(100) NOT NULL,
  lesson_order int(2) NOT NULL,
  active bigint(20) NOT NULL default '0',
  
  schedule_id int(10)  unsigned NOT NULL,
  file varchar(64) NOT NULL default '0',
  date_dz datetime ,
  date_sched datetime ,
  
  PRIMARY KEY  (lesson_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");


db_query("CREATE TABLE IF NOT EXISTS sch_quarters (
  quarter_id bigint(20) unsigned NOT NULL auto_increment,
  school_year_id bigint(20) unsigned NOT NULL,
  quarter_name varchar(50) NOT NULL,
  quarter_type int(11) NOT NULL default '1',
  current int(11) NOT NULL default '0',
  started date NOT NULL,
  finished date NOT NULL,
  PRIMARY KEY  (quarter_id),
  KEY current (current),
  KEY school_year_id (school_year_id),
  KEY type_quarter (quarter_type)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");


db_query("CREATE TABLE IF NOT EXISTS sch_school_years (
  school_year_id bigint(20) NOT NULL auto_increment,
  name_year varchar(50) NOT NULL,
  current tinyint(2) NOT NULL default '0',
  started date NOT NULL,
  finished date NOT NULL,
  PRIMARY KEY  (school_year_id),
  KEY current (current)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");


db_query("CREATE TABLE IF NOT EXISTS sch_students (
  				   
  student_id int(10) unsigned NOT NULL auto_increment,
  last_name varchar(25) NOT NULL,
  first_name varchar(25) NOT NULL,
  middle_name varchar(25) NOT NULL,
  login varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  birthday date NOT NULL default '0000-00-00',
  address varchar(255) NOT NULL,
  phone varchar(25) NOT NULL,
  mother_fio varchar(50) NOT NULL,
  mother_work_phone varchar(25) NOT NULL,
  mother_cell_phone varchar(25) NOT NULL,
  father_fio varchar(50) NOT NULL,
  father_work_phone varchar(25) NOT NULL,
  father_cell_phone varchar(25) NOT NULL,
  pin_code int(6) unsigned NOT NULL,
  email varchar(25) NOT NULL,
  mother_email varchar(25) NOT NULL,
  father_email varchar(25) NOT NULL,
  photo varchar(50) default NULL,
  update_photo int(11) default '0',
    `send_from` date NOT NULL,
  `send_to` date NOT NULL,
  `mode` smallint(6) NOT NULL,
  active 	tinyint(2) unsigned NOT NULL,
  date_last 	date,
  PRIMARY KEY  (student_id),
  UNIQUE KEY pin_code (pin_code)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");


db_query("CREATE TABLE IF NOT EXISTS sch_students_in_class (
  class_id int(10) unsigned NOT NULL,
  student_id int(10) unsigned NOT NULL,
  expeled int(1) NOT NULL default '0',
  KEY class_id (class_id,student_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");


db_query("CREATE TABLE IF NOT EXISTS sch_students_on_lesson (
  studless_id bigint(20)  unsigned NOT NULL auto_increment,													 
  student_id int(10) unsigned NOT NULL,
  lesson_id 	int(10) unsigned NOT NULL,
  grade char(3) NOT NULL,
  behavior int(11) default NULL,
  quater varchar(255) NOT NULL,
  subj_id varchar(25) NOT NULL,
  date_grade 	datetime 	,
  date_note 	datetime,
  note 	text,
  
  KEY studless_id (studless_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");


db_query("CREATE TABLE IF NOT EXISTS sch_subjects (
  subject_id int(10) unsigned NOT NULL auto_increment,
  discipline_id int(10) unsigned NOT NULL,
  teacher_id int(10) unsigned NOT NULL,
  class_id int(11) unsigned NOT NULL,
  PRIMARY KEY  (subject_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");


db_query("CREATE TABLE IF NOT EXISTS sch_teachers (
  teacher_id int(10) unsigned NOT NULL auto_increment,
  login varchar(25) NOT NULL,
  passwd varchar(32) NOT NULL,
  first_name varchar(25) NOT NULL,
  middle_name varchar(25) NOT NULL,
  last_name varchar(25) NOT NULL,
  photo varchar(50) NOT NULL,
  director tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (teacher_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

db_query("CREATE TABLE IF NOT EXISTS sch_users (
  user_id int(10) unsigned NOT NULL auto_increment,
  login char(25) character set utf8 NOT NULL,
  passwd char(35) character set utf8 NOT NULL,
  first_name char(25) character set utf8 NOT NULL,
  middle_name char(25) character set utf8 NOT NULL,
  last_name char(25) character set utf8 NOT NULL,
  access int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (user_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

db_query("CREATE TABLE sch_information (
  information_id int(11) NOT NULL auto_increment,
  information_date date NOT NULL default '0000-00-00',
  information_title varchar(100) character set utf8 default NULL,
  information_text varchar(500) character set utf8 default NULL,
  information_section enum('teacher','parent','student','balance','personal','all'),
  information_classes int(11) unsigned NOT NULL,
  date_news datetime,
  KEY information_id (information_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

db_query("CREATE TABLE sch_balance (
  id bigint(20)  unsigned NOT NULL auto_increment,
  student_id int(10) unsigned NOT NULL,
  date_add date,
  summa int(10),
  operator_id smallint(4),
  usluga_id smallint(5) unsigned NOT NULL,
  nomer varchar(64),
  date_edit datetime ,
  is_use tinyint(1) unsigned NOT NULL,
  active tinyint(1) unsigned NOT NULL,
  period_id smallint(3) unsigned NOT NULL,
	
  KEY id  (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

db_query("CREATE TABLE sch_classes_in_groups (
  clsgrp_id int(9)   unsigned NOT NULL auto_increment,
  group_id smallint(2)  unsigned NOT NULL,
  class_id int(9) unsigned NOT NULL,

  KEY  clsgrp_id (clsgrp_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

db_query("CREATE TABLE sch_groups (
  
  group_id smallint(2)  unsigned NOT NULL auto_increment,
  active 	tinyint(2) unsigned NOT NULL,
  
  
   KEY group_id (group_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

db_query("CREATE TABLE sch_operator (
  id smallint(2)  unsigned NOT NULL auto_increment,
  name varchar(32),
  path varchar(32),
  path_out 	varchar(32), 
  file 	varchar(16),
  active 	tinyint(1),

  KEY  id (id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

db_query("CREATE TABLE sch_parents (
 parent_id 	int(10)   unsigned NOT NULL auto_increment,
  last_name 	varchar(25),
  first_name 	varchar(25),
  middle_name 	varchar(25), 
  login 	varchar(32),
  password 	varchar(32) ,
  relative_id 	smallint(2)  unsigned NOT NULL ,
  address 	varchar(255),
  phone 	varchar(25),
  work_phone 	varchar(25),
  cell_phone 	varchar(25),
  email 	varchar(25),
  active 	tinyint(2) unsigned NOT NULL,

  KEY  parent_id (parent_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

db_query("CREATE TABLE sch_relatives (
 relative_id 	smallint(2)   unsigned NOT NULL auto_increment,
  relative 	varchar(16),
  
  KEY  relative_id  (relative_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

db_query("CREATE TABLE sch_representative (
 representative_id 	int(9)    unsigned NOT NULL auto_increment,
  login 	varchar(32),
  password 	varchar(32),
  first_name 	varchar(32),
  middl_name 	varchar(32),
  last_name 	varchar(32),
  phone 	varchar(16),
  mobile_phone 	varchar(16),
  city 	varchar(32),
  active 	tinyint(2) unsigned NOT NULL,
  
  KEY  representative_id  (representative_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

db_query("CREATE TABLE sch_schoole_represent (
 schrep_id 	int(9)     unsigned NOT NULL auto_increment,
  representative_id 	int(9)  unsigned NOT NULL,
  schoole_id 	int(9)  unsigned NOT NULL,
  active 	tinyint(2)  unsigned NOT NULL,
   
  KEY  schrep_id  (schrep_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

db_query("CREATE TABLE sch_services (
 service_id 	int(4)      unsigned NOT NULL auto_increment,
  service_name 	varchar(32) , 		
	tarif 	int(10) 	unsigned NOT NULL,	
	kod 	varchar(16) ,	 	
	tarif01 	int(10) unsigned NOT NULL,		
	tarif02 	int(10) unsigned NOT NULL,		
	tarif03 	int(10) unsigned NOT NULL,		
	tarif04 	int(10) unsigned NOT NULL,		
	tarif05 	int(10) unsigned NOT NULL,		
	tarif06 	int(10) unsigned NOT NULL,		
	tarif07 	int(10) unsigned NOT NULL, 		
	tarif08 	int(10) unsigned NOT NULL,		
	tarif09 	int(10) unsigned NOT NULL,		
	tarif10 	int(10) unsigned NOT NULL,		
	tarif11 	int(10) unsigned NOT NULL,		
	tarif12 	int(10) unsigned NOT NULL,		
	required 	tinyint(2) unsigned NOT NULL,		
	dotation 	tinyint(2) unsigned NOT NULL,		
	active 	tinyint(2) unsigned NOT NULL,
   
  KEY  service_id  (service_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");



db_query("CREATE TABLE sch_students_in_groups (
 service_id 	int(9)      unsigned NOT NULL auto_increment,
	group_id 	smallint(2) unsigned NOT NULL,		
	student_id 	int(9) 	unsigned NOT NULL,
   
  KEY  service_id  (service_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

db_query("CREATE TABLE sch_students_in_parent (
studparent_id 	int(9) 	unsigned NOT NULL auto_increment,	
	parent_id 	int(9) 	unsigned NOT NULL,	
	student_id 	int(9)  unsigned NOT NULL,
   
  KEY  studparent_id   (studparent_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

db_query("CREATE TABLE sch_students_in_service (
	student_id 	int(10) unsigned NOT NULL auto_increment,	
	service_id 	int(10) unsigned NOT NULL,	
	date_add 	date,			
	tarif int(10) unsigned NOT NULL,
   
  KEY  student_id   (student_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

db_query("CREATE TABLE sch_sms_logs (
	sms_id 	bigint(20)  unsigned NOT NULL auto_increment,	
	sstudless_id 	varchar(120),	
	student_id 	int(10) unsigned NOT NULL,			
	type 	enum('g','d','z','s','n','m'),
	date 	datetime,
	text 	text,
   
  KEY  sms_id   (sms_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

db_query("ALTER TABLE `sch_groups` ADD COLUMN `group` varchar(32) character set utf8 default NULL AFTER `group_id` ");
  db_query("ALTER TABLE `sch_groups` ADD COLUMN `short` varchar(8) character set utf8 default NULL AFTER `group_id` ");
  
 db_query("CREATE TABLE sch_schools (
  schoole_id int(9)  unsigned NOT NULL auto_increment,
  schoole_name varchar(128) ,
  schoole_number varchar(16) ,
  city varchar(64) ,
  sub_domen varchar(64) ,
  domen varchar(64) ,
  username varchar(64),
  basename varchar(64),
  password varchar(64),
  prefix varchar(64) default 'sch_',
  comment varchar(255),
  active tinyint(2) unsigned NOT NULL,
	
  KEY schoole_id  (schoole_id)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");  

?>