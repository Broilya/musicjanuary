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

include_once ('../include/classes.php');
include_once ('../include/curriculums.php');


$dump=0;if ($dump) {echo '<br><pre>$_request=|';print_r($_REQUEST);echo '</pre>|<br>';}

  $class_id = $_REQUEST['class_id'];
  $update   = $_REQUEST['update'];

  $ERROR = array();

  if ($_REQUEST['delete_this']=='yes') {
    $temp=array_shift($_REQUEST);
    
    foreach ($_REQUEST['classes_id'] as $class_id=> $val) {
    
    //echo $id;  
  /*
    $query = "DELETE FROM `".TABLE_BALANCE."` WHERE student_id ='".$id."'";
      $res=mysql_query($query);

    $query = "DELETE FROM `".TABLE_USERS_STUDENTS."` WHERE student_id
      IN (SELECT student_id FROM `".TABLE_STUDENTS_IN_CLASS."` WHERE `class_id`='".$id."')";
      $res=mysql_query($query);

    $query = "DELETE FROM `".TABLE_STUDENTS_IN_CLASS."` WHERE class_id ='".$id."'";
      $res=mysql_query($query);
  */
      $sql = "SELECT student_id FROM `".TABLE_STUDENTS_IN_CLASS."`"
            ." WHERE class_id ='".$class_id."'"
            ." LIMIT 0,1";
      $student_id = db_get_cell($sql);
      if (empty($student_id)){
        $query = "DELETE FROM `".TABLE_CLASSES."` WHERE class_id ='".$class_id."'";
        $res=mysql_query($query);
      }else {
        $mode= 'not_delete';
      }
    }

    if ($mode == 'not_delete'){
      $ERROR[]='Нельзя удалять классы с учениками.';
      $ERROR[]='Предварительно переведите учеников в другой класс или удалите.';
    }
    unset($class_id);
  }



  if ($_REQUEST['delete_this1']=='yes') {
    
    $temp=array_shift($_REQUEST);
    
    foreach ($_REQUEST as $key=> $id) {
      list($id_c, $subj)=explode("-",$key);  
    //echo $id;  
      $query = "DELETE FROM `".TABLE_SUBJECTS."` WHERE class_id='".$id_c."' AND subject_id='".$subj."'";
    //echo $query;
    
      $res=mysql_query($query);
    }
  }

?>



<br />
<div align="center"> <span style="color:red;">
<?php echo join('<br>', $ERROR).'<br><br>';?></span>

<table cellspacing="0" cellpadding="0">
<tr class="noodd"><td valign="top">


<form action="classes.php" method="get">
<?php
$school_years = get_school_years();

?>
<span class="head_top"><?php echo $lang['class_list'];?>
<select name="school_year" onChange="javascript: this.form.submit();">

<?php 

//if (!isset($_REQUEST['school_year'])) 
  echo "<option value=''>{$lang['select']}</option>";

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


 <form name='delclass' method='post' action='' id='classes'>

<table id="rounded-corner" style="width:100%">
<thead>
  <tr>
    <th width="100" style="text-align:center;" class="rounded-left"><?php echo $lang['class'];?> &nbsp;&nbsp;(<?php echo $lang['class_count'];?>)</th>
    <th width="200"><?php echo $lang['rucovod'];?></th>
    <th width="120" style="text-align:center;"><?php echo $lang['disciplines'];?></th>
    <th width="100" style="text-align:center;"><?php echo $lang['students_list'];?></th>
    <th width="25" class="rounded-right">
<?php
  $classes_list = get_classes_list($_REQUEST['school_year']);
  if (!empty($classes_list)) {
    echo '<input name="allMark" type="checkbox" onclick="if (this.checked == true) markAllRows(this.form.id); else unMarkAllRows(this.form.id);" title="Отметить все" value=1>';
  } else echo '&nbsp;';
?>    
    </th>
  </tr>
</head>
  <input type='hidden' name='delete_this' value='yes'>
