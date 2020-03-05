<?php
session_start();   
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


ini_set("display_errors","15");


include_once 'include/mysql_db.php';
include_once 'config.php';

if (!isset($ROOT_DIR))
  if (defined('TEACHER_ZONE') || defined('ADMIN_ZONE') || 
      defined('STUDENT_ZONE') || defined('PARENT_ZONE')) {
    $ROOT_DIR= '../';
  } else {
    $ROOT_DIR= './';
  }
//echo "|".$ROOT_DIR.'student_photo/'.SUBDOMEN."|";
  if (!is_dir($ROOT_DIR.'student_photo/'.SUBDOMEN)) {
    mkdir($ROOT_DIR.'student_photo/'.SUBDOMEN, 0777);
    chmod($ROOT_DIR.'student_photo/'.SUBDOMEN, 0777);
    mkdir($ROOT_DIR.'student_photo/'.SUBDOMEN.'/sm', 0777);
    chmod($ROOT_DIR.'student_photo/'.SUBDOMEN.'/sm', 0777);
  }
//echo "|".$ROOT_DIR.'teacher_photo/'.SUBDOMEN."|";
  if (!is_dir($ROOT_DIR.'teacher_photo/'.SUBDOMEN)) {
    mkdir($ROOT_DIR.'teacher_photo/'.SUBDOMEN, 0777);
    chmod($ROOT_DIR.'teacher_photo/'.SUBDOMEN, 0777);
    mkdir($ROOT_DIR.'teacher_photo/'.SUBDOMEN.'/sm', 0777);
    chmod($ROOT_DIR.'teacher_photo/'.SUBDOMEN.'/sm', 0777);
  }

if($dump) echo "3) $db_host, $db_user, $db_passwd, $db_base";
$link0 = db_connect($db_host, $db_user, $db_passwd, $db_base);


$db_config = mysql_query("SELECT * FROM `".TABLE_CONFIG."`");
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
while ($config = mysql_fetch_array($db_config)) {
  define($config['key_config'], $config['value_config']);
}

$user = db_get_first_row($sql = "SELECT user_id FROM `".TABLE_USERS."` WHERE login='admin' AND access=1");
define('SUPERADMINID', $user['user_id']);

/*
$query="select value_config FROM `".TABLE_CONFIG."` where key_config='LANG'";
$res=mysql_query($query);
$row=mysql_fetch_array($res);
*/
$language_index = LANG;

if(isset($_GET['deflang']))$_SESSION['def_lang']= $_GET['deflang'];

if (isset($_SESSION['def_lang']))
  $language_index=$_SESSION['def_lang'];

if (is_file("language/lang_{$language_index}.php"))
  include_once ("language/lang_{$language_index}.php"); 
else
  include_once ("language/lang_ru.php"); 

if (defined('TEACHER_ZONE')) {
  if (!isset($_SESSION['teacher_id'])) {
  	header('Location: login.php');
  } else {
    $teacher_id = $_SESSION['teacher_id'];
  }
}
elseif (defined('ADMIN_ZONE')) {
  if (!isset($_SESSION['admin_id'])) {
  	header('Location: login.php');
echo  '$admin_id ='.$admin_id ;
  } else {
    $admin_id = $_SESSION['admin_id'];
  }
}
elseif (defined('PARENT_ZONE')) {
  if (!isset($_SESSION['parent_id'])) {
  	header('Location: login.php');
  } else {
    $parent_id = $_SESSION['parent_id'];
  }
}
elseif (defined('STUDENT_ZONE')) {
  if (!isset($_SESSION['student_id'])) {
  	header('Location: index.php');
  } else {
    $student_id = $_SESSION['student_id'];
  }
}

//echo "SUBDOMEN=".SUBDOMEN;echo "; session_id=".session_id().'; $_SESSION=';print_r($_SESSION);

//echo  '$admin_id ='.$admin_id.'; $teacher_id ='.$teacher_id.'; $parent_id ='.$parent_id.'; $student_id ='.$student_id ;

?>