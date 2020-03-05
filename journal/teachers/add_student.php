<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/



define('TEACHER_ZONE', true);

include_once ('../init.php');
include_once ('../include/classes.php');

function rus2translit($string)
{
    $converter = array(
        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => "'",  'ы' => 'y',   'ъ' => "'",
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => "'",  'Ы' => 'Y',   'Ъ' => "'",
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
    );
    return strtr($string, $converter);
}

function generate_pass(){
  $letter=array('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
  $s='';
  for($i=0;$i<6;$i++){
    $s.=$letter[rand(0,count($letter))];
  }
  return $s;
}
// определяем какой клас ведет учитель
$teacher_class = db_get_first_row("SELECT class_id FROM `".TABLE_CLASSES."` WHERE teacher_id='".$_SESSION['teacher_id']."'");
$class_id = $teacher_class['class_id'];

$student_id = @intval($_REQUEST['student_id']);
$mode       = @$_REQUEST['mode'];

if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];

  if ($action == 'add') {
  
  // Загрузка фото учинека
  	
  	if($_FILES['student_photo']['name']!=='')
    {
	   if(ereg("^(.*)\\.(jpg|gif|png)$", $_FILES['student_photo']['name']))
	   {
	       if (file_exists($_FILES['student_photo']['tmp_name']))
	       {
             $type = substr($_FILES["student_photo"]["name"], -3, 3);
	         $imgname = "student_".date(YmdHis).".".$type;
	         copy($_FILES['student_photo']['tmp_name'], "../student_photo/".SUBDOMEN."/".$imgname);
			          
           }
                  
	   }
    }
		    
    /* Информация о учинеке*/
    
    //запись имени фото в бд
    $fields[] = "photo='".$imgname."'";

    $fields[] = "last_name='". mysql_escape_string(substr($_POST['last_name'], 0, 25))."'";
    $fields[] = "first_name='".mysql_escape_string(substr($_POST['first_name'], 0, 25))."'";
    $fields[] = "middle_name='".mysql_escape_string(substr($_POST['middle_name'], 0, 25))."'";

    $fields[] = "login='".mysql_escape_string(strtolower(substr(rus2translit($_POST['last_name']), 0, 25)))."'";
    $fields[] = "password='".mysql_escape_string(generate_pass())."'";

    $fields[] = "birthday='".mysql_escape_string(implode('-', array_reverse(explode('.', $_POST['birthday']))))."'";
    $fields[] = "address='".mysql_escape_string(substr($_POST['address'], 0, 255))."'";
    $fields[] = "phone='".mysql_escape_string(substr($_POST['phone'], 0, 25))."'";

    /* Информация о родителях*/
    $fields[] = "mother_fio='".mysql_escape_string(substr($_POST['mother_fio'], 0, 50))."'";
    $fields[] = "mother_work_phone='".mysql_escape_string(substr($_POST['mother_work_phone'], 0, 25))."'";
    $fields[] = "mother_cell_phone='".mysql_escape_string(substr($_POST['mother_cell_phone'], 0, 25))."'";

    $fields[] = "father_fio='".mysql_escape_string(substr($_POST['father_fio'], 0, 50))."'";
    $fields[] = "father_work_phone='".mysql_escape_string(substr($_POST['father_work_phone'], 0, 25))."'";
    $fields[] = "father_cell_phone='".mysql_escape_string(substr($_POST['father_cell_phone'], 0, 25))."'";
     $fields[] = "pin_code='".substr($_POST['pin_code'], 0, 25)."'";
    $fields[] = "email='".substr($_POST['email'], 0, 25)."'";

    db_query("INSERT students SET ".implode(', ', $fields));
    $student_id = db_get_insert_id();
    db_query("INSERT students_in_class VALUES ('{$class_id}', '{$student_id}', 0)");
    header('Location: add_student.php?mode=success_add');
    exit();
  } 
}
  include('../header_dialog.php');
?>
  <body style="margin-left: 0px; margin-right: 5px;">
<?php
  if ($student_id == 0 && $mode == '') {
  	$mode = 'add';
  } 

  if ($mode == 'success_add') {
  	echo '<center>'.$lang['new_studer_add'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="self.parent.tb_remove();self.parent.location.reload();" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  	<input type="button" value="&nbsp;&nbsp;'.$lang['continue'].'&nbsp;&nbsp;" onclick="document.location=\'add_student.php?mode=add\'" /></center>';
  } if ($mode == 'add') {
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


<form action="add_student.php" method="post" id="studentForm" enctype="multipart/form-data">';
if (is_null($student)) {
  echo '<input type="hidden" name="action" value="add" />';
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
    <td><label for="lname">'.$lang['familiy'].'</label></td>
    <td><input type="text" name="last_name" class="required" value="'.(isset($student)?$student['last_name']:'').'" size="26" /></td>
  </tr>
  <tr>
    <td>'.$lang['name'].'</td>
    <td><input type="text" name="first_name" class="required" value="'.(isset($student)?$student['first_name']:'').'" size="26" /></td>
  </tr>
  <tr>
 <td>'.$lang['otchesctvo'].'</td>
    <td><input type="text" name="middle_name" class="required" value="'.(isset($student)?$student['middle_name']:'').'" size="26" /></td>
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
  <th class="TableHead">'.$lang['student_mother'].'</th>
</tr>
<tr>
  <td>
<table id="edit_in" width="100%">
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
  <th>'.$lang['student_father'].'</th>
</tr>
<tr>
  <td>
<table id="edit_in" width="100%">
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
    <td><input type="text" name="pin_code" size="7" maxlength="6" value="'.(is_null($student)?rand(100000, 999999):$student['pin_code']).'"></td>
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
<input type="button" class="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="self.parent.tb_remove();self.parent.location.reload();" />
</center>
</form>';

}

?>
  </body>
</html>