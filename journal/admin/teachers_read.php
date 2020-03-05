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
 
  $file_xls = "../phpexcel/teachers.xls";
  $xlsData = getXLS($file_xls,0); //извлеаем данные из XLS
//echo "\nxlsData=\n";
//var_dump($xlsData);

  $dates=$xlsData[2];
  $i=-1;
//  $class_id=$xlsData[0][0];
//  $subj_id=$xlsData[0][1];
//$dates = array_diff($dates, array(''));
  $grades=array();
  $data_ok=0;
  foreach ($xlsData as $key=>$data) {

//$val = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));

//echo "$i) $data_ok|$key:data=\n";
//var_dump($data);

    for ($y=0, $num = count($data); $y<=$num; $y++) {
      $data[$y] = trim($data[$y]);
      $data[$y] = (empty($data[$y]) || ($data[$y] == '-')) ? '' : $data[$y];
    }

//echo $data[0]."|".strtoupper(iconv('utf-8', "cp1251//IGNORE//TRANSLIT", trim($data[0])))."|".(strtolower(iconv('utf-8', "cp1251//IGNORE//TRANSLIT", trim($data[0]))) == 'Їрьшыш ')."|\n";

    if ($key>2 && empty($data[0]) && empty($data[4])) continue;

    if ($key == 0) {
//$data[1]=NUM_SCHOOL;
      if (NUM_SCHOOL != $data[1]) {
        $ERROR = "╨д╨░╨╣╨╗ ╨╜╨╡ ╨┤╨╗╤П ╤Н╤В╨╛╨╣ ╤И╨║╨╛╨╗╤Л!";
        $ERROR = "╨Ю╤И╨╕╨▒╨║╨░. ╨д╨░╨╣╨╗ `".$_REQUEST['filename']."` ╨┤╨╗╤П ╤И╨║╨╛╨╗╤Л `".$data[1]."`!";
//echo "NUM_SCHOOL=".NUM_SCHOOL."|$ERROR\n";
        if ($_SESSION['admin_id']!="") { header("Location: ./add_teacher.php?mode=not_add&error=".$ERROR); } 
        else { header("Location: ./teachers.php"); } 
        die();
      }
      continue;
    }
    elseif (($key < 2) || empty($data[0])) {
      continue;
    }
//    elseif (strtolower(iconv('utf-8', "cp1251//IGNORE//TRANSLIT", trim($data[0]))) == 'Їрьшыш ') {  //  фамилия
    elseif (trim($data[0]) == '╨д╨░╨╝╨╕╨╗╨╕╤П') {  //  ╤Д╨░╨╝╨╕╨╗╨╕╤П
      $data_ok=1;
      continue;
    }
    elseif (empty($data_ok)) {
      continue;
    }

//    $grades[$i]=array();
    if ($key>2) {
      if (!empty($data[0])) {

        $i++;
        $grades[$i]=array();
        $grades[$i]['teacher_fio']   = trim($data[0]);
        $grades[$i]['teacher_ima']   = trim($data[1]);
        $grades[$i]['teacher_otc']   = trim($data[2]);
        $grades[$i]['teacher_class'] = trim($data[5]);
        $grades[$i]['teacher_login'] = trim($data[6]);
        $grades[$i]['teacher_passw'] = trim($data[7]);
        $grades[$i]['teacher_phone'] = trim($data[8]);
        $grades[$i]['teacher_email'] = trim($data[9]);
      }


      if (!empty($data[3])) {
        $teacher_disc    = explode(",", $data[3]);
        $teacher_classes = explode(",", $data[4]);

        for ($j = 0, $count = count($teacher_disc); $j < $count; $j++) {
          for ($k = 0, $count1 = count($teacher_classes); $k < $count1; $k++) {
            $grades[$i]['teacher_disc'][]    = mysql_real_escape_string(trim($teacher_disc[$j]));
            $grades[$i]['teacher_classes'][] = mysql_real_escape_string(trim($teacher_classes[$k]));
          }  //  for ($i = 0
        }  //  for ($i = 0
      }  //  if (!empty($data[3]))
    }  //  if ($key>2)
//echo "\n1 ) grades[$i]=\n";
//var_dump($grades[$i]);
  }

