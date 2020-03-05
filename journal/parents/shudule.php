<?php

define('PARENT_ZONE', true);
include_once ('../init.php');
include_once ('../include/classes.php');
include_once ('../include/students.php');
include_once ('../include/report.php');
include_once ('../include/images.php');


// config
/*
$db_config = mysql_query("SELECT * FROM `".TABLE_CONFIG."`");
while ($config = mysql_fetch_array($db_config)) {
  define($config['key_config'], $config['value_config']);
}
*/
// sms
if (isset($_GET['txt']) && isset($_GET['pref'])) {

  header("Location: sms-services.php?txt=".$_GET['txt']."&pref=".$_GET['pref']."");
  exit();

}

 if(!isset($_POST['action'])) {$_POST['action'] = '';}
 
  // Загрузка фото учинека
  if ($_POST['action'] == 'update_photo' && $_FILES['uploadfile']['tmp_name']!=='') {
    
    @unlink("../student_photo/".SUBDOMEN."/".$_POST['photo']);
    @unlink("../student_photo/".SUBDOMEN."/sm/".$_POST['photo']);
    $student_photo = UploadedPhotoFile("../student_photo/".SUBDOMEN."/");		 
    $query = mysql_query("UPDATE `".TABLE_USERS_STUDENTS."` SET photo='".$student_photo."', update_photo=".($_POST['update_photo']+1)." WHERE student_id='".$_POST['student_id']."'"); 	
    header('Location: index.php');
    exit();        
     
  } elseif ($_POST['action'] == 'add_photo' && $_FILES['uploadfile']['tmp_name']!=='') {
  	
  	$student_photo = UploadedPhotoFile("../student_photo/".SUBDOMEN."/");	
    $query = mysql_query("UPDATE `".TABLE_USERS_STUDENTS."` SET photo='".$student_photo."' WHERE student_id='".$_POST['student_id']."'"); 	
    header('Location: index.php');
    exit();         
  }
  
include 'header.php';

