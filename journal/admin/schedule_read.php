<?php
  define('ADMIN_ZONE', true);
  ini_set("memory_limit", "256M");
  include ("../phpexcel/PHPExcel.php");
/** PHPExcel_Writer_Excel2007 */
  include ("../phpexcel/PHPExcel/Writer/Excel5.php");

  include_once ('../init.php');

  function getXLS($xls, $actsheet){
    include_once '../phpexcel/PHPExcel/IOFactory.php';

    $objPHPExcel = PHPExcel_IOFactory::load($xls);

    $objPHPExcel->setActiveSheetIndex($actsheet);
//    $objPHPExcel->setReadDataOnly(false);

    $aSheet = $objPHPExcel->getActiveSheet();
 
    //этот массив будет содержать массивы содержащие в себе значения ячеек каждой строки
    $array = array();
    //получим итератор строки и пройдемся по нему циклом
    foreach($aSheet->getRowIterator() as $row){
      //получим итератор ячеек текущей строки
      $cellIterator = $row->getCellIterator();
      //пройдемся циклом по ячейкам строки
      //этот массив будет содержать значения каждой отдельной строки
      $item = array();
      foreach($cellIterator as $cell){
        //заносим значения ячеек одной строки в отдельный массив
        array_push($item, $cell->getCalculatedValue());
      }
      //заносим массив со значениями ячеек отдельной строки в "общий массв строк"
      array_push($array, $item);
    }
    return $array;
  }
 
  include ("../include/curriculums.php");
  $quarter = get_cur_quarter();
  $quarter_id = $quarter['quarter_id'];

  $file_xls = "../phpexcel/schedule.xls";
  $xlsData = getXLS($file_xls,0); //извлеаем данные из XLS
//echo "\nxlsData=\n";
//var_dump($xlsData);

  $dates=$xlsData[2];
  $i=-1;
