<?php

  define('ADMIN_ZONE', true);
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

$file_templ = "../phpexcel/schedule_templ.xls";

	function trans($s, $utf=true) {
	        if (!empty($utf))
		        $s = iconv('utf-8', 'cp1251//IGNORE//TRANSLIT', $s);
		$trans=array( " "=>"_","\\"=>"","/"=>"",":"=>"",";"=>"",","=>".","*"=>"","?"=>"",""=>"N","{"=>"(","}"=>")","["=>"(","]"=>")","'"=>"","\""=>"","<"=>"",">"=>"","|"=>"",""=>"a",""=>"A",""=>"b",""=>"B",""=>"v",""=>"V",""=>"g",""=>"G",""=>"d",""=>"D",""=>"e",""=>"E",""=>"e",""=>"E",""=>"zh",""=>"ZH",""=>"z",""=>"Z",""=>"i",""=>"I",""=>"j",""=>"J",""=>"k",""=>"K",""=>"l",""=>"L",""=>"m",""=>"M",""=>"n",""=>"N",""=>"o",""=>"O",""=>"p",""=>"P",""=>"r",""=>"R",""=>"s",""=>"S",""=>"t",""=>"T",""=>"u",""=>"U",""=>"f",""=>"F",""=>"h",""=>"H",""=>"c",""=>"C",""=>"ch",""=>"CH",""=>"sh",""=>"SH",""=>"sh",""=>"SH",""=>"",""=>"",""=>"y",""=>"Y",""=>"",""=>"",""=>"e",""=>"E",""=>"u",""=>"U",""=>"ia",""=>"IA");
		$s=strtr($s,$trans);return $s;
	}

   $num_school = str_replace("'", '', str_replace('"', '', NUM_SCHOOL));

   $file_list  = "../phpexcel/schedule_s". $num_school .".xls";
if (LOCAL === true) {
   $file_list  = "../phpexcel/schedule_s". $num_school .".xls";
   $file_list  = "../phpexcel/schedule_s". iconv('utf-8', 'cp1251//IGNORE//TRANSLIT', $num_school.".xls");
   $file_list  = "../phpexcel/schedule_s". trans($num_school.".xls");
} else {
   $file_list  = "../phpexcel/schedule_s". iconv('utf-8', 'cp1251//IGNORE//TRANSLIT', $num_school.".xls");
   $file_list  = "../phpexcel/schedule_s". $num_school .".xls";
   $file_list  = "../phpexcel/schedule_s". trans($num_school.".xls");
}


$objPHPExcel = PHPExcel_IOFactory::load($file_templ); 

$objPHPExcel->setActiveSheetIndex(0);
$aSheet = $objPHPExcel->getActiveSheet();

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 2, 1, NUM_SCHOOL );
//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 2, 2, NAME_SCHOOL." №".NUM_SCHOOL );
//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 2, 1,  "Ведомость успеваимости для {$names['class']}-{$names['letter']} класса" );



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