if (!isset($_SESSION['student_id'])) {

if(!isset($_REQUEST['error'])){$_REQUEST['error'] = '';}
if(!isset($_SESSION['class'])){$_SESSION['class'] = '';}

 if(isset($_POST['class']) && $_POST['class'] !== '') {
   $_SESSION['class'] = $_POST['class'];
 } 

 // дни недели

 $dnum = date("w"); 
 $d = $dnum-1;  
?>
<style type="text/css">
<!--
.style1 {font-size: 9px}
-->
</style>
<script type="text/javascript" src="js/wz_tooltip.js"></script>
<script type="text/javascript" src="js/month.js"></script>
<table   height="100%" id="oblozhka2" width="100%" >
<tr style="height:100px;color:white; ">
	<td style="font-size:13px; text-align:right;">
	





<div id="container">
  <div id="topnav" class="topnav"> Авторизация  <a href="login" class="signin"><span>Вход на сайт</span></a> </div>
  <fieldset id="signin_menu">
    <form method="post" id="signin" action="../login.php">
     
  <input type="hidden" name="action" value="login" />
            <input type="hidden" name="action2" value="login" />
           
				
                    <input name="name" type="text" value="Логин" onclick='if(this.value=="Логин"){this.value="";}' onblur='if(this.value==""){this.value="Логин";}' />
                    <input name="pass" type="password" value="Пароль" onclick='if(this.value=="Пароль"){this.value="";}' onblur='if(this.value==""){this.value="Пароль";}' />
                    <select name="type"><option value="student">Ученик</option><option value="teacher">Учитель</option><option value="admin">Админ</option></select></select>
                    <input type="submit" id="signin_submit" tabindex="6"  value="Войти" />



    </form>
  </fieldset>
</div>










</td>




</tr>
<tr style=""  >
  <td valign="top" class="vivod"> 
 <?php // вывод предметов

  if (isset($_SESSION['class']))
   {	
   	 
    for ($j = 0; $j<=5; $j++) 
    {
       echo "<div id=\"discipline_$j\"><table border=0>"; 
       
       if (isset($_GET['date'])) {
         $date_d = date('d', strtotime($_GET['date']));  
         $date_m = date('m', strtotime($_GET['date']));  
         $date_y = date('Y', strtotime($_GET['date'])); 
         $date_day = date('Y-m-d', mktime(0,0,0, $date_m, $date_d+$j-$d,  $date_y));
       } else {
         $date_day = date('Y-m-d', mktime(0,0,0, date('m'), date('d')+$j-$d, date('Y')));
       }
         
       $report_indx_list = get_report_indx_list($_SESSION['class'], $date_day);
       $i=1;
       foreach($report_indx_list as $report_indx) {
        
       $report_indx_lessons = get_report_indx_lessons($report_indx['subject_id'], $report_indx['date_schedule'], $report_indx['order_schedule']);
       
   	   if($report_indx['order_schedule'] > $i) {
       echo '<tr><td colspan="2" class="discipline" height="12px"></td></tr>';
       }
		 echo "<tr><td class='discipline' width=115><div style='cursor:pointer;' onmouseover=\"Tip('".$report_indx['cabinet']."')\" onmouseout=\"UnTip()\">".$report_indx['discipline']."</div></td><td class='discipline'>";
         foreach($report_indx_lessons as $report_lessons) { 
          echo "<div style='cursor:pointer;' onmouseover=\"Tip('".$report_lessons['dz']."')\" onmouseout=\"UnTip()\">".substr($report_lessons['dz'], 0, 40)." ...</div>";
         }
         echo "</td></tr>";
        $i++;
      }  
	  echo "</table></div>";
     }	
    }
	
	// дата последний оценки
	$report_indx_update = get_report_indx_update();
  
       foreach($report_indx_update as $report_update) {
   	   
		 echo "<div id=\"update\">".$report_update['lesson_date1']."</div>";
   	   
      }  	
  ?>
   </div> 
  <form action="index.php" method="post"> 
  
  <?php 
    // дата недели
    
   if( $dnum !== '0')
   {
      for ($i = 0; $i<=5; $i++) 
      {
 	     if(!isset($_REQUEST['error'])){$_REQUEST['error'] = '';}
          // дни недели
          if (isset($_GET['date'])) {
            $date = date('d', strtotime($_GET['date']));  
            $date_w = date('d', mktime(0,0,0, date('m'), $date+$i-$d, date('Y')));
          } else {
            $date_w = date('d', mktime(0,0,0, date('m'), date('d')+$i-$d, date('Y')));
          }
	 echo " ";	
     }
   }
  ?>

      <div id="clas_sel_form"> <div class="my-skinnable-select">
  	  <select name="class" onChange="javascript: this.form.submit();">
  	  <option value="">Выберите класс</option>
	
  <?php 
  
  // список класов
  
  $classes_list_sel = get_classes_list_sel();
  
   foreach($classes_list_sel as $class_sel) {
   	
 	if ($class_sel['class_id'] == $_SESSION['class']){
   	  $sel = "selected";
   	} else {
   	  $sel ="";	
   	}
  	echo '<option value="'.$class_sel['class_id'].'" '.$sel.'>'.$class_sel['class'].'-'.$class_sel['letter'].'</option>';
  	}
 ?>
</select></div></div>
</form>
<div id="nav">
<div style="width:800px;  float:left; text-align:center;">
<a href="?date=
<?php 
  if (isset($_GET['date'])){ 
  $date_d = date('d', strtotime($_GET['date']));  
  $date_m = date('m', strtotime($_GET['date']));  
  $date_y = date('Y', strtotime($_GET['date'])); 
  echo date('Y-m-d', mktime(0,0,0, $date_m, $date_d-7,  $date_y)); 
  } else {echo date('Y-m-d', mktime(0,0,0, date('m'), date('d')-7, date('Y')));}?>"><img src="../images/prev.jpg" ></a>


  &nbsp;&nbsp;<a href="?date=<?php echo date('Y-m-d');?>"><img src="../images/current.jpg" width:120px; ></a>&nbsp;&nbsp;

<a href="?date=
<?php 
  if (isset($_GET['date'])){ 
  $date_d = date('d', strtotime($_GET['date']));  
  $date_m = date('m', strtotime($_GET['date']));  
  $date_y = date('Y', strtotime($_GET['date'])); 
  echo date('Y-m-d', mktime(0,0,0, $date_m, $date_d+7,  $date_y)); 
  } else {echo date('Y-m-d', mktime(0,0,0, date('m'), date('d')-7, date('Y')));}?>"><img src="../images/next.jpg"></a></div>
</div>


 








</td>
  </tr>
</table>
</body>
</html>
<?php
  exit();
}
$student_id = $_SESSION['student_id'];
?>
<br />




  <script type="text/javascript">
  $(document).ready(function(){
    $("#tabs").tabs();
  });
	</SCRIPT>

<?php



