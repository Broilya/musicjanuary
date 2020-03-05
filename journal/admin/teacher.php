<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                     |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('ADMIN_ZONE', true);

include_once ('../init.php');
include_once ('../include/classes.php');
include_once ('../include/images.php');

$teacher_id    = @intval($_REQUEST['teacher_id']);
$mode        = @$_REQUEST['mode'];

if ($teacher_id == 0 && $mode == '') {
	$mode = 'add';
} elseif ($teacher_id != 0 && $mode == '') {
	$mode = 'update';
}



if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];

  if ($action == 'del_photo') {
	
	@unlink("../teacher_photo/".SUBDOMEN."/".$_REQUEST['photo']);
   	@unlink("../teacher_photo/".SUBDOMEN."/sm/".$_REQUEST['photo']);  	  
    $query = mysql_query("UPDATE `".TABLE_USERS_TEACHERS."` SET photo='' WHERE  teacher_id='".$_REQUEST['teacher_id']."'"); 	
	
   }

  if ($action == 'add') {
   
    /// Загрузка фото учинека
    $teacher_photo = UploadedPhotoFile("../teacher_photo/".SUBDOMEN."/");
  
	//запись имени фото в бд
    $fields[] = "photo='".$teacher_photo."'";
		    
    $fields[] = "last_name='". mysql_escape_string(substr($_POST['last_name'], 0, 25))."'";
    $fields[] = "first_name='".mysql_escape_string(substr($_POST['first_name'], 0, 25))."'";
    $fields[] = "middle_name='".mysql_escape_string(substr($_POST['middle_name'], 0, 25))."'";

    $fields[] = "login='".mysql_escape_string(substr($_POST['login'], 0, 25))."'";
    $fields[] = "passwd='".md5($_POST['passwd'])."'";

    db_query($sql = "INSERT `".TABLE_USERS_TEACHERS."` SET ".implode(', ', $fields));
    header('Location: teacher.php?mode=success_add');
    exit();

  } elseif ($action == 'update') {
    
    /// Загрузка фото учинека
    $teacher_photo = UploadedPhotoFile("../teacher_photo/".SUBDOMEN."/");
    
	$fields = array();
	//запись имени фото в бд
    $fields[] = "photo='".$teacher_photo."'";
    
    $fields[] = "last_name='". mysql_escape_string(substr($_POST['last_name'], 0, 25))."'";
    $fields[] = "first_name='".mysql_escape_string(substr($_POST['first_name'], 0, 25))."'";
    $fields[] = "middle_name='".mysql_escape_string(substr($_POST['middle_name'], 0, 25))."'";

    $fields[] = "login='".mysql_escape_string(substr($_POST['login'], 0, 25))."'";

    if (isset($_POST['passwd'])) {
      $fields[] = "passwd='".md5($_POST['passwd'])."'";
    }

    db_query($sql = "UPDATE `".TABLE_USERS_TEACHERS."` SET ".implode(', ', $fields)." WHERE teacher_id='".$teacher_id."'");
    header('Location: teacher.php?mode=success_update');
    exit();

  }
}
  include('../header_dialog.php');
?>
  <script type="text/javascript">
  function checkValidForm() {
    var validForm = true;

    if (document.getElementById('last_name_id').value == '') {
    	validForm = false;
    	alert('<?php echo $lang['input_teacher_f'];?>');
    }

    if (document.getElementById('first_name_id').value == '') {
    	validForm = false;
    	alert('<?php echo $lang['input_teacher_name'];?>');
    }

    if (document.getElementById('middle_name_id').value == '') {
    	validForm = false;
    	alert('<?php echo $lang['input_teacher_o'];?>');
    }

    if (document.getElementById('login_id').value == '') {
    	validForm = false;
    	alert('<?php echo $lang['input_teacher_login'];?>');
    }


    return validForm;
  }
  </script>
  <body style="margin-left: 0px;	margin-right: 0px;">
<?php

  if ($mode == 'success_update') {
  	echo '<center>'.$lang['teacher_update_add_good'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" /></center>';
  } elseif ($mode == 'success_add') {
  	echo '<center>'.$lang['new_teacher_added'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" />
  	&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;'.$lang['continue'].'&nbsp;&nbsp;" onclick="document.location=\'teacher.php\'" /></center>';
  } elseif ($mode == 'update') {
    $teacher  = db_get_first_row("SELECT * FROM `".TABLE_USERS_TEACHERS."` WHERE teacher_id='".$teacher_id."'");
    outTeacherForm($teacher);
  } elseif ($mode == 'add') {
    outTeacherForm();
  }

function outTeacherForm($teacher = null)
{
global $lang;
	global $teacher_id;
	echo '
<form action="teacher.php" method="post" enctype="multipart/form-data">';
if (isset($teacher)) {
  echo '<input type="hidden" name="action" value="update" />';
  echo '<input type="hidden" name="teacher_id" value="'.$teacher_id.'" />';
} else {
  echo '<input type="hidden" name="action" value="add" />';
}
echo '
<table id="edit_in" align="center">
<tbody>
  <tr>
    <td>'.$lang['familiy'].'<font color="red">*</font></td>
    <td><input type="text" name="last_name" id="last_name_id" value="'.(isset($teacher)?$teacher['last_name']:'').'" /></td>
  </tr>
  <tr>
    <td>'.$lang['name'].'<font color="red">*</font></td>
    <td><input type="text" name="first_name" id="first_name_id" value="'.(isset($teacher)?$teacher['first_name']:'').'" /></td>
  </tr>
  <tr>
    <td>'.$lang['otchesctvo'].'<font color="red">*</font></td>
    <td><input type="text" name="middle_name" id="middle_name_id" value="'.(isset($teacher)?$teacher['middle_name']:'').'" /></td>
  </tr>
  <tr>
    <td>'.$lang['foto'].'</td>';
    
    // Фото
    
    if ($teacher['photo']=='')
    {
       echo '<td><input type="file" size="15" name="uploadfile" /></td>';
    }
	// Форма загрузки фото
    else
    { echo '<td><img src="../teacher_photo/'.SUBDOMEN.'/sm/'.$teacher['photo'].'" border="0"><br>
	   <a href="teacher.php?action=del_photo&teacher_id='.$teacher_id.'&photo='.$teacher['photo'].'">Удалить фото</a></td>';	
     
    }
    
 
 echo'</tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>'.$lang['login'].'<font color="red">*</font></td>
    <td><input type="text" name="login" id="login_id" value="'.(isset($teacher)?$teacher['login']:'').'" /></td>
  </tr>
  <tr>
    <td>'.$lang['pass'].'</td>
    <td><input type="password" name="passwd" value="" /></td>
  </tr>
  <tr>
    <td>'.$lang['pass'].'</td>
    <td><input type="password" name="passwd2" value="" /></td>
  </tr>

  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>

  <tr>
    <td colspan="2" align="center">';
if (isset($teacher)) {
	echo '<input type="button" class="button" value="'.$lang['save'].'" onClick="javascript: if (checkValidForm()) this.form.submit();">';
} else {
  echo '<input type="button" class="button" value="'.$lang['add'].'" onClick="javascript: if (checkValidForm()) this.form.submit();">';
}
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" class="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();}" /></td>
</tr></tbody></table></form>';
}

?>
  </body>
</html>