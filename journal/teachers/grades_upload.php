<?php
   $file_xls = "../phpexcel/grades.xls";
   if (is_file($file_xls))
     unlink ($file_xls);
sleep(1);
   if(copy($_FILES["filename"]["tmp_name"], $file_xls))
   {sleep(2);
     header("Location: grades_read.php");
   } else {
      echo("Ошибка загрузки файла");
   }
?>