function show_months_grades($quarter, $started, $fineshed,$fd)
{
	$quarters = get_quarters_in_year(1,1);
	$last_day=array_pop($quarters);
	
	  global $student_id, $sum_q;
	  $months = array(1  => 'Январь',
                  2  => 'Февраль',
                  3  => 'Март',
                  4  => 'Апрель',
                  5  => 'Май',
                  6  => 'Июнь',
                  7  => 'Июль',
                  8  => 'Август',
                  9  => 'Сентябрь',
                  10 => 'Октябрь',
                  11 => 'Ноябрь',
                  12 => 'Декабрь',
                  );
  $started = split('-', $started);
  $fineshed = split('-', $fineshed);
  $month = intval($started[1]);
  //print "<font color='red'>".$month."</font>";
	?>
  <h3><a href="#"><?php echo $months[$month]; ?></a></h3>
<div width="100%">
<table id="rounded-corner" width="100%" border="1">
<thead>
  <tr>
    <th><font size="3px">Дисциплина</font></th>
<?php
  $arr = array('Mon' => 'Пн',
               'Tue' => 'Вт',
               'Wed' => 'Ср',
               'Thu' => 'Чт',
               'Fri' => 'Пт',
               'Sat' => 'Сб',
               'Sun' => 'Вс',
              );
$dates = array();
$res = db_query("SELECT value_config FROM `".TABLE_CONFIG."` WHERE key_config='".DAYS."'");
  $days_mode = array_pop(mysql_fetch_assoc($res));
  
for($i=$started[2];$i<=$fineshed[2]; $i++) {
	if (date('N', strtotime($started[0].'-$month-'.$i)) == 7) {
	  continue;
	}
	if(date('D', mktime(0,0,0, $month, $i, $started[0]))=="Sun") { continue; }
	if( (date('D', mktime(0,0,0, $month, $i, $started[0]))=="Sat") and ($days_mode==0))  { continue; }
  echo '<th><font size="1px">'.$i.'<br />'.$arr[date('D', mktime(0,0,0, $month, $i, $started[0]))].'</font></th>';
  $dates[] = sprintf('%4d-%02d-%02d',$started[0],$month, $i);
}
 echo '<th><font size="2px">Четвертная</th>';
  echo '<th><font size="2px">Годовая</font></th>';
   echo '<th><font size="2px">Экзамен</font></th>';
   echo '<th><font size="2px">Итоговая</font></th>';
?>

	
  </tr>
</thead>
<?php

  $res = db_query("SELECT class_id FROM `".TABLE_STUDENTS_IN_CLASS."` WHERE student_id='".$student_id."'");
  $class_id = array_pop(mysql_fetch_assoc($res));
  $disceplines = get_disciplines_from_class($class_id);
  
  $res = db_query("SELECT sc.student_id AS student_id, sl.grade AS grade, sl.behavior AS behavior, l.lesson_date AS lesson_date, l.dz AS lesson_dz, l.topic AS lesson_topic, l.lesson_id AS lesson_id, s.discipline_id AS discipline_id, d.discipline AS discipline"
  ." FROM `".TABLE_STUDENTS_IN_CLASS."` sc"
  ." JOIN `".TABLE_SUBJECTS."` s on (s.class_id = sc.class_id)"
  ." JOIN `".TABLE_LESSONS."` l on (l.subject_id = s.subject_id)"
  ." left JOIN `".TABLE_STUDENTS_ON_LESSON."` sl on (sl.student_id = sc.student_id) and (sl.lesson_id = l.lesson_id)"
  ." left JOIN `".TABLE_SPR_DISCIPLINES."` d on (d.discipline_id = s.discipline_id)"
  ." WHERE sc.student_id='".$student_id."' order by l.lesson_date, sc.student_id");

  $grades = array();
  while ($row = mysql_fetch_assoc($res)) {
  	if(isset($grades[$row['lesson_date']][$row['discipline_id']])) {
  		$grades[$row['lesson_date']][$row['discipline_id']] .= '/'.$row['grade'];
  		
  	} else {
      $grades[$row['lesson_date']][$row['discipline_id']] = $row['grade'];
  	}

  	if(isset($grades['lesson_dz'][$row['lesson_date']][$row['discipline_id']])) {
  		
  		$grades['lesson_dz'][$row['lesson_date']][$row['discipline_id']] .= '/'.$row['lesson_dz'];
  		
  	} else {
      $grades['lesson_dz'][$row['lesson_date']][$row['discipline_id']] = $row['lesson_dz'];
  	}
  	
  	if(isset($grades['behavior'][$row['lesson_date']][$row['discipline_id']])) {
  		
  		$grades['behavior'][$row['lesson_date']][$row['discipline_id']] .= '/'.$row['behavior'];
  		
  	} else {
      $grades['behavior'][$row['lesson_date']][$row['discipline_id']] = $row['behavior'];
  	}
  	
  	if(isset($grades['lesson_topic'][$row['lesson_date']][$row['discipline_id']])) {
  		
  		$grades['lesson_topic'][$row['lesson_date']][$row['discipline_id']] .= '/'.$row['lesson_topic'];
  		
  	} else {
      $grades['lesson_topic'][$row['lesson_date']][$row['discipline_id']] = $row['lesson_topic'];
  	}
  }
$sum=0;
  foreach($disceplines as $discepline_id => $discepline)  {
    echo '<tr><td nowrap="nowrap"><font size="3px" style="color:black;
text-shadow:1px 1px 1px #568F23;">'.$discepline.'</font></td>';
    foreach ($dates as $date) {
    	if (isset($grades[$date][$discepline_id])) {

   		if($grades['behavior'][$date][$discepline_id]=='1')
		   {
		  	$behavior = "Поведение: отличное";
		   }
		   elseif($grades['behavior'][$date][$discepline_id]=='2')
		   {
		  	$behavior ="Поведение: удовлетворительное";
		   }
		   elseif($grades['behavior'][$date][$discepline_id]=='3')
		   {
		  	$behavior ="Поведение: плохое";
		   }

        echo "<td><font size=1px><div style='cursor:pointer;' onmouseover=\"Tip('".$behavior."<br>Тема урока: ".$grades['lesson_topic'][$date][$discepline_id]."<br>Домашнее задание: ".$grades['lesson_dz'][$date][$discepline_id]."')\" onmouseout=\"UnTip()\" >".$grades[$date][$discepline_id]."</div></font></td>";
        $sum_q+=$grades[$date][$discepline_id];
     } else {
        echo '<td>&nbsp;</td>';
     }
    }
     //выводим четвертную оценку
      //if($months[$month]==$months[$fd]){
        $stud=mysql_query("SELECT * FROM `".TABLE_STUDENTS_ON_LESSON."` WHERE  `student_id` = '".$student_id."' AND `quater`= '".$quarter['quarter_id']."' AND `subj_id`='".$discepline_id."'");
        $sum=0;
      if(mysql_num_rows($stud)!=0){
        for($i=0;$i<mysql_num_rows($stud);$i++){
            $sum+=mysql_result($stud,$i,2);
        }
        
      print "<td>".round($sum/mysql_num_rows($stud))."</td>";
      }else{
      print "<td>Н/А</td>";
      }
       //выводим годовую
       
      //$stud=mysql_query()
      if (date("Y-m-d")>$last_day['finished']) {
      if(mysql_num_rows($stud)!=0){
        $stud=mysql_query("SELECT *, avg( grade ) FROM `".TABLE_STUDENTS_ON_LESSON."`"
        ." WHERE  `student_id` = '".$student_id."' AND  `subj_id`='".$discepline_id."' group by quater");
        $sum=0;

      if(mysql_num_rows($stud)!=0){
        for($i=0;$i<mysql_num_rows($stud);$i++){
            $sum+=mysql_result($stud,$i,6);
        }
        
      print "<td>".round($sum/mysql_num_rows($stud))."</td>";
      }else{
      print "<td>Н/А</td>";
      } 
      } } else  print "<td>Н/А</td>";
      $year=round($sum/mysql_num_rows($stud));
   //выводим экзамен
      if(mysql_num_rows($stud)!=0){
        $stud=mysql_query("SELECT * FROM `".TABLE_STUDENTS_ON_LESSON."`"
        ." WHERE  `student_id` = '".$student_id."' and `quater`= 10000 AND  `subj_id`='".$discepline_id."'");
        $sum=0;

      if(mysql_num_rows($stud)!=0){
        for($i=0;$i<mysql_num_rows($stud);$i++){
            $sum+=mysql_result($stud,$i,2);
        }
      print "<td>".round($sum/mysql_num_rows($stud))."</td>";
      }else{
      print "<td>Н/А</td>";
      }
      }
     // }
  //  echo '</tr>'."\n";
    
    //выводим итог
      if (date("Y-m-d")>$last_day['finished']) {
      if ($sum>0) {
      	
      	$itogo=($sum+$year)/2;
      print "<td>".round($itogo)."</td>";
      }else{
      print "<td>$sum</td>";
      }
      } else  print "<td>Н/А</td>";
     // }
    echo '</tr>'."\n";

  }
?>
<tr>
</tr>
</table>
</div>
  <?php
}

