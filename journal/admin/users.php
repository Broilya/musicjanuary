<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                        |
+-----------------------------------------------------------------------------+
\*****************************************************************************/



define('ADMIN_ZONE', true);

include_once ('../init.php');
include 'header.php';
include_once ('../include/users.php');

if ($_POST['delete_this']=='yes') {
	
	$temp=array_shift($_POST);
	
	foreach ($_POST as $key=> $id) 
	{
		$id=str_replace('adm', $key);
	
//echo $id;	
		if (($_SESSION['admin_id'] == SUPERADMINID) || 
		    (SUPERADMINID != $id) && (SUPERADMINID != $_SESSION['admin_id']) )
			$query = "DELETE FROM `".TABLE_USERS."` WHERE user_id ='".$id."'";
//echo $query;
	
	  	$res=mysql_query($query);
  	
 
	}
	
	
	
}

if ($_POST['delete_this2']=='yes') {
	
	$temp=array_shift($_POST);
	
	foreach ($_POST as $key=> $id) 
	{
		$id=str_replace('user', $key);
	
	//echo $id;	
	$query = "DELETE FROM `".TABLE_USERS_TEACHERS."` WHERE teacher_id ='".$id."'";
	//echo $query;
	
  	$res=mysql_query($query);
  	
 
    }
	
	
	
}
?>
<div align="center">
<span class="head_top"><?php echo $lang['users_list'];?>: Администраторы</span>
    <form name='deladm' method='post' action='' id="fadmin">
  <input type='hidden' name='delete_this' value='yes'>
<table id="rounded-corner">
  <thead>
  <tr>
    <th class="rounded-left"><?php echo $lang['fio'];?></th>
    <th><?php echo $lang['login'];?></th>
    <th width="100">&nbsp;</th>
    <th class="rounded-right" width="20">
<?php
  $user_list = get_teachers_list();
  if (!empty($user_list)) {
    echo '<input name="allMark" type="checkbox" onclick="if (this.checked == true) markAllRows(this.form.id); else unMarkAllRows(this.form.id);" title="Отметить все" value=1>';
  } else echo '&nbsp;';
?>    
</th>  </tr>
  </thead>
  <tbody>
<?php
  $user_list = get_users_list();
  foreach($user_list as $user) {

  echo "<tr class=odd><td>".$user['last_name']." ".$user['first_name']." ".$user['middle_name']."</td><td>".$user['login']."</td>"
      .( (($_SESSION['admin_id'] == SUPERADMINID) || 
		    (SUPERADMINID != $user['user_id']) && (SUPERADMINID != $_SESSION['admin_id']) ) ?
       "<td><a href='user.php?user_id=".$user['user_id']."&".uniqid('')."&keepThis=true&TB_iframe=true&height=280&width=410' class='thickbox' title='Редактировать информацию об пользователе'>".$lang['change']."</a></td>"
      ."<td><input value='1' type='checkbox' name='adm" . $user["user_id"]."' >" : "</td>")
      ."</tr>";
  }
?>
<tr><td colspan="2">&nbsp;</td>
<td colspan="2" align="right">&nbsp;</td>
</tr>

</tbody>
<tfoot>
    	<tr>
       	  <td class="rounded-foot-left" colspan="2">&nbsp;</td>
        	<td class="rounded-foot-right" colspan="2"><a href="" onClick="javascript: tb_show('Добавить', 'user.php?<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=280&width=300'); return false;" class="add" title="Добавить пользователя"><?php echo $lang['add'];?></a>
</td>
        </tr>
    </tfoot>
</table>
</form>




<span class="head_top"><?php echo $lang['users_list'];?>: Учителя</span>
    <form name='delteach' method='post' action='' id="fteacher">
  <input type='hidden' name='delete_this2' value='yes'>
<table id="rounded-corner">
  <thead>
  <tr>
    <th class="rounded-left"><?php echo $lang['fio'];?></th>
    <th><?php echo $lang['login'];?></th>
    <th width="100">&nbsp;</th>
    <th class="rounded-right" width="20">
<?php
  $user_list = get_teachers_list();
  if (!empty($user_list)) {
    echo '<input name="allMark" type="checkbox" onclick="if (this.checked == true) markAllRows(this.form.id); else unMarkAllRows(this.form.id);" title="Отметить все" value=1>';
  } else echo '&nbsp;';
?>    
</th>  </tr>
  </thead>
  <tbody>
<?php

  foreach($user_list as $user) {

  echo "<tr class=odd><td>".$user['last_name']." ".$user['first_name']." ".$user['middle_name']."</td><td>".$user['login']."</td>"
      ."<td><a href='auth_chg.php?st=".$user[teacher_id]."&TB_iframe=true&height=250&width=500' class='thickbox' title='Редактировать информацию об пользователе'>".$lang['change']."</a></td>"
      ."<td><input value='1' type='checkbox' name='user".$user["teacher_id"]."' ></td></tr>";
  }
?>
<tr><td colspan="2">&nbsp;</td>
<td colspan="2" align="right"><input id='delete2' class='butonoff' name="delete" disabled="true" type='submit' value="<?php echo $lang['delete'];?>"
    onClick="if (confirm('Вы желаете удалить пользователя?')) return true; else return false;"></td>
</tr>

</tbody>
<tfoot>
    	<tr>
       	  <td class="rounded-foot-left" colspan="2">&nbsp;</td>
        	<td class="rounded-foot-right" colspan="2"></td>
        </tr>
    </tfoot>
</table>
</form>

<?php /* ?>


    <form name='deldir' method='post' action='' id="fdir">
  <input type='hidden' name='delete_this2' value='yes'>
<span class="head_top"><?php echo $lang['users_list'];?>: Директор</span>
<table id="rounded-corner">
  <thead>
  <tr>
    <th class="rounded-left"><?php echo $lang['login'];?></th>
    <th><?php echo $lang['fio'];?></th>
    <th width="125">&nbsp;</th>
    <th class="rounded-right" width="20">
<?php
  $user_list = get_dir_list();
  if (!empty($user_list)) {
    echo '<input name="allMark" type="checkbox" onclick="if (this.checked == true) markAllRows(this.form.id); else unMarkAllRows(this.form.id);" title="Отметить все" value=1>';
  } else echo '&nbsp;';
?>    
</th>  </tr>
  </thead>
  <tbody>
<?php

  foreach($user_list as $user) {

  echo "<tr class=odd><td>$user[login]</td><td>$user[last_name] $user[first_name] $user[middle_name]</td><td>
</td>
   <td><input value='1' type='checkbox' name='id" . $user["user_id"] . "' ></td></tr>";
  }
?>
<tr><td colspan="2">&nbsp;</td>
<td colspan="2" align="right"><input id='delete3' name="delete" class='butonoff' disabled="true" type='submit' value="<?php echo $lang['delete'];?>"
    onClick="if (confirm('Вы желаете удалить?')) return true; else return false;"></td>
</tr>

</tbody>
<tfoot>
    	<tr>
       	  <td class="rounded-foot-left" colspan="2">&nbsp;</td>
        	<td class="rounded-foot-right" colspan="2"><a href="" onClick="javascript: tb_show('Добавить', 'user.php?<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=280&width=300'); return false;" class="add" title="Добавить пользователя"><?php echo $lang['add'];?></a>
</td>
        </tr>
    </tfoot>
</table>
</form>

<?php */ ?>

</div>

<?php
include 'footer.php';
?>