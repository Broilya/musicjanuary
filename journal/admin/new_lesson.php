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

$subject_id   = @intval($_REQUEST['subject_id']);
$mode         = @$_REQUEST['mode'];



if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];

  if ($action == 'add') {
  	$lesson_date = implode('-', array_reverse(explode('.', $_REQUEST['lesson_date'])));
  	$topic = addslashes($_REQUEST['topic']);
  	$dz = addslashes($_REQUEST['dz']);
    $lesson_order = addslashes($_REQUEST['lesson_order']);
   
  	db_query("INSERT INTO `".TABLE_LESSONS."` VALUES(NULL, '$lesson_date', $subject_id, '$topic', '$dz', '$lesson_order', ".(time() + 60*60*45).");");
  	
    header('Location: new_lesson.php?mode=success_add');
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
  	echo $lang['new_lesson_add'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['add'].'&nbsp;&nbsp;" onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" />';
  } elseif ($mode == 'add') {
    outStudentForm();
  }

function outStudentForm()
{
	global $subject_id, $lang;
	echo '
<form action="new_lesson.php" method="post">';
  echo '<input type="hidden" name="action" value="add" />';  
  $quer="SELECT lesson_order+1 as t "
       ." FROM `".TABLE_LESSONS."` "
       ." WHERE subject_id='$subject_id' AND lesson_order!=10000 "
       ." ORDER BY lesson_order DESC LIMIT 1";  
  $res=mysql_query($quer);  
  $order=mysql_fetch_assoc($res);

  echo '<input type="hidden" name="subject_id" value="'.$subject_id.'" />
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
   <input type="text" name="lesson_date" id="lesson_date_id" value="" size="26" onchange="ewd_getcontent(\'ajaxform-she.php?date=\'+this.value+\'&subj='.$subject_id.'\', \'errordiv\');"/></td>
  <div id="errordiv"></div>
  </tr>
  <tr>
    <td>'.$lang['lesson_order'].'</td>
    <td><input type="text" name="lesson_order" value="'.$order['t'].'" size="2" /></td>
  </tr>
  <tr>
    <td>'.$lang['lesson_them'].'</td>
    <td><input type="text" name="topic" value="" size="26" /></td>
  </tr>
  <tr>
    <td>'.$lang['lesson_dz'].'</td>
    <td><textarea name="dz" rows="4"></textarea></td>
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
