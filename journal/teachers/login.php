<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


//define('TEACHER_ZONE', true);
  $ROOT_DIR= '../';
include_once ('../init.php');

   foreach($_SESSION as $key => $val) {
     if ($key != 'SUB_DOMEN')
       unset($_SESSION[$key]);
   }

if(!isset($_REQUEST['error'])){$_REQUEST['error'] = '';}

if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
  if ($action == 'login') {
  	$login = mysql_escape_string(substr($_POST['login'], 0, 25));
  	$passwd = md5($_POST['passwd']);
    $teacher = db_get_first_row("SELECT teacher_id FROM `".TABLE_USERS_TEACHERS."` WHERE login='$login' AND passwd='$passwd'");
    if (intval($teacher['teacher_id']) != 0) {
    	$_SESSION['teacher_id'] = $teacher['teacher_id'];
    	header('Location: index.php');
    } else {
    	header('Location: login.php?error=wrong_passwd');
    }
    exit();
  } elseif ($action == 'logout')	{
//    unset($_SESSION['SUB_DOMEN']);
    header('Location: ../');
    exit();
  }

}

include 'header.php';
?>
<div id="rc"><!-- ПРАВАЯ КОЛОНКА!!! -->
	  <span class="right_col">


	  </span></div>
	<div id="lc"><!-- ЛЕВАЯ КОЛОНКА!!! -->
	  <span class="right_left">
      <div class="body_d">
          <center>
<form action="login.php" method="post">
<input type="hidden" name="action" value="login" />
  <table id="rounded-corner" style="width:auto">
    <thead>
    <tr>
      <th class="rounded-left">&nbsp;</th>
      <th colspan="2"><?php echo $lang['teacher_login_auth'];?></th>
      <th class="rounded-right">&nbsp;</th>
    </tr>
    </thead>
    <!-- Вывод сообщения об ощибке пароля или логина -->
     <? if ($_REQUEST['error'] == "wrong_passwd") { ?>
      <tr>
      <td>&nbsp;</td>
      <td colspan="2"><div id="loginform_error"><?php echo $lang['admin_auth_error'];?></div></td>
      <td>&nbsp;</td>
    </tr>	
    <? } ?>
    <tr>
      <td>&nbsp;</td>
      <td><?php echo $lang['login'];?></td>
      <td><input type="login" name="login" value="" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><?php echo $lang['pass'];?></td>
      <td><input type="password" name="passwd" value="" /></td>
      <td>&nbsp;</td>
    </tr>
    <tfoot>
    <tr>
      <td class="rounded-foot-left">&nbsp;</td>
      <td colspan="2" align="center"><input type="submit" value="<?php echo $lang['admin_enter'];?>" /></td>
      <td class="rounded-foot-right">&nbsp;</td>
    </tr>
    </tfoot>
</table>
</form></center>
<?php
include 'footer.php';
?>