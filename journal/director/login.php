<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('DIRECTOR_ZONE', true);
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

    $user = db_get_first_row($sql = "SELECT user_id FROM `".TABLE_USERS."` WHERE login='$login' AND passwd='$passwd' AND  access=2");
   
    if (intval($user['teacher_id']) != 0) {
 
    	$_SESSION['director_id'] = $user['teacher_id'];

    	header('Location: srv.php'); 
    	
    } else {
    	header('Location: login.php?error=wrong_passwd');
    }

    exit();
  } elseif ($action == 'logout')	{
//    unset($_SESSION['SUB_DOMEN']);
    header('Location: ../index.php');
    exit();
  }

}

include 'header.php';
?>
<table width="100%" height="100%">
<tr>
  <td width="50%">&nbsp;</td>
  <td>
<form action="login.php" method="post">
<input type="hidden" name="action" value="login" />
  <table id="rounded-corner" style="width:auto">
    <thead>
    <tr>
      <th class="rounded-left">&nbsp;</th>
      <th colspan="2">Авторизация директора</th>
      <th class="rounded-right">&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <!-- Вывод сообщения об ощибке пароля или логина -->
     <? if ($_REQUEST['error'] == "wrong_passwd") { ?>
      <tr>
      <td>&nbsp;</td>
      <td colspan="2"><div id="loginform_error">Неверный логин, пароль или вы не имеете прав директора!</div></td>
      <td>&nbsp;</td>
    </tr>	
    <? } ?>
    <tr>
      <td>&nbsp;</td>
      <td>Логин</td>
      <td><input type="login" name="login" value="" /></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>Пароль</td>
      <td><input type="password" name="passwd" value="" /></td>
      <td>&nbsp;</td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
      <td class="rounded-foot-left">&nbsp;</td>
      <td colspan="2" align="center"><input type="submit" value="Войти" /></td>
      <td class="rounded-foot-right">&nbsp;</td>
    </tr>
    </tfoot>
</table>
</form>
</td>
</tr>
</table>
</body>
</html>