<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                     |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('ADMIN_ZONE', true);

include_once ('../init.php');
include_once ('../include/classes.php');
include_once ('../include/curriculums.php');
include_once ('../include/tocode.php');

$dump=0;

if ($dump) {echo '<br><pre>$_request=|';print_r($_REQUEST);echo '</pre>|<br>';}

function UploadedCSVFile ($path) {
  if (isset($_FILES["uploadfile"])){
    if (is_uploaded_file($_FILES['uploadfile']['tmp_name'])) {
      $filename = $_FILES['uploadfile']['tmp_name'];
      $_ext = explode ('.', $_FILES['uploadfile']['name']);
      $ext  = $_ext[count($_ext)-1];
      $uploadfilename = md5(rand());
      if (strpos($ext, 'htm') === 0) 
        $ext = 'htm';
      else 
        $ext = 'csv';

      $uploadfile = $path.$uploadfilename.'.'.$ext;
      if (move_uploaded_file($filename, $uploadfile)){
        return $uploadfile;
      }
    }
  }

  return false;
} //  function *



$teacher_id    = @intval($_REQUEST['teacher_id']);
$mode        = @$_REQUEST['mode'];

if ($teacher_id == 0 && $mode == '') {
	$mode = 'add';
} elseif ($teacher_id != 0 && $mode == '') {
	$mode = 'update';
}



    $tblname = $_REQUEST['typecsv'];

    switch ($tblname) {


  /** *********************************************************************************************** */

      case 'teacher_list':
        $C_teacher_list = 'selected="selected"';
        $row0[] = "id";
        $row0[] = "fio";
        $row0[] = "login";
        $row0[] = "passwd";

        $row01[] = "Код";
        $row01[] = "Фамилия";
        $row01[] = "Логин";
        $row01[] = "Пароль";
        $delimiter = " ";
        break;

      case 'teacher_pass':
        $C_teacher_pass = 'selected="selected"';
        $row0[] = "id";
        $row0[] = "fio";
        $row0[] = "login";
        $row0[] = "passwd";

        $row01[] = "Код";
        $row01[] = "Фамилия";
        $row01[] = "Логин";
        $row01[] = "Пароль";
        $delimiter = ";";
        break;

      case 'teacher_sched':
        $C_teacher_sched = 'selected="selected"';
        $row0[] = "id";
        $row0[] = "fio";
        $row0[] = "login";
        $row0[] = "passwd";

        $row01[] = "Код";
        $row01[] = "Фамилия";
        $row01[] = "Логин";
        $row01[] = "Пароль";
        $delimiter = ";";
        break;

      case 'parents_phone':
        $C_parents_phone = 'selected="selected"';
        $row0[] = "id";
        $row0[] = "fio";
        $row0[] = "login";
        $row0[] = "passwd";

        $row01[] = "Код";
        $row01[] = "Фамилия";
        $row01[] = "Логин";
        $row01[] = "Пароль";
        $delimiter = ";";
        break;

      case 'student_pass':
        $C_student_pass = 'selected="selected"';
        $row0[] = "id";
        $row0[] = "fio";
        $row0[] = "login";
        $row0[] = "passwd";

        $row01[] = "Код";
        $row01[] = "Фамилия";
        $row01[] = "Логин";
        $row01[] = "Пароль";

        $delimiter = " ";
        break;

    }