function show_quarter_grades($quarter)
{
  global $student_id, $sum_q;

?>

<SCRIPT type="text/javascript">
	$(function() {
		$("#months<?php echo $quarter['quarter_id']; ?>").accordion();
	});
	</script>

<div id="months<?php echo $quarter['quarter_id']; ?>">
<?php

$started_date = split('-', $quarter['started']);
$fineshed_date = split('-', $quarter['finished']);
echo $quarter['started'].' - '.$quarter['finished'];

$dates = array();
$flag = true;
$i = 0;
while($flag) {
  $dates[$i]['started'] = sprintf('%4d-%02d-%02d', $started_date[0], $started_date[1], $started_date[2]);
  if ($started_date[1] == $fineshed_date[1]) {
    $finished = $fineshed_date[2];
  } else {
    $finished = cal_days_in_month(CAL_GREGORIAN, $started_date[1], $started_date[0]);
  }
  $dates[$i]['finished'] = sprintf('%4d-%02d-%02d', $started_date[0], $started_date[1], $finished);

  $started_date[2] = 1;
  $started_date[1]++;
  if ($started_date[1] > 12) {
    $started_date[1] = 1;
    $started_date[0]++;
  };
  if ($started_date[0].'-'.$started_date[1] > $fineshed_date[0].'-'.$fineshed_date[1]) {
    //print  $started_date[1];
  	$flag = false;
  }
  $i++;
}

$sum_q=0;

foreach($dates as $date) {

  show_months_grades($quarter, $date['started'], $date['finished'], $fineshed_date[1]);
}
?>
</div>

<?php

}

