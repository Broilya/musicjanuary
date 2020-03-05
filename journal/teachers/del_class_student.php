<?
 // DEL STUDENT FROM CLASS
   
define('TEACHER_ZONE', true);
   include_once ('../init.php');
   
  if (isset($_SESSION['teacher_id']))
  {
 
    $query = "DELETE FROM `".TABLE_STUDENTS_IN_CLASS."` WHERE class_id='".$_GET['class_id']."' AND student_id='".$_GET['student_id']."'";
  
    if(mysql_query($query)) 
    {
 	  exit(header("Location: lessons.php?subject_id=".$_GET['subject_id'].""));
    }
	
   } else { exit(header("Location: login.php")); }  
?>