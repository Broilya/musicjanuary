<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('ADMIN_ZONE', true);
include_once ('../init.php');
include_once ('../include/classes.php');

$lesson_id   = @intval($_REQUEST['lesson_id']);
$mode        = @$_REQUEST['mode'];


if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];

  if ($action == 'update') {
  	$fields = array();
    $fields['lesson_date'] = implode('-', array_reverse(explode('.', $_POST['lesson_date'])));
    $fields['topic'] = addslashes($_POST['topic']);
    $fields['dz'] = addslashes($_POST['dz']);
    $fields['lesson_order'] = addslashes($_REQUEST['lesson_order']);
    
    db_array2update(TABLE_LESSONS, $fields,'lesson_id='.$lesson_id);
   	header('Location: edit_lesson.php?mode=success_update');
    
  }
}
  include('../header_dialog.php');
?>
  <body>
<?php
  
  if ($mode == '') {
  	$mode = 'update';
  }
  
  if ($mode == 'success_update') {
  	echo $lang['info_update_good_qq'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="self.parent.tb_remove();self.parent.location.reload();" />';
  } elseif ($mode == 'update') {
  	$lesson = db_get_first_row("SELECT * FROM `".TABLE_LESSONS."` WHERE lesson_id='".$lesson_id."'");
    outLessonForm($lesson);
  }

function outLessonForm($lesson = null)
{
	global $subject_id, $lang;
	echo '
<form action="edit_lesson.php" method="post">';
  echo '<input type="hidden" name="action" value="update" />';
echo '<input type="hidden" name="lesson_id" value="'.$lesson['lesson_id'].'" />
<table>

  <tr>
    <td>'.$lang['lesson_date'].'</td>
    <td>
<script type="text/javascript">
	$(function() {
		$("#lesson_date_id").datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
	</script>

    <input type="text" name="lesson_date" id="lesson_date_id" value="'.(isset($lesson)?implode('.', array_reverse(explode('-', $lesson['lesson_date']))):'').'" size="26" /></td>
  </tr>
  <tr>
    <td>'.$lang['lesson_date'].'</td>
    <td><input type="text" name="lesson_order" value="'.(isset($lesson)?$lesson['lesson_order']:'').'" size="2" /></td>
  </tr>
    <tr>
    <td>'.$lang['lesson_them'].'</td>
    <td><input type="text" name="topic" value="'.(isset($lesson)?$lesson['topic']:'').'" size="26" /></td>
  </tr>
  <tr>
    <td>'.$lang['lesson_dz'].'</td>
    <td><textarea name="dz" rows="4">'.(isset($lesson)?$lesson['dz']:'').'</textarea></td>
  </tr>
</table>
 ';
  echo '<input type="submit" value="'.$lang['refresh'].'" />';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();}" />
</center>
</form>';
}

?>
  </body>
</html>