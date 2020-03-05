<?php
session_start();
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



if (!isset($_SESSION['schoolyear'])) {$_SESSION['schoolyear']='';}
if (!isset($_SESSION['classes'])) {$_SESSION['classes']='';}
if (!isset($_SESSION['schoolyear2'])) {$_SESSION['schoolyear2']='';}
if (!isset($_SESSION['classes2'])) {$_SESSION['classes2']='';}

if(isset($_POST['data'])) {


$query="UPDATE `".TABLE_STUDENTS_IN_CLASS."` set `class_id`={$_POST['classes2']} where `class_id`={$_POST['classes']}";
$res=mysql_query($query);

if ($res) { echo "Ученики успешно переведены в указанный класс"; }



  $_SESSION['schoolyear'] = $_POST['schoolyear'];
  $_SESSION['classes'] = $_POST['classes'];
  
  
    $_SESSION['schoolyear2'] = $_POST['schoolyear2'];
  $_SESSION['classes2'] = $_POST['classes2'];
  session_register('schoolyear');
  session_register('classes');
   session_register('schoolyear2');
  session_register('classes2');

  //exit(header ('Location: lessons.php'));
}


  
//include 'header.php';

?>
<br />
<fieldset><legend>Перевод учеников</legend>
 <table><tr><td align='left'>   
<form action=""  method="post" id="ftheme">
<input name="data" type="hidden" value="load"/>
 
<b><?php echo $lang['ukaz_ych_god'];?>:</b>
  <select name="schoolyear" onchange="ewd_getcontent('ajaxform-classes.php?schoolyear='+this.value, 'classesdiv');">
  <option value=""><?php echo $lang['select'];?></option>
  <?php

   $db_classes = mysql_query("SELECT distinct school_year FROM `".TABLE_CLASSES."` ORDER BY school_year DESC");
   //print "<option>fuck</option>";
   while ($classes2 = mysql_fetch_array($db_classes)) {
    print "<option value='".$classes2['school_year']."'>".$classes2['school_year']."</option>";
    $school_year = $classes2['school_year'];
    }

   ?>
 </select><br/>

  <b><?php echo $lang['class_sours'];?></b>
  <div id="classesdiv" style=" align:left;">
  <select name="classes" onchange="ewd_getcontent('ajaxform-discipline.php?classid='+this.value, 'disciplinesdiv');">
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
 </select> 
 </div>
 <br>
 
 
<b><?php echo $lang['select_new_year_dest'];?></b>
  <select name="schoolyear2" onchange="ewd_getcontent('ajaxform-classes2.php?schoolyear='+this.value, 'classesdiv2');">
  <option value=""><?php echo $lang['select'];?></option>
  <?php

   $db_classes = mysql_query("SELECT distinct school_year FROM `".TABLE_CLASSES."` ORDER BY school_year DESC");
   //print "<option>fuck</option>";
   while ($classes4 = mysql_fetch_array($db_classes)) {
    print "<option value='".$classes4['school_year']."'>".$classes4['school_year']."</option>";
    $school_year = $classes4['school_year'];
    }

   ?>
 </select><br/>
<b><?php echo $lang['select_new_class_dest'];?></b>
  <div id="classesdiv2">
  <select name="classes2" >
  <option value=""><?php echo $lang['select'];?></option>
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

 <br />
 
 
  <input type="submit" value="<?php echo $lang['execute_trans'];?>" />
  </form>
 <br />

<br />
</table>
</fieldset>
<br/> 
<?php
//include 'footer.php';
?>