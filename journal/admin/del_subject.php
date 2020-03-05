<?
    // DEL STUDENT CLASS

  define('ADMIN_ZONE', true);
   include_once ('../init.php');

   if (isset($_SESSION['admin_id']))
  {
 
    $query = "DELETE FROM `".TABLE_SUBJECTS."` WHERE class_id='".$_GET['class_id']."' AND subject_id='".$_GET['subject_id']."'";
  
    if(mysql_query($query)) 
    {
 	  exit(header("Location: class.php?class_id=".$_GET['class_id'].""));
    }
  
  } else { exit(header("Location: login.php")); }
	  
?>