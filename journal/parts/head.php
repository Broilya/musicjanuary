<?php
if (!isset($ROOT_DIR))
  if (defined('TEACHER_ZONE') || defined('ADMIN_ZONE') || 
      defined('STUDENT_ZONE') || defined('PARENT_ZONE')) {
    $ROOT_DIR= '../';
  } else {
    $ROOT_DIR= './';
  }

include_once ($ROOT_DIR.'init.php');
include_once ($ROOT_DIR.'include/students.php');
include_once ($ROOT_DIR.'include/classes.php');
include_once ($ROOT_DIR.'include/images.php');

//print_r($_SERVER); 
/*
if(($_SESSION['student_id']=="" and ($_SERVER['PHP_SELF']!='/auth.php' and
$_SERVER['PHP_SELF']!='/about_as.php' and
$_SERVER['PHP_SELF']!='/oferta.php' and
$_SERVER['PHP_SELF']!='/feedback.php' ) ) ) { header("Location: auth.php");}
if(($_SESSION['student_id']!="" and $_SESSION['blocked']==0 and ($_SERVER['REQUEST_URI']!='/index.php' ))) { header("Location: index.php");}
*/
$dump=0;if ($dump) {echo '|$_GET=|';print_r($_GET);}
$dump=0;if ($dump) {echo '|$_SESSION=|';print_r($_SESSION);}

$PHP_SELF = str_replace( '/journal', '', $_SERVER['PHP_SELF']);
$ACCEPT = array('/auth.php', '/about_as.php', '/oferta.php', '/feedback.php');
//echo "|".$_SESSION['student_id']."|".$_SERVER['PHP_SELF']."|".$PHP_SELF."|".in_array($PHP_SELF, $ACCEPT)."<br>";
if(($_SESSION['student_id']=="") and !in_array($PHP_SELF, $ACCEPT)) { 

  header("Location: auth.php");
}


if(($_SESSION['student_id']!="" and $_SESSION['blocked']==0 and (!strpos($_SERVER['REQUEST_URI'], 'index.php') ))) { 
      $student = db_get_first_row("SELECT student_id,active FROM `".TABLE_USERS_STUDENTS."` WHERE student_id='".$_SESSION['student_id']."';");
      if ($student) {
        $_SESSION['student_id'] = $student['student_id'];
        $_SESSION['blocked'] = $student['active'];
      }
  if ($_SESSION['blocked']==0)
    header("Location: index.php");
}
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
<title>Страница ученика <?=NAME_SCHOOL;?></title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
<style type="text/css">
<!--
.right_left {height:500px; width:50%; padding-left:10px;padding-right:15px; }
.right_col {height:500px; width:100%; padding-left:80px;}
-->
</style>
</head>
    
<body>
<?php $date=date("Y-m-d");?>
<div id="top"><div id="header">
	<div id="pin04"><a href="oferta.php"><img src="img/pin04.png" width="116" height="121" alt="Оферта" border="0"></a></div>
	<div id="pin03"><a href="feedback.php"><img src="img/pin03.png" width="117" height="121" alt="Связь с нами" border="0"></a></div>
	<div id="pin02"><a href="about_as.php"><img src="img/pin02.png" width="116" height="121" alt="О системе" border="0"></a></div>
	<div id="pin01"><a href="index.php"><img src="img/pin01.png" width="116" height="121" alt="Главная" border="0"></a></div><a href="http://journal.schoole.ru/">
     <img src="img/no.gif" width="320" height="121" alt="Главная" border="0"></a><br>
         <img src="img/no.gif" width="1" height="20" alt="Главная" border="0"><br>
<div id="menu">

<img src="img/c04.png" width="63" height="63" alt="" style="margin-left:-63px;" border="0"><img src="img/t01.png" width="74" height="63" alt="Дневник"><a href="index.php" style="width:122px;height:63px;background-image:url('img/m01.png')">Дневник</a>
<img src="img/t02.png" width="40" height="63" alt="Школы"><a href="<?php $date=date("Y-m-d"); echo "grades.php?date=".$date;?>" style="width:121px;height:63px;background-image:url('img/m02.png')">Оценки</a>

<img src="img/t03.png" width="21" height="63" alt="Войти">
<a href="<?php //кнопка входа
if(strpos($_SERVER['PHP_SELF'], "grades.php"))
{ echo ' '; }
elseif(strpos($_SERVER['PHP_SELF'], "/auth.php"))
{ echo ' '; }
    
else { echo '../login.php?action=logout'; } ?>



" style="width:123px;height:63px;background-image:url('img/m03.png')">

<?php // кнопка выхода
if(strpos($_SERVER['PHP_SELF'], "grades.php"))
{ echo ' '; }
elseif(strpos($_SERVER['PHP_SELF'], "auth.php"))
{ echo ' Вход '; }
    
else { echo 'Выход'; } ?>
</a>


<img src="img/t04.png" width="19" height="63" alt="Оценки"><a href="grades.php?t=quater" style="width:121px;height:63px;background-image:url('img/m04.png')">Четвертные</a>
<img src="img/t05.png" width="43" height="63" alt="Итоговые"><a href="grades.php?t=year" style="width:121px;height:63px;background-image:url('img/m05.png')">Итоговые</a>
<img src="img/t06.png" width="65" height="63" alt=""><img src="img/c03.png" width="63" height="63" alt="" style="margin-right:-63px;"></div></div></div>

<div id="middle"><div id="wrap01"><div id="wrap02"><div id="wrap03"><div id="main"><img src="img/t07.png" width="870" height="10" alt=""><div id="nav">
<img src="img/pg.png" width="74" height="38" alt="" align="left">&gt;&gt; 
<a href="index.php">Дневник</a> 

<?php //навигатор
if(strpos($_SERVER['PHP_SELF'], "grades.php"))
{ echo ' -&gt;<a href="#">Оценки</a></div>'; }
elseif(strpos($_SERVER['PHP_SELF'], "auth.php"))
{ echo ' -&gt;<a href="#">Авторизация</a></div>'; }
    
else { echo '<a href="#"></a></div>'; }
	