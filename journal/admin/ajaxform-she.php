<?php

  header("Content-type: text/html; charset=utf-8");
  define('ADMIN_ZONE', true);
  include_once ('../init.php'); 
  
  error_reporting(E_ALL & ~E_NOTICE);
//  $date=$_GET['date'];
  $date = implode('-', array_reverse(explode('.', $_REQUEST['date'])));

  $subj=intval($_GET['subj']);
  
  $query="SELECT a.*, d.discipline as s3, s.subject_id FROM `".TABLE_SCHEDULE."` AS a 
  LEFT JOIN `".TABLE_SPR_DISCIPLINES."` AS d ON d.discipline_id=a.discipline_id 
  LEFT JOIN `".TABLE_SUBJECTS."` AS s ON s.discipline_id=a.discipline_id  and s.subject_id=$subj
  
  WHERE a.discipline_id=(select discipline_id FROM `".TABLE_SUBJECTS."` where subject_id=$subj)
  AND date_schedule=weekday('$date')";
  $res=mysql_query($query);
 
  if (mysql_num_rows($res)==0) { echo "<font color='red'>Урока нет в рассписании!</font>"; } else 
  {
  
 
  while ($row=mysql_fetch_assoc($res))
  {
  $d_name="<b>".$row['s3'].":</b><br>";
  $text.="Позиция урока: {$row['order_schedule']}<br>";
  }
  $text=$d_name.$text;
  
  echo "<font color='green'>".$text."</font>";
  }
