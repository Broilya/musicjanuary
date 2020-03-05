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

 <br />
 <table  id="rounded-corner" width="100%" align="center">
  <thead>
  <tr class="TableHead">
    <th width="25" class="rounded-left">№</th>
    <th><?php echo $lang['fio'];?></th>
    <th><?php echo $lang['login'];?></th>
    <th width="125"><?php echo $lang['data_change'];?></th>
   <th width="25" class="rounded-right">&nbsp;</th>
  </tr>
  </thead>
  <tbody>
<?php 
  
//echo "SELECT subject_id FROM `".TABLE_SUBJECTS."` WHERE discipline_id='".$_SESSION['discipline']."' AND teacher_id='".$_SESSION['teacher']."' AND class_id = '".$_SESSION['classes']."'";
  $query = "SELECT * FROM `".TABLE_USERS_TEACHERS."` as c ";


 $res=mysql_query($query);
$n=1;
 //$students=mysql_fetch_assoc($res);
  while ($row=mysql_fetch_assoc($res)) {

  if ($row['student_photo']!=='')
  {
  	$student_photo ="<img src=\'../student_photo/".SUBDOMEN."/sm/{$row['student_photo']}\'>";
  }
  else
  {
  	$student_photo ="";
  }
  echo "<tr align='center'><td>$n</td><td nowrap=\"nowrap\" align='left'>{$row['first_name']} {$row['last_name']}</td>";
  print "<td align='left'>".$row['login']."</td><td><a href='auth_chg2.php?st={$row['teacher_id']}&TB_iframe=true&height=250&width=500' class='thickbox'>{$lang['edit']}</a><td>&nbsp;&nbsp;</td>";
  echo '</tr>';
  $n++;
  }

?>
  </tbody>
  <tfoot>
    	<tr>
       	  <td width="25" class="rounded-foot-left">&nbsp;</td>
	        <td colspan="3">&nbsp;</td>
            <td width="25" class="rounded-foot-right">&nbsp;</td>
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