//  unset ($grades[0]);
//  unset ($grades[1]);
//echo "\n1 ) grades=\n";
//var_dump($grades);
    
  foreach ($grades as $key=>$data) {
//      list ($dd, $mm, $yyyy ) = explode ('_', $data['student_date']);
//      $data['student_date'] = "$yyyy-$mm-$dd";
    if (empty($data['teacher_fio'])) continue;

    $data['teacher_ima']=mysql_real_escape_string($data['teacher_ima']);
    $data['teacher_otc']=mysql_real_escape_string($data['teacher_otc']);
    $data['teacher_fio']=mysql_real_escape_string($data['teacher_fio']);
    $data['teacher_class']=mysql_real_escape_string($data['teacher_class']);
    $data['teacher_login']=mysql_real_escape_string($data['teacher_login']);
    $data['teacher_passw']=mysql_real_escape_string($data['teacher_passw']);
    $data['teacher_phone']=mysql_real_escape_string($data['teacher_phone']);
    $data['teacher_email']=mysql_real_escape_string($data['teacher_email']);

//print_r($data['teacher_disc']);

    $discipline_id = array();
    for ($i = 0, $count = count($data['teacher_disc']); $i < $count; $i++) {

      if (empty($data['teacher_disc'][$i]) || ($data['teacher_disc'][$i] == '-')) continue;

      $sql="SELECT discipline_id  FROM `".TABLE_SPR_DISCIPLINES."` WHERE `discipline`='".$data['teacher_disc'][$i]."' LIMIT 0,1;";
      $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

      if (mysql_num_rows($res)==1) 
      {
        $row = mysql_fetch_array($res);
        $discipline_id[$i]= $row['discipline_id'];
      } else {
//        $data['teacher_disc'][$i] = ucfirst ($data['teacher_disc'][$i]);

        $sql="INSERT INTO `".TABLE_SPR_DISCIPLINES."` (`discipline`) VALUES ('".$data['teacher_disc'][$i]."')";
        $res=mysql_query($sql);
        $discipline_id[$i] = mysql_insert_id();
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
      }
    }  //  for ($i = 0


    $sql="SELECT t.`teacher_id`, s.`login`, t.`passwd` FROM `".TABLE_USERS_TEACHERS."` t"
        ." WHERE t.`last_name`='".$data['teacher_fio']."' AND  t.`first_name`='".$data['teacher_ima']."' AND t.`middle_name`='".$data['teacher_otc']."' LIMIT 0,1;";
//echo "S) ".$class_id."|".$sql."\n<br>";
    $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

    $teacher_id = '';
    if (mysql_num_rows($res)==1) 
    {
      $row = mysql_fetch_array($res);
      $teacher_id = $row['teacher_id'];
      $login    = (empty($data['teacher_login'])) ? "'".$row['login']."'" : "'".$data['teacher_login']."'";
      $password = (empty($data['teacher_passw'])) ? "'".$row['passwd']."'" : "'".$data['teacher_passw']."'";

      $sql="DELETE FROM `".TABLE_SUBJECTS."`"
          ." WHERE `teacher_id`='".$teacher_id."';";
//      $res=mysql_query($sql);
//if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

      $sql="REPLACE INTO `".TABLE_USERS_TEACHERS."` (`teacher_id`, `login`, `passwd`, `first_name`, `middle_name`, `last_name`)" //, `phone`, `email`, `active`)".
          ." VALUES ('".$teacher_id."', `".$login."', '".$password."', '".$data['teacher_ima']."', '".$data['teacher_otc']."', '".$data['teacher_fio']."');"; // , '".$data['teacher_phone']."'", '".$data['teacher_email']."', 1);
//echo "R) ".$teacher_id."|".$sql."\n<br>";
      $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

    }
    else {

      $sql="INSERT INTO `".TABLE_USERS_TEACHERS."` (`teacher_id`, `first_name`, `middle_name`, `last_name`)" //, `phone`, `email`,`active`)
           ."VALUES ('".$teacher_id."', '".$data['teacher_ima']."', '".$data['teacher_otc']."', '".$data['teacher_fio']."');"; //, '".$data['teacher_phone']."', '".$data['teacher_email']."', 1);
//echo "I) ".$teacher_id."|".$sql."\n<br>";
      $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

      $teacher_id = mysql_insert_id();

      $login    = (empty($data['teacher_login'])) ? "concat(`teacher_id`, `last_name`)" : "'".$data['teacher_login']."'";
      $password = (empty($data['teacher_passw'])) ? "MD5('1')" : "'".$data['teacher_passw']."'";

      $sql="UPDATE `".TABLE_USERS_TEACHERS."` SET `login`=".$login.", `passwd`=".$password
         ." WHERE `teacher_id`='".$teacher_id."';";
      $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

    }

    if (!empty($data['teacher_class'])) {
      $sql="SELECT class_id  FROM `".TABLE_CLASSES."` WHERE `class`='".$data['teacher_class']."' LIMIT 0,1;";
      $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

      $class_id = 0;
      if (mysql_num_rows($res)==1) 
      {
        $row = mysql_fetch_array($res);
        $class_id = $row['class_id'];
        $sql="UPDATE `".TABLE_CLASSES."` SET `teacher_id`='".$teacher_id."' WHERE `class_id`='".$class_id."';";
        $res=mysql_query($sql);
      } else {
        $sql="INSERT INTO `".TABLE_CLASSES."` (`class`, `school_year`, `teacher_id`) VALUES ('".$data['teacher_class']."', '".$_REQUEST['school_year']."', '".$teacher_id."');";
        $res=mysql_query($sql);
        $class_id = mysql_insert_id();
      }
//echo "KP)$key:$i=".$sql."<br>\n";
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
    }

    for ($i = 0, $count = count($discipline_id); $i < $count; $i++) {

      if (empty($data['teacher_classes'][$i])) continue;

      $sql="SELECT class_id  FROM `".TABLE_CLASSES."` WHERE `class`='".$data['teacher_classes'][$i]."' LIMIT 0,1;";
      $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

      $class_id = 0;
      if (mysql_num_rows($res)==1) 
      {
        $row = mysql_fetch_array($res);
        $class_id = $row['class_id'];
      } else {
        $sql="INSERT INTO `".TABLE_CLASSES."` (`class`, `school_year`) VALUES ('".$data['teacher_classes'][$i]."', '".$_REQUEST['school_year']."');";
//echo "K)$key:$i=".$sql."<br>\n";
        $res=mysql_query($sql);
        $class_id = mysql_insert_id();
      }

      $sql="INSERT IGNORE INTO `".TABLE_SUBJECTS."` (`teacher_id`, `discipline_id`, `class_id`) VALUES ('".$teacher_id."', '".$discipline_id[$i]."', '".$class_id."');";
//echo $sql."<br>\n";
      $res=mysql_query($sql);
      $subject_id = mysql_insert_id();

if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
    }  //  for ($i = 0
  }  //  foreach ($grades


//die("!!!");

  if ($_SESSION['admin_id']!="") { header("Location: ./add_teacher.php?mode=success_add"); } 
  else { header("Location: ./teachers.php"); } 
  
?>