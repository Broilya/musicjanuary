<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
|                                                                 |
| Copyright (c) 2009-2012 <journal.schoole.ru>                      |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

#
# $Id: update.php 2011-04-010 $
#


include_once ('../init_update.php');
?>
<html>
  <head>
    <title>Школьный журнал</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/thickbox.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/thickbox.css" media="screen" />
  </head>
  <body>
<div align="center">


<?php
  db_query("UPDATE classes set school_year= (select school_year_id from school_years where current=1) ");
  
  db_query("ALTER TABLE  `classes` CHANGE `class` `class` VARCHAR( 20 ) NOT NULL DEFAULT '1'");
  
    db_query("ALTER TABLE `students` ADD COLUMN `active` tinyint(2)  unsigned NOT NULL  AFTER `student_id` ");
  db_query("ALTER TABLE `students` ADD COLUMN `mother_email` varchar(25) NOT NULL  AFTER `active` ");
 db_query("ALTER TABLE `students` ADD COLUMN `father_email` varchar(25) NOT NULL  AFTER `active` ");
 
 db_query("ALTER TABLE `students_on_lesson` ADD COLUMN `studless_id` bigint(20)  unsigned NOT NULL AFTER `student_id` ");
 db_query("ALTER TABLE `students_on_lesson` ADD COLUMN `date_grade` datetime ");
 db_query("ALTER TABLE `students_on_lesson` ADD COLUMN `date_note` datetime ");
 db_query("ALTER TABLE `students_on_lesson` ADD COLUMN `note` text ");
 db_query("ALTER TABLE  `students_on_lesson` CHANGE `grade` `grade` char(3) NOT NULL ");
 
 db_query("ALTER TABLE `information` ADD COLUMN `date_news` datetime ");
 db_query("ALTER TABLE `schedule` ADD COLUMN `quarter_id` int(6)  unsigned NOT NULL ");
 
 
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
   

  KEY  group_id (group_id)
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

?>
Обновление базы данных до версии 1.2 betta успешно завершено.
</div>
  </body>
</html>