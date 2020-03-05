<?php

/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

session_start();

define('TEACHER_ZONE', true);

include_once ('../init.php');
include_once ('../include/classes.php');
include_once ('../include/curriculums.php');

include_once ('../include/images.php');

  unset($_SESSION['lesson_id']);

if(isset($_REQUEST['action'])) {
  if ($_REQUEST['action']=="sendnote") {
    $_REQUEST['sub_act']='zero';
    include_once ('./sms_sending-note.php');

    unset($_REQUEST['action']);
    unset($_REQUEST['sub_act']);
  } 
  
  elseif ($_REQUEST['action']=="edit_grades" and $_REQUEST['sub_act']=='zero') {
    
    $sql = "UPDATE `".TABLE_LESSONS."` SET active=("
          ."SELECT if((`date_grade` <> '') AND (DATE_ADD( `date_grade`, INTERVAL 2 DAY ) < NOW()) , 0, 1)"
          ." FROM `".TABLE_STUDENTS_ON_LESSON."` WHERE lesson_id='".$_REQUEST['less']."' ORDER BY `date_grade` DESC LIMIT 0,1)"
          ." WHERE lesson_id='".$_REQUEST['less']."';";
if ($dump)echo "$sql\n";

    $q=mysql_query($sql);
// unset ($_REQUEST);
    unset($_REQUEST['action']);
    unset($_REQUEST['sub_act']);
   
  } 
  
  
}


//mysql_query("UPDATE `".TABLE_LESSONS."` SET active=1 WHERE lesson_id= '".$_REQUEST['less']."'" );  

if ($_REQUEST['delete_this']=='yes') {
  
  $temp=array_shift($_REQUEST);
  
  foreach ($_REQUEST as $key=> $id) 
  {
    $id=substr($key, 2);
  
  //echo $id;  
    $query = "DELETE FROM `".TABLE_LESSONS."` WHERE lesson_id=  '".$id."'";
  //echo $query;
  
    $res=mysql_query($query);
    
    $query="DELETE FROM `".TABLE_STUDENTS_ON_LESSON."` where lesson_id='".$id."'";
    $res=mysql_query($query);
  }
}

  
if ($dump) {echo '<br><pre>$_REQUEST=|';print_r($_REQUEST);echo '</pre>|<br>';}
if ($dump) {echo '<br><pre>$_SESSION=|';print_r($_SESSION);echo '</pre>|<br>';}

  $_lesson_id             = (isset($_REQUEST['lesson_id']))  ? $_REQUEST['lesson_id'] : 
                            $_REQUEST['less'];
//                           ((isset($_REQUEST['lesson_date'])) ?  '' : $_SESSION['lesson_id']);
//  $_SESSION['lesson_id'] = $_lesson_id;

  $class_id              = (isset($_REQUEST['classes']))  ? $_REQUEST['classes'] : $_SESSION['classes'];
  $_SESSION['classes']   = $class_id;

if ($dump)echo $_SESSION['lesson_date'];

  $lesson_date = date('Y-m-d');

if ($dump) echo "|$lesson_date|".$_SESSION['lesson_date'];
if ($dump) {echo '0)<br><pre>$_SESSION=|';print_r($_SESSION);echo '</pre>|<br>';}

//  $lesson_date = (isset($_REQUEST['lesson_date']))  ? $_REQUEST['lesson_date'] : $_SESSION['lesson_date'];
  $lesson_date = (isset($_REQUEST['lesson_date']))  ? mysql_escape_string(implode('-', array_reverse(explode('.', $_REQUEST['lesson_date']))))
                 : ((isset($_SESSION['lesson_date']))  ? $_SESSION['lesson_date'] : $lesson_date);
if ($dump)echo "1)|$lesson_date|";


  $_SESSION['lesson_date'] = $lesson_date;
if ($dump) {echo '1)<br><pre>$_SESSION=|';print_r($_SESSION);echo '</pre>|<br>';}

  $schoolyear = get_school_year_id($lesson_date);
  $_SESSION['schoolyear']  = $schoolyear;

  $_date  = implode('.', array_reverse(explode('-', $lesson_date)));

  $_SESSION['quarterid'] = get_quarter_id($lesson_date);

  list($year, $month, $day) = explode ('-', $lesson_date);

  $week_day = date("w", mktime(0, 0, 0, $month, $day, $year))-1;
  switch ($week_day) {
    case 0: $day=$lang['monday']; break;
    case 1: $day=$lang['vtornik']; break;
    case 2: $day=$lang['sreda']; break;
    case 3: $day=$lang['chetverg']; break;
    case 4: $day=$lang['pytnica']; break;
    case 5: $day=$lang['subbota']; break;
  }


//echo "|$lesson_date|";
//echo "|$_date|$day|";

