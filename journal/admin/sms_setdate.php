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

$student_id   = @intval($_REQUEST['student_id']);
$mode         = @$_REQUEST['mode'];



if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];

  if ($action == 'add') {
  	$sms_date_from = implode('-', array_reverse(explode('.', $_REQUEST['send_date_from'])));
  	$sms_date_to = implode('-', array_reverse(explode('.', $_REQUEST['send_date_to'])));
  	
  	$send_type=$_REQUEST['send_mother']+$_REQUEST['send_father'];
 
  	db_query("UPDATE `".TABLE_USERS_STUDENTS."` SET 
		`send_from` = '{$sms_date_from}', 
		`send_to` = '{$sms_date_to}',
		`mode` = '{$send_type}'
	
		WHERE `student_id` ='{$student_id}'  ");

  	
    header('Location: sms_setdate.php?mode=success_add');
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
  	echo $lang['sms_param_update'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" />';
  } elseif ($mode == 'add') {
    outStudentForm();
  }

function outStudentForm()
{
	global $student_id, $lang;
	
	$query="select send_from, send_to, mode  FROM `".TABLE_USERS_STUDENTS."` where student_id='{$student_id}'";
	$res=mysql_query($query);
	$data=mysql_fetch_assoc($res);
	
	if ($data['mode']==1) { $chech_m=" checked "; } else  { $chech_m=" "; }
	if ($data['mode']==2) { $chech_f=" checked "; } else { $chech_f=" "; }
	if ($data['mode']==3) { $chech_m=" checked "; $chech_f=" checked "; }  else { $chech_f=" ";$chech_m=" "; }
	echo '
<form action="sms_setdate.php" method="post">';
  echo '<input type="hidden" name="action" value="add" />';
echo '<input type="hidden" name="student_id" value="'.$student_id.'" />
<table>

  <tr>
    <td>'.$lang['sms_send_start'].'</td>
    <td>
<script type="text/javascript">
	$(function() {
		$("#send_date_from_id").datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
	</script>
  <input type="text" name="send_date_from" id="send_date_from_id" value="'.$data['send_from'].'" size="26" /></td>
  </tr>
  
    <tr>
    <td>'.$lang['sms_send_end'].'</td>
    <td>
<script type="text/javascript">
	$(function() {
		$("#send_date_to_id").datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
	</script>
  <input type="text" name="send_date_to" id="send_date_to_id" value="'.$data['send_to'].'" size="26" /></td>
  </tr>
  
  
  <tr>
    <td>'.$lang['sms_send_to'].'</td>
    <td><input type="checkbox" name="send_mother" value="1"'; if ($data['mode']==1 or $data['mode']==3) echo " checked "; echo '>'.$lang['sms_send_to_mother'].'<br>
    <input type="checkbox" name="send_father" value="2" '; if ($data['mode']==2 or $data['mode']==3) echo " checked "; echo '>'.$lang['sms_send_to_father'].'<br>
    </td>
  </tr>
 
</table>
 ';
  echo '<input type="submit" value="'.$lang['save'].'" />';
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();}" />
</center>
</form>';
}

?>

  </body>
</html>