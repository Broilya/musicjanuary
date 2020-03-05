<?
 // DEL STUDENT FROM CLASS
   
   define('ADMIN_ZONE', true);
   include_once ('../init.php');
   
  if (isset($_SESSION['admin_id']))
  {
 
    $query = "DELETE FROM `".TABLE_LESSONS."` WHERE lesson_id='".$_GET['lesson_id']."' AND subject_id='".$_GET['subject_id']."'";
  
    if(mysql_query($query)) 
    {
 	  exit(header("Location: theme-lessons.php"));
    }
	
   } else { exit(header("Location: login.php")); }  
?>