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

$student_id = $_GET['st'];
$mode = $_GET['mode'];

if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
  

  if ($action == 'update') {
  	   $err=0;
    if ($_POST['login']!='') {
    	$sql="select * FROM `".TABLE_USERS_STUDENTS."` where login='{$_POST['login']}'";
    	$res=mysql_query($sql);
    	$num=mysql_num_rows($res);
    	
    	if ($num != 0 ) { 
    		?>
    		<center><br><b><?php echo $lang['user_login_error'];?></b>!</center>
    		<input type="button" class="button" value="&nbsp;&nbsp;<?php echo $lang['close'];?>&nbsp;&nbsp;" onclick="self.parent.tb_remove();self.parent.location.reload();" />
    		
    		
    		<?php 
    		exit();
    		$err=1; }
    	if ($err!=1) {
         $fields[1] = "login='".mysql_escape_string(substr($_POST['login'], 0, 25))."'"; }
    }  
         if ($_POST['newpass']!='') {  
    	 $fields[2] = "password='".mysql_escape_string(substr($_POST['newpass'], 0, 25))."'"; } 
    
    if ($_POST['login']!='' and $err!=1) {
   
    db_query("UPDATE `".TABLE_USERS_STUDENTS."` SET {$fields[1]} WHERE student_id=".$student_id); }
    
   if ($_POST['newpass']!='' and $err!=1) {
    db_query("UPDATE `".TABLE_USERS_STUDENTS."` SET {$fields[2]} WHERE student_id=".$student_id); }
    
    header('Location: auth_chg.php?mode=success_update'); 
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
  	
  	<?php 
  	$sql="select * FROM `".TABLE_USERS_STUDENTS."` where student_id=".$student_id;
  	$res=mysql_query($sql);
  	$row=mysql_fetch_array($res);

  	
  	?>
  	<b><?php echo $lang['user_edit_auth_d'];?><br>
  	<?=$row['last_name']?> <?=$row['first_name']?>  <?=$row['middle_name']?> </b><br><br>
  	 
  	<form id='fr1' method='post' action=''> 
  	<table> <tr> 
  	<td>   <?php echo $lang['user_login_login'];?>: <td><input type='text' name='login'>
  	<tr> <td><?php echo $lang['user_login_pass'];?>: <td><input type='text' name='newpass'>
  	<input type='hidden' value='update' name='action'>
  	<tr> <td><input type='submit' value='<?php echo $lang['refresh'];?>'><br>
  	</form>
  	</center>
  	
  	<?php 
  	
  	
  }

  if ($mode == 'success_update') {
  	echo '<center>'.$lang['user_update_login_good'].'.<br /><br />';
  
  } elseif ($mode == 'update') {

  	
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