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
include_once ('../include/classes.php');
include_once ('../include/students.php');
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
  
  
$class_id   = @intval($_REQUEST['class_id']);
$student_id = @intval($_REQUEST['student_id']);
$mode       = @$_REQUEST['mode'];

if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
  
if ($action == 'del_photo') {
	
	@unlink("../student_photo/".SUBDOMEN."/".$_GET['photo']);
   	@unlink("../student_photo/".SUBDOMEN."/sm/".$_GET['photo']);
         	  
    $query = mysql_query("UPDATE `".TABLE_USERS_STUDENTS."` SET photo='' WHERE student_id='".$_GET['student_id']."'"); 	
}
  if ($action == 'add') {
  
  // Загрузка фото учинека
  $student_photo = UploadedPhotoFile("../student_photo/".SUBDOMEN."/");
  
  /* Информация о учинеке*/
    
    //запись имени фото в бд
    $fields = array();
    $fields[] = "photo='".$student_photo."'";
    
    $last_name = mysql_escape_string(substr($_POST['last_name'], 0, 25));
    $fields[] = "last_name='". mysql_escape_string(substr($_POST['last_name'], 0, 25))."'";
    $fields[] = "first_name='".mysql_escape_string(substr($_POST['first_name'], 0, 25))."'";
    $fields[] = "middle_name='".mysql_escape_string(substr($_POST['middle_name'], 0, 25))."'";
    $fields[] = "birthday='".mysql_escape_string(implode('-', array_reverse(explode('.', $_POST['birthday']))))."'";
    $fields[] = "address='".mysql_escape_string(substr($_POST['address'], 0, 255))."'";
    $fields[] = "phone='".mysql_escape_string(substr($_POST['phone'], 0, 25))."'";

    /* Информация о родителях*/
    $fields[] = "mother_fio='".mysql_escape_string(substr($_POST['mother_fio'], 0, 50))."'";
    $fields[] = "mother_work_phone='".mysql_escape_string(substr($_POST['mother_work_phone'], 0, 25))."'";
    $fields[] = "mother_cell_phone='".mysql_escape_string(substr($_POST['mother_cell_phone'], 0, 25))."'";
    $_POST['mode'] = (empty($_POST['mother_cell_phone'])) ? 0: 1;
    $fields[] = "father_fio='".mysql_escape_string(substr($_POST['father_fio'], 0, 50))."'";
    $fields[] = "father_work_phone='".mysql_escape_string(substr($_POST['father_work_phone'], 0, 25))."'";
    $fields[] = "father_cell_phone='".mysql_escape_string(substr($_POST['father_cell_phone'], 0, 25))."'";
    $_POST['mode'] += (empty($_POST['father_cell_phone'])) ? 0: 2;
    $fields[] = "mode='".(int)$_POST['mode']."'";
    $pin_code = intval(substr($_POST['pin_code'], 0, 6));
    $pin_code = (empty($pin_code)) ? rand(100000,999999) : $pin_code;
    while(1) {
      $sql="SELECT s.`pin_code`  FROM `".TABLE_USERS_STUDENTS."` s"
          ." WHERE s.`pin_code`='".$pin_code."';";
      $pincode=db_get_cell($sql);
      if (empty($pincode)) 
        break;
      $pin_code = rand(100000,999999);
    }

    $fields[] = "pin_code=".$pin_code."";

    $fields[] = "email='".substr($_POST['email'], 0, 25)."'";
    
	//$fields[] = "login='".translit(mysql_escape_string(substr($_POST['last_name'], 0, 25))).".".translit(mysql_escape_string(substr($_POST['first_name'], 0, 25)))."'";
    $login=translit(mysql_escape_string(substr($_POST['last_name'], 0, 25))).".".translit(mysql_escape_string(substr($_POST['first_name'], 0, 25)));
    $login2=check_login($login);
    $fields[]="login='".$login2."'";
    
    	
    
    
	
	
    db_query("INSERT INTO `".TABLE_USERS_STUDENTS."` SET ".implode(', ', $fields));
    $student_id = db_get_insert_id();
    $fields = array();
    $fields[]="login='".$student_id.$last_name."'";
    $fields[] = "password='".substr(md5(rand(100000,999999)), 0, 8)."'";
    db_query("UPDATE `".TABLE_USERS_STUDENTS."` SET ".implode(', ', $fields)." WHERE `student_id`='".$student_id."';");

    db_query("INSERT INTO `".TABLE_STUDENTS_IN_CLASS."` VALUES ($class_id, $student_id, 0)");

    $active = setTestBalance ($student_id);
/*
    if (TEST_DAYS > 0) {
      $data = array();
      $sql = "INSERT INTO `".TABLE_STUDENTS_IN_SERVICE."` (`student_id`, `service_id`, `tarif`, `date_add`)"
            ." SELECT '".$student_id."', s.`service_id`, s.`tarif`, NOW() FROM `".TABLE_BALANCE_SERVICES."` s"
            ." WHERE s.`required` ='1';";
//echo "Iss)".$sql."\n<br>";
      db_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

      $sql = "SELECT sum(ss.`tarif`) FROM `".TABLE_STUDENTS_IN_SERVICE."` ss"
            ." WHERE ss.`student_id`='".$student_id."';";
//echo "Sss)".$sql."\n<br>";
      $tarif_all = db_get_cell($sql);

      $data['student_balance'] = (int)(TEST_DAYS*$tarif_all/30);

      if ($data['student_balance'] > 0) {
        $data['student_operator'] = TESTPAY;
        $data['student_nomer'] = '';
        $balance_id = 'NULL';

        $sql = "REPLACE INTO `".TABLE_BALANCE."`  (`id`, `student_id`, `date_add`, `summa`, `operator_id`, `date_edit`, `active`) VALUES"
              ." ('".$balance_id."', '".$student_id."', NOW(), '".$data['student_balance']."', '".$data['student_operator']."', NOW(), 1);";
//echo "Rb)".$sql."\n<br>";
        db_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
      }
    }  //  if (TEST_DAYS > 0)

    $sql="UPDATE `".TABLE_USERS_STUDENTS."`  s SET s.`active`=(SELECT if(sum(b.`summa`) > 0, 1, 0) FROM `".TABLE_BALANCE."` b WHERE b.`student_id`=s.student_id)"
        ." WHERE s.`student_id`='".$student_id."';";

    $res=mysql_query($sql);
*/
    header('Location: student.php?mode=success_add&class_id='.$class_id);
    exit();
  } elseif ($action == 'update') {
  	
  	// Загрузка фото учинека
   $student_photo = UploadedPhotoFile("../student_photo/".SUBDOMEN."/");
		    
    $fields = array();
    
    /* Информация о учинеке*/
    
    //запись имени фото в бд
    $fields[] = "photo='".$student_photo."'";
    
    $last_name = mysql_escape_string(substr($_POST['last_name'], 0, 25));
    $fields[] = "last_name='". mysql_escape_string(substr($_POST['last_name'], 0, 25))."'";
    $fields[] = "first_name='".mysql_escape_string(substr($_POST['first_name'], 0, 25))."'";
    $fields[] = "middle_name='".mysql_escape_string(substr($_POST['middle_name'], 0, 25))."'";
    $fields[] = "birthday='".mysql_escape_string(implode('-', array_reverse(explode('.', $_POST['birthday']))))."'";
    $fields[] = "address='".mysql_escape_string(substr($_POST['address'], 0, 255))."'";
    $fields[] = "phone='".mysql_escape_string(substr($_POST['phone'], 0, 25))."'";

    /* Информация о родителях*/
    $fields[] = "mother_fio='".mysql_escape_string(substr($_POST['mother_fio'], 0, 50))."'";
    $fields[] = "mother_work_phone='".mysql_escape_string(substr($_POST['mother_work_phone'], 0, 25))."'";
    $fields[] = "mother_cell_phone='".mysql_escape_string(substr($_POST['mother_cell_phone'], 0, 25))."'";
    $_POST['mode'] = (empty($_POST['mother_cell_phone'])) ? 0: 1;
    $fields[] = "father_fio='".mysql_escape_string(substr($_POST['father_fio'], 0, 50))."'";
    $fields[] = "father_work_phone='".mysql_escape_string(substr($_POST['father_work_phone'], 0, 25))."'";
    $fields[] = "father_cell_phone='".mysql_escape_string(substr($_POST['father_cell_phone'], 0, 25))."'";
    $pin_code = intval(substr($_POST['pin_code'], 0, 6));
    $pin_code = (empty($pin_code)) ? rand(100000,999999) : $pin_code;
    while(1) {
      $sql="SELECT s.`pin_code`  FROM `".TABLE_USERS_STUDENTS."` s"
          ." WHERE s.`pin_code`='".$pin_code."';";
      $pincode=db_get_cell($sql);
      if (empty($pincode)) 
        break;
      $pin_code = rand(100000,999999);
    }

    $fields[] = "pin_code=".$pin_code."";
    $fields[] = "email='".substr($_POST['email'], 0, 25)."'";
    $_POST['mode'] += (empty($_POST['father_cell_phone'])) ? 0: 2;
    $fields[] = "mode='".(int)$_POST['mode']."'";

    db_query("UPDATE `".TABLE_USERS_STUDENTS."` SET ".implode(', ', $fields)." WHERE student_id='".$student_id."'");
    header('Location: student.php?mode=success_update');
    exit();
  }
}
  include('../header_dialog.php');
