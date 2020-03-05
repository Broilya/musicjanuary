<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                    |
+-----------------------------------------------------------------------------+
\*****************************************************************************/



define('ADMIN_ZONE', true);

include_once ('../init.php');
include 'header.php';
include_once ('../include/teachers.php');

if ($_POST['delete_this']=='yes') {
	
	$temp=array_shift($_POST);
	
	foreach ($_POST as $key=> $id) 
	{
	$id=substr($key, 2);
	
	//echo $id;	
	$query = "DELETE FROM `".TABLE_SPR_DISCIPLINES."` WHERE discipline_id ='".$id."'";
	//echo $query;
	
  	$res=mysql_query($query);
    }
}


?>
<div align="center">
<span class="head_top"><?php echo $lang['disp_list']?></span>
  <form name='del' method='post' action='' id='disciplines'>
<table id="rounded-corner">
  <thead>
  <tr>
    <th class="rounded-left"><?php echo $lang['nazvanie']?></th>
    <th width="125">&nbsp;</th>
    <th width="25" class="rounded-right">
<?php
  $res = db_query("SELECT * FROM `".TABLE_SPR_DISCIPLINES."` ORDER BY discipline;");
  if (!empty($res)) {
    echo '<input name="allMark" type="checkbox" onclick="if (this.checked == true) markAllRows(this.form.id); else unMarkAllRows(this.form.id);" title="Отметить все" value=1>';
  } else echo '&nbsp;';
?>    
    </th>
  </tr>
  <thead>
  <tbody>
  <input type='hidden' name='delete_this' value='yes'>
<?php
  while($row = mysql_fetch_assoc( $res)) {

    echo "<tr class=odd><td>$row[discipline]</td><td><a href=\"discipline.php?discipline_id=$row[discipline_id]&TB_iframe=true&height=110&width=250&".uniqid('r')."\" title=\"Редактировать дисциплину\" class=\"thickbox\">{$lang['edit']}</a></td>
      <td><input value='1' type='checkbox' name='id" . $row["discipline_id"] . "' ></td></tr>";

  }
?>
<tr><td>&nbsp;</td>
  <td colspan='2' align="right"><input id='delete' name="delete" class='butonoff' disabled="true"  type='submit' value='<?php echo $lang['delete']?>'
    onclick="if (confirm('Вы желаете удалить дисциплину?')) return true; else return false;"></td></tr>
<tfoot>
    	<tr>
       	  <td class="rounded-foot-left">&nbsp;</td>
          <td class="rounded-foot-right" colspan="2"><a href="" onClick="javascript: tb_show('<?php echo $lang['add']?>', 'discipline.php?TB_iframe=true&height=110&width=250&<?php echo uniqid('r'); ?>'); return false;" class="add" title="<?php echo $lang['add']?> новую дисциплину"><?php echo $lang['add']?></a></td>
        </tr>
    </tfoot>
</table>
</form>
</div>
<?php
include 'footer.php';
?>