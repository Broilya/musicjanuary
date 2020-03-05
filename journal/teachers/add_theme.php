<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                      |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('TEACHER_ZONE', true);

include_once ('../init.php');
include_once ('../include/teachers.php');
include_once ('../include/curriculums.php');

if (isset($_REQUEST['mode'])) {
  $mode = $_REQUEST['mode'];
} else {
	$mode = 'upload';
}

if (isset($_REQUEST['action'])) {
  if ($_REQUEST['action'] == 'upload') {
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
      header('Location: add_teacher.php?mode=success_add');
      exit();
    }
  }
}
  if ($mode == 'success_add') {
  	echo "<center>".$lang['teacher_up_good']."<br /><br />";
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;"  onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" /></center>';
  	exit();
  }
  elseif ($mode == 'not_add') {
  	echo "<center>".stripslashes ( $_REQUEST['error'])."<br /><br />";
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

  if (document.getElementById('filename').value == 0) {
  	validForm = false;
  	alert('<?php echo $lang['select_filename'];?>');
  }

  return validForm;
}
</script>

<form action="theme_upload.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="action" value="upload" />
<table align="center" id="edit_in">

  <tr>
    <td align="right"><?php echo $lang['year'];?><font color="red">*</font></td>
    <td>:</td>
    <td><?php $school_years = get_school_years();?>
<select name="school_year" >
<option value=''><?php echo $lang['select'];?></option>
<?php foreach ($school_years as $years) {?>

<option value="<?php echo  $years['school_year_id'];?>"<?php echo  ((empty($years['current'])) ? "" : " selected=selected");?>><?php echo $years['name_year'];?></option>

<?php } ?>
</select></td>
  </tr>
  <tr>
    <td><?php echo $lang['select_filename'];?><font color="red">*</font></td>
    <td>:</td>
    <td>
      <input type="file" name="filename" id="filename"><br> 
    </td>
  </tr>

</table>
<br />
<center>
<input type="button" value="<?php echo $lang['upload'];?>" onClick="javascript: if (checkForm()) this.form.submit();" 
/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;<?php echo $lang['close'];?>&nbsp;&nbsp;" onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();}" />
</center>
</form>
<?php

?>
</body>
</html>
