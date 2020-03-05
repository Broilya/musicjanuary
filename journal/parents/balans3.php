<?php
/*****************************************************************************\
+-----------------------------------------------------------------------------+
| SchoolReg                                                                   |
| Copyright (c) 2010 <www.journal.schoole.ru>                      |
| All rights reserved.                                                       |
+-----------------------------------------------------------------------------+
\*****************************************************************************/

$db_config = mysql_query("SELECT * FROM `".TABLE_CONFIG."`");
while ($config = mysql_fetch_array($db_config)) {
  define($config['key_config'], $config['value_config']);
}

?>
  <body>
<?
if (SMS_ZAPROS == '0') {
 echo "{$lang['sms1']} ".SMS_PREFIKS_OZENKI. " $student[pin_code] {$lang['sms2']}. <br><br>{$lang['sms3']} ".SMS_PREFIKS_DZ." $student[pin_code] {$lang['sms2']}. <br><a href=\"http://num.smsonline.ru/?4345\" target=_blank>{$lang['sms4']}</a>";   
}
?>
  </body>
</html>