<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

define('TEACHER_ZONE', true);
function translitIt($str) 
{
    $tr = array(
        "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
        "Д"=>"D","Е"=>"E","Ё"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
        "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
        "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
        "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
        "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
        "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"e","ж"=>"j",
        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
        "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
        "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", 'і'=>'i', 'ї'=>'i', " "=>"_", "№"=>"N"
    );
    return strtr($str,$tr);
}

include_once ('../init.php');

include_once ('../include/curriculums.php');

if ((LOCAL === true) || (SUBDOMEN == 'demo'))
  $OFF = 1;
else
  $OFF = 0;

if (isset($_REQUEST['action']) && $_REQUEST['action']='sendsched') {
  $quarter_id = $_SESSION['quarterid'] = get_quarter_id($lesson_date);

  $date  = date('Y-m-d');
  $date0 = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d')+1, date('Y')));
  $date1 = date('d.m', mktime(0, 0, 0, date('m'), date('d')+1, date('Y')));
  $wd    = date('w');
  $we    = (DAYS) ? 6 : 5;

  $sql = "SELECT a.`class_id`, l.* , d.discipline, a.discipline_id, a.teacher_id, a.date_schedule, a.order_schedule, a.id_schedule"
        ." FROM `".TABLE_SCHEDULE."` AS a"
        ." LEFT JOIN `".TABLE_LESSONS."` AS l ON l.schedule_id = a.id_schedule"
        ."  AND (date_format( DATE_ADD( NOW() , INTERVAL ".(($wd >= $we) ? 8-$we : 1)." DAY ) , '%Y-%m-%d' ) = l.`lesson_date` )"
        ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` AS d ON d.discipline_id = a.discipline_id"
//       ." LEFT JOIN `".TABLE_SUBJECTS."`    AS s ON (s.discipline_id = a.discipline_id) AND (s.class_id = a.class_id) AND ( s.teacher_id = a.teacher_id )"
        ." WHERE ( a.date_schedule = date_format(DATE_ADD( NOW() , INTERVAL ".(($wd >= $we) ? 7-$we : 0)." DAY ) , '%w' ) )"
        ." AND (a.quarter_id='".$quarter_id."')"
        ." AND ( date_format(DATE_ADD( NOW() , INTERVAL ".(($wd >= $we) ? 8-$we : 1)." DAY ), '%Y-%m-%d' ) BETWEEN a.started AND a.finished )"
        ." AND NOT ifnull( l.date_sched, 0 )"
        ." ORDER BY a.class_id, a.date_schedule, a.order_schedule, a.started DESC, a.finished";

$dump=0;if ($dump) echo $sql."|$wd ==$we|". DAYS."|";

  $res1=mysql_query($sql);

if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

  $sms_count = 0;
  $sms_count_cur = 0;
  while($row1 = mysql_fetch_assoc($res1)) {

if ($dump) {echo "\nschedule=";print_r($row1);}

    $sql = "SELECT s.last_name, s.student_id, s.mother_cell_phone, s.father_cell_phone, s.mode"
          ." FROM `".TABLE_STUDENTS_IN_CLASS."` as sc"
          ." LEFT JOIN `".TABLE_USERS_STUDENTS."` as s ON sc.student_id=s.student_id"
          ." WHERE (s.`active`=1)"
          ." AND ((s.mother_cell_phone<>'') OR (s.father_cell_phone<>''))"
          ." AND (sc.class_id='".$row1['class_id']."')"
          ." ORDER BY s.student_id;";

if ($dump) echo $sql;
    $res2 = db_query($sql);
//if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

    while($row = mysql_fetch_assoc($res2)) {
      $student_id = $row['student_id'];

      $arrays['lesson_id'][$row1['id_schedule']]     = $row1['lesson_id'];
      $arrays['discipline_id'][$row1['id_schedule']] = $row1['discipline_id'];
      $arrays['teacher_id'][$row1['id_schedule']]    = $row1['teacher_id'];
      $arrays['class_id'][$row1['id_schedule']]      = $row1['class_id'];

      $array[$row['student_id']]['id_schedule']   = $row1['id_schedule'];
      $array[$row['student_id']]['name']          = $row['last_name'];
      $array[$row['student_id']]['mode']          = $row['mode'];
      $array[$row['student_id']]['m_fone']        = $row['mother_cell_phone'];
      $array[$row['student_id']]['f_fone']        = $row['father_cell_phone'];
      $array[$row['student_id']]['date_schedule'] = $row1['date_schedule'];
      $array[$row['student_id']]['note'][$row1['order_schedule']] = $row1['discipline'];
    }
  }  //  while($row1
if ($dump) {echo "\narrays=";print_r($arrays);}
if ($dump) {echo "\narray=";print_r($array);}

  if (!empty($array))
    foreach ($array as $student_id=>$data) 
    {
      $sms_count_cur = $sms_count;
      $text="";
      $phones = '';
      $date_schedule = $data['date_schedule'];
      $name_st=$data['name'];

      $text="{$date}.{$name_st}.".$lang['sms_send_sched']."_".$date1.":";

      if (!empty($data['note']))
      foreach ($data['note'] as $order_schedule=>$discipline) 
      {
          $text.=$order_schedule."-".$discipline;
          $text.=";";
      }  //  foreach ($data['notes']

          $text=translitIt($text);
//          $text=str_replace(' ','',$text);
          $test_to_send=iconv("UTF-8","Windows-1251",$text);
         
          if (1||($data['mode']=="1") || ($data['mode']=="3")){
            if (!empty($data['m_fone'])) {
              $data['m_fone'] = str_replace('(' ,'', $data['m_fone']);
              $data['m_fone'] = str_replace(')' ,'', $data['m_fone']);
              $data['m_fone'] = str_replace(' ' ,'', $data['m_fone']);
              $data['m_fone'] = str_replace('-' ,'', $data['m_fone']);
              $data['m_fone'] = substr($data['m_fone'], -10);
        
              if (strlen($data['m_fone']) == 10) {
                $phones .= 'M'.$data['m_fone'].';';

if (empty($OFF)){
                $status = file_get_contents("http://{$sms_send_login}:{$sms_send_pass}@gate.iqsms.ru/send/?phone=+7{$data['m_fone']}&text=$test_to_send&sender=DHEBHUK");
              if (strpos($status, 'accepted') > 0){
                $sms_count++;
              }
} else
                $sms_count++;
if ($dump) echo "|".$status."|".$test_to_send."|";
              } else
                $data['m_fone'] = '';
            }
//$send_m=mail("38{$data['m_fone']}@mxs.mobisoftline.com.ua", "",$test_to_send);
         
//echo "38{$data['m_fone']}@mxs.mobisoftline.com.ua";
          
          }
          
          if (1||($data['mode']=="2") || ($data['mode']=="3")){
      //mail("38{$data['f_fone']}@mxs.mobisoftline.com.ua", "",$test_to_send);
            if (!empty($data['f_fone'])) {
              $data['f_fone'] = str_replace('(' ,'', $data['f_fone']);
              $data['f_fone'] = str_replace(')' ,'', $data['f_fone']);
              $data['f_fone'] = str_replace(' ' ,'', $data['f_fone']);
              $data['f_fone'] = str_replace('-' ,'', $data['f_fone']);
              $data['f_fone'] = substr($data['f_fone'], -10);
        
              if (strlen($data['f_fone']) == 10) {
                $phones .= 'F'.$data['f_fone'].';';
if (empty($OFF)){
                $status = file_get_contents("http://{$sms_send_login}:{$sms_send_pass}@gate.iqsms.ru/send/?phone=+7{$data['f_fone']}&text=$test_to_send&sender=DHEBHUK");
              if (strpos($status, 'accepted') > 0){
                $sms_count++;
if ($dump) echo "|".$status."|".$test_to_send."|";
              }
} else
                $sms_count++;
              } else
                $data['f_fone'] = '';

            }
          }

//if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

          if ($sms_count_cur < $sms_count) {
          $sql = "INSERT INTO `".TABLE_SMS_LOGS."` (`studless_id`, `student_id`, `date`, `type`, `text`)"
                ." VALUES ('".$data['id_schedule']."', '".$student_id."', NOW(), 's', '".$phones.$test_to_send."');";
if ($dump) echo "\n".$sql;
          $res=mysql_query($sql);
        }
//if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

    }  //  foreach ($array


  $text="";

  $send_OK =  "\n<br>".$lang['sms_sched_send_ok']."(".$sms_count.")";
}  //  if($_REQUEST['action']='senddz')


  if ($sms_count > 0) {
    foreach ($arrays['lesson_id'] as $schedule_id=>$lesson_id) {
      if (empty($lesson_id)){
        $sql = "SELECT subject_id FROM `".TABLE_SUBJECTS."`"
              ." WHERE (teacher_id='".$arrays['teacher_id'][$schedule_id]."') AND (discipline_id='".$arrays['discipline_id'][$schedule_id]."') AND (class_id='".$arrays['class_id'][$schedule_id]."')";
        $subject_id = db_get_cell($sql);
if ($dump) {echo "\nsubject_id=$subject_id|$sql";}
        if (!empty($subject_id)){
          $fields = array();
          $fields['lesson_date'] = $date0;
          $fields['subject_id']  = $subject_id;
          $fields['schedule_id'] = $schedule_id;
          $fields['active']      = 1;
if ($dump) {echo "\nfields=";print_r($fields);}
          $lesson_id = db_array2insert(TABLE_LESSONS, $fields);
        }
      } 

      if (!empty($lesson_id)){
        $sql = "UPDATE `".TABLE_LESSONS."` SET `date_sched`=NOW()"
              ." WHERE (`lesson_id`='".$lesson_id."') ;";
if ($dump) echo $sql;
        $res=mysql_query($sql);
      }
    }
  }

include 'header.php';
/*
$nums_grade = db_get_cell("SELECT COUNT(grade) FROM `".TABLE_STUDENTS_ON_LESSON."` 
           INNER JOIN `".TABLE_LESSONS."` ON lessons.lesson_id=students_on_lesson.lesson_id WHERE lessons.lesson_date='".date('Y-m-d')."';");
*/
?>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet" />
      <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
      <script type="text/javascript" src="../js/jquery.js"></script>
      <script type="text/javascript" src="../js/jquery-ui.js"></script>
      <script type="text/javascript" src="../js/ui.datepicker-ru.js"></script>
<div align="center"> 

<br />
<table id="edit">
  <tbody>
  <tr class="TableHead">
    <th colsapan="2"><?php echo $lang['sms_sched_send'];?></th>
  </tr>
  <tr>
    <td><?php echo $send_OK;?></td>
  </tr>
  <tr>
    <td><?php echo $lang['sms_send_sched'];?>: <?php echo date('d.m.Y', mktime(0,0,0,date('m'), date('d')+1, date('Y'))); ?> </td>
  </tr>
  
  <tr>
   <td>
   <form action="schedull_send_sms.php" method="post">
   <input type="hidden" name="action" value="sendsched" />
    <?php echo $lang['sms_send_commit_sched'];?>
      <input type="submit"  class="button" value=" <?php echo $lang['sms_send'];?> " />
<script type="text/javascript">
  $(function() {
    $('#date_send_id').datepicker({
      changeMonth: true,
      changeYear: true,
      showButtonPanel: true
    });
  });
  </script>
    </form>
    </td>
  <tr>
  </tbody>
</table>
</div> 
<br> 
<?php
include 'footer.php';
?>