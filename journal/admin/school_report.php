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
include 'header.php';

  $school_year_id = empty($_REQUEST['schoolyear']) ? $_SESSION['schoolyear'] : $_REQUEST['schoolyear'];

  $class_id=$_REQUEST['id_class'];
  $quater_id=$_REQUEST['id_quater'];

?>
<table border='0' width=100%><tr align='center'><td>
<script type="text/javascript" src="../js/wz_tooltip.js"></script>
<br />

<span class="head_top"><?php echo $lang['class_list'];?></span>
<tr><td align='center'>
    <form method="get" action='school_report.php'>

<?php
$school_years = get_school_years();

?>

<?php echo $lang['class_list'];?>
<select name="school_year" onChange="javascript: this.form.id_class.value=0; this.form.id_quater.value=0; this.form.submit();">

<?php 

//if (!isset($_REQUEST['school_year'])) 
  echo "<option value=''>{$lang['select']}</option>";

foreach ($school_years as $years) {

    if ($years['school_year_id']==$_REQUEST['school_year']){
      $selected="selected"; 
      $school_year_id = $years['school_year_id'];
      $_SESSION['schoolyear'] = $years['school_year_id'];
    } elseif (empty($_REQUEST['school_year'])) {
      if (empty($years['current'])) 
        $selected="";
      else {
        $selected="selected"; 
        $school_year_id = $years['school_year_id'];
        $_SESSION['schoolyear'] = $years['school_year_id'];
      }
    }
    else 
      $selected="";
?>

<option value="<?php echo  $years['school_year_id'];?>" <?php echo $selected;?>><?php echo $years['name_year'];?></option>

<?php 

} 

?>
</select>

    <select name='id_class' onChange="javascript: this.form.submit();">
     <option value=''><?php print $lang['select']; ?></option>

    <?php

    $q=db_query("SELECT * FROM `".TABLE_CLASSES."` WHERE school_year='".$school_year_id."' ORDER BY class;");
    $list_class=array();
    while($row = mysql_fetch_assoc($q)){
        $list_class[] = $row;
    }
    foreach($list_class as $class){
      if(($class['class_id']) == $class_id)
        print "<option value='".$class['class_id']."' selected='selected'>".$class['class'].$class['letter']."</option>";
      else
        print "<option value='".$class['class_id']."'>".$class['class'].$class['letter']."</option>";
    }

    ?>
    </select>

    <select name='id_quater' onChange="javascript: this.form.submit();">
     <option value=''><?php print $lang['select']; ?></option>
    <?php
    $q=db_query("SELECT * FROM `".TABLE_SCHOOL_QUARTERS."` WHERE school_year_id='".$school_year_id."'");
    $list_quater=array();
    while($row = mysql_fetch_assoc($q)){
        $list_quater[] = $row;
    }
    foreach($list_quater as $quater){
      if (empty($quater_id)) {
        if($quater['current'] != 0)
          print "<option value='".$quater['quarter_id']."' selected='selected'>".$quater['quarter_name']."</option>";
        else
          print "<option value='".$quater['quarter_id']."'>".$quater['quarter_name']."</option>";
      } elseif($quater['quarter_id']==$quater_id){
        print "<option value='".$quater['quarter_id']."' selected='selected'>".$quater['quarter_name']."</option>";
      } else {
        print "<option value='".$quater['quarter_id']."'>".$quater['quarter_name']."</option>";
      }
    }
    ?>
    </select>
   </form>

</td></tr>
</table>
<div align="center">
<table  id="rounded-corner" align="center">
  <thead>
  <tr class="TableHead">
    <th class="rounded-left">№</th>
    <th><?php echo $lang['name'];?></th>
    <th align='center'><?php echo $lang['aver_bal'];?></th>
    <th><?php echo $lang['dvoiki'];?></th>
    <th>%<?php echo $lang['obuch'];?></th>
    <th><?php echo $lang['quality'];?></th>
   <th class="rounded-right" colspan="3">&nbsp;</th>
  </tr>
  </thead>
  <tbody>


<?php


