<?php
define('TEACHER_ZONE', true);
include_once ('../init.php');
include_once ('../include/classes.php');
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/
$q=mysql_query("SELECT class_id FROM `".TABLE_CLASSES."` WHERE `teacher_id`=".$teacher_id."");


$subject_id = 2;
$class_id=mysql_result($q,0,0);


db_query("UPDATE `".TABLE_LESSONS."` SET active = 0 WHERE active<".time());

if(isset($_POST['action'])) {
  $action = $_POST['action'];
  if ($action == 'update') {
  	$grades = $_POST['grades'];
  	$behavior = $_POST['behavior'];
  	foreach ($grades as $lesson_id => $lesson) {
     foreach ($lesson as $student_id => $grade) {

      	db_query($sql = "DELETE FROM `".TABLE_STUDENTS_ON_LESSON."` WHERE lesson_id='".$lesson_id."' AND student_id='".$student_id."'");

      	if ($grade != '') {
      	  $q=mysql_query("SELECT * FROM `".TABLE_LESSONS."` WHERE lesson_id='".$lesson_id."'");
          $qu=mysql_query("SELECT * FROM `".TABLE_SCHOOL_QUARTERS."` WHERE `started` <= '".mysql_result($q,0,1)."' AND `finished` >= '".mysql_result($q,0,1)."'");
        	db_query($sql ="INSERT INTO `".TABLE_STUDENTS_ON_LESSON."` (student_id, lesson_id, grade, behavior, quater, subj_id) VALUES"
        	."('".$student_id."', '".$lesson_id."', '".substr($grade, 0, 2)."','".$behavior[$lesson_id][$student_id]."','".mysql_result($qu,0,0)."','".$subject_id."')");
      	}
      }
  	}
  	print "<script>location.replace('lessons.php?subject_id='.$subject_id.');</script>";
  } elseif ($action == 'close') {
  	  $grades = $_POST['grades'];
 	  $behavior = $_POST['behavior'];
 	  foreach ($grades as $lesson_id => $lesson) {
 	  	foreach ($lesson as $student_id => $grade) {

		  db_query($sql = "DELETE FROM `".TABLE_STUDENTS_ON_LESSON."` WHERE lesson_id='".$lesson_id."' AND student_id='".$student_id."'");

      if ($grade != '') {
          $q=mysql_query("SELECT * FROM `".TABLE_LESSONS."` WHERE lesson_id='".$lesson_id."'");
          $qu=mysql_query("SELECT * FROM `".TABLE_SCHOOL_QUARTERS."` WHERE `started` < '".mysql_result($q,0,1)."' AND `finished` > '".mysql_result($q,0,1)."'");

        db_query("INSERT INTO `".TABLE_STUDENTS_ON_LESSON."` (student_id, lesson_id, grade, behavior, quater) VALUES"
           ."('".$student_id."', '".$lesson_id."', '".substr($grade, 0, 2)."','".$behavior[$lesson_id][$student_id]."','".mysql_result($qu,0,0)."')");
      	}
      }
  	}
  	db_query("UPDATE `".TABLE_LESSONS."` SET active=0 WHERE lesson_id='".$lesson_id."'");
  	header ('Location: lessons.php?subject_id='.$subject_id);
    exit();
  }
}

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
<div id="rc"><!-- ПРАВАЯ КОЛОНКА!!! -->
	  <span class="right_col">


	  </span></div>
	<div id="lc"><!-- ЛЕВАЯ КОЛОНКА!!! -->
	  <span class="right_left">
      <div class="body_d">
<form action="lessons.php?" method="post">
<input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
<input type="hidden" name="action" value="update" />
<table  width="100%" align="center" >
  <thead>
  <tr class="TableHead">
    <th >№</th>
    <th><?php echo $lang['name'];?></th>
    <th><?php echo $lang['login'];?></th>
    <th><?php echo $lang['pass'];?></th>
    <th><?php echo $lang['table_action'];?></th>
   
  </tr>
  </thead>
  <tbody>
<?php
  $active_leson = false;
  // определяем какой клас ведет учитель
 // $teacher_class = db_get_first_row("SELECT class_id FROM `".TABLE_CLASSES."` WHERE teacher_id='".$_SESSION['teacher_id']."'");

 // $subject_id = 1;


 // $subject = db_get_first_row("SELECT * FROM `".TABLE_SUBJECTS."` WHERE subject_id='".$subject_id."'");
 // $students_list = get_student_classes_list($subject['class_id']);
  $n=1;

 $query= "SELECT * FROM `".TABLE_CLASSES."` as c "
        ." JOIN `".TABLE_STUDENTS_IN_CLASS."` as sc on sc.class_id=c.class_id"
        ." JOIN `".TABLE_USERS_STUDENTS."` as s on sc.student_id=s.student_id"
        ." where c.teacher_id='".$_SESSION['teacher_id']."'";
 $res=mysql_query($query);

 //$students=mysql_fetch_assoc($res);
  while ($row=mysql_fetch_assoc($res)) {

  if ($row['student_photo']!=='')
  {
  	$student_photo ="<img src=\'../student_photo/".SUBDOMEN."/sm/$student[student_photo]\'>";
  }
  else
  {
  	$student_photo ="";
  }
  echo "<tr align='center'><td>$n</td><td nowrap=\"nowrap\" align='left'><div style='cursor:pointer;' 
  onmouseover=\"Tip('$student_photo <br>{$lang['pin']}: {$row['pin_code']}<br> {$lang['student_adress']}: {$roe['address']} <br>{$lang['student_teless']}: {$row['phone']}')\" onmouseout=\"UnTip()\">{$row['first_name']} {$row['last_name']}</div></td>";
  print "<td align='left'>".$row['login']."</td><td align='left'>".$row['password']."</td><td><a href='pass_chg.php?st={$row['student_id']}&TB_iframe=true&height=130&width=250' class='thickbox'>{$lang['password_chenge']}</a><td>&nbsp;&nbsp;</td>";
  echo '</tr>';
  $n++;
  }

?>
  </tbody>
  

</table>
<br />
</form>

<?include 'footer.php';