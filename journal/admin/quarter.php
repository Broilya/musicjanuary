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
include_once ('../include/curriculums.php');

if (isset($_REQUEST['school_year_id'])) {
	$school_year_id = intval($_REQUEST['school_year_id']);
} else {
  $school_year_id = @intval($_SESSION['schoolyear']);
}

if (isset($_REQUEST['quarter_id'])) {
	$quarter_id = intval($_REQUEST['quarter_id']);
} else {
  $quarter_id = 0;
}

$mode = @$_REQUEST['mode'];

if ($quarter_id == 0 && $mode == '') {
	$mode = 'add';
} elseif ($quarter_id != 0 && $mode == '') {
	$mode = 'update';
}



if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];

  if ($action == 'add' ) {
    if (empty($_POST['quarter_name']) ||  empty($_POST['started']) || empty($_POST['finished']) ) {
      $error = "Не задан период!";
      header('Location: quarter.php?mode=not_success&error='.$error);
      exit();
    }

    $fields[] = "quarter_name='". mysql_escape_string(substr($_POST['quarter_name'], 0, 50))."'";
    $fields[] = "started='".implode('-', array_reverse(explode('.', $_POST['started'])))."'";
    $fields[] = "finished='".implode('-', array_reverse(explode('.', $_POST['finished']))  )."'";
    $fields[] = "quarter_type=".intval($_POST['quarter_type']);
    $fields[] = "school_year_id=".$school_year_id;

    $_POST['current'] = (empty($_POST['current'])) ? 0 : 1; 
    $fields[] = "current='".$_POST['current']."'";
    if (!empty($_POST['current'])) {
      db_query("UPDATE `".TABLE_SCHOOL_QUARTERS."` SET current=0;");
    }

    db_query("INSERT `".TABLE_SCHOOL_QUARTERS."` SET ".implode(', ', $fields));
    header('Location: quarter.php?mode=success_add');
    exit();

  } elseif ($action == 'update') {
    if (empty($_POST['quarter_name']) ||  empty($_POST['started']) || empty($_POST['finished']) ) {
      $error = "Не задан период!";
      header('Location: quarter.php?mode=not_success&error='.$error);
      exit();
    }
    $fields = array();

    $fields[] = "quarter_name='". mysql_escape_string(substr($_POST['quarter_name'], 0, 50))."'";
    $fields[] = "started='".implode('-', array_reverse(explode('.', $_POST['started'])))."'";
    $fields[] = "finished='".implode('-', array_reverse(explode('.', $_POST['finished']))  )."'";
    $fields[] = "quarter_type=".intval($_POST['quarter_type']);

    $_POST['current'] = (empty($_POST['current'])) ? 0 : 1; 
    $fields[] = "current='".$_POST['current']."'";

    if (!empty($_POST['current'])) {
      db_query("UPDATE `".TABLE_SCHOOL_QUARTERS."` SET current=0;");
    }

    db_query($sql = "UPDATE `".TABLE_SCHOOL_QUARTERS."` SET ".implode(', ', $fields).' WHERE quarter_id='.$quarter_id);
    header('Location: quarter.php?mode=success_update');
    exit();

  }
}
  include('../header_dialog.php');
?>

  <body style="margin-left: 0px;	margin-right: 0px;">
<?php

  if ($mode == 'success_update') {
  	echo '<center>'.$lang['info_about_year'].'.<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" /></center>';
  } elseif ($mode == 'success_add') {
  	echo '<center>'.$lang['info_about_added'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;"  onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}"" />
  	&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;'.$lang['continue'].'&nbsp;&nbsp;" onclick="document.location=\'school_year.php\'" /></center>';
  } elseif ($mode == 'not_success') {
  	echo '<center>'.$_REQUEST['error'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;"  onClick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}"" />
  	</center>';
  } elseif ($mode == 'update') {
    $quarter  = get_quarter($quarter_id);
    outQuarterForm($quarter);
  } elseif ($mode == 'add') {
    outQuarterForm();
  }

function outQuarterForm($quarter = null)
{
	global $school_year_id, $quarter_id, $lang;
	echo '
<form action="quarter.php" method="post">';
if (isset($quarter)) {
  echo '<input type="hidden" name="action" value="update" />';
  echo '<input type="hidden" name="quarter_id" value="'.$quarter_id.'" />';
} else {
  echo '<input type="hidden" name="action" value="add" />';
}
echo '<input type="hidden" name="school_year_id" value="'.$school_year_id.'" />';
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
<table align="center" id="edit_in" width="98%">
<tbody>
  <tr>
    <td>'.$lang['period_name'].'<font color="red">*</font></td>
    <td><input type="text" name="quarter_name" id="quarter_name_id" size="50" value="'.(isset($quarter)?$quarter['quarter_name']:'').'" /></td>
  </tr>
<tr><td colspan="2">&nbsp;</td></tr>
  <tr>
    <td>'.$lang['period_start'].'<font color="red">*</font></td>
    <td><input type="text" name="started" id="started_id" value="'.(isset($quarter)?date('d.m.Y', strtotime($quarter['started'])):'').'" /></td>
  </tr>
  <tr>
    <td>'.$lang['period_end'].'<font color="red">*</font></td>
    <td><input type="text" name="finished" id="finished_id" value="'.(isset($quarter)?date('d.m.Y', strtotime($quarter['finished'])):'').'" /></td>
  </tr>

  <tr>
    <td>'.$lang['type'].'<font color="red">*</font></td>
    <td><select name="quarter_type" id="quarter_type_id">
     <option value="1"'.(isset($quarter)?($quarter['quarter_type']==1?' selected="selected"':''):'').'>'.$lang['period_type_u'].'</option>
     <option value="2"'.(isset($quarter)?($quarter['quarter_type']==2?' selected="selected"':''):'').'>'.$lang['period_type_k'].'</option>
     </select></td>
  </tr>

    <tr>
    <td>'.$lang['current_year'].'</td>
    <td align="left"><input style="width:10px;" type="checkbox" name="current" id="current" size="50" value="1" '.($quarter['current']?"checked":'').'" /></td>
  </tr>


  <tr>
    <td colspan="2" align="center">';
if (isset($quarter)) {
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