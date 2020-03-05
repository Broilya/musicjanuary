<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('TEACHER_ZONE', true);
include_once ('../init.php');
include_once ('../include/classes.php');

$subject_id = intval($_REQUEST['subject_id']);
$class_id = $_REQUEST['class_id'];


//db_query('UPDATE `".TABLE_LESSONS."` SET active = 0 WHERE active<'.time());


if(isset($_GET['act'])) {
	if ($_GET['act']=="edit_grades" and $_GET['sub_act']=='zero') {
		
	 $q=mysql_query('UPDATE `".TABLE_LESSONS."` SET active=1 WHERE lesson_id='.$_GET['less'] );	
	// unset ($_GET);
	 
	} 
	
	
}

if ($_POST['delete_this']=='yes') {
	
	$temp=array_shift($_POST);
	
	foreach ($_POST as $key=> $id) 
	{
	$id=substr($key, 2);
	
	//echo $id;	
	$query = "DELETE FROM `".TABLE_LESSONS."` WHERE lesson_id='".$id."'";
	//echo $query;
	
  	$res=mysql_query($query);
  	
  	$query="DELETE FROM `".TABLE_STUDENTS_ON_LESSON."` where lesson_id='".$id."'";
  	$res=mysql_query($query);
    }
	
	
	
}




if(isset($_POST['act'])) {
  $act = $_POST['act'];
  if ($act == 'update') {
  	$grades = $_POST['grades'];
  	$behavior = $_POST['behavior'];
  	foreach ($grades as $lesson_id => $lesson) {
     foreach ($lesson as $student_id => $grade) {
    	
      	db_query($sql = 'DELETE FROM `".TABLE_STUDENTS_ON_LESSON."` WHERE lesson_id='.$lesson_id.' AND student_id='.$student_id);

      	if ($grade != '') {
      	  $q=mysql_query("SELECT * FROM `".TABLE_LESSONS."` WHERE lesson_id=".$lesson_id."");
      	 // echo "SELECT * FROM `".TABLE_LESSONS."` WHERE lesson_id=".$lesson_id."";
      	 if (mysql_result($q,0,5)!=10000) {
      	 	
          $qu=mysql_query("SELECT * FROM `".TABLE_SCHOOL_QUARTERS."` WHERE `started` <= '".mysql_result($q,0,1)."' AND `finished` >= '".mysql_result($q,0,1)."'");
        	if (mysql_num_rows($qu)!=0) {
        		
          db_query($sql ='INSERT INTO `".TABLE_STUDENTS_ON_LESSON."` (student_id, lesson_id, grade, behavior, quater, subj_id) VALUES('.$student_id.', '.$lesson_id.', "'.$grade.'",'.$behavior[$lesson_id][$student_id].','.mysql_result($qu,0,0).','.$subject_id.')');
      	 }  } else {
      	 	
        	db_query($sql ='INSERT INTO `".TABLE_STUDENTS_ON_LESSON."` (student_id, lesson_id, grade, behavior, quater, subj_id) VALUES('.$student_id.', '.$lesson_id.', "'.$grade.'",'.$behavior[$lesson_id][$student_id].',"10000",'.$subject_id.')');
    
      	 }
      	 
      	 }
      }
  	}
  	 exit(header ("Location: lessons.php?subject_id=".$subject_id));
  	echo "<script>location.replace('lessons.php?subject_id='.$subject_id.');</script>";
  	print "<script>location.replace('lessons.php?subject_id='.$subject_id.');</script>";
  } elseif ($act == 'close') {
  	  $grades1 = $_POST['grades'];
  	  
 	  $behavior1 = $_POST['behavior'];
 	  foreach ($grades1 as $lesson_id => $lesson) {
 	  	foreach ($lesson as $student_id => $grade) {

		  db_query($sql = 'DELETE FROM `".TABLE_STUDENTS_ON_LESSON."` WHERE lesson_id='.$lesson_id.' AND student_id='.$student_id);

      if ($grade != '') {
          $q=mysql_query("SELECT * FROM `".TABLE_LESSONS."` WHERE lesson_id=".$lesson_id."");
          $qu=mysql_query("SELECT * FROM `".TABLE_SCHOOL_QUARTERS."` WHERE `started` < '".mysql_result($q,0,1)."' AND `finished` > '".mysql_result($q,0,1)."'");
    
          
          if (mysql_result($q,0,5)!=10000) {
          $qu=mysql_query("SELECT * FROM `".TABLE_SCHOOL_QUARTERS."` WHERE `started` <= '".mysql_result($q,0,1)."' AND `finished` >= '".mysql_result($q,0,1)."'");
          if (mysql_num_rows($qu)!=0) {
          	//echo 'INSERT INTO `".TABLE_STUDENTS_ON_LESSON."` (student_id, lesson_id, grade, behavior, quater, subj_id) VALUES('.$student_id.', '.$lesson_id.', "'.substr($grade, 0, 2).'",'.$behavior1[$lesson_id][$student_id].','.mysql_result($qu,0,0).','.$subject_id.')';
          	db_query($sql ='INSERT INTO `".TABLE_STUDENTS_ON_LESSON."` (student_id, lesson_id, grade, behavior, quater, subj_id) VALUES('.$student_id.', '.$lesson_id.', "'.substr($grade, 0, 2).'",'.$behavior1[$lesson_id][$student_id].','.mysql_result($qu,0,0).','.$subject_id.')');

          } } else {
      	 	 //  echo 'INSERT INTO `".TABLE_STUDENTS_ON_LESSON."` (student_id, lesson_id, grade, behavior, quater, subj_id) VALUES('.$student_id.', '.$lesson_id.', "'.substr($grade, 0, 2).'",'.$behavior1[$lesson_id][$student_id].',10000,'.$subject_id.')';
      	 	
        	db_query($sql ='INSERT INTO `".TABLE_STUDENTS_ON_LESSON."` (student_id, lesson_id, grade, behavior, quater, subj_id) VALUES('.$student_id.', '.$lesson_id.', "'.substr($grade, 0, 2).'",'.$behavior1[$lesson_id][$student_id].',"10000",'.$subject_id.')');
//  echo 'INSERT INTO `".TABLE_STUDENTS_ON_LESSON."` (student_id, lesson_id, grade, behavior, quater, subj_id) VALUES('.$student_id.', '.$lesson_id.', "'.substr($grade, 0, 2).'","'.$behavior[$lesson_id][$student_id].'",10000,'.$subject_id.')';

          }	}
      }
  	}
  	$active_leson = false;
  	db_query('UPDATE `".TABLE_LESSONS."` SET active=0 WHERE lesson_id='.$lesson_id);
  	 exit(header ('Location: lessons.php?subject_id='.$subject_id));
    exit();
  }
}