if(isset($_REQUEST['id_class'])){
  $n=1;

 // $q = mysql_query("SELECT * FROM `".TABLE_CLASSES."` WHERE class='".$c[0]."' AND letter='".$c[1].$c[2]."'");

//$subject_id = 1;


  //$subject = db_get_first_row("SELECT * FROM `".TABLE_SUBJECTS."` WHERE subject_id='".$subject_id."'");
  //$students_list = get_student_classes_list2($subject['class_id']);

//echo "select * FROM `".TABLE_STUDENTS_IN_CLASS."` as s JOIN `".TABLE_USERS_STUDENTS."` on students.student_id=s.student_id where   class_id='{$class_id}'";
  $studen=mysql_query("select * FROM `".TABLE_STUDENTS_IN_CLASS."` as s "
    ." JOIN `".TABLE_USERS_STUDENTS."` on students.student_id=s.student_id"
    ." where class_id='".$class_id."'");
  while ($row=mysql_fetch_assoc($studen)) {
    $students_list[]=$row;
  }

  $grades = db_query("SELECT * FROM `".TABLE_STUDENTS_ON_LESSON."` WHERE quater='".$quater_id."'");
  $list_grades = array();
  while($row = mysql_fetch_assoc($grades)){
    $list_grades[] = $row;
  }
  $col_five=0; $col_good=0;
  foreach($list_grades as $g){
    if(($g['grade']=='4')or($g['grade']=='5')){
      $col_five++;
    }
    if($g['grade']!=2){
      $col_good++;
    }
  }

  if(count($list_grades)!=0){
    $obuch=$col_good/count($list_grades)*100;
    $quality=$col_five/count($list_grades)*100;
  }else{
    $obuch=0;
    $quality=0;
  }


  if (!empty($students_list))
  foreach($students_list as $student) {



    if ($student['student_photo']!=='')
    {
            $student_photo ="<img src=\'../student_photo/".SUBDOMEN."/sm/$student[student_photo]\'>";
    }
    else
    {
            $student_photo ="<img src=\'./images/nophoto.gif \'>";
    }
    echo "<tr align='center'><td>$n</td><td nowrap=\"nowrap\" align='left'><div style='cursor:pointer;' onmouseover=\"Tip('$student_photo <br>ПИН код: {$student['pin_code']}<br> Адресс: {$student['address']} <br>Телефон: {$student['phone']}')\" onmouseout=\"UnTip()\">{$student['last_name']}  {$student['first_name']}</div></td>";
    $grades = db_query("SELECT * FROM `".TABLE_STUDENTS_ON_LESSON."` WHERE student_id='".$student['student_id']."' AND quater='".$quater_id."'");
    $list_grades = array();
    while($row = mysql_fetch_assoc($grades)){
      $list_grades[] = $row;
    }
    //считаем средний балл
    $sred_grade=0;$col_five=0;
    $col_d=0;$col_good=0;
    foreach($list_grades as $g){
      $sred_grade+=$g['grade'];
      if($g['grade']=='2'){
        $col_d++;
      }else{
        $col_good++;
      }
      if(($g['grade']=='4')or($g['grade']=='5')){
        $col_five++;
      }
    }
    if(count($list_grades)!=0){
      print "<td>".round($sred_grade/count($list_grades),2)."</td><td>".$col_d."</td>";
    }else{
      print "<td>0</td><td>0</td>"; 
    }
    if($n==1){
      print "<td rowspan='".count($students_list)."'>".round($obuch,2)."%</td>
      <td colspan='6' align='left' rowspan='".count($students_list)."'>".round($quality,2)."%</td>";
    }
    echo '</tr>';
    $n++;
  }
}

?>
  </tbody>

  <tfoot>
    <tr>
      <td colspan="2" class="rounded-foot-left">&nbsp;</td>
      <td colspan="8" class="rounded-foot-right">&nbsp;</td>
    </tr>
   </tfoot>
</table>
<br />

</td>
<?php


  echo " </table> <table border=0 width='100%'>
<tr aling='center'> <td colspan='2'>";
  
  include 'footer.php';
?>
</body>
</html>
