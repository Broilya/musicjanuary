<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

//$db_config = mysql_query("SELECT round(sum(summa)/100,2) as s FROM `sch_balance` WHERE student_id=".$_SESSION['student_id']);
//$sum=mysql_fetch_assoc($db_config);

if (!empty($_SESSION['student_id'])) {
  $sum = getStudentBalance ($_SESSION['student_id']);

  $sums = ((empty($sum)) ? 0 :$sum)." рублей";
  if (empty($sum)) {
   $sums="<font color='red'>".$sums."<br><br><b>Ваша учетная запись заблокирована! Пожалуйста, пополните счет.</b></font>";
  } 
  //$sum['s']=round($sum['s']/100,2);

  echo "На вашем счету: {$sums}";
} else {
  echo "Вы не вошли в дневник. Пожалуйста авторизуйтесь.";
}

?>
  </body>
</html>