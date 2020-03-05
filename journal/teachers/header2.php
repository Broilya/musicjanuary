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
<title>Учитель <?=NAME_SCHOOL;?></title>
            <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
            <link type="text/css" href="../css/style.css" rel="stylesheet" />
    <link type="text/css" href="../css/jquery-ui.css" rel="stylesheet" />
    <script type="text/javascript" src="../js/jquery.js"></script>
   <script type="text/javascript" src="../js/jquery-ui.js"></script>
   <script type="text/javascript" src="../js/ui.datepicker-ru.js"></script>
    <script type="text/javascript" src="../js/thickbox.js"></script>
    <script type="text/javascript" src="../js/ajaxform.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/thickbox.css" media="screen" />
<style type="text/css">

.journal { width:100%;
}

.journal_top {
	background: url(img/top_journal.png) 0% 0% no-repeat;
	
}

.journal_bottom {
	background: url(img/bottom_journal.png) 0% 100%  no-repeat;
	padding-top:127px;
	padding-bottom:114px;	
	
}

body {
	background-image: url(img/mainbg.jpg); padding:0; margin:0;
}

.journal_center {
	background: url(img/centr_journal.png) 0% 0%;
	background-repeat: repeat-y;		
	
}

.logo {
	background: url(img/logo.png) 0 0 no-repeat;
	height: 150px;
	width:326px;
	float:left;
	
}


.header { height:180px;width:950px; margin: 0 auto;	
}

.top_menu {
	width: 610px;float:right; 
}

.journal_top1 {
	background: url(img/top_journal1.png) 0% 0% no-repeat;
}

.journal_bottom1 {
	background: url(img/bottom_journal1.png) 0% 100%  no-repeat;
	padding-top:41px;
	padding-bottom:33px;
			
}

.journal_center1 {background: url(img/centr_journal1.png) 0% 0%;
	background-repeat: repeat-y;
	
}

.menu {
	width:111px;
	height:125px;
	background: url(img/top_menu.png);
	padding-left:9px;
	vertical-align: baseline;
	display: table;
	text-align: center;
}

.menu1 , .menu2 , .menu3, .menu4 , .menu5 {  }

.vkladka1 {
	background-image: url(img/vkladka1.png); width:127px ;height:95px;
}

.vkladka2 {
	background-image: url(img/vkladka2.png); width:128px ;height:121px;
}

.vkladka3 {
	background-image: url(img/vkladka3.png); width:140px ;height:113px;
}

.vkladka4 {
	background-image: url(img/vkladka4.png); width:130px ;height:121px;
}

.vkladka5 {
	background-image: url(img/vkladka5.png); width:128px ;height:101px;
}

.vkladki_menu1 {
	height: 50px;
	z-index:10;
	position:absolute;
	left: 46px;
	top: 137px;
	width: 830px;
}


</style>
</head>

<body>
<script type="text/javascript" src="../js/wz_tooltip.js"></script>
<div style="margin-left:150px;width:1259px;position:relative;">
<!-- Начало шапки -->
<div class="header">
<!-- Начало логотипа -->
<div class="logo"></div>
<!-- Конец логотипа -->
<!-- Начало меню -->
  <div class="top_menu">
    <div style="float:right;"><a href="../oferta.php"><div class="menu"><span style="display:table-cell; vertical-align:middle"><img src="img/oferta.png" /></span></div></a></div>
    <div style="float:right;width:25px;">&nbsp;</div>
    <div style="float:right;"><a href="../feedback.php"><div class="menu"><span style="display:table-cell; vertical-align:middle"><img src="img/svaz.png" /></span></div></a></div>
    <div style="float:right;width:25px;">&nbsp;</div>
    <div style="float:right;"><a href="../about_as.php"><div class="menu"><span style="display:table-cell; vertical-align:middle"><img src="img/osysteme.png" /></span></div></a></div>
	<div style="float:right;width:25px;">&nbsp;</div>
    <div style="float:right;"><a href="../index.php"><div class="menu"><span style="display:table-cell; vertical-align:middle"><img src="img/glavnay.png" /></span></div>
    </a></div>
  </div>       
  <!-- Конец меню -->
</div>
</div>


<!-- Начало журнала -->
<div align="left" style="width:1259px;">
<!-- Фон журнала начало -->
<div class="journal_top">
<div class="journal_bottom">
<div class="journal_center">
<div style="height:440px">
</div>
</div>
</div>
</div>
<!-- Фон журнала конец -->
<!-- страницы журнала начало -->
<div class="journal" style="position:absolute; left: 0px; top: 200px;z-index:20;width:1259px;">
<div class="journal_top1">
<div class="journal_bottom1">
<div class="journal_center1">
<div style="height:500px;padding-left:15px;padding-right:15px;" align="LEFT">
<div style="float: left;width: 120px;padding:20px;">s</div>
<div style="float: right;width: 889px;margin-top:20px;margin-left:50px;margin-bottom:20px;margin-right:130px;">
    
  <?
