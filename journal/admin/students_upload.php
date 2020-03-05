<?php

   $file_xls = "../phpexcel/students.xls";
   if (is_file($file_xls))
     unlink ($file_xls);
sleep(1);
   if(copy($_FILES["filename"]["tmp_name"], $file_xls))
   {sleep(2);
     header("Location: students_read.php?school_year=".$_REQUEST['school_year']."&filename=".$_FILES["filename"]["name"]);
   } else {
      echo("Ошибка загрузки файла '".$_FILES["filename"]["name"]."'");
   }
?>

