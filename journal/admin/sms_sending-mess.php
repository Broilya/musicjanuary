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

if (1) {
      $result = mysql_query("SHOW COLUMNS FROM `".TABLE_SMS_LOGS."` WHERE field='type'");
      if(mysql_num_rows($result)) {
        $result = mysql_query("ALTER TABLE `".TABLE_SMS_LOGS."` CHANGE `type` `type` ENUM( 'g', 'd', 'z', 's', 'n', 'm' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'g';");
      }
}

  $date=date('Y-m-d');
if (isset($_REQUEST['action']) && $_REQUEST['action']=='sendmess') {
		
  $sms_count = 0;
  $sms_count_cur = 0;

$dump=0;if ($dump) {echo '<br><pre>$_request=|';print_r($_REQUEST);echo '</pre>|<br>';}

$class_id = @intval($_REQUEST['class_id']);

$information_title = $_REQUEST['title'] ;
/*
function unicode_urldecode($url)
{
   preg_match_all('/%u([[:alnum:]]{4})/', $url, $a);
echo  "|$url|";
print_r($a); 
   foreach ($a[1] as $uniord)
   {
       $utf = '&#x' . $uniord . ';';
       $url = str_replace('%u'.$uniord, $utf, $url);
   }
echo  "|$url|";
   return urldecode($url);
}

function code2utf($num){
  if($num<128)
    return chr($num);
  if($num<1024)
    return chr(($num>>6)+192).chr(($num&63)+128);
  if($num<32768)
    return chr(($num>>12)+224).chr((($num>>6)&63)+128)
          .chr(($num&63)+128);
  if($num<2097152)
    return chr(($num>>18)+240).chr((($num>>12)&63)+128)
          .chr((($num>>6)&63)+128).chr(($num&63)+128);
  return '';
}
function unescape($strIn, $iconv_to = 'UTF-8') {
  $strOut = '';
  $iPos = 0;
  $len = strlen ($strIn);
  while ($iPos < $len) {
    $charAt = substr ($strIn, $iPos, 1);
    if ($charAt == '%') {
      $iPos++;
      $charAt = substr ($strIn, $iPos, 1);
      if ($charAt == 'u') {
        // Unicode character
        $iPos++;
        $unicodeHexVal = substr ($strIn, $iPos, 4);
        $unicode = hexdec ($unicodeHexVal);
        $strOut .= code2utf($unicode);
        $iPos += 4;
      }
      else {
        // Escaped ascii character
        $hexVal = substr ($strIn, $iPos, 2);
        if (hexdec($hexVal) > 127) {
          // Convert to Unicode
          $strOut .= code2utf(hexdec ($hexVal));
        }
        else {
          $strOut .= chr (hexdec ($hexVal));
        }
        $iPos += 2;
      }
    }
    else {
      $strOut .= $charAt;
      $iPos++;
    }
  }
  if ($iconv_to != "UTF-8") {
    $strOut = iconv("UTF-8", $iconv_to, $strOut);
  }  
  return $strOut;
}


function unhtmlentitiesUtf8($string, $dump=0) {

    // replace numeric entities
    $string = preg_replace('~%u([0-9a-f]+)~ei', 'chr(hexdec("\\1"))', $string);
if ($dump) {echo "0|$string|\n";}
    $string = preg_replace('~&#([0-9]+);~e', 'chr("\\1")', $string);
    // replace literal entities
    $trans_tbl = get_html_translation_table(HTML_ENTITIES);
    $trans_tbl = array_flip($trans_tbl);
    // changing translation table to UTF-8
    foreach( $trans_tbl as $key => $value ) {
        $trans_tbl[$key] = iconv( 'Windows-1251', 'UTF-8', $value );
    }
    return strtr($string, $trans_tbl);
}

function unicode_decode($txt) {
//  return ereg_replace('%u([[:alnum:]]{4})', '&#x\1;',$txt);
  $temp =  preg_replace('/%u([[:alnum:]]{4})/', '&#\1;',$txt);
  $temp = html_entity_decode($temp);
  return $temp;
  
}
*/

function global_decode($str) {

//    return html_entity_decode()
    return preg_replace_callback(
        '|(?:%u.{4})|',
        create_function(
            '$matches',
            'return \'&#\'.hexdec(substr($matches[0], 2)).\';\';'
        ),
        $str
    );
}  

function formspecialchars($var, $dump=0)
    {
        $pattern = '/&(#)?[a-fA-F0-9]{0,};/';
       
        if (is_array($var)) {    // If variable is an array
            $out = array();      // Set output as an array
            foreach ($var as $key => $v) {     
                $out[$key] = formspecialchars($v);         // Run formspecialchars on every element of the array and return the result. Also maintains the keys.
            }
        } else {
            $out = $var;
            while (preg_match($pattern,$out) > 0) {
                $out = htmlspecialchars_decode($out,ENT_QUOTES);      
            }                            
if ($dump) {echo "0|$out|\n";}
            $out = htmlspecialchars(stripslashes(trim($out)), ENT_QUOTES,'UTF-8',true);     // Trim the variable, strip all slashes, and encode it
           
        }
       
        return $out;
    } 

function htmlspecialchars_deep($mixed, $quote_style = ENT_QUOTES, $charset = 'UTF-8')
{
    if (is_array($mixed)) {
        foreach($mixed as $key => $value) {
            $mixed[$key] = htmlspecialchars_deep($value, $quote_style, $charset);
        }
    } elseif (is_string($mixed)) {
        $mixed = htmlspecialchars(htmlspecialchars_decode($mixed, $quote_style), $quote_style, $charset);
    }
    return $mixed;
} 

$information_text  = urldecode($_REQUEST['message']);
$information_text = $_REQUEST['message'];
$information_text = global_decode($information_text);
if ($dump) {echo "1|$students|$information_title|$information_text|\n";}
$information_text = htmlspecialchars_deep($information_text, $dump);

$students = join("','", $_REQUEST['student_id'] );

if ($dump) {echo "2|$students|$information_title|$information_text|\n";}

  $sql = "SELECT s.last_name, s.student_id, s.mother_cell_phone, s.father_cell_phone, s.mode"
         ." FROM `".TABLE_STUDENTS_IN_CLASS."` as sc"
         ." LEFT JOIN `".TABLE_USERS_STUDENTS."` as s ON sc.student_id=s.student_id"
         ." WHERE (s.`active`=1)"
         ." AND ((s.mother_cell_phone<>'') OR (s.father_cell_phone<>''))"
         ." AND sc.student_id  IN ('".$students."')"
         ." AND (sc.class_id='".$class_id."')"
         .";";

if ($dump) echo $sql;
  $res2 = db_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

  $array = array();
  while($row = mysql_fetch_assoc($res2)) {
    $array[$row['student_id']]['name']=$row['last_name'];
    $array[$row['student_id']]['mode']=$row['mode'];
    $array[$row['student_id']]['m_fone']=$row['mother_cell_phone'];
    $array[$row['student_id']]['f_fone'] = $row['father_cell_phone'];
    $array[$row['student_id']]['news']   = ((empty($information_title)) ? '' : $information_title.":").$information_text;
  
// $text .="$grade[discipline]: $grade[grade]\n";
  }
  
if ($dump) var_dump($array);
  $text="";
  if (!empty($array))
  foreach ($array as $student_id=>$data) 
  {
    $phones = '';

    $name_st=$data['name'];

    $note = $data['news'];
    $sms_count_cur = $sms_count;
    $text="{$date}.{$name_st}.";
    $text.=$note;
    $text.=";";
//echo $text;

//      $text=translitIt($text);
//else        $text = str_replace('' ,'_', $text);

//          $text=str_replace(' ','',$text);
//    $test=iconv("UTF-8","Windows-1251",$text);
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

if (1||empty($OFF)){
//          $status = file_get_contents("http://{$sms_send_login}:{$sms_send_pass}@gate.iqsms.ru/send/?phone=+7{$data['m_fone']}&text=$test_to_send&sender=DHEBHUK");
          $status=send("gate.iqsms.ru", 80, $sms_send_login, $sms_send_pass, "7".$data['m_fone'], $test_to_send, "DHEBHUK");
          if (strpos($status, 'accepted') > 0){
            $sms_count++;
          }
} else
          $sms_count++;

$dump=1;if ($dump) echo "|status=".$status."|".strpos($status, 'accepted')."|".$test_to_send."|sms_count=".$sms_count."|sms_count_cur=".$sms_count_cur."|<br>";
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
if ($dump) echo "|status=".$status."|".strpos($status, 'accepted')."|".$test_to_send."|sms_count=".$sms_count."|sms_count_cur=".$sms_count_cur."|<br>";
        } else
          $data['f_fone'] = '';
      }
    }

if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

    if ($sms_count_cur < $sms_count) {
      $sql = "INSERT INTO `".TABLE_SMS_LOGS."` (`studless_id`, `student_id`, `date`, `type`, `text`)"
            ." VALUES ('0', '".$student_id."', NOW(), 'm', '".$phones.$test_to_send."');";
if ($dump) echo $sql;
      $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
    }

    $text="";
  }  //  foreach ($array


  $send_OK =  "\n<br>".$lang['sms_mess_send_ok']."(".$sms_count.")";
}  //  if($_REQUEST['action']='sendnote')


$nums_note =$sms_count;
$date = implode('.', array_reverse(explode('-', $date)));

echo <<< EOT

<div align=center> 

<br />
<table id="edit">
  <tbody>
  <tr class="TableHead">
    <th colsapan="2">{$lang['sms_mess_send']}</th>
  </tr>
  <tr>
    <td>{$send_OK}</td>
  </tr>

  <tr>
    <td>Разослано сообщение: "{$note}".</td>
  </tr>


  </tbody>
</table>

<input type="button" value="&nbsp;&nbsp;{$lang['close']}&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" />
</div> 
<br> 


EOT;