//  $class_id=$xlsData[0][0];
//  $subj_id=$xlsData[0][1];
//$dates = array_diff($dates, array(''));
  $classes = array();
  $grades  = array();
  $data_ok = 0;
  foreach ($xlsData as $key=>$data) {

//$val = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));


    for ($y=0, $num = count($data); $y<=$num; $y++) {
      $data[$y] = trim($data[$y]);
      $data[$y] = (empty($data[$y]) || ($data[$y] == '-') || ($data[$y] == 'NULL')) ? '' : $data[$y];
    }

//echo "$i) $data_ok|$key:data=\n";
//var_dump($data);

//echo $data[0]."|".(trim($data[0]) == '╨Ф╨╜╨╕ ╨╜╨╡╨┤╨╡╨╗╨╕')."|\n";

//echo $data[0]."|".strtoupper(iconv('utf-8', "cp1251//IGNORE//TRANSLIT", trim($data[0])))."|".(strtolower(iconv('utf-8', "cp1251//IGNORE//TRANSLIT", trim($data[0]))) == 'фэш эхфхыш')."|\n";

    if ($key == 0) {
$data[1]=NUM_SCHOOL;
      if (NUM_SCHOOL != $data[1]) {
        $ERROR = "╨д╨░╨╣╨╗ ╨╜╨╡ ╨┤╨╗╤П ╤Н╤В╨╛╨╣ ╤И╨║╨╛╨╗╤Л!";
        $ERROR = "╨Ю╤И╨╕╨▒╨║╨░. ╨д╨░╨╣╨╗ `".$_REQUEST['filename']."` ╨┤╨╗╤П ╤И╨║╨╛╨╗╤Л `".$data[1]."`!";
//echo "NUM_SCHOOL=".NUM_SCHOOL."|$ERROR\n";
        if ($_SESSION['admin_id']!="") { header("Location: ./add_schedule.php?mode=not_add&error=".$ERROR); } 
        else { header("Location: ./schedule-journal.php"); } 
        die();
      }
      continue;
    }
//    elseif (strtolower(iconv('utf-8', "cp1251//IGNORE//TRANSLIT", trim($data[0]))) == 'фэш эхфхыш') {  //  Дни недели
    elseif (trim($data[0]) == '╨Ф╨╜╨╕ ╨╜╨╡╨┤╨╡╨╗╨╕') {  //  Дни недели
      $date_schedule = -1;
      $classes = array();
      $num_c   = 0;

      $data_ok = 1;
      $num   = floor((count($data)-2)/3);
      $num_c = 0;
      for ($k = 0; $k < $num; $k++) {
        if (empty($data[$k*3+2])) continue;
          
        if (strpos($data[$k*3+2], '/') > 1) {
          $data[$k*3+2] = str_replace('./', '/', $data[$k*3+2]);
          $classes[$num_c] = explode('/',$data[$k*3+2]);
          for ($kk = 0, $count=count($classes[$num_c]); $kk < $count; $kk++) {
            $classes[$num_c][$kk] = trim($classes[$num_c][$kk]);
          }
        } else
          $classes[$num_c] = $data[$k*3+2];
        $num_c++;
      }  //  for ($k = 0

//echo "\n!!!$key#$i) ".$data[0]."|".$data[1]."|".$date_schedule."|num=".$num_c."\n";print_r($classes);
      continue;
    }
    elseif (empty($data_ok)) {
      continue;
    }

    if ($key>2 && empty($data[1]) && !empty($data_ok)) continue;

//echo "\n!!!$key#$i) ".$data[0]."|".$data[1]."|".$date_schedule."\n";
    if ($key>2) {
      if (!empty($data[0])) {
        $date_schedule++;
      }

      if (!empty($data[1])) {
        $data[1] = trim($data[1]);
//        $grades[$i]=array();
        $kk = -1;
        for ($k = 0; $k < $num_c; $k++) {
          if (empty($data[$k*3+2])) continue;

          if (is_array($classes[$k])) {
            if ($kk < 0) {
              $kk = 0;
              $kkm = count($classes[$k]);
            } else
              $kk++;
            $class = $classes[$k][$kk];
          } else {
            $kk = -1;
            $class = $classes[$k];
          }
          
          $i++;
          list($kab    , $kab2)         = explode('/',$data[$k*3+2+1]);
          list($teacher, $teacher2) = explode('/',$data[$k*3+2+2]);
          $grades[$i]['date_schedule']    = $date_schedule;
          $grades[$i]['order_schedule']   = $data[1];
          $grades[$i]['schedule_class']   = $class;
          list($discl, $discl2) = explode('/',$data[$k*3+2]);
          $grades[$i]['schedule_discl']   = trim($discl  );
          $grades[$i]['schedule_kab']     = trim($kab    );
          $grades[$i]['schedule_teacher'] = trim($teacher);

          if (!empty($kab2) || !empty($teacher2) || !empty($discl2)) {
            $i++;
            $grades[$i]['date_schedule'   ] = $date_schedule;
            $grades[$i]['order_schedule'  ] = $data[1];
            $grades[$i]['schedule_class'  ] = $class;
            $grades[$i]['schedule_discl'  ] = (empty($discl2  )) ? trim($discl  ) : trim($discl2  );
            $grades[$i]['schedule_kab'    ] = (empty($kab2    )) ? trim($kab    ) : trim($kab2    );
            $grades[$i]['schedule_teacher'] = (empty($teacher2)) ? trim($teacher) : trim($teacher2);
          } 


//echo "\n$key#$i) k=$k(kk=$kk):".$date_schedule."|".$data[1]."|classes[$k]=\n";print_r ($classes[$k]);echo "\ngrades[$i]=\n";var_dump($grades[$i]);

          if (($kk > -1) && ($kk+1 < $kkm)){
            $k--;
          }
        }  //  for ($k = 0
      }

    }  //  if ($key>2)
//echo "\n1 ) grades[$i]=\n";var_dump($grades[$i]);

  } //  foreach($xlsData
if ($dump) var_dump($grades);