function count_overage($quarter){
$start=$quarter['started'];
$finish=$quarter['finished'];

$dates = array();
for($i=$started[2];$i<=$fineshed[2]; $i++) {
  if($arr[date('D', mktime(0,0,0, $month, $i, $started[0]))]!='Вс'){
	if (date('N', strtotime($started[0].'-$month-'.$i)) == 7) {
	  continue;
	}
  echo '<th><font size="1px">'.$i.'<br />'.$arr[date('D', mktime(0,0,0, $month, $i, $started[0]))].'</font></th>';
  $dates[] = sprintf('%4d-%02d-%02d',$started[0],$month, $i);
  }
}

foreach($dates as $date){
  print $date;
}
}

function dima_mozg($quarter, $started, $fineshed,$fd){
    global $student_id;
	  $months = array(1  => 'Январь',
                  2  => 'Февраль',
                  3  => 'Март',
                  4  => 'Апрель',
                  5  => 'Май',
                  6  => 'Июнь',
                  7  => 'Июль',
                  8  => 'Август',
                  9  => 'Сентябрь',
                  10 => 'Октябрь',
                  11 => 'Ноябрь',
                  12 => 'Декабрь',
                  );
  $started = split('-', $started);
  $fineshed = split('-', $fineshed);
  $month = intval($started[1]);

   $subj=db_query("SELECT * FROM `".TABLE_SPR_DISCIPLINES."`");
   $disciplines=array();
   while($row=mysql_fetch_assoc($subj)){
     $disciplines[]=$row;
   }

   $res = db_query("SELECT class_id FROM `".TABLE_STUDENTS_IN_CLASS."` WHERE student_id='".$student_id."'");
   $class_id = array_pop(mysql_fetch_assoc($res));
   $q=db_query("SELECT * FROM `".TABLE_SCHOOL_QUARTERS."`");
   $quarters=array();
   while($row = mysql_fetch_assoc($q)){
     $quarters[]=$row;
   }
   foreach($quarters as $quarter){
     print $quarter['quarter_name']."<br>";
     $q_id=$quarter['quarter_id'];
     //Ищем предметы
     $pred=db_query("SELECT * FROM `".TABLE_SUBJECTS."` WHERE class_id='".$class_id."'");
     while($p=mysql_fetch_assoc($pred)){
       print "&nbsp;&nbsp;".$disciplines[$p['subject_id']-1]['discipline']."<br>";
     //
        $grades=db_query("SELECT * FROM `".TABLE_STUDENTS_ON_LESSON."` WHERE student_id='".$student_id."' AND quater='".$q_id."' AND subj_id='".$p['subject_id']."'");
        while($row=mysql_fetch_assoc($grades)){
            print "&nbsp;&nbsp;&nbsp;&nbsp;".$row['grade']."<br>";
        }
     }

   }
}

   
  include_once ('../include/curriculums.php');
  $quarters = get_quarters_in_year(1,1);