?>
  <body style="margin-left: 0px; margin-right: 5px;">
<?php
  if ($student_id == 0 && $mode == '') {
  	$mode = 'add';
  } elseif ($student_id != 0 && $mode == '') {
  	$mode = 'update';
  }

  if ($mode == 'success_update') {
  	echo '<center>'.$lang['user_update_login_good'].'.<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" />';
  } elseif ($mode == 'success_add') {
  	echo '<center>'.$lang['new_studer_add'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  	<input type="button" value="&nbsp;&nbsp;'.$lang['continue'].'&nbsp;&nbsp;" onclick="document.location=\'student.php?class_id='.$_REQUEST['class_id'].'&mode=add\'" /></center>';
  } elseif ($mode == 'update') {
    $student = db_get_first_row("SELECT * FROM `".TABLE_USERS_STUDENTS."` WHERE student_id='".$student_id."'");
    outStudentForm($student);
  } elseif ($mode == 'add') {
    outStudentForm();
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
  $("#phone_id").mask("(999) 999-99-99");
  $("#mother_work_phone_id").mask("(999) 999-99-99");
  });
</script>

<script type="text/javascript">
$(document).ready(function() {
	$("#studentForm").validate();
});
</script>


<form action="student.php" method="post" id="studentForm" enctype="multipart/form-data">';
if (is_null($student)) {
  echo '<input type="hidden" name="action" value="add" />';
          while(1) {
            $pin_code = rand(100000,999999);
            $sql="SELECT s.`pin_code`  FROM `".TABLE_USERS_STUDENTS."` s"
                ." WHERE s.`pin_code`='".$pin_code."';";
            $pin_code=db_get_cell($sql);
            if (empty($pin_code)) 
              break;
          }


} else {
	echo '<input type="hidden" name="action" value="update" />';
}
echo '<input type="hidden" name="class_id" value="'.$class_id.'" />
<input type="hidden" name="student_id" value="'.$student['student_id'].'" />

