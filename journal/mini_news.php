<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


//define('TEACHER_ZONE', true);

include_once ('init.php');
include 'header.php';
include_once ('include/information.php');

 if (isset($_GET['view']) && intval($_GET['view']) > 0)
 {

?>
<div align="center">
<span class="head_top"><?php echo $lang['info_mess_student_main'];?></span>
<table id="rounded-corner">
  <thead>
  <tr>
    <th class="rounded-left"><?php echo $lang['inform_data'];?></th>
    <th><?php echo $lang['inform_tema'];?></th>
    <th class="rounded-right"><?php echo $lang['inform_messs'];?></th>
  </tr>
  </thead>
  <tbody>
<?php
  $information_list = get_information_list_at_news($_GET['id']);
  foreach($information_list as $information) {

  if( $information['information_id']==$_GET['view'])
  {
  	echo "<tr><td>$information[information_date]</td>
    <td>$information[information_title]</td>
	<td>$information[information_text]</td>
	</tr>";
   }
  }
?>
</tbody>
<tfoot>
    	<tr>
       	  <td class="rounded-foot-left" colspan="2">&nbsp;</td>
        	<td class="rounded-foot-right"><a href="javascript:history.go(-1)"><< <?php echo $lang['back'];?></a></a></td>
        </tr>
    </tfoot>
</table>
</div> 
<? } else {?>
<div align="center">
<span class="head_top"><?php echo $lang['info_mess_student_main'];?></span>
<table id="rounded-corner">
  <thead>
  <tr>
    <th class="rounded-left"><?php echo $lang['inform_data'];?></th>
    <th class="rounded-right"><?php echo $lang['inform_tema'];?></th>
  </tr>
  </thead>
  <tbody>
<?php
  $information_list = get_information_list_at_news($_GET['id']);
  foreach($information_list as $information) {

 
  	echo "<tr><td>$information[information_date]</td>
    <td><a href='?id={$_GET['id']}&view=$information[information_id]'>$information[information_title]</a></td></tr>";
   
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