include 'header.php';
?>
<script type="text/javascript" src="../js/wz_tooltip.js"></script>
<br />
<div>
<center>
<a href="new_lesson.php?subject_id=<?php echo $subject_id ?>&TB_iframe=true&height=330&width=400&<?php echo uniqid('r'); ?>" title="Создать новый урок" class="thickbox">Новый урок</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="new_lesson_exam.php?subject_id=<?php echo $subject_id ?>&TB_iframe=true&height=330&width=400&<?php echo uniqid('r'); ?>" title="Оценки по экзамену" class="thickbox">Добавить экзамен</a></td>


<span class="head_top"><form metod='POST' act="lessons.php?subject_id=<?php echo $subject_id; ?>"><?php echo $lang['show_last'];?> <select name="col" onChange="javascript: this.form.submit();"><?php  if($_REQUEST['col']=='') { $cols=7; $selected_cols=7; } else {$selected_cols=$_REQUEST['col'];}?><option <?php if($selected_cols==7) echo "selected"; ?> value='7'>7</option><option <?php if($selected_cols==14) echo "selected"; ?> value='14'>14</option><option <?php if($selected_cols==24) echo "selected"; ?> value='24'>24</option></select> записей <input type='hidden' name='subject_id' value='<?php print $subject_id; ?>' /></form><br>
<table width="100%" border="0" ><tr><td width="100%" align="center">
<form act="lessons.php?" method="post">
<input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
<input type="hidden" name="act" value="update" />
<table  id="rounded-corner" width="100%" align="center">

  <thead>
  <tr class="TableHead">
    <th class="rounded-left">№</th>
    <th><?php $lang['name'];?></th>
