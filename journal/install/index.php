<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

session_start();

function print_head()
{
?>
<html>
  <head>
    <title>Установка школьного журнала</title>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <script type="text/javascript" src="thickbox.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
  </head>
  <body>
  <br />
  <br />
<div align="center">
<?php
}

if (isset($_REQUEST['step'])) {
	$step = $_REQUEST['step'];
} else {
  $step = 1;
}

if ($step == 1) {
print_head();
?>
  <td width="50%" valign="top">&nbsp;</td>
  <td>
Вас приветсвует прграммы установки школьного журнала, для продолжения нажмите Далее<br /><br />

<input type="button" value="Далее" onClick="javascript:document.location='index.php?step=2';" />
</td>
</tr>
</table>

<?php
} elseif ($step == 2) {
print_head();
?>
<form action="index.php" method="post">
<input type="hidden" name="step" value="3" />
<table align="center">
  <tr>
    <td>Настройки базы данных:</td>
    <td></td>
  </tr>
  <tr>
    <td>Сервер</td>
    <td><input type="text" name="db_server" value="localhost" /></td>
  </tr>
  <tr>
    <td>Логин</td>
    <td><input type="text" name="db_login" /></td>
  </tr>
  <tr>
    <td>Пароль</td>
    <td><input type="text" name="db_passwd" /></td>
  </tr>
  <tr>
    <td>База данных</td>
    <td><input type="text" name="db_name" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>Алминистратор</td>
    <td><input type="text" name="user_name" /></td>
  </tr>
  <tr>
    <td>Пароль</td>
    <td><input type="text" name="user_passswd" /></td>
  </tr>
</table>
  <tr>
    <td colspan="2" align="center">
      <input type="submit" value="Далее" />
    </td>
  </tr>
</form>


<?php
} elseif ($step == 3) {
  $_SESSION['db_server'] = $_POST['db_server'];
  $_SESSION['db_login'] = $_POST['db_login'];
  $_SESSION['db_passwd'] = $_POST['db_passwd'];
  $_SESSION['db_name'] = $_POST['db_name'];
  $_SESSION['user_name'] = $_POST['user_name'];
  $_SESSION['password'] = $_POST['user_passswd'];
  
  $connect = mysql_connect($_SESSION['db_server'], $_SESSION['db_login'], $_SESSION['db_passwd']);
  mysql_select_db($_SESSION['db_name']) ;

  include_once dirname(__FILE__).'/mysql_db.php';
  include dirname(__FILE__).'/create_tables.php';

  db_query("INSERT INTO sch_users (login, passwd, first_name, middle_name, last_name, access) VALUES ('".$_SESSION['user_name']."', '".md5($_SESSION['password'])."', '', '', '', 1);");
  
  header('Location: index.php?step=4');

} elseif ($step == 4) {
print_head();

@chmod("student_photo", 0777);
@chmod("student_photo/sm", 0777);
@chmod("teacher_photo", 0777);
@chmod("teacher_photo/sm", 0777);

$config_file= fopen("../config.php","w+");

  if(!$config_file) { 
    echo("Ошибка открытия файла config.php"); 
 } else {  
   
   $config_txt = '<?php
   function setLocal($local = array("int", "local")) {
    $_LOCAL = (is_array($local)) ? 
       (in_array(array_pop(explode(".", $_SERVER["SERVER_NAME"])), $local) ? true : false) : 
       ( (($local === true) || ($local === 1))? true : false);


    define("LOCAL", $_LOCAL);
}
   setLocal();
 
   
   $db_host = "'.$_SESSION['db_server'].'";
   $db_user = "'.$_SESSION['db_login'].'";
   $db_passwd = "'.$_SESSION['db_passwd'].'";
   $db_base = "'.$_SESSION['db_name'].'"; 
   
   $sms_send_login="ikBaks";
   $sms_send_pass="111987";
   
    define("PREFIX", "sch_");
  define("TABLE_BALANCE",                PREFIX."balance");
  define("TABLE_BALANCE_OPERATOR",       PREFIX."operator");
  define("TABLE_BALANCE_SERVICES",       PREFIX."services");
  define("TABLE_CLASSES",                PREFIX."classes");                
  define("TABLE_CLASSES_IN_GROUPS",      PREFIX."classes_in_groups");
  define("TABLE_CONFIG",                 PREFIX."config");                 
  define("TABLE_INFORMATION",            PREFIX."information");            
  define("TABLE_LESSONS",                PREFIX."lessons");                
  define("TABLE_SCHEDULE",               PREFIX."schedule");               
  define("TABLE_SCHOOL_QUARTERS",        PREFIX."quarters");               
  define("TABLE_SCHOOL_YEARS",           PREFIX."school_years");           
  define("TABLE_SMS_LOGS",               PREFIX."sms_logs");
  define("TABLE_SPR_DISCIPLINES",        PREFIX."disciplines");            
  define("TABLE_SPR_GROUPS",             PREFIX."groups");
  define("TABLE_SPR_RELATIVES",          PREFIX."relatives");
  define("TABLE_STUDENTS_IN_CLASS",      PREFIX."students_in_class");      
  define("TABLE_STUDENTS_IN_GROUPS",     PREFIX."students_in_groups");
  define("TABLE_STUDENTS_IN_PARENT",     PREFIX."students_in_parent");
  define("TABLE_STUDENTS_IN_SERVICE",    PREFIX."students_in_service");
  define("TABLE_STUDENTS_ON_LESSON",     PREFIX."students_on_lesson");     
  define("TABLE_SUBJECTS",               PREFIX."subjects");               
  define("TABLE_USERS",                  PREFIX."users");                  
  define("TABLE_USERS_PARENTS",          PREFIX."parents");
  define("TABLE_USERS_STUDENTS",         PREFIX."students");               
  define("TABLE_USERS_TEACHERS",         PREFIX."teachers");               


return;
   
?>';
   fwrite($config_file, $config_txt); 
   fclose($config_file);
 }
?>
<center>
Установка успешно завершена.
<br /><br />
<b>Внимание:</b> проверьте права на запись (chmod 0777) для следующих папок:<br />
student_photo<br />
student_photo/sm<br />
teacher_photo<br />
teacher_photo/sm<br />
<br />
<font color="red">Удалите файл install.php</font>
<br />
</center>
<?php
}
?>
<br />
<div align="center">
<br />
<table border="0" cellspacing="0" cellpadding="0" class="table_menu">
  <tr>
    <td><img src="images/circle_left_top.gif" alt="" width="6" height="6"></td>
    <td valign="top" class="border_top"><img src="images/border.gif" alt="" width="1" height="1"></td>
    <td><img src="images/circle_right_top.gif" alt="" width="6" height="6"></td>
  </tr>
  <tr>
    <td class="border_left">&nbsp;</td>
    <td class="padding" align="center"> <br /><nowrap>Поддержка: <a href="http://schoole.ru/">www.schoole.ru</a></nowrap><br /><br /></td>
    <td class="border_right">&nbsp;</td>
  </tr>
  <tr>
    <td><img src="images/circle_left_bottom.gif" alt="" width="6" height="6"></td>
    <td width="99%" valign="bottom" class="border_bottom"><img src="images/border.gif" alt="" width="1" height="1"></td>
    <td><img src="images/circle_right_bottom.gif" alt="" width="6" height="6"></td>
  </tr>
</table>
</div>
</div>
  </body>
</html>