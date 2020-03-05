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
include_once ('../include/users.php');

if (isset($_REQUEST['mode'])) {
  $mode = $_REQUEST['mode'];
} else {
	$mode = 'add';
}

  $class_id = $_REQUEST['class_id'];
  $teacher_id = $_REQUEST['teacher'];

if (isset($_REQUEST['action'])) {
  if ($_REQUEST['action'] == 'upd') {
    $error = '';

    $fields['teacher_id'] = $_REQUEST['teacher_id'];

    $class_id = db_get_cell("SELECT class_id FROM `".TABLE_CLASSES."`"
              ." WHERE class_id='".$_REQUEST['class_id']."' LIMIT 0,1;");

    if (empty($class_id)) {
      $error = 'class_not';
    }

    if ($error == '') {
      db_query("UPDATE `".TABLE_CLASSES."` SET teacher_id=0"
              ." WHERE teacher_id='".$_REQUEST['teacher_id']."';");

      db_array2update(TABLE_CLASSES, $fields, "class_id='".$class_id."'");

      if (empty($fields['teacher_id'])) {
        header('Location: classruk.php?mode=success_upd0');
      } else {
        header('Location: classruk.php?mode=success_upd');
      }
      exit();
    }
  }
}
  if ($mode == 'success_upd') {
  	echo "<center>{$lang['upd_class_ruk']}<br /><br />";
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" 
  	       onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" /></center>';
  	exit();
  } 
  elseif ($mode == 'success_upd0') {
  	echo "<center>{$lang['upd_class_ruk_of']}<br /><br />";
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" 
  	       onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" /></center>';
  	exit();
  }


  $teachers = get_teachers_list();
  include('../header_dialog.php');
?>
  <body>

<?php
if (@$error == 'class_not') {
  echo "<div align='center'><font color='red'>{$lang['class_ruk_error']}</font></div>";
}

    $class = db_get_cell("SELECT class FROM `".TABLE_CLASSES."`"
              ." WHERE class_id='".$_REQUEST['class_id']."' LIMIT 0,1;");

?>


<script type="text/javascript">
function checkForm() {
  var validForm = true;
  return validForm;

  if (document.getElementById('teacher_id_id').value == 0) {
  	validForm = false;
  	alert('<?php echo $lang['select_class_teacher'];?>');
  }

  return validForm;
}
</script>

<form action="classruk.php" method="post">
<input type="hidden" name="action" value="upd" />
<input type="hidden" name="class_id" value="<?php echo $class_id;?>" />
 
<table align="center" id="edit_in">
  <tr>
    <td colspan="3"><?php echo $lang['class'];?>: <?php echo $class;?></td>
  </tr>

  <tr>
    <td><?php echo $lang['select_class_ruk'];?><font color="red">*</font> : </td>
    <td>
<select name="teacher_id">
  <option value=''><?php echo $lang['select'];?></option>
<?php
  foreach ($teachers as $teacher) {
    $selected = ($teacher['teacher_id'] == $teacher_id) ? 'selected="selected"': '';
    echo '<option '.$selected.'value="'.$teacher['teacher_id'].'">'.$teacher['last_name'].' '.$teacher['first_name'].' '.$teacher['middle_name'].'</option>';
  }
?>
</select>
    </td>
  </tr>

</table>
<br />
<center>
<input type="button" value="<?php echo $lang['refresh'];?>"
 onClick="this.form.submit();" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;<?php echo $lang['close'];?>&nbsp;&nbsp;"
  onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();}" />
</center>
</form>
<?php

?>
</body>
</html>