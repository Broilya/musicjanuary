<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

$res = db_query("select class_id FROM `".TABLE_STUDENTS_IN_CLASS."` where student_id=".$_SESSION['student_id']);
$row_shed=mysql_fetch_assoc($res);


$class_id      = $row_shed['class_id'];

  include('../header_dialog2.php');
?>
  <body>
Личные сообщения, новости ......................................<br>
сайта
  </body>
</html>