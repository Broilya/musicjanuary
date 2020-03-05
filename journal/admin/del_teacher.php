<?
 // DEL TEACHER

  define('ADMIN_ZONE', true);

   include_once ('../init.php');
   
  if (isset($_SESSION['admin_id']))
  {
  	
    $query = "DELETE FROM `".TABLE_USERS_TEACHERS."` WHERE teacher_id ='".$_GET['teacher_id']."'";
  
    if(mysql_query($query)) 
    {
 	  exit(header("Location: teachers.php"));
    }
    
  } else { exit(header("Location: login.php")); }
 
?>