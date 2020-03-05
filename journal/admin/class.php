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

$dump=0;if ($dump) {echo '<br><pre>$_request=|';print_r($_REQUEST);echo '</pre>|<br>';}
if ($dump) {echo '<br><pre>$_GET=|';print_r($_GET);echo '</pre>|<br>';}
if ($dump) {echo '<br><pre>$_POST=|';print_r($_POST);echo '</pre>|<br>';}

  $_SESSION['class_id'] = (isset($_REQUEST['class_id'])) ? $_REQUEST['class_id'] : $_SESSION['class_id'];
  $class_id  = (empty($_REQUEST['class_id'])) ? $_SESSION['class_id'] : $_REQUEST['class_id'];

/*
  if ($_REQUEST['class_id'] == 0) {
    $_SESSION['class_id'] = 0;
    $class_id  = 0;
  }
*/

if ($dump) {echo $class_id.'<br><pre>$_SESSION=|';print_r($_SESSION);echo '</pre>|<br>';}

$dump=0;  

  $newstudent = $_REQUEST['newstudent'];

  $upd_group = $_REQUEST['upd_group'];
  $add_group = $_REQUEST['add_group'];

  $update    = $_REQUEST['update'];
  $upd_class = $_REQUEST['upd_class'];

  if (!empty($_REQUEST['delete_this2'])) {
  
//    $temp=array_shift($_REQUEST);
  
    foreach ($_REQUEST as $id_c=>$val) {
if ($dump) echo $id_c."\n";  
      if (is_numeric($id_c) && $id_c > 0) {

//      list($id_c, $subj)=explode("-",$key);  
  //$query = "DELETE FROM `".TABLE_SUBJECTS."` WHERE class_id='".$id_c."' AND subject_id='".$subj."'";
  

//        $query = "DELETE FROM `".TABLE_STUDENTS_IN_CLASS."` WHERE class_id='".$class_id."' AND student_id='".$id_c."'";
        $query = "UPDATE `".TABLE_STUDENTS_IN_CLASS."` SET class_id=0 WHERE class_id='".$class_id."' AND student_id='".$id_c."'";
if ($dump) echo $query."\n";
  
        $res=mysql_query($query);
      }
    }
  }

  $groups_list = array();

