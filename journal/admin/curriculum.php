<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                     |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('ADMIN_ZONE', true);

include_once ('../init.php');
include 'header.php';
include_once ('../include/curriculums.php');


if ($_POST['delete_this']=='yes') {
	
	$temp=array_shift($_POST);
	
    foreach ($_POST as $key=> $id) 
    {
	$id=substr($key, 2);
	
	//echo $id;	
	$query = "DELETE FROM `".TABLE_SCHOOL_YEARS."` WHERE school_year_id ='".$id."'";
	//echo $query;
	
  	$res=mysql_query($query);
    }
}



if ($_POST['delete_this2']=='yes') {
	
	$temp=array_shift($_POST);
	
    foreach ($_POST as $key=> $id) 
    {
	$id=substr($key, 2);
	
	//echo $id;	
	$query = "DELETE FROM `".TABLE_SCHOOL_QUARTERS."` WHERE quarter_id ='".$id."'";
	//echo $query;
	
  	$res=mysql_query($query);
    }
}


if (isset($_REQUEST['school_year_id'])) {
	$school_year_id = intval($_REQUEST['school_year_id']);
} else {
  $school_year_id = 0;
}

if ($school_year_id == 0) {
$school_years = get_school_years();
?>
<div align="center">
<span class="head_top"><?php echo $lang['years_list_q'];?></span>
<table id="rounded-corner">
  <thead>
  <tr>
    <th class="rounded-left"><?php echo $lang['year'];?></th>
    <th><?php echo $lang['current_year']?></th>
    <th><?php echo $lang['current_year_start']?></th>
    <th><?php echo $lang['current_year_end']?></th>
    <th width="125">&nbsp;</th>
    <th class="rounded-right" width="25">&nbsp;</th>
  <tr>
  </thead>
      <form name='del' method='post' action=''>
  <input type='hidden' name='delete_this' value='yes'>
  <tbody>
<?php foreach($school_years as $school_year) {?>
  <tr>
    <td nowrap="nowrap"><a href="curriculum.php?school_year_id=<?php echo $school_year['school_year_id']; ?>" title="<?php echo $lang['add_new_period_w'];?>"><?php echo $school_year['name_year'];?></a></td>
    <td align="center"><?php if ($school_year['current']) {echo $lang['yes']; } ?></td>
    <td><?php echo $school_year['started'];?></td>
    <td><?php echo $school_year['finished'];?></td>
    <td><a href="school_year.php?school_year_id=<?php echo $school_year['school_year_id']; ?>&TB_iframe=true&keepThis=true&height=200&width=420&<?php echo uniqid('sy'); ?>" title="Редактировать учебный год" class="thickbox"><?php echo $lang['edit']?></a></td>
     <td><?php echo "<input value='1' type='checkbox' name='id" . $school_year['school_year_id'] . "'";?> > 
    
  </tr>
<?php } ?>
<tr><td colspan='4'>&nbsp;</td>
    <td colspan='2' align="right"><input type='submit' value='Удалить'
    onclick="if (confirm('Вы желаете удалить учебный год?')) return true; else return false;"></td></tr>
  </tbody>
</form>
<tfoot>
    	<tr>
       	  <td colspan="4" class="rounded-foot-left">&nbsp;</td>
        	<td class="rounded-foot-right" colspan="2"><a href="" onClick="javascript: tb_show('Добавить год', 'school_year.php?<?php echo uniqid('') ?>&TB_iframe=true&&keepThis=true&height=200&width=420'); return false;" class="add" title="Добавить год"><?php echo $lang['add_new_year'];?></a>
</td>
        </tr>
    </tfoot>
</table>
</div>
<?php
} else {
  $quarters_in_year = get_quarters_in_year($school_year_id);
  $school_year = get_school_year($school_year_id);
?>
<div align="center">
<span class="head_top"><a href="curriculum.php"><?php echo $lang['years_list_q'];?></a>&nbsp;&gt;&gt;&nbsp;<?php echo $school_year['name_year']; ?></span>
<table id="rounded-corner">
  <thead>
  <tr>
    <th class="rounded-left"><?php echo $lang['period_name'];?></th>
    <th><?php echo $lang['type'];?></th>
    <th><?php echo $lang['current_year'];?></th>
    <th><?php echo $lang['current_year_start'];?></th>
    <th><?php echo $lang['current_year_end'];?></th>
    <th width="125">&nbsp;</th>
    <th class="rounded-right" width="25">&nbsp;</th>
  <tr>
  </thead>
      <form name='del1' method='post' action=''>
  <tbody>
  <input type='hidden' name='delete_this2' value='yes'>
<?php 
 foreach($quarters_in_year as $quarter) {?>
  <tr>
    <td nowrap="nowrap"><?php echo $quarter['quarter_name'];?></td>
    <td align="center"><?php if ($quarter['quarter_type'] == 1) {echo $lang['period_type_u']; } else {echo $lang['period_type_k'];} ?></td>
    <td align="center"><?php if ($quarter['current']) {echo 'Да'; } ?></td>
    <td><?php echo $quarter['started'];?></td>
    <td><?php echo $quarter['finished'];?></td>
    <td><a href="quarter.php?quarter_id=<?php echo $quarter['quarter_id']; ?>&TB_iframe=true&height=200&width=400&<?php echo uniqid('sy'); ?>" title="Редактировать учебный период" class="thickbox"><?php echo $lang['edit'];?></a></td>
  <td><?php echo "<input value='1' type='checkbox' name='id" . $quarter['quarter_id'] . "'";?> ></td></tr>
<?php } ?>
<tr><td colspan='5'>&nbsp;</td>
    <td colspan='2' align="right"><input type='submit' value='Удалить'
    onclick="if (confirm('Вы желаете удалить период?')) return true; else return false;"></td></tr>
  </tbody>
</form>
<tfoot>
    	<tr>
       	  <td colspan="5" class="rounded-foot-left">&nbsp;</td>
        	<td class="rounded-foot-right" nowrap="nowrap" colspan="2"><a href="" onClick="javascript: tb_show('Добавить учебный период', 'quarter.php?<?php echo uniqid('') ?>&school_year_id=<?php echo $school_year_id?>&keepThis=true&TB_iframe=true&height=200&width=400'); return false;" class="add" title="Добавить учебный период"><?php echo $lang['add_new_period_w'];?></a>
</td>
        </tr>
    </tfoot>
</table>
</div>
<?php

}

include 'footer.php';
?>