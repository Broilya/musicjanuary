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

$schoolyear = @intval($_SESSION['schoolyear']);
$class_id   = @intval($_SESSION['classes']);
$quarter_id = @intval($_SESSION['quarterid']);
$mode       = @$_REQUEST['mode'];

$dump=0;if ($dump) {echo $class_id.'<br><pre>$_request=|';print_r($_REQUEST);echo '</pre>|<br>';}
if ($dump) {echo '<br><pre>$_SESSION=|';print_r($_SESSION);echo '</pre>|<br>';}

if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];

  if ($action == 'add') {

  	$date_schedule =(int)$_REQUEST['day'];
   	$i = 0;
    foreach ($_REQUEST['disciplines'] as $discipline) {
      if ($discipline > 0) {
        $cabinet    = $_REQUEST['cabinets'][$i];
        $teacher_id = (int)$_REQUEST['teachers'][$i];

        $id_schedule = (int)$_REQUEST['id_schedule'];
      //  echo "|".$order."|";
          $fields = array();
          $fields['cabinet']        = addslashes($_REQUEST['cabinets'][$i]);
          $fields['discipline_id']  = (int)$discipline;
          $fields['group_id']       = (int)$_REQUEST['groups'][$i];
          $fields['teacher_id']     = (int)$_REQUEST['teachers'][$i];
//          $_REQUEST['order_schedule'][$i] = $i+1;
          $fields['order_schedule'] = (int)$_REQUEST['order_schedule'][$i];
          $fields['quarter_id']     = $quarter_id;
          $fields['class_id']       = $class_id;
          $fields['date_schedule']  = $date_schedule;
          $fields['school_year']    = $schoolyear;

          $sql = "SELECT * FROM `".TABLE_SCHOOL_QUARTERS."` WHERE quarter_id='".$quarter_id."'";
          $quarter = db_get_first_row($sql);
          $fields['started']        = $quarter['started'];
          $fields['finished']       = $quarter['finished'];

if ($dump) echo "|$id_schedule|";
        db_array2insert(TABLE_SCHEDULE, $fields);


          $sql = "SELECT subject_id FROM `".TABLE_SUBJECTS."` WHERE (teacher_id='".$fields['teacher_id']."') AND (discipline_id='".$fields['discipline_id']."') AND (class_id='".$class_id."')";
          
          $subject_id = db_get_cell($sql);
if ($dump) echo "|subject_id=$subject_id|";
          if (empty($subject_id)) {
            $fields = array();
            $fields['class_id']       = $class_id;
            $fields['discipline_id']  = (int)discipline;
            $fields['teacher_id']     = (int)$_REQUEST['teachers'][$i];
            db_array2insert(TABLE_SUBJECTS, $fields);

          }



/*
        $sql = "SELECT `id_schedule` FROM `".TABLE_SCHEDULE."` WHERE `date_schedule`='$date_schedule' AND `school_year`='$schoolyear' AND `discipline_id`='$discipline' AND `class_id`='$class_id' AND `cabinet`='$cabinet' AND `teacher_id`='$teacher_id' AND `order_schedule`='$i' LIMIT 0,1";
//echo $sql;
        $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
        if (mysql_num_rows($res) == 1){
          $schedule_id = mysql_fetch_array($res);
          $sql="DELETE FROM `".TABLE_SCHEDULE."`"
              ." WHERE `schedule_id`='".$schedule_id."';";
          $res=mysql_query($sql);
        }
*/

////        $sql = "INSERT INTO `".TABLE_SCHEDULE."` (`id_schedule`, `date_schedule`, `school_year`, `quarter_id`, `discipline_id`, `class_id`, `cabinet`, `teacher_id`, `order_schedule`) VALUES" //   
////               ." (NULL, '$date_schedule', '$schoolyear', '$quarter_id', '$discipline', '$class_id', '$cabinet', '$teacher_id', '".($i+1)."');";
////if ($dump) echo $sql;

////        $res=mysql_query($sql);
//       db_query($sql);
///if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
      }
      $i++;
    }
    header('Location: new_schedule.php?mode=success_add');
    die();
  }  //  if ($action == 'add')
}  //  if (isset($_REQUEST['action']))
  
  include('../header_dialog.php');

