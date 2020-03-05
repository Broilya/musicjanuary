<?
define('TEACHER_ZONE', true);
include_once ('../init.php');
include_once ('../include/students.php');
include_once ('../include/classes.php');
include_once ('../include/images.php');

//print_r($_SERVER); 
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
<title>Страница ученика <?=NAME_SCHOOL;?></title>
	<link rel="stylesheet" type="text/css" href="../css/main.css">
    <link type="text/css" href="../css/jquery-ui.css" rel="stylesheet" />
    <script type="text/javascript" src="../js/jquery.js"></script>
   <script type="text/javascript" src="../js/jquery-ui.js"></script>
   <script type="text/javascript" src="../js/ui.datepicker-ru.js"></script>
    <script type="text/javascript" src="../js/thickbox.js"></script>
    <script type="text/javascript" src="../js/ajaxform.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/thickbox.css" media="screen" />
     <script type="text/javascript">
$(document).ready(function(){
    $('.topmenu ul li').hover(
        function() {
            $(this).addClass("active");
            $(this).find('ul').stop(true, true);
            $(this).find('ul').slideDown();
        },
        function() {
            $(this).removeClass("active");
            $(this).find('ul').slideUp('slow');
        }
    );
});

$(document).ready(function(){

	$("ul.subnav").parent().append("<span></span>"); //Only shows drop down trigger when js is enabled - Adds empty span tag after ul.subnav
	
	$("ul.topnav li span").click(function() { //When trigger is clicked...
		
		//Following events are applied to the subnav itself (moving subnav up and down)
		$(this).parent().find("ul.subnav").slideDown('fast').show(); //Drop down the subnav on click

		$(this).parent().hover(function() {
		}, function(){	
			$(this).parent().find("ul.subnav").slideUp('slow'); //When the mouse hovers out of the subnav, move it back up
		});

		//Following events are applied to the trigger (Hover events for the trigger)
		}).hover(function() { 
			$(this).addClass("subhover"); //On hover over, add class "subhover"
		}, function(){	//On Hover Out
			$(this).removeClass("subhover"); //On hover out, remove class "subhover"
	});

});
</script>
 </head>    
<style type="text/css">

.body_d { padding-left:10px;padding-right:15px; }
.right_col {height:500px; width:100%; padding-left:80px;}

</style>
</head>
    
<body>
<?php $date=date("Y-m-d");?>
<div id="top"><div id="header">
	<div id="pin04"><a href="../oferta.php"><img src="img/pin04.png" width="116" height="121" alt="Оферта" border="0"></a></div>
	<div id="pin03"><a href="../feedback.php"><img src="img/pin03.png" width="117" height="121" alt="Связь с нами" border="0"></a></div>
	<div id="pin02"><a href="../about_as.php"><img src="img/pin02.png" width="116" height="121" alt="О системе" border="0"></a></div>
	<div id="pin01"><a href="../index.php"><img src="img/pin01.png" width="116" height="121" alt="Главная" border="0"></a></div><a href="../index.php">
     <img src="img/no.gif" width="320" height="121" alt="Главная" border="0"></a><br>
         <img src="img/no.gif" width="1" height="20" alt="Главная" border="0"><br>
<div id="menu">

<img src="img/c04.png" width="63" height="63" alt="" style="margin-left:-63px;" border="0"><img src="img/t01.png" width="74" height="63" alt="Дневник"><a href="index.php" style="width:122px;height:63px;background-image:url('img/m01.png')">Учитель</a>
<img src="img/t02.png" width="40" height="63" alt="Школы"><a href="index.php?act=info" style="width:121px;height:63px;background-image:url('img/m02.png')">Сообщения</a>

<img src="img/t03.png" width="21" height="63" alt="Войти">

<a href="<?php //кнопка входа
if(strpos($_SERVER['PHP_SELF'], "grades.php"))
{ echo ' '; }
elseif(strpos($_SERVER['PHP_SELF'], "auth.php"))
{ echo ' '; }
    
else { echo 'login.php?action=logout'; } ?>

" style="width:123px;height:63px;background-image:url('img/m03.png')">

<?php // кнопка выхода
if(strpos($_SERVER['PHP_SELF'], "grades.php"))
{ echo ' '; }
elseif(strpos($_SERVER['PHP_SELF'], "auth.php"))
{ echo ' Вход '; }
    
else { echo 'Выход'; } ?>
</a>


<img src="img/t04.png" width="19" height="63" alt="Логины"><a href="logins.php" style="width:121px;height:63px;background-image:url('img/m04.png')">Логины</a>
<img src="img/t05.png" width="43" height="63" alt="Операции"><a href="service.php" style="width:121px;height:63px;background-image:url('img/m05.png')">Операции</a>
<img src="img/t06.png" width="65" height="63" alt=""><img src="img/c03.png" width="63" height="63" alt="" style="margin-right:-63px;"></div></div></div>

<div id="middle"><div id="wrap01"><div id="wrap02"><div id="wrap03"><div id="main"><img src="img/t07.png" width="870" height="10" alt=""><div id="nav">
<img src="img/pg.png" width="74" height="38" alt="" align="left">&gt;&gt; 
<a href="../index.php">Дневник</a> 

<?php //навигатор
if(strpos($_SERVER['PHP_SELF'], "grades.php"))
{ echo ' -&gt;<a href="#">Оценки</a></div>'; }
elseif(strpos($_SERVER['PHP_SELF'], "auth.php"))
{ echo ' -&gt;<a href="#">Авторизиция</a></div>'; }
    
else { echo '<a href="#"></a></div>'; }
	



?>

