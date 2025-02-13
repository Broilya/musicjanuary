<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                      |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('ADMIN_ZONE', true);

include_once ('../init.php');
include_once ('../include/classes.php');

$class_id   = @intval($_REQUEST['class_id']);
$student_id = @intval($_REQUEST['student_id']);
$mode       = @$_REQUEST['mode'];



if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];

  if ($action == 'add') {
    /* Информация о учинеке*/
    $fields[] = "last_name='". mysql_escape_string(substr($_POST['last_name'], 0, 25))."'";
    $fields[] = "first_name='".mysql_escape_string(substr($_POST['first_name'], 0, 25))."'";
    $fields[] = "middle_name='".mysql_escape_string(substr($_POST['middle_name'], 0, 25))."'";
    $fields[] = "birthday='".mysql_escape_string(implode('-', array_reverse(explode('.', $_POST['birthday']))))."'";
    $fields[] = "address='".mysql_escape_string(substr($_POST['address'], 0, 255))."'";
    $fields[] = "phone='".mysql_escape_string(substr($_POST['phone'], 0, 25))."'";

    /* Информация о родителях*/
    $fields[] = "mother_fio='".mysql_escape_string(substr($_POST['mother_fio'], 0, 50))."'";
    $fields[] = "mother_work_phone='".mysql_escape_string(substr($_POST['mother_work_phone'], 0, 25))."'";
    $fields[] = "mother_cell_phone='".mysql_escape_string(substr($_POST['mother_cell_phone'], 0, 25))."'";

    $fields[] = "father_fio='".mysql_escape_string(substr($_POST['father_fio'], 0, 50))."'";
    $fields[] = "father_work_phone='".mysql_escape_string(substr($_POST['father_work_phone'], 0, 25))."'";
    $fields[] = "father_cell_phone='".mysql_escape_string(substr($_POST['father_cell_phone'], 0, 25))."'";

    db_query("INSERT students SET ".implode(', ', $fields));
    $student_id = db_get_insert_id();
    db_query("INSERT students_in_class VALUES ($class_id, $student_id, 0)");
    header('Location: student.php?mode=success_add');
    exit();
  } elseif ($action == 'update') {
    $fields = array();

    /* Информация о учинеке*/
    $fields[] = "last_name='". mysql_escape_string(substr($_POST['last_name'], 0, 25))."'";
    $fields[] = "first_name='".mysql_escape_string(substr($_POST['first_name'], 0, 25))."'";
    $fields[] = "middle_name='".mysql_escape_string(substr($_POST['middle_name'], 0, 25))."'";
    $fields[] = "birthday='".mysql_escape_string(implode('-', array_reverse(explode('.', $_POST['birthday']))))."'";
    $fields[] = "address='".mysql_escape_string(substr($_POST['address'], 0, 255))."'";
    $fields[] = "phone='".mysql_escape_string(substr($_POST['phone'], 0, 25))."'";

    /* Информация о родителях*/
    $fields[] = "mother_fio='".mysql_escape_string(substr($_POST['mother_fio'], 0, 50))."'";
    $fields[] = "mother_work_phone='".mysql_escape_string(substr($_POST['mother_work_phone'], 0, 25))."'";
    $fields[] = "mother_cell_phone='".mysql_escape_string(substr($_POST['mother_cell_phone'], 0, 25))."'";

    $fields[] = "father_fio='".mysql_escape_string(substr($_POST['father_fio'], 0, 50))."'";
    $fields[] = "father_work_phone='".mysql_escape_string(substr($_POST['father_work_phone'], 0, 25))."'";
    $fields[] = "father_cell_phone='".mysql_escape_string(substr($_POST['father_cell_phone'], 0, 25))."'";

    db_query("UPDATE `".TABLE_USERS_STUDENTS."` SET ".implode(', ', $fields)." WHERE student_id='".$student_id."'");
    header('Location: student.php?mode=success_update');
    exit();
  }
}
  include('../header_dialog.php');
?>
  <body>
