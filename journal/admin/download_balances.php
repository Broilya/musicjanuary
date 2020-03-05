<?php

ini_set("memory_limit", "256M");
  define('ADMIN_ZONE', true);

include ("../phpexcel/PHPExcel.php");
/** PHPExcel_Writer_Excel2007 */
include ("../phpexcel/PHPExcel/Writer/Excel5.php");
include_once ('../init.php');



$dump=0;
if ($dump) {echo '<br><pre>$_request=|';print_r($_REQUEST);echo '</pre>|<br>';}

$class_id = (int)$_REQUEST['class_id'];
include_once ('../include/classes.php');
$class   = db_get_first_row("SELECT c.* FROM `".TABLE_CLASSES."` c JOIN `".TABLE_SCHOOL_YEARS."` sy ON (sy.school_year_id=c.school_year) WHERE class_id='".$class_id."';");

$shcool_name = "11111";
$i=1;

//–°–æ–∑–¥–∞–Ω–∏–µ Excel –¥–æ–∫—É–º–µ–Ω—Ç–∞-------------------------------------------------------------------------------------------


include_once '../phpexcel/PHPExcel/IOFactory.php';

$file_templ = "../phpexcel/balances_templ.xls";

	function trans($s, $utf=true) {
	        if (!empty($utf))
		        $s = iconv('utf-8', 'cp1251//IGNORE//TRANSLIT', $s);
		$trans=array( " "=>"_","\\"=>"","/"=>"",":"=>"",";"=>"",","=>".","*"=>"","?"=>"","π"=>"N","{"=>"(","}"=>")","["=>"(","]"=>")","'"=>"","\""=>"","<"=>"",">"=>"","|"=>"","‡"=>"a","¿"=>"A","·"=>"b","¡"=>"B","‚"=>"v","¬"=>"V","„"=>"g","√"=>"G","‰"=>"d","ƒ"=>"D","Â"=>"e","≈"=>"E","∏"=>"e","®"=>"E","Ê"=>"zh","∆"=>"ZH","Á"=>"z","«"=>"Z","Ë"=>"i","»"=>"I","È"=>"j","…"=>"J","Í"=>"k"," "=>"K","Î"=>"l","À"=>"L","Ï"=>"m","Ã"=>"M","Ì"=>"n","Õ"=>"N","Ó"=>"o","Œ"=>"O","Ô"=>"p","œ"=>"P",""=>"r","–"=>"R","Ò"=>"s","—"=>"S","Ú"=>"t","“"=>"T","Û"=>"u","”"=>"U","Ù"=>"f","‘"=>"F","ı"=>"h","’"=>"H","ˆ"=>"c","÷"=>"C","˜"=>"ch","◊"=>"CH","¯"=>"sh","ÿ"=>"SH","˘"=>"sh","Ÿ"=>"SH","˙"=>"","⁄"=>"","˚"=>"y","€"=>"Y","¸"=>"","‹"=>"","˝"=>"e","›"=>"E","˛"=>"u","ﬁ"=>"U","ˇ"=>"ia","ﬂ"=>"IA");
		$s=strtr($s,$trans);return $s;
	}


   $file_list  = "../phpexcel/balances_s". NUM_SCHOOL ."_".date("Y-m-d")."_c".trans($class['class'].".xls");
if (LOCAL === true) {                                                      
   $file_list  = "../phpexcel/balances_s". NUM_SCHOOL ."_".date("Y-m-d")."_c".$class_id.".xls";
} else {                                                                   
   $file_list  = "../phpexcel/balances_s". NUM_SCHOOL ."_".date("Y-m-d")."_c".trans($class['class'].".xls");
   $file_list  = "../phpexcel/balances_s". NUM_SCHOOL ."_".date("Y-m-d")."_c".iconv('utf-8', 'cp1251//IGNORE//TRANSLIT', $class['class'].".xls");
   $file_list  = "../phpexcel/balances_s". NUM_SCHOOL ."_".date("Y-m-d")."_c".$class['class'].".xls";
}

$objPHPExcel = PHPExcel_IOFactory::load($file_templ); 

$objPHPExcel->setActiveSheetIndex(0);
$aSheet = $objPHPExcel->getActiveSheet();

//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 0, 1, $_POST['class_id']  );
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 2, 2, NAME_SCHOOL." ‚Ññ".NUM_SCHOOL );
//$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 2, 1,  "–í–µ–¥–æ–º–æ—Å—Ç—å —É—Å–ø–µ–≤–∞–∏–º–æ—Å—Ç–∏ –¥–ª—è {$names['class']}-{$names['letter']} –∫–ª–∞—Å—Å–∞" );


  $students_list = get_student_classes_list($class_id);

  $balances =0;
  $i=$i+2;
  $pos=0;
  foreach($students_list as $student) {
    $balance = db_get_cell("SELECT sum(b.summa)/100 FROM `".TABLE_BALANCE."` b WHERE student_id='".$student['student_id']."';");
    $balances +=$balance;
//    $balance = (empty($balance)) ? '0,00': round($balance,2);

if ($dump) {echo '<br><pre>$student=|';print_r($student);echo '</pre>|<br>';}

    $i++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 0, $i, $student['student_id'] );
    $pos++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 1, $i, $pos );

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 2, $i, $student['student_name'] );

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 3, $i, $class['class'] );
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 4, $i, " ".date("d.m.Y") );
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 5, $i, round($balance*1.00, 2) );
  }

    $i++;
    $i++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 4, $i, "–ò—Ç–æ–≥–æ:" );
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 5, $i, $balances );
/*

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 0, $i, iconv("cp1251", "utf-8", $student['student_id'] ));
    $pos++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 1, $i, iconv("cp1251", "utf-8", $pos ));

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 2, $i, iconv("cp1251", "utf-8", $student['student_name'] ));

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 3, $i, iconv("cp1251", "utf-8", $student['students_classid'] ));

//–°—Ç–∏–ª–∏ –≥—Ä–∞–Ω–∏—Ü —Ç–∞–±–ª–∏—Ü—ã
$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
		),
	),
);
$objPHPExcel->getActiveSheet()->getStyle("A4:AI{$i}")->applyFromArray($styleArray);

*/



//–û—Ç–¥–∞—á–∞ —Ñ–∞–π–ª–∞ –ø–æ–ª—å–∑–æ–≤–∞—Ç–µ–ª—é-------------------------------------------------------------------------------------------
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