//  unset ($grades[0]);
//  unset ($grades[1]);
//echo "\n1 ) grades=\n";var_dump($grades);
//die("!!!");

    $discipline_id = array();
    $sql="SELECT `discipline_id`, `discipline`  FROM `".TABLE_SPR_DISCIPLINES."`;";
    $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

    if (mysql_num_rows($res) > 0) {
      while($row = mysql_fetch_array($res))
        $discipline_id[$row['discipline']] = $row['discipline_id'];
    }

//echo "\n1 ) discipline_id=\n";var_dump($discipline_id);

    $class_id = array();
    $sql = "SELECT `class_id`, `class`  FROM `".TABLE_CLASSES."`"
          ." WHERE `school_year`='".$_REQUEST['school_year']."';";
    $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

    if (mysql_num_rows($res) > 0) 
    {
      while($row = mysql_fetch_array($res))
        $class_id[$row['class']] = $row['class_id'];
    }

//echo "\n1)$sql| class_id=\n";var_dump($class_id);

    $teacher_id = array();
    $sql = "SELECT `teacher_id`, `last_name`  FROM `".TABLE_USERS_TEACHERS."`;";
    $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

    if (mysql_num_rows($res) > 0) 
    {
      while($row = mysql_fetch_array($res)) 
        $teacher_id[$row['last_name']] = $row['teacher_id'];
    }

//echo "\n1 ) teacher_id=\n";var_dump($teacher_id);

  $sql="DELETE FROM `".TABLE_SCHEDULE."`"
      ." WHERE `school_year`='".$_REQUEST['school_year']."';";
  $res=mysql_query($sql);

  foreach ($grades as $key=>$data) {
//      list ($dd, $mm, $yyyy ) = explode ('_', $data['student_date']);
//      $data['student_date'] = "$yyyy-$mm-$dd";
    if (empty($data['schedule_discl'])) continue;

    $data['date_schedule'   ] = mysql_real_escape_string($data['date_schedule'   ]);
    $data['order_schedule'  ] = mysql_real_escape_string($data['order_schedule'  ]);
    $data['schedule_class'  ] = mysql_real_escape_string($data['schedule_class'  ]);
    $data['schedule_discl'  ] = mysql_real_escape_string($data['schedule_discl'  ]);
    $data['schedule_kab'    ] = mysql_real_escape_string($data['schedule_kab'    ]);
    $data['schedule_teacher'] = mysql_real_escape_string($data['schedule_teacher']);

    list($data['schedule_teacher']) = explode(' ', $data['schedule_teacher']);

//print_r($data['teacher_disc']);

    $sql = "INSERT INTO `".TABLE_SCHEDULE."` (`date_schedule`, `school_year`, `discipline_id`, `class_id`, `cabinet`, `teacher_id`"
          .", `quarter_id`, `order_schedule`, `started`,`finished`) VALUES"
          ." ('".$data['date_schedule']."', '".$_REQUEST['school_year']."', '".$discipline_id[$data['schedule_discl']]."'"
          .", '".$class_id[$data['schedule_class']]."', '".$data['schedule_kab']."', '".$teacher_id[$data['schedule_teacher']]."'"
          .", '".$quarter_id."', '".$data['order_schedule']."'"
          .", '".$quarter['started']."', '".$quarter['finished']."');"
          ." #'".$data['date_schedule']."', '".$_REQUEST['school_year']."', '".$data['schedule_discl']."', '".$data['schedule_class']."', '".$data['schedule_kab']."', '".$data['schedule_teacher']."', '".$quarter_id."', '".$data['order_schedule']."'\n";
    $res=mysql_query($sql);

if ($dump) echo mysql_insert_id().": ".$sql."<br>\n";

if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

  }  //  foreach ($grades


//die("!!!");

  if ($_SESSION['admin_id']!="") { header("Location: ./add_schedule.php?mode=success_add"); } 
  else { header("Location: ./schedule-journal.php"); } 
  
?>