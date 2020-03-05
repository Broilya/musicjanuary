<?
 // DEL CLASSES


  define('ADMIN_ZONE', true);
   include_once ('../init.php');
   
  if (isset($_SESSION['admin_id']))
  {
  	
    $query = "DELETE FROM `".TABLE_CLASSES."` WHERE  class_id ='".$_GET['class_id']."'";
  
    if(mysql_query($query)) 
    {
 	  exit(header("Location: classes.php"));
    }
    
  } else { exit(header("Location: login.php")); }
 
?>