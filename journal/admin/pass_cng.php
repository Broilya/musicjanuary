<?php
session_start();
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

if (!isset($_SESSION['schoolyear'])) {$_SESSION['schoolyear']='';}
if (!isset($_SESSION['classes'])) {$_SESSION['classes']='';}
if (!isset($_SESSION['discipline'])) {$_SESSION['discipline']='';}
if (!isset($_SESSION['teacher'])) {$_SESSION['teacher']='';}

if(isset($_POST['data'])) {
  $_SESSION['schoolyear'] = $_POST['schoolyear'];
  $_SESSION['classes'] = $_POST['classes'];
  $_SESSION['discipline'] = $_POST['discipline'];
  $_SESSION['teacher'] = $_POST['teacher'];
  
  session_register('schoolyear');
  session_register('classes');
  session_register('discipline');
  session_register('teacher');

  exit(header ('Location: srv.php'));
}

include 'header.php';

?>
<script type="text/javascript" src="../js/wz_tooltip.js"></script>
<div align="center"> 
<br />
<form action="srv.php"  method="post" id="ftheme">
<input name="data" type="hidden" value="load"/>
 <table width="70%" border="0" cellpadding="2" cellspacing="2" bgcolor="#e7e7e7">
 <tr>
 <td width="15%" height="45px"><b><?php echo $lang['year'];?>:</b><br/>
  <select name="schoolyear" onchange="ewd_getcontent('ajaxform-classes.php?schoolyear='+this.value, 'classesdiv');">
  <option value=""><?php echo $lang['select'];?></option>
  <?php

   $db_classes = mysql_query("SELECT school_year FROM `".TABLE_CLASSES."` ORDER BY school_year DESC");
   //print "<option>fuck</option>";
   while ($classes2 = mysql_fetch_array($db_classes)) {
    print "<option value='".$classes2['school_year']."'>".$classes2['school_year']."</option>";
    $school_year = $classes2['school_year'];
    }

   ?>
 </select>
  </td>
  <td width="15%"><b><?php echo $lang['class'];?>:</b><br/>
  <div id="classesdiv">
  <select name="classes">
  <option value=""><?php echo $lang['select'];?></option>
  <?php if($_SESSION['schoolyear']!='') {
    print "SESSION";
    //echo "SELECT class_id, class, letter FROM `".TABLE_CLASSES."` WHERE school_year = '".$_SESSION['schoolyear']."'";
   $db_classes = mysql_query("SELECT class_id, class, letter FROM `".TABLE_CLASSES."` WHERE school_year = '".$_SESSION['schoolyear']."'");
   while ($classes1 = mysql_fetch_array($db_classes)) {

   if ($_SESSION['classes'] == $classes1['class_id']){
 	 $selclass = "selected";
   } else { $selclass = "";}

    echo "<option $selclass value=\"".$classes1['class_id']."\">".$classes1['class']." ".$classes1['letter']."</option>";
   }
  }else{

  }
  ?>
 
 </div>
  </td>
  <td width="10%"><br/>
  <input type="submit" value="<?php echo $lang['data_output'];?>" />
  </td>
 </tr>
 </table>
 </form>
 <br />
 <table  id="rounded-corner" width="100%" align="center">
  <thead>
  <tr class="TableHead">
    <th class="rounded-left">№</th>
    <th><?php echo $lang['fio'];?></th>
    <th><?php echo $lang['login'];?></th>
    <th><?php echo $lang['pass'];?></th>
   <th class="rounded-right" colspan="3">&nbsp;</th>
  </tr>
  </thead>
  <tbody>
<?php  if($_SESSION['schoolyear'] !=='' && $_SESSION['classes'] !=='' ) {
  
//echo "SELECT subject_id FROM `".TABLE_SUBJECTS."` WHERE discipline_id='".$_SESSION['discipline']."' AND teacher_id='".$_SESSION['teacher']."' AND class_id = '".$_SESSION['classes']."'";
  $query = "SELECT * FROM `".TABLE_CLASSES."` as c 
JOIN `".TABLE_STUDENTS_IN_CLASS."` as sc on sc.class_id=c.class_id
JOIN `".TABLE_USERS_STUDENTS."` as s on sc.student_id=s.student_id
where `teacher_id`=".$_SESSION['classes'];
 $res=mysql_query($query);
$n=1;
 //$students=mysql_fetch_assoc($res);
  while ($row=mysql_fetch_assoc($res)) {

  if ($row['student_photo']!=='')
  {
  	$student_photo ="<img src=\'../student_photo/".SUBDOMEN."/sm/$student[student_photo]\'>";
  }
  else
  {
  	$student_photo ="";
  }
  echo "<tr align='center'><td>$n</td><td nowrap=\"nowrap\" align='left'><div style='cursor:pointer;' onmouseover=\"Tip('$student_photo <br>ПИН код: {$row['pin_code']}<br> Адресс: {$roe['address']} <br>Телефон: {$row['phone']}')\" onmouseout=\"UnTip()\">{$row['first_name']} {$row['last_name']}</div></td>";
  print "<td align='left'>".$row['login']."</td><td align='left'>".$row['password']."</td><td>&nbsp;&nbsp;</td>";
  echo '</tr>';
  $n++;
  }}

?>
  </tbody>
  <tfoot>
    	<tr>
       	  <td class="rounded-foot-left">&nbsp;</td>
        	<td>&nbsp;</td>
	        <td>&nbsp;</td>
            <td colspan="3" class="rounded-foot-right">&nbsp;</td>
        </tr>
    </tfoot>

</table>
<br />
</form>
</td>
</tr>
<tr>
<td align="center">
<table border="0" cellspacing="0" cellpadding="0" class="table_menu">
  <tr>
    <td><img src="../images/circle_left_top.gif" alt="" width="6" height="6"></td>
    <td valign="top" class="border_top"><img src="../images/border.gif" alt="" width="1" height="1"></td>
    <td><img src="../images/circle_right_top.gif" alt="" width="6" height="6"></td>
  </tr>
  <tr>
    <td class="border_left">&nbsp;</td>
    <td class="padding" align="center"> <br /><nowrap>
      <nowrap>&copy Роман Зенкин и Евгений Чернышов</nowrap>
    </nowrap>
    <br /><br /></td>
    <td class="border_right">&nbsp;</td>
  </tr>
  <tr>
    <td><img src="../images/circle_left_bottom.gif" alt="" width="6" height="6"></td>
    <td width="99%" valign="bottom" class="border_bottom"><img src="../images/border.gif" alt="" width="1" height="1"></td>
    <td><img src="../images/circle_right_bottom.gif" alt="" width="6" height="6"></td>
  </tr>
</table>
</td>
</tr></table>

</div>
</body>
</html>