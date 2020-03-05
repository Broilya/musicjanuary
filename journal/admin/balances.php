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
include_once ('../include/classes.php');
include_once ('../include/curriculums.php');

?>

<br />
<div align="center">
<form action="balances.php" method="get">
<?php
$school_years = get_school_years();

?>
<span class="head_top"><?php echo $lang['menu_10']?></span><br /><br />

<span class="head_top"><?php echo $lang['balance_list'];?>
<select name="school_year" onChange="javascript: this.form.submit();">

<?php 

  if (!isset($_GET['school_year'])) echo "<option value=''>{$lang['select']}</option>";
  foreach ($school_years as $years) {

    if ($years['school_year_id']==$_REQUEST['school_year']){
      $selected="selected"; 
      $school_year_id = $years['school_year_id'];
      $_SESSION['schoolyear'] = $years['school_year_id'];
    } elseif (empty($_REQUEST['school_year'])) {
      if (empty($years['current'])) 
        $selected="";
      else {
        $selected="selected"; 
        $school_year_id = $years['school_year_id'];
        $_SESSION['schoolyear'] = $years['school_year_id'];
      }
    }
    else 
      $selected="";
?>

    <option value="<?php echo  $years['school_year_id'];?>" <?php echo $selected;?>><?php echo $years['name_year'];?></option>

<?php 
  }
?>
</select>
 <?php echo $lang['study_year'];?>:</span>
</form>
<table id="rounded-corner">
<thead>
  <tr>
    <th width="80" class="rounded-left"><?php echo $lang['class'];?> &nbsp;&nbsp;(<?php echo $lang['class_count'];?>)</th>
    <th><?php echo $lang['rucovod'];?></th>
    <th width="100"><?php echo $lang['year'];?></th>
    <th width="125" class="rounded-right">&nbsp;</th>
  </tr>
</thead>
<tbody>

<?php

  $classes_list = get_classes_list($_GET['school_year']);
  
  foreach($classes_list as $class) {
    $sql = "SELECT count(1) FROM `".TABLE_STUDENTS_IN_CLASS."`"
          ." WHERE `class_id`='".$class['class_id']."';";
//echo "Sss)".$sql."\n<br>";
    $class['class_count'] = db_get_cell($sql);
    
    $sql = "SELECT count(1) FROM `".TABLE_USERS_STUDENTS."` s"
           ." LEFT JOIN `".TABLE_STUDENTS_IN_CLASS."` sl ON (sl.student_id = s.student_id)"
          ." WHERE (sl.`class_id`='".$class['class_id']."') AND (s.`active` = 0);";
//echo "Sss)".$sql."\n<br>";
    $class['class_nopay'] = db_get_cell($sql);
    
    echo "<tr><td>".$class['class'].''.$class['letter']."&nbsp;(".$class['class_count']."/<span title='Заблокированы' style='color:red;'>".$class['class_nopay']."</span>)</td>";

    $class['teacher_name'] = ($class['teacher_name'] == ' . .') ? '&nbsp;' : $class['teacher_name'];
    echo '<td>'.$class['teacher_name'].'</td>';
    echo '<td>'.$class['name_year'].'</td>';
// Доблено кнопку удалить 
    echo "<td><a href=\"balance.php?class_id=".$class['class_id']."\">".$lang['edit']."</a></td>
 ";

  }
?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="2" class="rounded-foot-left">&nbsp;</td>
      <td colspan="2" class="rounded-foot-right"><a href="" onClick="javascript: tb_show('<?php echo $lang['balance_upload'];?>', 'add_balance.php?<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=200&width=400&mo_dal=true'); return false;" class="add" title="<?php echo $lang['balance_upload'];?>"><?php echo $lang['balance_upload'];?></a>
     </td>
    </tr>
   </tfoot>
</table>
</div>
<?php
include 'footer.php';
?>
