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

$schedule_id = @intval($_REQUEST['schedule_id']);
$subject_id  = @intval($_REQUEST['subject_id']);
$lesson_id   = @intval($_REQUEST['lesson_id']);
$lesson_date = $_SESSION['lesson_date'];

if ($dump) echo "4)|$lesson_date|";
if ($dump) {echo '<br>4)<pre>$_SESSION=|';print_r($_SESSION);echo '</pre>|<br>';}

$mode        = @$_REQUEST['mode'];


  $_date  = implode('.', array_reverse(explode('-', $lesson_date)));
  if (empty($lesson_id)) {
    
    $fields = array();
    $fields['lesson_date'] = addslashes($lesson_date);
    $fields['subject_id']  = $subject_id;
    $fields['schedule_id'] = $schedule_id;
    $fields['active']      = 1;
    $lesson_id = db_array2insert(TABLE_LESSONS, $fields);

//    db_query("INSERT INTO `".TABLE_LESSONS."` (`lesson_date`, `subject_id`, `schedule_id`, `active`) VALUES('$lesson_date', '$subject_id', '$schedule_id', 1);");
//echo "INSERT INTO `".TABLE_LESSONS."` (`lesson_date`, `subject_id`, `schedule_id`, `active`) VALUES('$lesson_date', '$subject_id', '$schedule_id', 1);";
//    $lesson_id = mysql_insert_id();	
//    $_SESSION['lesson_id']  = $lesson_id;
//    echo '<input type="hidden" name="lesson_id"  id="lesson_id" value="'.$lesson_id.'">';
/*
echo "
<script language='javascript'> <!--
   location= 'theme-lessons.php?lesson_date=".$_date."&lesson_id=".$lesson_id."';
*/
//--></script>";
//    header('Location: theme-lessons.php?lesson_date='.$_date.'&lesson_id='.$lesson_id);
//http://schoole.servicetelematic.ru.int/journal/admin/theme-lessons.php?subject_id=36&act=edit_grades&sub_act=zero&less=104
/*
?>
<script language='javascript'> <!--
self.parent.tb_remove();
self.parent.location= 'theme-lessons.php?subject_id=<?php echo $subject_id;?>&act=edit_grades&sub_act=zero&lesson_id=<?php echo $lesson_id;?>&less=<?php echo $lesson_id;?>';
//--></script>
	
<?php
    exit;
*/
    header('Location: theme-lessons.php?subject_id='.$subject_id.'&act=edit_grades&sub_act=zero&lesson_id='.$lesson_id.'&less='.$lesson_id);
    exit;
    $mode = 'success_update';
  } else {
/*
?>
<script language='javascript'> <!--
self.parent.tb_remove();
self.parent.location= 'theme-lessons.php?lesson_date=<?php echo $_date;?>&lesson_id=<?php echo $lesson_id;?>';
//--></script>
	
<?php
    exit;
*/
    header('Location: theme-lessons.php?lesson_date='.$_date.'&lesson_id='.$lesson_id);
    exit;
/*
    $fields = array();
    $fields['topic'] = addslashes($_REQUEST['topic']);
    $fields['dz'] = addslashes($_REQUEST['dz']);
    $fields['lesson_order'] = addslashes($_REQUEST['lesson_order']);
    db_array2update(TABLE_LESSONS, $fields,'lesson_id='.$lesson_id);
    echo $lang['info_update_good_qq'];
//   	header('Location: edit_lesson.php?mode=success_update');
*/    
  }

//    exit;
  include('../header_dialog.php');
?>
  <body>
<?php
  
  if ($mode == '') {
  	$mode = 'update';
  }
//  http://schoole.servicetelematic.ru.int/journal/admin/theme-lessons.php?subject_id=36&act=edit_grades&sub_act=zero&less=289  
  if ($mode == 'success_update') {
  	echo $lang['new_lesson'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="self.parent.tb_remove();
  	self.parent.location= \'theme-lessons.php?subject_id='.$subject_id.'&act=edit_grades&sub_act=zero&lesson_id='.$lesson_id.'&less='.$lesson_id.'\';
  	" />';
  } elseif ($mode == 'update') {
  	$lesson = db_get_first_row("SELECT * FROM `".TABLE_LESSONS."` WHERE lesson_id='".$lesson_id."'");
  }
?>