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

         if ($_POST['newpass']!='') {  
    	 $fields[2] = "passwd='".md5($_POST['newpass'])."'"; 
         
         
         } 
         if ($_POST['dir']!='') {  
    	 $fields[3] = "director=1 ";          
         
         } 
    
  if ($fields[2]!="" and $fields[3]!="") $coma=" , ";
    
   if ( $err!=1) { 
    db_query("UPDATE `".TABLE_USERS_TEACHERS."` SET {$fields[2]} $coma {$fields[3]} WHERE teacher_id='".$student_id."'"); }
    
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
  	$sql="select * FROM `".TABLE_USERS_TEACHERS."` where teacher_id='".$student_id."'";
  	$res=mysql_query($sql);
  	$row=mysql_fetch_array($res);

  	
  	?>
  	<b><?php echo $lang['auth_teacher_edit'];?><br>
  	<?=$row['last_name']?> <?=$row['first_name']?>  <?=$row['middle_name']?> </b><br><br>
  	 
  	<form id='fr1' method='post' action=''> 
  	<table> <tr> 
  	
  	<tr> <td><?php echo $lang['new_password'];?>: <td><input type='text' name='newpass'>
  	<?php if($row['director']=="1") $chec="checked";?>
  	<tr> <td><?php echo $lang['set_director'];?>: <td><input type='checkbox' <?php echo $chec;?> name='dir' value='1'>
  	
  	<input type='hidden' value='update' name='action'>
  	<tr> <td><td><input type='submit' value='<?php echo $lang['refresh'];?>'><br>
  	</form>
  	
  	
  	
  	
  	
  	</center>
  	
  	<?php 
  	
  	
  }

  if ($mode == 'success_update') {
  	echo "<center>{$lang['update_good']}.<br /><br />";
  
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