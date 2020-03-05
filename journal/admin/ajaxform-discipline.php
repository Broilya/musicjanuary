<?php
  
  header("Content-type: text/html; charset=utf-8");
  define('ADMIN_ZONE', true);
  include_once ('../init.php');   
  error_reporting(E_ALL & ~E_NOTICE);
  $classid=intval($_GET['classid']);
  
?>
<select name="discipline" onchange="ewd_getcontent('ajaxform-teacher.php?disciplineid='+this.value+'&class=<?php echo $classid;?>', 'teacherdiv');">
  <option value=""><?php echo $lang['select'];?></option>
 <?php
   $db_discipline = mysql_query(
  ." SELECT DISTINCT a.discipline_id, b.discipline_id, b.discipline "
  ." FROM `".TABLE_SUBJECTS."` AS a "
  ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` AS b ON b.discipline_id = a.discipline_id "
  .((empty($classid)) ? '' : "WHERE class_id = '$classid'")
  ." GROUP BY b.discipline"
  ." ORDER BY b.discipline");
   while ($discipline = mysql_fetch_array($db_discipline)) {
    echo "<option value=\"".$discipline['discipline_id']."\">". $discipline['discipline']."</option>";
   }
   ?>
</select>