$student = get_student($_SESSION['student_id']);

 if ($student['update_photo'] < 3 && $student['photo'] !=='') {

$link_photo="<br><a href='?action=update_photo&student_id=$student[student_id]&photo=$student[photo]&update_photo=$student[update_photo]'>Изменить фото</a><br><font color=red><small>(Ограничение до ".(3-$student['update_photo'])." изменений)</small></font>";
 
 }
  elseif ($student['update_photo'] == 0 && $student['photo'] =='') {
 	$link_photo="<br><a href='?action=add_photo&student_id=$student[student_id]'>Добавить фото</a></font>";
 }
 else
 {
 	$link_photo="";
 }


echo "<table border='0' cellpadding='2'><tr>";
if($student['photo'] !=='') { echo "<td><a class=\"highslide\" onclick=\"return hs.expand(this)\" href=\"../student_photo/".SUBDOMEN."/$student[photo]\" title=\"Увеличить фото\"><img src='../student_photo/".SUBDOMEN."/sm/$student[photo]' border=\"0\"></a>".$link_photo."</td><td width=5>&nbsp;</td>"; }
else
{
	echo "<td><img src='images/nophoto.gif' border=1 height='100' width='100'>".$link_photo."</td><td width=5>&nbsp;</td>";
}
$query="SELECT class,letter FROM `".TABLE_STUDENTS_IN_CLASS."`  as sic"
      ." JOIN `".TABLE_CLASSES."` as c on c.class_id=sic.class_id"
      ." WHERE sic.student_id='".$student[student_id]."'";
$res=mysql_query($query);
$row=mysql_fetch_array($res);

echo "<td valign=top>$student[last_name] $student[first_name] $student[middle_name]   {$row['class']}-{$row['letter']}";


if (SMS_ZAPROS == '0') {
 echo "<br><br>Для того, чтобы получить оценки, за неделю на мобильный телефон,<br> отправьте SMS с кодом ".SMS_PREFIKS_OZENKI." $student[pin_code] на номер 4345. <br><br>Для того, чтобы получить домашние задание за сегодня, на мобильный телефон,<br> отправьте SMS с кодом ".SMS_PREFIKS_DZ." $student[pin_code] на номер 4345. <br><a href=\"http://num.smsonline.ru/?4345\" target=_blank>Операторы и стоимость</a>";   
}

echo"</td></tr></table><br />";

if (isset($_GET['action']))
{
  if ($_GET['action'] == 'update_photo' && $student['update_photo'] < 3)
  {
  	echo '<form action="index.php" method="post" enctype="multipart/form-data">
  	<input type="hidden" name="action" value="update_photo" />
  	<input type="hidden" name="student_id" value="'.$_GET['student_id'].'" />
  	<input type="hidden" name="photo" value="'.$_GET['photo'].'" />
  	<input type="hidden" name="update_photo" value="'.$_GET['update_photo'].'" />
	 Фото: <input type="file" size="15" name="uploadfile" /> <input type="submit" class="button" value="Загрузить" />
	  </form><br>
	  ';
  }
  elseif ($_GET['action'] == 'add_photo' && $student['update_photo'] == 0)
  {
  	
  	echo '<form action="index.php" method="post" enctype="multipart/form-data">
  	<input type="hidden" name="action" value="add_photo" />
  	<input type="hidden" name="student_id" value="'.$_GET['student_id'].'" />
	 Фото: <input type="file" size="15" name="uploadfile" /> <input type="submit" class="button" value="Загрузить" />
	  </form><br>
	  ';
  	
  }
	
}
echo '<div id="tabs" width="100%">
    <ul>';
foreach ($quarters as $quarter) {

echo '<li><a href="#quarter-'.$quarter['quarter_id'].'"><span>'.$quarter['quarter_name'].'</span></a></li>';
}
echo '</ul>';

foreach ($quarters as $quarter) {
echo '<div id="quarter-'.$quarter['quarter_id'].'">';
//count_overage($quarter);
show_quarter_grades($quarter);
echo '</div>';
}

?>
</div>


