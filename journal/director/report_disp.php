<?php
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
include_once ('../include/information.php');



db_query("UPDATE `".TABLE_LESSONS."` SET active = 0 WHERE active<".time());


include 'header.php';
if(isset($_REQUEST['id_quater'])){
$quater_id=$_REQUEST['id_quater'];
}else{
$quater_id=1;
}


    $q=db_query("SELECT * FROM `".TABLE_SCHOOL_QUARTERS."` WHERE quarter_id='".$quater_id."'");
    $list_quater=mysql_fetch_assoc($q);
    $tek_quarter=$list_quater['quarter_name'];
?>
<script type="text/javascript" src="../js/wz_tooltip.js"></script>
<br />
<div>

    <center>
<table width="40%" border="0" ><tr><td width="20%" valign="top">
<form action="lessons.php?" method="post">
<input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
<input type="hidden" name="action" value="update" />
<br>
<?php 

$query="select class ,letter FROM `".TABLE_CLASSES."` where class_id='".$_GET['class']."'";
$res=mysql_query($query);
$row=mysql_fetch_assoc($res);
$class_name=$row['class']."-".$row['letter'];

$query="select discipline FROM `".TABLE_SPR_DISCIPLINES."` where discipline_id='".$_GET['disp_id']."'";
$res=mysql_query($query);
$row=mysql_fetch_assoc($res);
$displ=$row['discipline'];
?>
<center>Ведомость успеваемости по <b><?php echo $class_name;?></b> классу. Предмет <b><?php echo $displ;?> </b>
<br>
<a href="javascript: history.go(-1)">Вернуться назад</a>
</center>

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

  
  
 
  $query="SELECT s.student_id, s.last_name, s.first_name,s.middle_name, s.photo, s.address, s.phone, sol.grade "
        ." FROM `".TABLE_STUDENTS_ON_LESSON."` as sol"
        ." left JOIN `".TABLE_STUDENTS_IN_CLASS."` as sic on sic.student_id=sol.student_id"
        ." left JOIN `".TABLE_CLASSES."` as cl on cl.class_id=sic.class_id"
        ." left JOIN `".TABLE_USERS_STUDENTS."` as s on s.student_id=sol.student_id"
        ." left JOIN `".TABLE_LESSONS."` as l on l.lesson_id=sol.lesson_id"
        ." left JOIN `".TABLE_SUBJECTS."` as su on su.subject_id=l.subject_id"
        ." left JOIN `".TABLE_SPR_DISCIPLINES."` as d on d.discipline_id=su.discipline_id"
        ." WHERE cl.class_id='".$_REQUEST['class']."' and d.discipline_id='".$_REQUEST['disp_id']."' ORDER BY s.last_name asc";

  $res=mysql_query($query);
   $nums=mysql_num_rows($res);
  $stud_grades=array();
  $stud_names=array();
   
  if($nums>0) {
  $n=1;
  while($row=mysql_fetch_assoc($res)) {
  
  	$stud_grades[$row['student_id']][]=$row['grade'];
  	$stud_names[$row['student_id']]['name']=$row['last_name']." ".$row['first_name'];
  	$stud_names[$row['student_id']]['photo']=$row['photo'];
  	$stud_names[$row['student_id']]['address']=$row['address'];
 
  	
  }
   
 
  $good_cnt=0;
   foreach($stud_names as $key => $student) {
   	foreach ($stud_grades[$key] as $grade) {
   	if ($grade=="12" or $grade=="11" or $grade=="10" or $grade=="9" or $grade=="8") { $good_cnt++; } 
   	if ($grade=="12" or $grade=="11" or $grade=="10") { $very_good_cnt++; } 
   	} }
   	
   $good_procent=$good_cnt/(count($stud_names));
   $good_procent=round($good_procent,2);
   $good_procent=$good_procent*100;
   
   $very_good_procent=$very_good_cnt/(count($stud_names));
   $very_good_procent=round($very_good_procent,2);
   $very_good_procent=$very_good_procent*100;
   
 $cnt_2=0; $cnt_1=0; $cnt_3=0;
$cnt_4=0;$cnt_5=0;$cnt_6=0;$cnt_7=0;$cnt_8=0;$cnt_9=0;$cnt_10=0; $cnt_11=0;$cnt_12=0; $total=0;
 foreach($stud_names as $key => $student) {

  	
  if ($student['photo']!=='')
  {
  	$student_photo ="<img src=\'../student_photo/".SUBDOMEN."/sm/{$student['photo']}\'>";
  }
  else
  {
  	$student_photo ="<img src=\'/images/nophoto.gif \'>";
  }
  $aver=0;
  echo "<tr align='center'><td>$n</td><td nowrap=\"nowrap\" align='left'><div style='cursor:pointer;' onmouseover=\"Tip('$student_photo <br>ПИН код: {$student['pcode']}<br> Адресс: {$student['address']} <br>Телефон: {$student['phone']}')\" onmouseout=\"UnTip()\">{$stud_names[$key]['name']}</div></td>";

  foreach ($stud_grades[$key] as $grade) {
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
 	
 	$aver+=$grade;
 }
  $list_grades = array();
 

  $aver=$aver/count($stud_grades[$key]);
  $aver=round($aver,2);
  
  print "<td>$total<td>$cnt_1<td>$cnt_2<td>$cnt_3<td>$cnt_4<td>$cnt_5<td>$cnt_6<td>$cnt_7<td>$cnt_8<td>$cnt_9<td>$cnt_10<td>$cnt_11<td>$cnt_12<td>$aver";
  
     
 $cnt_2=0; $cnt_1=0; $cnt_3=0;
$cnt_4=0;$cnt_5=0;$cnt_6=0;$cnt_7=0;$cnt_8=0;$cnt_9=0;$cnt_10=0; $cnt_11=0;$cnt_12=0; $total=0; 
 
  if($n==1){
  	
  print "<td rowspan='".count($stud_names)."'>".$good_procent."%</td>
  <td colspan='4' align='left' rowspan='".count($stud_names)."' >".$very_good_procent."%</td>";
  }
  echo '</tr>';
  $n++;
  }
  } else print "<tr><td colspan=7 align='center'><font color='red' size='4px'>Нет данных</font></td>";
?>
  </tbody>

</table>

<br />
</form>

</td>
<div align="center">

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