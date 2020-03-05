<?php
 // DEL STUDENT FROM CLASS
define('TEACHER_ZONE', true);
   include_once('../init.php');

  if ($_SESSION['teacher_id']!='')
  {
    $query = "DELETE FROM `".TABLE_LESSONS."` WHERE lesson_id='".$_REQUEST['lesson_id']."' AND subject_id='".$_REQUEST['subject_id']."'";
  
    if(mysql_query($query)) 
    {
 	  exit(header("Location: lessons.php?subject_id=".$_REQUEST['subject_id'].""));
    }

   } else {print "hahah"; exit(header("Location: login.php")); }
?>