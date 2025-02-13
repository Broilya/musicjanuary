<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                      |
+-----------------------------------------------------------------------------+
\*****************************************************************************/
 

define('ADMIN_ZONE', true);

include_once ('../init.php');
include 'header.php';
?>
<style type="text/css">
#oned p {
  text-indent: 20px;
  margin-bottom:10px;
 }
#oned a{
 font-size:16px;
 font-weight:bold;
 }
</style>
<div align="center" id='oned'> 
<h2><?php echo $lang['header_1dnevnik'];?></h2>
<br />
<div align="left" style="width: 600px;"> 

<p>Если Ваша школа подключена к 1dnevnik.ru и Вы желаете использовать Ваши данные из него, то Вам необходимо сохранить эти данные приведенным ниже способом.</p>

<p>Для создания списков учителей Вам необходимо зайти в <a href="1dnevnik.ru" target="_blank">1dnevnik.ru</a> и перейти на закладку "Школа" и затем выбрать "Школьный персонал".
После того , как страница загрузится , в Вашем браузере выберите "Файл" -> "Сохранить как..." -> "Вэб-страница, только HTML".
Вам будет предложено сохранить файл "<b>school.htm</b>" - ответить "Сохранить", потом кликните на эту ссылку:

<a href="" onClick="javascript: tb_show('Добавить', 'read_csv.php?typecsv=teacher_list&<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=230&width=350'); return false;" class="add" title="Добавить"><?php echo 'Список учителей';?></a>

 и выберите сохраненный файл "<b>school.htm</b>" и кликните "Добавить".
</p>

<p>Для создания расписания Вам необходимо зайти в <a href="1dnevnik.ru" target="_blank">1dnevnik.ru</a> и перейти на закладку "Расписание учителей" и затем выбрать "Экспорт" (зеленая кнопка сверху справо).
Вам будет предложено сохранить файл "<b>Расписание_учителей_14.11.2011-19.11.2011.csv</b>" - ответить "Сохранить", потом кликните на эту ссылку:

<a href="" onClick="javascript: tb_show('Добавить', 'read_csv.php?typecsv=teacher_sched&<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=230&width=350'); return false;" class="add" title="Добавить"><?php echo 'Расписание учителей';?></a>

 и выберите сохраненный файл "<b>Расписание_учителей_14.11.2011-19.11.2011.csv</b>" и кликните "Добавить".
</p>

<p>Для создания списков уччеников и их родителей Вам необходимо зайти в <a href="1dnevnik.ru" target="_blank">1dnevnik.ru</a> и перейти на закладку "Классы" и затем выбрать "Родители".
После того , как страница загрузится , в Вашем браузере выберите "Файл" -> "Сохранить как..." -> "Вэб-страница, только HTML".
Вам будет предложено сохранить файл "<b>parents.htm</b>" - ответить "Сохранить", потом кликните на эту ссылку:

<a href="" onClick="javascript: tb_show('Добавить', 'read_csv.php?typecsv=parents_phone&<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=230&width=350'); return false;" class="add" title="Добавить"><?php echo 'Телефоны родителей';?></a>

 и выберите сохраненный файл "<b>parents.htm</b>" и кликните "Добавить".
</p>

<p>Если у Вас есть данные о логинах и паролях преподавателей, учеников и родителей, то необходимо связаться с нами и предоставить формат ваших файлов.</p>
<p>Если же Ваши файлы имеет такую структуру :
</p>
<p> - для преподавателей:<br>
<br>
<hr>
<br>

Фамилия Имя Отчество логин пароль<br>
Фамилия Имя Отчество логин пароль<br>
...<br><br>
<hr>
<br>

кликните на эту ссылку: <a href="" onClick="javascript: tb_show('Добавить', 'read_csv.php?typecsv=teacher_pass&<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=230&width=350'); return false;" class="add" title="Добавить"><?php echo 'Пароли для учителей';?></a>
</p>
<p></p>
<p>- для учеников (если в семье несколько учеников, то заполнять для каждого в соответствующем классе) :<br>
<br>
<hr>
<br>
ХХХХ класс<br>
<br>
ФамилияУченика ИмяУченика ОтчествоУченика логин пароль<br>
ФамилияМатери ИмяМатери ОтчествоМатери логин пароль<br>
ФамилияОтца ИмяОтца ОтчествоОтца логин пароль<br>
<br>
ФамилияУченика ИмяУченика ОтчествоУченика логин пароль<br>
ФамилияМатери ИмяМатери ОтчествоМатери логин пароль<br>
ФамилияОтца ИмяОтца ОтчествоОтца логин пароль<br>
<br>
....<br><br>
<hr>
<br>

кликните на эту ссылку: <a href="" onClick="javascript: tb_show('Добавить', 'read_csv.php?typecsv=student_pass&<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=230&width=350'); return false;" class="add" title="Добавить"><?php echo 'Пароли для студентов';?></a>

</p>

<?php

?>
<p></p>
<p></p>
<p></p>

<br/> 
</div> 
</div> 
<br/> 
<?php
include 'footer.php';
?>