<?php
  if ($student_id == 0 && $mode == '') {
  	$mode = 'add';
  } elseif ($student_id != 0 && $mode == '') {
  	$mode = 'update';
  }

  if ($mode == 'success_update') {
  	echo '<center>'.$lang['user_update_login_good'].'.<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" /></center>';
  } elseif ($mode == 'success_add') {
  	echo $lang['new_studer_add'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" />';
  } elseif ($mode == 'update') {
    $student = db_get_first_row("SELECT * FROM `".TABLE_USERS_STUDENTS."` WHERE student_id='".$student_id."'");
    outStudentForm($student);
  } elseif ($mode == 'add') {
    outStudentForm();
  }

function outStudentForm($student = null)
{
	global $class_id, $student_id, $lang;
	echo '
<form action="student.php" method="post">';
if (is_null($student)) {
  echo '<input type="hidden" name="action" value="add" />';
} else {
	echo '<input type="hidden" name="action" value="update" />';
}
echo '<input type="hidden" name="class_id" value="'.$class_id.'" />
<input type="hidden" name="student_id" value="'.$student['student_id'].'" />

<table  width="100%">
  <tr>
    <td width="50%">'.$lang['student_data_v'].'</td>
    <td width="50%">'.$lang['student_roditel_v'].'</td>
  </tr>
  <tr>
  <td rowspan="4">
<table>
  <tr>
    <td>'.$lang['familiy'].'</td>
    <td><input type="text" name="last_name" value="'.(isset($student)?$student['last_name']:'').'" size="26" /></td>
  </tr>
  <tr>
    <td>'.$lang['name'].'</td>
    <td><input type="text" name="first_name" value="'.(isset($student)?$student['first_name']:'').'" size="26" /></td>
  </tr>
  <tr>
    <td>'.$lang['otchesctvo'].'</td>
    <td><input type="text" name="middle_name" value="'.(isset($student)?$student['middle_name']:'').'" size="26" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>'.$lang['date_of_birth'].'</td>
    <td>
<script type="text/javascript">
	$(function() {
		$("#birthday_id").datepicker({
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			yearRange: \'1990:2010\',
		});
	});
	</script>

    <input type="text" name="birthday" id="birthday_id" value="'.(isset($student)?implode('.', array_reverse(explode('-', $student['birthday']))):'').'" size="26" /></td>
  </tr>
  <tr>
    <td>'.$lang['telephone_user'].'</td>
    <td><input type="text" name="phone" value="'.(isset($student['phone'])?$student['phone']:'').'" size="26" /></td>
  </tr>
  <tr>
    <td>'.$lang['adress_student'].'</td>
    <td><textarea name="address" rows="4">'.(isset($student['address'])?$student['address']:'').'</textarea></td>
  </tr>
</table>
  </td>
  <td>'.$lang['student_mother'].'</td>
</tr>
<tr>
  <td>
<table>
  <tr>
  <td>'.$lang['student_mother_fio'].'</td>
  <td>&nbsp;</td>
  <td><input type="text" name="mother_fio" value="'.(isset($student['mother_fio'])?$student['mother_fio']:'').'" /></td>
  </tr>
  <tr>
    <td>'.$lang['student_mother_rub_fone'].'</td>
    <td>&nbsp;</td>
    <td><input type="text" name="mother_work_phone" value="'.(isset($student['mother_work_phone'])?$student['mother_work_phone']:'').'" /></td>
  </tr>
  <tr>
    <td>'.$lang['student_mother_sel_fone'].'</td>
    <td>&nbsp;</td>
    <td><input type="text" name="mother_cell_phone" value="'.(isset($student['mother_cell_phone'])?$student['mother_work_phone']:'').'" /></td>
  </tr>
</table>
  </td>
</tr>
<tr>
  <td>'.$lang['student_father'].'</td>
</tr>
<tr>
  <td>
<table>
  <tr>
    <td>'.$lang['father_fio'].'</td>
    <td>&nbsp;</td>
    <td><input type="text" name="father_fio" value="'.(isset($student['father_fio'])?$student['father_fio']:'').'" /></td>
  </tr>
  <tr>
    <td>'.$lang['father_rab_fone'].'</td>
    <td>&nbsp;</td>
    <td><input type="text" name="father_work_phone" value="'.(isset($student['father_work_phone'])?$student['mother_work_phone']:'').'" /></td>
  </tr>
  <tr>
    <td>'.$lang['student_mother_sel_fone'].'</td>
    <td>&nbsp;</td>
    <td><input type="text" name="father_cell_phone" value="'.(isset($student['father_cell_phone'])?$student['mother_work_phone']:'').'" /></td>
  </tr>
</table>
  </td>
</tr>
</table>
<center>';
if (is_null($student)) {
  echo '<input type="submit" value="'.$lang['add'].'" />';
} else {
	echo '<input type="submit" value="'.$lang['refresh'].'" />';
}
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();}" />
</center>
</form>';
}

?>
  </body>
</html>