if(isset($_REQUEST['id_quater'])){
$quater_id=$_REQUEST['id_quater'];
}else{
$quater_id=1;
}


    $q=db_query("SELECT * FROM `".TABLE_SCHOOL_QUARTERS."` WHERE quarter_id='".$quater_id."'");
    $list_quater=mysql_fetch_assoc($q);
    $tek_quarter=$list_quater['quarter_name'];
?>
<script type="text/javascript" src="../js/wz_tooltip.js"></script>
<div align="center"> 
<br />
<form action=""  method="post" id="ftheme">
<input name="data" type="hidden" value="load"/>
 <table width="70%" border="0" cellpadding="2" cellspacing="2" bgcolor="#e7e7e7">
 <tr>
 <td width="15%" height="45px"><b><?php echo $lang['year'];?></b><br/>
 
  <select name="year"  onchange="ewd_getcontent('ajaxform-quoters.php?classid='+this.value, 'classesdiv');">
<option value=""><?php echo $lang['select'];?></option>
 
  <?php

 $query="SELECT * FROM `".TABLE_SCHOOL_YEARS."`  order by finished desc";
 $res=mysql_query($query);
 while ($row=mysql_fetch_assoc($res))
 {
 	echo "<option value='{$row['school_year_id']}'>{$row['name_year']}</option>";
 	
 }
   ?>
 </select>
  </td>
  <td width="15%"><b><?php echo $lang['quoter'];?></b><br/>
  <div id="classesdiv">
  <select name="month" >
 <option value=""><?php echo $lang['select'];?></option> 
  
 
 </select> 
 </div>
  </td>
 
 
  <td width="10%"><br/>
  <input type="submit" value="<?php echo $lang['data_output'];?>" />
  </td>
 </tr>
 </table>
 </form>
 <br />
<br />
<div>

<table width="40%" border="0" ><tr><td width="20%" valign="top">
<form action="lessons.php?" method="post">
<input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
<input type="hidden" name="action" value="update" />
<br>
<table  id="rounded-corner" width="40%" align="center" border='0'>
  <thead>
  <tr class="TableHead">
    <th class="rounded-left">№</th>
    <th><?php echo $lang['name'];?></th>
    <th><?php echo $lang['total'];?></th>
    <th>на 1</th>
    <th>на 2</th>
    <th>на 3</th>
    <th>на 4</th>
    <th>на 5</th>
    <th>на 6</th>
    <th>на 7</th>
    <th>на 8</th>
    <th>на 9</th>
    <th>на 10</th>
    <th>на 11</th>
    <th>на 12</th>
    <th><?php echo $lang['avereg'];?></th>
    <th width="2"><?php echo $lang['obuch_procent'];?></th>
    <th width="2"><?php echo $lang['kachesctvo'];?></th>
   <th class="rounded-right" colspan="3">&nbsp;</th>
  </tr>
  </thead>
  <tbody>
