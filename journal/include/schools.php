<?php

function get_schools_list($school_id=0, $active=0)
{
  $sql = "SELECT s.*"
         ." FROM `".TABLE_SCHOOLS."` s"
         ." WHERE 1=1"
         .((empty($active)) ? '' :" ` AND active`=1")
         .((empty($school_id)) ? '' :
           " AND s.school_id='".$school_id."'")
         ." ORDER BY s.school_name";
//echo $sql;
  $res = db_query($sql);
  $list_schools = array();
  while($row = mysql_fetch_assoc($res)){
    $list_schools[] = $row;
  }
  return $list_schools;
}

?>