<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                      |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


function get_users_list()
{
  $sql = "SELECT * FROM `".TABLE_USERS."` where access=1 ORDER BY 5, 3, 4";
  $res = db_query($sql);
  $users_list = array();
  while($row = mysql_fetch_assoc($res)){
    $users_list[] = $row;
  }
  return $users_list;
}

function get_teachers_list()
{
  $sql = "SELECT * FROM `".TABLE_USERS_TEACHERS."`  ORDER BY last_name, first_name";
  $res = db_query($sql);
  $users_list = array();
  while($row = mysql_fetch_assoc($res)){
    $users_list[] = $row;
  }
  return $users_list;
}

function get_dir_list()
{
  $sql = "SELECT * FROM `".TABLE_USERS."` where access=2 ORDER BY last_name, first_name";
  $res = db_query($sql);
  $users_list = array();
  while($row = mysql_fetch_assoc($res)){
    $users_list[] = $row;
  }
  return $users_list;
}
?>