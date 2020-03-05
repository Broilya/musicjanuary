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
 
  $file_xls = "../phpexcel/students.xls";
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

//echo "$i) $data_ok|$key:data=\n";
//var_dump($data);

    for ($y=0, $num = count($data); $y<=$num; $y++) {
      $data[$y] = trim($data[$y]);
      $data[$y] = (empty($data[$y]) || ($data[$y] == '-')) ? '' : $data[$y];
    }

//echo $data[0]."|".strtoupper(iconv('utf-8', "cp1251//IGNORE//TRANSLIT", trim($data[0])))."|".(strtolower(iconv('utf-8', "cp1251//IGNORE//TRANSLIT", trim($data[0]))) == '╘рьшыш ')."|\n";

    if ($key > 3 && empty($data[0])) continue;

    if ($key == 0) {
$data[1]=NUM_SCHOOL;
      if (NUM_SCHOOL != $data[1]) {
        $ERROR = "╨д╨░╨╣╨╗ ╨╜╨╡ ╨┤╨╗╤П ╤Н╤В╨╛╨╣ ╤И╨║╨╛╨╗╤Л!";
        $ERROR = "╨Ю╤И╨╕╨▒╨║╨░. ╨д╨░╨╣╨╗ `".$_REQUEST['filename']."` ╨┤╨╗╤П ╤И╨║╨╛╨╗╤Л `".$data[1]."`!";
//echo "NUM_SCHOOL=".NUM_SCHOOL."|$ERROR\n";
        if ($_SESSION['admin_id']!="") { header("Location: ./add_student.php?mode=not_add&error=".$ERROR); } 
        else { header("Location: ./students.php"); } 
        die();
      }
      continue;
    }
    elseif ($key == 1) {
      if (empty($data[1])) {
        $ERROR = "╨Э╨╡╤В ╨╜╨╛╨╝╨╡╤А╨░ ╨║╨╗╨░╤Б╤Б╨░!";
        if ($_SESSION['admin_id']!="") { header("Location: ./add_student.php?mode=not_add&error=".$ERROR); } 
        else { header("Location: ./students.php"); } 
        die();
      }

      $student_class = $data[1];
      continue;
    }
    elseif (($key < 3) || empty($data[0])) {
      continue;
    }
//    if (function_exists ('iconv')) $massiv[$k] = iconv('cp1251', "utf-8//IGNORE//TRANSLIT", $massiv[$k]);
//    elseif (strtolower(iconv('utf-8', "cp1251//IGNORE//TRANSLIT", trim($data[0]))) == 'Їрьшыш ') {  //  фами<ия
    elseif (trim($data[0]) == '╨д╨░╨╝╨╕╨╗╨╕╤П') {  //  фамилия
      $data_ok=1;
      continue;
    }
    elseif (empty($data_ok)) {
//echo strtolower(iconv('utf-8', "cp1251//IGNORE//TRANSLIT", trim($data[0])));
      continue;
    }

    $i++;
    $grades[$i]=array();

//$val = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));
    
    $grades[$i]['student_class'] = $student_class;
    $grades[$i]['student_fio']   = $data[0];
    $grades[$i]['student_ima']   = $data[1];
    $grades[$i]['student_otc']   = $data[2];
    $grades[$i]['student_login'] = $data[3];
    $grades[$i]['student_passw'] = $data[4];
    $grades[$i]['parent1_fio']   = (empty($data[5]) || ($data[5] == '-')) ? $data[0] : $data[5];
    $grades[$i]['parent1_ima']   = $data[6];
    $grades[$i]['parent1_otc']   = $data[7];
    $grades[$i]['parent1_phone'] = $data[8];
    $grades[$i]['parent1_email'] = $data[9];
//    $grades[$i]['student_email']=(empty($data[7]) || ($data[7] == '-')) ? '' : $data[7];

  }

//  unset ($grades[0]);
//  unset ($grades[1]);

//echo "|".$_REQUEST['school_year']."|";

