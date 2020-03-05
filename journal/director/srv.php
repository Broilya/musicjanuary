<?php
session_start();
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('DIRECTOR_ZONE', true);
include_once ('../init.php');
include_once ('../include/classes.php');

if (!isset($_SESSION['schoolyear'])) {$_SESSION['schoolyear']='';}
if (!isset($_SESSION['classes'])) {$_SESSION['classes']='';}
if (!isset($_SESSION['discipline'])) {$_SESSION['discipline']='';}
if (!isset($_SESSION['teacher'])) {$_SESSION['teacher']='';}

if(isset($_POST['data'])) {
  $_SESSION['schoolyear'] = $_POST['schoolyear'];
  $_SESSION['classes'] = $_POST['classes'];
  $_SESSION['discipline'] = $_POST['discipline'];
  $_SESSION['teacher'] = $_POST['teacher'];
  
  session_register('schoolyear');
  session_register('classes');
  session_register('discipline');
  session_register('teacher');

  exit(header ('Location: srv.php'));
}

include 'header.php';

?>
<script type="text/javascript" src="../js/wz_tooltip.js"></script>
<div align="center"> 
<br />
<form action="srv.php"  method="post" id="ftheme">
<input name="data" type="hidden" value="load"/>
 <table width="70%" border="0" cellpadding="2" cellspacing="2" bgcolor="#e7e7e7">
 <tr>
 <td width="15%" height="45px"><b>Учебный год:</b><br/>
  <select name="schoolyear" onchange="ewd_getcontent('ajaxform-classes.php?schoolyear='+this.value, 'classesdiv');">
  <option value="">Выберете</option>
  <?php

   $db_classes = mysql_query("SELECT distinct school_year FROM `".TABLE_CLASSES."` ORDER BY school_year DESC");
   //print "<option>fuck</option>";
   while ($classes2 = mysql_fetch_array($db_classes)) {
    print "<option value='".$classes2['school_year']."'>".$classes2['school_year']."</option>";
    $school_year = $classes2['school_year'];
    }

   ?>
 </select>
  </td>
  <td width="15%"><b>Класс:</b><br/>
  <div id="classesdiv">
  <select name="classes">
  <option value="">Выберете</option>
  <?php if($_SESSION['schoolyear']!='') {
    print "SESSION";
    //echo "SELECT class_id, class, letter FROM `".TABLE_CLASSES."` WHERE school_year = '".$_SESSION['schoolyear']."'";
   $db_classes = mysql_query("SELECT class_id, class, letter FROM `".TABLE_CLASSES."` WHERE school_year = '".$_SESSION['schoolyear']."'");
   while ($classes1 = mysql_fetch_array($db_classes)) {

   if ($_SESSION['classes'] == $classes1['class_id']){
 	 $selclass = "selected";
   } else { $selclass = "";}

    echo "<option $selclass value=\"".$classes1['class_id']."\">".$classes1['class']." ".$classes1['letter']."</option>";
   }
  }else{

  }
  ?>
 
 </div>
  </td>
  <td width="10%"><br/>
  <input type="submit" value="Вывести данные" />
  </td>
 </tr>
 </table>
 </form>
 <br />
  <center>
  <center>Ведомость успеваемости по классам. 
<table width="40%" border="0" ><tr><td width="20%" valign="top">
<form action="lessons.php?" method="post">
<input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
<input type="hidden" name="action" value="update" />
<br>
<table  id="rounded-corner" width="40%" align="center" border='0'>
  <thead>
  <tr class="TableHead">
    <th class="rounded-left">№</th>
    <th>Имя</th>
    <th>Всего</th>
    <th>на 1</th>
    <th>на 2</th>
    <th>на 3</th>
    <th>на 4</th>
    <th>на 5</th>
    <th>на 6</th>
    <th>на 7</th>
    <th>на 8</th>
    <th>на 9</th>
    <th>на 10</th>
    <th>на 11</th>
    <th>на 12</th>
    <th>Средний балл</th>
    <th width="2">%обученности</th>
    <th width="2">Качество</th>
   <th class="rounded-right" colspan="3">&nbsp;</th>
  </tr>
  </thead>
  <tbody>