<?php

  // определяем какой клас ведет учитель

  
  
 
  $query="SELECT s.student_id, s.last_name, s.first_name,	s.middle_name, s.photo, s.address, s.phone, sol.grade   "
        ." FROM `".TABLE_STUDENTS_ON_LESSON."` as sol"
        ." left JOIN `".TABLE_STUDENTS_IN_CLASS."` as sic on sic.student_id=sol.student_id"
        ." left JOIN `".TABLE_CLASSES."` as cl on cl.class_id=sic.class_id"
        ." left JOIN `".TABLE_USERS_STUDENTS."` as s on s.student_id=sol.student_id"
        ." left JOIN `".TABLE_LESSONS."` as l on l.lesson_id=sol.lesson_id"
        ." left JOIN `".TABLE_SUBJECTS."` as su on su.subject_id=l.subject_id"
        ." left JOIN `".TABLE_SPR_DISCIPLINES."` as d on d.discipline_id=su.discipline_id"
        ."  WHERE su.teacher_id='".$_SESSION['teacher_id']."' and su.subject_id='".$_REQUEST['disp_id']."' "
        ."  and sol.quater='".$quater_id."' order by s.last_name asc";
  
  $res=mysql_query($query);
   $nums=mysql_num_rows($res);
  $stud_grades=array();
  $stud_names=array();
   
  if($nums>0) {
  $n=1;
  while($row=mysql_fetch_assoc($res)) {
  
  	$stud_grades[$row['student_id']][]=$row['grade'];
  	$stud_names[$row['student_id']]['name']=$row['last_name']." ".$row['first_name'];
  	$stud_names[$row['student_id']]['photo']=$row['photo'];
  	$stud_names[$row['student_id']]['address']=$row['address'];
 
  	
  }
   
 
  $good_cnt=0;
   foreach($stud_names as $key => $student) {
   	foreach ($stud_grades[$key] as $grade) {
   	if ($grade=="12" or $grade=="11" or $grade=="10" or $grade=="9" or $grade=="8") { $good_cnt++; } 
   	if ($grade=="12" or $grade=="11" or $grade=="10") { $very_good_cnt++; } 
   	} }
   	
   $good_procent=$good_cnt/(count($stud_names));
   $good_procent=round($good_procent,2);
   $good_procent=$good_procent*100;
   
   $very_good_procent=$very_good_cnt/(count($stud_names));
   $very_good_procent=round($very_good_procent,2);
   $very_good_procent=$very_good_procent*100;
   
 $cnt_2=0; $cnt_1=0; $cnt_3=0;
$cnt_4=0;$cnt_5=0;$cnt_6=0;$cnt_7=0;$cnt_8=0;$cnt_9=0;$cnt_10=0; $cnt_11=0;$cnt_12=0; $total=0;
 foreach($stud_names as $key => $student) {

  	
  if ($student['photo']!=='')
  {
  	$student_photo ="<img src=\'../student_photo/".SUBDOMEN."/sm/{$student['photo']}\'>";
  }
  else
  {
  	$student_photo ="<img src=\'/images/nophoto.gif \'>";
  }
  $aver=0;
  echo "<tr align='center'><td>$n</td><td nowrap=\"nowrap\" align='left'><div style='cursor:pointer;' onmouseover=\"Tip('$student_photo <br>ПИН код: {$student['pcode']}<br> Адресс: {$student['address']} <br>Телефон: {$student['phone']}')\" onmouseout=\"UnTip()\">{$stud_names[$key]['name']}</div></td>";

  foreach ($stud_grades[$key] as $grade) {
 	$total++;
 	
  if ($grade=="1") { $cnt_1++;}
  if ($grade=="2") { $cnt_2++;}
  if ($grade=="3") { $cnt_3++;}
  if ($grade=="4") { $cnt_4++;}
  if ($grade=="5") { $cnt_5++;}
  if ($grade=="6") { $cnt_6++;}
  if ($grade=="7") { $cnt_7++;}
  if ($grade=="8") { $cnt_8++;}
  if ($grade=="9") { $cnt_9++;}
  if ($grade=="10") { $cnt_10++;}
  if ($grade=="11") { $cnt_11++;}
  if ($grade=="12") { $cnt_12++;}
 	
 	$aver+=$grade;
 }
  $list_grades = array();
 

  $aver=$aver/count($stud_grades[$key]);
  $aver=round($aver,2);
  
  print "<td>$total<td>$cnt_1<td>$cnt_2<td>$cnt_3<td>$cnt_4<td>$cnt_5<td>$cnt_6<td>$cnt_7<td>$cnt_8<td>$cnt_9<td>$cnt_10<td>$cnt_11<td>$cnt_12<td>$aver";
  
  
  $two_cnt=0;  
 
  if($n==1){
  	
  print "<td rowspan='".count($stud_names)."'>".$good_procent."%</td>
  <td colspan='4' align='left' rowspan='".count($stud_names)."' >".$very_good_procent."%</td>";
  }
  echo '</tr>';
  $n++;
  }
  } else print "<tr><td colspan='19' align='center'><font color='red' size='4px'>Нет данных</font></td>";
?>
  </tbody>

</table>

<br />
</form>

</td>
</table>   
</div></div>

</div>

</div>
</div>
</div>
</div>
</div>
<!-- страницы журнала конец -->
<!-- страницы журнала конец -->
<!-- Блок меню-закладок журнала начало-->
<div class="vkladki_menu1">
    <div style="float:right;"><div style="width:15px;">&nbsp;</div></div>
    <div style="float:right;" class="vkladka1"><a href="logins.php"><div style="padding-top:32px;" align="center">Логины</div></a></div>
    <div style="float:right;" ><div style="width:22px;">&nbsp;</div></div>
    <div style="float:right;" class="vkladka2"><a href="service.php"><div style="padding-top:32px;" align="center">Операции</div></a></div>
    <div style="float:right;"><div style="width:25px;">&nbsp;</div></div>
    <div style="float:right;" class="vkladka3"><a href="login.php?action=logout"><div style="padding-top:32px;" align="center">Выход</div></a></div>
    <div style="float:right;"><div style="width:22px;">&nbsp;</div></div>
    <div style="float:right;" class="vkladka4"><a href="index.php?act=info"><div style="padding-top:32px;" align="center">Сообщения</div></a></div>
	<div style="float:right;";><div style="width:22px;">&nbsp;</div></div>
    <div style="float:right;" class="vkladka5"><a href="index.php"><div style="padding-top:32px;" align="center">Учитель</div></a></div>
	<div style="float:right;"><div style="width:15px;">&nbsp;</div></div>
  </div>
<!-- Блок меню-закладок журнала начало-->
<!-- Закладка журнала начало
<div class="zakladka"><a href="">
  <div class="zakladka1"></div></a></div>-->
<!-- Закладка журнала конец-->
<!-- Уголок страницы 
<div class="ugolok"></div>-->
<!-- Конец журнала -->

</div>
</div>
</body>
</html>
