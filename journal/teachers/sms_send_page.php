<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                      |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


//define('TEACHER_ZONE', true);

include_once ('../init.php');


if (isset($_REQUEST['action']) && $_REQUEST['action']='sendgrade') {

  $headers = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";

   $teacher = db_get_first_row("SELECT class_id FROM `".TABLE_CLASSES."` WHERE teacher_id='".$_SESSION['teacher_id']."'");
   $teacher_class = $teacher['class_id'];
   
	$res = db_query($sql = "SELECT student_id FROM `".TABLE_STUDENTS_ON_LESSON."`"
	     ." INNER JOIN `".TABLE_LESSONS."` ON lessons.lesson_id=students_on_lesson.lesson_id"
	     ." WHERE lessons.lesson_date >= '".implode('-', array_reverse(explode('.', $_REQUEST['date1'])))."' AND lessons.lesson_date <= '".implode('-', array_reverse(explode('.', $_REQUEST['date2'])))."'"
	     ." GROUP BY student_id");
	while ($student_id = mysql_fetch_assoc($res)) {
	  $student_id = array_pop($student_id);

	  $student = db_get_first_row("SELECT a.*, b.class_id FROM `".TABLE_USERS_STUDENTS."` AS a"
	     ." LEFT JOIN `".TABLE_STUDENTS_IN_CLASS."` AS b ON b.student_id = a.student_id"
	     ." WHERE a.student_id='".$student_id."' AND b.class_id = '".$teacher_class."';");
	  $text = "Ученик $student[last_name] $student[first_name] $student[middle_name] за ".$_REQUEST['date1']."-".$_REQUEST['date2']." получил следующие оценки:\n";
	  $res2 = db_query("SELECT grade, discipline"
             ." FROM `".TABLE_STUDENTS_ON_LESSON."`"
             ." INNER JOIN `".TABLE_LESSONS."` ON lessons.lesson_id = students_on_lesson.lesson_id"
             ." INNER JOIN `".TABLE_SUBJECTS."` ON lessons.subject_id = subjects.subject_id"
             ." INNER JOIN `".TABLE_SPR_DISCIPLINES."` ON disciplines.discipline_id = subjects.discipline_id"
             ." WHERE lessons.lesson_date >= '".implode('-', array_reverse(explode('.', $_REQUEST['date1'])))."' AND lessons.lesson_date <= '".implode('-', array_reverse(explode('.', $_REQUEST['date2'])))."' AND student_id=$student_id;");
  while($grade = mysql_fetch_assoc($res2)) {
    $text .="$grade[discipline]: $grade[grade]\n";
  }
  if ($student['email'] != '') {
  	mail($student['email'], "Оценки ученика $student[last_name] $student[first_name] $student[middle_name] за ".$_REQUEST['date1']."-".$_REQUEST['date2'], $text, $headers);
  }
	}

}


//include 'header.php';
$nums_grade = db_get_cell("SELECT COUNT(grade) FROM `".TABLE_STUDENTS_ON_LESSON."`"
                 ." INNER JOIN `".TABLE_LESSONS."` ON lessons.lesson_id=students_on_lesson.lesson_id"
                 ." WHERE lessons.lesson_date='".date('Y-m-d')."';");
?>

<table id="edit">
  <tbody>
  <tr class="TableHead">
    <th colsapan="2"><?php echo $lang['menu_1'];?></th>
  </tr>
  <!--tr>
    <td>За <?php echo date('d.m.Y'); ?> выставленно <?php echo $nums_grade ?> оценок.</td>
  </tr-->
  <tr>
	 <td>
	 <form action="services.php" method="post">
	 <input type="hidden" name="action" value="sendgrade" />
    <?php echo $lang['sms_send_from'];?> 
         <br><input type="text" id="date_send_id" name="date1" value="<?php echo date('d.m.Y', mktime(0,0,0, date('m'), date('d')-7, date('Y'))); ?>" />     
    <?php echo $lang['sms_send_to'];?><input type="text" name="date2" value="<?php echo date('d.m.Y'); ?>" /><br>
    <input type="submit"  class="button" value=" <?php echo $lang['sms_send_commit'];?> " />
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

<?php
//include 'footer.php';
?>