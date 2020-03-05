<?php

$dump=1;if ($dump) {echo 'egppk) <br><pre>$_REQUEST=|';print_r($_REQUEST);echo '</pre>|<br>';}
$dump=1;if ($dump) {echo 'egppk) <br><pre>$_SERVER=|';print_r($_SERVER);echo '</pre>|<br>';}
    $DIR_FS_PAGES = '../../demo.el-dn.ru/public_html/teacher_photo/';
    $DIR_FS_PAGES = './';
    $DIR_FS_PAGES = 'teacher_photo/';
    if($d=@dir("$DIR_FS_PAGES")) {
      echo $DIR_FS_PAGES.":<br>\n";
      while(false !==($file=$d->read())) {
        if ($file[0] == '.') continue;
        echo  $file."<br>\n";
      }
      $d->close();

    }


?>