<table width="100%" id="edit">
<tbody>
  <tr class="TableHead" valign="top" width="100%">
    <th width="50%">'.$lang['student_data_v'].'</th>
    <th width="50%">'.$lang['student_roditel_v'].'</th>
  </tr>
  <tr>
  <td rowspan="4">
<table id="edit_in">
<tbody>
  <tr>
    <td><label for="lname">'.$lang['familiy'].'</label> (*)</td>
    <td><input id ="lname" type="text" name="last_name" class="required" value="'.(isset($student)?$student['last_name']:'').'" size="26" /></td>
  </tr>
  <tr>
    <td>'.$lang['name'].' (*)</td>
    <td><input type="text" name="first_name" class="required" value="'.(isset($student)?$student['first_name']:'').'" size="26" /></td>
  </tr>
  <tr>
 <td>'.$lang['otchesctvo'].'</td>
    <td><input type="text" name="middle_name"  value="'.(isset($student)?$student['middle_name']:'').'" size="26" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
     <td>'.$lang['date_of_birth'].'</td>
    <td>
<!--script type="text/javascript">
	$(function() {
		$("#birthday_id").datepicker({
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			yearRange: \'1990:2010\'
		});
	});
	</script-->

    <input type="text" name="birthday" id="birthday_id" value="'.(isset($student)?implode('.', array_reverse(explode('-', $student['birthday']))):'').'" size="26" /></td>
  </tr>
  <tr>
     <td>'.$lang['telephone_user'].'</td>
    <td><input type="text" name="phone" id="phone_id" value="'.(isset($student['phone'])?$student['phone']:'').'" size="26" /></td>
  </tr>
  <tr>
    <td>'.$lang['adress_student'].'</td>
    <td><textarea name="address" id="address_id" rows="4">'.(isset($student['address'])?$student['address']:'').'</textarea></td>
  </tr>
  <tr>
   <td>'.$lang['foto'].'</td>';
    
    // Фото
    
    if ($student['photo']=='')
    {
       echo '<td><input type="file" size="15" name="uploadfile" /></td>';
    }
	// Форма загрузки фото
    else
    { echo '<td><img src="../student_photo/'.SUBDOMEN.'/sm/'.$student['photo'].'" border="0"><br>
	   <a href="student.php?action=del_photo&student_id='.$student['student_id'].'&photo='.$student['photo'].'">'.$lang['delete_foto'].'</a></td>';	
     
    }
    
 
 echo'</tr>