if ($dump) {echo '<br><pre>$_request=|';print_r($_REQUEST);echo '</pre>|<br>';}

  if (!empty($update)) {
    if (!empty($_POST['upd_group'])) {
      $update    = $_REQUEST['update'] = '';
//      $add_group = 
      $_REQUEST['add_group'] = '';
      foreach($_REQUEST['group_check'] as $group_id=>$checked) {
        $data = array();
        $data['group_id'] = $group_id;
        $data['class_id'] = $class_id ;
        $group_cur = db_get_cell("SELECT `clsgrp_id` FROM `".TABLE_CLASSES_IN_GROUPS."` WHERE `group_id`='".$group_id."' AND `class_id`='".$class_id."' LIMIT 0,1");
        if (empty($group_cur)) {
          $group_id  = db_array2insert(TABLE_CLASSES_IN_GROUPS, $data);
        } else {
          db_array2update(TABLE_CLASSES_IN_GROUPS, $data, " `clsgrp_id`='".$group_cur."'");
        }
      }
      foreach($_REQUEST['group_name'] as $group_id=>$checked) {
        if (empty($_REQUEST['group_name'][$group_id])) continue;

        $group_cur = db_get_cell("SELECT `group_id` FROM `".TABLE_SPR_GROUPS."` WHERE `group`='".$_REQUEST['group_name'][$group_id]."' LIMIT 0,1");
        $data = array();
        $data['group'] = $_REQUEST['group_name'][$group_id];
        $data['short'] = (empty($_REQUEST['group_short'][$group_id])) ? substr($_REQUEST['group_name'][$group_id], 0, 5) :
                          $_REQUEST['group_short'][$group_id];
        if (empty($group_cur)) {
          if (($group_id == 'new1') || ($group_id == 'new2')) {
            $group_id = db_array2insert(TABLE_SPR_GROUPS, $data);
          } else {
            db_array2update(TABLE_SPR_GROUPS, $data, " `group_id`='".$group_id."'");
//            $group_cur = db_get_cell("SELECT `group_id` FROM `".TABLE_SPR_GROUPS."` WHERE `group_id`='".$group_id."' LIMIT 0,1");
          }
        } else {
          if (($group_id == 'new1') || ($group_id == 'new2')) {
            db_array2update(TABLE_SPR_GROUPS, $data, " `group_id`='".$group_cur."'");
          } else {
            if ($group_id == $group_cur) 
              db_array2update(TABLE_SPR_GROUPS, $data, " `group_id`='".$group_id."'");
//            $group_cur = db_get_cell("SELECT `group_id` FROM `".TABLE_SPR_GROUPS."` WHERE `group_id`='".$group_id."' LIMIT 0,1");
          }
        }

        if (!empty($checked))
          $groups_list[] = $group_id;
      }
//      $update = '';
    }  //  if (!empty($_REQUEST['upd_group']))

    elseif (!empty($_POST['upd_class'])) {
      $add_group = $_REQUEST['add_group'] = '';
      foreach($_REQUEST['check_list'] as $student_id=>$group) {
        $res = db_query("DELETE FROM `".TABLE_STUDENTS_IN_GROUPS."` WHERE student_id='".$student_id."'");
        foreach($group as $group_id=>$check) {

          if (!empty($check)) {
            $data = array();
            $data['student_id']  = $student_id;
            $data['group_id']    = $group_id;
            db_array2insert(TABLE_STUDENTS_IN_GROUPS, $data);
          }
        }
      }
      $update = '';
    }  //  if (!empty($_REQUEST['upd_class']))

    
    
    elseif (!empty($_REQUEST['newstudent'])) {
      $classto_id = (int)$_REQUEST['classto_id'];
      $student_id = (int)$_REQUEST['student_id'];
      if (!empty($classto_id)) {
        $data = array();
        $data['class_id']    = $classto_id;
        $data['student_id']  = $student_id;
        $where = " (`student_id`='".$student_id."') AND (`class_id`='".$class_id."')";

if ($dump) {echo $where.'<br><pre>$_request=|';print_r($data);echo '</pre>|<br>';}

        $class_0 = db_get_cell("SELECT `class_id` FROM `".TABLE_STUDENTS_IN_CLASS."` WHERE ".$where." LIMIT 0,1");
        if ($class_0 == 0)
          db_array2update(TABLE_STUDENTS_IN_CLASS, $data, $where);
        else 
          db_array2insert(TABLE_STUDENTS_IN_CLASS, $data);
      }
      $update = '';
    }  //  if (!empty($_REQUEST['newstudent']))
  }  //  if (!empty($update))
  elseif (!empty($_GET['del_group'])) {
    $res = db_query("DELETE FROM `".TABLE_STUDENTS_IN_GROUPS."` WHERE group_id='".$_REQUEST['del_group']."'");
    $group_cur = db_get_cell("SELECT `group_id` FROM `".TABLE_STUDENTS_IN_GROUPS."` WHERE `group_id`='".$_REQUEST['del_group']."' LIMIT 0,1");

    if (empty($group_cur)) {
      $res = db_query("DELETE FROM `".TABLE_SPR_GROUPS."` WHERE group_id='".$_REQUEST['del_group']."'");
    }
  } 
  
  $class   = db_get_first_row("SELECT * FROM `".TABLE_CLASSES."` c JOIN `".TABLE_SCHOOL_YEARS."` sy ON (sy.school_year_id=c.school_year)  WHERE c.class_id='".$class_id."'");
  $teacher = db_get_first_row("SELECT * FROM `".TABLE_USERS_TEACHERS."` WHERE teacher_id='".$class['teacher_id']."'");

  if (!empty($class_id))
    if (!empty($add_group) || !empty($update)) 
      $groups_list = get_group_classes_list();
    else
      $groups_list = get_group_classes_list($class_id);

if ($dump) {echo "class_id=$class_id !empty($add_group) || !empty($update)";print_r($groups_list);}

  $groupgraf = '';

//  $class['name_year'] = (empty($class['name_year'])) ? $_SESSION['schoolyear'] : $class['name_year'];

  echo '<div align="center"><div align="left" style="width:600px;">';
  echo $lang['class'].": <b>".$class['class'].$class['letter']."</b><br>";
  echo $lang['select_class_ruk'].": <b>".$teacher['last_name']." ".$teacher['first_name']." ".$teacher['middle_name']."</b><br />";
  echo $class['name_year']." ".$lang['year_study']."<br></div>";

  echo '<div align="center"><div align="left" style="width:200px;">';
  echo '<form method="post" action="" name="group">
        <input type="hidden" name="update" value="0">
        <input type="hidden" name="upd_group" value="0">
        <input type="hidden" name="add_group" value="1">';

