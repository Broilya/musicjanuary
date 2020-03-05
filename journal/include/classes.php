<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                      |
+-----------------------------------------------------------------------------+
\*****************************************************************************/



// ����� ������ �����
function get_classes_list_sel($school_year_id='')
{
  $sql = "SELECT class_id, class, letter FROM `".TABLE_CLASSES."` "
  ." WHERE school_year="
  .((empty($school_year_id)) ? 
      "(select school_year_id FROM `".TABLE_SCHOOL_YEARS."` where current=1)"
    : "'$school_year_id';");
  $res = db_query($sql);
  $list_classes_sel = array();
  while($row = mysql_fetch_assoc($res)){
    $list_classes_sel[] = $row;
  }
  return $list_classes_sel;
}

function get_classes_list($school_year = null)
{
  $sql = "SELECT c.class_id, CONCAT_WS('', c.class, '-', c.letter) AS name,"
        ." c.class, c.letter, sy.name_year, c.teacher_id, "
        ." CONCAT_WS('', t.last_name, ' ', SUBSTRING(t.first_name, 1, 1), '. ',"
        ." SUBSTRING(t.middle_name, 1, 1),'.') AS teacher_name, c.school_year"
        ." FROM `".TABLE_CLASSES."` c"
        ." LEFT JOIN `".TABLE_USERS_TEACHERS."` t ON c.teacher_id=t.teacher_id"
        ." JOIN `".TABLE_SCHOOL_YEARS."` sy ON sy.school_year_id=c.school_year ";

  if (!is_null($school_year)) {
    $sql .= " WHERE c.school_year='".$school_year. "' ORDER BY c.class, c.letter";
  } else {
    $sql .= 'WHERE sy.current=1 ORDER BY c.class, c.letter'; 
  }

  $res = db_query($sql);
  $list_classes = array();
  while($row = mysql_fetch_assoc($res)){
    $list_classes[] = $row;
  }
  return $list_classes;
}

function get_student_classes_list($class_id, $is_group=0)
{
  $sql = "SELECT sc.class_id AS students_classid, s.phone AS student_phone, s.login AS student_login, s.password AS student_password"
        ." , s.address AS student_address, s.photo AS student_photo, s.student_id, s.active"
        ." , CONCAT_WS('', s.last_name, ' ', s.first_name, ' ', SUBSTRING(s.middle_name, 1, 1),'.') AS student_name"
         .((empty($is_group)) ? "" : 
         ", g.group_id, g.group")
        ." FROM `".TABLE_USERS_STUDENTS."` s"
        ." LEFT JOIN `".TABLE_STUDENTS_IN_CLASS."` sc ON sc.student_id=s.student_id"
        .((empty($is_group)) ? "" : 
          " LEFT JOIN `".TABLE_STUDENTS_IN_GROUPS."` sg ON sg.student_id=s.student_id"
         ." LEFT JOIN `".TABLE_SPR_GROUPS."` g ON g.group_id=sg.group_id")
        ." WHERE"
        .((empty($class_id)) ? " NOT ifnull( sc.`class_id`, 0 )" : " (sc.`class_id`='".$class_id."')")
        ." ORDER BY"
        ." student_name "
        .((empty($is_group)) ? "" : ', sg.`group_id`');
//echo $sql;
  $res = db_query($sql);
  $list_classes = array();
  while($row = mysql_fetch_assoc($res)){
    $list_classes[] = $row;
  }
  return $list_classes;
}

function get_student_classes_list2($class_id, $lim=0)
{
  $sql = "SELECT sic.class_id AS students_classid, s.phone AS student_phone, "
        ." s.login AS student_login, s.password AS student_password, s.address AS student_address, "
        ." s.photo AS student_photo, s.student_id, CONCAT_WS('', last_name, ' ', first_name, ' ', "
        ." SUBSTRING(middle_name, 1, 1),'.') AS student_name , s.active"
        ." FROM `".TABLE_STUDENTS_IN_CLASS."` as sic " 
        ." LEFT JOIN `".TABLE_USERS_STUDENTS."` as s ON sic.student_id=s.student_id";

  $sql .= " WHERE class_id='".$class_id."' ORDER BY student_name ";

  if ($lim >0 ) { $sql .= "limit {$lim} "; }
  $res = db_query($sql);
  $list_classes = array();
  while($row = mysql_fetch_assoc($res)){
    $list_classes[] = $row;
  }
  return $list_classes;
}




