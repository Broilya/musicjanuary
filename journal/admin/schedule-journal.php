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
include_once ('../include/curriculums.php');

if (!isset($_SESSION['schoolyear'])) {
  $_SESSION['schoolyear']='';
  $_SESSION['quarterid'] ='';
  $_SESSION['classes']='';
}
  unset($_SESSION['quaterid']);

if (!isset($_SESSION['classes'])) {
  $_SESSION['classes']='';
}

if(isset($_REQUEST['data'])) {
  $_SESSION['schoolyear'] = $_REQUEST['schoolyear'];
  $_SESSION['classes'] = $_REQUEST['classes'];
  $_SESSION['quarterid'] = $_REQUEST['quarter_id'];
  
//  session_register('schoolyear');
//  session_register('classes');

  exit(header ('Location: schedule-journal.php'));

}
$dump=0;if ($dump) {echo '<br><pre>$_SESSION=|';print_r($_SESSION);echo '</pre>|<br>';}
if ($dump) {echo '<br><pre>$_REQUEST=|';print_r($_REQUEST);echo '</pre>|<br>';}

$class_id = $_SESSION['classes'];

if ($_POST['act']=="del")
{
	if ($_POST['0']=="0")
	{
	$q="delete FROM `".TABLE_SCHEDULE."` where date_schedule=0 and school_year='{$_SESSION['schoolyear']}' and class_id='{$_SESSION['classes']}' ";
	$res=mysql_query($q);
	}
	if ($_POST['1']=="1")
	{
	$q="delete FROM `".TABLE_SCHEDULE."` where date_schedule=1 and school_year='{$_SESSION['schoolyear']}' and class_id='{$_SESSION['classes']}' ";
	$res=mysql_query($q);
	}
	if ($_POST['2']=="2")
	{
	$q="delete FROM `".TABLE_SCHEDULE."` where date_schedule=2 and school_year='{$_SESSION['schoolyear']}' and class_id='{$_SESSION['classes']}' ";
	$res=mysql_query($q);
	}
	if ($_POST['3']=="3")
	{
	$q="delete FROM `".TABLE_SCHEDULE."` where date_schedule=3 and school_year='{$_SESSION['schoolyear']}' and class_id='{$_SESSION['classes']}' ";
	$res=mysql_query($q);
	}
	if ($_POST['4']=="4")
	{
	$q="delete FROM `".TABLE_SCHEDULE."` where date_schedule=4 and school_year='{$_SESSION['schoolyear']}' and class_id='{$_SESSION['classes']}' ";
	$res=mysql_query($q);
	}
	if ($_POST['5']=="5")
	{
	$q="delete FROM `".TABLE_SCHEDULE."` where date_schedule=5 and school_year='{$_SESSION['schoolyear']}' and class_id='{$_SESSION['classes']}' ";
	$res=mysql_query($q);
	}
	if ($_POST['6']=="6")
	{
	$q="delete FROM `".TABLE_SCHEDULE."` where date_schedule=6 and school_year='{$_SESSION['schoolyear']}' and class_id='{$_SESSION['classes']}' ";
	$res=mysql_query($q);
	}
	if ($_POST['7']=="7")
	{
	$q="delete FROM `".TABLE_SCHEDULE."` where date_schedule=7 and school_year='{$_SESSION['schoolyear']}' and class_id='{$_SESSION['classes']}' ";
	$res=mysql_query($q);
	}


} //  if ($_POST['act']=="del")

