<?php
  
  header("Content-type: text/html; charset=utf-8");
  define('TEACHER_ZONE', true);
  include_once ('../init.php');   
  error_reporting(E_ALL & ~E_NOTICE);
  $classid=intval($_GET['classid']);
  
?>
<select name="information_classes" >
<option value=""><?php echo $lang['select'];?></option>
 <?php
   $db_discipline = mysql_query("SELECT s.student_id, last_name, first_name FROM `".TABLE_STUDENTS_IN_CLASS."` as si"
           ." JOIN `".TABLE_USERS_STUDENTS."` as s on s.student_id=si.student_id where class_id='".$classid."'");
   while ($discipline = mysql_fetch_array($db_discipline)) {
    echo "<option value=\"".$discipline['student_id']."\">". $discipline['last_name']." ".$discipline['first_name']."</option>";
   }
   ?>
</select>