<tbody>
<?php

  
  foreach($classes_list as $class) {
    $sql = "SELECT count(1) FROM `".TABLE_STUDENTS_IN_CLASS."`"
          ." WHERE `class_id`='".$class['class_id']."';";
//echo "Sss)".$sql."\n<br>";
    $class['class_count'] = db_get_cell($sql);
    $class_cur = ($class['class_id'] == $class_id) ? ' style="background:#DDE4C8"' : '';
    echo '<tr class="odd"><td'.$class_cur.'>'.$class['class'].''.$class['letter']."&nbsp;(".$class['class_count'].")</td>";

    $class['teacher_name'] = ($class['teacher_name'] == ' . .') ? '&nbsp;' : $class['teacher_name'];

    echo '<td'.$class_cur.'><a href="classruk.php?class_id='.$class['class_id'].'&teacher='.$class['teacher_id'].'&TB_iframe=true&height=150&width=450" title="'.$lang['edit'].'" class="thickbox">'.$class['teacher_name'].'</a></td>';
    echo '<td'.$class_cur.'><a href="classes.php?class_id='.$class['class_id'].'">'.$lang['edit'].'</a></td>';
  // Доблено кнопку удалить 
    echo '<td'.$class_cur.'><a href="class.php?class_id='.$class['class_id'].'">'.$lang['edit'].'</a></td>
   <td><input value="1" type="checkbox" name="classes_id['. $class['class_id'] .']" ></td></tr>
   ';
  }

if (1){
  $class_not = db_get_cell("SELECT count(1) as class_count"
                 ." FROM `".TABLE_USERS_STUDENTS."` s"
                 ." LEFT JOIN `".TABLE_STUDENTS_IN_CLASS."` sc ON ( sc.student_id = s.student_id ) "
                 ." WHERE NOT ifnull( sc.class_id, 0 ) ");
  if (!empty($class_not)){
    $class = array();
    $class['class_id'] = 0;

      $class['class_count'] = $class_not;
      $class_cur = ($class['class_id'] == $class_id) ? ' style="background:#DDE4C8"' : '';
      echo '<tr class="odd"><td'.$class_cur.'>'.$class['class'].''.$class['letter']."&nbsp;(".$class['class_count'].")</td>";

      $class['teacher_name'] = 'Список учеников не прикрепленных ни к какому классу';

      echo '<td'.$class_cur.' colspan="2">'.$class['teacher_name'].'</td>';
    // Доблено кнопку удалить 
      echo '<td'.$class_cur.'><a href="class.php?class_id='.$class['class_id'].'">'.$lang['edit'].'</a></td>
     <td><input value="1" type="checkbox" name="classes_id['. $class['class_id'] .']" ></td></tr>
     ';
  }
}

    $class_name = db_get_cell("SELECT class FROM `".TABLE_CLASSES."`"
              ." WHERE class_id='".$class_id."' LIMIT 0,1;");
?>

<tr><td colspan='3'>&nbsp;</td>
  <td colspan='2' align="right"><input id='delete' name='delete' class='butonoff' disabled="true" type='submit' value='<?php echo $lang['delete'];?>'
    onclick="if (confirm('Вы желаете удалить класс(ы)?')) return true; else return false;"
    ></td></tr>
</tbody>

<tfoot>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><?php 
      if (SUBDOMEN != 'egppk') {
?><a href="" onClick="javascript: tb_show('Добавить', 'read_csv.php?<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=230&width=350'); return false;" class="add" title="Добавить"><?php echo 'Добавить из файла';?></a>
<?php } ?>

      <td colspan="2"><a href="" onClick="javascript: tb_show('Добавить класс', 'add_class.php?<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=200&width=400&modal=true'); return false;" class="add" title="Добавить класс"><?php echo $lang['class_add_new'];?></a></td>
    </tr>
    <tr>
      <td colspan="3" class="rounded-foot-left" style="text-align:left;">&nbsp;<a  class="dnl" href="../phpexcel/students_templ.xls">Скачать шаблон для заполнения учеников</a></td>
      <td colspan="2" class="rounded-foot-right"><a href="" onClick="javascript: tb_show('<?php echo $lang['students_upload'];?>', 'add_student.php?<?php echo uniqid('') ?>&keepThis=true&TB_iframe=true&height=200&width=400&mo_dal=true'); return false;" class="add" title="<?php echo $lang['students_upload'];?>"><?php echo $lang['students_upload'];?></a></td>
    </tr>
    </tfoot>
