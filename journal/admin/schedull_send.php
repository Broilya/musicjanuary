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
        "Д"=>"D","Е"=>"E","Ж"=>"J","З"=>"Z","И"=>"I",
        "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
        "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
        "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
        "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"","Ы"=>"YI","Ь"=>"",
        "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
        "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
        "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", 'і'=>'i', 'ї'=>'i'
    );
    return strtr($str,$tr);
}

include_once ('../init.php');


if (isset($_REQUEST['action']) && $_REQUEST['action']='sendgrade') {
$date=date('Y-m-d');
		
			$date=date('Y-m-d');
			$query_student="SELECT si.class_id, s.* "
    ." FROM `".TABLE_STUDENTS_IN_CLASS."` AS si"
    ." JOIN `".TABLE_USERS_STUDENTS."` AS s ON s.student_id = si.student_id"
    ." WHERE s.email != ''";
 			$students=mysql_query($query_student);
 			while ($row=mysql_fetch_assoc($students)) {
 			
					
		$res2 = db_query("SELECT a. * , d.discipline, s.subject_id, l. * "
    ." FROM `".TABLE_SCHEDULE."` AS a"
    ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` AS d ON d.discipline_id = a.discipline_id"
    ." LEFT JOIN `".TABLE_SUBJECTS."` AS s ON s.discipline_id = a.discipline_id"
    ." LEFT JOIN `".TABLE_LESSONS."` AS l ON s.subject_id = l.subject_id"
    ." WHERE a.class_id = '".$row['class_id']."'"
    ." AND s.class_id = '".$row['class_id']."'"
    ." AND lesson_date = '".$date."'");
		
		
		$text=$lang['sms_send_dz']." {$date}\n";
  while($row2 = mysql_fetch_assoc($res2)) {
$text.=$row2['discipline'].": ".$row2['dz'].";\n";
  
  
   // $text .="$grade[discipline]: $grade[grade]\n";
  } 
  $header=iconv("UTF-8", "windows-1251", $lang['sms_dz_name']);
  $text=iconv("UTF-8", "windows-1251", $text);
   //mail("bart@ua.fm", $header,$text);
  
   mail("{$row['email']}", $header,$text);



}
echo $lang['sms_send_good'];
}
include 'header.php';
$nums_grade = db_get_cell("SELECT COUNT(grade) FROM `".TABLE_STUDENTS_ON_LESSON."` "
    ." INNER JOIN `".TABLE_LESSONS."` ON lessons.lesson_id=students_on_lesson.lesson_id WHERE lessons.lesson_date='".date('Y-m-d')."';");
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
    <th colsapan="2"><?php echo $lang['sms_email']?></th>
  </tr>
  <tr>
    <td><?php echo $lang['sms_send_dz']; echo date('d.m.Y'); ?> </td>
  </tr>
  
  <tr>
	 <td>
	 <form action="schedull_send.php" method="post">
	 <input type="hidden" name="action" value="sendgrade" />
    <?php echo $lang['sms_send_e']?>
	    <input type="submit"  class="button" value=" <?php echo $lang['sms_send']?> " />
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