<?php
  
  header("Content-type: text/html; charset=utf-8");
  define('ADMIN_ZONE', true);
  include_once ('../init.php');   
  include_once ('../include/teachers.php');
  error_reporting(E_ALL & ~E_NOTICE);
//  $empty       = intval($_REQUEST['empty']);
  $discipline_id=intval($_REQUEST['disciplineid']);
  $class_id    = intval($_REQUEST['class']);
  $teacher_id  = intval($_REQUEST['teacher_id']);
  if (isset($_REQUEST['ID'])) {
    $ID = intval($_REQUEST['ID']);
    $ss = (isset($_REQUEST['ID'])) ? "s[]" : '';
  }

  $_tmp =  get_teachers_list($discipline_id);

  $discipline_id = (empty($_tmp)) ? '' : $discipline_id; 
/*
  $sql = "SELECT DISTINCT a.*, b.teacher_id, b.first_name, b.middle_name, b.last_name "
//        ." FROM `".TABLE_SUBJECTS."` AS a"
//        ." LEFT JOIN `".TABLE_USERS_TEACHERS."` AS b ON (b.teacher_id = a.teacher_id) WHERE 1=1"
        
        .( (empty($discipline_id)) ? ' ' : " AND (a.discipline_id = '$discipline_id')")
        .( (empty($class_id)) ? ' ' : " AND (a.class_id='".$class_id."')")
//        .( (empty($empty)) ? " )" : " OR (a.class_id = 0))")
        ." GROUP BY b.teacher_id"
        ." ORDER BY b.last_name, b.first_name, m.middle_name;";
*/
  $sql = "SELECT  a.*, b.teacher_id, b.first_name, b.middle_name, b.last_name "
           .", "
           .( (empty($discipline_id)) ? 'IF( NOT ifnull( a.discipline_id, 0 ), 1, 0)' :
              " IF ( a.discipline_id = '".$discipline_id."', 2, IF( NOT ifnull( a.discipline_id, 0 ), 1, 0) )")
           ." AS sel"
        ." FROM `".TABLE_USERS_TEACHERS."` AS b"
        ." LEFT JOIN `".TABLE_SUBJECTS."` AS a ON (b.teacher_id = a.teacher_id) "
        ." WHERE 1=1 "
//        .( (empty($discipline_id)) ? ' ' : " AND (a.discipline_id = '$discipline_id')")
        .( (empty($class_id)) ? ' ' : " AND (a.class_id='".$class_id."')")
//        .( (empty($empty)) ? " )" : " OR (a.class_id = 0))")
        ." GROUP BY sel, b.teacher_id"
        ." ORDER BY sel DESC, b.last_name, b.first_name, b.middle_name;";

$dump =0; if ($dump) echo $sql."$teacher_id|$discipline_id|<br>\n";

  $db_teacher = mysql_query($sql);
  $coun_db = mysql_num_rows($db_teacher);

  while ($teacher = mysql_fetch_array($db_teacher)) {
    $teachers[$teacher['teacher_id']]=$teacher;
    $teachers[$teacher['teacher_id']]['select'] += $teacher['sel'];
  }
if ($dump) print_r($teachers);
?>
<select name="teacher<?php echo $ss;?>" id="teacher<?php echo $ID;?>" style="width:220px;">
  <option value=""><?php echo $lang['select'];?></option>
<?php
  $c = 0;
  foreach ($teachers  as $teacher_id=>$teacher) {
if ($dump) print_r($teacher);
    if ($c == 0) {
      $selected =(!empty($discipline_id) && (($coun_db == 1) || ($teacher['teacher_id'] == $teacher_id)
                  || ($teacher['discipline_id'] == $discipline_id))) ? "selected='selected'" : ''; 
      $c ++;
    } else 
      $selected ='';

    echo "<option value='".$teacher['teacher_id']."' $selected>". $teacher['last_name']." ". $teacher['first_name']." ".$teacher['middle_name']."</option>";
  }
?>
</select>
