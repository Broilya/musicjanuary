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


if (isset($_REQUEST['action']) && $_REQUEST['action']='sendgrade') {

  $headers = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";

	$res = db_query($sql = "SELECT student_id FROM `".TABLE_STUDENTS_ON_LESSON."` INNER JOIN `".TABLE_LESSONS."` ON lessons.lesson_id=students_on_lesson.lesson_id WHERE lessons.lesson_date >= '".implode('-', array_reverse(explode('.', $_REQUEST['date1'])))."' AND lessons.lesson_date <= '".implode('-', array_reverse(explode('.', $_REQUEST['date2'])))."' GROUP BY student_id");
	while ($student_id = mysql_fetch_assoc($res)) {
		$student_id = array_pop($student_id);

		$student = db_get_first_row("SELECT * FROM `".TABLE_USERS_STUDENTS."` WHERE student_id=$student_id;");
		$text = "Ученик $student[last_name] $student[first_name] $student[middle_name] за ".$_REQUEST['date1']."-".$_REQUEST['date2']." получил следующие оценки:\n";
		$res2 = db_query("SELECT grade, discipline"
    ." FROM `".TABLE_STUDENTS_ON_LESSON."`"
    ." INNER JOIN `".TABLE_LESSONS."` ON lessons.lesson_id = students_on_lesson.lesson_id"
    ." INNER JOIN `".TABLE_SUBJECTS."` ON lessons.subject_id = subjects.subject_id"
    ." INNER JOIN `".TABLE_SPR_DISCIPLINES."` ON disciplines.discipline_id = subjects.discipline_id"
    ." WHERE lessons.lesson_date >= '".implode('-', array_reverse(explode('.', $_REQUEST['date1'])))."' AND lessons.lesson_date <= '".implode('-', array_reverse(explode('.', $_REQUEST['date2'])))."' AND student_id=$student_id;");$curr="";
    while($grade = mysql_fetch_assoc($res2)) {	if ($curr==$grade[discipline]) { $text .=",$grade[grade]\n";  } else {
    $text .="$grade[discipline]: $grade[grade]\n";	} $curr=$grade[discipline];
  }
  if ($student['email'] != '') {
  	mail($student['email'], $lang['sms_student_grade']." $student[last_name] $student[first_name] $student[middle_name] за ".$_REQUEST['date1']."-".$_REQUEST['date2'], $text, $headers);
  }
 }

}

include 'header.php';
$nums_grade = db_get_cell("SELECT COUNT(grade) FROM `".TABLE_STUDENTS_ON_LESSON."` INNER JOIN `".TABLE_LESSONS."` ON lessons.lesson_id=students_on_lesson.lesson_id WHERE lessons.lesson_date='".date('Y-m-d')."';");
?>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet" />
      <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    	<script type="text/javascript" src="../js/jquery.js"></script>
    	<script type="text/javascript" src="../js/jquery-ui.js"></script>
    	<script type="text/javascript" src="../js/ui.datepicker-ru.js"></script>
<div align="center"> 
<br />
<table id="edit">
  <tbody>
  <tr class="TableHead">
    <th colsapan="2"><?php echo $lang['sms_grades_send'];?></th>
  </tr>
  <!--tr>
    <td>За <?php echo date('d.m.Y'); ?> выставленно <?php echo $nums_grade ?> оценок.</td>
  </tr-->
  <tr>
	 <td>
	 <form action="sending-rating.php" method="post">
	 <input type="hidden" name="action" value="sendgrade" />
    <?php echo $lang['sms_send_from'];?>
		<input type="text" id="date_send_id" name="date1" value="<?php echo date('d.m.Y', mktime(0,0,0, date('m'), date('d')-7, date('Y'))); ?>" /> <?php echo $lang['sms_send_to']?> <input type="text" name="date2" value="<?php echo date('d.m.Y'); ?>" /><?php echo $lang['sms_parents']?>
    <input type="submit"  class="button" value=" Выслать " />
<script type="text/javascript">
	$(function() {
		$('#date_send_id').datepicker({
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true
		});
	});
	</script>
    </form>
    </td>
  <tr>
  </tbody>
</table>
</div> 
<br> 
<?php
include 'footer.php';
?>