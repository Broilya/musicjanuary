<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


function get_report_teachers_list(){
  $sql = "SELECT * FROM `".TABLE_USERS_TEACHERS."` ORDER BY teacher_id DESC LIMIT 5";
  $res = db_query($sql);
  $report_teachers_list = array();
  while($row = mysql_fetch_assoc($res)){
    $report_teachers_list[] = $row;
  }
  return $report_teachers_list;
}


function get_report_students_list(){
  $sql = "SELECT * FROM `".TABLE_USERS_STUDENTS."` ORDER BY student_id DESC LIMIT 5";
  $res = db_query($sql);
  $report_students_list = array();
  while($row = mysql_fetch_assoc($res)){
    $report_students_list[] = $row;
  }
  return $report_students_list;
}

function get_report_lessons_list() {
  $sql = "SELECT a.lesson_date, a.active, a.subject_id, a.topic, b.first_name, b.last_name, b.middle_name, "
        ." d.discipline, f.class, f.letter FROM `".TABLE_LESSONS."` AS a "
        ." LEFT JOIN `".TABLE_SUBJECTS."` AS s ON s.subject_id=a.subject_id "
        ." LEFT JOIN `".TABLE_USERS_TEACHERS."` AS b ON b.teacher_id=s.teacher_id "
        ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` AS d ON d.discipline_id=s.discipline_id "
        ." LEFT JOIN `".TABLE_CLASSES."` AS f ON f.class_id=s.class_id "
        ." WHERE active='0' ORDER BY lesson_id DESC LIMIT 5";
//echo "|lessons=".$sql."<br>\n";
  $res = db_query($sql);
  $report_lessons_list = array();
  while($row = mysql_fetch_assoc($res)){
    $report_lessons_list[] = $row;
  }
  return $report_lessons_list;
}

function get_report_indx_list($id_class = null, $date_day = null) {
  $sql = "SELECT a.*, d.discipline, s.subject_id FROM `".TABLE_SCHEDULE."` AS a "
        ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` AS d ON d.discipline_id=a.discipline_id "
        ." LEFT JOIN `".TABLE_SUBJECTS."` AS s ON (s.discipline_id=a.discipline_id) AND (s.`teacher_id` = a.`teacher_id`)"
        ." WHERE a.class_id='".intval($id_class)."' AND s.class_id='".intval($id_class)."' "
        ." AND date_schedule='".$date_day."'   and a.school_year=(select school_year FROM `".TABLE_CLASSES."`  as c "
        ." JOIN `".TABLE_SCHOOL_YEARS."` as y on y.school_year_id=c.school_year"
        ." where class_id='".intval($id_class)."'  and y.current=1)"
        ." and a.group_id in (select group_id from `".TABLE_STUDENTS_IN_GROUPS."` where student_id='{$_SESSION['student_id']}' union select '0' )"
        ." ORDER BY order_schedule LIMIT 11";
//echo "|indx=".$sql."<br>\n";  
  $res = db_query($sql);
  $report_indx_list = array();
  while($row = mysql_fetch_assoc($res)){
    $report_indx_list[] = $row;
  }
 
  return $report_indx_list;
}

function get_report_indx_update() {
  $sql = "SELECT  DATE_FORMAT(b.lesson_date,'%d.%m.%y') as lesson_date1, b.active "
        ." FROM `".TABLE_STUDENTS_ON_LESSON."` AS a LEFT JOIN `".TABLE_LESSONS."` AS b ON  b.lesson_id=a.lesson_id "
        ." WHERE b.active = '0' ORDER BY student_id DESC LIMIT 1";
  $res = db_query($sql);
  $report_indx_update = array();
  while($row = mysql_fetch_assoc($res)){
    $report_indx_update[] = $row;
  }
  return $report_indx_update;
}

function get_report_indx_lessons($subject_id = null, $date_schedule = null, $order_schedule = null) {
  
  $sql = "SELECT topic, dz FROM `".TABLE_LESSONS."` WHERE subject_id='".$subject_id."' "
        ." AND lesson_date='".$date_schedule."' AND lesson_order='".$order_schedule."'"; 
  $res = db_query($sql);
  $report_indx_lessons = array();
  while($row = mysql_fetch_assoc($res)){
    $report_indx_lessons[] = $row;
  }
  return $report_indx_lessons;
}



function get_report_indx_lessons_by_student($subject_id = null, $date_schedule = null, $order_schedule = null) {
  
  $sql = "SELECT topic, dz FROM `".TABLE_LESSONS."` WHERE subject_id='".$subject_id."' "
        ." AND lesson_date='".$date_schedule."' AND lesson_order='".$order_schedule."'";

  $sql="SELECT dz,grade"
      ." FROM `".TABLE_LESSONS."` as l"
      ." left JOIN `".TABLE_STUDENTS_ON_LESSON."` as sol on sol.lesson_id=l.lesson_id and l.lesson_date='".$date_schedule."' and sol.student_id='".$_SESSION['student_id']."'"
      ." WHERE subject_id='".$subject_id."'  AND lesson_date='".$date_schedule."'  ";
//      ." lesson_order='".$order_schedule."' ";


  $res = db_query($sql);
  $report_indx_lessons = array();
  while($row = mysql_fetch_assoc($res)){
    $report_indx_lessons[] = $row;
  }
  return $report_indx_lessons;
}





function show_months($mnt) {

$months = array('01'  => 'Январь', '02'  => 'Февраль', '03'  => 'Март', '04'  => 'Апрель', '05'  => 'Май', '06'  => 'Июнь', '07'  => 'Июль', '08'  => 'Август', '09'  => 'Сентябрь', '10' => 'Октябрь', '11' => 'Ноябрь', '12' => 'Декабрь');
$month = $lang["month$mnt"];
//return iconv("WINDOWS-1251", "UTF-8",$month);
return $month;
}

function show_months_ru($mnt) {

$months = array('01'  => 'Январь', '02'  => 'Февраль', '03'  => 'Март', '04'  => 'Апрель', '05'  => 'Май', '06'  => 'Июнь', '07'  => 'Июль', '08'  => 'Август', '09'  => 'Сентябрь', '10' => 'Октябрь', '11' => 'Ноябрь', '12' => 'Декабрь');
$month = $months[$mnt];
//return iconv("WINDOWS-1251", "UTF-8",$month);
return $month;
}
?>