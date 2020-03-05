<?
 // DEL USER


  define('ADMIN_ZONE', true);
   include_once ('../init.php');
   
  if (isset($_SESSION['admin_id']))
  {
  	
    $query = "DELETE FROM `".TABLE_SCHOOL_YEARS."` WHERE school_year_id ='".$_GET['school_year_id']."'";
  
    if(mysql_query($query)) 
    {
 	  exit(header("Location: curriculum.php"));
    }
    
  } else { exit(header("Location: login.php")); }
 
?>