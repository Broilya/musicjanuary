<?
    // DEL DISCIPLINES
 
  define('ADMIN_ZONE', true);
  include_once ('../init.php');
  
  if (isset($_SESSION['admin_id']))
  {
  	
    $query = "DELETE FROM `".TABLE_SPR_DISCIPLINES."` WHERE discipline_id ='".$_GET['discipline_id']."'";
  
    if(mysql_query($query)) 
    {
 	  exit(header("Location: disciplines.php"));
    }
  
  } else { exit(header("Location: login.php")); }
 
?>