</tbody>
</table>
  </td>
  <th class="TableHead">'.$lang['student__mother'].'</th>
</tr>
<tr>
  <td>
<table id="edit_in" width="100%">
<tr><td>Статус</td><td><select name="status_1" id="status_1"><option value="0">Не указан</option><option value="1">мама</option><option value="2">папа</option><option value="3">бабушка</option><option value="4">дедушка</option><option value="5">брат</option><option value="14">воспитатель</option><option value="12">дядя</option><option value="6">сестра</option><option value="11">тётя</option></select></td></tr>

  <tr>
  <td>'.$lang['student_mother_fio'].'</td>
  <td><input type="text" name="mother_fio" value="'.(isset($student['mother_fio'])?$student['mother_fio']:'').'" /></td>
  </tr>
  <tr>
    <td>'.$lang['student_mother_rub_fone'].'</td>
    <td><input type="text" name="mother_work_phone" id="mother_work_phone_id" value="'.(isset($student['mother_work_phone'])?$student['mother_work_phone']:'').'" /></td>
  </tr>
  <tr>
    <td>'.$lang['student_mother_sel_fone'].'</td>
    <td><input type="text" name="mother_cell_phone" value="'.(isset($student['mother_cell_phone'])?$student['mother_cell_phone']:'').'" /></td>
  </tr>
</table>
  </td>
</tr>
<tr class="TableHead">
  <th>'.$lang['student__father'].'</th>
</tr>
<tr>
  <td>
<table id="edit_in" width="100%">
<tr><td>Статус</td><td><select name="status_2" id="status_2"><option value="0">Не указан</option><option value="1">мама</option><option value="2">папа</option><option value="3">бабушка</option><option value="4">дедушка</option><option value="5">брат</option><option value="14">воспитатель</option><option value="12">дядя</option><option value="6">сестра</option><option value="11">тётя</option></select></td></tr>
  <tr>
    <td>'.$lang['father_fio'].'</td>
    <td><input type="text" name="father_fio" value="'.(isset($student['father_fio'])?$student['father_fio']:'').'" /></td>
  </tr>
  <tr>
    <td>'.$lang['father_rab_fone'].'</td>
    <td><input type="text" name="father_work_phone" value="'.(isset($student['father_work_phone'])?$student['father_work_phone']:'').'" /></td>
  </tr>
  <tr>
    <td>'.$lang['student_mother_sel_fone'].'</td>
    <td><input type="text" name="father_cell_phone" value="'.(isset($student['father_cell_phone'])?$student['father_cell_phone']:'').'" /></td>
  </tr>
</table>
  </td>
</tr>
<tr>
  <td colspan="2">

<table width="100%" id="edit_in">
  <tr>
    <td>'.$lang['pin'].'</td>
    <td><input type="text" name="pin_code" size="7" maxlength="6" value="'.(is_null($student)? $pin_code : $student['pin_code']).'"></td>
    <td>'.$lang['email'].'</td>
    <td><input type="text" name="email" class="email" value="'.(isset($student['email'])?$student['email']:'').'">
  </tr>
</table>

  </td>
</tr>
</tbody>
</table>
<center><br />';
if (is_null($student)) {
  echo '<input type="submit" class="button" value="'.$lang['add'].'" />';
} else {
	echo '<input type="submit" class="button" value="'.$lang['refresh'].'" />';
}
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" class="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();}" />
</center>
</form>';
}

?>
  </body>
</html>