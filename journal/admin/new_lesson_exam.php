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
include_once ('../include/classes.php');

$schedule_id = @intval($_REQUEST['schedule_id']);
$subject_id  = @intval($_REQUEST['subject_id']);
$lesson_id   = @intval($_REQUEST['lesson_id']);

$mode         = @$_REQUEST['mode'];



if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];

  if ($action == 'add') {
  	$lesson_date = implode('-', array_reverse(explode('.', $_REQUEST['lesson_date'])));

    
    $fields = array();
    $fields['lesson_date']  = $lesson_date;
    $fields['subject_id']   = $subject_id;
    $fields['schedule_id']  = $schedule_id;
    $fields['lesson_order'] = 10000;
    $fields['active']       = time() + 60*60*45;
    $lesson_id = db_array2insert(TABLE_LESSONS, $fields);

//  	db_query("INSERT INTO `".TABLE_LESSONS."` (`lesson_id`, `lesson_date`, `subject_id`, `lesson_order`, `active `) VALUES"
//  	        ." (NULL, '$lesson_date', $subject_id, '', '', 10000, ".(time() + 60*60*45).");");
    //echo "INSERT INTO `".TABLE_LESSONS."` VALUES (NULL, '$lesson_date', $subject_id, '', '', 10000, ".(time() + 60*60*45);
    
  	header('Location: new_lesson_exam.php?mode=success_add');
  }
}
  include('../header_dialog.php');
?>
  <body>
<?php
  if ($mode == '') {
  	$mode = 'add';
  }

  if ($mode == 'success_add') { 
  	echo $lang['exam_add_text'].'.<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" />';
  } elseif ($mode == 'add') {
    outStudentForm();
  }

function outStudentForm()
{
	global $subject_id, $lang;
	echo '
<form action="new_lesson_exam.php" method="post">';
  echo '<input type="hidden" name="action" value="add" />';
echo '<input type="hidden" name="subject_id" value="'.$subject_id.'" />
<table>

  <tr>
    <td>'.$lang['exam_date'].'</td>
    <td>
<script type="text/javascript">
	$(function() {
		$("#lesson_date_id").datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
	</script>
  <input type="text" name="lesson_date" id="lesson_date_id" value="" size="26" /></td>
  </tr>
  
</table>
 ';
  echo '<input type="submit" value="'.$lang['add'].'" />';
  echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();}" />
</center>
</form>';
}

?>
  </body>
</html>