?>

<table id="rounded-corner" cellspacing="0" cellpadding="0" align="center" style="width:100%">

<thead>

<?php

  $groupcount = 0;
  if (empty($groups_list)){
    echo '<tr><th colspan="5" style="text-align:center"><b>Подгрупп '.((empty($add_group)) ? ' в классе' : ' в школе').' нет</b></th></tr>';
    $groupgraf = '<th>&nbsp;</th>';
    $groupcount = 1;
    echo "</thead>
          <tbody>";
  } else {
    echo '<tr><th colspan="5" style="text-align:center"><b>Подгруппы '.((empty($add_group)) ? 'класса' : 'школы').':</b></th></tr>';
    $j=0;
    echo '<tr>
      <th width="20">№</th>
      <th>Название</th>
      <th width="10">&nbsp;</th>
      <th width="10">&nbsp;</th>
      <th width="10">&nbsp;</th>
      </tr>';

    echo "</thead>
          <tbody>";

    for ($i = 0, $count=count($groups_list); $i < $count; $i++, $j=$i) {
//print_r($groups_list[$i]);

      $checked = ($groups_list[$i]['class_id'] == $class_id) ? 'checked="checked"' : ''; 
      if (empty($add_group)) {
        if ( !empty($checked)) 
          echo '<tr><td>'.($i+1).'.</td><td colspan="4">'.$groups_list[$i]['group'].'</td></tr>';
      } else {
        $group_id = $groups_list[$i]['group_id'];
        echo  '<tr><td>'
//             .'<input id="group'.$group_id.'" type="checkbox" name="check_list['.$group_id.']" value="1" '.$checked.'>&nbsp;';
             .($i+1).'</td>';
//             echo '<td>'.$groups_list[$i]['group'].'</td>';

        echo '<td>
               <span id="zgroup_'.$group_id.'" 
                   s_tyle="cursor:pointer;">'
                  .$groups_list[$i]['group'].'</span>' 
              .'<input name="group_name['.$group_id.']" 
                     id="group_'.$group_id.'" style="display:none;" ' 
                    .' disabled="disabled" value="'.$groups_list[$i]['group'].'">'
              .'<input name="group_short['.$group_id.']" 
                     id="sgroup_'.$group_id.'" style="display:none;" ' 
                    .' disabled="disabled" value="'.$groups_list[$i]['short'].'" maxlength="8" size="8">'
            .'</td>';

        echo '<td><a href="" title="Изменить" '
                   .' id="egroup_'.$group_id.'" '
                   .' onClick="
                        if (document.getElementById('."'".'group_'.$group_id."'".').disabled) {
                          document.getElementById('."'".'egroup_'.$group_id."'".').title=\'Сохранить\';
                          document.getElementById('."'".'zgroup_'.$group_id."'".').style.display=\'none\';
                          document.getElementById('."'".'group_'.$group_id."'".').disabled=false;
                          document.getElementById('."'".'sgroup_'.$group_id."'".').disabled=false;
                          document.getElementById('."'".'group_'.$group_id."'".').style.display=\'inline\';
                          document.getElementById('."'".'sgroup_'.$group_id."'".').style.display=\'inline\';
                        } else {
                          document.group.upd_group.value=1; 
                          document.group.update.value=1;
                          document.group.submit();
                        }
                        return false;">&nbsp;</a></td>';


         echo '<td><a style="font-size:16px;color:red;" title="Удалить" class="del"
           href="class.php?del_group='.$groups_list[$i]['group_id'].'&add_group=1"
           onClick="if (confirm('."'Вы желаете удалить подгруппу `".$groups_list[$i]['group']."`?'"
                     .')) return true; else return false;"></a>&nbsp;</td>';
         echo '<td><input title="Отметить группу" type="checkbox" name="group_check['.$group_id.']" value="1"></td>';
         echo '</tr>';
      }  //  if (empty($add_group))
//<img src="images/del.gif" border="0">
      if (empty($update)) {
        if (!empty($checked)) {
          $groupgraf .= "<th title='".$groups_list[$i]['group']."'>".str_replace(' ', '&nbsp;', $groups_list[$i]['short'])."</th>";
          $groupcount ++;
        }
      } else {
        if (!empty($checked)) {
          $groupgraf .= "<th title='".$groups_list[$i]['group']."'>".str_replace(' ', '&nbsp;', $groups_list[$i]['short'])."</th>";
          $groupcount ++;
        }
      }
    }  //  for ($i = 0
  }  //  if (empty($groups_list))

