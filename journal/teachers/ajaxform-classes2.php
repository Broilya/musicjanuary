<?php

  header("Content-type: text/html; charset=utf-8");
  define('TEACHER_ZONE', true);
  include_once ('../init.php');   
  error_reporting(E_ALL & ~E_NOTICE);
  $schoolyear=intval($_GET['schoolyear']);
  
?>
<select name="classes2" >
<option value=""><?php echo $lang['select'];?></option>
 <?php
   $db_classes = mysql_query("SELECT class_id, class, letter FROM `".TABLE_CLASSES."` WHERE school_year = '$schoolyear' and teacher_id={$_SESSION['teacher_id']}");
   while ($classes = mysql_fetch_array($db_classes)) {
    echo "<option value=\"".$classes['class_id']."\">".$classes['class']." ". $classes['letter']."</option>";
   }
   
   ?>
  
</select>
