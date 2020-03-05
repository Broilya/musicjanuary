<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                      |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('ADMIN_ZONE', true);

include_once ('../init.php');
include_once ('../include/curriculums.php');

if (isset($_REQUEST['school_year_id'])) {
	$school_year_id = intval($_REQUEST['school_year_id']);
} else {
  $school_year_id = 0;
}




$mode = @$_REQUEST['mode'];

if ($school_year_id == 0 && $mode == '') {
	$mode = 'add';
} elseif ($school_year_id != 0 && $mode == '') {
	$mode = 'update';
}



if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];

  if ($action == 'add') {
    if (empty($_POST['name_year']) ||  empty($_POST['started']) || empty($_POST['finished']) ) {
      $error = "Не задан период!";
      header('Location: school_year.php?mode=not_success&error='.$error);
      exit();
    }

    $fields[] = "name_year='". mysql_escape_string(substr($_POST['name_year'], 0, 50))."'";
    $fields[] = "started='".implode('-', array_reverse(explode('.', $_POST['started'])))."'";
    $fields[] = "finished='".implode('-', array_reverse(explode('.', $_POST['finished']))  )."'";
    $_POST['current'] = (empty($_POST['current'])) ? 0 : 1; 
    $fields[] = "current='".$_POST['current']."'";
    if (!empty($_POST['current'])) {
      db_query("UPDATE `".TABLE_SCHOOL_YEARS."` SET current=0;");
    }
    db_query("INSERT `".TABLE_SCHOOL_YEARS."` SET ".implode(', ', $fields));
    header('Location: quarter.php?mode=success_add');
    exit();

  } elseif ($action == 'update') {
    if (empty($_POST['name_year']) ||  empty($_POST['started']) || empty($_POST['finished']) ) {
      $error = "Не задан период!";
      header('Location: school_year.php?mode=not_success&error='.$error);
      exit();
    }

    $fields = array();

    $fields[] = "name_year='". mysql_escape_string(substr($_POST['name_year'], 0, 50))."'";
    $fields[] = "started='".implode('-', array_reverse(explode('.', $_POST['started'])))."'";
    $fields[] = "finished='".implode('-', array_reverse(explode('.', $_POST['finished']))  )."'";
    $_POST['current'] = (empty($_POST['current'])) ? 0 : 1; 
    $fields[] = "current='".$_POST['current']."'";
    if (!empty($_POST['current'])) {
      db_query("UPDATE `".TABLE_SCHOOL_YEARS."` SET current=0;");
    }

    db_query($sql = "UPDATE `".TABLE_SCHOOL_YEARS."` SET ".implode(', ', $fields).' WHERE school_year_id='.$school_year_id);
    header('Location: school_year.php?mode=success_update');
    exit();

  }
}
  include('../header_dialog.php');
?>

  <body style="margin-left: 0px;	margin-right: 0px;">
<?php

  if ($mode == 'success_update') {
  	echo '<center>'.$lang['period_info'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" /></center>';
  } elseif ($mode == 'success_add') {
  	echo '<center>'.$lang['new_period_add'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;"  onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" />
  	&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;'.$lang['continue'].'&nbsp;&nbsp;" onclick="document.location=\'school_year.php\'" /></center>';
  } elseif ($mode == 'not_success') {
  	echo '<center>'.$_REQUEST['error'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;"  onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}"" />
  	</center>';
  } elseif ($mode == 'update') {
    $year  = get_school_year($school_year_id);
    outYearForm($year  );
  } elseif ($mode == 'add') {
    outYearForm();
  }

function outYearForm($year = null)
{
	global $school_year_id, $quarter_id, $lang; 
	echo '
<form action="school_year.php" method="post">';
if (isset($year)) {
  echo '<input type="hidden" name="action" value="update" />';
  echo '<input type="hidden" name="school_year_id" value="'.$school_year_id.'" />';
} else {
  echo '<input type="hidden" name="action" value="add" />';
}
echo '

<script type="text/javascript">
	jQuery(function($){

	$.mask.definitions[\'~\']=\'[01]\';
	$.mask.definitions[\'a\']=\'[0123]\';
	$.mask.definitions[\'b\']=\'[12]\';
  $.mask.definitions[\'c\']=\'[09]\';
  $("#started_id").mask("a9.~9.bc99");
  $("#finished_id").mask("a9.~9.bc99");

  });
</script>
<table align="center" id="edit_in">
<tbody>
  <tr>
    <td>'.$lang['period_name'].'<font color="red">*</font></td>
    <td><input type="text" name="name_year" id="name_year_id" size="50" value="'.(isset($year)?$year['name_year']:'').'" /></td>
  </tr>
  
 
<tr><td colspan="2">&nbsp;</td></tr>
  <tr>
    <td>'.$lang['period_start'].'<font color="red">*</font></td>
    <td><input type="text" name="started" id="started_id" value="'.(isset($year)?date('d.m.Y', strtotime($year['started'])):'').'" /></td>
  </tr>
  <tr>
    <td>'.$lang['period_end'].'<font color="red">*</font></td>
    <td><input type="text" name="finished" id="finished_id" value="'.(isset($year)?date('d.m.Y', strtotime($year['finished'])):'').'" /></td>
  </tr>
    <tr>
    <td>'.$lang['current_year'].'</td>
    <td align="left"><input style="width:10px;" type="checkbox" name="current" id="current" size="50" value="1" '.($year['current']?"checked":'').'" /></td>
  </tr>



  <tr>
    <td colspan="2" align="center">';
if (isset($year)) {
	echo '<input type="submit" class="button" value="'.$lang['save'].'" >';
} else {
  echo '<input type="submit" class="button" value="'.$lang['add'].'" >';
}
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" class="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;"  onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();}" /></td>
</tr></tbody></table></form>';
}

?>
  </body>
</html>