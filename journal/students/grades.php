<?php
define('STUDENT_ZONE', true);
include_once ('../parts/head.php');
include_once ('../include/report.php');
include_once ('../include/classes.php');
include_once ('../include/students.php');

$dump=0;if ($dump) {echo '|$_GET=';print_r($_GET);}

$students = get_student($_SESSION['student_id']);
//print_r($students);
if ($_GET['t'] == "") {
    $dnum = date("w");
    $d = $dnum - 1;
    $first_td = array();

    $ng = array();
    $ng[]=$lang['monday']  ;
    $ng[]=$lang['vtornik'] ;
    $ng[]=$lang['sreda']   ;
    $ng[]=$lang['chetverg'];
    $ng[]=$lang['pytnica'] ;
    $ng[]=$lang['subbota'] ;
    $nd = array();
    for ($j = 0, $countj=count($ng); $j < $countj ; $j++) {
      for ($i = 0, $counti=strlen($ng[$j]); $i < $counti ; $i+=2) {
        $nd[$j].='&nbsp;'.$ng[$j][$i].$ng[$j][$i+1].'&nbsp; ';
      }
    }
//var_dump($nd);
    for ($j = 0; $j <= 5; $j++) {

        if (isset($_GET['date'])) {
            $date_d = date('d', strtotime($_GET['date']));
            $date_m = date('m', strtotime($_GET['date']));
            $date_y = date('Y', strtotime($_GET['date']));
            $date_day = date('Y-m-d', mktime(0, 0, 0, $date_m, $date_d + $j - $d, $date_y));
            $date_month = date('m', mktime(0, 0, 0, $date_m, $date_d + $j - $d, $date_y));
            $date_d1 = date('d', mktime(0, 0, 0, $date_m, $date_d + $j - $d, $date_y));
        } else {
            $date_day = date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + $j - $d, date('Y')));
            $date_d1 = date('d', mktime(0, 0, 0, date('m'), date('d') + $j - $d, date('Y')));
            $date_month = date('m', mktime(0, 0, 0, date('m'), date('d') + $j - $d, date('Y')));
        }

        $report_indx_list = get_report_indx_list($_SESSION['class_id'], $j);
if ($dump) {echo '|$report_indx_list=';print_r($report_indx_list);}
        $month_table = "";
        if ($j == 0 or $j == 3) {
          if ($j == 3) {
            $first_td[$j].= $students['student_name'] .'&nbsp;&nbsp;&nbsp;'.$students['class_name'];

          } 
//          else                $first_td[$j].= "&nbsp;<br />&nbsp;<br />";


          $first_td[$j].="<table border='0' width='100%' cellspacing='0' cellpadding='0'><tr><td align='right'>" . show_months_ru($date_month).'</td></tr>';
        }
        $first_td[$j].="<table border='1' width='100%' cellspacing='0' cellpadding='0' class='shedule'>
            <tr><th width='20'>{$date_d1}</th><th>№<th width='110'>Предмет</th><th>Домашнее задание</th><th width='65'>Оценка</th></tr>
            <tr><td rowspan=11 valign='top'class='ned'>{$nd[$j]}</td>"; //  {$days[$j]}&nbsp;

        $i = 1;
        for ($num = 0; $num < 10; $num++) {
            //foreach($report_indx_list as $report_indx) {


            $report_indx_lessons = get_report_indx_lessons_by_student($report_indx_list[$num]['subject_id'], $date_day, $report_indx_list[$num]['order_schedule']);
if ($dump) {echo '|$report_indx_lessons=';print_r($report_indx_lessons);}
            foreach ($report_indx_lessons as $report_lessons) {
                
            }

            if (!empty($report_indx_list[$num]['order_schedule']) || $i < 5) {

              $first_td[$j].=((empty($num)) ? "" : "<tr>")."<td>&nbsp;{$report_indx_list[$num]['order_schedule']}<td id='distipline'>{$report_indx_list[$num]['discipline']}&nbsp;";
              $first_td[$j].= "<td id='dz'>{$report_lessons['dz']}&nbsp;<td id='grade'>{$report_lessons['grade']}&nbsp;";
              $first_td[$j].= "</td></tr>";
              $i++;
            }

//            unset($report_indx);
            unset($report_lessons);

        }

        if ($i == 1)
            $first_td[$j].= "<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>";
        $first_td[$j].= "</table>";
    }  //  for ($j = 0;

?>

    <div id="rc">
        <span class="right_col">

<?php
    echo $first_td[3];
    echo $first_td[4];
    echo $first_td[5];
?>

        </span></div>
    <div id="lc">
        <span class="right_left">
            <div class="body_d">
<?php
    echo $first_td[0];
    echo $first_td[1];
    echo $first_td[2];
?>

    <div id="nav">
       <div style="width:100%;  float:left; text-align:center;">
            <a href="?date=<?php
    if (isset($_GET['date'])) {
        $date_d = date('d', strtotime($_GET['date']));
        $date_m = date('m', strtotime($_GET['date']));
        $date_y = date('Y', strtotime($_GET['date']));
        echo date('Y-m-d', mktime(0, 0, 0, $date_m, $date_d - 7, $date_y));
    } else {
        echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 7, date('Y')));
    }
