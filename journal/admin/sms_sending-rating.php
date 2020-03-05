<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('ADMIN_ZONE', true);

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
        "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", '?'=>'i', 'ї'=>'i', " "=>"_", "№"=>"N"
    );
    return strtr($str,$tr);
}

  include_once ('../init.php');
  include_once ('../include/php_sms.php');

if ((LOCAL === true) || (SUBDOMEN == 'demo'))
  $OFF = 1;
else
  $OFF = 0;


if (isset($_REQUEST['action']) && $_REQUEST['action']=='sendgrade') {
		
  $date=date('Y-m-d');
  $sql = "SELECT s.last_name, s.student_id, s.mother_cell_phone, s.father_cell_phone, s.mode , sol.*, l.*, d.*"
        ." FROM `".TABLE_USERS_STUDENTS."` as s"
        ." LEFT JOIN `".TABLE_STUDENTS_ON_LESSON."` as sol ON sol.student_id=s.student_id"
        ." LEFT JOIN `".TABLE_LESSONS."` as l ON l.lesson_id=sol.lesson_id"
        ." LEFT JOIN `".TABLE_SUBJECTS."` as subj ON subj.subject_id=l.subject_id"
        ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` as d ON d.discipline_id=subj.discipline_id"
        ." WHERE (s.`active`=1)"
        ." AND l.lesson_date<='".$date."'"
        ." AND sol.grade <> ''"
        ." AND (s.mother_cell_phone<>'' OR s.father_cell_phone<>'')"
        ." AND NOT ifnull( sol.date_grade, 0 )";
//            WHERE s.`send_from`<='{$date}' AND s.`send_to`>='{$date}' 
$dump=0;if ($dump) echo $sql;
  $res2 = db_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

		
  $sms_count = 0;
  $sms_count_cur = 0;
  while($row = mysql_fetch_assoc($res2)) {
    if (empty($row['grade'])) continue;

    $array[$row['student_id']]['studless_id'][]=$row['studless_id'];
    $array[$row['student_id']]['lesson_id'][]=$row['lesson_id'];
    $array[$row['student_id']]['name']=$row['last_name'];
    $array[$row['student_id']]['mode']=$row['mode'];
    $array[$row['student_id']]['m_fone']=$row['mother_cell_phone'];
    $array[$row['student_id']]['f_fone']=$row['father_cell_phone'];
    $array[$row['student_id']]['grades'][$row['discipline']][]=$row['grade'];
  
// $text .="$grade[discipline]: $grade[grade]\n";
  }
  
if ($dump) print_r($array);
  $text="";
  if (!empty($array))
  foreach ($array as $student_id=>$data) 
  {
    $sms_count_cur = $sms_count;
    $phones = '';
  	
    $name_st=$data['name'];
    $text.="{$date}.{$name_st}.";
    
    foreach ($data['grades'] as $disp=>$grade) 
    {
//      $discepl=translitIt($disp);
      $text.=$disp.":";
      foreach($grade as $gr)
      {
        if (empty($gr)) continue;

        $gr=str_replace('н', 'H', $gr);
        $gr=str_replace('Н', 'H', $gr);
        $grades_array[] = $gr;
//$text.=$gr.", ";
      }

      $text.=implode(",", $grades_array);
      unset($grades_array);
      $text.=";";
    }
//echo $text;

//    $text=translitIt($text);
//    $text=str_replace(' ','',$text);
//    $test_to_send=iconv("UTF-8","Windows-1251",$text);
          $test_to_send=$text;
   
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
//              $SMS = "http://{$sms_send_login}:{$sms_send_pass}@gate.iqsms.ru/send/?phone=+7{$data['m_fone']}&text=$test_to_send&sender=DHEBHUK";
//              $status = @file_get_contents($SMS);
              $status=send("gate.iqsms.ru", 80, $sms_send_login, $sms_send_pass, "7".$data['m_fone'], $test_to_send, "DHEBHUK");
              if (strpos($status, 'accepted') > 0){
                $sms_count++;
              }
} else
          $sms_count++;

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
//          $status = file_get_contents("http://{$sms_send_login}:{$sms_send_pass}@gate.iqsms.ru/send/?phone=+7{$data['f_fone']}&text=$test_to_send&sender=DHEBHUK");
              $status=send("gate.iqsms.ru", 80, $sms_send_login, $sms_send_pass, "7".$data['f_fone'], $test_to_send, "DHEBHUK");
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

$dump=0;if ($dump) echo $OFF."|".$status."|".$SMS."|<br>\n";
$dump=0;

    if ($sms_count_cur < $sms_count) 
    if (!empty($data['m_fone']) || !empty($data['f_fone'])) {
      $studless_all ='';
      foreach($data['studless_id'] as $key=>$studless_id) {
        $sql = "UPDATE `".TABLE_STUDENTS_ON_LESSON."` SET `date_grade`=NOW()"
              ." WHERE (`studless_id`='".$studless_id."') ;";
        $studless_all .= $studless_id.";";
if ($dump) echo $sql;
        $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
      }

      $sql = "INSERT INTO `".TABLE_SMS_LOGS."` (`studless_id`, `student_id`, `date`, `type`, `text`)"
            ." VALUES ('".$studless_all."', '".$student_id."', NOW(), 'g', '".$phones.$test_to_send."');";
if ($dump) echo $sql;
      $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
    }

    $text="";
  }  //  foreach ($array


  $send_OK =  "\n<br>".$lang['sms_grades_send_ok']."(".$sms_count.")";
}  //  if($_REQUEST['action']='sendgrade')


include 'header.php';
$nums_grade = db_get_cell("SELECT COUNT(1) FROM `".TABLE_STUDENTS_ON_LESSON."` sl"
       ." INNER JOIN `".TABLE_LESSONS."` l ON l.lesson_id=sl.lesson_id "
       ." WHERE l.lesson_date='".date('Y-m-d')."' AND sl.grade<>'';");
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
    <th colsapan="2"><?php echo $lang['sms_grades_send'];?></th>
  </tr>
  <tr>
    <td><?php echo $send_OK;?></td>
  </tr>

  <tr>
    <td>За <?php echo date('d.m.Y'); ?> выставленно <?php echo $nums_grade ?> оценок!...</td>
  </tr>
  
  <tr>
	 <td>
	 <form action="sms_sending-rating.php" method="post">
	 <input type="hidden" name="action" value="sendgrade" />
    <?php echo $lang['sms_send_commit'];?> 
	    <input type="submit"  class="button" value=" Выслать " />
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
  </tr>
  </tbody>
</table>
</div> 
<br> 
<?php
include 'footer.php';
?>