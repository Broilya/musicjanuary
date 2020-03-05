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

  
  db_query("ALTER TABLE `sch_groups` ADD COLUMN `group` varchar(32) character set utf8 default NULL AFTER `group_id` ");
  db_query("ALTER TABLE `sch_groups` ADD COLUMN `short` varchar(8) character set utf8 default NULL AFTER `group_id` ");
  db_query("ALTER TABLE `sch_groups` ADD COLUMN `active` tinyint(2)  unsigned NOT NULL AFTER `group_id` ");
 
  db_query("ALTER TABLE `lessons` ADD COLUMN `schedule_id` int(10)  unsigned NOT NULL AFTER `lesson_id` ");
  db_query("ALTER TABLE `lessons` ADD COLUMN `file` varchar(64) NOT NULL default '0' AFTER `lesson_id` ");
  db_query("ALTER TABLE `lessons` ADD COLUMN `date_dz` datetime AFTER `lesson_id` ");
  db_query("ALTER TABLE `lessons` ADD COLUMN `date_sched` datetime AFTER `lesson_id` ");

  db_query("ALTER TABLE `schedule` ADD COLUMN `teacher_id` int(10) unsigned NOT NULL AFTER `id_schedule` ");
  db_query("ALTER TABLE `schedule` ADD COLUMN `group_id` smallint(4)  unsigned NOT NULL AFTER `id_schedule` ");
  db_query("ALTER TABLE `schedule` ADD COLUMN `started` date AFTER `id_schedule` ");
  db_query("ALTER TABLE `schedule` ADD COLUMN `finished` date AFTER `id_schedule` ");
  
  
  

 
 
 

?>
Обновление базы данных до версии 1.3 betta успешно завершено.
</div>
  </body>
</html>