?>"><img src="<?php echo $lang['raspisanie_prev'] ?>" ></a>

       <a href="?date=<?php echo date('Y-m-d'); ?>"><img src="<?php echo $lang['raspisanie_curr'] ?>" width:120px; ></a>

       <a href="?date=<?php
       if (isset($_GET['date'])) {
           $date_d = date('d', strtotime($_GET['date']));
           $date_m = date('m', strtotime($_GET['date']));
           $date_y = date('Y', strtotime($_GET['date']));
           echo date('Y-m-d', mktime(0, 0, 0, $date_m, $date_d + 7, $date_y));
       } else {
           echo date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') - 7, date('Y')));
       }
       ?>"><img src="<?php echo $lang['raspisanie_next'] ?>"></a>

       
       </div>
     </div>
<!-- -->


<?php
}  //  if ($_GET['t'] == "")
  
elseif ($_GET['t'] == "quater") {
      $q = "select q.quarter_name, q.started, q.finished FROM `".TABLE_SCHOOL_QUARTERS."` as q"
          ." JOIN `".TABLE_SCHOOL_YEARS."` as y on y.school_year_id=q.school_year_id"
          ." WHERE y.current=1 and q.quarter_type=1 AND q.current=1";
$dump=0;if ($dump) {echo '|$q='.$q;}

          $res = mysql_query($q);

          while ($row = mysql_fetch_assoc($res)) {
              $names[] = $row['quarter_name'];
              $grades = get_student_quarter_grade($row['started'], $row['finished']);
if ($dump) {echo '|$grades=';print_r($grades);}
              if (!empty($grades))
                foreach ($grades as $value)
                  $arr[$value['discipline']][$row['quarter_name']] = $value['aver'];
          }
if ($dump) {echo '|$names=';print_r($names);}
if ($dump) {echo '|$arr=';print_r($arr);}
?>

          <div id="rc">
              <span class="right_col"><br>
              </span></div>
          <div id="lc">
              <span class="right_left">
                  <div class="body_d">


<?php
        echo "Четвертные оценки за текущий учебный год";
        echo "<table border=1 cellspacing='0' cellpadding='0'><tr><th>Предмет</th>";
        foreach ($names as $value) {
            echo "<th>{$value}</th>";
        }
        echo "</tr>\n";

      if (!empty($grades))
        foreach ($arr as $discipline => $grade) {
            echo "<tr><td>$discipline</td>";
            foreach ($names as $value) {
                echo "<td>" . round($grade[$value], 1)."</td>";
            }
          echo "</tr>\n";
        }
          echo "</table>";
}  //  if ($_GET['t'] == "quater")
    
elseif ($_GET['t'] == "year") {
          $q = "select q.quarter_name, y.started, y.finished FROM `".TABLE_SCHOOL_QUARTERS."` as q
                JOIN `".TABLE_SCHOOL_YEARS."` as y on y.school_year_id=q.school_year_id
                where y.current=1 and q.quarter_type=1";
        $res = mysql_query($q);

        while ($row = mysql_fetch_assoc($res)) {
               $names[] = $row['quarter_name'];
               $grades = get_student_quarter_grade($row['started'], $row['finished']);
               foreach ($grades as $value){
                   $arr[$value['discipline']][$row['quarter_name']] = $value['aver'];
//		   $arr2[$value['discipline']]['subject_id'] = $value['subject_id'];
		   $arr2[$value['discipline']]['subject_id'] = $value['lesson_id'];
               } 
        }
		 
if ($dump) {echo '|$names=';print_r($names);}
if ($dump) {echo '|$arr=';print_r($arr);}
if ($dump) {echo '|$arr2=';print_r($arr2);}

?>

           <div id="rc">
               <span class="right_col"><br>
               </span></div>
           <div id="lc">
               <span class="right_left">
                   <div class="body_d">


<?php

        echo "Годовые оценки за текущий учебный год";
        echo "<table border=1 cellspacing='0' cellpadding='0'><tr><th>Предмет</th><th>Годовая</th><th>Экзамен</th><th>Итог</th></tr>";
      

        foreach ($arr as $discipline => $grade) {
            $year=0; $i=0;
            echo "<tr><td>$discipline</td>";
            foreach ($names as $value) {
                $year+=$grade[$value]; $i++;
            }
          
            
            $exam=get_student_exam_grade($arr2[$discipline]['subject_id']);
if ($dump) {echo empty($exam).'|$exam=';var_dump($exam);}

            if (empty($exam))
            {
                $exam='N\A';
                $itog='N\A';
            }
            else
            {
                $itog=round(($exam+$year)/2,1);
                             
            }
            echo "<td>" . round($year/$i, 1)."</td><td>{$exam}</td><td>{$itog}</td></tr>";
        }
        
        echo "</table>";
}  //  if ($_GET['t'] == "year")


include_once ('../parts/foot.php');
?>
	