//echo "|$groupgraf|$update|";

  if (!empty($add_group)) {
    echo  '<tr><td>'.($j+1).".</td>"
//        '<input type="checkbox" name="check_list[new1]" value="1">&nbsp;'
        .'<td colspan="4"><input type="text" name="group_name[new1]" value=""> &nbsp;&nbsp;Краткое:&nbsp;'
        .'<input type="text" name="group_short[new1]" value="" size="8" maxlength="8"></td></tr>'
//        .'<input type="checkbox" name="check_list[new2]" value="1">&nbsp;'
        .'<tr><td>'.($j+2).".</td>"
        .'<td colspan="4"><input type="text" name="group_name[new2]" value=""> &nbsp;&nbsp;Краткое:&nbsp;'
        .'<input type="text" name="group_short[new2]" value="" size="8" maxlength="8"></td></tr></tbody>';


    echo '<tfoot><tr><td colspan="5" align="center"><a href="#" style="display:inline;" class="add" title="'.$lang['add'].'"'
        .' onClick="document.group.upd_group.value=1; document.group.update.value=1; document.group.submit();">'.$lang['add'].'</a>'
        .'&nbsp;&nbsp;&nbsp;<input type="submit" value="Отказаться" title="Отказаться" 
           onClick="location='."'http://'".'+location.host+location.pathname; return false;"></td></tr></tfoot>';
  } else {
      echo '<tr><td>&nbsp;</td><td colspan="4"><a href="#" onClick="document.group.submit();" title="'.$lang['change'].'">'.$lang['change'].'</a></td></tr></tbody>';
  }
// onclick="document.class.upd_class.value=1;
?>
      
      </table>
      </form>
     </div></div>
<br />
<?php

  if (empty($groupgraf)){
    $groupgraf = '<th>&nbsp;</th>';
    $groupcount = 1;
  }

?>  
  
  <div align="center">
<form method="post" action="" name="class" id='class'>
  <input type="hidden" name="update" value="1">
  <input type="hidden" name="upd_class" value="0">

<span class="head_top"><?php echo $lang['students_list']?>:</span>
<table id="rounded-corner" cellspacing="0" cellpadding="0" align="center">
<thead>
  <tr>
    <th width="20" class="rounded-left">№</th>
    <th><?php echo $lang['name'];?></th>
    <?php echo $groupgraf;?>
    <th width="100">&nbsp;</th>
    <th width="20">&nbsp;</th>
    <th width="20" class="rounded-right">
<?php
  $students_list = get_student_classes_list($class_id, 1);
  if (!empty($students_list)) {
    echo '<input name="allMark" type="checkbox" onclick="if (this.checked == true) markAllRows(this.form.id); else unMarkAllRows(this.form.id);" title="Отметить все" value=1>';
  } else echo '&nbsp;';
?>    
    </th>
  </tr>
  </thead>

<tbody>


<?php

$dump =0;if ($dump) print_r($students_list);
  $n=1;
  $student_id = '';