if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];

  if ($action == 'add') {
   
    include_once ('../include/csv.class.php');

//    $query_id = $dbs->query("SHOW fields FROM ".$tblname);
    $row0 = array();
    $row01 = array();

    $csv_name = UploadedCSVFile("../tmp/");

    $_ext = explode ('.', $csv_name);
    $ext  = $_ext[count($_ext)-1];

    switch ($tblname) {


  /** *********************************************************************************************** */

      case 'teacher_list':

        if ($ext == 'htm') {
          $res = file($csv_name);

          $res = join('', $res);
          $r = preg_match_all("/\<tr id=.+?\>.+?\<td\>\<span.*?\>(.*?)\<\/span\>/is", $res,$page);
          unset($page[0]);

          unlink($csv_name);

          $csv_name = $csv_name.'.cvs';
if ($dump) {echo $csv_name.'<br><pre>$page[0]=|';print_r($page);echo '</pre>|<br>'.count($page[1]);}

          $f = @fopen($csv_name, 'w');

          for ($i = 0, $counti = count($page[1]); $i < $counti; $i++) {
            $fio_teacher  = explode (' ', str_replace('&nbsp;', '', str_replace('  ', ' ', trim($page[1][$i]))));
            $f_i_o_teacher = join(' ', $fio_teacher);
            fwrite($f, iconv('UTF-8//IGNORE//TRANSLIT', 'WINDOWS-1251', $f_i_o_teacher."\n"));
          }  //  for ($i = 0

          fclose($f);
    //      $win = false;
        } else
          $win = true;

        break;


  /** *********************************************************************************************** */

      case 'parents_phone':

        if ($ext == 'htm') {
          $res = file($csv_name);

          $res = join('', $res);
          $r = preg_match_all("/\<tr id=.+?\>.+?\<td\>(.*?)\<\/td\>.+?\<td\>(.*?)\<\/td\>.+?\<td\>(.*?)\<\/td\>/is", $res,$page);
          unset($page[0]);

          unlink($csv_name);

          $csv_name = $csv_name.'.cvs';
if ($dump) {echo $csv_name.'<br><pre>$page[0]=|';print_r($page);echo '</pre>|<br>'.count($page[1]);}

          $f = @fopen($csv_name, 'w');

          for ($i = 0, $counti = count($page[1]); $i < $counti; $i++) {
            $fio_parent  = explode (' ', str_replace('&nbsp;', '', str_replace('  ', ' ', trim($page[1][$i]))));
            $fio_parent  = join (' ', $fio_parent);
            $phone       = trim(str_replace('&nbsp;', '', $page[3][$i]));
            $fio_students = explode ('<br>', str_replace('&nbsp;', '', str_replace('  ', ' ', trim($page[2][$i]))));

if ($dump) {echo '<br><pre>$fio_students=|';print_r($fio_students);echo '</pre>|<br>';}

            for ($j = 0, $countj = count($fio_students); $j < $countj; $j++) {
              $fio_student = explode (' ', $fio_students[$j]);
              $class       = $fio_student[count($fio_student)-1];
              unset($fio_student[count($fio_student)-1]);
              $fio_student = trim(join (' ', $fio_student));

              $class       = str_replace('(', '', $class);
              $class       = str_replace(')', '', $class);
              $class = an_to_ru($class);
              $class = str_to_upper($class);

              if (empty($class) || empty($fio_student)) 
                $error[] = '<b>Не задан '.((empty($fio_student)) ? ' ученик':'').((empty($class)) ? ' класс':'').'.</b> Родитель '.$fio_parent.'; '.((empty($fio_student)) ? '':' ученик '.$fio_student.';').((empty($class)) ? '':' класс '.$class.';').((empty($phone)) ? ' Телефон: '.$phone.".":'');
//              else
              fwrite($f, iconv('UTF-8//IGNORE//TRANSLIT', 'WINDOWS-1251', $fio_parent.';'.$fio_student.';'.$class.';'.$phone.";\n"));
            }
          }  //  for ($i = 0

          fclose($f);
    //      $win = false;
        } else
          $win = true;

        break;

    }  //  switch ($tblname)

    $win = false;

    $csv = new phpCSV();

    $csv->setAttribute('file', $csv_name);
    $csv->setAttribute('mode', 'r');
    $csv->setAttribute('delimiter', $delimiter);
    $csv->setAttribute('length', '1024');
    $csv->setAttribute('null', true);
    $csv->openFile();
    $csv->readCSV($win);
    unlink($csv_name);

    $relatives = array();

    while ($row = $csv->fetch_array()) {
      $row[0] = trim($row[0]);

      $row1 = array();  //  client/ other
      $fields = array();

if($dump) print_r($row);
      switch ($tblname) {


    /** *********************************************************************************************** */

        case 'teacher_list':

//          $row[0]=mysql_escape_string($row[0]);
//          $row[1]=iconv("Windows-1251","UTF-8", $row[1]);
//          list ($last_name, $first_name, $middle_name) = explode (' ', $row[0]);
          $last_name   = $row[0];
          $first_name  = $row[1];
          $middle_name = $row[2];
          

          $fields['last_name']   = trim(substr($last_name, 0, 50));
          $fields['first_name']  = trim(substr($first_name, 0, 50));
          $fields['middle_name'] = trim(substr($middle_name, 0, 50));

if($dump) print_r($fields);
          $sql = "SELECT teacher_id FROM `".TABLE_USERS_TEACHERS."` WHERE"
                ."     (last_name  ='".$fields['last_name']  ."')"
                ." AND (first_name ='".$fields['first_name'] ."')"
                ." AND (middle_name='".$fields['middle_name']."') LIMIT 0,1";
          $teacher_id = db_get_cell($sql);
          if (empty($teacher_id)){
              $fields['login'] = md5(rand());

              $teacher_id = db_array2insert(TABLE_USERS_TEACHERS, $fields);

              $fields = array();
              $fields['login']    = $teacher_id.$login;
              $fields['passwd'] = md5('1');
              db_array2update(TABLE_USERS_TEACHERS, $fields, "teacher_id ='".$teacher_id."'");
          }else
            db_array2update(TABLE_USERS_TEACHERS, $fields, "teacher_id ='".$teacher_id."'");

          $lang_new_added = $lang['new_teacher_pass_added'];

          break;


    /** *********************************************************************************************** */


        case 'teacher_pass':


          if ($row[2] =='логин') break;

          if (is_numeric($row[0])) {
            $row[1]=mysql_escape_string($row[1]);
  //          $row[1]=iconv("Windows-1251","UTF-8", $row[1]);
            
            list ($last_name, $first_name, $middle_name) = explode (' ', $row[1]);
            $login = $row[2];
            $passw = $row[3];
          } else{
            for ($i = count($row)-1; $i > -1; $i--) {
              $row[$i] = trim(substr($row[$i], 0, 64));
              if (!empty($row[$i])) {
                $password = md5($row[$i]);
                $login    = $row[$i-1];
                unset($row[$i]);
                unset($row[$i-1]);
                break;
              }
            }  //  for ($i = 0
            $last_name   = $row[0];
            $first_name  = $row[1];
            $middle_name = $row[2];
          }

          $fields['last_name']   = trim(substr($last_name, 0, 50));
          $fields['first_name']  = trim(substr($first_name, 0, 50));
          $fields['middle_name'] = trim(substr($middle_name, 0, 50));

          $fields['login']  = trim(substr($login, 0, 64));
          $fields['passwd'] = md5(trim(substr($passw, 0, 64)));

if($dump) print_r($fields);
          $sql = "SELECT teacher_id FROM `".TABLE_USERS_TEACHERS."` WHERE"
                ."     (last_name  ='".$fields['last_name']  ."')"
                ." AND (first_name ='".$fields['first_name'] ."')"
                ." AND (middle_name='".$fields['middle_name']."') LIMIT 0,1";
          $teacher_id = db_get_cell($sql);
          if (empty($teacher_id))
            $teacher_id = db_array2insert(TABLE_USERS_TEACHERS, $fields);
          else
            db_array2update(TABLE_USERS_TEACHERS, $fields, "teacher_id ='".$teacher_id."'");

          $lang_new_added = $lang['new_teacher_pass_added'];

          break;


  /** *********************************************************************************************** */

        
        case 'parents_phone':



          if (!empty($row[2])) {
            $class = $row[2];
            $class = an_to_ru($class);
            $class = str_to_upper($class);
            $sql = "SELECT class_id FROM `".TABLE_CLASSES."` WHERE"
                  ." (`class` ='".$class."') LIMIT 0,1";
            $class_id = db_get_cell($sql);
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
            if (empty($class_id)) {
              $fields['class'] = trim($class);
              $fields['school_year'] = $_SESSION['schoolyear'];
if($dump) print_r($fields);

              $class_id = db_array2insert(TABLE_CLASSES, $fields);
if($dump) echo "|$class_id|$sql|\n";
if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; }
            }
          } else 
            $class_id = 0;

          $row[1]=trim($row[1]);
//if($dump) print_r($row);
//          $row[1]=iconv("Windows-1251","UTF-8", $row[1]);
          $fields  = array();
          $row[1]  = (empty($row[1])) ? 'Ученика нет' : $row[1];
          $student = explode (' ', $row[1],3);
          $login   = $fields['last_name']   = trim(substr($student[0], 0, 50));
          $fields['first_name']  = trim(substr($student[1], 0, 50));
          $fields['middle_name'] = trim(substr($student[2], 0, 50));

$dump=0;if($dump) print_r($fields);

          $sql = "SELECT s.* FROM `".TABLE_USERS_STUDENTS."` s"
                ." LEFT JOIN `".TABLE_STUDENTS_IN_CLASS."` sc ON (sc.student_id=s.student_id)"
                ." WHERE (sc.class_id='".$class_id."')"
                ." AND (s.last_name  ='".$fields['last_name']  ."')"
                ." AND (s.first_name ='".$fields['first_name'] ."')"
                .((empty($fields['middle_name'])) ? "" : " AND ((s.middle_name='') OR (s.middle_name='".$fields['middle_name']."'))")
                ." LIMIT 0,1";

          $student = db_get_first_row($sql);
          $student_id = $student['student_id'];

if($dump) {echo "|$student_id|$sql|\n";}
          if (empty($student_id)) {
            while(1) {
              $pin_code = rand(100000,999999);
              $sql="SELECT s.`pin_code`  FROM `".TABLE_USERS_STUDENTS."` s"
                  ." WHERE s.`pin_code`='".$pin_code."';";
              $pincode=db_get_cell($sql);
              if (empty($pincode)) 
                break;
            }

            $fields['pin_code'] = $pin_code;

            $fields['login'] = md5(rand());
            $student_id = db_array2insert(TABLE_USERS_STUDENTS, $fields);

            $sql = "SELECT s.* FROM `".TABLE_USERS_STUDENTS."` s"
                  ." WHERE (s.student_id='".$student_id."')"
                  ." LIMIT 0,1";

            $student = db_get_first_row($sql);

            $fields = array();
            $fields['class_id']   = $class_id;
            $fields['student_id'] = $student_id;

            db_array2insert(TABLE_STUDENTS_IN_CLASS, $fields);
          }else
            db_array2update(TABLE_USERS_STUDENTS, $fields, "student_id ='".$student_id."'");
/*
          $fields = array();
          
          if (empty($student['password'])) {
            $fields['login']    = $student_id.$login;
            $fields['password'] = substr(md5(rand(100000,999999)), 0, 8);
            db_array2update(TABLE_USERS_STUDENTS, $fields, "student_id ='".$student_id."'");
          }
*/
if($dump) {echo "|$student_id|student=\n";var_dump($student);}

          $fields = array();
          $parent = explode (' ', $row[0],3);
          $plogin = $fields['last_name']   = trim(substr($parent[0], 0, 50));
          $fields['first_name']  = trim(substr($parent[1], 0, 50));
          $fields['middle_name'] = trim(substr($parent[2], 0, 50));
          $fields['cell_phone']  = trim(substr($row[3], 0, 25));
          $relative_id = $fields['relative_id'] = 
                         (substr($fields['last_name'], -2, 2) == 'а') ? 1 : 2;

          $fio   = trim($fields['last_name']." ".$fields['first_name'] ." ".$fields['middle_name']);
          $phone = trim(substr($row[3], 0, 25));

if($dump) print_r($fields);

          $sql = "SELECT p.parent_id FROM `".TABLE_USERS_PARENTS."` p"
//                ." LEFT JOIN `".TABLE_STUDENTS_IN_PARENT."` sp ON (sp.parent_id=p.parent_id)"
                ." WHERE "
//                ."  (sp.student_id ='".$student_id."')"
                ." (p.last_name  ='".$fields['last_name']  ."')"
                ." AND (p.first_name ='".$fields['first_name'] ."')"
                .((empty($fields['middle_name'])) ? "" : " AND ((p.middle_name='') OR (p.middle_name='".$fields['middle_name']."'))")
                ." LIMIT 0,1";
          $parent = db_get_first_row($sql);
          $parent_id = $parent['parent_id'];
if($dump) {echo "|$parent_id|$sql|\n";print_r($parent);}

          if (empty($parent_id)){
            $fields['login'] = md5(rand());
            $parent_id = db_array2insert(TABLE_USERS_PARENTS, $fields);
          } else
            db_array2update(TABLE_USERS_PARENTS, $fields, "parent_id ='".$parent_id."'");

          if (empty($parent['password'])) {
            $fields = array();
            $fields['login'] = $parent_id.$plogin;
            $fields['password'] = substr(md5(rand(100000,999999)), 0, 8);
            db_array2update(TABLE_USERS_PARENTS, $fields, "parent_id ='".$parent_id."'");
          }

          $fields = array();
          
          if (empty($student['password'])) {
            $fields['login']    = $student_id.$login;
            $fields['password'] = substr(md5(rand(100000,999999)), 0, 8);
          }

if($dump) {echo "|$student_id|".$student['mother_fio']."|".$student['father_fio']."|\n";}

          if ($relative_id == 1){
            if (empty($student['mother_fio']) || ($student['mother_fio'] == $fio)){
              $fields['mother_fio'] = $fio;
              $fields['mother_cell_phone'] = $phone;
            }
          } else {
             if (empty($student['father_fio']) || ($student['father_fio'] == $fio)) {
              $fields['father_fio'] = $fio;
              $fields['father_cell_phone'] = $phone;
            }
          }
/*          elseif (!empty($phone)) {
            if (empty($student['mother_cell_phone']))
              $fields['mother_cell_phone'] = $phone;
            else
              $fields['father_cell_phone'] = $phone;
          } 
*/

if($dump) print_r($fields);
          if (!empty($fields))
            db_array2update(TABLE_USERS_STUDENTS, $fields, "student_id ='".$student_id."'");

          $fields = array();
          $fields['student_id'] = $student_id;
          $fields['parent_id']  = $parent_id;

if($dump) print_r($fields);

          $sql = "SELECT sp.studparent_id FROM `".TABLE_STUDENTS_IN_PARENT."` sp"
                ." WHERE (sp.student_id ='".$student_id."')"
                ." AND (sp.parent_id  ='".$parent_id."') LIMIT 0,1";
          $studparent_id = db_get_cell($sql);
if($dump) echo "|$studparent_id|$sql|\n";
          if (empty($studparent_id))
            $studparent_id = db_array2insert(TABLE_STUDENTS_IN_PARENT, $fields);
          else
            db_array2update(TABLE_STUDENTS_IN_PARENT, $fields, "studparent_id ='".$studparent_id."'");

        
          $lang_new_added       = $lang['new_phone_added'];
          $lang_new_added_error = $lang['new_added_error'];

          break;


  /** *********************************************************************************************** */


        case 'student_pass':


          if (trim($row[1]) == 'класс') {
            $class = $row[0];
            $class = an_to_ru($class);
            $class = str_to_upper($class);
            $sql = "SELECT class_id FROM `".TABLE_CLASSES."` WHERE"
                  ." (`class` ='".$class."') LIMIT 0,1";
            $class_id = db_get_cell($sql);
$dump=0;if($dump) echo "|$class_id|$sql|\n";
            if (empty($class_id)) {
              $row[0]=mysql_escape_string($row[0]);
     	  
              $fields['class'] = trim($class);
              $fields['school_year'] = $_SESSION['schoolyear'];
              $class_id = db_array2insert(TABLE_CLASSES, $fields);
//              $sql = "DELETE FROM `".TABLE_STUDENTS_IN_CLASS."` WHERE `class_id`='$class_id'";
//              db_query($sql);
            }
            break;
          }

          if (empty($row[0])) {
            $parent_id = 0;
            $student_id = 0;
            $relative_id = 0; 
            break;
          }

//          $row[1]=mysql_escape_string($row[1]);
//if($dump) print_r($row);
//          $row[1]=iconv("Windows-1251","UTF-8", $row[1]);
          if (strpos(join(';', $row), 'Логин:') > 1) {

            $fields['last_name']   = trim(substr($row[1], 0, 50));
            $fields['first_name']  = trim(substr(str_replace('.', '', $row[2]), 0, 50));
            $fields['middle_name'] = trim(str_replace('.', '', $row[3]));

              if ($row[3] == 'Логин:') {
                $i=-1;
                $fields['middle_name'] = '';
              } elseif ($row[4] == 'Логин:') {
                $i=0;
              } elseif ($row[5] == 'Логин:') {
                $i=1;
                $fields['middle_name'] .= trim(substr(str_replace('.', '', $row[3+$i]), 0, 50));
              }
              $fields['middle_name'] = trim(substr($fields['middle_name'], 0, 50));

            $fields['login']    = trim(substr($row[5+$i], 0, 64));
            $fields['password'] = trim(substr($row[8+$i], 0, 64));
          }else {
if($dump) print_r($row);
            for ($i = count($row)-1; $i > -1; $i--) {
              $row[$i] = trim(substr($row[$i], 0, 64));
              if (!empty($row[$i])) {
                $fields['password'] = $row[$i];
                $fields['login']    = $row[$i-1];
                unset($row[$i]);
                unset($row[$i-1]);
                break;
              }
            }  //  for ($i = 0
if($dump) print_r($row);

            $fields['last_name']   = trim(substr($row[0], 0, 50));
            $fields['first_name']  = trim(substr(str_replace('.', '', $row[1]), 0, 50));
            $fields['middle_name'] = trim(substr(str_replace('.', '', $row[2]), 0, 50));

          }

if($dump) print_r($fields);
          if ((trim($row[0]) == 'Ученик') || empty($student_id)){

            $sql = "SELECT s.student_id FROM `".TABLE_USERS_STUDENTS."` s"
                  ." LEFT JOIN `".TABLE_STUDENTS_IN_CLASS."` sc ON (sc.student_id=s.student_id)"
                  ." WHERE (sc.class_id='".$class_id."')"
                  ." AND (s.last_name  ='".$fields['last_name']  ."')"
                  ." AND (s.first_name ='".$fields['first_name'] ."')"
                  .((empty($fields['middle_name'])) ? "" : " AND ((s.middle_name='') OR (s.middle_name='".$fields['middle_name']."'))")
                  ." LIMIT 0,1";
            $student_id = db_get_cell($sql);
if($dump) echo "|$student_id|$sql|\n";
            if (empty($student_id)) {

              while(1) {
                $pin_code = rand(100000,999999);
                $sql="SELECT s.`pin_code`  FROM `".TABLE_USERS_STUDENTS."` s"
                    ." WHERE s.`pin_code`='".$pin_code."';";
                $pincode=db_get_cell($sql);
                if (empty($pincode)) 
                  break;
              }

              $fields['pin_code'] = $pin_code;

              $student_id = db_array2insert(TABLE_USERS_STUDENTS, $fields);

              $fields = array();
              $fields['class_id']   = $class_id;
              $fields['student_id'] = $student_id;

              db_array2insert(TABLE_STUDENTS_IN_CLASS, $fields);
            }else
              db_array2update(TABLE_USERS_STUDENTS, $fields, "student_id ='".$student_id."'");

            $relative_id = -1; 
          }
          elseif ((trim($row[0]) == 'Родитель') || empty($relative_id)) {
            $sql = "SELECT s.* FROM `".TABLE_USERS_STUDENTS."` s"
                  ." WHERE (s.student_id='".$student_id."')"
                  ." LIMIT 0,1";

            $student = db_get_first_row($sql);

            if (empty($parent_id)){
              $relative_id = 1; 
            } else {
              $relative_id = 2; 
            }

            if ($relative_id == 1){
              $fio = trim($fields['last_name']." ".$fields['first_name'] ." ".$fields['middle_name']);
            } else {
              $fio = trim($fields['last_name']." ".$fields['first_name'] ." ".$fields['middle_name']);
            }

            $fields['relative_id'] = $relative_id;

            $sql = "SELECT p.parent_id FROM `".TABLE_USERS_PARENTS."` p"
//                  ." LEFT JOIN `".TABLE_STUDENTS_IN_PARENT."` sp ON (sp.parent_id=p.parent_id)"
                  ." WHERE (p.relative_id ='".$relative_id."')"
//                  ." AND (sp.student_id ='".$student_id."')"
                  ." AND (p.last_name  ='".$fields['last_name']  ."')"
                  ." AND (p.first_name ='".$fields['first_name'] ."')"
                  .((empty($fields['middle_name'])) ? "" : " AND ((p.middle_name='') OR (p.middle_name='".$fields['middle_name']."'))")
                  ." LIMIT 0,1";
            $parent_id = db_get_cell($sql);

if($dump) echo "|$parent_id|$sql|\n";

            if (empty($parent_id)){
              $parent_id = db_array2insert(TABLE_USERS_PARENTS, $fields);
              $fields = array();
              $fields['student_id'] = $student_id;
              $fields['parent_id']  = $parent_id;
              $parent_id = db_array2insert(TABLE_STUDENTS_IN_PARENT, $fields);

            } else
              db_array2update(TABLE_USERS_PARENTS, $fields, "parent_id ='".$parent_id."'");

            $fields = array();
            if ($relative_id == 1){
              if (empty($student['mother_fio']))
                $fields['mother_fio'] = $fio;
            } else {
              if (empty($student['father_fio']))
                $fields['father_fio'] = $fio;
            }

if($dump) print_r($fields);
            if (!empty($fields))
              db_array2update(TABLE_USERS_STUDENTS, $fields, "student_id ='".$student_id."'");
          
          }

          $lang_new_added = $lang['new_student_pass_added'];

          break;


  /** *********************************************************************************************** */

        
        case 'teacher_sched':

          if (empty($row[1])) break;

//          $row[1]=mysql_escape_string($row[1]);
if($dump) print_r($row);
//          $row[1]=iconv("Windows-1251","UTF-8", $row[1]);
          
          if (!empty($row[0])) {
            $FIO =$row[0];
            $row[0] = str_replace('  ', ' ', $row[0]);
            list ($last_name , $_io) = explode (' ', $row[0]);
            list ($first_name , $middle_name, $_tmp) = explode ('.', $_io);
            $FIO = $last_name.' '.substr($first_name, 0,2).'.'.substr($middle_name, 0,2);
if($dump) print_r($fields);
            $sql = "SELECT teacher_id FROM `".TABLE_USERS_TEACHERS."` t WHERE"
                  ." (CONCAT(t.last_name, ' ', SUBSTRING(t.first_name, 1, 1), '.',  SUBSTRING(t.middle_name, 1, 1)) ='".$FIO."')"
                  ." LIMIT 0,1";
            $teacher_id = db_get_cell($sql);
if($dump) echo "|$teacher_id|$sql|\n";

            if (empty($teacher_id)) {
              $login = $fields['last_name']   = trim(substr($last_name, 0, 50));
              $fields['first_name']  = trim(substr($first_name, 0, 50));
              $fields['middle_name'] = trim(substr($middle_name, 0, 50));
              $fields['login'] = md5(rand());

              $teacher_id = db_array2insert(TABLE_USERS_TEACHERS, $fields);

              $fields = array();
              $fields['login']    = $teacher_id.$login;
              $fields['passwd'] = md5('1');
              db_array2update(TABLE_USERS_TEACHERS, $fields, "teacher_id ='".$teacher_id."'");
            } 
          } else {

            for ($i = 0; $i < 7; $i++) {
              if (empty($row[2+$i*2])) continue;

              $fields = array();
              $date_schedule  = $fields['date_schedule']  = $i;
              $order_schedule = $fields['order_schedule'] = $row[1+$i*2];
              $fields['teacher_id']     = $teacher_id;
              $fields['school_year']    = $_SESSION['schoolyear'];
              $quarters   = get_cur_quarter();
              $quarter_id = $fields['quarter_id']     = $quarters['quarter_id'];
              $fields['started']        = $quarters['started'];
              $fields['finished']       = $quarters['finished'];

              $disciplines = explode ('----', $row[2+$i*2]);

              for ($j = 0, $countj = count($disciplines); $j < $countj; $j++) {
                if (empty($disciplines[$j])) continue;

                $class   = '';
                $cabinet = '';
                $group   = '';
                list($discipline, $gc) = explode (',', $disciplines[$j]);
                if (empty($gc)) {
                  list($discipline, $cabinet, $class) = explode ('(', $discipline);
                  if (empty($class)) {
                    $class = $cabinet;
                    $cabinet = '';
                  }
                } else {
//Английский язык, англ. язык 1 подгр. (6г)
                  list($group, $class) = explode ('(', $gc);
                  $group = trim($group);
                  $groups = explode (' ', $group);
                  $count=count($groups);
                  $n = ceil(8/$count);
if($dump) echo "$group|$count|$n>";
                  $short = '';
                  for ($k = 0; $k < $count; $k++) {
                    $short .= substr($groups[$k], 0, $n*2);
if($dump) echo "$k|$groups[$k]|";
                  }  //  for ($i = 0
if($dump) echo "$short|<br>\n";

                  list($discipline, $cabinet) = explode ('(', $discipline);
                }

                $class   = str_replace(')', '', $class);
                $cabinet = str_replace(')', '', $cabinet);
                $discipline = trim($discipline);
                if (!empty($cabinet)) {
                  if (!empty($group) && ($group != $cabinet)) 
                    $fields['cabinet'] = $cabinet;
                }

                if (!empty($discipline)) {
                  $sql = "SELECT discipline_id FROM `".TABLE_SPR_DISCIPLINES."` WHERE"
                        ." (`discipline` ='".$discipline."') LIMIT 0,1";
                  $discipline_id = db_get_cell($sql);
                  if (!empty($discipline) && empty($discipline_id)) {
                    $fieldss = array();
                    $fieldss['discipline'] = trim($discipline);

                    $discipline_id = db_array2insert(TABLE_SPR_DISCIPLINES, $fieldss);
if($dump) echo "|$discipline_id|$sql|\n";
                  }
                  $fields['discipline_id'] = $discipline_id;
                } else
                  unset($fields['discipline_id']);

                $group_id = 0;
                if (!empty($group)) {
                  $sql = "SELECT group_id FROM `".TABLE_SPR_GROUPS."` WHERE"
                        ." (`group` ='".$group."') LIMIT 0,1";
                  $group_id = db_get_cell($sql);
                  if (!empty($group) && empty($group_id)) {
                    $fieldss = array();
                    $fieldss['group'] = trim($group);
                    $fieldss['short'] = substr(trim($short), 0, 16);

                    $group_id = db_array2insert(TABLE_SPR_GROUPS, $fieldss);
if($dump) echo "|$group_id|$sql|\n";
                  }
                  $fields['group_id'] = $group_id;
                } else
                  unset($fields['group_id']);

                if (!empty($class)) {
                  $class = an_to_ru($class);
                  $class = str_to_upper($class);
                  $sql = "SELECT class_id FROM `".TABLE_CLASSES."` WHERE"
                        ." (`class` ='".$class."') LIMIT 0,1";
                  $class_id = db_get_cell($sql);
                  if (!empty($class) && empty($class_id)) {
                    $fieldss = array();
                    $fieldss['class'] = trim($class);
                    $fieldss['school_year'] = $_SESSION['schoolyear'];

                    $class_id = db_array2insert(TABLE_CLASSES, $fieldss);
if($dump) echo "|$class_id|$sql|\n";
                  }
                  $fields['class_id'] = $class_id;
                } else
                  unset($fields['class_id']);

if($dump) {echo "\n[$i:$j] schedule=";print_r($fields);}

                if (!empty($discipline_id) && !empty($teacher_id) && !empty($class_id)){

                  $sql = "SELECT id_schedule FROM `".TABLE_SCHEDULE."` WHERE"
                        ."     (`school_year`    ='".$_SESSION['schoolyear']."')"
                        ." AND (`date_schedule`  ='".$date_schedule."')"
                        ." AND (`order_schedule` ='".$order_schedule."')"
                        ." AND (`discipline_id`  ='".$discipline_id."')"
                        ." AND (`teacher_id`     ='".$teacher_id."')"
                        ." AND (`class_id`       ='".$class_id."')"
                        ." AND (`group_id`       ='".$group_id."')"
                        ." LIMIT 0,1";
                  $schedule_id = db_get_cell($sql);
                  if (empty($schedule_id)) {
                    $schedule_id = db_array2insert(TABLE_SCHEDULE, $fields);
                  }

                  if (!empty($group)) {
                    $fieldss = array();
                    $fieldss['group_id'] = $group_id;
                    $fieldss['class_id'] = $class_id;
                    $subject_id = db_get_cell($sql);
                    $sql = "SELECT clsgrp_id FROM `".TABLE_CLASSES_IN_GROUPS."` WHERE"
                          ." (`group_id` ='".$group_id."')"
                          ." AND (`class_id` ='".$class_id."') LIMIT 0,1;";
                    $clsgrp_id = db_get_cell($sql);
                    if (empty($clsgrp_id)) {
                      $group_id = db_array2insert(TABLE_CLASSES_IN_GROUPS, $fieldss);
                    }
                  }

                  $sql = "SELECT subject_id FROM `".TABLE_SUBJECTS."` WHERE"
                        ." (`discipline_id` ='".$discipline_id."')"
                        ." AND (`teacher_id` ='".$teacher_id."')"
                        ." AND (`class_id` ='".$class_id."')"
                        ." LIMIT 0,1";
                  $subject_id = db_get_cell($sql);
                  if (empty($subject_id)) {
                    $fieldss = array();
                    $fieldss['discipline_id'] = $discipline_id;
                    $fieldss['teacher_id']    = $teacher_id;
                    $fieldss['class_id']      = $class_id;

                    $subject_id = db_array2insert(TABLE_SUBJECTS, $fieldss);
if($dump) echo "subject|$subject_id|$sql|\n";
if($dump) print_r($fields);
                  }
                }
              }  //  for ($j = 0

            }  //  for ($i = 0
          }
          $lang_new_added = $lang['new_teacher_shed_added'];
          
          break;

        default:

          break;

      }  //  switch ()

    }  //  while ($row

