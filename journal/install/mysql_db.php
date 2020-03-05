<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                     |
+-----------------------------------------------------------------------------+
\*****************************************************************************/



function db_connect($host, $user, $passwd, $base)
{
  $link = @mysql_connect($host, $user, $passwd) or die('MySQL Error:<br />'.mysql_error());
  db_select($base, $link);
  return $link;
}

function db_select($base, $link = '')
{
  if (empty($link))
    @mysql_select_db($base) or die('MySQL Error:<br />'.mysql_error());
  else
    @mysql_select_db($base, $link) or die('MySQL Error:<br />'.mysql_error());
if (mysql_errno()) { echo '<br>db_select:'. mysql_errno().':'.mysql_error().'<br>'; }
  @mysql_query('SET NAMES UTF8;') or die('MySQL Error:<br />'.mysql_error());
}

function db_query($sql) {
  $result = @mysql_query($sql) or die('MySQL Error:<br />'.$sql.' - '.mysql_error());
  return $result;
}

function db_get_first_row($sql)
{
  $result = @mysql_query($sql) or die('MySQL Error:<br />'.$sql.' - '.mysql_error());
  $row = mysql_fetch_assoc($result);

  return $row;
}

function db_get_rows($sql)
{
  $result = @mysql_query($sql) or die('MySQL Error:<br />'.$sql.' - '.mysql_error());
  $list = array();
  while($row = mysql_fetch_assoc($result)){
    $list[] = $row;
  }
  return $list;
}

function db_get_cell($sql)
{
  $result = @mysql_query($sql) or die('MySQL Error:<br />'.$sql.' - '.mysql_error());
  $row = mysql_fetch_assoc($result);
  if ($row) {
    return array_pop($row);
  } else {
  	return null;
  }
}

function db_get_insert_id()
{
  return mysql_insert_id();
}

function db_array2insert($table, $data)
{
  $fields = implode('`, `', array_keys($data));
  $values = implode("', '", array_map('mysql_escape_string', $data));
  $sql = "INSERT INTO `".$table."` (`".$fields."`) VALUES ('".$values."');";
//echo $sql;
  db_query($sql);
  return db_get_insert_id();
}

function db_array2update($table, $data, $where)
{
  $fields = array();
  foreach($data as $field=>$value) {
    if ($value == 'NULL')
      $fields[] = "`".$field."` = NULL";
    else
      $fields[] = "`".$field."` = '".mysql_escape_string($value)."'";
  }
  $sql = "UPDATE  `".$table."` SET ".implode(', ', $fields)." WHERE ".$where.";";
//echo $sql."\n";
  return db_query($sql);
}


?>