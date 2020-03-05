<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/




function get_teachers_list($discipline_id='')
{
  $sql = "SELECT t.*, d.discipline_id, d.discipline FROM `".TABLE_USERS_TEACHERS."` t"
         ." LEFT JOIN `".TABLE_SUBJECTS."` s ON (s.teacher_id=t.teacher_id)"
         ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` d ON (d.discipline_id=s.discipline_id)"
         .((empty($discipline_id)) ? '' : " WHERE d.`discipline_id`='$discipline_id'")
         ." ORDER BY last_name, first_name, middle_name, d.discipline";
  $res = db_query($sql);
  $teachers_list = array();
  while($row = mysql_fetch_assoc($res)){
    $teachers_list[] = $row;
  }
  return $teachers_list;
}

function get_student_classes_list($class_id)
{
  $sql = "SELECT students.student_id, CONCAT_WS('', last_name, ' ', first_name, ' ', "
         ." SUBSTRING(middle_name, 1, 1),'.') AS teacher_name  , students.active"
         ." FROM `".TABLE_STUDENTS_IN_CLASS."` "
         ." LEFT JOIN `".TABLE_USERS_STUDENTS."` ON students_in_class.student_id=students.student_id";
  $sql .= " WHERE class_id='".$class_id."'";
  $res = db_query($sql);
  $list_classes = array();
  while($row = mysql_fetch_assoc($res)){
    $list_classes[] = $row;
  }
  return $list_classes;
}

?>