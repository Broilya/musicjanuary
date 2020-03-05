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
if (!isset($_SESSION['schoolyear2'])) {$_SESSION['schoolyear2']='';}
if (!isset($_SESSION['classes2'])) {$_SESSION['classes2']='';}

if(isset($_POST['data'])) {
	print_r($_POST);
	
  $_SESSION['schoolyear'] = $_POST['schoolyear'];
  $_SESSION['classes'] = $_POST['classes'];
  
  $_SESSION['schoolyear2'] = $_POST['schoolyear2'];
  $_SESSION['classes2'] = $_POST['classes2'];
  
  session_register('schoolyear');
  session_register('classes');
  session_register('schoolyear2');
  session_register('classes2');

  exit(header ('Location: perevod.php'));
}




	
	
	




  
include 'header.php';

?>
<script type="text/javascript" src="../js/wz_tooltip.js"></script>
<div align="center"> 
<br />
<form action="perevod.php"  method="post" id="ftheme">
<input name="data" type="hidden" value="load"/>
 <table width="70%" border="0" cellpadding="2" cellspacing="2" bgcolor="#e7e7e7">
 <tr>
 <td width="15%" height="45px"><b><?php echo $lang['year']?>:</b><br/>
  <select name="schoolyear" onchange="ewd_getcontent('ajaxform-classes.php?schoolyear='+this.value, 'classesdiv');">
  <option value=""><?php echo $lang['select']?></option>
  <?php

   $db_classes = mysql_query("SELECT distinct school_year FROM `".TABLE_CLASSES."` ORDER BY school_year DESC");
   //print "<option>fuck</option>";
   while ($classes2 = mysql_fetch_array($db_classes)) {
    print "<option value='".$classes2['school_year']."'>".$classes2['school_year']."</option>";
    $school_year = $classes2['school_year'];
    }

   ?>
 </select>
  </td>
  
  
  <td width="15%"><b><?php echo $lang['class']?>:</b><br/>
  <div id="classesdiv">
  <select name="classes3" onchange="ewd_getcontent('ajaxform-discipline.php?classid='+this.value, 'disciplinesdiv');">
  <option value=""><?php echo $lang['select']?></option>
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
 </select> 
 </div>
  </td>
  
  
  
  
  
 </tr>
 
 
 <br>


 <tr>
 <td width="15%" height="45px"><b><?php echo $lang['year']?>:</b><br/>
  <select name="schoolyear2" onchange="ewd_getcontent('ajaxform-classes.php?schoolyear='+this.value, 'classesdiv2');">
  <option value=""><?php echo $lang['select']?></option>
  <?php

   $db_classes = mysql_query("SELECT distinct school_year FROM `".TABLE_CLASSES."` ORDER BY school_year DESC");
   //print "<option>fuck</option>";
   while ($classes2 = mysql_fetch_array($db_classes)) {
    print "<option value='".$classes2['school_year']."'>".$classes2['school_year']."</option>";
    $school_year = $classes2['school_year'];
    }

   ?>
 </select>
  </td>
  <td width="15%"><b><?php echo $lang['class']?>:</b><br/>
  <div id="classesdiv2">
  <select name="classes3" >
  <option value=""><?php echo $lang['select']?></option>
  <?php if($_SESSION['schoolyear2']!='') {
    print "SESSION";
    //echo "SELECT class_id, class, letter FROM `".TABLE_CLASSES."` WHERE school_year = '".$_SESSION['schoolyear']."'";
   $db_classes = mysql_query("SELECT class_id, class, letter FROM `".TABLE_CLASSES."` WHERE school_year = '".$_SESSION['schoolyear2']."'");
   while ($classes1 = mysql_fetch_array($db_classes)) {

   if ($_SESSION['classes2'] == $classes1['class_id']){
 	 $selclass = "selected";
   } else { $selclass = "";}

    echo "<option $selclass value=\"".$classes1['class_id']."\">".$classes1['class']." ".$classes1['letter']."</option>";
   }
  }else{

  }
  ?>
 </select> 
 
 </div>
 <input type='submit' value='<?php echo $lang['execute_trans'];?>'>
  </td>
  
 </tr>
 
 
 
 </table>
 </form>
 
 
 
 <br />
<?php  if($_SESSION['schoolyear'] !=='' && $_SESSION['classes'] !=='' && $_SESSION['discipline'] !=='' && $_SESSION['teacher'] !=='') {
  
//echo "SELECT subject_id FROM `".TABLE_SUBJECTS."` WHERE discipline_id='".$_SESSION['discipline']."' AND teacher_id='".$_SESSION['teacher']."' AND class_id = '".$_SESSION['classes']."'";
  $res = db_query("SELECT subject_id FROM `".TABLE_SUBJECTS."` WHERE discipline_id='".$_SESSION['discipline']."' AND teacher_id='".$_SESSION['teacher']."' AND class_id = '".$_SESSION['classes']."'");
  $subject = mysql_fetch_array($res);
  $subject_id=$subject['subject_id']; 
    }
?>

</div> 
<br/> 
<?php

include 'footer.php';
?>