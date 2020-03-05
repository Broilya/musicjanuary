<?php 
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('PARENT_ZONE', true);

include_once ('../init.php');

include_once ('../include/information.php');
include_once ('../include/students.php');

$dump=0;if ($dump) {echo "|_SESSION=|";print_r($_SESSION);}

 $student_in_class = get_student_in_class($_SESSION['student_id']); 
 
 if (isset($_GET['view']) && intval($_GET['view']) > 0)
 {

?>
<br />
<div align="center">

<table >
    <tbody>
<?php
  $information_list = get_information_list();

  foreach($information_list as $information) {

  if($information['information_section']=='student' && $information['information_id']==$_GET['view'])
  {
  	
    echo "<tr><td>Дата:<td>$information[information_date]<br>
    <tr><td>Тема:<td>$information[information_title]<br>
	<tr><td>Сообщение:<td>$information[information_text]<br>
	</tr>";
   }
    if($information['information_section']=='personal' && $information['information_classes']==$_SESSION['student_id'] && $information['information_id']==$_GET['view'])
  {
  
  	echo "<tr><td>Дата:<td>$information[information_date]<br>
    <tr><td>Тема:<td>$information[information_title]<br>
	<tr><td>Сообщение:<td>$information[information_text]<br>
	</tr>";
   }
  }
?>
</tbody>
<tfoot>
    	<tr>
       	  <td >&nbsp;</td>
        	<td ><a href="javascript:history.go(-1)"><< <?php echo $lang['back'];?></a></a></td>
        </tr>
    </tfoot>
</table>
</div> 
<?php } else {?>
<br />
<div align="center">

<table id="rounded-corner">
  <thead>
  <tr>
    <th ><?php echo $lang['inform_data'];?></th>
    <th ><?php echo $lang['inform_tema'];?></th>
  </tr>
  </thead>
  <tbody>
<?php
  $information_list = get_information_list();
  foreach($information_list as $information) {

  if($information['information_section']=='student' && ($information['information_classes'] == '0' || $information['information_classes'] == $student_in_class['class_id'])){
  	echo "<tr><td>$information[information_date]</td>
    <td><a href='?view=$information[information_id]'>$information[information_title]</a></td></tr>";
   }
   
  if($information['information_section']=='personal' && $information['information_classes']==$_SESSION['student_id'] )
  {
  
  	echo "<tr><td>$information[information_date]</td>
    <td><a href='?view=$information[information_id]'>$information[information_title]</a></td></tr>";
 
   }
   
  }
?>
</tbody>
<tfoot>
    	<tr>
       	  <td class="rounded-foot-left">&nbsp;</td>
        	<td class="rounded-foot-right" colspan="2"></td>
        </tr>
    </tfoot>
</table>
</div>
<?php } ?>
<?php
include 'footer.php';
?>