//die();
    if (empty($error)){
      header('Location: '.basename(__FILE__).'?mode=success_add&message='.$lang_new_added);
      exit();
    }else
      $mode='error_add';

  }  //  if ($action == 'add')

  elseif ($action == 'update') {
    
    /// Загрузка фото учинека
    $teacher_photo = UploadedPhotoFile("../teacher_photo/".SUBDOMEN."/");
    
	$fields = array();
	//запись имени фото в бд
    $fields[] = "photo='".$teacher_photo."'";
    
    $fields[] = "last_name='". mysql_escape_string(substr($_POST['last_name'], 0, 25))."'";
    $fields[] = "first_name='".mysql_escape_string(substr($_POST['first_name'], 0, 25))."'";
    $fields[] = "middle_name='".mysql_escape_string(substr($_POST['middle_name'], 0, 25))."'";

    $fields[] = "login='".mysql_escape_string(substr($_POST['login'], 0, 25))."'";

    if (isset($_POST['passwd'])) {
      $fields[] = "passwd='".md5($_POST['passwd'])."'";
    }

    db_query($sql = "UPDATE `".TABLE_USERS_TEACHERS."` SET ".implode(', ', $fields)." WHERE teacher_id='".$teacher_id."'");
    header('Location: '.basename(__FILE__).'?mode=success_update');
    exit();

  }  //  if ($action == 'update')
}  //  if (isset($_REQUEST['action']))

  include('../header_dialog.php');
