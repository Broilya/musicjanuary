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
include_once ('../include/teachers.php');
include_once ('../include/curriculums.php');

if (isset($_REQUEST['mode'])) {
  $mode = $_REQUEST['mode'];
} else {
	$mode = 'add';
}

if (isset($_REQUEST['action'])) {
  if ($_REQUEST['action'] == 'add') {
  	$error = '';

  	$fields['class'] = $_REQUEST['class'];
  	
    $fields['school_year'] = intval($_REQUEST['school_year']);
    $fields['teacher_id'] = $_REQUEST['teacher_id'];

    $class_id = db_get_cell("SELECT class_id FROM `".TABLE_CLASSES."` WHERE class='$fields[class]'  AND school_year=$fields[school_year]");

    if ($class_id != 0) {
    	$error = 'class_exist';
    }

    if ($error == '') {
      db_array2insert(TABLE_CLASSES, $fields);
      header('Location: add_class.php?mode=success_add');
      exit();
    }
  }
}
  if ($mode == 'success_add') {
  	echo "<center>{$lang['new_class']}<br /><br />";
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;"  onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" /></center>';
  	exit();
  }
  $teachers = get_teachers_list();
  include('../header_dialog.php');
?>
  <body>

<?php
if (@$error == 'class_exist') {
  echo "<div align='center'><font color='red'>{$lang['class_add_error']}</font></div>";
}
?>

<script type="text/javascript">
function checkForm() {
  var validForm = true;

  if (document.getElementById('teacher_id_id').value == 0) {
  	validForm = false;
  	alert('<?php echo $lang['select_class_teacher'];?>');
  }

  return validForm;
}
</script>

<form action="add_class.php" method="post">
<input type="hidden" name="action" value="add" />
<table align="center" id="edit_in">
  <tr>
    <td><?php echo $lang['class_number'];?></td>
    <td>:</td>
    <td>

<input type="text" name="class"></input>

  </tr>



  <tr>
    <td><?php echo $lang['select_class_ruk'];?><font color="red">*</font></td>
    <td>:</td>
    <td>
<select name="teacher_id" id="teacher_id_id">
  <option value="0">&nbsp;</option>
<?php
  foreach ($teachers as $teacher) {
    echo '<option value="'.$teacher['teacher_id'].'">'.$teacher['last_name'].' '.$teacher['first_name'].' '.$teacher['middle_name'].'</option>';
  }
?>
</select>
    </td>
  </tr>

  <tr>
    <td><?php echo $lang['year'];?></td>
    <td>:</td>
    <td>
   <?php $school_years = get_school_years();?>
<select name="school_year" >
<option value=''><?php echo $lang['select'];?></option>
<?php foreach ($school_years as $years) {?>

<option value="<?php echo  $years['school_year_id'];?>"><?php echo $years['name_year'];?></option>

<?php } ?>
</select></td>
  </tr>
</table>
<br />
<center>
<input type="button" value="<?php echo $lang['add'];?>" onClick="javascript: if (checkForm()) this.form.submit();" 
/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;<?php echo $lang['close'];?>&nbsp;&nbsp;" onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();}" />
</center>
</form>
<?php

?>
</body>
</html>