//echo "\n1 ) grades=\n";
//var_dump($grades);

  foreach ($grades as $key=>$data) {
//      list ($dd, $mm, $yyyy ) = explode ('_', $data['student_date']);
//      $data['student_date'] = "$yyyy-$mm-$dd";

      $data['student_class']=mysql_real_escape_string($data['student_class']);
      $data['student_ima']=mysql_real_escape_string($data['student_ima']);
      $data['student_otc']=mysql_real_escape_string($data['student_otc']);
      $data['student_fio']=mysql_real_escape_string($data['student_fio']);
      $data['student_login']=mysql_real_escape_string($data['student_login']);
      $data['student_passw']=mysql_real_escape_string($data['student_passw']);
      $data['student_phone']=mysql_real_escape_string($data['student_phone']);
      $data['student_email']=mysql_real_escape_string($data['student_email']);
      $data['parent1_ima']=mysql_real_escape_string($data['parent1_ima']);
      $data['parent1_otc']=mysql_real_escape_string($data['parent1_otc']);
      $data['parent1_fio']=mysql_real_escape_string($data['parent1_fio']);
      $data['parent1_phone']=mysql_real_escape_string($data['parent1_phone']);
      $data['parent1_email']=mysql_real_escape_string($data['parent1_email']);
      $mode = (empty($data['parent1_phone'])) ? 0: 1;

      $sql="SELECT `class_id`  FROM `".TABLE_CLASSES."` WHERE `class`='".$data['student_class']."' LIMIT 0,1;";
      $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

      $class_id = 0;
      if (mysql_num_rows($res)==1) 
      {
        $row = mysql_fetch_array($res);
        $class_id = $row['class_id'];
      } else {
        $sql="INSERT INTO `".TABLE_CLASSES."` (`class`, `school_year`) VALUES ('".$data['student_class']."', '".$_REQUEST['school_year']."')";
        $res=mysql_query($sql);
        $class_id = mysql_insert_id();
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
      }


      $sql="SELECT s.`student_id`, s.`pin_code`, s.`login`, s.`password`  FROM `".TABLE_USERS_STUDENTS."` s"
          ." LEFT JOIN `".TABLE_STUDENTS_IN_CLASS."` sc ON (sc.`student_id`=s.`student_id`)"
          ." WHERE s.`last_name`='".$data['student_fio']."' AND  s.`first_name`='".$data['student_ima']."' AND s.`middle_name`='".$data['student_otc']."' AND sc.`class_id`='".$class_id."' LIMIT 0,1;";
//echo "Ss) ".$class_id."|".$sql."\n<br>";
      $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

      $student_id = '';
      if (mysql_num_rows($res)==1) 
      {
        $row = mysql_fetch_array($res);
        $student_id = $row['student_id'];
        $pin_code = $row['pin_code'];
        $login    = (empty($data['student_login'])) ? "'".$row['login']."'"    : "'".$data['student_login']."'";
        $password = (empty($data['student_passw'])) ? "'".$row['password']."'" : "'".$data['student_passw']."'";

        $sql="DELETE FROM `".TABLE_STUDENTS_IN_CLASS."`"
            ." WHERE `student_id`='".$student_id."';";
        $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

        $sql="REPLACE INTO `".TABLE_USERS_STUDENTS."` (`student_id`, `login`, `password`, `first_name`, `middle_name`, `last_name`, `phone`, `mother_fio`, `mother_cell_phone`, `email`, `pin_code`, `mode`, `active`) VALUES".
             " ('".$student_id."', `".$login."', '".$password."', '".$data['student_ima']."', '".$data['student_otc']."', '".$data['student_fio']."', '".$data['student_phone']."'" //, '".$data['student_email']."'
            .", '".$data['parent1_fio']." ".$data['parent1_ima']." ".$data['parent1_otc']."', '".$data['parent1_phone']."', '".$data['parent1_email']."', '".$pin_code."', '".$mode."', 0);";
//echo "R) ".$student_id."|".$sql."\n<br>";
        $res=mysql_query($sql);

if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
      }  //  if (mysql_num_rows($res)==1)

      else {
        while(1) {
          $pin_code = rand(100000,999999);
          $sql="SELECT s.`pin_code`  FROM `".TABLE_USERS_STUDENTS."` s"
              ." WHERE s.`pin_code`='".$pin_code."';";
          $res=mysql_query($sql);
          if (mysql_num_rows($res) == 0) 
            break;
        }

        $sql="INSERT INTO `".TABLE_USERS_STUDENTS."` (`student_id`, `first_name`, `middle_name`, `last_name`, `phone`, `mother_fio`, `mother_cell_phone`, `email`, `pin_code`, `mode`, `active`) VALUES"
            ." ('".$student_id."', '".$data['student_ima']."', '".$data['student_otc']."', '".$data['student_fio']."', '".$data['student_phone']."'" //, '".$data['student_email']."'
            .", '".$data['parent1_fio']." ".$data['parent1_ima']." ".$data['parent1_otc']."', '".$data['parent1_phone']."', '".$data['parent1_email']."', '".$pin_code."', '".$mode."', 0);";
//echo "Is) ".$student_id."|".$sql."\n<br>";
        $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

        $student_id = mysql_insert_id();
//        
        $login    = (empty($data['student_login'])) ? "concat(`student_id`, `last_name`)" : "'".$data['student_login']."'"
        $password = (empty($data['student_passw'])) ? substr(md5(rand(100000,999999)), 0, 6) : "'".$data['student_passw']."'";

        $sql="UPDATE `".TABLE_USERS_STUDENTS."` SET `login`=".$login.", `password`=".$password
           ." WHERE `student_id`='".$student_id."';";
        $res=mysql_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

        if (TEST_DAYS > 0) {
          $sql = "INSERT INTO `".TABLE_STUDENTS_IN_SERVICE."` (`student_id`, `service_id`, `tarif`, `date_add`)"
                ." SELECT '".$student_id."', s.`service_id`, s.`tarif`, NOW() FROM `".TABLE_BALANCE_SERVICES."` s"
                ." WHERE s.`required` ='1';";
//echo "Iss)".$sql."\n<br>";
          db_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }

          $sql = "SELECT sum(ss.`tarif`) FROM `".TABLE_STUDENTS_IN_SERVICE."` ss"
                ." WHERE ss.`student_id`='".$student_id."';";
//echo "Sss)".$sql."\n<br>";
          $tarif_all = db_get_cell($sql);

          $data['student_balance'] = (int)(TEST_DAYS*$tarif_all/30);

          if ($data['student_balance'] > 0) {
            $data['student_operator'] = -1;
            $data['student_nomer'] = '';
    
            $sql = "REPLACE INTO `".TABLE_BALANCE."`  (`id`, `student_id`, `date_add`, `summa`, `operator_id`, `date_edit`, `active`) VALUES"
                  ." ('".$balance_id."', '".$student_id."', NOW(), '".$data['student_balance']."', '".$data['student_operator']."', NOW(), 1);";
//echo "Rb)".$sql."\n<br>";
            db_query($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
          }
        }  //  if (TEST_DAYS > 0)
      }  //  if (mysql_num_rows($res)==1)


      $sql="INSERT INTO `".TABLE_STUDENTS_IN_CLASS."` (`student_id`, `class_id`) VALUES ('".$student_id."', '".$class_id."')";
//echo "Isc)".$sql."<br>\n";
      $res=mysql_query($sql);

if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
  }  //  foreach ($grades

  setStudentActive ();
//      $sql="UPDATE `".TABLE_USERS_STUDENTS."`  s SET s.`active`=(SELECT if(sum(b.`summa`) > 0, 1, 0) FROM `".TABLE_BALANCE."` b WHERE b.`student_id`=s.student_id);";
//      $res=mysql_query($sql);

//die("!!!");

  if ($_SESSION['admin_id']!="") { header("Location: ./add_student.php?mode=success_add"); } 
  else { header("Location: ./students.php"); } 
  
?>