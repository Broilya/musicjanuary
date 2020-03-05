<?php
include_once ('parts/head.php');

/*
$db_config = mysql_query("SELECT * FROM `".TABLE_CONFIG."`");
while ($config = mysql_fetch_array($db_config)) {
  define($config['key_config'], $config['value_config']);
}
*/

$student = get_student($_SESSION['student_id']);
$query="SELECT c.class_id, `class`, `letter`, `first_name`,	`middle_name`, 	`last_name`, `photo`"
      ." FROM `".TABLE_STUDENTS_IN_CLASS."`  as sic"
      ." JOIN `".TABLE_CLASSES."` as c on c.class_id=sic.class_id"
      ." JOIN `".TABLE_USERS_TEACHERS."` as t on t.teacher_id=c.teacher_id"
      ." WHERE sic.student_id='".$student[student_id]."'";
$res=mysql_query($query);
$row=mysql_fetch_array($res);

if ($_POST['action']=="update_pass")
{

 db_query("UPDATE `".TABLE_USERS_STUDENTS."` SET password='".$_POST['newpass']."' WHERE student_id='".$_SESSION['student_id']."'"); 
 $pass_change="<font color='green'>Пароль успешно изменен!</font>";
}

if ($_POST['action']=="add_photo" && $_FILES['uploadfile']['tmp_name']!=='')
{ 
    $res_foto = mysql_query("select photo,update_photo FROM `".TABLE_USERS_STUDENTS."` WHERE student_id='".$_POST['student_id']."'");
    $row_foto=mysql_fetch_assoc($res_foto);
    

    @unlink("student_photo/".SUBDOMEN."/".$row_foto['photo']);
    @unlink("student_photo/".SUBDOMEN."/sm/".$row_foto['photo']);
    $student_photo = UploadedPhotoFile("student_photo/".SUBDOMEN."/");
    $query = mysql_query("UPDATE `".TABLE_USERS_STUDENTS."` SET photo='".$student_photo."', update_photo=".($row_foto['update_photo']+1)." WHERE student_id='".$_POST['student_id']."'");
   if ($query) $photo_change="<font color='green'>Доступно 3 обновления!</font>";
}
?>
<div id="rc"><!-- ПРАВАЯ КОЛОНКА!!! -->
	  <span class="right_col">
	  <?php 
if (isset($_GET['act']))
{
  if ($_GET['act'] == 'ava' )
  {
  	echo "<fieldset><legend>Сменить аватар</legend><table width='100%' border='0' cellspacing='3' cellpadding='4' ><tr><td>";
  	echo $photo_change.'<form action="" method="post" enctype="multipart/form-data">
  	<input type="hidden" name="action" value="add_photo" />
  	<input type="hidden" name="student_id" value="'.$_SESSION['student_id'].'" />
	 Выберите файл: <input type="file" size="15" name="uploadfile" /> <input type="submit" class="button" value="'.$lang['load'].'" />
	  </form><br> ';
	  echo "<br>Перед загрузкой убедитесь что ваша фотография не привышает <b>300Kb</b>, а так же ее формат <b>.jpg .gif .png</b> <br>
	  Обратите внимание что изменение фото ограниченно <u>3 загрузками.</u>";
  	echo "</table></fieldset>";
  }

 elseif ($_GET['act'] == 'pass' )
  {
          echo "<fieldset><legend>Сменить пароль</legend><table width='100%' border='0' cellspacing='3' cellpadding='4' ><tr><td>";
	 echo"{$pass_change}<form id='fr1' method='post' action=''>
          {$lang['user_login_pass']}: <input type='text' name='newpass'>
          <input type='hidden' value='update_pass' name='action'>
          <input type='submit' value='{$lang['refresh']}'><br>
          </form>";
		  echo "<br>Придумайте сложный пароль, который нельзя подобрать:
от 6 до 12 символов — цифры, английские буквы и спецсимволы.";
		  echo "</table></fieldset>";
  }

elseif ($_GET['act'] == 'class' )
  {
	echo "<fieldset><legend>Ваш класс</legend><table width='100%' border='0' cellspacing='3' cellpadding='4' ><tr><td>";
	
echo "Ваша школа: ".NAME_SCHOOL." №".NUM_SCHOOL."<br>";

echo "Класс: {$row['class']}<br><br> {$lang['your_class_ruk_e']}:";
echo "<div style='cursor:pointer;' onmouseover=\"Tip('$teacher_photo <br> {$row['first_name']} {$row['middle_name']} {$row['last_name']}')\" onmouseout=\"UnTip()\">{$row['first_name']} {$row['middle_name']} {$row['last_name']}</div>";    
echo "</table></fieldset>";

	echo "<fieldset><legend>Одноклассники</legend><table width='100%' border='0' cellspacing='3' cellpadding='4' >";
	$class_list=get_class_student($_SESSION['student_id']);
	foreach($class_list as $key=>$value)
	{	$num=$key+1;
		echo "<tr><td>{$num}<td>{$value}";
	}
	echo "</table></fieldset>";

   }
 elseif ($_GET['act'] == 'shedule' )
  {
echo "<fieldset><legend>Домашнее задание:</legend><table width='100%' border='0' cellspacing='3' cellpadding='4' ><tr><td>";
	 require_once("schedul.php");
echo "</table></fieldset>";
  }

	
}
elseif ($_GET['act']=="" )
  {
echo "<fieldset><legend>Баланс:</legend><table width='100%' border='0' cellspacing='3' cellpadding='4' ><tr><td>";
	 require_once("balans4.php");
echo "</table></fieldset>";

echo "<fieldset><legend>Сообщения:</legend><table width='100%' border='0' cellspacing='3' cellpadding='4' ><tr><td>";
	 require_once("information.php");
echo "</table></fieldset>";

echo "<fieldset><legend>СМС:</legend><table width='100%' border='0' cellspacing='3' cellpadding='4' ><tr><td valign='top'>";
	 require_once("balans3.php");
echo "</table></fieldset>";
  }
  
