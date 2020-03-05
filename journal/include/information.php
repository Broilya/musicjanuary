<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

/*
information_section=
student
parent
teacher
balance
personal
all

*/


function get_information_list($section ='')
{
  $sql = "SELECT * FROM `".TABLE_INFORMATION."`"
        .((empty($section)) ? '' : " WHERE information_section='".$section."'")
        ." ORDER BY information_date DESC";
  $res = db_query($sql);
  $information_list = array();
  while($row = mysql_fetch_assoc($res)){
    $information_list[] = $row;
  }
  return $information_list;
}


function get_information_list_at_news($class_id)
{
  if (empty($class_id))
    return false;

  $sql = "SELECT * FROM `".TABLE_INFORMATION."` 
  where information_section='student' and information_classes='{$class_id}' 
  ORDER BY information_date DESC";

  $res = db_query($sql);
  $information_list = array();
  while($row = mysql_fetch_assoc($res)){
    $information_list[] = $row;
  }
  return $information_list;
}

?>