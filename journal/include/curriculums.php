<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                     |
+-----------------------------------------------------------------------------+
\*****************************************************************************/



function get_school_years()
{
  $sql = "SELECT * FROM `".TABLE_SCHOOL_YEARS."` 
          ORDER BY started";
  $res = db_query($sql);
  $school_years = array();
  while($row = mysql_fetch_assoc($res)){
    $school_years[] = $row;
  }
  return $school_years;
}

function get_school_year($school_year_id)
{
  $sql = "SELECT * FROM `".TABLE_SCHOOL_YEARS."` WHERE "
          ."school_year_id = '$school_year_id'";
  $res = db_query($sql);
  $school_year = mysql_fetch_assoc($res);
  return $school_year;
}

function get_cur_school_year()
{
  $sql = "SELECT * FROM `".TABLE_SCHOOL_YEARS."` WHERE 
          current=1;";
  $res = db_query($sql);
  $school_year = mysql_fetch_assoc($res);
  return $school_year;
}


function get_quarters_in_year($school_year_id)
{
  $sql = "SELECT quarter_id, school_year_id, quarter_name, quarter_type, current, started, finished 
          FROM `".TABLE_SCHOOL_QUARTERS."` 
          WHERE school_year_id = '$school_year_id' 
          ORDER BY started";
  $res = db_query($sql);
  $quarters_in_year = array();
  while($row = mysql_fetch_assoc($res)){
    $quarters_in_year[] = $row;
  }
  return $quarters_in_year;
}

function get_quarter($quarter_id)
{
  $sql = "SELECT * FROM `".TABLE_SCHOOL_QUARTERS."` WHERE quarter_id = '$quarter_id'";
  $res = db_query($sql);
  $quarter = mysql_fetch_assoc($res);
  return $quarter;
}

function get_cur_quarter($lesson_date='')
{
  $sql = "SELECT * FROM `".TABLE_SCHOOL_QUARTERS."` WHERE "
          .((empty($lesson_date)) ? " (current = 1)" :
            "'".$lesson_date."' BETWEEN started  AND finished ")
          ." LIMIT 0,1;";
  $res = db_query($sql);
  $quarter = mysql_fetch_assoc($res);
  return $quarter;
}

function get_quarter_id($lesson_date='')
{
  $quarter = get_cur_quarter($lesson_date='');
  return $quarter['quarter_id'];
}

function get_school_year_id($lesson_date='')
{
  $sql = "SELECT school_year_id FROM `".TABLE_SCHOOL_YEARS."` WHERE "
          ."'".$lesson_date."' BETWEEN started  AND finished LIMIT 0,1";
  $res = db_query($sql);
  $school_year = mysql_fetch_assoc($res);
  return $school_year['school_year_id'];
}

function date_monday($date='', $n=0) {
  $date0 = (empty($date)) ? date("Y-m-d") : $date;
  $n = (int)$n;
  list ($Y, $M, $D) = explode ('-', $date0);
  $W = date("w", mktime(0, 0, 0, $M, $D, $Y));
  $date0 = mktime(0, 0, 0, $M, $D-$W+$n*7+1, $Y);  // next ponedelnik
  $date0 = date("Y-m-d", $date0);

  return $date0;
}

?>