if(isset($_REQUEST['action'])) {

$dump=0;if ($dump) {echo '<br><pre>$_REQUEST=|';print_r($_REQUEST);echo '</pre>|<br>';}

  $action = $_REQUEST['action'];
  $subject_id=$_REQUEST['subj'];

  unset($_REQUEST['action']);
  unset($_REQUEST['sub_act']);

  if (isset($_REQUEST['grades']))
    $grades  = $_REQUEST['grades'];
  else
    unset($grades);

  $behavior = $_REQUEST['behavior'];
  if (isset($_REQUEST['notes']))
    $notes  = $_REQUEST['notes'];
  else
    unset($notes);

  $studless = $_REQUEST['studless'];

  if ($action == 'update') {

    if (empty($grades)) {
      foreach ($notes[$_lesson_id] as $student_id => $note) {
        $grades = array($_lesson_id=>array($student_id=>'-1'));
      }
    }

    foreach ($grades as $lesson_id => $lesson) {
      foreach ($lesson as $student_id => $grade) {

        $sl = db_query($sql = "SELECT `date_note` FROM `".TABLE_STUDENTS_ON_LESSON."` WHERE studless_id='".$studless[$lesson_id][$student_id]."'");
//        db_query($sql = "DELETE FROM `".TABLE_STUDENTS_ON_LESSON."` WHERE lesson_id=   '".$lesson_id."' AND student_id='".$student_id."'");
        
        if (mysql_num_rows($sl) == 0) {
          if (($grade > 0) || !empty($notes[$lesson_id][$student_id])) {
            $q=mysql_query("SELECT * FROM `".TABLE_LESSONS."` WHERE lesson_id=    '".$lesson_id."' LIMIT 0,1");
            $qu=mysql_query("SELECT * FROM `".TABLE_SCHOOL_QUARTERS."` WHERE `started` <= '".mysql_result($q,0,1)."' AND `finished` >= '".mysql_result($q,0,1)."' LIMIT 0,1");          
//    db_array2insert(TABLE_LESSONS, $fields);

            $fields = array();
            if ($grade!='-1') {
              $fields['grade']    = $grade;
              $fields['behavior'] = $behavior[$lesson_id][$student_id];
            }
            if (isset($notes))
              $fields['note'] = $notes[$lesson_id][$student_id];

            if (!empty($fields)) {
              $fields['student_id'] = $student_id;
              $fields['lesson_id']  = $lesson_id;
              $fields['quater'] = mysql_result($qu,0,0);
              $fields['subj_id'] = $subject_id;

              db_array2insert(TABLE_STUDENTS_ON_LESSON, $fields); // ,"studless_id='".$studless[$lesson_id][$student_id]."'");

            }
//            $sql = "INSERT INTO `".TABLE_STUDENTS_ON_LESSON."` (student_id, lesson_id, grade, behavior, quater, subj_id, `note`) VALUES
//                    ('".$student_id."', '".$lesson_id."', '".$grade."', '".$behavior[$lesson_id][$student_id]."', '"
//                    .mysql_result($qu,0,0)."', '".$subject_id."' , '".$notes[$lesson_id][$student_id]."');";
//            db_query($sql);
          }
        }  //  if (mysql_num_rows($sl) == 0
        else {
          $fields = array();
          if ($grade!='-1') {
            $fields['grade']    = $grade;
            $fields['behavior'] = $behavior[$lesson_id][$student_id];
          }
          if (isset($notes))
            $fields['note'] = $notes[$lesson_id][$student_id];

          if (!empty($fields)) 
            db_array2update(TABLE_STUDENTS_ON_LESSON, $fields,"studless_id='".$studless[$lesson_id][$student_id]."'");
        }

        $row = mysql_fetch_array($sl);
        if (empty($row['date_note'])) {
          $_REQUEST['action']='sendnote';
        }
      }  //  foreach ($lesson
    }  //  foreach ($grades

    exit(header ('Location: lessons.php?&lesson_id='.$_lesson_id.'&subject_id='.$subject_id.'&action='.$_REQUEST['action']));
//    $fields['lesson_order'] = addslashes($_REQUEST['lesson_order']);
  } 
  elseif ($action == 'close') {
    if (!empty($grades))
    foreach ($grades as $lesson_id => $lesson) {
      foreach ($lesson as $student_id => $grade) {
      
        $sl = db_query($sql = "SELECT `date_note` FROM `".TABLE_STUDENTS_ON_LESSON."` WHERE studless_id='".$studless[$lesson_id][$student_id]."'");
//        db_query($sql = "DELETE FROM `".TABLE_STUDENTS_ON_LESSON."` WHERE lesson_id=     '".$lesson_id."' AND student_id='".$student_id."'");
        
        if (mysql_num_rows($sl) == 0) {
          if (!empty($grade) || !empty($notes[$lesson_id][$student_id])) {
            $q=mysql_query("SELECT * FROM `".TABLE_LESSONS."` WHERE lesson_id=      '".$lesson_id."'");
            $qu=mysql_query("SELECT * FROM `".TABLE_SCHOOL_QUARTERS."` 
                 WHERE `started` <= '".mysql_result($q,0,1)."' AND `finished` >= '".mysql_result($q,0,1)."'");

            $sql="INSERT INTO `".TABLE_STUDENTS_ON_LESSON."` (student_id, lesson_id, grade, behavior, quater, subj_id, `note`) VALUES
                 ('".$student_id."', '".$lesson_id."', '".$grade."', '".$behavior[$lesson_id][$student_id]."', '"
                  .mysql_result($qu,0,0)."', '".$subject_id."', '".addslashes($notes[$lesson_id][$student_id])."');";

if ($dump)echo $sql."|2.1\n";
            $res=mysql_query($sql);
          }
        }  //  if (mysql_num_rows($sl) == 0
        else {
          $fields = array();
          if ($grade!='-1') {
            $fields['grade']    = $grade;
            $fields['behavior'] = $behavior[$lesson_id][$student_id];
          }
          if (isset($notes))
            $fields['note'] = $notes[$lesson_id][$student_id];

          if (!empty($fields)) 
            db_array2update(TABLE_STUDENTS_ON_LESSON, $fields,"studless_id='".$studless[$lesson_id][$student_id]."'");

//          $sql = "UPDATE `".TABLE_STUDENTS_ON_LESSON."`"
//                ." SET grade='".$grade."', behavior='".$behavior[$lesson_id][$student_id]."'"
//                .", `note`='".$notes[$lesson_id][$student_id]."'"
//                ." WHERE  studless_id='".$studless[$lesson_id][$student_id]."';";
//          db_query($sql);
        }

        $row = mysql_fetch_array($sl);
        if (empty($row['date_note'])) {
          $_REQUEST['action']='sendnote';
//        $date_note = $row['date_note'];
        }
      }  //  foreach ($lesson
    }  //  foreach ($grades

    $fields = array();
    $fields['topic'] = addslashes($_REQUEST['topic']);
    $fields['dz'] = addslashes($_REQUEST['dz']);
    $fields['active'] = 0;
//    $fields['lesson_order'] = addslashes($_REQUEST['lesson_order']);
//var_dump    ($_REQUEST);
    db_array2update(TABLE_LESSONS, $fields,"lesson_id='".$_lesson_id."'");

//die("!2!")        ;

    exit(header ('Location: lessons.php?&lesson_id='.$_lesson_id.'&subject_id='.$subject_id.'&action='.$_REQUEST['action']));

  }  //  if ($action == 'close')

$dump=0;
}  //  if(isset($_REQUEST['action']))
  
//include 'header.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Страница учителя  <?=NAME_SCHOOL;?></title>
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

.main {
	width: 1259px;
	text-align:center;
	margin:0px;
	padding:0px;
	
}

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
	background-image: url(img/mainbg.jpg);
	margin:0px;
	padding:0px;
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
	background: url(img/top_journal1.png) 0% 0 no-repeat;
}
.journal_bottom1 {
	background: url(img/bottom_journal1.png) 0% 100%  no-repeat;
	padding-top:32px;
	padding-bottom:33px;
			
}
.journal_center1 {
    background: url(img/centr_journal1.png) 0 0;
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
.vkladki_menu {
	height: 50px;
	z-index:10;
	position:absolute;
	left: 45px;
	top: -78px;
	width: 830px;
}

a:link, a:visited {
    color:#27b;
    text-decoration:none;
}
a:hover {
    text-decoration:underline;
}
</style>
</head>

<body>
<div class="main">
<div style="margin: 0px;padding:0px;width:1259px;position:relative;padding-bottom:280px;">
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
<!-- Начало дневника -->
<!-- Фон дневника начало -->
<div class="journal_top">
<div class="journal_bottom">
<div class="journal_center">
<div style="min-height:440px">




</div>
</div>
</div>
</div>
<!-- Фон дневника конец -->
<!-- страницы дневника начало -->
<div class="journal" style="position:absolute; left: 0px; top:200px;z-index:20">
<div class="journal_top1">
<div class="journal_bottom1">
<div class="journal_center1">
<div style="min-height:500px;padding-left:15px;padding-right:15px;" align="center">



<script type="text/javascript" src="../js/wz_tooltip.js"></script>
<div align="center"> 
<?php echo $result_note;?>
<br />
<form action="lessons.php"  method="post" id="ftheme">
<input name="data" type="hidden" value="load"/>
 <table width="350" border="0" cellpadding="2" cellspacing="2" bgcolor="#e7e7e7">
  <tr>
    <td><b><?php echo $lang['lesson_date'];?></b><br />

  <div id="errordiv"></div>



<link type="text/css" href="css/jquery-ui.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-ui.js"></script>
<script type="text/javascript" src="js/ui.datepicker-ru.js"></script>
<script type="text/javascript">

var   cur_note='';

function note_onoff(note, edit) {
  if (note == '') return false;

    if (edit) {
      if (cur_note){
        document.getElementById(cur_note).disabled         = true;
        document.getElementById(cur_note).style.display      = 'none';
        document.getElementById('z'+cur_note).style.display  = 'inline';
        document.getElementById('e'+cur_note).style.display= 'none';
      }
    }

    cur_note='note_'+note;

    if (edit) {
      document.getElementById(cur_note).disabled         = false;
      document.getElementById('e'+cur_note).style.display= 'inline';
    }
    document.getElementById(cur_note).style.display      = 'inline';
    document.getElementById('z'+cur_note).style.display  = 'none';
    document.getElementById(cur_note).focus();
  return true;
}




var  lesson_id=0;
var  subject_id=0;

	$(function() {
		$("#lesson_date_id").datepicker({
			changeMonth: true,
			changeYear: true
		});
	});
	</script>
   <input type="text" name="lesson_date" id="lesson_date_id" value="<?php echo $_date;?>" size="10" 
   onChange="
     if (this.form.classes.value+0 > 0) {
       location = 'lessons.php?classes='+this.form.classes.value+'&lesson_date='+this.value;
     }
   "/></td>


  <td><b><?php echo $lang['class'];?></b><br />
  <div id="classesdiv">
  <select name="classes" onChange="
     if (this.form.lesson_date.value != '') {
       location = 'lessons.php?classes='+this.value+ '&lesson_date='+this.form.lesson_date.value;
     }
   ">
  <option value=""><?php echo $lang['select'];?></option>
<?php 

/*       ewd_getcontent('lessons.php?date='+this.value+'&class=<?php echo $class_id;?>', 'errordiv');*/

if($_SESSION['schoolyear']!='') {
//     print "SESSION";
     //echo "SELECT class_id, class, letter FROM `".TABLE_CLASSES."` WHERE school_year = '".$_SESSION['schoolyear']."'";
  $db_classes = get_classes_list_sel($school_year);
    
  foreach ($db_classes as $classes1) {

    if ($_SESSION['classes'] == $classes1['class_id']) {
     $selclass = "selected";
    } else { $selclass = "";}

    echo "<option $selclass value=\"".$classes1['class_id']."\">".$classes1['class']." ".$classes1['letter']."</option>";
  }
}
  ?>
 </select> 
 </div>
  </td>
 
  <td>&nbsp;<br/>
  <input type="submit" value="<?php echo $lang['data_output'];?>" />
  </td>
 </tr>
 </table>
 </form>
<br>
 
 <br />
<?php
$lesson = array();
if ($_lesson_id !=='')
{
  
//echo "SELECT subject_id FROM `".TABLE_SUBJECTS."` WHERE discipline_id='".$_SESSION['discipline']."' AND teacher_id='".$_SESSION['teacher']."' AND class_id = '".$_SESSION['classes']."'";
  $sql = "SELECT s.*, b.discipline, t.`last_name`, t.`first_name`, t.`middle_name`"
         ." , s.subject_id, l.lesson_id ,l.topic, l.dz, l.schedule_id, a.id_schedule, g.group_id, g.group"
         ." FROM `".TABLE_LESSONS."` AS l"
         ." LEFT JOIN `".TABLE_SCHEDULE."`    AS a ON (a.id_schedule= l.schedule_id)"
         ." LEFT JOIN `".TABLE_SPR_GROUPS."`  AS g ON (g.group_id= a.group_id)"
         ." LEFT JOIN `".TABLE_SUBJECTS."`    AS s ON (l.subject_id = s.subject_id)"
         ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` AS b ON (b.discipline_id = a.discipline_id)"
         ." LEFT JOIN `".TABLE_USERS_TEACHERS."`    AS t ON (t.teacher_id = a.teacher_id)"
         ." WHERE (l.lesson_id = '".$_lesson_id."')"
         ." limit 0,1";

if ($dump) print_r($_SESSION);
$dump=0;if ($dump) echo $sql."\n";

  $res = db_query($sql);
  $lesson = mysql_fetch_array($res);
if ($dump) print_r($lesson);

  $subject_id=$lesson['subject_id']; 
  $lesson['topic'] = str_replace('"', '&#0171;', $lesson['topic']);
  $lesson['topic'] = str_replace("'", '&quot;' , $lesson['topic']);
  $lesson['dz']    = str_replace('"', '&#0171;', $lesson['dz']);
  $lesson['dz']    = str_replace("'", '&quot;' , $lesson['dz']);
}

?>

<form name='download' action='download_grades_templ.php' method='POST'>
<table>
<tr><td><input type='hidden' name='class_id' value="<?php echo $lesson['class_id'];?>"></td>
<td><input type='hidden' name='subject_id' value="<?php echo $subject_id;?>"></td>
<td><input type='submit' value='<?php echo  $lang['get_excel_template'];?>'></td></tr>
</table></form>


<form action="lessons.php">
<!--a href="new_lesson.php?subject_id=<?php echo $subject_id ?>&TB_iframe=true&height=330&width=400&<?php echo uniqid('r'); ?>" title="Создать новый урок" class="thickbox">Новый урок</a-->
<a href="new_lesson_exam.php?subject_id=<?php echo $subject_id ?>&TB_iframe=true&height=330&width=400&<?php echo uniqid('r'); 
   ?>" title="Оценки по экзамену" class="thickbox"><?php echo $lang['add_exam_m'];?></a>

<input type='hidden' name='subject_id' value='<?php print $subject_id; ?>' /></form><br/>


  <form action="lessons.php" method="post" name="main">
  <input type="hidden" name="action" value="update" />
  <input type="hidden" name="subject_id" id="subject_id" value='<?php print $subject_id; ?>'>

<table width="100%" border="0" cellpadding="2" tt=1>
<tr><td valign="top" align="center">
      

  <table id="rounded-corner" width="100%" align="center" border="0" tt=2>
  <thead>
    <tr class="TableHead">
      <th class="rounded-left" width="50"><?php echo $lang['lesson_date'];?></th>
      <th width="200"><?php echo $lang['disclipline']."<br>".$lang['teacher'];?></th>
      <th class="rounded-right" colspan="2"><?php echo $lang['lesson_them'];?></th>
    </tr>
  </thead>

  <tbody>
    <tr><td><?php echo $day."<br>".implode('.', array_reverse(explode('-', $lesson_date)));?></td>
        <td><div id="teacher"><?php echo $lesson['discipline'].((empty($lesson['group'])) ? '' : " [".$lesson['group']."]");?><br><?php echo $lesson['last_name'];?></div></td>

        <td><div id="topicdiv"><input style="width:100%" type="text" name="topic" id="topic" value="<?php echo $lesson['topic'];?>"
        on_Blur="
         if (document.getElementById('lesson_id').value == '') {
           ewd_getcontent('ajaxform-lesson.php?lesson_id='+document.getElementById('lesson_id').value+'&subject_id='+document.getElementById('subject_id').value, 'lessondiv');
         }
        "></div>
        </td>
    </tr>

    <tr><td colspan="2" valign="top" align="left" style="padding:0px;">
       <table width="100%" align="left" border="0" tt=3>
       <thead>
         <tr class="TableHead">
           <th width="20">№</th>
           <th><?php echo $lang['disciplines'];?></th>
         </tr>
       </thead>

       <tbody>

<?php

if ($dump) print_r($_SESSION);

  $sql = "SELECT a.*, a.id_schedule AS schedule_id, b.discipline, t.`last_name`, t.`first_name`, t.`middle_name`"
         ." , s.subject_id, l.lesson_id ,l.topic, l.dz"
         ." FROM `".TABLE_SCHEDULE."` AS a"
         ." LEFT JOIN `".TABLE_SUBJECTS."`    AS s ON (s.discipline_id = a.discipline_id) AND (s.class_id = a.class_id) AND ( s.teacher_id = a.teacher_id )"
         ." LEFT JOIN `".TABLE_LESSONS."`     AS l ON (l.subject_id = s.subject_id)       AND (l.lesson_date = '".$lesson_date."')"
         ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` AS b ON (b.discipline_id = a.discipline_id)"
         ." LEFT JOIN `".TABLE_USERS_TEACHERS."`    AS t ON (t.teacher_id = a.teacher_id)"
         ." WHERE (a.school_year='".$_SESSION['schoolyear']."')"
         ." AND (a.quarter_id='".$_SESSION['quarterid']."')"
         ." AND (a.class_id='".$_SESSION['classes']."')" 
         ." AND (a.date_schedule ='".$week_day."')" 
         ." ORDER BY a.date_schedule,a.order_schedule,a.teacher_id";
/*

SELECT a.`id_schedule`, a.`cabinet`,a.`order_schedule`,a.`started`,a.`finished`
FROM `".TABLE_SCHEDULE."` a WHERE a.`started`=(
SELECT  max(s.`started`)
FROM `".TABLE_SCHEDULE."` s where 
(s.`class_id` = 4)
AND (s.`date_schedule` = DATE_FORMAT( NOW( ) , '%w' ) -1 )
AND (date_format(NOW( ), '%Y-%m-%d') BETWEEN s.`started` AND s.`finished`)
AND (s.order_schedule = a.order_schedule )
ORDER BY s.`date_schedule` , s.`order_schedule` , s.`started` DESC, s.`finished`
)
AND (a.`class_id` = 4)
AND (a.`date_schedule` = DATE_FORMAT( NOW( ) , '%w' ) -1 )
AND (date_format(NOW( ), '%Y-%m-%d') BETWEEN a.`started` AND a.`finished`)

ORDER BY a.`date_schedule` , a.`order_schedule` , a.`started` DESC, a.`finished`

*/

  $sql = "SELECT a.*, a.id_schedule AS schedule_id, b.discipline, t.`last_name`, t.`first_name`, t.`middle_name`"
         ." , s.subject_id, l.lesson_id ,l.topic, l.dz, g.group_id, g.group"
         ." FROM `".TABLE_SCHEDULE."` AS a"
//         ." LEFT JOIN `".TABLE_SUBJECTS."`    AS s ON (s.discipline_id = a.discipline_id) AND (s.class_id = a.class_id) AND ( s.teacher_id = a.teacher_id )"
//         ." LEFT JOIN `".TABLE_LESSONS."`     AS l ON (l.subject_id = s.subject_id)       AND (l.lesson_date = '".$lesson_date."')"
         ." LEFT JOIN `".TABLE_SPR_GROUPS."`  AS g ON (g.group_id= a.group_id)"
         ." LEFT JOIN `".TABLE_LESSONS."`     AS l ON (l.schedule_id= a.id_schedule)&& (`lesson_date`='".$lesson_date."')"
         ." LEFT JOIN `".TABLE_SUBJECTS."`    AS s ON (s.discipline_id = a.discipline_id) AND (s.class_id = a.class_id) AND ( s.teacher_id = a.teacher_id )"
//         ." LEFT JOIN `".TABLE_SUBJECTS."`    AS s ON (s.subject_id = l.subject_id)"
         ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` AS b ON (b.discipline_id = a.discipline_id)"
         ." LEFT JOIN `".TABLE_USERS_TEACHERS."`    AS t ON (t.teacher_id = a.teacher_id)"
         ." WHERE "
         ." (a.`class_id` = '".$_SESSION['classes']."')" 
         ." AND (a.`date_schedule` ='".$week_day."')" 
         ." AND (a.`started`=(
             SELECT  max(sa.`started`)
              FROM `".TABLE_SCHEDULE."` sa WHERE (sa.`class_id` = '".$_SESSION['classes']."')
              AND (sa.`date_schedule` = '".$week_day."')
              AND ('".$lesson_date."' BETWEEN sa.`started` AND sa.`finished`)
              AND (sa.`order_schedule` = a.`order_schedule`)
            ) )"
         ." AND a.teacher_id ='".$_SESSION['teacher_id']."'"
         ." ORDER BY a.date_schedule, a.order_schedule, a.group_id";

$dump=0;if ($dump) echo $sql."\n";

  $db_schedule = mysql_query($sql);

if ($dump) if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

  while ($schedule = mysql_fetch_array($db_schedule)) {
//    $schedule['subject_id'] = str_replace('"', '&quot;' $schedule['subject_id']);
//    $schedule['lesson_id'] = str_replace('"', '&quot;' $schedule['subject_id']);
if ($dump) print_r($schedule);
    $schedule['topic'] = str_replace('"', '&#0171;', $schedule['topic']);
    $schedule['topic'] = str_replace("'", '&quot;',  $schedule['topic']);
    $schedule['dz'] = str_replace('"', '&#0171;', $schedule['dz']);
    $schedule['dz'] = str_replace("'", '&quot;', $schedule['dz']);
    $_date  = implode('.', array_reverse(explode('-', $_SESSION['lesson_date'])));

?>
  <tr>
    <td><?php echo $schedule['order_schedule'];?></td>
    <td><a
    onClick="
     document.getElementById('lesson_id').value  = '<?php echo $schedule['lesson_id'];?>';
     document.getElementById('subject_id').value = '<?php echo $schedule['subject_id'];?>';
     document.getElementById('topic').value = '<?php echo $schedule['topic'];?>';
     document.getElementById('dz').value = '<?php echo $schedule['dz'];?>';

     document.getElementById('teacher').innerHTML = '<?php echo $schedule['last_name'];?>';

     if (document.getElementById('lesson_id').value != '') {
       location= 'lessons.php?lesson_date=<?php echo $_date;?>&lesson_id='+document.getElementById('lesson_id').value;
       return false;
     } else {
      return true;
     }
    "  
    href='ajaxform-lesson.php?schedule_id=<?php echo $schedule['schedule_id'];?>&lesson_id=<?php echo $schedule['lesson_id'];
          ?>&subject_id=<?php echo $schedule['subject_id'];?>&<?php echo uniqid('')?>&keepThis=true&TB_iframe=true&height=200&width=250' 
    title="<?php echo $schedule['discipline'];?>" cl_ass="thickbox"><?php echo $schedule['discipline'];?><?php echo (empty($schedule['group'])) ? '' : " [".$schedule['group']."]";?></a></td>
  </tr>

<?php 
  
  }  //  while ($schedule

//     ewd_getcontent('ajaxform-teacher.php?disciplineid='+this.value+'&class='+this.form.classes.value, 'dzdiv');
/*       subject_id='<?php echo $schedule['subject_id'];?>';*/
/*     lesson_id='<?php echo $schedule['lesson_id'];?>';*/

?>

       </tbody>

       </table>
     </td>
      <td align="left" valign="top" style="padding:0px;">
        <table width="100%" align="left" border="0" tt=4>
        <thead>
          <tr class="TableHead">
            <th colspan="2"><?php echo $lang['lesson_dz'];?>
        <script language='javascript'> 
//         document.write('<a href="edit_lesson.php?subject_id='+subject_id+'&lesson_id='+lesson_id+'&TB_iframe=true&height=300&width=400&<?php echo uniqid('r');?>" title="Редактировать урок" class="thickbox"><?php echo $lang['edit'];?></a></td><td><input value="1" type="checkbox" name="lesson_id">');
        </script>
            </th>
          </tr>
        </thead>

        <tbody>

          <tr>
              <td><div id="dzdiv" align="center"><textarea style="width:100%" name="dz" rows="5" id="dz"><?php echo $lesson['dz'];?></textarea></div>


        <br><br><input type="button" value="<?php echo $lang['end_lesson'];?>" onClick="this.form.action.value='close'; this.form.submit();" <?php if (!$active_leson ) echo ' disa_bled="disa_bled"' ?> />
              <div id="lessondiv"><input type="hidden" name="lesson_id"  id="lesson_id" value="<?php echo $_lesson_id;?>"></div>
              </td>
          </tr>

        </tbody>

        </table>
      </td>
    </tr>
   </tbody>

   <tfoot>
     <tr>
      <td colspan="2" class="rounded-foot-left">&nbsp;</td>
      <td class="rounded-foot-right" colspan="2" align="left"><a href="" onClick="javascript: tb_show('<?php echo $lang['excell_upload'];?>', 'add_theme.php?<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=200&width=400&'); return false;" class="add" title="<?php echo $lang['schedule_upload'];?>"><?php echo $lang['excell_upload'];?></a></td>
     </tr>
    </tfoot>
  </table>


  <table width="100%" border="0" cellpadding="2" t=2>
  <tr><td valign="top" align="center">
  <!--form action="lessons.php" method="post">
  <input type="hidden" name="lesson_id" value="<?php echo $lesson_id ?>" />
  <input type="hidden" name="action1" value="update" /-->
    <table  id="rounded-corner" width="100%" align="center" t=3>
      <thead>
      <tr class="TableHead">
       <th width="15" class="rounded-left">№</th>
       <th width="10"></th>
       <th width="200"><?php echo $lang['students_list'];?></th>
<?php

if (!empty($_lesson_id)) {

  $year  = (empty($_SESSION['schoolyear'])) ? $_SESSION['schoolyear'] : (int)date("Y");
  $month = (empty($_SESSION['month']))      ? $_SESSION['month']      : (int)date("n");

  $sql = "SELECT * FROM `".TABLE_LESSONS."`"
//                   JOIN `".TABLE_SCHOOL_YEARS."` ON school_years.school_year_id='{$year}' 
                 ." WHERE lesson_id= '{$_lesson_id}' 
                    AND lesson_date='".$_SESSION['lesson_date']."'
                   ORDER BY lesson_date";

$dump=0;if ($dump) echo $sql."\n";

  $res = db_query($sql);
  $lessons = array();
  $cols=1; 

  $num_row = mysql_num_rows($res);
  $col_row = 0;

  while ($row = mysql_fetch_assoc($res)) {
    $lessons[] = $row;
    list($year, $month, $day) = explode('-', $row['lesson_date']);
    echo "<th  style='writing-mode:tb-rl' colspan='3'><a href='lessons.php?subject_id=".$subject_id
         ."&action=edit_grades&sub_act=zero&less=".$row['lesson_id']."'>$day.$month</a></th>";
    $col_row++;
  }
}  //  if (!empty($_lesson_id))

?>
   <th class="rounded-right" colspan="1">&nbsp;</th>
  </tr>
  </thead>
  <tbody>

<?php


if (isset($class_id)) {
  $active_leson = false;

if ($dump) {echo '$_lesson_id='.$_lesson_id.'<br><pre>$lessons=|';print_r($lessons);echo '</pre>|<br>';}

  $subject = db_get_first_row("SELECT * FROM `".TABLE_SUBJECTS."` WHERE subject_id='".$subject_id."'");

  $students_list = get_student_classes_list2($class_id);
if ($dump) {echo '<br><pre>$students_list=|';print_r($students_list);echo '</pre>|<br>';}
  $n=1;
  foreach($students_list as $student) {
    
    if (!empty($student['student_photo']))
    {
      $student_photo ="<img src=\'../student_photo/".SUBDOMEN."/sm/$student[student_photo]\'>";
    }
    else
    {
      $student_photo ="<img src=\'../images/nophoto.gif\'>";
    }

    $student['student_address']=str_replace("\r\n"," ",$student['student_address']);

    $pict = (empty($student['active'])) ? '' : '../images/money25.png';
    $pict_alt = (empty($student['active'])) ? '' : 'оплачено';

    echo "<tr><td>$n</td><td style='padding:0px;'><img src='$pict' border=0 alt='$pict_alt' title='$pict_alt'></td><td nowrap=\"nowrap\"><div style='cursor:pointer;' onmouseover=\"Tip('$student_photo <br>{$lang['pin']}: $student[student_pcode]<br> {$lang['student_adress']}: $student[student_address] <br>{$lang['student_teless']}: $student[student_phone]')\" onmouseout=\"UnTip()\">$student[student_name]</div></td>";
//    echo "<tr><td>$n</td><td nowrap=\"nowrap\"><div style='cursor:pointer;' onmouseover=\"Tip('$student_photo <br>{$lang['pin']}: $student[student_pcode]<br> {$lang['student_adress']}: $student[student_address] <br>{$lang['student_teless']}: $student[student_phone]')\" onmouseout=\"UnTip()\">$student[student_name]</div></td>";

    $grades = get_grade_from_lesson2_n($student['student_id'], $_lesson_id);
//    $notes  = get_note_from_lesson2_n($student['student_id'], $_lesson_id);

if ($dump) {echo '<br><pre>$grades=|';print_r($grades);echo '</pre>|<br>';}

    if(!empty($_lesson_id)) {
     foreach ($lessons as $lesson) {
      $submit = false;

$dump=0;if ($dump) {echo $action.'<br><pre>$lesson=|';print_r($lesson);echo '</pre>|<br>'.@$_REQUEST['action'].'=='.'edit_grades'.'&&'.@$_REQUEST['student_id'].'=='.$student['student_id'].'&&'.@$_REQUEST['lesson_id'].'=='.$lesson['lesson_id'];}

      if($grades['behavior'][$lesson['lesson_id']]=='1') {$selected1='selected';} else {$selected1='';}
      if($grades['behavior'][$lesson['lesson_id']]=='2') {$selected2='selected';} else {$selected2='';}
      if($grades['behavior'][$lesson['lesson_id']]=='3') {$selected3='selected';} else {$selected3='';}

      if (!empty($grades[$lesson['lesson_id']])) {
        if ($lesson['active'] == 0) {
          if (($action == 'edit_grades') && @$_REQUEST['student_id'] == $student['student_id'] && @$_REQUEST['lesson_id'] ==$lesson['lesson_id']) {
           //  1 student 
            echo '<td>
                  <input type="hidden" name="studless['.$lesson['lesson_id'].']['.$student['student_id'].']" value="'.$grades['studless'][$lesson['lesson_id']].'" />
                  <input type="text" name="grades['.$lesson['lesson_id'].']['.$student['student_id'].']" size="5" value="'.$grades[$lesson['lesson_id']].'" maxlength="10" /></td>
                  <td><select style="width:100px;" name="behavior['.$lesson['lesson_id'].']['.$student['student_id'].']">';
            echo '<option value="1"'.$selected1.'>'.$lang['otlichnoe'].'</option>
                   <option value="2"'.$selected2.'>'.$lang['udovletvr'].'</option>
                   <option value="3"'.$selected3.'>'.$lang['plohoe'].'</option></select></td>';
            $submit = true;
          }
          else { 
            if($grades['behavior'][$lesson['lesson_id']]=='1') {
              $behavior = $lang['good_poved'];
            } elseif($grades['behavior'][$lesson['lesson_id']]=='2') {
              $behavior =$lang['poved_norm'];
            } elseif($grades['behavior'][$lesson['lesson_id']]=='3') {
              $behavior =$lang['bad_poved'];
            }

            if ($lesson['lesson_order']==10000) { 
              $color="<font color='red'>"; 
              $e_color="</font>";
            } else {
              $e_color=$color=""; 
            }
             
            echo '<td>
                  <input type="hidden" name="studless['.$lesson['lesson_id'].']['.$student['student_id'].']" value="'.$grades['studless'][$lesson['lesson_id']].'" />
                  <a onmouseover="Tip(\''.$behavior.'\')" onmouseout="UnTip()" href="?action=edit_grades&subject_id='.$subject_id
                   .'&lesson_id='.$lesson['lesson_id'].'&student_id='.$student['student_id']
                   .'&month='.$_REQUEST['month'].'&year='.$_REQUEST['year'].'">'
                   .$color.''.$grades[$lesson['lesson_id']].''.$e_color.'</a></td>
                  <td>&nbsp;</td>';
          }
        }  //  if ($lesson['active'] == 0)
        else { 
          $active_leson = true;
          echo '<td>
                <input type="hidden" name="studless['.$lesson['lesson_id'].']['.$student['student_id'].']" value="'.$grades['studless'][$lesson['lesson_id']].'" />
                <input type="text" name="grades['.$lesson['lesson_id'].']['.$student['student_id'].']" size="10" value="'.$grades[$lesson['lesson_id']].'" maxlength="10" /></td>
                <td><select name="behavior['.$lesson['lesson_id'].']['.$student['student_id'].']" 
                onChange="javascript: this.form.submit();">
                <option value="1"'.$selected1.'>'.$lang['otlichnoe'].'</option>
                <option value="2"'.$selected2.'>'.$lang['udovletvr'].'</option>
                <option value="3"'.$selected3.'>'.$lang['plohoe'].'</option></select></td>';
        }
      }  //  if ($grades[$lesson['lesson_id']]
      else {
        if ($lesson['active'] == 0) {
        // Добавить оценку если пусто  
          if ($action == 'add_grades' && @$_REQUEST['student_id'] == $student['student_id'] && @$_REQUEST['lesson_id'] ==$lesson['lesson_id'])  
          {
            echo '<td>
                  <input type="hidden" name="studless['.$lesson['lesson_id'].']['.$student['student_id'].']" value="'.$grades['studless'][$lesson['lesson_id']].'" />
                  <input type="text" name="grades['.$lesson['lesson_id'].']['.$student['student_id'].']" size="10" value="" maxlength="10" /></td>
                  <td><select name="behavior['.$lesson['lesson_id'].']['.$student['student_id'].']" 
                      onChange="document.getElementById('."'".'note_'.$lesson['lesson_id'].'_'.$student['student_id']."'".').disabled=false;this.form.submit();">
                    <option value="1"'.$selected1.'>'.$lang['otlichnoe'].'</option>
                    <option value="2"'.$selected2.'>'.$lang['udovletvr'].'</option>
                    <option value="3"'.$selected3.'>'.$lang['plohoe'].'</option></select></td>';
            $submit = true;
          } else  {
            echo '<td>
                  <input type="hidden" name="studless['.$lesson['lesson_id'].']['.$student['student_id'].']" value="'.$grades['studless'][$lesson['lesson_id']].'" />
                  <a href="?action=add_grades&subject_id='.$subject_id.'&lesson_id='.$lesson['lesson_id'].'&student_id='.$student['student_id']
                   .'" title="'.$lang['add_grade_w'].'">+</a></td>
                  <td>&nbsp;</td>';
          }
        } else {
          $active_leson = true;
          echo '<td>
                <input type="hidden" name="studless['.$lesson['lesson_id'].']['.$student['student_id'].']" value="'.$grades['studless'][$lesson['lesson_id']].'" />
                <input type="text" name="grades['.$lesson['lesson_id'].']['.$student['student_id'].']" size="10" value="" maxlength="10" /></td>
                <td><select name="behavior['.$lesson['lesson_id'].']['.$student['student_id'].']" >
                  <option value="1"'.$selected1.'>'.$lang['otlichnoe'].'</option>
                  <option value="2"'.$selected2.'>'.$lang['udovletvr'].'</option>
                  <option value="3"'.$selected3.'>'.$lang['plohoe'].'</option></select></td>';
        }
      }  //  if ($grades[$lesson['lesson_id']]

      $note = str_replace('"', '`', $grades['note'][$lesson['lesson_id']]);
      echo '<td>
             <span title="'.((empty($note)) ? 'Введите замечание' :$note)
                .'" id="znote_'.$lesson['lesson_id'].'_'.$student['student_id'].'" 
                 onClick="note_onoff(\''.$lesson['lesson_id'].'_'.$student['student_id'].'\','
                   .((empty($active_leson)) ? '1' : '0').');"
                 style="cursor:pointer;">'
                .((empty($note)) ? '+&nbsp;' :'&nbsp;&nbsp;')
                .'Замечание</span>' 
            .'<textarea name="notes['.$lesson['lesson_id'].']['.$student['student_id'].']" 
                   id="note_'.$lesson['lesson_id'].'_'.$student['student_id'].'" style="display:none;" ' 
                  .((empty($active_leson)) ? ' disabled="disabled"' : '')
                  .' rows="1">'.$note.'</textarea>'
          .'</td>';

      echo '<td><a href="" title="Сохранить" '
                 .' id="enote_'.$lesson['lesson_id'].'_'.$student['student_id'].'" '
                 .((empty($submit)) ? 'style="display:none"' : '')
                .' onClick="document.getElementById('."'".'note_'.$lesson['lesson_id'].'_'.$student['student_id']."'".').disabled=false;document.main.submit();return false;">&nbsp;</a></td>';
     }  //  foreach ($lessons
    } else {
    echo '<td colspan="4"></td>';
    }
    echo '</tr>';
    $n++;
    foreach ($lesson as $key=>$value) {

//if ($value['active']!=0) {$active_leson = true; } else $active_leson = false;
    }
  } //  foreach($students_list
}  //  if (isset($class_id))
?>
  </tbody>
