<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                     |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('TEACHER_ZONE', true);
include_once ('../init.php');
include 'header.php';
include_once ('../include/classes.php');
if ($_POST['action']=="update_pass")
{
    $pass=md5($_POST['newpass']);
 db_query("UPDATE `".TABLE_USERS_TEACHERS."` SET passwd='$pass' WHERE teacher_id=".$_SESSION['teacher_id']); 
 $pass_change="<font color='green'>Пароль успешно изменен!</font>";
}

if ($_POST['action']=="add_photo" && $_FILES['uploadfile']['tmp_name']!=='')
{ 
    $res_foto = mysql_query("select photo FROM `".TABLE_USERS_TEACHERS."` WHERE teacher_id='".$_SESSION['teacher_id']."'");
    $row_foto=mysql_fetch_assoc($res_foto);
    

    @unlink("../teacher_photo/".SUBDOMEN."/".$row_foto['photo']);
    @unlink("../teacher_photo/".SUBDOMEN."/sm/".$row_foto['photo']);
    $student_photo = UploadedPhotoFile("../teacher_photo/".SUBDOMEN."/");
   
    $query = mysql_query("UPDATE `".TABLE_USERS_TEACHERS."` SET photo='".$student_photo."' WHERE teacher_id='".$_SESSION['teacher_id']."'");
   if ($query) $photo_change="<font color='green'>Фотография успешно обновлена!</font>";
}


?>
<br />
<div align="center">

<div id="rc"><!-- ПРАВАЯ КОЛОНКА!!! -->
	  <span class="right_col">

<? if ($_GET['act']=='') { ?>
<fieldset><legend>Ваши классы</legend><table width='100%' border='0' cellspacing='3' cellpadding='4' ><tr><td >	 

<table  width="100%">
<thead>
  <tr>
    <th class="rounded-left"><?php echo $lang['class']?></th>
    <th ><?php echo $lang['predmet_per'];?></th>
    <th>
    <th class="rounded-right">&nbsp;</th>
  </tr>
</thead>
<tbody>
<tr>
<?php
  $classes_list = get_classe_list_from_teacher($teacher_id);
  $q=mysql_query("SELECT * FROM `".TABLE_CLASSES."` WHERE teacher_id='".$teacher_id."'");
  if (mysql_num_rows($q)){
    $class_t=mysql_result($q,0,1);
    $letter_t=mysql_result($q,0,2);
  }
  foreach($classes_list as $class) {

  if(($class['class']==$class_t)and($class['letter']==$letter_t)){
  echo '<tr><td style="color: red;"><b>'.$class['class'] ."</b></td><td>$class[discipline]</td><td><a href=\"lessons.php?subject_id=$class[subject_id]\">{$lang['lessons_report']}</a>";
 echo "<td><a href='report_other.php?disp_id={$class['subject_id']}'>{$lang['uspevaemost']}</a></td></tr>";
  }else{
  echo '<tr><td>'.$class['class'] ."</td><td>$class[discipline]</td><td><a href=\"lessons.php?subject_id=$class[subject_id]\">{$lang['lessons_report']}</a>";
  echo "<td><a href='report_other.php?disp_id={$class['subject_id']}'>{$lang['uspevaemost']}</a></td></tr>";
  }
  }
?>
</tr>
</tbody>

</table>
                 </table>  </fieldset> 
  <? } 
 elseif ($_GET['act']=="info") {
     
     include 'information.php';
}

 elseif ($_GET['act']=="service") {
     
     include 'services.php';
}

 elseif ($_GET['act']=="sms_send") {
     
     include 'sms_send_page.php';
}
 elseif ($_GET['act']=="replace") {
     
     include 'replace.php';
}
 elseif ($_GET['act'] == 'pass' )
  {

	 echo"<fieldset>{$pass_change}<form id='fr1' method='post' action=''>
          {$lang['user_login_pass']}: <input type='text' name='newpass'>
          <input type='hidden' value='update_pass' name='action'>
          <input type='submit' value='{$lang['refresh']}'><br>
          </form></fieldset>";
  }
    if ($_GET['act'] == 'ava' )
  {
  	
  	echo "<fieldset>".$photo_change.'<form action="" method="post" enctype="multipart/form-data">
            Выберите файл для загрузки:<br>
  	<input type="hidden" name="action" value="add_photo" />
  	<input type="hidden" name="student_id" value="'.$_SESSION['teacher_id'].'" />
	 Выберите файл: <input type="file" size="15" name="uploadfile" /> <input type="submit" class="button" value="'.$lang['load'].'" />
	  </form><br></fieldset>
	  ';
  	
  }
  ?>
    
    </div>
    
    
    
  </span></div>
	<div id="lc"><!-- ЛЕВАЯ КОЛОНКА!!! -->
	  <span class="right_left">
      <div class="body_d">   
          
          <fieldset><legend>ФИО</legend><table width='100%' border='0' cellspacing='3' cellpadding='4' ><tr><td >
          
          <?php

          $res=mysql_query("SELECT * FROM `".TABLE_USERS_TEACHERS."` WHERE teacher_id=".$teacher_id."");
          $row=mysql_fetch_assoc($res);
          $name=mysql_result($res,0,3);
          $fam=mysql_result($res,0,5);
          $otch=mysql_result($res,0,4);

if ($row['photo']!=='')
  {
  	$teacher_photo ="<img src='../teacher_photo/".SUBDOMEN."/sm/{$row['photo']}' width='150px' hight='150px'>";
  }
  else
  {
  	$teacher_photo ="<img src='../images/nophoto.gif' width='150px' hight='150px'>";
  }
  
  
          print "$teacher_photo<td valign='top'><span class='head_top'><b>Фамилия:</b>".$fam."<br><b>Имя:</b>".$name."<br><b>Отчетсво:</b>".$otch."</span>";
        ?>
            </table></fieldset>
          
          
              <br><br>
              
   <fieldset><legend>Сервисные операции</legend><table width='100%' border='0' cellspacing='3' cellpadding='4' ><tr><td >

                   
             <a href='index.php?act=service'>Загрузка оценок из Экселя</a><br>
             <a href='index.php?act=sms_send'>Отсылка оценок родителям</a><br>
             <a href='index.php?act=replace'>Перевод учеников в следующий класс</a><br>
             <a href='index.php?act=info'>Сообщения ученикам и учителям</a><br>
             <a href='index.php?act=pass'>Сменить пароль</a><br>
             <a href='index.php?act=ava'>Сменить фотографию</a><br>
             
     </table>  </fieldset>             
          
          
          
          
          
          
          
          
<?php

include 'footer.php';
?>