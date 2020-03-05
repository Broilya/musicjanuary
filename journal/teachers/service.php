<?php
define('TEACHER_ZONE', true);
include_once ('../init.php');
include_once ('../include/classes.php');
include 'header.php';
?><div id="rc"><!-- ПРАВАЯ КОЛОНКА!!! -->
	  <span class="right_col">


	  </span></div>
	<div id="lc"><!-- ЛЕВАЯ КОЛОНКА!!! -->
	  <span class="right_left">
      <div class="body_d">
          <center>
              <strong>Сервисные оперции</strong>            
          </center>
          <ul>
              <li><a href='services.php'>Загрузка оценок из Экселя</a></li>
              <li><a href='sms_send_page.php'>Отсылка оценок родителям</a></li>
              <li><a href='replace.php'>Перевод учеников в другой класс</a></li>
              
              
          </ul>
<?php

include_once ('footer.php');
?>
	
