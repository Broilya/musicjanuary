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
include_once ('../include/teachers.php');


if ($_POST['delete_this']=='yes') {
	
	$temp=array_shift($_POST);
	
	foreach ($_POST as $key=> $id) 
	{
	$id=substr($key, 2);
	
	//echo $id;	
	$query = "DELETE FROM `".TABLE_USERS_TEACHERS."` WHERE teacher_id ='".$id."'";
	//echo $query;
	
  	$res=mysql_query($query);
    }
}


?>
<div align="center">
<span class="head_top"><?php echo $lang['teachers_list']?></span>
  <form name='del' method='post' action='' id="teacher">
<table id="rounded-corner">
  <thead>
  <tr>
    <th class="rounded-left"><?php echo $lang['fio']?> <?php echo $lang['teachers'];?></th>
    <th width="5">&nbsp;</th>
    <th width="180"><?php echo $lang['disciplines'];?></th>
    <th width="125">&nbsp;</th>
    <th class="rounded-right" width="25">
<?php
  $teacher_list = get_teachers_list();
  if (!empty($teacher_list)) {
    echo '<input name="allMark" type="checkbox" onclick="if (this.checked == true) markAllRows(this.form.id); else unMarkAllRows(this.form.id);" title="Отметить все" value=1>';
  } else echo '&nbsp;';
?>    
    </th>
  </tr>
  </thead>
  <tbody>
  <input type='hidden' name='delete_this' value='yes'>
<?php
  $_teacher = array();
  $_teacherdisc = '';
  if (!empty($teacher_list))
  foreach($teacher_list as $teacher) {
// Доблено кнопку удалить 
    if ($_teacherdisc != $teacher['teacher_id']) {  //." ".$teacher['discipline_id']
      if (!empty($_teacherdisc)) {

        echo "<tr class=odd><td>".$_teacher['last_name']." ".$_teacher['first_name']." ".$_teacher['middle_name']."</td>"
            .'<td><a href="teacher_disc.php?teacher='.$_teacher['teacher_id'].'&TB_iframe=true&height=250&width=450" title="'.$lang['disp_edit'].'" class="thickbox">&nbsp;</a></td>'
            ."<td>".$_discipline."&nbsp;</td>
             <td><a href=\"teacher.php?teacher_id=".$_teacher['teacher_id']."&".uniqid('')."&keepThis=true&TB_iframe=true&height=450&width=380\" class=\"thickbox\" title=\"Редактировать информацию об учителе\">".$lang['edit']."</a></td>
             <td><input value='1' type='checkbox' name='id" . $_teacher["teacher_id"] . "' ></td></tr>";
      }

      $_discipline = '';
      $_teacher = $teacher;
      $_teacherdisc = $_teacher['teacher_id'];  //  ." ".$_teacher['discipline_id'];
    }

    if (!empty($teacher['discipline']))
      $_discipline .= (strpos($_discipline, $teacher['discipline']) === false) ? $teacher['discipline']."<br>" : '';
  }

  if (!empty($_teacherdisc)) {
    echo "<tr class=odd><td>".$_teacher['last_name']." ".$_teacher['first_name']." ".$_teacher['middle_name']."</td>"
        .'<td><a href="teacher_disc.php?teacher='.$_teacher['teacher_id'].'&TB_iframe=true&height=150&width=450" title="'.$lang['disp_edit'].'" class="thickbox">&nbsp;</a></td>'
        ."<td>&nbsp;".$_discipline."</td>
        <td><a href=\"teacher.php?teacher_id=".$_teacher['teacher_id']."&".uniqid('')."&keepThis=true&TB_iframe=true&height=450&width=380\" class=\"thickbox\" title=\"Редактировать информацию об учителе\">".$lang['edit']."</a></td>
        <td><input value='1' type='checkbox' name='id" . $_teacher["teacher_id"] . "' ></td></tr>";
  }
?>

<tr><td colspan='3'>&nbsp;</td>
    <td colspan='2' align="right"><input id='delete' name="delete" class='butonoff' disabled="true" type='submit' type='submit' value='<?php echo $lang['delete'];?>'
    onclick="if (confirm('Вы желаете удалить преподавателей?')) return true; else return false;"></td>
</tbody>
<tfoot>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><?php 
      if (SUBDOMEN != 'egppk_') {
?><a href="" onClick="javascript: tb_show('Добавить', 'read_csv.php?<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=230&width=350'); return false;" class="add" title="Добавить"><?php echo 'Добавить из файла';?></a>
<?php } ?>
      <td colspan="2"><a href="" onClick="javascript: tb_show('Добавить', 'teacher.php?<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=330&width=350'); return false;" class="add" title="Добавить"><?php echo $lang['add'];?></a>
      </td>
    </tr>
    <tr>
      <td colspan="3" class="rounded-foot-left" style="text-align:left;">&nbsp;<a  class="dnl" href="../phpexcel/teachers_templ.xls">Скачать шаблон для заполнения учителей</a></td>
      <td colspan="2" class="rounded-foot-right"><a href="" onClick="javascript: tb_show('<?php echo $lang['teachers_upload'];?>', 'add_teacher.php?<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=200&width=400&mo_dal=true'); return false;" class="add" title="<?php echo $lang['teachers_upload'];?>"><?php echo $lang['teachers_upload'];?></a>
     </td>
    </tr>
    </tfoot>
</table>
  </form>
</div>
<?php
include 'footer.php';
?>