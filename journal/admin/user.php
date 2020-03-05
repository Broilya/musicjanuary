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

$user_id   = @intval($_REQUEST['user_id']);
$mode       = @$_REQUEST['mode'];

    if ((SUPERADMINID != $_SESSION['admin_id']) && ($user_id == SUPERADMINID)) {
      $mode='noadmin_update';
    }

if ($user_id == 0 && $mode == '') {
	$mode = 'add';
} elseif ($user_id != 0 && $mode == '') {
	$mode = 'update';
}



if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];

  if ($action == 'add') {
    $fields = array();
    $fields['login'] = substr($_POST['login'], 0, 25);
    $fields['passwd'] = md5($_POST['passwd']);
    $fields['last_name'] = substr($_POST['last_name'], 0, 25);
    $fields['first_name'] = substr($_POST['first_name'], 0, 25);
    $fields['middle_name'] = substr($_POST['middle_name'], 0, 25);
    $fields['access'] = intval($_POST['access']);

    db_array2insert(TABLE_USERS, $fields);
    header('Location: user.php?mode=success_add');
    exit();
  } elseif ($action == 'update') {
    $fields = array();
    $fields['login'] = substr($_POST['login'], 0, 25);
    $fields['passwd'] = md5($_POST['passwd']);
    $fields['last_name'] = substr($_POST['last_name'], 0, 25);
    $fields['first_name'] = substr($_POST['first_name'], 0, 25);
    $fields['middle_name'] = substr($_POST['middle_name'], 0, 25);
//    $fields['access'] = intval($_POST['access']);
    if ((SUPERADMINID == $_SESSION['admin_id']) || ($user_id != SUPERADMINID)){
      db_array2update(TABLE_USERS, $fields,"user_id='".$user_id."'");
      header('Location: user.php?mode=success_update');
    } else {
      header('Location: user.php?mode=noadmin_update');
    }
    exit();
  }
}
  include('../header_dialog.php');
?>
  <body>
<?php

  if ($mode == 'success_update') {
  	echo '<center>'.$lang['information_update_good'].'.<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" />';
  } elseif ($mode == 'success_add') {
  	echo '<center>'.$lang['new_user_add_good'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" /></center>';
  } elseif ($mode == 'noadmin_update') {
  	echo '<center style="color:red;">'.$lang['noadmin_update'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" /></center>';
  } elseif ($mode == 'update') {
    $user = db_get_first_row("SELECT * FROM `".TABLE_USERS."` WHERE user_id='".$user_id."'");
    outUserForm($user);
  } elseif ($mode == 'add') {
    outUserForm();
  }

function outUserForm($user = null)
{
	global $class_id, $student_id, $lang;
	echo '
<form action="user.php" method="post">';
if (is_null($user)) {
  echo '<input type="hidden" name="action" value="add" />';
} else {
	echo '<input type="hidden" name="action" value="update" />';
}
echo '<input type="hidden" name="user_id" value="'.$user['user_id'].'" />

<table border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>'.$lang['login'].'</td>
    <td><input type="text" name="login" value="'.(isset($user)?$user['login']:'').'"'.(isset($user)?' readonly="readonly"':'').' size="26" /></td>
  </tr>
  <tr>
    <td>'.$lang['pass'].'</td>
    <td><input type="password" name="passwd" value="" size="26" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>'.$lang['familiy'].'</td>
    <td><input type="text" name="last_name" value="'.(isset($user)?$user['last_name']:'').'" size="26" /></td>
  </tr>
  <tr>
    <td>'.$lang['name'].'</td>
    <td><input type="text" name="first_name" value="'.(isset($user)?$user['first_name']:'').'" size="26" /></td>
  </tr>
  <tr>
    <td>'.$lang['otchesctvo'].'</td>
    <td><input type="text" name="middle_name" value="'.(isset($user)?$user['middle_name']:'').'" size="26" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>'.$lang['acsess'].'</td>
    <td>
      <select name="access">
        <option value="1"'.((isset($user)&&$user['access']==1)?' selected="selected"':'').'>'.$lang['administrator'].'</option>
        <option value="2" >'.$lang['ac3'].'</option>
      </select>
  </tr>
</table>
<center><br>';
if (is_null($user)) {
  echo '<input type="submit" value="'.$lang['add'].'" />';
} else {
	echo '<input type="submit" value="'.$lang['refresh'].'" />';
}
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();}" />
</center>
</form>';
}

?>
  </body>
</html>