?>
	  </span></div>
	<div id="lc"><!-- ЛЕВАЯ КОЛОНКА!!! -->
	  <span class="right_left">
      <div class="body_d">
	 
<?php
 //include_once ('include/curriculums.php');
 // $quarters = get_quarters_in_year(1);

$student = get_student($_SESSION['student_id']);

 if ($student['update_photo'] < 3 && $student['photo'] !=='') {

$link_photo="<a href='?act=ava'>Изменить фото</a><br><font color=red><small>(Ограничение до ".(3-$student['update_photo'])." изменений)</small></font>";
 
 }
 else
 {
 	$link_photo="";
 }

 echo "<fieldset><legend>ФИО</legend><table width='100%' border='0' cellspacing='3' cellpadding='4' ><tr><td width='100px'>";
if($student['photo'] !=='') { echo "<a class=\"highslide\" onclick=\"return hs.expand(this)\" href=\"student_photo/".SUBDOMEN."/$student[photo]\" title=\"Увеличить фото\"><img src='student_photo/".SUBDOMEN."/sm/$student[photo]' height='150' width='150' border=\"0\"></a>".$link_photo."<td valign='top'>"; }
else
{
	echo "<img src='images/nophoto.gif' border=1 height='100' width='100'>".$link_photo."<td valign='top'>";
}

$query="SELECT c.class_id, `class`, `letter`, `first_name`,	`middle_name`, 	`last_name`, `photo`"
      ." FROM `".TABLE_STUDENTS_IN_CLASS."`  as sic"
      ." JOIN `".TABLE_CLASSES."` as c on c.class_id=sic.class_id"
      ." JOIN `".TABLE_USERS_TEACHERS."` as t on t.teacher_id=c.teacher_id"
      ." WHERE sic.student_id='".$student[student_id]."'";
$res=mysql_query($query);
$row=mysql_fetch_array($res);


if ($row['photo']!=='')
  {
  	$teacher_photo ="<img src=\'../teacher_photo/".SUBDOMEN."/sm/{$row['photo']}\'>";
  }
  else
  {
  	$teacher_photo ="<img src=\'images/nophoto.gif\'>";
  }


echo "Фамилия: $student[last_name]<br> Имя:$student[first_name]<br> Отчетсво:$student[middle_name] </td>";

 



//echo "<tr><td><a href='schedul.php?class_id={$row['class_id']}&TB_iframe=true&height=500&width=600' class='thickbox'>{$lang['dz_show']}</a>";
echo"</td></tr></table><br /></fieldset><br><br>"; 

$date=date("Y-m-d");
echo "<fieldset><legend>Действия</legend><table width='100%' border='0' cellspacing='3' cellpadding='4' ><tr><td>
<ul>
<li><a href='?act=class'>Мой класс</a></li>
<li><a href='grades.php?date=".$date."'>Оценки</a></li>
<li><a href='?act=shedule'>Домашнее задание</a></li>
<li><a href='index.php'>Баланс, СМС и Сообщения</a></li>
<li><a href='?act=ava'>Сменить аватар</a></li>
<li><a href='?act=pass'>Сменить пароль</a></li>
<li><a href='../login.php?action=logout'>Выход 0</a></li>


</ul></table>";

include_once ('parts/foot.php');
?>
	