?>
<script language='javascript'>
function nvalid(form){
  return true;
  for(i=0; i<form.elements.length; i++)
  {
     alert(form.name+"|"+form.elements[i].name+"="+form.elements[i].value);
  }
}
</script>

  <body>
<?php
  if ($mode == '') {
    $mode = 'add';
  }

  if ($mode == 'success_add') {
    echo $lang['predmet_add_good'].'<br /><br />';
    echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" />';
  } elseif ($mode == 'add') {
    outStudentForm();
  }

function outStudentForm()
{
  global $schoolyear, $class_id, $lang;
  echo '
<form action="new_schedule.php" method="post" onsubmit="nvalid(document.forms[\'ff\']);" name="ff">';
  echo '<input type="hidden" name="action" value="add" />';
/*
  echo '<input type="hidden" name="schoolyear" value="'.$schoolyear.'" />
      <input type="hidden" name="class_id" value="'.$class_id.'" />';
*/
  echo '<table width="100%"> <tr><td align="center">
<table cellpadding="2">

  <tr>
    <td>'.$lang['new_day_of_week'].'</td>
    <td>
<select name="day">
<option value="0">'.$lang['monday'].'</option>
<option value="1">'.$lang['vtornik'].'</option>
<option value="2">'.$lang['sreda'].'</option>
<option value="3">'.$lang['chetverg'].'</option>
<option value="4">'.$lang['pytnica'].'</option>
<option value="5">'.$lang['subbota'].'</option>

  
    </td>
  </tr>
  <tr>
    <th>&nbsp;</th>
    <th>'.$lang['disciplines'].' / '.$lang['groups'].'
    </th>
    <th>'.$lang['cabinets'].' / '
    .$lang['per_teacher'].'</th>
  </tr>';

  for($i=1; $i<=8; $i++) {
?>
    <tr>
    <td align="right"><input type="text" name="order_schedule[]" value="<?php echo $i;?>" size="5" maxlength="1"></td><td>
    <select name="disciplines[]" style='width:220px;'
        onchange="ewd_getcontent('ajaxform-teacher.php?disciplineid='+this.value+'&ID=<?php echo $i;?>&class=<?php echo $class_id;?>', 'teacherdiv<?php echo $i;?>');" >
<?php

    echo '    <option value="">'.$lang['select'].'</option>';
    $sql = "SELECT b.discipline_id, b.discipline FROM `".TABLE_SUBJECTS."` AS a"
      ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` AS b ON (b.discipline_id = a.discipline_id) WHERE a.class_id = '".$class_id."'";
//echo $sql;
    $db_discipline = mysql_query($sql);
    while ($discipline = mysql_fetch_array($db_discipline)) {
      echo "<option value='".$discipline['discipline_id']."'>".$discipline['discipline']."</option>";
    }

    echo '</select><br>';

    $groups_list = get_group_classes_list($class_id);

    echo '<select name="group[]"  id="group'.$i.'" style="width:100px;">
           <option value="">'.$lang['All_groups'].'</option>';

    foreach ($groups_list as $group) {
      $selgroup = ($schedule['group_id'] == $group['group_id']) ? "selected" : '';
   
      echo '<option $selgroup value="'.$group['group_id'].'">'.$group['group'].'</option>';
    }

?>   
      </select>
     </td>
    <td><input type="text" name="cabinets[]" value="" size="10" maxlength="30" />
    <div id="teacherdiv<?php echo $i;?>">
    <select name="teachers[]" id="teacher<?php echo $i;?>">
    <option value=""><?php echo $lang['select'];?></option>
    </select>
     </div>
     </td>
    </tr>
<?php
  }
  
  echo '</table>';
  echo '<input type="submit" value="'.$lang['add'].'" />';
  echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();}" />
</center></table>
</form>';

}

?>
  </body>
</html>
