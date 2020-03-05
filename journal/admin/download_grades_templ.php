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




$sql="SELECT sol.student_id, s.last_name, s.first_name, s.middle_name, l.lesson_date, sol.grade"
    ." FROM `".TABLE_STUDENTS_ON_LESSON."` AS sol"
    ." JOIN `".TABLE_STUDENTS_IN_CLASS."` AS sic ON sic.student_id = sol.student_id"
    ." JOIN `".TABLE_CLASSES."` AS c ON c.class_id = sic.class_id"
    ." JOIN `".TABLE_LESSONS."` AS l ON l.lesson_id = sol.lesson_id"
    ." JOIN `".TABLE_USERS_STUDENTS."` AS s ON s.student_id = sol.student_id"
    ." WHERE c.class_id='".$_POST['class_id']."'";



$sql="Select * FROM `".TABLE_CLASSES."` where class_id='".$_POST['class_id']."'";

$res=mysql_query($sql);
$names=mysql_fetch_array($res);



$sql="SELECT s.student_id, s.last_name, s.first_name, s.middle_name FROM `".TABLE_CLASSES."` as c"
    ." JOIN `".TABLE_STUDENTS_IN_CLASS."` as sic on sic.class_id=c.class_id"
    ." JOIN `".TABLE_USERS_STUDENTS."` as s on s.student_id=sic.student_id"
    ." WHERE c.class_id='".$_POST['class_id']."'"
    ." order by s.last_name";

$query_dates="SELECT * FROM `".TABLE_LESSONS."` WHERE subject_id='".$_POST['subject_id']."' order by lesson_date";
$result_dates=mysql_query($query_dates);
while ($dates=mysql_fetch_array($result_dates)) {
	$lessons_date[$dates['lesson_date']]=0;
}


$i=1;
$query=$sql;
$res=mysql_query($query);


//Создание Excel документа-------------------------------------------------------------------------------------------


include_once '../phpexcel/PHPExcel/IOFactory.php';


$file_templ = "../phpexcel/grades_templ.xls";

	function trans($s, $utf=true) {
	        if (!empty($utf))
		        $s = iconv('utf-8', 'cp1251//IGNORE//TRANSLIT', $s);
		$trans=array( " "=>"_","\\"=>"","/"=>"",":"=>"",";"=>"",","=>".","*"=>"","?"=>"",""=>"N","{"=>"(","}"=>")","["=>"(","]"=>")","'"=>"","\""=>"","<"=>"",">"=>"","|"=>"",""=>"a",""=>"A",""=>"b",""=>"B",""=>"v",""=>"V",""=>"g",""=>"G",""=>"d",""=>"D",""=>"e",""=>"E",""=>"e",""=>"E",""=>"zh",""=>"ZH",""=>"z",""=>"Z",""=>"i",""=>"I",""=>"j",""=>"J",""=>"k",""=>"K",""=>"l",""=>"L",""=>"m",""=>"M",""=>"n",""=>"N",""=>"o",""=>"O",""=>"p",""=>"P",""=>"r",""=>"R",""=>"s",""=>"S",""=>"t",""=>"T",""=>"u",""=>"U",""=>"f",""=>"F",""=>"h",""=>"H",""=>"c",""=>"C",""=>"ch",""=>"CH",""=>"sh",""=>"SH",""=>"sh",""=>"SH",""=>"",""=>"",""=>"y",""=>"Y",""=>"",""=>"",""=>"e",""=>"E",""=>"u",""=>"U",""=>"ia",""=>"IA");
//		$trans=array( " "=>"_","\\"=>"","/"=>"",":"=>"",";"=>"",","=>".","*"=>"","?"=>"",""=>"N","{"=>"(","}"=>")","["=>"(","]"=>")","'"=>"","\""=>"","<"=>"",">"=>"","|"=>"",""=>"a",""=>"A",""=>"b",""=>"B",""=>"v",""=>"V",""=>"g",""=>"G",""=>"d",""=>"D",""=>"e",""=>"E",""=>"e",""=>"E",""=>"zh",""=>"ZH",""=>"z",""=>"Z",""=>"i",""=>"I",""=>"j",""=>"J",""=>"k",""=>"K",""=>"l",""=>"L",""=>"m",""=>"M",""=>"n",""=>"N",""=>"o",""=>"O",""=>"p",""=>"P",""=>"r",""=>"R",""=>"s",""=>"S",""=>"t",""=>"T",""=>"u",""=>"U",""=>"f",""=>"F",""=>"h",""=>"H",""=>"c",""=>"C",""=>"ch",""=>"CH",""=>"sh",""=>"SH",""=>"sh",""=>"SH",""=>"",""=>"",""=>"y",""=>"Y",""=>"",""=>"",""=>"e",""=>"E",""=>"u",""=>"U",""=>"ia",""=>"IA");
		$s=strtr($s,$trans);
		return $s;
	}


