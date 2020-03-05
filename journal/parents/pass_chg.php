<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/



define('PARENT_ZONE', true);
include_once ('../init.php');
include_once ('../include/classes.php');
$mode=$_GET['mode'];
$student_id = $_SESSION['student_id'];


if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
  

  if ($action == 'update') {
  	  

    db_query("UPDATE `".TABLE_USERS_STUDENTS."` SET password='{$_POST['newpass']}' WHERE student_id=".$student_id);
    header('Location: pass_chg.php?mode=success_update');
    exit();
  }
}
  include('../header_dialog.php');
?>
  <body style="margin-left: 0px; margin-right: 5px;">
<?php
 
  if ($student_id != 0 && $mode == '') {
  	$mode = 'update';
  	
  	?>
  	<center>
  	<form id='fr1' method='post' action=''> 
  	<?php echo $lang['user_login_pass'];?>: <input type='text' name='newpass'>
  	<input type='hidden' value='update' name='action'>
  	<input type='submit' value='<?php echo $lang['refresh'];?>'><br>
  	</form>
  	</center>
  	
  	<?php 
  	
  	
  }

  if ($mode == 'success_update') {
  	echo '<center><b>'.$lang['pass_chenged'].'.</b><br /><br />';
  
  } 
  
  

echo '
<center><br>
<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" class="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="self.parent.tb_remove();self.parent.location.reload();" />
</center>
</form>';


?>
  </body>
</html>