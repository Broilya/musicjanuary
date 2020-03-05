<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

define('ADMIN_ZONE', true);
include_once ('../init.php');
include 'header.php';

?>

<div align="center"> 
<br />
<div align="left" style="width: 300px;"> 
 <ul class="services_menu">
<!--
  <li><a href="sending-rating.php"><?php echo $lang['menu_1'];?></a></li>
  <li><a href="theme-lessons.php"><?php echo $lang['menu_2'];?></a></li>
  <li><a href="upload_form.php"><?php echo $lang['menu_3'];?></a></li>
  <li><a href="schedule-journal.php"><?php echo $lang['menu_4'];?></a></li>
  <li><a href="config-journal.php"><?php echo $lang['menu_5'];?></a></li>
  <li><a href="srv.php"><?php echo $lang['menu_6'];?></a></li>
  <li><a href="teacher_cng.php"><?php echo $lang['menu_7'];?></a></li>
  <li><a href="replace.php"><?php echo $lang['menu_8'];?></a></li>
  <li><a href="school_report.php"><?php echo $lang['menu_9'];?></a></li>
  <li><a href="balances.php"><?php echo $lang['menu_10'];?></a></li>

  <li><a href="students.php"><?php echo $lang['menu_11'];?></a></li>
  <li><a href="teachers.php"><?php echo $lang['menu_12'];?></a></li>
-->
		<li><a  class="dnl" href="config-journal.php"><?php echo $lang['header_config'];?></a></li>
                <li><a  class="dnl" href="from_1dnevnik.php"><?php echo $lang['header_1dnevnik'];?></a></li>
                <li><a  class="dnl" href="../phpexcel/grades_templ.xls">Скачать шаблон для ввода оценок</a></li>
                <li><a  class="dnl" href="../phpexcel/teachers_templ.xls">Скачать шаблон для заполнения учителей</a></li>
                <li><a  class="dnl" href="../phpexcel/schedule_templ.xls">Скачать шаблон для ввода расписания</a></li>
		<li><a  class="dnl" href="../phpexcel/students_templ.xls">Скачать шаблон для заполнения учеников</a></li>
		<li><a href="school_report.php"><?php echo $lang['header_reports'];?></a></li>
		<?php if (SUPERADMINID == $_SESSION['admin_id']) {?>
		<li><a  class="dnl" href="./.dumper.php"><?php echo $lang['sqldump_dumper'];?></a></li>
	        <?php }?>

 </ul>
<br/> 
</div> 
</div> 
<br/> 
<?php
include 'footer.php';
?>