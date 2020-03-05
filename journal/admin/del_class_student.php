<?
 // DEL STUDENT FROM CLASS
   
   include_once ('../init.php');
   
  if (isset($_SESSION['admin_id']))
  {
 
    $query = "DELETE FROM `".TABLE_STUDENTS_IN_CLASS."` WHERE class_id='".$_GET['class_id']."' AND student_id='".$_GET['student_id']."'";
  
    if(mysql_query($query)) 
    {
 	  exit(header("Location: class.php?class_id=".$_GET['class_id'].""));
    }
	
   } else { exit(header("Location: login.php")); }  
?>