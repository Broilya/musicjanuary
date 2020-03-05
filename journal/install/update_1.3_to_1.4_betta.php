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

db_query("ALTER TABLE `config` ADD COLUMN `active` tinyint(2)  unsigned NOT NULL AFTER `value_config` ");
  db_query("update config set active=1 where key_config = 'SMS_ZAPROS' ");
  db_query("update config set active=1 where key_config = 'SMS_PREFIKS_DZ' ");
  db_query("update config set active=1 where key_config = 'DAYS' ");
  db_query("update config set active=1 where key_config = 'LANG' ");
  db_query("update config set active=1 where key_config = 'INTERFACE' ");
  
  db_query("INSERT INTO `config` (`id_config`, `desc_config`, `key_config`, `value_config` , `active`) VALUES
(7, 'Название школы', 'NAME_SCHOOL', 'Demo_versia' , '1'),
(8, 'Номер школы', 'NUM_SCHOOL', '1' , '1'),
(9, 'Количество дней тестового периода', 'TEST_DAYS', '30' , '1'),
(10, 'Версия', 'VERSIY', '1.4 betta', '1')

");


  
  

 
 
 

?>
Обновление базы данных до версии 1.4 betta успешно завершено.
</div>
  </body>
</html>