?>
  <body style="margin-left: 0px;margin-right: 0px;">
<?php

//echo '$lang=';print_r ($lang);
//echo "<br>$mode|".$_REQUEST['message']."|".$lang_new_added."|".$lang_new_added_error;
  if ($mode == 'success_update') {
  	echo '<center>'.$lang['teacher_update_add_good'].'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" /></center>';
  } elseif ($mode == 'success_add') {
        if ($_REQUEST['message'])
          $lang_new_added = $_REQUEST['message'];
  	echo '<center>'.$lang_new_added.'<br /><br />';
  	echo '<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" />
  	&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;'.$lang['continue'].'&nbsp;&nbsp;" onclick="document.location=\''.basename(__FILE__).'\'" /></center>';
  } elseif ($mode == 'error_add') {
  	echo '<center>'.$lang_new_added_error.'<br /><br /></center>';
  	echo join('<br>', $error).'<br><br>';
  	echo '<center>'.'<input type="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" />
  	&nbsp;&nbsp;<input type="button" value="&nbsp;&nbsp;'.$lang['continue'].'&nbsp;&nbsp;" onclick="document.location=\''.basename(__FILE__).'\'" /></center>';
  } elseif ($mode == 'update') {
    $teacher  = db_get_first_row("SELECT * FROM `".TABLE_USERS_TEACHERS."` WHERE teacher_id='".$teacher_id."'");
    outTeacherForm($teacher);
  } elseif ($mode == 'add') {
    outTeacherForm();
  }

