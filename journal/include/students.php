<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


function get_student($student_id)
{
  $sql = "SELECT s.*, CONCAT_WS('', s.last_name, ' ', s.first_name, ' ', SUBSTRING(s.middle_name, 1, 1),'.') AS student_name, "
        ." c.class as class_name"
        ." FROM `".TABLE_USERS_STUDENTS."` s"
        ." LEFT JOIN `".TABLE_STUDENTS_IN_CLASS."` ss ON ss.`student_id` = s.`student_id`"
        ." LEFT JOIN `".TABLE_CLASSES."` c ON ss.`class_id` = c.`class_id`"
        ." WHERE s.`student_id` = '".$student_id."' "
        ." ORDER BY s.last_name, s.first_name, s.middle_name";
  $res = db_query($sql);
  $users_list = array();
  return mysql_fetch_assoc($res);
}

function get_student_in_class($student_id)
{
  $sql = "SELECT * FROM `".TABLE_STUDENTS_IN_CLASS."` WHERE `student_id` = '".$student_id."' ORDER BY class_id, student_id";
  $res = db_query($sql);
  return mysql_fetch_assoc($res);
}

function get_student_balance($student_id)
{
  $sql = "SELECT * FROM `".TABLE_BALANCE."` WHERE `student_id` = '".$student_id."' ORDER BY date_add, id";
  $res = db_query($sql);
  $list_classes = array();
  while($row = mysql_fetch_assoc($res)){
    $list_classes[] = $row;
  }
  return $list_classes;
}


function setTestBalance ($student_id) {

    if (TEST_DAYS > 0) {
      $data = array();
      $sql = "INSERT INTO `".TABLE_STUDENTS_IN_SERVICE."` (`student_id`, `service_id`, `tarif`, `date_add`)"
            ." SELECT '".$student_id."', s.`service_id`, s.`tarif`, NOW() FROM `".TABLE_BALANCE_SERVICES."` s"
            ." WHERE s.`required` ='1';";
//echo "Iss)".$sql."\n<br>";
      db_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

      $sql = "SELECT sum(ss.`tarif`) FROM `".TABLE_STUDENTS_IN_SERVICE."` ss"
            ." WHERE ss.`student_id`='".$student_id."' LIMIT 0,1;;";
//echo "Sss)".$sql."\n<br>";
      $tarif_all = db_get_cell($sql);

      $data['student_balance'] = (int)(TEST_DAYS*$tarif_all/30);

      if ($data['student_balance'] > 0) {
        $data['student_operator'] = TESTPAY;
        $data['student_nomer'] = '';
        $balance_id = 'NULL';

        $sql = "REPLACE INTO `".TABLE_BALANCE."`  (`id`, `student_id`, `date_add`, `summa`, `operator_id`, `date_edit`, `active`) VALUES"
              ." ('".$balance_id."', '".$student_id."', NOW(), '".$data['student_balance']."', '".$data['student_operator']."', NOW(), 1);";
//echo "Rb)".$sql."\n<br>";
        db_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
      }
    }  //  if (TEST_DAYS > 0)

  $active = setStudentActive ($student_id);

  return $active;
} //  function 


function setStudentActive ($student_id = 0) {

    $sql="UPDATE `".TABLE_USERS_STUDENTS."`  s SET s.`active`=(SELECT if(sum(b.`summa`) > 0, 1, 0)"
        ." FROM `".TABLE_BALANCE."` b WHERE b.`student_id`=s.student_id LIMIT 0,1)"
        .((empty($student_id)) ? '' : " WHERE s.`student_id`='".$student_id."'").";";

    $res=mysql_query($sql);
    if (!empty($student_id))
      $active = getStudentActive ($student_id);
    else
      $active = true;

  return $active;
}

function getStudentBalance ($student_id) {

  $sql = "SELECT round(sum(summa)/100,2) as balance FROM `".TABLE_BALANCE."`"
        ." WHERE `student_id`='".$student_id."' LIMIT 0,1";

  $balance = db_get_cell($sql);

  return $balance;
}



function getStudentActive ($student_id) {

  $sql="SELECT if(sum(`summa`) > 0, 1, 0) FROM `".TABLE_BALANCE."` "
      ." WHERE `student_id`='".$student_id."'"
      ." LIMIT 0,1;";

  $active = db_get_cell($sql);

  return $active;
}

?>