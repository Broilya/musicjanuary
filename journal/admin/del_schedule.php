<?
  // DEL STUDENT FROM CLASS
   
   define('ADMIN_ZONE', true);
   include_once ('../init.php');
   
  if (isset($_SESSION['admin_id']))
  {
 
    $query = "DELETE FROM `".TABLE_SCHEDULE."` WHERE id_schedule='".$_GET['id_schedule']."'";
  
    if(mysql_query($query)) 
    {
 	  exit(header("Location: schedule-journal.php"));
    }
	
   } else { exit(header("Location: login.php")); }  
?>