$objPHPExcel = PHPExcel_IOFactory::load("$file_templ"); 

$objPHPExcel->setActiveSheetIndex(0);
$aSheet = $objPHPExcel->getActiveSheet();

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 0, 1, $_POST['class_id']  );
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 1, 1, $_POST['subject_id'] );
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 2, 1,  "Ведомость успеваимости для {$names['class']}-{$names['letter']} класса" );


$i=$i+2;
$pos=0;

while ($row=mysql_fetch_array($res)) {
$i++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 0, $i, iconv("cp1251", "utf-8", $row['student_id'] ));
$pos++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 1, $i, iconv("cp1251", "utf-8", $pos ));
$fio=$row['last_name']." ".$row['first_name']." ".$row['middle_name'];

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 2, $i,  $fio );

$students[]=$row['student_id'];

$sql2="SELECT  s.student_id, l.lesson_date, sol.grade FROM `".TABLE_CLASSES."` as c"
    ." left JOIN `".TABLE_STUDENTS_IN_CLASS."` as sic on sic.class_id=c.class_id"
    ." left JOIN `".TABLE_USERS_STUDENTS."` as s on s.student_id=sic.student_id"
    ." left JOIN `".TABLE_STUDENTS_ON_LESSON."` as sol on sol.student_id=sic.student_id"
    ." left JOIN `".TABLE_LESSONS."` as l on l.lesson_id=sol.lesson_id"
    ." WHERE c.class_id='".$_POST['class_id']."' and s.student_id='".$row['student_id']."'"
    ." order by s.last_name, l.lesson_date";

$array[$row['student_id']]=$lessons_date;
$res2=mysql_query($sql2);
while($row2=mysql_fetch_array($res2)) {
	
	$array[$row2['student_id']][$row2['lesson_date']]=$row2['grade'];
	
}

}

$i=2;
$y=3;
if (!empty($lessons_date))
  foreach($lessons_date as $key=>$lesson)
  {
    $i++;
    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $i, 3, iconv("cp1251", "utf-8", $key ));
  }

$i=4;
$y=3;

if (!empty($students))
foreach($students as $key=>$student_id) {
	
	foreach($lessons_date as $key2=>$lesson) 
	{ 
		if ($array[$student_id][$key2]!="0") {
			$st_grade=$array[$student_id][$key2];
		}
		else 
		{
			$st_grade='';
		}
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( $y, $i,  $st_grade );
		$y++;
	}
	
$y=3;	
$i++;	
}




//Стили границ таблицы
$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
		),
	),
);
$objPHPExcel->getActiveSheet()->getStyle("A4:AI{$i}")->applyFromArray($styleArray);




$objPHPExcel->setActiveSheetIndex(1);
$aSheet = $objPHPExcel->getActiveSheet();

$sql="SELECT * FROM `".TABLE_LESSONS."` WHERE subject_id='".$_POST['subject_id']."' ORDER BY lesson_date";
$res=mysql_query($sql);
$i=2;
while ($row=mysql_fetch_array($res)) {
  $i++;
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 0, $i, $row['lesson_id']);
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 1, $i, $row['lesson_order']);
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 2, $i, $row['lesson_date']);
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 3, $i, $row['topic'] );
  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow( 4, $i, $row['dz']);
}

//Стили границ таблицы
$styleArray = array(
	'borders' => array(
		'allborders' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
		),
	),
);
$objPHPExcel->getActiveSheet()->getStyle("A4:E{$i}")->applyFromArray($styleArray);
$objPHPExcel->setActiveSheetIndex(0);

//echo "|".trans($num_school."_empty.xls")."|".$num_school."_empty.xls"."<br>\n";
if (LOCAL === true) {
   $file_list  = "../phpexcel/grades_s.xls";
} else {
   $file_list  = "../phpexcel/grades_s.xls";
}

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

?>

 
 