<?
 // DEL USER

  define('ADMIN_ZONE', true);

   include_once ('../init.php');
   
  if (isset($_SESSION['admin_id']))
  {
  	
    $query = "DELETE FROM `".TABLE_INFORMATION."` WHERE information_id ='".$_GET['information_id']."'";
  
    if(mysql_query($query)) 
    {
 	  exit(header("Location: information.php"));
    }
    
  } else { exit(header("Location: login.php")); }
 
?>