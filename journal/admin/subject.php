<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                      |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('ADMIN_ZONE', true);

include_once ('../init.php');
include_once ('../include/classes.php');

$dump=0;if ($dump) {echo '<br><pre>$_request=|';print_r($_REQUEST);echo '</pre>|<br>';}

$class_id    = intval($_REQUEST['class_id']);
$subject_id  = intval($_REQUEST['subject_id']);
$mode        = $_REQUEST['mode'];



if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
  $fields = array();

  if (empty($_REQUEST['teacher']) || empty($_REQUEST['discipline_id'])){
    header('Location: subject.php?subject_id='.$subject_id.'&mode=no_param');
    exit();
  }

  if ($action == 'add') {

    $fields[] = "class_id=". $class_id;
    $fields[] = "teacher_id=". intval($_REQUEST['teacher']);
    $fields[] = "discipline_id=". intval($_REQUEST['discipline_id']);

    db_query($sql = "INSERT `".TABLE_SUBJECTS."` SET ".implode(', ', $fields));
    header('Location: subject.php?mode=success_add');
    exit();

  } elseif ($action == 'update') {
    if (empty($_REQUEST['teacher']) || empty($_REQUEST['discipline_id'])){
      header('Location: subject.php?subject_id='.$subject_id.'&mode=no_param_upd');
    }


    $fields[] = "teacher_id=". intval($_REQUEST['teacher']);
    $fields[] = "discipline_id=". intval($_REQUEST['discipline_id']);


    db_query($sql = "UPDATE `".TABLE_SUBJECTS."` SET ".implode(', ', $fields).' WHERE subject_id='.$subject_id);
    header('Location: subject.php?mode=success_update');
    exit();

  }
}
  include('../header_dialog.php');
?>
  <body>
<?php

  if ($mode == 'no_param') {
  	echo '<center>'.$lang['no_param'].'<br /><br />';
  	$mode = '';
  }

  if ($subject_id == 0 && $mode == '') {
  	$mode = 'add';
  } elseif ($subject_id != 0 && $mode == '') {
  	$mode = 'update';
  }

  if ($mode == 'success_update') {
  	echo '<center>'.$lang['disp_update_good'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" /></center>';
  } elseif ($mode == 'success_add') {
  	echo $lang['new_disp_added_good'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" />';
  } elseif ($mode == 'update') {
    $subject  = db_get_first_row("SELECT * FROM `".TABLE_SUBJECTS."` WHERE subject_id='".$subject_id."'");
$dump=0;if ($dump) {echo '<br><pre>$subject=';print_r($subject);echo '</pre>|<br>';}
    outSubjectForm($subject);
  } elseif ($mode == 'add') {
    outSubjectForm();
  }

function outSubjectForm($subject = null)
{
  global $class_id, $subject_id, $lang;

  $res = db_query("SELECT * FROM `".TABLE_SPR_DISCIPLINES."` ORDER BY discipline");
  $disciplines = array();
  while($row = mysql_fetch_array($res)) {
    $disciplines[] = $row;
  }

  $res = db_query("SELECT * FROM `".TABLE_USERS_TEACHERS."` ORDER BY last_name,first_name,middle_name");
  $teachers = array();
  while($row = mysql_fetch_array($res)) {
    $teachers[] = $row;
  }

  echo '
<form action="subject.php" method="post">';
  if (isset($subject)) {
    echo '<input type="hidden" name="action" value="update" />';
  } else {
    echo '<input type="hidden" name="action" value="add" />';
  }
  echo '
<input type="hidden" name="class_id" value="'.$class_id.'" />
<input type="hidden" name="subject_id" value="'.$subject_id.'" />
<table width="100%"
  <tr>
    <td>'.$lang['disclipline'].'</td>
    <td>';
/*&class=<?php echo $class_id;?>*/
/*  ?disciplineid='+this.value+'&teacher_id=<?php echo $subject['teacher_id']; ?>*/
?>
   <select name="discipline_id"
        onchange="ewd_getcontent('ajaxform-teacher.php?disciplineid='+this.value, 'teacherdiv');" >

<?php
  echo '<option value="">'.$lang['select'].'</option>';

  foreach($disciplines as $discipline) {
    echo '<option value="'.$discipline['discipline_id'].'"';
    if ($discipline['discipline_id'] == $subject['discipline_id']) {
    	echo ' selected="selected"';
    }
    echo '>'.$discipline['discipline'].'</option>';
  }
  echo '</select>
    </td>
  </tr>
  <tr>
    <td>'.$lang['teacher'].'</td>
    <td>
    <div id="teacherdiv">
    <select name="teacher" id="teacher">
    <option value="">'.$lang['select'].'</option>
    </select>
     </div>';
/*
<select name="teacher_id">';
foreach($teachers as $teacher) {
  echo '<option value="'.$teacher['teacher_id'].'"';
  if ($teacher['teacher_id'] == $subject['teacher_id']) {
  	echo ' selected="selected"';
  }
  echo '>'.$teacher['last_name'].' '.$teacher['first_name'].' '.$teacher['middle_name'].'</option>';
}
*/
  echo '
    </td>
  </tr>
  <tr><td colspan="2">&nbsp;</td></tr>
  <tr>
    <td colspan="2" align="center">';
  if (isset($subject)) {
  	echo '<input type="submit" value="'.$lang['save'].'">';
  } else {
    echo '<input type="submit" value="'.$lang['add'].'">';
  }
  echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();}" /></td>
</tr>
</table>
</form>';
?>
<script language='javascript'> <!--
  if ('<?php echo $subject['discipline_id'];?>' +0 > 0)
    ewd_getcontent('ajaxform-teacher.php?disciplineid=<?php echo $subject['discipline_id'];?>&teacher_id=<?php echo $subject['teacher_id']; ?>', 'teacherdiv');
//--></script>
<?php

}

?>
  </body>
</html>