if(isset($_REQUEST['fschedule'])) {
 
  $id_schedule = (int)$_REQUEST['id_schedule'];
//  echo "|".$order."|";
    $fields = array();
    $fields['cabinet']        = addslashes($_REQUEST['cabinet']);
    $fields['discipline_id']  = (int)$_REQUEST['discipline'];
    $fields['group_id']       = (int)$_REQUEST['group'];
    $fields['teacher_id']     = (int)$_REQUEST['teacher'];
    $fields['order_schedule'] = (int)$_REQUEST['order_schedule'];
    $fields['quarter_id']     = (int)$_SESSION['quarterid'];
if ($dump) echo "|$id_schedule|";
    db_array2update(TABLE_SCHEDULE, $fields,"`id_schedule`='".$id_schedule."'");

    $sql = "SELECT subject_id FROM `".TABLE_SUBJECTS."` WHERE (teacher_id='".$fields['teacher_id']."') AND (discipline_id='".$fields['discipline_id']."') AND (class_id='".$class_id."')";
    
    $subject_id = db_get_cell($sql);
if ($dump) echo "|subject_id=$subject_id|";
    if (empty($subject_id)) {
      $fields = array();
      $fields['class_id']       = $class_id;
      $fields['discipline_id']  = (int)$_REQUEST['discipline'];
      $fields['teacher_id']     = (int)$_REQUEST['teacher'];
      db_array2insert(TABLE_SUBJECTS, $fields);

    }

//  mysql_query("UPDATE `".TABLE_SCHEDULE."` SET discipline_id='".$discipline_id."', teacher_id='".$teacher_id."', cabinet='".$cabinet."', order_schedule='".$order_schedule."' `quarter_id`='".$quarter_id."' WHERE id_schedule='".$id_schedule."'");

//  exit(header ('Location: schedule-journal.php'));

}

include 'header.php';

?>
<div align="center"> 
<br />

<script language='javascript'>
function nvalid(form, i){
  if (i> -1) {
    alocation='?'+
      '&fschedule=edit'+
      '&quarter_id='+document.getElementById('quarter_id').value+
      '&id_schedule='+document.getElementById('id_schedule'+i).value+
      '&order_schedule='+document.getElementById('order_schedule'+i).value+
      '&discipline='+document.getElementById('discipline'+i).value+
      '&group='+document.getElementById('group'+i).value+
      '&cabinet='+document.getElementById('cabinet'+i).value+
      '&teacher='+document.getElementById('teacher'+i).value;

//alert(alocation);
     location = alocation;

    return true;
  }

  for(i=0; i<form.elements.length; i++)
  {
     alert(form.name+"|"+form.elements[i].name+"="+form.elements[i].value);
  }
}
</script>

<script type="text/javascript">
function eventHandler(__id)
{
	var text=document.getElementById(__id).value;
	
	if(text=="") {
		document.getElementById(__id).value=__id; }
	else { document.getElementById(__id).value=""; }
   
  
}
</script>


<form action="schedule-journal.php"  method="post" id="fschedule">
<input name="data" type="hidden" value="load"/>
 <table width="40%" border="0" cellpadding="2" cellspacing="2" bgcolor="#e7e7e7">
 <tr>
 <td width="15%" height="45px"><b><?php echo $lang['year'];?></b><br/>
  <select name="schoolyear" onchange="ewd_getcontent('ajaxform-classes.php?schoolyear='+this.value, 'classesdiv');">
   <option value=""><?php echo $lang['select'];?></option>
 <?php 
  $school_years = get_school_years();

  foreach ($school_years as $years) {

    if ($years['school_year_id']==$_REQUEST['school_year']) {
      $selected="selected"; 
      $_SESSION['schoolyear'] = $years['school_year_id'];
    } elseif (empty($years['current'])) 
      $selected="";
    else {
      $selected="selected"; 
      $_SESSION['schoolyear'] = $years['school_year_id'];
    }
?>

<option value="<?php echo  $years['school_year_id'];?>" <?php echo $selected;?>><?php echo $years['name_year'];?></option>

<?php

  }

?>
   
 </select>
  </td>
  <td width="15%"><b><?php echo $lang['quater'];?>:</b><br/>
  <div id="quaterdiv">
  <select name="quarter_id" id="quarter_id" on_change="ewd_getcontent('ajaxform-discipline.php?quarterid='+this.value, 'disciplinesdiv');">
  <option value=""><?php echo $lang['select'];?></option>

