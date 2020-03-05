<?php

  header("Content-type: text/html; charset=utf-8");
  define('ADMIN_ZONE', true);
  include_once ('../init.php'); 
  
  error_reporting(E_ALL & ~E_NOTICE);
      $classfrom_id = (int)$_REQUEST['classfrom_id'];
      $classto_id   = (int)$_REQUEST['classto_id'];
      $student_id   = (int)$_REQUEST['student_id'];

      if (!empty($classto_id)) {
        $data = array();
        $data['class_id']    = $classto_id;
        $data['student_id']  = $student_id;
        $where = " (`student_id`='".$student_id."') AND (`class_id`='".$classfrom_id."')";
        $class = db_get_cell("SELECT class FROM `".TABLE_CLASSES."` WHERE `class_id`='".$classto_id."' LIMIT 0,1");

if ($dump) {echo $where.'<br><pre>$_request=|';print_r($data);echo '</pre>|<br>';}

        $class_0 = db_get_cell("SELECT class_id FROM `".TABLE_STUDENTS_IN_CLASS."` WHERE ".$where." LIMIT 0,1");
        if ($class_0 == $classfrom_id){
          if ($classto_id == $classfrom_id){
            echo "<span style='color:red;'>Ученик присутствует в ".$class." классе.</span>";
          }else{
            if (db_array2update(TABLE_STUDENTS_IN_CLASS, $data, $where))
              echo "Ученик переведен в ".$class." класс.";
            else 
              echo "<span style='color:red;'>Ученика не удалось перевести в ".$class." класс.</span>";
          }
        } else {
          echo "<span style='color:red;'>Ученика нельзя перевести в ".$class." класс.</span>";
        exit();
          db_array2insert(TABLE_STUDENTS_IN_CLASS, $data);
        }
      } else
        echo "<span style='color:red;'>Не задан класс для перевода.</span>";
?>