<?php
$active_leson = true;
  $res = db_query('SELECT * FROM `".TABLE_LESSONS."` WHERE subject_id='.$subject_id.' ORDER BY lesson_date ' );
 // echo 'SELECT * FROM `".TABLE_LESSONS."` WHERE subject_id='.$subject_id.' ORDER BY lesson_date';
  $lessons = array();
  if(isset($_REQUEST['col'])){
   $cols=$_REQUEST['col'];
  }else{ $cols=7; $_REQUEST['col']=7; }
  $num_row = mysql_num_rows($res);
  $col_row = 0;

    if(isset($_REQUEST['col'])){
      while ($row = mysql_fetch_assoc($res)) {
     if($col_row>=($num_row-$cols)){

        	$lessons[] = $row;
  	        list($year, $month, $day) = explode('-', $row['lesson_date']);
  	        echo "<th  style=\"writing-mode:tb-rl\"><a href='lessons.php?col={$_REQUEST['col']}&subject_id=$subject_id&act=edit_grades&sub_act=zero&less={$row['lesson_id']}'>$day.$month</a></th>";
     }
     $col_row++;
     }
        if($cols<$num_row){
             $num_row=$cols;
         }
    }else{
        while ($row = mysql_fetch_assoc($res)) {
        	$lessons[] = $row;
  	        list($year, $month, $day) = explode('-', $row['lesson_date']);
  	        echo "<th  style=\"writing-mode:tb-rl\"><a href='lessons.php?subject_id=$subject_id'> $day.$month</a></th>";
             $col_row++;
            }
    }

?>
   <th class="rounded-right" colspan="3">&nbsp;</th>
  </tr>
  </thead>
  <tbody>