<?php

  if($_SESSION['schoolyear']!=='') {
    $db_classes=db_query("SELECT * FROM `".TABLE_SCHOOL_QUARTERS."` WHERE school_year_id='".$_SESSION['schoolyear']."'");

    while ($quater = mysql_fetch_array($db_classes)) {

     if (empty($_SESSION['quarterid'])) {
        if($quater['current'] != 0) {
          $select = ' selected="selected"';
          $_SESSION['quarterid'] = $quater['quarter_id'];
        }else
          $select = '';
      } elseif ($_SESSION['quarterid'] == $quater['quarter_id']){
        $select = ' selected="selected"';
      } else { 
        $select = "";
      }
   
      echo "<option $select value=\"".$quater['quarter_id']."\">".$quater['quarter_name']."</option>";
    }
  }

  ?>
 </select>
 </div>
  </td>
  <td width="15%"><b><?php echo $lang['class'];?>:</b><br/>
  <div id="classesdiv">
  <select name="classes" on_change="ewd_getcontent('ajaxform-discipline.php?classid='+this.value, 'disciplinesdiv');">
  <option value=""><?php echo $lang['select'];?></option>

<?php


  if($_SESSION['schoolyear']!=='') {
    $db_classes = mysql_query("SELECT class_id, class, letter FROM `".TABLE_CLASSES."` WHERE school_year = '".$_SESSION['schoolyear']."' ORDER BY class, letter");

    while ($classes1 = mysql_fetch_array($db_classes)) {

      if ($_SESSION['classes'] == $classes1['class_id']){
        $selclass = ' selected="selected"';
      } else { 
        $selclass = "";
      }
   
      echo "<option $selclass value=\"".$classes1['class_id']."\">".$classes1['class']." ".$classes1['letter']."</option>";
    }
  }

if ($dump) {echo '<br><pre>$_SESSION=|';print_r($_SESSION);echo '</pre>|<br>';}

  ?>
 </select>
 </div>
  </td>
  <td width="10%"><br/>
  <input type="submit" value="<?php echo $lang['data_output'];?>" />
  </td>
<td width="1%"><div id="disciplinesdiv" style="display:none;"></div></td>
 </tr>
     <tr>
      <td colspan="4" align="center"><a href="" onClick="javascript: tb_show('<?php echo $lang['schedule_upload'];?>', 'add_schedule.php?<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=200&width=400&mo_dal=true'); return false;" class="add" title="<?php echo $lang['schedule_upload'];?>"><?php echo $lang['schedule_upload'];?></a>
     </td>
    </tr>
</table>
 </form>

 <br />
<table align="center" cellspacing="0" cellpadding="0" border="0">
      <tbody>
    	<tr>
       	  <td>
      &nbsp;<a  class="dnl" href="../phpexcel/schedule_templ.xls">Скачать шаблон для ввода расписания</a>
<!--            <form name="download" action="./download_schedule_templ.php" method="POST">

            <input value="Получить шаблон для ввода расписания" type="submit">&nbsp;&nbsp;&nbsp;
            </form>-->
          </td>

       	  <td>
<!--            <form name="download" action="./download_schedule.php" method="POST">

            &nbsp;&nbsp;<input value="Получить текущее расписание" type="submit">
            </form>-->
          </td>
        </tr>
    </tbody>
</table>
 <br />

<?php


