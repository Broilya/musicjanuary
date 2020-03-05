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

//die("|".$OFF."|");

  $date=date('Y-m-d');
if (isset($_REQUEST['action']) && $_REQUEST['action']=='sendnews') {
		
  $sql = "SELECT inf.*"
        ." FROM `".TABLE_INFORMATION."` as inf"
        ." WHERE (inf.information_date <='".$date."')"
        ." AND ((inf.information_title <> '') OR (inf.information_text <> ''))"
        ." AND NOT ifnull( inf.date_news, 0 )"
        ." AND (inf.information_section ='student')";

$dump=0;if ($dump) echo $sql;
  $res1 = db_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

		
		
  $sms_count = 0;
  $sms_count_cur = 0;
while($row1 = mysql_fetch_assoc($res1)) {

  $sql = "SELECT s.last_name, s.student_id, s.mother_cell_phone, s.father_cell_phone, s.mode"
        ." FROM `".TABLE_STUDENTS_IN_CLASS."` as sc"
        ." LEFT JOIN `".TABLE_USERS_STUDENTS."` as s ON sc.student_id=s.student_id"
        ." WHERE (s.`active`=1)"
        ." AND ((s.mother_cell_phone<>'') OR (s.father_cell_phone<>''))"
        .((empty($row1['information_classes'])) ? '' : " AND (sc.class_id='".$row1['information_classes']."')")
        .";";

# ON inf.class_id=inf.information_classes AND (mation_section ='student')
if ($dump) echo $sql;
  $res2 = db_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

  while($row = mysql_fetch_assoc($res2)) {
    $array[$row['student_id']]['information_id'][]=$row1['information_id'];
    $array[$row['student_id']]['name']=$row['last_name'];
    $array[$row['student_id']]['mode']=$row['mode'];
    $array[$row['student_id']]['m_fone']=$row['mother_cell_phone'];
    $array[$row['student_id']]['f_fone']=$row['father_cell_phone'];
    $array[$row['student_id']]['news'][$row1['information_id']][]=$row1['information_title'].":".$row1['information_text'];
  
// $text .="$grade[discipline]: $grade[grade]\n";
  }
}  
if ($dump) print_r($array);
  $text="";
  if (!empty($array))
  foreach ($array as $student_id=>$data) 
  {
    $phones = '';

    $name_st=$data['name'];

    foreach ($data['news'] as $information_id=>$notes) 
    {
      foreach ($notes as $key=>$note) 
      {
        $sms_count_cur = $sms_count;
        $text="{$date}.{$name_st}.";
        $text.=$note;
        $text.=";";
//echo $text;

//          $text=translitIt($text);
//          $text=str_replace(' ','',$text);
//        $test_to_send=iconv("UTF-8","Windows-1251",$text);
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
//              $status = file_get_contents("http://{$sms_send_login}:{$sms_send_pass}@gate.iqsms.ru/send/?phone=+7{$data['m_fone']}&text=$test_to_send&sender=DHEBHUK");
              $status=send("gate.iqsms.ru", 80, $sms_send_login, $sms_send_pass, "7".$data['m_fone'], $test_to_send, "DHEBHUK");
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
//              $status = file_get_contents("http://{$sms_send_login}:{$sms_send_pass}@gate.iqsms.ru/send/?phone=+7{$data['f_fone']}&text=$test_to_send&sender=DHEBHUK");
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

if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

        if ($sms_count_cur < $sms_count) {
          $sql = "INSERT INTO `".TABLE_SMS_LOGS."` (`studless_id`, `student_id`, `date`, `type`, `text`)"
                ." VALUES ('".$information_id."', '".$student_id."', NOW(), 'n', '".$phones.$test_to_send."');";
//echo $sql;
          $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
        }
      }
    }  //  foreach ($data['notes']

    if ($sms_count_cur < $sms_count) 
    if (!empty($data['m_fone']) || !empty($data['f_fone'])) {
      $information_all ='';
      foreach($data['information_id'] as $key=>$information_id) {
        $sql = "UPDATE `".TABLE_INFORMATION."` SET `date_news`=NOW()"
              ." WHERE (`information_id`='".$information_id."') ;";
        $information_all .= $information_id.";";
if ($dump) echo $sql;
        $res=mysql_query($sql);
      }

    }

    $text="";
  }  //  foreach ($array


  $send_OK =  "\n<br>".$lang['sms_news_send_ok']."(".$sms_count.")";
}  //  if($_REQUEST['action']='sendnote')


  include 'header.php';
/*
$nums_note = db_get_cell("SELECT COUNT(1) FROM `".TABLE_STUDENTS_ON_LESSON."`"
                        ." INNER JOIN `".TABLE_LESSONS."` ON lessons.lesson_id=students_on_lesson.lesson_id"
                        ." WHERE lessons.lesson_date='".date('Y-m-d')."';");

*/
$nums_note =$sms_count;
$date = implode('.', array_reverse(explode('-', $date)));
$result_note =<<< EOT

<div align="center"> 

<br />
<table id="edit">
  <tbody>
  <tr class="TableHead">
    <th colsapan="2">{$lang['sms_news_send']}</th>
  </tr>
  <tr>
    <td>{$send_OK}</td>
  </tr>

  <tr>
    <td>За {$date} разослано {$nums_note} новостей.</td>
  </tr>


  <tr>
	 <td>
<link type="text/css" href="../css/jquery-ui.css" rel="stylesheet" />
      <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    	<script type="text/javascript" src="../js/jquery.js"></script>
    	<script type="text/javascript" src="../js/jquery-ui.js"></script>
    	<script type="text/javascript" src="../js/ui.datepicker-ru.js"></script>

	 <form action="sms_sending-news.php" method="post">
	 <input type="hidden" name="action" value="sendnews" />
    {$lang['sms_send_commit_news']}
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
EOT;
  echo $result_note;
  include 'footer.php';

?>