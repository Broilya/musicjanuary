<?php
  define('ADMIN_ZONE', true);
  ini_set("memory_limit", "256M");

  include ("../phpexcel/PHPExcel.php");
/** PHPExcel_Writer_Excel2007 */
  include ("../phpexcel/PHPExcel/Writer/Excel5.php");

  include_once ('../init.php');
  define('TYPE_CASSA', 1);

  function getXLS($xls, $actsheet){
    include_once '../phpexcel/PHPExcel/IOFactory.php';

    $objPHPExcel = PHPExcel_IOFactory::load($xls);
//    $objPHPExcel->setReadDataOnly(false);

    $objPHPExcel->setActiveSheetIndex($actsheet);
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
 
  $file_xls = "../phpexcel/balances.xls";
  $xlsData = getXLS($file_xls,0); //извлеаем данные из XLS
//echo "\nxlsData=\n";
//var_dump($xlsData);


  $dates=$xlsData[2];
  $i=0;
  $class_id=$xlsData[0][0];
  $subj_id=$xlsData[0][1];
//$dates = array_diff($dates, array(''));
  $grades=array;
  foreach ($xlsData as $key=>$data) {
//    if ($key < 3) continue;

    $array=$data;
//echo "$i) $key:data=\n";
//var_dump($data);
    if ($key>3 && empty($data[0])) continue;

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

//    $grades[$i]=array();
    if ($key>3 ) {
      if (!empty($data[0])) {
//$val = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));

      $grades[$i]['student_id']=(int)$data[0];
      $grades[$i]['student_fio']=$data[1];
      $grades[$i]['student_date']=date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($data[3]));
      $grades[$i]['student_balance']=$data[4]*100;
      $grades[$i]['student_operator']=(int)$data[5];
      $grades[$i]['student_nomer']=$data[6];
    }

    $i++;
  }

  unset ($grades[0]);
  unset ($grades[1]);
  unset ($grades[2]);
//echo "\n1 ) grades=\n";
//var_dump($grades);
    
  foreach ($grades as $key=>$data) {
//      list ($dd, $mm, $yyyy ) = explode ('_', $data['student_date']);
//      $data['student_date'] = "$yyyy-$mm-$dd";
      $data['student_operator'] = ($data['student_operator']) ? $data['student_operator'] : TYPE_CASSA;

      $sql="SELECT `id`  FROM `".TABLE_BALANCE."` WHERE `date_add`='".$data['student_date']."' AND `student_id`='".$data['student_id']."' LIMIT 0,1;";
      $res=mysql_query($sql);

      $id = 0;
      if (mysql_num_rows($res)==1) 
      {
        $row = mysql_fetch_array($res);
        $id = $row['id'];
      }

      $data['student_kassa']=mysql_real_escape_string($data['student_kassa']);
      $data['student_nomer']=mysql_real_escape_string($data['student_nomer']);
      $data['student_summa']=mysql_real_escape_string($data['student_summa']);

      $sql="REPLACE INTO `".TABLE_BALANCE."`  (`id`, `student_id`, `date_add`, `summa`, `operator_id`, `nomer`, `date_edit`, `active`) VALUES".
           " ('".$id."', '".$data['student_id']."', '".$data['student_date']."', '".$data['student_balance']."', '".$data['student_operator']."', '".$data['student_nomer']."', NOW(), 1);";
      $res=mysql_query($sql);
//if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
//echo $sql."<br>\n";
  }

      $sql="UPDATE `".TABLE_USERS_STUDENTS."`  s SET s.`active`=(SELECT if(sum(b.`summa`) > 0, 1, 0) FROM `".TABLE_BALANCE."` b WHERE b.`student_id`=s.student_id);";
      $res=mysql_query($sql);

//die("!!!");

  if ($_SESSION['admin_id']!="") { header("Location: ./add_balance.php?mode=success_add"); } 
  else { header("Location: ./balances.php"); } 
  
?>