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


  db_query("update config set value_config='1.5 betta' where key_config = 'VERSIY' ");
  
  



 
 
 

?>
Обновление базы данных до версии 1.5 betta успешно завершено.
</div>
  </body>
</html>