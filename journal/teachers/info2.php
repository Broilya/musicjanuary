<?php error_reporting(E_ALL);
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                     |
+-----------------------------------------------------------------------------+
\*****************************************************************************/



define('TEACHER_ZONE', true);

include_once ('../init.php');

$information_id   = @intval($_REQUEST['information_id']);
$mode       = @$_REQUEST['mode'];

if ($information_id == 0 && $mode == '') {
	$mode = 'add';
} elseif ($information_id != 0 && $mode == '') {
	$mode = 'update';
}



if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];

  if ($action == 'add') {
   
	$fields = array();
    $fields['information_date'] = implode('-', array_reverse(explode('.', $_POST['information_date'])));
    
    $fields['information_title'] = substr($_POST['information_title'], 0, 100);
    $fields['information_text'] = substr($_POST['information_text'], 0, 500);
    $fields['information_section'] = "personal";
    $fields['information_classes'] = $_POST['information_classes'];
   
    db_array2insert(TABLE_INFORMATION, $fields);
    
    header('Location: info2.php?mode=success_add');
    
    exit();
    
  } elseif ($action == 'update') {
    $fields = array();
    $fields['information_date'] = implode('-', array_reverse(explode('.', $_POST['information_date'])));
    $fields['information_title'] = substr($_POST['information_title'], 0, 100);
    $fields['information_text'] = substr($_POST['information_text'], 0, 500);
    $fields['information_section'] = substr($_POST['information_section'], 0, 20);
    $fields['information_classes'] = $_POST['information_classes'];
     
    db_array2update(TABLE_INFORMATION, $fields,"information_id='".$information_id."'");
    header('Location: info2.php?mode=success_update');
    exit();
  }
}
  include('../header_dialog.php');
?>

  <body>
  <script type="text/javascript" src="../js/wz_tooltip.js"></script> 
    <script type="text/javascript" src="../js/ajaxform.js"></script>
<?php

  if ($mode == 'success_update') {
  	echo '<center>'.$lang['info_update_good_qq'].'.<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="self.parent.tb_remove();self.parent.location.reload();" />';
  } elseif ($mode == 'success_add') {
  	echo '<center>'.$lang['info_added'].'.<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="self.parent.tb_remove();self.parent.location.reload();" /></center>';
  } elseif ($mode == 'update') {
    $information = db_get_first_row("SELECT * FROM `".TABLE_INFORMATION."` WHERE information_id='".$information_id."'");
    outUserForm($information);
  } elseif ($mode == 'add') {
    outUserForm();
  }

function outUserForm($information = null)
{
	global $information_id, $lang;
	echo '<script type="text/javascript">
	$(function() {
		$("#information_date").datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
	</script>
<form action="info2.php" method="post">';
if (is_null($information)) {
  echo '<input type="hidden" name="action" value="add" />';
} else {
	echo '<input type="hidden" name="action" value="update" />';
}

echo '<input type="hidden" name="information_id" value="'.$information_id.'" />

<table>
  <tr>
    <td>'.$lang['inform_data'].'</td>
    <td><input type="text" name="information_date" id="information_date" value="'.(isset($information)?implode('.', array_reverse(explode('-', $information['information_date']))):'').'" size="26" />
	</td>
  </tr>
  <tr>
    <td>'.$lang['inform_to'].'</td>
    <td><select size="1" name="information_section">'; 
    
   
    if ($information['information_section'] == 'student')
    {
      echo '<option value="student" selected>'.$lang['inform_teacher'].'</option>';
    }
    else
    {
   	  echo '<option value="student">'.$lang['inform_student'].'</option>';
    }
	 echo '</select></td>
	 
  </tr>
  <tr>
    <td>Класс</td>'?>
    <td><select size="1" name="information_classes" onchange="ewd_getcontent('ajaxform-stud.php?classid='+this.value, 'disciplinesdiv');"> 
 <?php  echo ' <option value="">'.$lang['select'].'</option>';
   $db_classes = mysql_query("SELECT class_id, class, letter FROM `".TABLE_CLASSES."` WHERE school_year ='".date('Y-m-d')."'");
   while ($classes = mysql_fetch_array($db_classes)) {
    
    if($information['information_classes'] == $classes['class_id']) {
      $selclass="selected";  
    } else {$selclass="";}
    
    echo "<option $selclass value=\"".$classes['class_id']."\">".$classes['class']." ".$classes['letter']."</option>";
   }
  echo '</select></td>
 
  </tr>
  <tr>
  <td><td>
  <div id="disciplinesdiv">

  </div>
  <br>
  <tr>
  
  
  
  
  
    <td>'.$lang['inform_tema'].'</td>
    <td><input type="text" name="information_title" value="'.(isset($information)?$information['information_title']:'').'" size="26" /></td>
  </tr>
  <tr>
    <td>'.$lang['inform_messs'].'</td>
    <td><textarea name="information_text" class="required" rows="10" cols="35">'.(isset($information)?$information['information_text']:'').'</textarea></td>
  </tr>
</table>
<center>';
if (is_null($information)) {
  echo '<input type="submit" value="'.$lang['add'].'" />';
} else {
	echo '<input type="submit" value="'.$lang['refresh'].'" />';
}
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="self.parent.tb_remove();self.parent.location.reload();" />
</center>
</form>';
}

?>
  </body>
</html>