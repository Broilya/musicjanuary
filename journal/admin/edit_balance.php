<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/



define('ADMIN_ZONE', true);

include_once ('../init.php');
include_once ('../include/students.php');
include_once ('../include/classes.php');
include_once ('../include/images.php');



  
  function translit( $cyr_str) {
   $tr = array(
   "Ґ"=>"G","Ё"=>"YO","Є"=>"E","Ї"=>"YI","І"=>"I",
   "і"=>"i","ґ"=>"g","ё"=>"yo","№"=>"#","є"=>"e",
   "ї"=>"yi","А"=>"A","Б"=>"B","В"=>"V","Г"=>"G",
   "Д"=>"D","Е"=>"E","Ж"=>"ZH","З"=>"Z","И"=>"I",
   "Й"=>"Y","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
   "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
   "У"=>"U","Ф"=>"F","Х"=>"H","Ц"=>"TS","Ч"=>"CH",
   "Ш"=>"SH","Щ"=>"SCH","Ъ"=>"'","Ы"=>"YI","Ь"=>"",
   "Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
   "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"zh",
   "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
   "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
   "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
   "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"'",
   "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya"
  );	
  	return strtr($cyr_str,$tr);
  }
  
  function check_login ($login, $imp=NULL) {
  	$login_temp=$login.$imp; 
  	$query="select 1 as good FROM `".TABLE_USERS_STUDENTS."` where login='{$login_temp}'";
  	
  	$res=mysql_query($query);
  	$row=mysql_fetch_array($res);
  	
  	if ($row['good']!='1') {  $temp= $login.$imp; } 
  	else { 
  			if ($imp==NULL) 
  				{ 
  					$add=1;
  				} else 
  				{ $add=$imp;
  					$add++; 
  				}  
  				
  		
  		$temp=check_login($login, $add); 
  	}  
  	return $temp;
  }
  
if ($dump) {echo '<br><pre>$_request=|';print_r($_REQUEST);echo '</pre>|<br>';}  
$class_id   = @intval($_REQUEST['class_id']);
$student_id = @intval($_REQUEST['student_id']);
$balance_id = @intval($_REQUEST['balance_id']);
$mode       = @$_REQUEST['mode'];

if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];

  if ($action == 'delete') {
//echo $id;	
    $query = "DELETE FROM `".TABLE_BALANCE."` WHERE `id`='".$balance_id."'";
//echo $query;

    $res=mysql_query($query);
    $sql="UPDATE `".TABLE_USERS_STUDENTS."`  s SET s.`active`=(SELECT if(sum(b.`summa`) > 0, 1, 0) 
           FROM `".TABLE_BALANCE."` b WHERE b.`student_id`=s.student_id) 
           WHERE `student_id`='".$student_id."';";
    $res=mysql_query($sql);

    $mode = 'update';
  }

  elseif (($action == 'update') && !empty($_REQUEST['date_add']) && ($_REQUEST['date_add'] != "00.00.0000")) {
  	
    $data = array();
    $data['student_operator'] = $_REQUEST['operator'];
    $data['student_id']       = $student_id;
    $data['student_date']     = mysql_escape_string(implode('-', array_reverse(explode('.', $_REQUEST['date_add']))));
    $data['student_balance']  = substr($_REQUEST['balance'], 0, 10)."'";
    $data['student_balance']  = $data['student_balance']*100;

    $sql="SELECT `id`,`operator_id`  FROM `".TABLE_BALANCE."` 
           WHERE `date_add`='".$data['student_date']."' AND `student_id`='".$student_id."' LIMIT 0,1;";
    $res=mysql_query($sql);

    $id = 0;
    if (mysql_num_rows($res) == 1) 
    {
      $row = mysql_fetch_array($res);
      $id = $row['id'];
      $data['student_operator'] = $row['operator_id'];
    }

    $sql="REPLACE INTO `".TABLE_BALANCE."`  (`id`, `student_id`, `date_add`, `summa`, `operator_id`, `nomer`, `date_edit`, `active`) VALUES".
         " ('".$id."', '".$student_id."', '".$data['student_date']."', '".$data['student_balance']."', '".$data['student_operator']."', '".$data['student_nomer']."', NOW(), 1);";

//echo $sql;
    db_query($sql);
//if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

    $active = setStudentActive ($student_id);

    header('Location: edit_balance.php?mode=success_update');
    exit();
  }
}
  include('../header_dialog.php');
