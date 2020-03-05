<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
\*****************************************************************************/
define('ADMIN_ZONE', true);

include_once ('../init.php');

$discipline_id = @intval($_REQUEST['discipline_id']);
$mode       = @$_REQUEST['mode'];

  if ($discipline_id == 0 && $mode == '') {
  	$mode = 'add';
  } elseif ($discipline_id != 0 && $mode == '') {
  	$mode = 'update';
  }




if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];

  if ($action == 'add') {
    /* Информация о дисцеплине */
    $fields[] = "discipline='". mysql_escape_string(substr($_POST['discipline'], 0, 100))."'";
    db_query("INSERT `".TABLE_SPR_DISCIPLINES."` SET ".implode(', ', $fields));
    header('Location: discipline.php?mode=success_add');
    exit();
  } elseif ($action == 'update') {
    $fields = array();

    $fields[] = "discipline='". mysql_escape_string(substr($_POST['discipline'], 0, 100))."'";
    db_query($sql ="UPDATE `".TABLE_SPR_DISCIPLINES."` SET ".implode(', ', $fields)." WHERE discipline_id=$discipline_id");
    header('Location: discipline.php?mode=success_update');
    exit();
  }
}
  include('../header_dialog.php');
?>
  <body>
<?php
  if ($mode == 'success_update') {
  	echo '<center>'.$lang['disp_update_goood'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="self.parent.tb_remove();self.parent.location.reload();" /></center>';
  } elseif ($mode == 'success_add') {
  	echo $lang['disp_add_goood'].'<br /><br />';
  	echo '<center><input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="self.parent.tb_remove();self.parent.location.reload();" />
  	&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;'.$lang['continue'].'&nbsp;&nbsp;" onclick="document.location=\'discipline.php\'" /></center>';
  } elseif ($mode == 'update') {
    $discipline = db_get_first_row("SELECT * FROM `".TABLE_SPR_DISCIPLINES."` WHERE discipline_id='".$discipline_id."'");
    outDisciplineForm($discipline);
  } elseif ($mode == 'add') {
    outDisciplineForm();
  }

function outDisciplineForm($discipline = null)
{	global $lang;
	echo '<form action="discipline.php" method="post">
	<input type="hidden" name="discipline_id" value="'.$discipline['discipline_id'].'" />';
	if (isset($discipline)) {
    echo '<input type="hidden" name="action" value="update" />';
	} else {
    echo '<input type="hidden" name="action" value="add" />';
 }
echo '
<table width="100%"
  <tr>
    <td>Название</td>
    <td><input type="text" name="discipline" value="'.(isset($discipline)?$discipline['discipline']:'').'" size="26" /></td>
  </tr>
  <tr>
    <td colspan="2" align="center">';
    if (isset($discipline)) {
    	echo '<input type="submit" value="'.$lang['refresh'].'" />';
    } else {
      echo '<input type="submit" value="'.$lang['add'].'" />';
    }
echo'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="self.parent.tb_remove();self.parent.location.reload();" /></td>
</tr>
</table>
</form>';
}

?>
  </body>
</html>