if($_SESSION['schoolyear'] !=='' && $_SESSION['classes'] !=='') 
{ 


/*
<a href="new_schedule.php?schoolyear=<?php echo $_SESSION['schoolyear']; ?>&class_id=<?php echo $_SESSION['classes'] ?>&TB_iframe=true&height=500&width=800&<?php echo uniqid('r'); ?>" title="Добавить предмет и дату" class="thickbox"><?php echo $lang['add_predmed_date'];?></a>

*/
?>

<a href="new_schedule.php?schoolyear=<?php echo $_SESSION['schoolyear']; ?>&class_id=<?php echo $_SESSION['classes'] ?>&TB_iframe=true&height=500&width=800&<?php echo uniqid('r'); ?>" title="Добавить предмет и дату" class="thickbox"><?php echo $lang['add_predmed_date'];?></a>

<br/><br/>

 <table border="0" cellpadding="3" cellpadding="3" width="600">
 <thead>
 <tr>
 <td bgcolor="#e7e7e7" width="120"><b><?php echo $lang['day_pe'];?></b></td>
 <td bgcolor="#e7e7e7" width="30"><b><?php echo $lang['per_por'];?></b></td>
 <td bgcolor="#e7e7e7" align="center" width="160"><b><?php echo $lang['predmet_per'];?></b> /
 <b><?php echo $lang['groups'];?></b></td>
 <td bgcolor="#e7e7e7" width="160"><b><?php echo $lang['per_cabinet'];?></b> /
 <b><?php echo $lang['per_teacher'];?></b></td>
 <td bgcolor="#e7e7e7" width="30"></td>
 
 </tr>
 </thead>
 
<?php

  echo '
  <form action="schedule-journal.php"  method="post" id="fschedule_edit" name="fschedule_edit">
  <input name="fschedule" type="hidden" value="edit"/>
  <tbody>';
  $i=1;

  $date0 = date_monday();
  $sql = "SELECT a.*, b.discipline, t.`last_name`, t.`first_name`, t.`middle_name`"
         ." FROM `".TABLE_SCHEDULE."` AS a"
         ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` AS b ON b.`discipline_id` = a.`discipline_id`"
         ." LEFT JOIN `".TABLE_USERS_TEACHERS."` AS t ON t.`teacher_id` = a.`teacher_id`"
         ." WHERE a.`school_year`='".$_SESSION['schoolyear']."' AND a.`quarter_id`='".$_SESSION['quarterid']."'"
         ." AND a.`class_id`='".$_SESSION['classes']."'"
         ." AND DATE_FORMAT(DATE_ADD('".$date0."', INTERVAL a.`date_schedule` DAY), '%Y-%m-%d') BETWEEN  a.`started` AND a.`finished`" 
         ." ORDER BY a.`date_schedule`, a.`order_schedule`, a.`started` DESC, a.`finished`";
$dump=0;if ($dump) echo $sql."\n";
//print_r($_SESSION);

  $db_schedule = mysql_query($sql);

  while ($schedule = mysql_fetch_array($db_schedule)) {

if ($dump)  print_r($schedule);

    switch ($schedule['date_schedule']) {
    case 0: $day=$lang['monday']; break;
    case 1: $day=$lang['vtornik']; break;
    case 2: $day=$lang['sreda']; break;
    case 3: $day=$lang['chetverg']; break;
    case 4: $day=$lang['pytnica']; break;
    case 5: $day=$lang['subbota']; break;
    
    }

    if ($date_schedule !== $schedule['date_schedule']){
      if ($i!=1) {
        echo "<tr><td>&nbsp;</td></tr>";
        echo '<tr><td bgcolor="#e7e7e7" colspan="6" style="height:2px;"></td></tr>';
      }
      echo '<tr><td><input type="checkbox" onChange="eventHandler('.$schedule['date_schedule'].')">&nbsp;&nbsp;'.$day.'</td>';
    } else {
      echo '<tr><td></td><td bgcolor="#e7e7e7" colspan="5" style="height:2px;"></td></tr>';
      echo '<tr><td>&nbsp;</td>';

    }

    echo '<td>
 <input type="hidden" name="id_schedule[]" id="id_schedule'.$i.'" value="'.$schedule['id_schedule'].'"/>
 <input type="text" name="order_schedule[]" id="order_schedule'.$i.'" value="'.$schedule['order_schedule'].'" size="2" /></td>';

    $db_discipline = mysql_query("SELECT b.discipline_id, b.discipline FROM `".TABLE_SUBJECTS."` AS a LEFT "
    ." JOIN `".TABLE_SPR_DISCIPLINES."` AS b ON b.discipline_id = a.discipline_id "
    ." WHERE class_id = '".$_SESSION['classes']."'"
    ." ORDER BY b.discipline;");
?>

   <td><select name="discipline[]"  id="discipline<?php echo $i;?>"  style="width:160px;"
              onchange="ewd_getcontent('ajaxform-teacher.php?disciplineid='+this.value+'&ID=<?php echo $i;?>', 'teacherdiv<?php echo $i;?>');" >
   <option value=""><?php echo $lang['select'];?></option>

<?php

    while ($discipline = mysql_fetch_array($db_discipline)) {
      if ($schedule['discipline_id'] == $discipline['discipline_id']){
        $seldiscipline = "selected";
      } else { 
        $seldiscipline = "";
      }
   
      echo "<option $seldiscipline value=\"".$discipline['discipline_id']."\">".$discipline['discipline']."</option>\n";
    }

    echo "</select>\n";

    $groups_list = get_group_classes_list($class_id);

    echo '<select name="group[]"  id="group'.$i.'" style="width:160px;">
           <option value="">'.$lang['All_groups'].'</option>\n';

    foreach ($groups_list as $group) {
      $selgroup = ($schedule['group_id'] == $group['group_id']) ? "selected" : '';
      echo "<option $selgroup value=\"".$group['group_id']."\">".$group['group']."</option>\n";
    }

    echo "</select>\n";
    echo '</td>';

    $sql = "SELECT DISTINCT a.*, b.teacher_id, b.first_name, b.middle_name, b.last_name "
          ." FROM `".TABLE_SUBJECTS."` AS a"
          ." LEFT JOIN `".TABLE_USERS_TEACHERS."` AS b ON (b.teacher_id = a.teacher_id) "
          ." WHERE discipline_id = '".$schedule['discipline_id']."'"
          ." GROUP BY b.teacher_id"
          ." ORDER BY b.last_name, b.first_name;";
//echo "$day|$sql<br>\n";

    $db_teacher = mysql_query($sql);
    $coun_db = mysql_num_rows($db_teacher);

    echo '
   <td align="right"><input type="text" name="cabinet[]" id="cabinet'.$i.'" value="'.$schedule['cabinet'].'" size="5" />
       <div id="teacherdiv'.$i.'">
      <select name="teacher[]" id="teacher'.$i.'" style="width:160px;">
      <option value="">'.$lang['select'].'</option>';

  //    <option value="'.$schedule['teacher_id'].'">'.$schedule['last_name'].' '.substr($schedule['first_name'],0,2).'.'.substr($schedule['middle_name'],0,2).'.</option>
    $teacherid ='';
    while ($teacher = mysql_fetch_array($db_teacher)) {

      if ($teacher['teacher_id'] !== $teacherid) {
        $selected = (($coun_db == 1) || ($teacher['teacher_id'] == $schedule['teacher_id']))? "selected='selected'" : ''; 
        echo "<option value='".$teacher['teacher_id']."' $selected>". $teacher['last_name']." ". substr($teacher['first_name'], 0, 2)." ".substr($teacher['middle_name'], 0, 2)."</option>";
        $teacherid = $teacher['teacher_id'];
      }
    }

    echo '
      </select>
   </div></td>
   <td><a href="#" onclick="return nvalid(document.forms[\'fschedule_edit\'], '.$i.'); document.forms[\'fschedule_edit\'].submit()" title="Сохранить"><img src="images/edit.png" border="0"></a>&nbsp;<a 
   href="del_schedule.php?id_schedule='.$schedule['id_schedule'].'" title="Удалить"
      onclick="if (confirm(\'Вы желаете удалить урок?\')) return true; else return false;"
      ><img src="images/del.gif" border="0"></a></td>
   </tr>'; 

    $date_schedule = $schedule['date_schedule'];
    $i++;
  }  //  while ($schedule
 
?>
 </tbody>
 </form>
 <form action='' method='post'>
 <tfoot>

 <input type='hidden' id='0' name="0"></input>
 <input type='hidden' id='1' name="1"></input>
 <input type='hidden' id='2' name="2"></input>
 <input type='hidden' id='3' name="3"></input>
 <input type='hidden' id='4' name="4"></input>
 <input type='hidden' id='5' name="5"></input>
 <input type='hidden' id='6' name="6"></input>
  <input type='hidden'  name="act" value='del'></input>
 <tr><td>
 <input type='submit' value='<?php echo $lang['delete'];?>'
    onclick="if (confirm('Вы желаете удалить учебные дни?')) return true; else return false;"
    ></input>
 </td></tr>
 </tfoot>
 </form>
 </table>
 
<?php

}  //  if($_SESSION['schoolyear']

?>   

</div> 
<br/> 
<?php
include 'footer.php';

  /*
  <!--
  <script language='javascript'> 
  ewd_getcontent('ajaxform-teacher.php?disciplineid=<?php echo $schedule['discipline_id'];?>&teacher=<?php echo $schedule['teacher_id'];?>', 'teacherdiv<?php echo $i;?>');
  //</script>
  -->
  */
?>
