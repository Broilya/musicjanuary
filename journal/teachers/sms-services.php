<?php

/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

define('TEACHER_ZONE', true);

 header("Content-type: plaintext; charset=utf-8");
  
 include_once ('../init.php');
 
 $pincod = intval($_GET['txt']);
 
 $pref = $_GET['pref'];
 
 $t_discipline = "";
 
 function get_sms_student_list($pincod = null)
{
  $sql = "SELECT last_name, first_name, middle_name FROM `".TABLE_USERS_STUDENTS."` WHERE pin_code='".$pincod."'";
  $res = db_query($sql);
  $sms_student_list= array();
  while($row = mysql_fetch_assoc($res)){
    $sms_student_list[] = $row;
  }
  return $sms_student_list;
}


 function get_sms_student_grade($pincod = null)
{
  $sql = "SELECT a.student_id, a.pin_code, b.grade, d.discipline, c.lesson_date"
        ." FROM `".TABLE_USERS_STUDENTS."` AS a"
        ." LEFT JOIN `".TABLE_STUDENTS_ON_LESSON."` AS b ON b.student_id=a.student_id"
        ." LEFT JOIN `".TABLE_LESSONS."` AS c ON c.lesson_id=b.lesson_id"
        ." LEFT JOIN `".TABLE_SUBJECTS."` AS s ON s.subject_id=c.subject_id"
        ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` AS d ON d.discipline_id=s.discipline_id"
        ." WHERE pin_code='".$pincod."' AND lesson_date >='".date('Y-m-d', mktime(0,0,0, date('m'), date('d')-7, date('Y')))."' AND lesson_date <='".date('Y-m-d')."'";
  $res = db_query($sql);
  $sms_student_grade= array();
  while($row = mysql_fetch_assoc($res)){
    $sms_student_grade[] = $row;
  }
  return $sms_student_grade;
}

 function get_sms_student_dz($pincod = null)
{
  $sql = "SELECT a.student_id, a.pin_code, c.dz, c.lesson_date, d.discipline, s.class_id"
        ." FROM `".TABLE_USERS_STUDENTS."` AS a"
        ." LEFT JOIN `".TABLE_STUDENTS_IN_CLASS."` AS b ON b.student_id=a.student_id"
        ." LEFT JOIN `".TABLE_SUBJECTS."` AS s ON s.class_id=b.class_id"
        ." LEFT JOIN `".TABLE_LESSONS."` AS c ON c.subject_id=s.subject_id"
        ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` AS d ON d.discipline_id=s.discipline_id"
        ." WHERE pin_code='".$pincod."' AND lesson_date ='".date('Y-m-d')."'";
  $res = db_query($sql);
  $sms_student_dz= array();
  while($row = mysql_fetch_assoc($res)){
    $sms_student_dz[] = $row;
  }
  return $sms_student_dz;
}


 $sms_student_list = get_sms_student_list($pincod);

 $sms_student_grade = get_sms_student_grade($pincod);

 $sms_student_dz = get_sms_student_dz ($pincod);

 if ($pref=='pinkod' && count($sms_student_list) > 0)
 {
      
	  foreach($sms_student_list as $student) {
      
	   $s_last_name = iconv("UTF-8", "WINDOWS-1251",$student['last_name']);
       $s_first_name = iconv("UTF-8", "WINDOWS-1251",$student['first_name']);
       $s_middle_name = iconv("UTF-8", "WINDOWS-1251",$student['middle_name']);
      
   	   $sms_text="sms=Ученик $s_last_name $s_first_name $s_middle_name c ".date('d.m.Y', mktime(0,0,0, date('m'), date('d')-7, date('Y')))." по ".date('d.m.Y')." получил оценки:";	
		      
      }  
 	  
    if ( count($sms_student_grade) > 0 ) {
     
       foreach($sms_student_grade as $sms) {
       	
       	$s_discipline = iconv("UTF-8", "WINDOWS-1251",$sms['discipline']);
        $s_grade = iconv("UTF-8", "WINDOWS-1251",$sms['grade']);
        
   	     if ($s_discipline !==$t_discipline)
   	     {
   	     	$sms_text.=" $s_discipline";
   	     }
	     $sms_text.=" $s_grade;";
	     
	     $t_discipline = $s_discipline;
       }  
    
        echo  $sms_text;
        
    } 
	else 
	{
	    echo "sms=За ".date('d.m.Y')." ученик $s_last_name $s_first_name] $s_middle_name оценок не получал.";
	}	
  } 
  elseif ($pref=='domzad' && count($sms_student_list) > 0)
  {
    if ( count($sms_student_dz) > 0 ) {
     
     $sms_text="sms=Д.з. за ".date('d.m.Y').",";	
     
     
       foreach($sms_student_dz as $sms) {
       	
       	$s_discipline = iconv("UTF-8", "WINDOWS-1251",$sms['discipline']);
        $s_dz = iconv("UTF-8", "WINDOWS-1251",$sms['dz']);
        
   	     if ($s_discipline !==$t_discipline)
   	     {
   	     	$sms_text.=" $s_discipline:";
   	     }
	     $sms_text.=" $s_dz;";
	     
	     $t_discipline = $s_discipline;
       }  
    
        echo  $sms_text;
        
    } 
	else 
	{
	    echo "sms=Д.з. на ".date('d.m.Y')." не задано.";
	}	
  }
  else
 {
	 echo "sms=Ошибка: проверьте ключевое слово или пинкод!";
 }

?>