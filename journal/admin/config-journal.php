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

//  if (SUPERADMINID != $_SESSION['admin_id']) {
//    header('Location: services.php');
//  }

$db_config = mysql_query("SELECT * FROM `".TABLE_CONFIG."`");
while ($config = mysql_fetch_array($db_config)) {
  define($config['key_config'], $config['value_config']);
}

 $checked = (SMS_ZAPROS) ? '' : 'checked="checked"';
 $nochecked = (SMS_ZAPROS) ? 'checked="checked"' : '';

 $checked_d   = (DAYS) ? '' : 'checked="checked"';
 $nochecked_d = (DAYS) ? 'checked="checked"' : '';
 
  if (isset($_POST['config']) && $_POST['config'] == 'edit') {
    if (SUPERADMINID == $_SESSION['admin_id']) {
      mysql_query("UPDATE `".TABLE_CONFIG."` SET value_config='".$_POST['TEST_DAYS']."' WHERE key_config='TEST_DAYS' AND (active=1)");
      mysql_query("UPDATE `".TABLE_CONFIG."` SET value_config='".$_POST['LANG']."' WHERE key_config='LANG' AND (active=1)");
      mysql_query("UPDATE `".TABLE_CONFIG."` SET value_config='".$_POST['SMS_ZAPROS']."' WHERE key_config='SMS_ZAPROS' AND (active=1)");
      mysql_query("UPDATE `".TABLE_CONFIG."` SET value_config='".$_POST['SMS_PREFIKS_OZENKI']."' WHERE key_config='SMS_PREFIKS_OZENKI' AND (active=1)");
      mysql_query("UPDATE `".TABLE_CONFIG."` SET value_config='".$_POST['SMS_PREFIKS_DZ']."' WHERE key_config='SMS_PREFIKS_DZ' AND (active=1)");
    }
    mysql_query("UPDATE `".TABLE_CONFIG."` SET value_config='".$_POST['NUM_SCHOOL']."' WHERE key_config='NUM_SCHOOL' AND (active=1)");
    mysql_query("UPDATE `".TABLE_CONFIG."` SET value_config='".$_POST['NAME_SCHOOL']."' WHERE key_config='NAME_SCHOOL' AND (active=1)");
    mysql_query("UPDATE `".TABLE_CONFIG."` SET value_config='".$_POST['DAYS']."' WHERE key_config='DAYS' AND (active=1)");
    exit(header("Location: config-journal.php")); 
  }
 
 include 'header.php';

?>

<div align="center"> 
<br />
<form action="config-journal.php"  method="post" id="fconfig">
<input name="config" type="hidden" value="edit"/>
 <table width="70%" border="0" cellpadding="2" cellspacing="2" align="center">
 <tr>
    <td width="45%"><?php echo $lang['config_7']?>:</td>
    <td><input name="NAME_SCHOOL" value='<?=NAME_SCHOOL;?>' size="20" maxlength="255" type="text"/></td>
  </tr>
 <tr>
    <td width="45%"><?php echo $lang['config_8']?>:</td>
    <td><input name="NUM_SCHOOL" value='<?=NUM_SCHOOL;?>' size="20" maxlength="255" type="text"/></td>
  </tr>
 <tr>
    <td width="45%"><?php echo $lang['config_4']?>:</td>
    <td><input type="radio" name="DAYS" value="0" <?=$checked_d;?>/> 5 <?php echo $lang['config_4_days'];?> <input type="radio" name="DAYS" value="1" <?=$nochecked_d;?> /> 6 <?php echo $lang['config_4_days'];?></td>
  </tr>
<?php
    if (SUPERADMINID == $_SESSION['admin_id']) {
?>
 <tr>
    <td width="45%"><?php echo $lang['config_9']?>:</td>
    <td><input name="TEST_DAYS" value='<?=TEST_DAYS;?>' size="20" maxlength="2" type="text"/></td>
  </tr>
  <tr>
    <td width="45%"><?php echo $lang['config_5_q'];?>:</td>
    <td><input name="LANG" value="<?=LANG;?>" type="text" size="20" maxlength="30" /> </td>
  </tr>
 <tr>
    <td width="45%"><hr></td>
    <td>&nbsp;</td>
  </tr>
 <tr>
    <td width="45%"><?php echo $lang['config_1']?>:</td>
    <td><input type="radio" name="SMS_ZAPROS" value="0" <?=$checked;?>/> <?php echo $lang['config_1_on'];?> <input type="radio" name="SMS_ZAPROS" value="1" <?=$nochecked;?> /> <?php echo $lang['config_1_off'];?></td>
  </tr>
 <tr>
    <td width="45%"><?php echo $lang['config_2']?>:</td>
    <td><input name="SMS_PREFIKS_OZENKI" value="<?=SMS_PREFIKS_OZENKI;?>" size="20" maxlength="30" type="text"/></td>
  </tr>
  <tr>
    <td><?php echo $lang['config_3']?>: 
    <td><input name="SMS_PREFIKS_DZ" value="<?=SMS_PREFIKS_DZ;?>" size="20" maxlength="30" type="text"/></td>
  </tr>
<?php
    }
?>
  <tr>
  <td></td>
  <td height="35"><input type="submit" value="<?php echo $lang['save'];?>" /></td>
  </tr>
 </table>
</div> 
<br/> 
<?php
include 'footer.php';
?>