<?php
  $active_leson = false;
  
  // определяем какой клас ведет учитель
  $teacher_class = db_get_first_row('SELECT class_id FROM `".TABLE_CLASSES."` WHERE teacher_id='.$_SESSION['teacher_id']);

  $subject = db_get_first_row('SELECT * FROM `".TABLE_SUBJECTS."` WHERE subject_id='.$subject_id);
  $students_list = get_student_classes_list2($subject['class_id']);
  $n=1;

  foreach($students_list as $student) {
  	
  if ($student['student_photo']!=='')
  {
  	$student_photo ="<img src=\'../student_photo/sm/$student[student_photo]\'>";
  }
  else
  {
  	$student_photo ="<img src=\'../images/nophoto.gif\'>";
  }
   $student[student_address]=str_replace("\r\n"," ",$student[student_address]);
  echo "<tr><td>$n</td><td nowrap=\"nowrap\"><div style='cursor:pointer;' onmouseover=\"Tip('$student_photo <br>{$lang['login']}: $student[student_login] <br>{$lang['login']}: $student[student_password] <br> {$lang['student_adress']}: $student[student_address] <br>{$lang['student_teless']}: $student[student_phone]')\" onmouseout=\"UnTip()\">$student[student_name]</div></td>";
  $grades = get_grade_from_lesson2($student['student_id'], $subject_id, $cols);

  foreach ($lessons as $lesson){
  	
    	if ($grades[$lesson['lesson_id']] != '') {
  		if ($lesson['active'] == 0) {
		
		 if (@$_GET['action'] == 'edit_grades' && @$_GET['student_id'] == $student['student_id'] && @$_GET['lesson_id'] ==$lesson['lesson_id'])
		 {
			echo '<td><input type="text" name="grades['.$lesson['lesson_id'].']['.$student['student_id'].']" size="10" value="'.$grades[$lesson['lesson_id']].'" maxlength="10" />
			<select name="behavior['.$lesson['lesson_id'].']['.$student['student_id'].']" onChange="javascript: this.form.submit();">';
		    echo '<option value="1"'; if($grades['behavior'][$lesson['lesson_id']]=='1') {echo'selected';} echo'>'.$lang['otlichnoe'].'</option>';
		    
			echo '<option value="2"'; if($grades['behavior'][$lesson['lesson_id']]=='2') {echo'selected';} echo'>'.$lang['udovletvr'].'</option>';

			echo '<option value="3"'; if($grades['behavior'][$lesson['lesson_id']]=='3') {echo'selected';} echo'>'.$lang['plohoe'].'</option>';
			
		 }
		 else
		 {
		 	if($grades['behavior'][$lesson['lesson_id']]=='1')
		   {
		  	$behavior = $lang['good_poved'];
		   }
		   elseif($grades['behavior'][$lesson['lesson_id']]=='2')
		   {
		  	$behavior =$lang['poved_norm'];
		   }
		   elseif($grades['behavior'][$lesson['lesson_id']]=='3')
		   {
		  	$behavior =$lang['bad_poved'];
		   }

      	echo '<td><a onmouseover="Tip(\''.$behavior.'\')" onmouseout="UnTip()" href="?action=edit_grades&subject_id='.$subject_id.'&lesson_id='.$lesson['lesson_id'].'&student_id='.$student['student_id'].'">'.$grades[$lesson['lesson_id']].'</a></td>';
		  }
      } else {
      	echo '<td><input type="text" name="grades['.$lesson['lesson_id'].']['.$student['student_id'].']" size="10" value="'.$grades[$lesson['lesson_id']].'" maxlength="10" /><select name="behavior['.$lesson['lesson_id'].']['.$student['student_id'].']" onChange="javascript: this.form.submit();"><option value="1">'.$lang['otlichnoe'].'</option><option value="2">'.$lang['udovletvr'].'</option><option value="3">'.$lang['plohoe'].'</option></select></td>';
      }
    } else {
    	if ($lesson['active'] == 0) {
    	// Добавить оценку если пусто	
    	  if (@$_GET['action'] == 'add_grades' && @$_GET['student_id'] == $student['student_id'] && @$_GET['lesson_id'] ==$lesson['lesson_id'])	
      	  {
		    echo '<td><input type="text" name="grades['.$lesson['lesson_id'].']['.$student['student_id'].']" size="10" value="" maxlength="10" /></td><td><select name="behavior['.$lesson['lesson_id'].']['.$student['student_id'].']" onChange="javascript: this.form.submit();"><option value="1">'.$lang['otlichnoe'].'</option><option value="2">'.$lang['udovletvr'].'</option><option value="3">'.$lang['plohoe'].'</option></select></td>';
      	  }
      	  else
      	  {
      	  	echo '<td><a href="?action=add_grades&subject_id='.$subject_id.'&lesson_id='.$lesson['lesson_id'].'&student_id='.$student['student_id'].'" title="'.$lang['add_grade_w'].'">+</a></td>';
      	  }
      	
      } else {
      	$active_leson = true;
      	echo '<td><input type="text" name="grades['.$lesson['lesson_id'].']['.$student['student_id'].']" size="10" value="" maxlength="10" /><select name="behavior['.$lesson['lesson_id'].']['.$student['student_id'].']" ><option value="1">'.$lang['otlichnoe'].'</option><option value="2">'.$lang['udovletvr'].'</option><option value="3">'.$lang['plohoe'].'</option></select></td>';
      }
    }
   
  }
  if ($student['students_classid'] == $teacher_class['class_id'])
  {
  	echo '<td><a href="edit_student.php?student_id='.$student['student_id'].'&TB_iframe=true&height=400&width=600&'.uniqid('r').'" title="Редактировать ученика" class="thickbox">Редактировать</a>
	<a href="del_class_student.php?student_id='.$student['student_id'].'&subject_id='.$subject_id.'&class_id='.$subject['class_id'].'" onclick="return confirm(\'Вы, уверены что хотите удалить эту запись!\')">Удалить</a>
	</td>';
  }
  echo '<td></td>';
  echo '</tr>';
  $n++;
  }