?>
  <body style="margin-left: 0px; margin-right: 5px;">
<?php
  if ($student_id != 0 && $mode == '') {
  	$mode = 'update';
  }

  if ($mode == 'success_update') {
    echo '<center>'.$lang['user_balance_good'].'.<br /><br />';
    echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick=" if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" />';
  } elseif ($mode == 'update') {
    $student = db_get_first_row("SELECT student_id, last_name, first_name, middle_name 
                                  FROM `".TABLE_USERS_STUDENTS."` WHERE student_id='".$student_id."';");
    outStudentForm($student);
  }

function outStudentForm($student = null)
{
	global $class_id, $student_id, $lang;
	echo '

<script type="text/javascript">
	jQuery(function($){
	$.mask.definitions[\'~\']=\'[01]\';
	$.mask.definitions[\'a\']=\'[0123]\';
	$.mask.definitions[\'b\']=\'[12]\';
  $.mask.definitions[\'c\']=\'[09]\';
  $("#birthday_id").mask("a9.~9.bc99");
  });
</script>

<script type="text/javascript">
$(document).ready(function() {
	$("#studentForm").validate();
});
</script>

<div align="center">
<form action="edit_balance.php" method="post" id="studentForm" enctype="multipart/form-data">

<input type="hidden" name="action" value="update" />
<input type="hidden" name="class_id" value="'.$class_id.'" />
<input type="hidden" name="student_id" value="'.$student['student_id'].'" />'

."<b>({$student[student_id]}) {$student[last_name]} {$student[first_name]} {$student[middle_name]}</b>"

.'<table id="edit_in">
<thead>
   <tr>
     <th>№</th>
     <th>'.$lang['date_balance'].'</th>
     <th>'.$lang['user_summa'].'</th>
   </tr>

</thead>
<tbody>
 ';

  $balances_list = get_student_balance($student['student_id']);
  $i = 1;
  $balances = 0;
  foreach($balances_list as $balance) {
    $id = $balance['id'];
    echo '
   <tr>
    <td align="right">
    '.$i.'
    </td>
    <td>
    <input type="text" name="date_adds['.$id.']" id="date_adds['.$id.']" value="'.(isset($balance)?implode('.', array_reverse(explode('-', $balance['date_add']))):'').'" size="10" />
    </td>

    <td><input style="text-align:right;" type="text" name="balances['.$id.']" id="balances['.$id.']" value="'.(isset($balance['summa'])?$balance['summa']/100:'0').'" size="10" />
    </td>
    <td><input style="text-align:center;" type="button" value="'.$lang['delete'].'" onclick="'
  ."if (confirm('Вы желаете удалить позицию?')) 
    location='edit_balance.php?action=delete&balance_id=".$id."&student_id=".$student_id."'; else return false;"
    .'" />
    </td>
  </tr>
 ';
    $balances += $balance['summa']/100;
    $i++;
  }

  echo'
   <tr>
    <td align="center" colspan="2">'.$lang['itog'].'&nbsp;</td>
    <td align="right">'.$balances.'&nbsp;</td>
  </tr>

   <tr>
    <td align="center" colspan="2">'.$lang['add'].'&nbsp;</td>
  </tr>

   <tr>
    <td>&nbsp;</td>
    <td>
<script type="text/javascript">
	$(function() {
		$("#date_add").datepicker({
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			yearRange: \'2011:2012\'
		});
	});
	</script>

    <input type="hidden" name="operator" value="'.KASSA.'" />
    <input type="text" name="date_add" id="date_add" value="" size="10" /></td>
    <td><input type="text" name="balance" id="balance" value="" size="10" /></td>
  </tr>
 ';
 
echo '
</tbody>
</table>
<center><br />

<input type="submit" class="button" value="'.$lang['add'].'" />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" class="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" 
onclick="
  if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();}" />
</center>
</form>
 </div>

 ';

}

?>
  </body>
</html>