</table>
</form>
</td>


<!--/**   ************************* */-->


<td valign="top" <?php echo ((empty($class_id)) ? 'style="display:none;"' : 'style="padding-left:10px;"');?> >
<span class="head_top"><?php echo $lang['disp_list_class'];?> <?php echo $class_name;?></span>
       <form name='deldisc' method='post' action='' id='discipline'>
  <input type='hidden' name='delete_this1' value='yes'>
  <input type='hidden' name='class_id' value='". $class_id . "'>
<table id="rounded-corner" style="width:100%" cellspacing="0" cellpadding="0">
<thead>
  <tr>
    <th width="30%" class="rounded-left"><?php echo $lang['disclipline'];?></th>
    <th><?php echo $lang['teacher'];?></th>
    <th width="125">&nbsp;</th>
    <th width="25" class="rounded-right">
<?php
  $sql = "SELECT s.subject_id, CONCAT( t.last_name,  ' ',t.first_name,  ' ',t.middle_name ) AS name, d.discipline"
        ." FROM `".TABLE_SUBJECTS."` s"
        ." LEFT JOIN `".TABLE_CLASSES."` c ON (s.class_id = c.class_id)"
        ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` d ON (s.discipline_id = d.discipline_id)"
        ." LEFT JOIN `".TABLE_USERS_TEACHERS."` t ON (t.teacher_id = s.teacher_id)"
        ." WHERE c.class_id='".$class_id."' ORDER BY d.discipline";
  $res = db_query($sql);
  if (!empty($res)) {
    echo '<input name="allMark" type="checkbox" onclick="if (this.checked == true) markAllRows(this.form.id); else unMarkAllRows(this.form.id);" title="Отметить все" value=1>';
  } else echo '&nbsp;';
?>    
    </th>
  </tr>
  </thead>
<?php

  while($row = mysql_fetch_assoc($res)) {
    echo "<tr class='odd'><td>".$row['discipline']."</td><td>".$row['name']."</td><td>";
    echo '<a href="subject.php?class_id='.$class_id.'&subject_id='.$row['subject_id'].'&TB_iframe=true&height=150&width=450" title="Изменить" class="thickbox">Изменить</a>';
    // Добавнено кнопку удалить
    echo "</td><td><input value='1' type='checkbox' name='".$class_id."-". $row['subject_id']."'</td></tr>";
   // echo "<a href=\"del_subject.php?class_id=".$class_id."&subject_id=".$row['subject_id']."\" title=\"дисциплину\" onclick=\"return confirm('Вы, уверены что хотите удалить эту запись!')\">Удалить</a></td></td></tr>";
  }
?>
<tr><td colspan='2'>&nbsp;</td><td colspan="2" align="right">
<input id='delete2' name='delete' class='butonoff' disabled="true"  type='submit' value='<?php echo $lang['delete'];?>'
    onclick="if (confirm('Вы желаете удалить предмет?')) return true; else return false;">
      <tfoot>
      <tr>
          <td colspan="2" class="rounded-foot-left">&nbsp;</td>
          <td colspan="2" class="rounded-foot-right">
            <a href="" onClick="javascript: tb_show('Добавить', 'subject.php?class_id=<?php echo $class_id?>&TB_iframe=true&height=160&width=450'); return false;" class="add" title="Добавить"><?php echo $lang['add'];?></a>
          </td>
        </tr>
    </tfoot>
</table>
</form>
</td>
</tr></table>
</div>
<?php
  include 'footer.php';
?>