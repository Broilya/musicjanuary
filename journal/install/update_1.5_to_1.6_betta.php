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
    <script type="text/javascript" src="../js/jquery.js"></script>
    <script type="text/javascript" src="../js/thickbox.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <link rel="stylesheet" type="text/css" href="../css/thickbox.css" media="screen" />
  </head>
  <body>
<div align="center">


<?php
   db_query("RENAME TABLE classes TO  sch_classes ");
   
   db_query("RENAME TABLE config TO  sch_config ");
   db_query("RENAME TABLE disciplines TO  sch_disciplines ");
   db_query("RENAME TABLE information TO  sch_information ");
   db_query("RENAME TABLE lessons TO  sch_lessons ");
   db_query("RENAME TABLE quarters TO  sch_quarters ");
   db_query("RENAME TABLE schedule TO  sch_schedule ");
   db_query("RENAME TABLE school_years TO  sch_school_years ");
   db_query("RENAME TABLE students TO  sch_students ");
   db_query("RENAME TABLE students_in_class TO  sch_students_in_class ");
   db_query("RENAME TABLE students_on_lesson TO  sch_students_on_lesson ");
   db_query("RENAME TABLE subjects TO  sch_subjects ");
   db_query("RENAME TABLE teachers TO  sch_teachers ");
   db_query("RENAME TABLE users TO  sch_users ");

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
 

 db_query("update sch_config set active='1' where key_config = 'SMS_ZAPROS' ");
 db_query("update sch_config set active='1' where key_config = 'SMS_PREFIKS_OZENKI' ");
 db_query("update sch_config set active='1' where key_config = 'SMS_PREFIKS_DZ' ");
 db_query("update sch_config set active='1' where key_config = 'DAYS' ");
 db_query("update sch_config set active='1' where key_config = 'LANG' ");
db_query("update sch_config set active='1' where key_config = 'INTERFACE' ");
db_query("update sch_config set active='1' where key_config = 'NAME_SCHOOL' ");
db_query("update sch_config set active='1' where key_config = 'NUM_SCHOOL' ");
db_query("update sch_config set active='1' where key_config = 'TEST_DAYS' ");


db_query("update sch_config set value_config='1.6 betta' where key_config = 'VERSIY' ");
 
 
 

?>
Обновление базы данных до версии 1.6 beta успешно завершено.
</div>
  </body>
</html>