?>
  </tbody>
<tfoot>

    	<tr>
       	  <td class="rounded-foot-left">&nbsp;</td>
        	<td>&nbsp;</td>
<?php
for($i=1; $i<=$num_row; $i++) {
	echo '<td>&nbsp;</td>';
}
?>
<td colspan="3" class="rounded-foot-right"><?php  if ($student['students_classid'] == $teacher_class['class_id'])
  {
  	echo '<a href="add_student.php?TB_iframe=true&height=450&width=600&'.uniqid('r').'" title="Добавить ученика" class="thickbox">Добавить ученика</a>';
}
?></td>
        </tr>
    </tfoot>
</table>
<br />

<input type="button" value="Закончить урок" onClick="javascript:this.form.act.value='close'; this.form.submit();" <?php if (!$active_leson ) echo ' disabled="disabled"' ?> />
</form>
</td>
<table width="100%" border="0" ><tr><td width="100%" align="center">



<table id="rounded-corner" width="100%" align="center" border="0">
<thead>
  <tr>
    <th class="rounded-left">Дата</th>
    <th>№ урока</th>
    <th width="50%">Тема урока</th>
    <th>Домашнее задание</th>
    <th class="rounded-right" colspan="2">&nbsp;</th>
  </tr>
  </thead>
  <tbody>
  </center>
  
  <form name='del' method='post' action=''>
  <input type='hidden' name='delete_this' value='yes'>
<?php

  $show_line = false;
  foreach($lessons as $lesson) {
  	list($year, $month, $day) = explode('-', $lesson['lesson_date']);
  	if ($lesson['lesson_order']!='10000') {
  	echo '<tr><td width="8%">'.$day.'.'.$month.'</td><td>'.$lesson['lesson_order'].'</td><td width="50%">'.$lesson['topic'].'</td><td>'.$lesson['dz'].'</td>
  	<td><a href="edit_lesson.php?lesson_id='.$lesson['lesson_id'].'&TB_iframe=true&height=300&width=400&'.uniqid('r').'" title="Редактировать урок" class="thickbox">Редактировать</a></td>

  	<td><input value="1" type="checkbox" name="id'.$lesson["lesson_id"] . '"></td></tr>'; }
  	else {
  	
echo '<tr><td width="8%">'.$day.'.'.$month.'</td><td colspan="3" align="center">Экзамен
  	<td><a href="edit_lesson.php?lesson_id='.$lesson['lesson_id'].'&TB_iframe=true&height=300&width=400&'.uniqid('r').'" title="Редактировать урок" class="thickbox">Редактировать</a></td>

  	<td><input value="1" type="checkbox" name="id'.$lesson["lesson_id"] . '"></td></tr>';  	
  	
  	
  	}
  	
  	
  	
  	$show_line = !$show_line;
  }
?>
<td colspan="5"><td>
<input type='submit' value='Удалить'>
</form> </table>
<form name='download' action='../download.php' method='POST'>
<table>
<tr><td><input type='hidden' name='class_id' value="<?php echo $subject['class_id'];?>">
<td><input type='hidden' name='subject_id' value="<?php echo $subject_id;?>">
<td><input type='submit' value='Получить шаблон для ввода данных'>
</table>


</form>
  </tbody>


<tfoot>
    	<tr>
       	  <td class="rounded-foot-left">&nbsp;</td>
       	  <td>&nbsp;</td>
        	<td class="rounded-foot-right" colspan="4">&nbsp;</td>
        </tr>
    </tfoot>
</table>
<a href="new_lesson.php?subject_id=<?php echo $subject_id ?>&TB_iframe=true&height=330&width=400&<?php echo uniqid('r'); ?>" title="Создать новый урок" class="thickbox">Новый урок</a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="new_lesson_exam.php?subject_id=<?php echo $subject_id ?>&TB_iframe=true&height=330&width=400&<?php echo uniqid('r'); ?>" title="Оценки по экзамену" class="thickbox">Добавить экзамен</a></td>

</tr></table>
</div>
<?php

include 'footer.php';
?>