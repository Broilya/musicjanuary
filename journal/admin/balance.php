<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/


define('ADMIN_ZONE', true);

include_once ('../init.php');
include 'header.php';
include_once ('../include/classes.php');



if ($_REQUEST['delete_this']=='yes') {
	
	$temp=array_shift($_REQUEST);
	
	foreach ($_REQUEST as $key=> $id) 
	{
	list($id_c, $subj)=explode("-",$key);	
	//echo $id;	
	$query = "DELETE FROM `".TABLE_SUBJECTS."` WHERE class_id='".$id_c."' AND subject_id='".$subj."'";
	//echo $query;
	
  	$res=mysql_query($query);
    }
}


$class_id = $_REQUEST['class_id'];

if (!empty($_REQUEST['rerun'])) {
  setStudentActive ();

//      $sql="UPDATE `".TABLE_USERS_STUDENTS."`  s SET s.`active`=(SELECT if(sum(b.`summa`) > 0, 1, 0) FROM `".TABLE_BALANCE."` b WHERE b.`student_id`=s.student_id);";
//      $res=mysql_query($sql);
}

$class   = db_get_first_row("SELECT c.* FROM `".TABLE_CLASSES."` c JOIN `".TABLE_SCHOOL_YEARS."` sy ON (sy.school_year_id=c.school_year) WHERE class_id='".$class_id."';");
$teacher = db_get_first_row("SELECT t.* FROM `".TABLE_USERS_TEACHERS."` t WHERE t.teacher_id='".$class['teacher_id']."'");
?>
<div align="center">

<br /><a href="balances.php"><span class="head_top"><?php echo $lang['menu_10']?></span></a><br /><br />

<?php echo $lang['class'];?> <b><?php echo "$class[class]$class[letter]"; ?></b> <?php echo $lang['select_class_ruk'];?>: <b><?php echo "$teacher[last_name] $teacher[first_name] $teacher[middle_name]";?></b><br />
<?php echo $class['name_year']." "; /*echo $lang['year_study'];*/?><br />

<span class="head_top"><?php echo $lang['students_list']?>:</span>
<table id="rounded-corner">
<thead>
  <tr>
    <th class="rounded-left">№</th>
    <th> (ID) <?php echo $lang['name'];?></th>
    <th><?php echo $lang['balance'];?></th>
    <th class="rounded-right">&nbsp;</th>
  </tr>
  </thead>
        <form name='del2' method='post' action=''>
  <input type='hidden' name='delete_this2' value='yes'>
  <tbody>
<?php
  $students_list = get_student_classes_list($_REQUEST['class_id']);
  $n=1;
  $balances =0;

  foreach($students_list as $student) {
    $balance = db_get_cell("SELECT sum(b.summa)/100 FROM `".TABLE_BALANCE."` b WHERE student_id='".$student['student_id']."';");

    echo "<tr".(($student['active']) ? '': " style='color:red;' title='".$lang['user_blocked']."'").">"
        ."<td>$n</td><td>({$student[student_id]}) <span".(($student['active']) ? '': " style='color:red;' title='".$lang['user_blocked']."'").">{$student[student_name]}</span></td>";
    echo "<td align='right'><span".(($student['active']) ? '': " style='color:red;' title='".$lang['user_blocked']."'").">".round($balance,2)."&nbsp;</span></td>";
    echo "<td><a href=\"edit_balance.php?class_id={$_REQUEST[class_id]}&student_id={$student[student_id]}&".uniqid('')."&keepThis=true&TB_iframe=true&height=400&width=550\" title=\"{$lang['edit']} {$lang['balance']}\" class=\"thickbox\">{$lang['edit']}</a></td>";
  // Добавнено кнопку удалить
    echo "</tr>";
    $balances +=$balance;
    $n++;
  }
?>

  </tbody>
</form>
      <tfoot>

    	<tr>
       	  <td colspan="2" class="rounded-foot-left">&nbsp;</td>
                <td align="right"><?php echo round($balances,2);?>&nbsp;</td>
              	<td class="rounded-foot-right">
        	  <a href="balance.php?class_id=<?php echo $_REQUEST['class_id'];?>&rerun=1" class="add" name="rerun" title="<?php echo $lang['rerun'];?>"><?php echo $lang['rerun'];?></a>
          </td>
          <!--td class="rounded-foot-right">&nbsp;</td-->
        </tr>
    </tfoot>
</table>
<br />
<table align="center" cellspacing="0" cellpadding="0" border="0">
      <tbody>
    	<tr>
       	  <td>
            <form name="download" action="./download_balances_templ.php" method="POST">
            <input name="class_id" value="<?php echo $_REQUEST['class_id'];?>" type="hidden">

            <input value="Получить шаблон для ввода баланса" type="submit">&nbsp;&nbsp;&nbsp;
            </form>
          </td>

       	  <td>
            <form name="download" action="./download_balances.php" method="POST">
            <input name="class_id" value="<?php echo $_REQUEST['class_id'];?>" type="hidden">

            &nbsp;&nbsp;<input value="Получить отчет о балансе" type="submit">
            </form>
          </td>
        </tr>
    </tbody>
</table>


</div>
<?php
include 'footer.php';
?>