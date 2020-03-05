<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


  define('ADMIN_ZONE', true);

include_once ('../include/report.php');

?>
<div align="center">
<span class="head_top"><?php echo $lang['last_adding']?> </span>
<br /><br />
<br />
<span class="head_top"><?php echo $lang['lessons_report']?></span>
<table id="rounded-corner" width="70%">
  <thead>
  <tr>
    <th class="rounded-left"><?php echo $lang['inform_data'];?></th>
    <th><?php echo $lang['inform_tema'];?></th>
	<th><?php echo $lang['disclipline'];?></th>
	<th><?php echo $lang['class'];?></th>
    <th><?php echo $lang['teacher'];?></th>
    <th class="rounded-right">&nbsp;</th>
  </tr>
   </tr>
 </head>
<tbody>
<?php
  $report_lessons_list = get_report_lessons_list();
  foreach($report_lessons_list as $report_lessons) {
  echo "<tr><td>$report_lessons[lesson_date]</td>
  <td>$report_lessons[topic]</td>
  <td>$report_lessons[discipline]</td>
  <td>$report_lessons[class] $report_lessons[letter]</td>
  <td>$report_lessons[last_name] $report_lessons[first_name] $report_lessons[middle_name]</td>
  <td>&nbsp;</td>";
  }
?>
</tbody>
<tfoot>
<tfoot>
    	<tr>
       	  <td class="rounded-foot-left" colspan="4" >&nbsp;</td>
    	    <td class="rounded-foot-right"colspan="2">&nbsp;</td>
        </tr>
    </tfoot>
</table>
<br />
<span class="head_top"><?php echo $lang['teachers'];?></span>
<table id="rounded-corner" width="70%">
  <thead>
  <tr>
    <th class="rounded-left"><?php echo $lang['fio'];?></th>
    <th class="rounded-right">&nbsp;</th>
  </tr>
 </head>
<tbody>
<?php
  $report_teachers_list = get_report_teachers_list();
  foreach($report_teachers_list as $report_teachers) {
  echo "<tr><td>$report_teachers[last_name] $report_teachers[first_name] $report_teachers[middle_name]</td>";
  echo "<td>&nbsp;</td>";
  }
?>
</tbody>
<tfoot>
    	<tr>
       	  <td class="rounded-foot-left">&nbsp;</td>
    	    <td class="rounded-foot-right">&nbsp;</td>
        </tr>
    </tfoot>
</table>
<br />
<span class="head_top"><?php echo $lang['students'];?></span>
<table id="rounded-corner" width="70%">
  <thead>
  <tr>
    <th class="rounded-left"><?php echo $lang['fio'];?></th>
    <th class="rounded-right">&nbsp;</th>
  </tr>
 </head>
<tbody>
<?php
  $report_students_list = get_report_students_list();
  foreach($report_students_list as $report_students) {
  echo "<tr><td>$report_students[last_name] $report_students[first_name] $report_students[middle_name]</td>";
  echo "<td>&nbsp;</td>";

  }
?>
</tbody>
<tfoot>
<tfoot>
    	<tr>
       	  <td class="rounded-foot-left">&nbsp;</td>
    	    <td class="rounded-foot-right">&nbsp;</td>
        </tr>
    </tfoot>
</table>
</div>