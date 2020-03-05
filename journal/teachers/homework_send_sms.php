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


if ((LOCAL === true) || (SUBDOMEN == 'demo'))
  $OFF = 1;
else
  $OFF = 0;

if (isset($_REQUEST['action']) && $_REQUEST['action']='senddz') {
  $date=date('Y-m-d');

  $sql = "SELECT a.`class_id`, l.* , d.discipline"
        ." FROM `".TABLE_LESSONS."` AS l"
        ." LEFT JOIN `".TABLE_SCHEDULE."` AS a ON a.id_schedule = l.schedule_id"
        ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` AS d ON d.discipline_id = a.discipline_id"
        ." WHERE l.lesson_date<='".$date."'"
        ." AND l.dz <> ''"
        ." AND NOT ifnull( l.date_dz, 0 )"
        ." ORDER BY l.lesson_id";

$dump=0;if ($dump) echo $sql;

  $res1=mysql_query($sql);

if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

  $sms_count = 0;
  $sms_count_cur = 0;
  while($row1 = mysql_fetch_assoc($res1)) {

if ($dump) print_r($row1);

    $sql = "SELECT s.last_name, s.student_id, s.mother_cell_phone, s.father_cell_phone, s.mode"
          ." FROM `".TABLE_STUDENTS_IN_CLASS."` as sc"
          ." LEFT JOIN `".TABLE_USERS_STUDENTS."` as s ON sc.student_id=s.student_id"
          ." WHERE (s.`active`=1)"
          ." AND ((s.mother_cell_phone<>'') OR (s.father_cell_phone<>''))"
          ." AND (sc.class_id='".$row1['class_id']."')"
          ." ORDER BY s.student_id;";

if ($dump) echo $sql;
    $res2 = db_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

    while($row = mysql_fetch_assoc($res2)) {
      $student_id = $row['student_id'];
      $data = array();
      $data['name']   = $row['last_name'];
      $data['mode']   = $row['mode'];
      $data['m_fone'] = $row['mother_cell_phone'];
      $data['f_fone'] = $row['father_cell_phone'];
      $data['note'][$row1['lesson_id']][]=$row1['discipline'].":".$row1['topic'].".".$row1['dz'];

if ($dump) print_r($data);

      $text="";
      $phones = '';

      $name_st=$data['name'];

      if (!empty($data['note']))
      foreach ($data['note'] as $lesson_id=>$notes) 
      {
        foreach ($notes as $key=>$note) 
        {
          $sms_count_cur = $sms_count;
          $text="{$date}.{$name_st}.";
          $text.=$note;
          $text.=";";

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
              }
} else
                $sms_count++;
if ($dump) echo "|".$status."|".$test_to_send."|";
              } else
                $data['f_fone'] = '';

            }
          }

if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

          if ($sms_count_cur < $sms_count) {
            $sql = "INSERT INTO `".TABLE_SMS_LOGS."` (`studless_id`, `student_id`, `date`, `type`, `text`)"
                  ." VALUES ('".$lesson_id."', '".$student_id."', NOW(), 'd', '".$phones.$test_to_send."');";
if ($dump) echo "\n".$sql;
            $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
          }
        }  //  foreach ($notes
      }  //  foreach ($data['notes']

    }  //  while($row

    if ($sms_count_cur < $sms_count) 
    if ($sms_count > 0) {
      $sql = "UPDATE `".TABLE_LESSONS."` SET `date_dz`=NOW()"
            ." WHERE (`lesson_id`='".$lesson_id."') ;";
if ($dump) echo $sql;
      $res=mysql_query($sql);
    }
    $text="";
  }  //  while($row1

  $send_OK =  "\n<br>".$lang['sms_dz_send_ok']."(".$sms_count.")";
}  //  if($_REQUEST['action']='senddz')

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
    <th colsapan="2"><?php echo $lang['sms_dz_send'];?></th>
  </tr>

  <tr>
    <td><?php echo $send_OK;?></td>
  </tr>
  
  <tr>
    <td><?php echo $lang['sms_send_dz'];?>:<?php echo date('d.m.Y'); ?> </td>
  </tr>
  <tr>
   <td>
   <form action="homework_send_sms.php" method="post">
   <input type="hidden" name="action" value="senddz" />
    <?php echo $lang['sms_send_e'];?>
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