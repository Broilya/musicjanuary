<?php

  header("Content-type: text/html; charset=utf-8");
  define('TEACHER_ZONE', true);
  include_once ('../init.php');   
  error_reporting(E_ALL & ~E_NOTICE);
  $schoolyear=intval($_GET['classid']);
  
?>
<select name="id_quater" >
<option value=""><?php echo $lang['select'];?></option>
 <?php
   $db_classes = mysql_query("SELECT * FROM `".TABLE_SCHOOL_QUARTERS."` where school_year_id='".$schoolyear."' and quarter_type=1");
   while ($classes = mysql_fetch_array($db_classes)) {
    echo "<option value=\"".$classes['quarter_id']."\">".$classes['quarter_name']." ". $classes['letter']."</option>";
   }
   
   ?>
  
</select>
