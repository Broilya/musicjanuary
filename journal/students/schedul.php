<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

define('STUDENT_ZONE', true);

$res = db_query("select class_id FROM `".TABLE_STUDENTS_IN_CLASS."` where student_id=".$_SESSION['student_id']);
$row_shed=mysql_fetch_assoc($res);


$class_id      = $row_shed['class_id'];

  include('../header_dialog2.php');
?>
  <body>
<?php



    outStudentForm();


function outStudentForm()
{
  global  $class_id;
  echo '
<form action="" method="post">';
  echo '<input type="hidden" name="action" value="search" />';
  echo '
      <input type="hidden" name="class_id" value="'.$class_id.'" />

    Кликните в форму, для выбора даты:
    <script type="text/javascript">
        $(function() {
                $("#date_schedule_id").datepicker({
                        changeMonth: true,
                        changeYear: true
                });
        });
        </script>
  <input type="text" name="date_schedule" id="date_schedule_id" value="'.$_POST['date_schedule'].'" size="26" />&nbsp;&nbsp;<input type="submit" value="Показать" /></td>


 ';
  echo '&nbsp;&nbsp;&nbsp;

</form>';
}

if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];

  if ($action == 'search') {
    $date_schedule = implode('-', array_reverse(explode('.', $_REQUEST['date_schedule'])));
    $query="SELECT d.discipline, l.dz"
          ." FROM `".TABLE_SCHEDULE."` AS a"
          ." LEFT JOIN `".TABLE_SPR_DISCIPLINES."` AS d ON d.discipline_id = a.discipline_id"
          ." LEFT JOIN `".TABLE_SUBJECTS."` AS s ON s.discipline_id = a.discipline_id"
          ." LEFT JOIN `".TABLE_LESSONS."` AS l ON s.subject_id = l.subject_id"
          ." WHERE  s.class_id = '".$class_id."'"
          ." AND lesson_date = '".$date_schedule."'"
          ." group by d.discipline, l.dz";

    $res=mysql_query($query);

    echo "<table ><thead><tr><th>Предмет<th>Домашнее задание</thead><tbody>";
    while($row=mysql_fetch_array($res)) {
      echo "<tr><td>{$row['discipline']}<td>{$row['dz']}";
    }
    echo "</tbody></table>";
  }
}


?>
  </body>
</html>