<?php

  // определяем какой клас ведет учитель

  
 if ($_REQUEST['disp_id']!="") { $dis_query=" and  d.discipline_id={$_REQUEST['disp_id']} "; } 
 
  $query="SELECT discipline, d.discipline_id, s.student_id, s.last_name, s.first_name,	s.middle_name, s.photo, s.address, s.phone, sol.grade "
        ." FROM `".TABLE_STUDENTS_ON_LESSON."` as sol"
        ." left JOIN `".TABLE_STUDENTS_IN_CLASS."` as sic on sic.student_id=sol.student_id"
        ." left JOIN `".TABLE_CLASSES."` as cl on cl.class_id=sic.class_id"
        ." left JOIN `".TABLE_USERS_STUDENTS."` as s on s.student_id=sol.student_id"
        ." left JOIN `".TABLE_LESSONS."` as l on l.lesson_id=sol.lesson_id"
        ." left JOIN `".TABLE_SUBJECTS."` as su on su.subject_id=l.subject_id"
        ." left JOIN `".TABLE_SPR_DISCIPLINES."` as d on d.discipline_id=su.discipline_id"
        ." WHERE cl.class_id='".$_SESSION['classes']."' ORDER BY s.last_name asc";
 
  $res=mysql_query($query);
   $nums=mysql_num_rows($res);
  $stud_grades=array();
  $stud_names=array();
   
  if($nums>0) {
  $n=1;
  while($row=mysql_fetch_assoc($res)) {
  
  	$stud_grades[$row['discipline_id']]['name']=$row['discipline'];
  $stud_grades[$row['discipline_id']]['grade'][]=$row['grade'];
  	$stud_names[$row['student_id']]=1;
  
 
  	
  }


 
   
 $cnt_2=0; $cnt_1=0; $cnt_3=0;
$cnt_4=0;$cnt_5=0;$cnt_6=0;$cnt_7=0;$cnt_8=0;$cnt_9=0;$cnt_10=0; $cnt_11=0;$cnt_12=0; $total=0;
 foreach($stud_grades as $key => $student) {


  $aver=0;
  echo "<tr align='center'><td>$n</td><td nowrap=\"nowrap\" align='left'><a href='report_disp.php?disp_id={$key}&class={$_SESSION['classes']}'>{$student['name']
  }</a></td>";

  foreach ($stud_grades[$key]['grade'] as $grade) {
 	$total++;
 	
  if ($grade=="1") { $cnt_1++;}
  if ($grade=="2") { $cnt_2++;}
  if ($grade=="3") { $cnt_3++;}
  if ($grade=="4") { $cnt_4++;}
  if ($grade=="5") { $cnt_5++;}
  if ($grade=="6") { $cnt_6++;}
  if ($grade=="7") { $cnt_7++;}
  if ($grade=="8") { $cnt_8++;}
  if ($grade=="9") { $cnt_9++;}
  if ($grade=="10") { $cnt_10++;}
  if ($grade=="11") { $cnt_11++;}
  if ($grade=="12") { $cnt_12++;}
 $good_cnt=0; $very_good_cnt=0;	
 if ($grade=="12" or $grade=="11" or $grade=="10" or $grade=="9" or $grade=="8") { $good_cnt++; } 
   	if ($grade=="12" or $grade=="11" or $grade=="10") { $very_good_cnt++; } 
   	
   	$good_procent=$good_cnt/(count($stud_names));
   $good_procent=round($good_procent,2);
   $good_procent=$good_procent*100;
   
   $very_good_procent=$very_good_cnt/(count($stud_names));
   $very_good_procent=round($very_good_procent,2);
   $very_good_procent=$very_good_procent*100;
   
   
 	$aver+=$grade;
 }
  $list_grades = array();
 

  $aver=$aver/count($stud_grades[$key]['grade']);
  $aver=round($aver,2);
  
  print "<td>$total<td>$cnt_1<td>$cnt_2<td>$cnt_3<td>$cnt_4<td>$cnt_5<td>$cnt_6<td>$cnt_7<td>$cnt_8<td>$cnt_9<td>$cnt_10<td>$cnt_11<td>$cnt_12<td>$aver";
  
  
  $two_cnt=0;  
  $cnt_2=0; $cnt_1=0; $cnt_3=0;
$cnt_4=0;$cnt_5=0;$cnt_6=0;$cnt_7=0;$cnt_8=0;$cnt_9=0;$cnt_10=0; $cnt_11=0;$cnt_12=0; $total=0; 
 
  	
  print "<td>".$good_procent."%</td>
  <td colspan='4' align='left'  >".$very_good_procent."%</td>";
  
  echo '</tr>';
  $n++;
  }
  } else print "<tr><td colspan=16 align='center'><font color='red' size='4px'>Нет данных</font></td>";
?>
  </tbody>

</table>

<br />
</form>

</td>
</div>

</tr>
<tr>
<td colspan='2' align="center"><br><br>
<table border="0" cellspacing="0" cellpadding="0" class="table_menu">
  <tr>
    <td><img src="../images/circle_left_top.gif" alt="" width="6" height="6"></td>
    <td valign="top" class="border_top"><img src="../images/border.gif" alt="" width="1" height="1"></td>
    <td><img src="../images/circle_right_top.gif" alt="" width="6" height="6"></td>
  </tr>
  <tr>
    <td class="border_left">&nbsp;</td>
    <td class="padding" align="center"> <br /><nowrap>
      <nowrap>&copy Роман Зенкин и Евгений Чернышов</nowrap>
    </nowrap>
    <br /><br /></td>
    <td class="border_right">&nbsp;</td>
  </tr>
  <tr>
    <td><img src="../images/circle_left_bottom.gif" alt="" width="6" height="6"></td>
    <td width="99%" valign="bottom" class="border_bottom"><img src="../images/border.gif" alt="" width="1" height="1"></td>
    <td><img src="../images/circle_right_bottom.gif" alt="" width="6" height="6"></td>
  </tr>
</table>
</td>
</tr></table>
</div>
</body>
</html>