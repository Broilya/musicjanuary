<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                     |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('DIRECTOR_ZONE', true);
include_once ('../init.php');
include 'header.php';
include_once ('../include/classes.php');
?>
<br />
<div align="center">
        <?php

          $res=mysql_query("SELECT * FROM `".TABLE_USERS_TEACHERS."` WHERE teacher_id=".$teacher_id."");
          $name=mysql_result($res,0,3);
          $fam=mysql_result($res,0,5);
          $otch=mysql_result($res,0,4);

          print "<span class='head_top'>".$fam."&nbsp;".$name[0].$name[1]."&nbsp;".$otch[0].$otch[1]."</span>";
        ?>
<span class="head_top">Список классов:</span>
<table id="rounded-corner">
<thead>
  <tr>
    <th class="rounded-left">Класс</th>
    <th>Предмет</th>
    <th class="rounded-right">&nbsp;</th>
  </tr>
</thead>
<tbody>
<tr>
<?php
  $classes_list = get_classe_list_from_teacher($teacher_id);
  $q=mysql_query("SELECT * FROM `".TABLE_CLASSES."` WHERE teacher_id=".$teacher_id);
  $class_t=mysql_result($q,0,1);
  $letter_t=mysql_result($q,0,2);
  foreach($classes_list as $class) {
  if(($class['class']==$class_t)and($class['letter']==$letter_t)){
  echo '<tr><td style="color: red;"><b>'.$class['class'].'-'.$class['letter']."</b></td><td>$class[discipline]</td><td><a href=\"lessons.php?subject_id=$class[subject_id]\">Уроки</a></td></tr>";
  }else{
  echo '<tr><td>'.$class['class'].'-'.$class['letter']."</td><td>$class[discipline]</td><td><a href=\"lessons.php?subject_id=$class[subject_id]\">Уроки</a></td></tr>";
  }
  }
?>
</tr>
</tbody>
<tfoot>
    	<tr>
       	  <td colspan="2" class="rounded-foot-left"></td>
        	<td class="rounded-foot-right">&nbsp;</td>
        </tr>
    </tfoot>
</table>
<?php

include 'footer.php';
?>