function get_classe_list_from_teacher($teacher_id)
{
  $sql = "SELECT c.class_id, subject_id, class, letter, discipline"
        ." FROM `".TABLE_CLASSES."` as c" 
        ." LEFT JOIN `".TABLE_SUBJECTS."` as s ON c.class_id = s.class_id"
        ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` as d ON s.discipline_id=d.discipline_id"
        ." WHERE s.teacher_id='".$teacher_id."' ORDER BY class, letter, discipline";
   $res = db_query($sql);
   $list_classes = array();
  while($row = mysql_fetch_assoc($res)){
    $list_classes[] = $row;
  }
  return $list_classes;
}

function get_grade_from_lesson($student_id, $subject_id, $cols)
{
  $res = db_query("SELECT * FROM `".TABLE_LESSONS."` WHERE subject_id='".intval($subject_id)."' limit ". $cols);
  $grades = array();
  while ($row = mysql_fetch_assoc($res)) {
          $grades[$row['lesson_date']] = 0;
  }

  $res = db_query("SELECT * FROM `".TABLE_STUDENTS_ON_LESSON."` "
        ." JOIN `".TABLE_LESSONS."` on lessons.lesson_id=students_on_lesson.lesson_id WHERE student_id='".intval($student_id)."'");
  while ($row = mysql_fetch_assoc($res)) {
          $grades[$row['lesson_date']] = $row['grade'];
          //$grades[$row['lesson_id']] = $row['lesson_date'];
          $grades['behavior'][$row['lesson_id']] = $row['behavior'];
  }
  return $grades;
}


function get_grade_from_lesson2($student_id, $subject_id, $cols, $month, $year)
{ 
  $res = db_query("SELECT * FROM `".TABLE_LESSONS."`"
      ." WHERE EXTRACT(YEAR from lesson_date)='".$year."' and EXTRACT(MONTH from lesson_date)='".$month."'"
      ." and subject_id='".intval($subject_id)."'"
      ." ORDER BY lesson_date DESC"
      ." LIMIT ". $cols);

    $grades = array();
  while ($row = mysql_fetch_assoc($res)) {
          $grades[$row['lesson_date']] = 0;
  }

  $res = db_query("SELECT * FROM `".TABLE_STUDENTS_ON_LESSON."` "
         ." JOIN `".TABLE_LESSONS."` on lessons.lesson_id=students_on_lesson.lesson_id WHERE student_id='".intval($student_id)."'");
  while ($row = mysql_fetch_assoc($res)) {
          $grades[$row['lesson_date']] = $row['grade'];
          $grades[$row['lesson_id']] = $row['grade'];
          $grades['behavior'][$row['lesson_id']] = $row['behavior'];
  }
  return $grades;
}


function get_grade_from_lesson3($student_id, $subject_id, $cols)
{
  $res = db_query("SELECT * FROM `".TABLE_LESSONS."` WHERE  subject_id='".intval($subject_id)."' LIMIT ". $cols);

    $grades = array();
  while ($row = mysql_fetch_assoc($res)) {
          $grades[$row['lesson_date']] = 0;
  }

  $res = db_query("SELECT * FROM `".TABLE_STUDENTS_ON_LESSON."` "
       ." JOIN `".TABLE_LESSONS."` on lessons.lesson_id=students_on_lesson.lesson_id "
       ." WHERE student_id='".intval($student_id)."'");

  while ($row = mysql_fetch_assoc($res)) {
          $grades[$row['lesson_date']] = $row['grade'];
          $grades[$row['lesson_id']] = $row['grade'];
          $grades['behavior'][$row['lesson_id']] = $row['behavior'];
  }
  return $grades;
}



function get_disciplines_from_class($class_id)
{
  $res = db_query("SELECT disciplines.discipline_id, discipline, te.teacher_id, te.photo,"
                 ." te.first_name, te.middle_name, te.last_name"
                 ." FROM `".TABLE_SPR_DISCIPLINES."`"
                 ." INNER JOIN `".TABLE_SUBJECTS."` ON subjects.discipline_id = disciplines.discipline_id"
                 ." JOIN `".TABLE_USERS_TEACHERS."` te on te.teacher_id=subjects.teacher_id"
                 ." WHERE subjects.class_id='".intval($class_id)."'");
  $disciplines = array();
  while ($row = mysql_fetch_assoc($res)) {
          $disciplines[$row['discipline_id']]['name'] = $row['discipline'];
          $disciplines[$row['discipline_id']]['teacher'] = $row['first_name']." ".$row['middle_name']." ".$row['last_name'];
          $disciplines[$row['discipline_id']]['photo'] = $row['photo'];
  }
  return $disciplines;
}


function get_class_student($student_id)
{
  $res = db_query("SELECT CONCAT_WS(' ',s.last_name,s.first_name,middle_name) as fio  , s.active"
         ." FROM `".TABLE_STUDENTS_IN_CLASS."` as sic"
         ." LEFT JOIN `".TABLE_USERS_STUDENTS."` as s ON sic.student_id=s.student_id"
         ." WHERE sic.class_id=(select class_id FROM `".TABLE_STUDENTS_IN_CLASS."` where student_id='".$student_id."')"
         ." ORDER BY s.last_name asc");
          
  $class_students = array();
  while ($row = mysql_fetch_assoc($res))
  {
     $class_students[]=$row['fio'];
  }
  return $class_students;
}


function get_student_quarter_grade($start,$end)
{
  $sql="SELECT sum(sol.grade)/count(sol.grade) as aver, d.discipline,s.subject_id, l.lesson_id"
      ." FROM `".TABLE_STUDENTS_ON_LESSON."` as sol"
      ." JOIN `".TABLE_LESSONS."` as l on (l.lesson_id=sol.lesson_id)"
      ." JOIN `".TABLE_SUBJECTS."` as s on (s.subject_id=l.subject_id)"
      ." JOIN `".TABLE_SPR_DISCIPLINES."` d on (d.discipline_id=s.discipline_id)"
      ." JOIN `".TABLE_CLASSES."` as c on (c.class_id=s.class_id)"
      ." JOIN `".TABLE_SCHOOL_YEARS."` y on (y.school_year_id=c.school_year)"
      ." WHERE (l.lesson_date between '".$start."' and '".$end."')"
      ." AND (sol.student_id='".$_SESSION['student_id']."')"
      ." GROUP by d.discipline,s.subject_id"
      ." ORDER by d.discipline";
//echo $sql;
  $res = db_query($sql);

  $grades = array();
  while ($row=mysql_fetch_assoc($res))
  {
    $grades[]=$row;
  }
  return $grades;
}




function get_student_exam_grade($lesson_id)
{
   
  $sql=  "SELECT sol.grade"
        ." FROM `".TABLE_STUDENTS_ON_LESSON."` as sol"
        ." JOIN `".TABLE_LESSONS."` as l on l.lesson_id=sol.lesson_id)"
        ." JOIN `".TABLE_SUBJECTS."` as s on s.subject_id=l.subject_id)"
        ." JOIN `".TABLE_SPR_DISCIPLINES."` d on d.discipline_id=s.discipline_id)"
        ." JOIN `".TABLE_CLASSES."` as c on c.class_id=s.class_id)"
        ." JOIN `".TABLE_SCHOOL_YEARS."` y on y.school_year_id=c.school_year)"
        ." WHERE (l.lesson_date between y.started AND y.finished)"
        ." AND (y.current=1)"
        ." AND (l.lesson_order=10000)"
        ." AND (l.lesson_id='".$lesson_id."')"
        ." AND (sol.student_id='".$_SESSION['student_id']."');";

//echo $sql;
  $res=db_query($sql);

  $grades = '';
  while ($row=mysql_fetch_assoc($res))
  {
    $grades=$row['grade'];
  }
  return $grades;
}


function get_grade_from_lesson2_n($student_id, $lesson_id)
{
  $sql = "SELECT l.lesson_id, l.lesson_date, sl.student_id, sl.grade, sl.date_grade, sl.behavior, sl.`note`, sl.date_note, sl.studless_id FROM `".TABLE_STUDENTS_ON_LESSON."` sl"
        ." LEFT JOIN `".TABLE_LESSONS."` l on l.lesson_id=sl.lesson_id"
        ." WHERE l.lesson_id='".$lesson_id."'"
        ." AND sl.student_id='".intval($student_id)."'"
        ." ORDER BY l.lesson_date DESC"
        ." LIMIT 0,1";

//echo $sql.'<br>';
  $res = db_query($sql);
    $grades = array();
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
  while ($row = mysql_fetch_assoc($res)) {
          $grades[$row['lesson_date']] = $row['grade'];
          $grades[$row['lesson_id']] = $row['grade'];
          $grades['grade']['date_grade'] = $row['date_grade'];

          $grades['behavior'][$row['lesson_id']] = $row['behavior'];
          $grades['studless'][$row['lesson_id']] = $row['studless_id'];

          $grades['note'][$row['lesson_id']] = $row['note'];
          $grades['note']['date_note'] = $row['date_note'];
  }
  return $grades;
}


function get_group_classes_list($class_id=0)
{
  $sql = "SELECT DISTINCT g.*, cg.class_id"
        ." FROM `".TABLE_SPR_GROUPS."` g"
        ." LEFT JOIN `".TABLE_CLASSES_IN_GROUPS."` cg ON cg.group_id=g.group_id"
        .((empty($class_id)) ? '' :" WHERE cg.class_id='".$class_id."'")
        ." GROUP BY g.group_id ORDER BY g.group_id";
//echo $sql;
  $res = db_query($sql);
  $list_groups = array();
  while($row = mysql_fetch_assoc($res)){
    $list_groups[] = $row;
  }
  return $list_groups;
}

function get_groups_list($group_id=0)
{
  $sql = "SELECT g.*"
        ." FROM `".TABLE_SPR_GROUPS."` g ORDER BY g.group_id"
        .((empty($group_id)) ? '' :" WHERE g.group_id='".$group_id."'");

  $res = db_query($sql);
  $list_groups = array();
  while($row = mysql_fetch_assoc($res)){
    $list_groups[] = $row;
  }
  return $list_groups;
}


?>