function outTeacherForm($teacher = null)
{
global $lang;
	global $teacher_id;
	global $C_teacher_list,
	       $C_teacher_pass,
	       $C_teacher_sched,
	       $C_parents_phone,
	       $C_student_pass;



	echo ' <center><b>'.$lang['header_1dnevnik'].'</b></center>
<form action="'.basename(__FILE__).'" method="post" enctype="multipart/form-data">
<input type="hidden" name="action" value="add" />
<table id="edit_in" align="center">
<tbody>
  <tr>
    <td>Тип файла</td>
    <td>
      <select name="typecsv">
      <option value="">Выберите тип</option>
      <option value="teacher_list" '.$C_teacher_list.'>Список учителей</option>
      <option value="teacher_pass" '.$C_teacher_pass.'>Пароли для учителей</option>
      <option value="teacher_sched" '.$C_teacher_sched.'>Расписание учителей</option>
      <option value="parents_phone" '.$C_parents_phone.'>Телефоны родителей</option>
      <option value="student_pass" '.$C_student_pass.'>Пароли для студентов</option>
      </select>
    </td>
  </tr>

  <tr>
    <td>Загрузить файл</td>
    <td><input type="file" size="15" name="uploadfile" /></td>
   </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="center">
   <input type="button" class="button" value="'.$lang['add'].'" onClick="this.form.submit();">

    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <input type="button" class="button" value="&nbsp;&nbsp;'.$lang['close'].'&nbsp;&nbsp;" onclick="if(self == self.parent) parent.location=document.referrer; else {self.parent.tb_remove();self.parent.location.reload();}" /></td>
  </tr></tbody></table></form>
  ';
}

?>
  </body>
</html>