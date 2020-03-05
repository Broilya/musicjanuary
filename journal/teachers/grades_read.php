<?php
ini_set("memory_limit", "256M");

include ("../phpexcel/PHPExcel.php");
/** PHPExcel_Writer_Excel2007 */
include ("../phpexcel/PHPExcel/Writer/Excel5.php");

include_once ('../init.php');


function getXLS($xls, $actsheet){
	include_once '../phpexcel/PHPExcel/IOFactory.php';
 $objPHPExcel = PHPExcel_IOFactory::load($xls);
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
 
  $file_xls = "../phpexcel/grades.xls";
  $xlsData = getXLS('../phpexcel/grades.xls', 0); //извлеаем данные из XLS


  $dates=$xlsData[2];
  $i=0;
  $class_id=$xlsData[0][0];
  $subj_id=$xlsData[0][1];
  //$dates = array_diff($dates, array(''));
  foreach ($xlsData as $key=>$data) {
  	$array=$data;
  	$grades[$i]=$data;
  	
  
  	$grades[$i]['student_id']=$data[0];
  	$grades[$i]['student_fio']=$data[2];
  	$grades[$i]['grades']=array_combine($dates, $array);
  	$num=count($grades[$i])-3;
  	for ($y=0; $y<=$num; $y++) {
  		unset($grades[$i][$y]);
  	}
  	$i++;
  }
  unset ($grades[0]);
  unset ($grades[1]);
  unset ($grades[2]);
    

  
 $file_xls = "../phpexcel/grades.xls";
 $xlsData = getXLS($file_xls, 1); //извлеаем данные из XLS 
   unset ($xlsData[0]);
  unset ($xlsData[1]);
  		 			foreach ($xlsData as $key=>$less) 
		 			{
						if (count($less)==4) 
							{
								 array_unshift($xlsData[$key], "0"); 
							} 
  					
					if ( $less[0]=='' and $less[2]!="" ) 
  						{ 		
  							$sql="Select 1  FROM `".TABLE_LESSONS."` where lesson_date='{$less[2]}' and subject_id='{$subj_id}'";
  			
  			$res=mysql_query($sql);
			  			
			if (mysql_num_rows($res)==0) 
				{
							$less[1]=mysql_real_escape_string($less[1]);
							$less[2]=mysql_real_escape_string($less[2]);
							$less[3]=mysql_real_escape_string($less[3]);
							$less[4]=mysql_real_escape_string($less[4]);
  							$sql="insert INTO `".TABLE_LESSONS."`  (lesson_date, subject_id, topic, dz, lesson_order,	active) values ('$less[2]', '{$subj_id}',  '{$less[3]}','{$less[4]}','{$less[1]}',0)";
					  		
					  		$res=mysql_query($sql);
                                                        $xlsData[$key][0]=1;
  						}  
		 			}
		 				}

 foreach ($grades as $grade ) 
  {
  foreach ($grade['grades'] as $date=>$st_grade) 
   {
  	  if ($st_grade!="")
  	    {
			$sql="SELECT quarter_id FROM `".TABLE_SCHOOL_QUARTERS."` WHERE `started`<='{$date}' and `finished`>='{$date}'";
			$res=mysql_query($sql);
			$quarter_id=mysql_result($res,0,0);

  		

  			
  	        $sql="Select lesson_id  FROM `".TABLE_LESSONS."` where lesson_date='{$date}' and subject_id='{$subj_id}'";
  	        
  	        $res=mysql_query($sql);
  	        $id=mysql_result($res,0,0);
  	        $sql="Select 1 FROM `".TABLE_STUDENTS_ON_LESSON."` where student_id='{$grade['student_id']}' and lesson_id='{$id}' and subj_id='{$subj_id}' and quater='{$quarter_id}'";
  	        $res=mysql_query($sql);	
  		    if (mysql_num_rows($res)==0) 
  		    {
	  			$sql="Insert INTO `".TABLE_STUDENTS_ON_LESSON."` (student_id, lesson_id, grade,	quater,	subj_id) values ('{$grade['student_id']}', '{$id}', '{$st_grade}', '{$quarter_id}', '{$subj_id}')";
	  			$res=mysql_query($sql);
  		    }
  		    else 
  		    { 
  		    	$sql="UPDATE `".TABLE_STUDENTS_ON_LESSON."` set grade='{$st_grade}' where student_id='{$grade['student_id']}' and lesson_id='{$id}' and subj_id='{$subj_id}' and quater='{$quarter_id}'";
  		    	$res=mysql_query($sql);
  		    }
  		}
  	}
  	
  }
if ($_SESSION['teacher_id']!="") { 
header("Location: ../teachers/good_load.php"); }
if ($_SESSION['admin_id']!="") { header("Location: ../admin/good_load.php"); } 
  
?>			