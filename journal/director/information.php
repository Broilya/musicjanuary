<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('DIRECTOR_ZONE', true);

include_once ('../init.php');
include 'header.php';
include_once ('../include/information.php');


if ($_POST['delete_this']=='yes') {
	
	$temp=array_shift($_POST);
	
	foreach ($_POST as $key=> $id) 
	{
	$id=substr($key, 2);
	
	//echo $id;	
	$query = "DELETE FROM `".TABLE_INFORMATION."` WHERE information_id='".$id."'";
	//echo $query;
	
  	$res=mysql_query($query);
  	
 
    }
	
	
	
}




?>
<div align="center">
<span class="head_top">Информация - Сообщение учащимся и учителям</span>
<table id="rounded-corner">
  <thead>
  <tr>
    <th class="rounded-left">Дата</th>
    <th>Кому</th>
    <th>Тема</th>
    <th class="rounded-right" colspan="3">&nbsp;</th>
  </tr>
  </thead>
  <tbody>
<?php
  $information_list = get_information_list();
 echo " <form name='del' method='post' action=''>
  <input type='hidden' name='delete_this' value='yes'>";
  foreach($information_list as $information) {
// Доблено кнопку удалить 
  if ($information['information_section']=='student')
  {
  	$section='Ученикам';
  }
  elseif($information['information_section']=='teacher')
  {
  	$section='Учителям';
  }
  
  echo "<tr><td>$information[information_date]</td>
   <td>$section</td>
  <td>$information[information_title]</td><td>
  <a href=\"info.php?information_id=$information[information_id]&".uniqid('')."&keepThis=true&TB_iframe=true&height=350&width=400&modal=true\" class=\"thickbox\" title=\"Редактировать информацию\">Редактировать</a></td>
  <td><input value='1' type='checkbox' name='id" . $information["information_id"] . "'></td></tr>";
  }
?>
<tr><td colspan='4'><td>
<input type='submit' value='Удалить'>
</form>
</tbody>
<tfoot>
    	<tr>
       	  <td class="rounded-foot-left" colspan="3">&nbsp;</td>
        	<td class="rounded-foot-right" colspan="3"><a href="" onClick="javascript: tb_show('Добавить', 'info.php?<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=350&width=400&modal=true'); return false;" class="add" title="Добавить">Добавить</a>
      </td>
        </tr>
    </tfoot>
</table>
</div>
<?php
include 'footer.php';
?>