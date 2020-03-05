<?php
  define('TEACHER_ZONE', true);

ini_set("memory_limit", "256M");

include ("../phpexcel/PHPExcel.php");
/** PHPExcel_Writer_Excel2007 */
include ("../phpexcel/PHPExcel/Writer/Excel5.php");
include_once ('../init.php');


   $dir_xls  = "../phpexcel";
   
    if(false !== ($dh = @opendir("$dir_xls"))) {
      while($file = readdir($dh)) {
        if((strpos($file, '.xls') > 1) && (strpos($file, '_templ') < 2) && is_file($dir_xls.'/'.$file) && ($file[0] != ".")){
          @unlink ($dir_xls.'/'.$file);
        } 
      }
      closedir($dh);
   }


$dump=0;
if ($dump) {echo '<br><pre>$_request=|';print_r($_REQUEST);echo '</pre>|<br>';}

$class_id = (int)$_REQUEST['class_id'];
include_once ('../include/classes.php');
$class   = db_get_first_row("SELECT c.* FROM `".TABLE_CLASSES."` c JOIN `".TABLE_SCHOOL_YEARS."` sy ON (sy.school_year_id=c.school_year) WHERE class_id='".$class_id."';");

$shcool_name = "11111";
$i=1;

//Создание Excel документа-------------------------------------------------------------------------------------------


include_once '../phpexcel/PHPExcel/IOFactory.php';

$file_templ = "../phpexcel/balances_templ.xls";

	function trans($s, $utf=true) {
	        if (!empty($utf))
		        $s = iconv('utf-8', 'cp1251//IGNORE//TRANSLIT', $s);
		$trans=array( " "=>"_","\\"=>"","/"=>"",":"=>"",";"=>"",","=>".","*"=>"","?"=>"",""=>"N","{"=>"(","}"=>")","["=>"(","]"=>")","'"=>"","\""=>"","<"=>"",">"=>"","|"=>"",""=>"a",""=>"A",""=>"b",""=>"B",""=>"v",""=>"V",""=>"g",""=>"G",""=>"d",""=>"D",""=>"e",""=>"E",""=>"e",""=>"E",""=>"zh",""=>"ZH",""=>"z",""=>"Z",""=>"i",""=>"I",""=>"j",""=>"J",""=>"k",""=>"K",""=>"l",""=>"L",""=>"m",""=>"M",""=>"n",""=>"N",""=>"o",""=>"O",""=>"p",""=>"P",""=>"r",""=>"R",""=>"s",""=>"S",""=>"t",""=>"T",""=>"u",""=>"U",""=>"f",""=>"F",""=>"h",""=>"H",""=>"c",""=>"C",""=>"ch",""=>"CH",""=>"sh",""=>"SH",""=>"sh",""=>"SH",""=>"",""=>"",""=>"y",""=>"Y",""=>"",""=>"",""=>"e",""=>"E",""=>"u",""=>"U",""=>"ia",""=>"IA");
		$s=strtr($s,$trans);return $s;
	}


   $file_list  = "../phpexcel/balances_s". NUM_SCHOOL ."_".trans($class['class'].".xls");
if (LOCAL === true) {
   $file_list  = "../phpexcel/balances_s". NUM_SCHOOL ."_".$class_id."_empty.xls";
} else {
   $file_list  = "../phpexcel/balances_s". NUM_SCHOOL ."_".trans($class['class'].".xls");
   $file_list  = "../phpexcel/balances_s". NUM_SCHOOL ."_".iconv('utf-8', 'cp1251//IGNORE//TRANSLIT', $class['class'].".xls");
   $file_list  = "../phpexcel/balances_s". NUM_SCHOOL ."_".$class['class']."_empty.xls";
}


$objPHPExcel = PHPExcel_IOFactory::load($file_templ); 

$objPHPExcel->setActiveSheetIndex(0);
$aSheet = $objPHPExcel->getActiveSheet();

//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 0, 1, $_POST['class_id']  );
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 2, 2, NAME_SCHOOL." №".NUM_SCHOOL );
//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 2, 1,  "Ведомость успеваимости для {$names['class']}-{$names['letter']} класса" );


  $students_list = get_student_classes_list($class_id);

  $i=$i+2;
  $pos=0;
  foreach($students_list as $student) {
if ($dump) {echo '<br><pre>$student=|';print_r($student);echo '</pre>|<br>';}
//    $student['students_classid']
//    $student['active']
//    $student['student_id']
//    $student['student_name']

    $i++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 0, $i, $student['student_id'] );
    $pos++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 1, $i, $pos );

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 2, $i, $student['student_name'] );

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 3, $i, $class['class'] );
  }

/*

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 0, $i, iconv("cp1251", "utf-8", $student['student_id'] ));
    $pos++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 1, $i, iconv("cp1251", "utf-8", $pos ));

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 2, $i, iconv("cp1251", "utf-8", $student['student_name'] ));

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 3, $i, iconv("cp1251", "utf-8", $student['students_classid'] ));

//Стили границ таблицы
$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
		),
	),
);
$objPHPExcel->getActiveSheet()->getStyle("A4:AI{$i}")->applyFromArray($styleArray);

*/



//Отдача файла пользователю-------------------------------------------------------------------------------------------
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
$objWriter->setTempDir("/tmp/");
$objWriter->save( $file_list );
// redirect output to client browser
//header( "Content-Type: application/vnd.ms-excel" );
//header( "Content-Disposition: attachment;filename=1.xls");
//header( "Cache-Control: max-age=0" );
//$objWriter->save( "php://output" );
//echo "";
header("Location:".$file_list);
die();
?> 
