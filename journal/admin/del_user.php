<?
 // DEL USER

  define('ADMIN_ZONE', true);

   include_once ('../init.php');
   
  if (isset($_SESSION['admin_id']))
  {
  	
    $query = "DELETE FROM `".TABLE_USERS."` WHERE user_id ='".$_GET['user_id']."'";
  
    if(mysql_query($query)) 
    {
 	  exit(header("Location: users.php"));
    }
    
  } else { exit(header("Location: login.php")); }
 
?>