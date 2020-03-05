<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                     |
+-----------------------------------------------------------------------------+
\*****************************************************************************/



define('DIRECTOR_ZONE', true);

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
    $fields['information_section'] = substr($_POST['information_section'], 0, 20);
    $fields['information_classes'] = $_POST['information_classes'];
   
    db_array2insert(TABLE_INFORMATION, $fields);
    
    header('Location: info.php?mode=success_add');
    
    exit();
    
  } elseif ($action == 'update') {
    $fields = array();
    $fields['information_date'] = implode('-', array_reverse(explode('.', $_POST['information_date'])));
    $fields['information_title'] = substr($_POST['information_title'], 0, 100);
    $fields['information_text'] = substr($_POST['information_text'], 0, 500);
    $fields['information_section'] = substr($_POST['information_section'], 0, 20);
    $fields['information_classes'] = $_POST['information_classes'];
     
    db_array2update(TABLE_INFORMATION, $fields,"information_id='".$information_id."'");
    header('Location: info.php?mode=success_update');
    exit();
  }
}
  include('../header_dialog.php');
?>
  <body>
  
<?php

  if ($mode == 'success_update') {
  	echo '<center>Информация успешно обновлена.<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;Закрыть&nbsp;&nbsp;" onclick="self.parent.tb_remove();self.parent.location.reload();" />';
  } elseif ($mode == 'success_add') {
  	echo '<center>Информация успешно добавлена.<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;Закрыть&nbsp;&nbsp;" onclick="self.parent.tb_remove();self.parent.location.reload();" /></center>';
  } elseif ($mode == 'update') {
    $information = db_get_first_row("SELECT * FROM `".TABLE_INFORMATION."` WHERE information_id='".$information_id."'");
    outUserForm($information);
  } elseif ($mode == 'add') {
    outUserForm();
  }

function outUserForm($information = null)
{
	global $information_id;
	echo '<script type="text/javascript">
	$(function() {
		$("#information_date").datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
	</script>
<form action="info.php" method="post">';
if (is_null($information)) {
  echo '<input type="hidden" name="action" value="add" />';
} else {
	echo '<input type="hidden" name="action" value="update" />';
}
echo '<input type="hidden" name="information_id" value="'.$information_id.'" />

<table>
  <tr>
    <td>Дата</td>
    <td><input type="text" name="information_date" id="information_date" value="'.(isset($information)?implode('.', array_reverse(explode('-', $information['information_date']))):'').'" size="26" />
	</td>
  </tr>
  <tr>
    <td>Кому</td>
    <td><select size="1" name="information_section">'; 
    
    if ($information['information_section'] == 'teacher')
    {
      echo '<option value="teacher" selected>Учителям</option>';
    }
    else
    {
   	  echo '<option value="teacher">Учителям</option>';
    }
    
    if ($information['information_section'] == 'student')
    {
      echo '<option value="student" selected>Ученикам</option>';
    }
    else
    {
   	  echo '<option value="student">Ученикам</option>';
    }
	 echo '</select></td>
  </tr>
  <tr>
    <td>Класс</td>
    <td><select size="1" name="information_classes"> 
   <option value="">Выберите</option>';
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
    <td>Тема</td>
    <td><input type="text" name="information_title" value="'.(isset($information)?$information['information_title']:'').'" size="26" /></td>
  </tr>
  <tr>
    <td>Сообщение</td>
    <td><textarea name="information_text" class="required" rows="10" cols="35">'.(isset($information)?$information['information_text']:'').'</textarea></td>
  </tr>
</table>
<center>';
if (is_null($information)) {
  echo '<input type="submit" value="Добавить" />';
} else {
	echo '<input type="submit" value="Обновить" />';
}
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="&nbsp;&nbsp;Закрыть&nbsp;&nbsp;" onclick="self.parent.tb_remove();self.parent.location.reload();" />
</center>
</form>';
}

?>
  </body>
</html>