<tfoot>
      <tr>
           <td class="rounded-foot-left">&nbsp;</td>
        <td colspan="2">&nbsp;</td>
          <?php for($i=1; $i<=$num_row; $i++) {echo '<td colspan="3">&nbsp;</td>'; } ?>
          <td colspan="1" class="rounded-foot-right"></td>
        </tr>
    </tfoot>
</table>
<br />

<input type="button" value="<?php echo $lang['end_lesson'];?>" onClick="this.form.action.value='close'; this.form.submit();" <?php if (!$active_leson ) echo ' disabled="disabled"' ?> />
</td>
</tr>

</table>
<input type='hidden' name='subj' value='<?php print $subject_id; ?>' />
</form>

<br />
</div> 
<br/> 
<?php
if ($dump) {echo '5)<br><pre>$_SESSION=|';print_r($_SESSION);echo '</pre>|<br>';}
//include 'footer.php';
?>
</div>
</div>
</div>
</div>
<!-- страницы дневника конец -->
<!-- Блок меню-закладок дневника начало-->
<div class="vkladki_menu">
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
<!-- Блок меню-закладок дневника начало-->
<!-- Закладка дневника начало
<div class="zakladka"><a href="">
  <div class="zakladka1"></div></a></div>-->
<!-- Закладка дневника конец-->
<!-- Уголок страницы -->
<!--<div class="ugolok"></div>-->
<!-- Конец дневника -->
</div>


</div>
</div>



</div>

</body>
</html>