//  $students = array();
  foreach($students_list as $student) {
$dump =0;if ($dump) print_r($student);

    $students[$student['student_id']]['student_id'] = $student['student_id'];
    $student['student_name'] = str_replace(' .', '', $student['student_name']);
    $students[$student['student_id']]['student_name'] = $student['student_name'];
    $students[$student['student_id']]['active'] = $student['active'];

    if (!empty($student['group_id'])){
      $students[$student['student_id']]['groups'][$student['group_id']] = 1;
    }
if ($dump) print_r($students);
  }

  if (!empty($students))
  foreach($students as $student_id => $student) {
if ($dump) print_r($student);

    $student_n = "<tr class='odd'><td>$n</td><td><span id='stud_name".$student_id."' ".(($student['active']) ? '': " style='color:red;' title='".$lang['user_blocked']."'")
                .">".$student['student_name']."</span> <div id='studentdiv".$student_id."' ></td>";

    if (!empty($groups_list)) {

      $student_g = '';
      $groupcount = 0;
      for ($i = 0, $count=count($groups_list); $i < $count; $i++) {

        if (empty($groups_list[$i]['class_id'])) continue;
        if ($groups_list[$i]['class_id'] != $class_id) continue;
        if (empty($update)) {
          $groupcount ++;
          $alt        = (empty($student['groups'][$groups_list[$i]['group_id']])) ? '' : ' title="'.$groups_list[$i]['group'].'"';
          $checked    = (empty($student['groups'][$groups_list[$i]['group_id']])) ? '&nbsp;' : "&nbsp;V&nbsp;";
          $student_g .= '<td align="center"'.$alt.'>'.$checked."</td>";
        } else {
          $groupcount ++;
          $alt        = ' title="'.$groups_list[$i]['group'].'"';
          $checked    = ((empty($student['groups'][$groups_list[$i]['group_id']])) ? '' : 'checked="checked"');
          $student_g .= '<td align="center"'.$alt.'><input type="checkbox" name="check_list['.$student_id.']['.$groups_list[$i]['group_id'].']" value="1" '.$checked.'></td>';
        }
      }  //  for ($i = 0
    }
  
    if (empty($student_g)) {
      $student_g = "<td>&nbsp</td>";
    }

    $student_k = "<td><a href=\"student.php?class_id=".$class_id."&student_id=".$student['student_id']."&".uniqid('')."&keepThis=true&TB_iframe=true&height=550&width=670\" title=\"".$lang['change']."\" class=\"thickbox\">".$lang['change']."</a></td>";
    $student_k .= '
          <td><a href="" onclick="
          document.getElementById(\'student_name\').innerHTML=document.getElementById(\'stud_name'.$student_id.'\').innerHTML;
          document.getElementById(\'student_id\').value =\''.$student_id.'\';
          document.getElementById(\'addClass\').style.display=\'block\';
          return false;" title="'.$lang['move'].'" class=\'change\'>&nbsp;</a>
          </div></td>';
// Добавнено кнопку удалить            document.getElementById(\'classto_id\').focus();
    $student_k .= "<td><input value='1' type='checkbox' name='".$student['student_id']."'></td></tr>";
//echo "<td><a href=\"del_class_student.php?student_id=$student[student_id]&class_id=$_REQUEST[class_id]\" title=\"Удалить ученика\" onclick=\"return confirm('Вы, уверены что хотите удалить эту запись!')\">Удалить</a></td></tr>";
    echo $student_n.$student_g.$student_k."\n";

    $n++;

  }  //  foreach($students_list

?>

</tbody>
      <tfoot>




<tr><td colspan="2">&nbsp;</td><td colspan="<?php echo $groupcount;?>" align="left">
<?php
  if (!empty($class_id))
   if (empty($update)) 
     echo '<a href="class.php?update=1" style="color:#669933" title="'.$lang['change'].'">'.$lang['change'].'</a>';
   else
     echo '<a href="#" style="color:#669933" title="Сохранить"
             onclick="document.class.upd_class.value=1; document.class.delete_this2.disabled=true; document.class.submit();return false;">Сохранить</a>&nbsp;&nbsp;&nbsp;'
         .'<a href="#" style="color:#669933" title="Отказаться" 
             onClick="location='."'http://'".'+location.host+location.pathname; return false;">Отказаться</a>';

?>
</td>




<td align="right" colspan="3">
  <input id='message' class="butonoff" ref="thickbox" name='message' disabled="true" type='submit' value="<?php echo $lang['message'];?>"
    alt=''
    title="<?php echo $lang['message'];?>"
    onClick="document.class.update.value=''; 
             f=this.form;
             document.getElementById('sendMessage').style.display='block';
             return false;
             var student='';
             for (i=0; i< f.elements.length; i++){

               if ((f.elements[i].type=='checkbox') && 
                   (f.elements[i].name != '') && (f.elements[i].checked)){
                 student += '&student_id[]='+f.elements[i].name;
               }
             }
             this.alt= 'message.php?class_id=<?php echo $class_id?>'+
               student+
               '&<?php echo uniqid('')?>&keepThis=true&TB_iframe=true&height=250&width=300';
             return false;
             s = prompt('Введите текст сообщения:', ''); 
             if (s) return true;
             else return false;"
  >&nbsp;&nbsp;<input id='delete' name="delete_this2" class='butonoff' disabled="true" type='submit' value="<?php echo $lang['delete'];?>"
    onClick="if (confirm('Вы желаете удалить ученика из класса?')) { document.class.update.value=''; return true; }else return false;"></td>
</tr> <!--  alert(f.elements[i].type+'|'+f.elements[i].name+'|'+f.elements[i].checked);-->

     <tr>
           <td colspan="2" class="rounded-foot-left">&nbsp;</td>
           <td colspan="<?php echo $groupcount;?>" >&nbsp;</td>
           <td colspan="3" class="rounded-foot-right">
           <a href="" onClick="javascript: tb_show('Добавить', 'student.php?class_id=<?php echo $class_id;?>&<?php echo uniqid(''); ?>&TB_iframe=true&height=400&width=600'); return false;" 
              class="add" title="Добавить"><?php echo $lang['add'];?></a>
          </td>
    </tr>
     </tfoot>
</table>
</form>
</div>
<div id="addClass" style="display:none;" >
<div id="student_name"></div>  
<br>
    <form method="post" action="" name="student" id="student">
       <input type="hidden" name="update" value="1">
        <input type="hidden" name="newstudent" value="1">
        <input type="hidden" id="classfrom_id" name="classfrom_id" value="<?php echo $class_id;?>">
        <input type="hidden" id="student_id" name="student_id" value="">
        <select name="classto_id" id="classto_id">
        <option value=""><?php echo $lang['select'];?></option>
<?php
   $classes_list = get_classes_list_sel($_SESSION['schoolyear']);
   foreach ($classes_list as $classes1) {
    echo '<option $selclass value="'.$classes1['class_id'].'">'.$classes1['class'].' '.$classes1['letter'].'</option>';
   }
?>
      </select>
<br>
<br>
           <a href="" onClick="
            if (document.getElementById('classto_id').value=='') {
            document.getElementById('classto_id').focus();
            return false;}
            document.getElementById('addClass').style.display='none';
            ewd_getcontent('ajaxform-student.php?student_id='+document.getElementById('student_id').value+
              '&classto_id='+document.getElementById('classto_id').value+
              '&classfrom_id='+document.getElementById('classfrom_id').value, 'studentdiv'+document.getElementById('student_id').value);
            return false;
            document.getElementById('student').submit(); 
            return false;" 
              class="add" title="<?php echo $lang['move'];?>"><?php echo $lang['move'];?></a> <a href="" onClick="
            document.getElementById('addClass').style.display='none';
            return false;" 
              class="add" title="Закрыть"><?php echo $lang['close'];?></a>
    </form>
</div>

<div id="sendMessage" style="display:none;" >

<br>
    <form method="post" action="" name="sendmess" id="sendmess">
    Введите тему<br>(не обязательно)<br>
    <input type="text" name="title" style="width: 90%;"><br>
    Введите сообщение<br>
    <textarea name="message"></textarea><br>

           <a href="" class="thickbox" title="Закрыть" onClick="
             if (document.sendmess.message.value ==''){
              document.sendmess.message.focus(); 
              return false;
            }
             var student='';
             for (i=0; i< f.elements.length; i++){
               if ((f.elements[i].type=='checkbox') && 
                   (f.elements[i].name != '') && (f.elements[i].checked)){
                 student += '&student_id[]='+f.elements[i].name;
               }
             }
            document.getElementById('sendMessage').style.display='none';
            this.href= 'sms_sending-mess.php?class_id=<?php echo $class_id?>'+
               student+
               '&title='+
               document.sendmess.title.value+
               '&message='+
               document.sendmess.message.value.replace(/(\n|\r|\r\n)/g,'')
               +'&action=sendmess&<?php echo uniqid('')?>&keepThis=true&TB_iframe=true&height=250&width=300';
            return false;
            document.getElementById('student').submit(); 
            return false;" 
              class="add" title="<?php echo $lang['send'];?>"><?php echo $lang['send'];?></a> <a href="" onClick="
            document.getElementById('sendMessage').style.display='none';
            return false;" 
          ><?php echo $lang['close'];?></a>
    </form>
</div>
<?php
  include 'footer.php';
?>
<script language='javascript'> <!--
var f='';
//--></script>
