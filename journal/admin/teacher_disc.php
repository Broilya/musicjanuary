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

  $teacher_id = intval($_REQUEST['teacher']);
  $mode       = $_REQUEST['mode'];



if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
  $fields = array();

  if ($action == 'add') {

    if (empty($_REQUEST['discipline_id']) || empty($_REQUEST['teacher'])){
      header('Location: teacher_disc.php?teacher='.$teacher_id.'&mode=no_param_upd');
      exit();
    }
    $fields[] = "`teacher_id`='". intval($_REQUEST['teacher'])."'";
    $fields[] = "`discipline_id`='". intval($_REQUEST['discipline_id'])."'";

    db_query("INSERT `".TABLE_SUBJECTS."` SET ".implode(', ', $fields));
    $mode='success_add';

  } elseif ($action == 'delete') {
    $subject_id = intval($_REQUEST['subject_id']);
    if (empty($_REQUEST['subject_id'])){
      header('Location: teacher_disc.php?teacher='.$teacher_id.'&mode=no_param_upd');
      exit();
    }
    $sql = "DELETE FROM `".TABLE_SUBJECTS."` WHERE subject_id='".$subject_id."'";
//echo $sql;
    $mode='success_del';
    db_query($sql);
  }
}
  include('../header_dialog.php');
?>
  <body>
<?php

  if ($mode == 'no_param_upd') {
  	echo '<center>'.$lang['no_param'].'<br /><br />';
  	$mode = '';
  }

  if ($mode == 'success_add') {
  	echo $lang['new_disp_added_good'].'<br /><br />';
  } elseif ($mode == 'success_del') {
  	echo $lang['disp_delete_good'].'<br /><br />';
  } 
  
  $mode = 'add';
  if ($mode == 'add') {
    $sql = "SELECT s.*, d.* FROM `".TABLE_SUBJECTS."` s"
          ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` d ON (d.discipline_id = s.discipline_id)"
          ." WHERE s.teacher_id='".$teacher_id."' ORDER BY d.discipline";

    $subjects = db_get_rows($sql);
    $subject  = db_get_first_row("SELECT * FROM `".TABLE_SUBJECTS."` WHERE subject_id='".$subject_id."'");
$dump=0;if ($dump) {echo $sql.'<br><pre>$subject=';print_r($subjects);echo '</pre>|<br>';}
    outSubjectForm($subject);
  }

function outSubjectForm($subject = null)
{
  global $teacher_id, $subjects, $subject_id, $lang;

  $teacher_name = db_get_cell("SELECT CONCAT( ' ', t.last_name,  ' ',t.first_name,  ' ',t.middle_name ) AS teacher_name"
                 ." FROM `".TABLE_USERS_TEACHERS."` t WHERE t.teacher_id='".$teacher_id."'");

  echo '
<form action="teacher_disc.php" method="post">';
  echo '<input type="hidden" name="action" value="add" />';

  echo '
        <input type="hidden" name="subject_id" value="'.$subject_id.'" />
        <input type="hidden" name="teacher" value="'.$teacher_id.'" />'
       .$teacher_name.'
       <table width="100%"
 ';
  echo '<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <tr>';

/*&class=<?php echo $class_id;?>*/
/*  ?disciplineid='+this.value+'&teacher_id=<?php echo $subject['teacher_id']; ?>*/
?>
<?php
$dump=0;if ($dump) {echo $sql.'<br><pre>$subject=';print_r($subjects);echo '</pre>|<br>';}

  foreach($subjects as $discipline) {
$dump=0;if ($dump) {echo $sql.'<br><pre>$discipline=';print_r($discipline);echo '</pre>|<br>';}
    echo '  <tr>
    <td colspan="2">'.$discipline['discipline'].'</td>'
   .'<td><a style="font-size:16px;color:red;" title="Удалить" '
           .'href="teacher_disc.php?action=delete&subject_id='.$discipline['subject_id'].'&teacher='.$teacher_id.'"'
           .'onClick="if (confirm('."'Вы желаете удалить дисциплину `".$discipline['discipline']."`?'"
                         .')) return true; else return false;"><img src="images/del.gif" border="0"></a></label></td>
      </tr> ';
      $_subjects['discipline_id'][] = $discipline['discipline_id'];
  }

  echo '<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <tr>';

  $res = db_query("SELECT * FROM `".TABLE_SPR_DISCIPLINES."` ORDER BY discipline");
  $disciplines = array();
  while($row = mysql_fetch_array($res)) {
    $disciplines[] = $row;
  }


  echo '<tr>
    <td>'.$lang['disclipline'].'</td>
    <td colspan="2">';
/*&class=<?php echo $class_id;?>*/
/*  ?disciplineid='+this.value+'&teacher_id=<?php echo $subject['teacher_id']; ?>*/

?>
   <select name="discipline_id" >

<?php
  echo '<option value="">'.$lang['select'].'</option>';

  foreach($disciplines as $discipline) {
    if (in_array ($discipline['discipline_id'], $_subjects['discipline_id'])) continue;

    echo '<option value="'.$discipline['discipline_id'].'"';
    if ($discipline['discipline_id'] == $subjects['discipline_id']) {
    	echo ' selected="selected"';
    }
    echo '>'.$discipline['discipline'].'</option>';
  }
  echo '</select>
    </td>
  </tr>

  <tr><td colspan="3">&nbsp;</td></tr>
  <tr>
    <td colspan="3" align="center">';

    echo $subject.'<input type="submit" value="'.$lang['add'].'">';
/*
  if (empty($subject)) {
  } else {
    echo '<input type="submit" value="'.$lang['save'].'">'.$subject;
  }
*/
  echo '&nbsp;&nbsp;&nbsp;&nbsp;'
      .'<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" /></td>
        </tr>
     </table>
   </form>';

}

?>
  </body>
</html>
