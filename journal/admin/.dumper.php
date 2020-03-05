<?php

// no direct access
define('ADMIN_ZONE', true);
include_once ('../init.php');

$DB_HOST     = $db_host  ;
$DB_DATABASE = $db_base  ;
$DB_USER     = $db_user  ;
$DB_PASSWORD = $db_passwd;
$DIR_FILES   = '.';

  $OUT = "";



/***************************************************************************\
| Sypex Dumper Lite          version 1.0.8b                                 |
| (c)2003-2006 zapimir       zapimir@zapimir.net       http://sypex.net/    |
| (c)2005-2006 BINOVATOR     info@sypex.net                                 |
|---------------------------------------------------------------------------|
|     created: 2003.09.02 19:07              modified: 2006.10.27 03:30     |
|---------------------------------------------------------------------------|
| This program is free software; you can redistribute it and/or             |
| modify it under the terms of the GNU General Public License               |
| as published by the Free Software Foundation; either version 2            |
| of the License, or (at your option) any later version.                    |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,USA. |
\***************************************************************************/

//SLIPPERY//
// è„‚Ï ® URL ™ ‰†©´†¨ °•™†Ø†
define('PATH', $DIR_FILES.'/backup/'.SUBDOMEN.'/');
define('PATHINC', $DIR_FILES.'/backup/');

define('URL',  $DIR_FILES.'/backup/'.SUBDOMEN.'/');
  if (!is_dir(PATH)){
    mkdir(PATH, 0777);
    chmod(PATH, 0777);
  }

// å†™·®¨†´Ï≠Æ• ¢‡•¨Ô ¢ÎØÆ´≠•≠®Ô ·™‡®Ø‚† ¢ ·•™„≠§†Â
// 0 - °•ß Æ£‡†≠®Á•≠®©
define('TIME_LIMIT', 600);
// é£‡†≠®Á•≠®• ‡†ß¨•‡† §†≠≠ÎÂ §Æ·‚†¢†•¨ÎÂ ß† Æ§≠Æ Æ°‡†È•≠®Ô ™ ÅÑ (¢ ¨•£†°†©‚†Â)
// ç„¶≠Æ §´Ô Æ£‡†≠®Á•≠®Ô ™Æ´®Á•·‚¢† Ø†¨Ô‚® ØÆ¶®‡†•¨Æ© ·•‡¢•‡Æ¨ Ø‡® §†¨Ø• ÆÁ•≠Ï Æ°Í•¨≠ÎÂ ‚†°´®Ê
define('LIMIT', 1);
// mysql ·•‡¢•‡
//SLIPPERY//define('DBHOST', 'localhost:3306');
define('DBHOST', $DB_HOST.'');

// Å†ßÎ §†≠≠ÎÂ, •·´® ·•‡¢•‡ ≠• ‡†ß‡•Ë†•‚ Ø‡Æ·¨†‚‡®¢†‚Ï ·Ø®·Æ™ °†ß §†≠≠ÎÂ,
// ® ≠®Á•£Æ ≠• ØÆ™†ßÎ¢†•‚·Ô ØÆ·´• †¢‚Æ‡®ß†Ê®®. è•‡•Á®·´®‚• ≠†ß¢†≠®Ô Á•‡•ß ß†ØÔ‚„Ó
define('DBNAMES', $DB_DATABASE.'');  //SLIPPERY//
// äÆ§®‡Æ¢™† ·Æ•§®≠•≠®Ô · MySQL
// auto - †¢‚Æ¨†‚®Á•·™®© ¢Î°Æ‡ („·‚†≠†¢´®¢†•‚·Ô ™Æ§®‡Æ¢™† ‚†°´®ÊÎ), cp1251 - windows-1251, ® ‚.Ø.
define('CHARSET', 'auto');
// äÆ§®‡Æ¢™† ·Æ•§®≠•≠®Ô · MySQL Ø‡® ¢Æ··‚†≠Æ¢´•≠®®
// ç† ·´„Á†© Ø•‡•≠Æ·† ·Æ ·‚†‡ÎÂ ¢•‡·®© MySQL (§Æ 4.1), „ ™Æ‚Æ‡ÎÂ ≠• „™†ß†≠† ™Æ§®‡Æ¢™† ‚†°´®Ê ¢ §†¨Ø•
// è‡® §Æ°†¢´•≠®® 'forced->', ™ Ø‡®¨•‡„ 'forced->cp1251', ™Æ§®‡Æ¢™† ‚†°´®Ê Ø‡® ¢Æ··‚†≠Æ¢´•≠®® °„§•‚ Ø‡®≠„§®‚•´Ï≠Æ ß†¨•≠•≠† ≠† cp1251
// åÆ¶≠Æ ‚†™¶• „™†ßÎ¢†‚Ï ·‡†¢≠•≠®• ≠„¶≠Æ• ™ Ø‡®¨•‡„ 'cp1251_ukrainian_ci' ®´® 'forced->cp1251_ukrainian_ci'
//SLIPPERY//define('RESTORE_CHARSET', 'cp1251');
define('RESTORE_CHARSET', 'utf8');
// Ç™´ÓÁ®‚Ï ·ÆÂ‡†≠•≠®• ≠†·‚‡Æ•™ ® ØÆ·´•§≠®Â §•©·‚¢®©
// Ñ´Ô Æ‚™´ÓÁ•≠®Ô „·‚†≠Æ¢®‚Ï ß≠†Á•≠®• 0
define('SC', 1);
// í®ØÎ ‚†°´®Ê „ ™Æ‚Æ‡ÎÂ ·ÆÂ‡†≠Ô•‚·Ô ‚Æ´Ï™Æ ·‚‡„™‚„‡†, ‡†ß§•´•≠≠Î• ß†ØÔ‚Æ©
define('ONLY_CREATE', 'MRG_MyISAM,MERGE,HEAP,MEMORY');
// É´Æ°†´Ï≠†Ô ·‚†‚®·‚®™†
// Ñ´Ô Æ‚™´ÓÁ•≠®Ô „·‚†≠Æ¢®‚Ï ß≠†Á•≠®• 0
define('GS', 0);


// Ñ†´ÏË• ≠®Á•£Æ ‡•§†™‚®‡Æ¢†‚Ï ≠• ≠„¶≠Æ

$is_safe_mode = ini_get('safe_mode') == '1' ? 1 : 0;
if (!$is_safe_mode && function_exists('set_time_limit')) set_time_limit(TIME_LIMIT);

$timer = array_sum(explode(' ', microtime()));
//ob_implicit_flush();

//SLIPPERY//  error_reporting(E_ALL);

//SLIPPERY//
  $DUMPER = '';
  ob_start();
  $SK ='';
  $OUT = '';

function do_dumper() {  //SLIPPERY//
  global $DB_USER, $DB_PASSWORD, $DIR_FS_MODULES, $DIR_FS_SCRIPLETS, $TABLE_SCRIPLETS;
  global $FILE_FCK_DEL, $timer, $is_safe_mode, $SK, $DUMPER, $OUT;

/*
header("Expires: Tue, 1 Jul 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
*/
//echo (empty($_COOKIE['sxd']))."|1) _COOKIE['sxd']=".$_COOKIE['sxd']."<br>\n";
  if (empty($_COOKIE['sxd'])) {
    setcookie("sxd", base64_encode("SKD101:{$DB_USER}:{$DB_USER}"));
  }


$auth = 0;
$error = '';
    setcookie("sxd", base64_encode("SKD101:{$DB_USER}:{$DB_USER}"));
//echo "|2) _COOKIE['sxd']=".$_COOKIE['sxd']."<br>\n";

  if (!empty($_POST['login']) && isset($_POST['pass'])) {
    if (@mysql_connect(DBHOST, $_POST['login'], $_POST['pass'])){
      setcookie("sxd", base64_encode("SKD101:{$_POST['login']}:{$_POST['pass']}"));
      header("Location: .dumper.php");   //SLIPPERY//
//    mysql_close();            //SLIPPERY//
      do_exit();                  //SLIPPERY//
      return;
    }
    else{
      $error = '#' . mysql_errno() . ': ' . mysql_error();
    }
  }
  elseif (!empty($_COOKIE['sxd'])) {

//echo "|3) _COOKIE['sxd']=".$_COOKIE['sxd']."<br>\n";

    $user = explode(":", base64_decode($_COOKIE['sxd']));
    $user[1] = $DB_USER.'';  //SLIPPERY//
    $user[2] = $DB_PASSWORD.'';  //SLIPPERY//
    if (@mysql_connect(DBHOST, $user[1], $user[2])){
      $auth = 1;
    }
    else{
      $error = '#' . mysql_errno() . ': ' . mysql_error();
    }
  } else {
    if (@mysql_connect(DBHOST, $DB_USER, $DB_PASSWORD)){
      setcookie("sxd", base64_encode("SKD101:{$DB_USER}:{$DB_USER}"));
      header("Location: .dumper.php");   //SLIPPERY//
//    mysql_close();            //SLIPPERY//
      do_exit();                  //SLIPPERY//
      return;
    }
    else{
      $error = '#' . mysql_errno() . ': ' . mysql_error();
    }
  }

  if (!$auth || (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] == 'reload')) {
    setcookie("sxd");
    echo tpl_page(tpl_auth($error ? tpl_error($error) : ''), "<SCRIPT>if (jsEnabled) {document.write('<INPUT TYPE=submit VALUE=–ü—Ä–∏–º–µ–Ω–∏—Ç—å>');}</SCRIPT>");
    echo "<SCRIPT>document.getElementById('timer').innerHTML = '" . round(array_sum(explode(' ', microtime())) - $timer, 4) . " —Å–µ–∫.'</SCRIPT>";
    do_exit();                  //SLIPPERY//
    return;
    exit;
  }
  if (!file_exists(PATH) && !$is_safe_mode) {
//    mkdir(PATH, 0777) || trigger_error("ç• „§†´Æ·Ï ·Æß§†‚Ï ™†‚†´Æ£ §´Ô °•™†Ø† - ".PATH, E_USER_ERROR);
      mkdir(PATH, 0777) || trigger_error("–ù–µ —É–¥–∞–ª–æ—Å—å —Å–æ–∑–¥–∞—Ç—å –∫–∞—Ç–∞–ª–æ–≥ –¥–ª—è –±–µ–∫–∞–ø–∞ - ".PATH, E_USER_ERROR);
  }

  $SK = new dumper();
  define('C_DEFAULT', 1);
  define('C_RESULT', 2);
  define('C_ERROR', 3);
  define('C_WARNING', 4);

  $action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';
  switch($action){
    case 'backup':

      $SK->backup();
      break;

    case 'restore':

      $SK->restore();

      break;
    default:
      $SK->main();
  }

//SLIPPERY//mysql_close();

  echo "<SCRIPT>document.getElementById('timer').innerHTML = '" . round(array_sum(explode(' ', microtime())) - $timer, 4) . " —Å–µ–∫.'</SCRIPT>";

} //  function do_dumper() {  //SLIPPERY//


class dumper {
  function dumper() {
    global $OUT;
    if (file_exists(PATHINC . "dumper.cfg.php")) {
        include(PATHINC . "dumper.cfg.php");
    }
    else{
      $this->SET['last_action'] = 0;
      $this->SET['last_db_backup'] = '';
      $this->SET['tables'] = '';
      $this->SET['comp_method'] = 2;
      $this->SET['comp_level']  = 7;
      $this->SET['last_db_restore'] = '';
    }
    $this->tabs = 0;
    $this->records = 0;
    $this->size = 0;
    $this->comp = 0;

// Ç•‡·®Ô MySQL ¢®§† 40101
    preg_match("/^(\d+)\.(\d+)\.(\d+)/", mysql_get_server_info(), $m);
    $this->mysql_version = sprintf("%d%02d%02d", $m[1], $m[2], $m[3]);

    $this->only_create = explode(',', ONLY_CREATE);
    $this->forced_charset  = false;
    $this->restore_charset = $this->restore_collate = '';
    if (preg_match("/^(forced->)?(([a-z0-9]+)(\_\w+)?)$/", RESTORE_CHARSET, $matches)) {
      $this->forced_charset  = $matches[1] == 'forced->';
      $this->restore_charset = $matches[3];
      $this->restore_collate = !empty($matches[4]) ? ' COLLATE ' . $matches[2] : '';
    }
  }

  function backup() {
    if (!isset($_POST)) {
      $this->main();
    }
//??????    set_error_handler("SXD_errorHandler");
//    $buttons = "<A ID=save HREF='' STYLE='display: none;'>ë™†Á†‚Ï ‰†©´</A> &nbsp; <INPUT ID=back TYPE=button VALUE='Ç•‡≠„‚Ï·Ô' DISABLED onClick=\"history.back();\">";
    $buttons = "<A ID=save HREF='' STYLE='display: none;'>–°–∫–∞—á–∞—Ç—å —Ñ–∞–π–ª</A> &nbsp; <INPUT ID=back TYPE=button VALUE='–í–µ—Ä–Ω—É—Ç—å—Å—è' DISABLED onClick=\"history.back();\">";
//    echo tpl_page(tpl_process("ëÆß§†•‚·Ô ‡•ß•‡¢≠†Ô ™ÆØ®Ô ÅÑ"), $buttons);
    echo tpl_page(tpl_process("–°–æ–∑–¥–∞–µ—Ç—Å—è —Ä–µ–∑–µ—Ä–≤–Ω–∞—è –∫–æ–ø–∏—è –ë–î"), $buttons);

    $this->SET['last_action']     = 0;
    $this->SET['last_db_backup']  = isset($_POST['db_backup']) ? $_POST['db_backup'] : '';
    $this->SET['tables_exclude']  = !empty($_POST['tables']) && $_POST['tables']{0} == '^' ? 1 : 0;
    $this->SET['tables']          = isset($_POST['tables']) ? $_POST['tables'] : '';
    $this->SET['comp_method']     = isset($_POST['comp_method']) ? intval($_POST['comp_method']) : 0;
    $this->SET['comp_level']      = isset($_POST['comp_level']) ? intval($_POST['comp_level']) : 0;
    $this->fn_save();

    $this->SET['tables']          = explode(",", $this->SET['tables']);
    if (!empty($_POST['tables'])) {
      foreach($this->SET['tables'] AS $table){
            $table = preg_replace("/[^\w*?^]/", "", $table);
        $pattern = array( "/\?/", "/\*/");
        $replace = array( ".", ".*?");
        $tbls[] = preg_replace($pattern, $replace, $table);
          }
    }
    else{
      $this->SET['tables_exclude'] = 1;
    }

    if ($this->SET['comp_level'] == 0) {
      $this->SET['comp_method'] = 0;
    }
    $db = $this->SET['last_db_backup'];

    if (!$db) {
//      echo tpl_l("éòàÅäÄ! ç• „™†ß†≠† °†ß† §†≠≠ÎÂ!", C_ERROR);
      echo tpl_l("–û–®–ò–ë–ö–ê! –ù–µ —É–∫–∞–∑–∞–Ω–∞ –±–∞–∑–∞ –¥–∞–Ω–Ω—ã—Ö!", C_ERROR);
      echo tpl_enableBack();
      $this->do_exit();                  //SLIPPERY//
      return;
      exit;
    }
//    echo tpl_l("èÆ§™´ÓÁ•≠®• ™ ÅÑ `{$db}`.");
    echo tpl_l("–ü–æ–¥–∫–ª—é—á–µ–Ω–∏–µ –∫ –ë–î `{$db}`.");
//    mysql_select_db($db) or trigger_error ("ç• „§†•‚·Ô ¢Î°‡†‚Ï °†ß„ §†≠≠ÎÂ.<BR>" . mysql_error(), E_USER_ERROR);
    mysql_select_db($db) or trigger_error ("–ù–µ —É–¥–∞–µ—Ç—Å—è –≤—ã–±—Ä–∞—Ç—å –±–∞–∑—É –¥–∞–Ω–Ω—ã—Ö.<BR>" . mysql_error(), E_USER_ERROR);
    $tables = array();
    $result = mysql_query("SHOW TABLES");
    $all = 0;
    while($row = mysql_fetch_array($result)) {
      $status = 0;
      if (!empty($tbls)) {
        foreach($tbls AS $table){
          $exclude = preg_match("/^\^/", $table) ? true : false;
          if (!$exclude) {
            if (preg_match("/^{$table}$/i", $row[0])) {
              $status = 1;
            }
            $all = 1;
          }
          if ($exclude && preg_match("/{$table}$/i", $row[0])) {
            $status = -1;
          }
        }
      }
      else {
        $status = 1;
      }
      if ($status >= $all) {
            $tables[] = $row[0];
      }
    }

    $tabs = count($tables);
// éØ‡•§•´•≠®• ‡†ß¨•‡Æ¢ ‚†°´®Ê
    $result = mysql_query("SHOW TABLE STATUS");
    $tabinfo = array();
    $tab_charset = array();
    $tab_type = array();
    $tabinfo[0] = 0;
    $info = '';
    while($item = mysql_fetch_assoc($result)){
//print_r($item);
      if(in_array($item['Name'], $tables)) {
        $item['Rows'] = empty($item['Rows']) ? 0 : $item['Rows'];
        $tabinfo[0] += $item['Rows'];
        $tabinfo[$item['Name']] = $item['Rows'];
        $this->size += $item['Data_length'];
        $tabsize[$item['Name']] = 1 + round(LIMIT * 1048576 / ($item['Avg_row_length'] + 1));
        if($item['Rows']) 
          $info .= "|" . $item['Rows'];
        if (!empty($item['Collation']) && preg_match("/^([a-z0-9]+)_/i", $item['Collation'], $m)) {
          $tab_charset[$item['Name']] = $m[1];
        }
        $tab_type[$item['Name']] = isset($item['Engine']) ? $item['Engine'] : $item['Type'];
      }
    }
    $show = 10 + $tabinfo[0] / 50;
    $info = $tabinfo[0] . $info;
    $name = $db . '_' . date("Y-m-d_H-i");
          $fp = $this->fn_open($name, "w");
//    echo tpl_l("ëÆß§†≠®• ‰†©´† · ‡•ß•‡¢≠Æ© ™ÆØ®•© ÅÑ:<BR>\\n  -  {$this->filename}");
    echo tpl_l("–°–æ–∑–¥–∞–Ω–∏–µ —Ñ–∞–π–ª–∞ —Å —Ä–µ–∑–µ—Ä–≤–Ω–æ–π –∫–æ–ø–∏–µ–π –ë–î:<BR>\\n  -  {$this->filename}");
    $this->fn_write($fp, "#SKD101|{$db}|{$tabs}|" . date("Y.m.d H:i:s") ."|{$info}\n\n");
    $t=0;
    echo tpl_l(str_repeat("-", 60));
    $result = mysql_query("SET SQL_QUOTE_SHOW_CREATE = 1");
// äÆ§®‡Æ¢™† ·Æ•§®≠•≠®Ô ØÆ „¨Æ´Á†≠®Ó
    if ($this->mysql_version > 40101 && CHARSET != 'auto') {
//      mysql_query("SET NAMES '" . CHARSET . "'") or trigger_error ("ç•„§†•‚·Ô ®ß¨•≠®‚Ï ™Æ§®‡Æ¢™„ ·Æ•§®≠•≠®Ô.<BR>" . mysql_error(), E_USER_ERROR);
      mysql_query("SET NAMES '" . CHARSET . "'") or trigger_error ("0) –ù–µ—É–¥–∞–µ—Ç—Å—è –∏–∑–º–µ–Ω–∏—Ç—å –∫–æ–¥–∏—Ä–æ–≤–∫—É —Å–æ–µ–¥–∏–Ω–µ–Ω–∏—è.<BR>" . mysql_error(), E_USER_ERROR);
      $last_charset = CHARSET;
    }
    else{
      $last_charset = '';
    }
    foreach ($tables AS $table){
// ÇÎ·‚†¢´Ô•¨ ™Æ§®‡Æ¢™„ ·Æ•§®≠•≠®Ô ·ÆÆ‚¢•‚·‚¢„ÓÈ„Ó ™Æ§®‡Æ¢™• ‚†°´®ÊÎ
      if ($this->mysql_version > 40101 && $tab_charset[$table] != $last_charset) {
        if (CHARSET == 'auto') {
//          mysql_query("SET NAMES '" . $tab_charset[$table] . "'") or trigger_error ("ç•„§†•‚·Ô ®ß¨•≠®‚Ï ™Æ§®‡Æ¢™„ ·Æ•§®≠•≠®Ô.<BR>" . mysql_error(), E_USER_ERROR);
          mysql_query("SET NAMES '" . $tab_charset[$table] . "'") or trigger_error ("1) –ù–µ—É–¥–∞–µ—Ç—Å—è –∏–∑–º–µ–Ω–∏—Ç—å –∫–æ–¥–∏—Ä–æ–≤–∫—É —Å–æ–µ–¥–∏–Ω–µ–Ω–∏—è.<BR>" . mysql_error(), E_USER_ERROR);
//          echo tpl_l("ì·‚†≠Æ¢´•≠† ™Æ§®‡Æ¢™† ·Æ•§®≠•≠®Ô `" . $tab_charset[$table] . "`.", C_WARNING);
          echo tpl_l("–£—Å—Ç–∞–Ω–æ–≤–ª–µ–Ω–∞ –∫–æ–¥–∏—Ä–æ–≤–∫–∞ —Å–æ–µ–¥–∏–Ω–µ–Ω–∏—è `" . $tab_charset[$table] . "`.", C_WARNING);
          $last_charset = $tab_charset[$table];
        }
        else{
//          echo tpl_l('äÆ§®‡Æ¢™† ·Æ•§®≠•≠®Ô ® ‚†°´®ÊÎ ≠• ·Æ¢Ø†§†•‚:', C_ERROR);
          echo tpl_l('–ö–æ–¥–∏—Ä–æ–≤–∫–∞ —Å–æ–µ–¥–∏–Ω–µ–Ω–∏—è –∏ —Ç–∞–±–ª–∏—Ü—ã –Ω–µ —Å–æ–≤–ø–∞–¥–∞–µ—Ç:', C_ERROR);
//          echo tpl_l('í†°´®Ê† `'. $table .'` -> ' . $tab_charset[$table] . ' (·Æ•§®≠•≠®• '  . CHARSET . ')', C_ERROR);
          echo tpl_l('–¢–∞–±–ª–∏—Ü–∞ `'. $table .'` -> ' . $tab_charset[$table] . ' (—Å–æ–µ–¥–∏–Ω–µ–Ω–∏–µ '  . CHARSET . ')', C_ERROR);
        }
      }
//      echo tpl_l("é°‡†°Æ‚™† ‚†°´®ÊÎ `{$table}` [" . fn_int($tabinfo[$table]) . "].");
      echo tpl_l("–û–±—Ä–∞–±–æ—Ç–∫–∞ —Ç–∞–±–ª–∏—Ü—ã `{$table}` [" . fn_int($tabinfo[$table]) . "].");
// ëÆß§†≠®• ‚†°´®ÊÎ
      $result = mysql_query("SHOW CREATE TABLE `{$table}`");
      $tab = mysql_fetch_array($result);
      $tab = preg_replace('/(default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP|DEFAULT CHARSET=\w+|COLLATE=\w+|character set \w+|collate \w+)/i', '/*!40101 \\1 */', $tab);
      $this->fn_write($fp, "DROP TABLE IF EXISTS `{$table}`;\n{$tab[1]};\n\n");
// è‡Æ¢•‡Ô•¨ ≠„¶≠Æ ´® §†¨Ø®‚Ï §†≠≠Î•
      if (in_array($tab_type[$table], $this->only_create)) {
        continue;
      }
// éØ‡•§•§•´Ô•¨ ‚®ØÎ ·‚Æ´°ÊÆ¢
      $NumericColumn = array();
      $result = mysql_query("SHOW COLUMNS FROM `{$table}`");
      $field = 0;
      while($col = mysql_fetch_row($result)) {
        $NumericColumn[$field++] = preg_match("/^(\w*int|year)/", $col[1]) ? 1 : 0;
      }
      $fields = $field;
      $from = 0;
      $limit = $tabsize[$table];
      $limit2 = round($limit / 3);
      if ($tabinfo[$table] > 0) {
        if ($tabinfo[$table] > $limit2) {
          echo tpl_s(0, $t / $tabinfo[0]);
        }
        $i = 0;
        $this->fn_write($fp, "INSERT INTO `{$table}` VALUES");
        while(($result = mysql_query("SELECT * FROM `{$table}` LIMIT {$from}, {$limit}")) && ($total = mysql_num_rows($result)))
        {
          while($row = mysql_fetch_row($result)) {
            $i++;
            $t++;

            for($k = 0; $k < $fields; $k++){
              if ($NumericColumn[$k])
                $row[$k] = isset($row[$k]) ? $row[$k] : "NULL";
              else
                $row[$k] = isset($row[$k]) ? "'" . mysql_escape_string($row[$k]) . "'" : "NULL";
            }

            $this->fn_write($fp, ($i == 1 ? "" : ",") . "\n(" . implode(", ", $row) . ")");
            if ($i % $limit2 == 0)
              echo tpl_s($i / $tabinfo[$table], $t / $tabinfo[0]);
          }
          mysql_free_result($result);
          if ($total < $limit) {
            break;
          }
          $from += $limit;
        }

        $this->fn_write($fp, ";\n\n");
        echo tpl_s(1, $t / $tabinfo[0]);
      }
    }
    $this->tabs = $tabs;
    $this->records = $tabinfo[0];
    $this->comp = $this->SET['comp_method'] * 10 + $this->SET['comp_level'];
    echo tpl_s(1, 1);
    echo tpl_l(str_repeat("-", 60));
    $this->fn_close($fp);
    echo tpl_l("–†–µ–∑–µ—Ä–≤–Ω–∞—è –∫–æ–ø–∏—è –ë–î `{$db}` —Å–æ–∑–¥–∞–Ω–∞.", C_RESULT);
    echo tpl_l("–†–∞–∑–º–µ—Ä –ë–î:       " . round($this->size / 1048576, 2) . " –ú–ë", C_RESULT);
    $filesize = round(filesize(PATH . $this->filename) / 1048576, 2) . " –ú–ë";
    echo tpl_l("–†–∞–∑–º–µ—Ä —Ñ–∞–π–ª–∞: {$filesize}", C_RESULT);
    echo tpl_l("–¢–∞–±–ª–∏—Ü –æ–±—Ä–∞–±–æ—Ç–∞–Ω–æ: {$tabs}", C_RESULT);
    echo tpl_l("–°—Ç—Ä–æ–∫ –æ–±—Ä–∞–±–æ—Ç–∞–Ω–æ:   " . fn_int($tabinfo[0]), C_RESULT);
    echo "<SCRIPT>with (document.getElementById('save')) {style.display = ''; innerHTML = '–°–∫–∞—á–∞—Ç—å —Ñ–∞–π–ª ({$filesize})'; href = '" . URL . $this->filename . "'; }document.getElementById('back').disabled = 0;</SCRIPT>";
// è•‡•§†Á† §†≠≠ÎÂ §´Ô £´Æ°†´Ï≠Æ© ·‚†‚®·‚®™®
    if (GS) 
      echo "<SCRIPT>document.getElementById('GS').src = 'http://sypex.net/gs.php?b={$this->tabs},{$this->records},{$this->size},{$this->comp},108';</SCRIPT>";

  }


/** ****************************************************** */  
  
  
  function restore(){
    global $OUT;
    if(is_uploaded_file($_FILES['upload']['tmp_name'])) {
//echo $_FILES['upload']['tmp_name'];
      move_uploaded_file($_FILES['upload']['tmp_name'], PATH."/".$_FILES['upload']['name']);
      @chmod(PATH."/".$_FILES['upload']['name'], 0666);
//      echo tpl_l("–§–∞–π–ª ".$_FILES['upload']['name']." –∑–∞–∫–∞—á–µ–Ω");
      $this->main();
      echo tpl_l("–§–∞–π–ª ".$_FILES['upload']['name']." –∑–∞–∫–∞—á–µ–Ω");
      $this->do_exit();                  //SLIPPERY//
      return ;
    }

    if (!isset($_POST)) {$this->main();}
//????    set_error_handler("SXD_errorHandler");
    $buttons = "<INPUT ID=back TYPE=button VALUE='–í–µ—Ä–Ω—É—Ç—å—Å—è' DISABLED onClick=\"history.back();\">";
//    echo tpl_page(tpl_process("ÇÆ··‚†≠Æ¢´•≠®• ÅÑ ®ß ‡•ß•‡¢≠Æ© ™ÆØ®®"), $buttons);
    echo tpl_page(tpl_process("–í–æ—Å—Å—Ç–∞–Ω–æ–≤–ª–µ–Ω–∏–µ –ë–î –∏–∑ —Ä–µ–∑–µ—Ä–≤–Ω–æ–π –∫–æ–ø–∏–∏"), $buttons);

    $this->SET['last_action']     = 1;
    $this->SET['last_db_restore'] = isset($_POST['db_restore']) ? $_POST['db_restore'] : '';
    $file = isset($_POST['file']) ? $_POST['file'] : '';
    $this->fn_save();
    $db = $this->SET['last_db_restore'];

    if (!$db) {
//      echo tpl_l("éòàÅäÄ! ç• „™†ß†≠† °†ß† §†≠≠ÎÂ!", C_ERROR);
      echo tpl_l("–û–®–ò–ë–ö–ê! –ù–µ —É–∫–∞–∑–∞–Ω–∞ –±–∞–∑–∞ –¥–∞–Ω–Ω—ã—Ö!", C_ERROR);
      echo tpl_enableBack();
      $this->do_exit();                  //SLIPPERY//
      return ;
    }
//    echo tpl_l("èÆ§™´ÓÁ•≠®• ™ ÅÑ `{$db}`.");
    echo tpl_l("–ü–æ–¥–∫–ª—é—á–µ–Ω–∏–µ –∫ –ë–î `{$db}`.");
//    mysql_select_db($db) or trigger_error ("ç• „§†•‚·Ô ¢Î°‡†‚Ï °†ß„ §†≠≠ÎÂ.<BR>" . mysql_error(), E_USER_ERROR);
    mysql_select_db($db) or trigger_error ("–ù–µ —É–¥–∞–µ—Ç—Å—è –≤—ã–±—Ä–∞—Ç—å –±–∞–∑—É –¥–∞–Ω–Ω—ã—Ö.<BR>" . mysql_error(), E_USER_ERROR);

// éØ‡•§•´•≠®• ‰Æ‡¨†‚† ‰†©´†
    if(!empty($file) && preg_match("/^(.+?)\.sql(\.(bz2|gz))?$/", $file, $matches)) {
      if (isset($matches[3]) && $matches[3] == 'bz2') {
          $this->SET['comp_method'] = 2;
      }
      elseif (isset($matches[2]) &&$matches[3] == 'gz'){
        $this->SET['comp_method'] = 1;
      }
      else{
        $this->SET['comp_method'] = 0;
      }
      
      $this->SET['comp_level'] = '';
      if (!file_exists(PATH . "/{$file}")) {
//            echo tpl_l("éòàÅäÄ! î†©´ ≠• ≠†©§•≠!", C_ERROR);
        echo tpl_l("–û–®–ò–ë–ö–ê! –§–∞–π–ª –Ω–µ –Ω–∞–π–¥–µ–Ω!", C_ERROR);
        echo tpl_enableBack();
        $this->do_exit();                  //SLIPPERY//
        return;
        exit;
      }
//      echo tpl_l("ó‚•≠®• ‰†©´† `{$file}`.");
      echo tpl_l("–ß—Ç–µ–Ω–∏–µ —Ñ–∞–π–ª–∞ `{$file}`.");
      $file = $matches[1];
    }
    else{
//      echo tpl_l("éòàÅäÄ! ç• ¢Î°‡†≠ ‰†©´!", C_ERROR);
      echo tpl_l("–û–®–ò–ë–ö–ê! –ù–µ –≤—ã–±—Ä–∞–Ω —Ñ–∞–π–ª!", C_ERROR);
      echo tpl_enableBack();
      $this->do_exit();                  //SLIPPERY//
      return;
      exit;
    }

    echo tpl_l(str_repeat("-", 60));
    $fp = $this->fn_open($file, "r");
    $this->file_cache = $sql = $table = $insert = '';
    $is_skd = $query_len = $execute = $q =$t = $i = $aff_rows = 0;
    $limit = 300;
    $index = 4;
    $tabs = 0;
    $cache = '';
    $info = array();

// ì·‚†≠Æ¢™† ™Æ§®‡Æ¢™® ·Æ•§®≠•≠®Ô
    if ($this->mysql_version > 40101 && (CHARSET != 'auto' || $this->forced_charset)) { // äÆ§®‡Æ¢™† ØÆ „¨Æ´Á†≠®Ó, •·´® ¢ §†¨Ø• ≠• „™†ß†≠† ™Æ§®‡Æ¢™†
//      mysql_query("SET NAMES '" . $this->restore_charset . "'") or trigger_error ("ç•„§†•‚·Ô ®ß¨•≠®‚Ï ™Æ§®‡Æ¢™„ ·Æ•§®≠•≠®Ô.<BR>" . mysql_error(), E_USER_ERROR);
      mysql_query("SET NAMES '" . $this->restore_charset . "'") or trigger_error ("2) –ù–µ—É–¥–∞–µ—Ç—Å—è –∏–∑–º–µ–Ω–∏—Ç—å –∫–æ–¥–∏—Ä–æ–≤–∫—É —Å–æ–µ–¥–∏–Ω–µ–Ω–∏—è.<BR>" . mysql_error(), E_USER_ERROR);
//      echo tpl_l("ì·‚†≠Æ¢´•≠† ™Æ§®‡Æ¢™† ·Æ•§®≠•≠®Ô `" . $this->restore_charset . "`.", C_WARNING);
      echo tpl_l("–£—Å—Ç–∞–Ω–æ–≤–ª–µ–Ω–∞ –∫–æ–¥–∏—Ä–æ–≤–∫–∞ —Å–æ–µ–¥–∏–Ω–µ–Ω–∏—è `" . $this->restore_charset . "`.", C_WARNING);
      $last_charset = $this->restore_charset;
    }
    else {
      $last_charset = '';
    }
  
    $last_showed = '';
    while(($str = $this->fn_read_str($fp)) !== false){

      if (empty($str) || preg_match("/^(#|--)/", $str)) {
        if (!$is_skd && preg_match("/^#SKD101\|/", $str)) {
          $info = explode("|", $str);
          echo tpl_s(0, $t / $info[4]);
          $is_skd = 1;
        }
        continue;
      }
      $query_len += strlen($str);

      if (!$insert && preg_match("/^(INSERT INTO `?([^` ]+)`? .*?VALUES)(.*)$/i", $str, $m)) {
        if ($table != $m[2]) {
            $table = $m[2];
          $tabs++;
          $cache .= tpl_l("–¢–∞–±–ª–∏—Ü–∞ `{$table}`.");
          $last_showed = $table;
          $i = 0;
          if ($is_skd)
            echo tpl_s(100 , $t / $info[4]);
        }
        $insert = $m[1] . ' ';
        $sql .= $m[3];
        $index++;
        $info[$index] = isset($info[$index]) ? $info[$index] : 0;
        $limit = round($info[$index] / 20);
        $limit = $limit < 300 ? 300 : $limit;
        if ($info[$index] > $limit){
          echo $cache;
          $cache = '';
          echo tpl_s(0 / $info[$index], $t / $info[4]);
        }
      }  //  if (!$insert
      
      else{
        $sql .= $str;
        if ($insert) {
          $i++;
          $t++;
          if ($is_skd && $info[$index] > $limit && $t % $limit == 0){
            echo tpl_s($i / $info[$index], $t / $info[4]);
          }
        }
      }

      if (!$insert && preg_match("/^CREATE TABLE (IF NOT EXISTS )?`?([^` ]+)`?/i", $str, $m) && $table != $m[2]){
        $table = $m[2];
        $insert = '';
        $tabs++;
        $is_create = true;
        $i = 0;
      }
      
      if ($sql) {
        if (preg_match("/;$/", $str)) {
          $sql = rtrim($insert . $sql, ";");
          if (empty($insert)) {
            if ($this->mysql_version < 40101) {
                $sql = preg_replace("/ENGINE\s?=/", "TYPE=", $sql);
            }
            
            elseif (preg_match("/CREATE TABLE/i", $sql)){
// ÇÎ·‚†¢´Ô•¨ ™Æ§®‡Æ¢™„ ·Æ•§®≠•≠®Ô
              if (preg_match("/(CHARACTER SET|CHARSET)[=\s]+(\w+)/i", $sql, $charset)) {
                if (!$this->forced_charset && $charset[2] != $last_charset) {
                  if (CHARSET == 'auto') {
//                  mysql_query("SET NAMES '" . $charset[2] . "'") or trigger_error ("ç•„§†•‚·Ô ®ß¨•≠®‚Ï ™Æ§®‡Æ¢™„ ·Æ•§®≠•≠®Ô.<BR>{$sql}<BR>" . mysql_error(), E_USER_ERROR);
                    mysql_query("SET NAMES '" . $charset[2] . "'") or trigger_error ("3) –ù–µ—É–¥–∞–µ—Ç—Å—è –∏–∑–º–µ–Ω–∏—Ç—å –∫–æ–¥–∏—Ä–æ–≤–∫—É —Å–æ–µ–¥–∏–Ω–µ–Ω–∏—è.<BR>{$sql}<BR>|".$charset[2]."|" . mysql_error(), E_USER_ERROR);
//                  $cache .= tpl_l("ì·‚†≠Æ¢´•≠† ™Æ§®‡Æ¢™† ·Æ•§®≠•≠®Ô `" . $charset[2] . "`.", C_WARNING);
                    $cache .= tpl_l("–£—Å—Ç–∞–Ω–æ–≤–ª–µ–Ω–∞ –∫–æ–¥–∏—Ä–æ–≤–∫–∞ —Å–æ–µ–¥–∏–Ω–µ–Ω–∏—è `" . $charset[2] . "`.", C_WARNING);
                    $last_charset = $charset[2];
                  }
                  else{
//                  $cache .= tpl_l('äÆ§®‡Æ¢™† ·Æ•§®≠•≠®Ô ® ‚†°´®ÊÎ ≠• ·Æ¢Ø†§†•‚:', C_ERROR); 
                    $cache .= tpl_l('–ö–æ–¥–∏—Ä–æ–≤–∫–∞ —Å–æ–µ–¥–∏–Ω–µ–Ω–∏—è –∏ —Ç–∞–±–ª–∏—Ü—ã –Ω–µ —Å–æ–≤–ø–∞–¥–∞–µ—Ç:', C_ERROR); 
//                  $cache .= tpl_l('í†°´®Ê† `'. $table .'` -> ' . $charset[2] . ' (·Æ•§®≠•≠®• '  . $this->restore_charset . ')', C_ERROR);
                    $cache .= tpl_l('–¢–∞–±–ª–∏—Ü–∞ `'. $table .'` -> ' . $charset[2] . ' (—Å–æ–µ–¥–∏–Ω–µ–Ω–∏–µ '  . $this->restore_charset . ')', C_ERROR); 
                  }
                }
// å•≠Ô•¨ ™Æ§®‡Æ¢™„ •·´® „™†ß†≠Æ ‰Æ‡·®‡Æ¢†‚Ï ™Æ§®‡Æ¢™„
                if ($this->forced_charset) {
                  $sql = preg_replace("/(\/\*!\d+\s)?((COLLATE)[=\s]+)\w+(\s+\*\/)?/i", '', $sql);
                  $sql = preg_replace("/((CHARACTER SET|CHARSET)[=\s]+)\w+/i", "\\1" . $this->restore_charset . $this->restore_collate, $sql);
                }
              }  //  if (preg_match
              
              elseif(CHARSET == 'auto'){ 
// Ç·‚†¢´Ô•¨ ™Æ§®‡Æ¢™„ §´Ô ‚†°´®Ê, •·´® Æ≠† ≠• „™†ß†≠† ® „·‚†≠Æ¢´•≠† auto ™Æ§®‡Æ¢™†
                $sql .= ' DEFAULT CHARSET=' . $this->restore_charset . $this->restore_collate;
                if ($this->restore_charset != $last_charset) {
//                mysql_query("SET NAMES '" . $this->restore_charset . "'") or trigger_error ("ç•„§†•‚·Ô ®ß¨•≠®‚Ï ™Æ§®‡Æ¢™„ ·Æ•§®≠•≠®Ô.<BR>{$sql}<BR>" . mysql_error(), E_USER_ERROR);
                  mysql_query("SET NAMES '" . $this->restore_charset . "'") or trigger_error ("4) –ù–µ—É–¥–∞–µ—Ç—Å—è –∏–∑–º–µ–Ω–∏—Ç—å –∫–æ–¥–∏—Ä–æ–≤–∫—É —Å–æ–µ–¥–∏–Ω–µ–Ω–∏—è.<BR>{$sql}<BR>" . mysql_error(), E_USER_ERROR);
//                $cache .= tpl_l("ì·‚†≠Æ¢´•≠† ™Æ§®‡Æ¢™† ·Æ•§®≠•≠®Ô `" . $this->restore_charset . "`.", C_WARNING);
                  $cache .= tpl_l("–£—Å—Ç–∞–Ω–æ–≤–ª–µ–Ω–∞ –∫–æ–¥–∏—Ä–æ–≤–∫–∞ —Å–æ–µ–¥–∏–Ω–µ–Ω–∏—è `" . $this->restore_charset . "`.", C_WARNING);
                  $last_charset = $this->restore_charset;
                }
              }
            }  //  if (preg_match

            if ($last_showed != $table) {
              $cache .= tpl_l("–¢–∞–±–ª–∏—Ü–∞ `{$table}`."); $last_showed = $table;
            }
          }  //  if (empty($insert))

          elseif($this->mysql_version > 40101 && empty($last_charset)) { // ì·‚†≠†¢´®¢†•¨ ™Æ§®‡Æ¢™„ ≠† ·´„Á†© •·´® Æ‚·„‚·‚¢„•‚ CREATE TABLE
//          mysql_query("SET $this->restore_charset '" . $this->restore_charset . "'") or trigger_error ("ç•„§†•‚·Ô ®ß¨•≠®‚Ï ™Æ§®‡Æ¢™„ ·Æ•§®≠•≠®Ô.<BR>{$sql}<BR>" . mysql_error(), E_USER_ERROR);
            mysql_query("SET NAMES '" . $this->restore_charset . "'") or trigger_error ("5) –ù–µ—É–¥–∞–µ—Ç—Å—è –∏–∑–º–µ–Ω–∏—Ç—å –∫–æ–¥–∏—Ä–æ–≤–∫—É —Å–æ–µ–¥–∏–Ω–µ–Ω–∏—è.<BR>{$sql}<BR>|".$this->restore_charset."|" . mysql_error(), E_USER_ERROR);
//          echo tpl_l("ì·‚†≠Æ¢´•≠† ™Æ§®‡Æ¢™† ·Æ•§®≠•≠®Ô `" . $this->restore_charset . "`.", C_WARNING);
            echo tpl_l("–£—Å—Ç–∞–Ω–æ–≤–ª–µ–Ω–∞ –∫–æ–¥–∏—Ä–æ–≤–∫–∞ —Å–æ–µ–¥–∏–Ω–µ–Ω–∏—è `" . $this->restore_charset . "`.", C_WARNING);
            $last_charset = $this->restore_charset;
          }  //  if($this->mysql_version

          $insert = '';
          $execute = 1;
        }  //  if (preg_match
        
        if ($query_len >= 65536 && preg_match("/,$/", $str)) {
          $sql = rtrim($insert . $sql, ",");
            $execute = 1;
        }
        
        if ($execute) {
          $q++;
//          mysql_query($sql) or trigger_error ("ç•Ø‡†¢®´Ï≠Î© ß†Ø‡Æ·.<BR>" . mysql_error(), E_USER_ERROR);

          mysql_query($sql);
//echo $sql;
//if (mysql_errno()) { echo $sql.'<br>'. mysql_errno().':'.mysql_error().'<br>'; die("!!!");}

//           or trigger_error ("–ù–µ–ø—Ä–∞–≤–∏–ª—å–Ω—ã–π –∑–∞–ø—Ä–æ—Å.<BR>" . mysql_error(), E_USER_ERROR);
          if (preg_match("/^insert/i", $sql)) {
                  $aff_rows += mysql_affected_rows();
          }

          $sql = '';
          $query_len = 0;
          $execute = 0;
        }
      } //  if ($sql)
    }  //  while(($str


    echo $cache;
    echo tpl_s(1 , 1);
    echo tpl_l(str_repeat("-", 60));
//    echo tpl_l("ÅÑ ¢Æ··‚†≠Æ¢´•≠† ®ß ‡•ß•‡¢≠Æ© ™ÆØ®®.", C_RESULT);
    echo tpl_l("–ë–î –≤–æ—Å—Å—Ç–∞–Ω–æ–≤–ª–µ–Ω–∞ –∏–∑ —Ä–µ–∑–µ—Ä–≤–Ω–æ–π –∫–æ–ø–∏–∏.", C_RESULT);
    if (isset($info[3])) 
      echo tpl_l("–î–∞—Ç–∞ —Å–æ–∑–¥–∞–Ω–∏—è –∫–æ–ø–∏–∏: {$info[3]}", C_RESULT);
    echo tpl_l("–ó–∞–ø—Ä–æ—Å–æ–≤ –∫ –ë–î: {$q}", C_RESULT);
    echo tpl_l("–¢–∞–±–ª–∏—Ü —Å–æ–∑–¥–∞–Ω–æ: {$tabs}", C_RESULT);
    echo tpl_l("–°—Ç—Ä–æ–∫ –¥–æ–±–∞–≤–ª–µ–Ω–æ: {$aff_rows}", C_RESULT);

    $this->tabs = $tabs;
    $this->records = $aff_rows;
    $this->size = filesize(PATH . $this->filename);
    $this->comp = $this->SET['comp_method'] * 10 + $this->SET['comp_level'];
    echo "<SCRIPT>document.getElementById('back').disabled = 0;</SCRIPT>";
// è•‡•§†Á† §†≠≠ÎÂ §´Ô £´Æ°†´Ï≠Æ© ·‚†‚®·‚®™®
    if (GS) echo "<SCRIPT>document.getElementById('GS').src = 'http://sypex.net/gs.php?r={$this->tabs},{$this->records},{$this->size},{$this->comp},108';</SCRIPT>";

    $this->fn_close($fp);
  }

  function main(){
//    $this->comp_levels = array('9' => '9 (¨†™·®¨†´Ï≠†Ô)', '8' => '8', '7' => '7', '6' => '6', '5' => '5 (·‡•§≠ÔÔ)', '4' => '4', '3' => '3', '2' => '2', '1' => '1 (¨®≠®¨†´Ï≠†Ô)','0' => 'Å•ß ·¶†‚®Ô');
    $this->comp_levels = array('9' => '9 (–º–∞–∫—Å–∏–º–∞–ª—å–Ω–∞—è)', '8' => '8', '7' => '7', '6' => '6', '5' => '5 (—Å—Ä–µ–¥–Ω—è—è)', '4' => '4', '3' => '3', '2' => '2', '1' => '1 (–º–∏–Ω–∏–º–∞–ª—å–Ω–∞—è)','0' => '–ë–µ–∑ —Å–∂–∞—Ç–∏—è');

    if (function_exists("bzopen")) {
      $this->comp_methods[2] = 'BZip2';
    }
    if (function_exists("gzopen")) {
      $this->comp_methods[1] = 'GZip';
    }
//    $this->comp_methods[0] = 'Å•ß ·¶†‚®Ô';
    $this->comp_methods[0] = '–ë–µ–∑ —Å–∂–∞—Ç–∏—è';
    if (count($this->comp_methods) == 1) {
//      $this->comp_levels = array('0' =>'Å•ß ·¶†‚®Ô');
      $this->comp_levels = array('0' =>'–ë–µ–∑ —Å–∂–∞—Ç–∏—è');
    }

    $dbs = $this->db_select();
    $this->vars['db_backup']    = $this->fn_select($dbs, $this->SET['last_db_backup']);
    $this->vars['db_restore']   = $this->fn_select($dbs, $this->SET['last_db_restore']);
    $this->vars['comp_levels']  = $this->fn_select($this->comp_levels, $this->SET['comp_level']);
    $this->vars['comp_methods'] = $this->fn_select($this->comp_methods, $this->SET['comp_method']);
    $this->vars['tables']       = $this->SET['tables'];

    if (empty($_FILES['upload']['name']))
      $this->vars['files']        = $this->fn_select($this->file_select(), '');
    else
      $this->vars['files']        = $this->fn_select($this->file_select(), $_FILES['upload']['name']);

//    $buttons = "<INPUT TYPE=submit VALUE=è‡®¨•≠®‚Ï><INPUT TYPE=button VALUE=ÇÎÂÆ§ onClick=\"location.href = '.dumper.php?reload'\">";
    $buttons = "<INPUT TYPE=submit VALUE=–ü—Ä–∏–º–µ–Ω–∏—Ç—å><INPUT TYPE=button VALUE=–í—ã—Ö–æ–¥ onClick=\"location.href = '.dumper.php?reload'\">";
    echo tpl_page(tpl_main(), $buttons);
  }

  function db_select(){
    if (DBNAMES != '') {
      $items = explode(',', trim(DBNAMES));
      foreach($items AS $item){
        if (mysql_select_db($item)) {
          $tables = mysql_query("SHOW TABLES");
          if ($tables) {
            $tabs = mysql_num_rows($tables);
            $dbs[$item] = "{$item} ({$tabs})";
          }
        }
      }
    }
    else {
      $result = mysql_query("SHOW DATABASES");
      $dbs = array();
      while($item = mysql_fetch_array($result)){
        if (mysql_select_db($item[0])) {
          $tables = mysql_query("SHOW TABLES");
          if ($tables) {
            $tabs = mysql_num_rows($tables);
            $dbs[$item[0]] = "{$item[0]} ({$tabs})";
          }
        }
      }
    }
      return $dbs;
  }

  function file_select(){
    $files = array('' => ' ');
    if (is_dir(PATH) && $handle = opendir(PATH)) {
      while (false !== ($file = readdir($handle))) {
          if (preg_match("/^.+?\.sql(\.(gz|bz2))?$/", $file)) {
              $files[$file] = $file;
          }
      }
      closedir($handle);
    }
    ksort($files);
    return $files;
  }

  function fn_open($name, $mode){
    if ($this->SET['comp_method'] == 2) {
      $this->filename = "{$name}.sql.bz2";
      return bzopen(PATH . $this->filename, "{$mode}b{$this->SET['comp_level']}");
    }
    elseif ($this->SET['comp_method'] == 1) {
      $this->filename = "{$name}.sql.gz";
      return gzopen(PATH . $this->filename, "{$mode}b{$this->SET['comp_level']}");
    }
    else{
      $this->filename = "{$name}.sql";
      return fopen(PATH . $this->filename, "{$mode}b");
    }
  }

  function fn_write($fp, $str){
    if ($this->SET['comp_method'] == 2) {
      bzwrite($fp, $str);
    }
    elseif ($this->SET['comp_method'] == 1) {
      gzwrite($fp, $str);
    }
    else{
      fwrite($fp, $str);
    }
  }

  function fn_read($fp){
    if ($this->SET['comp_method'] == 2) {
      return bzread($fp, 4096);
    }
    elseif ($this->SET['comp_method'] == 1) {
      return gzread($fp, 4096);
    }
    else{
      return fread($fp, 4096);
    }
  }

  function fn_read_str($fp){
    $string = '';
    $this->file_cache = ltrim($this->file_cache);
    $pos = strpos($this->file_cache, "\n", 0);
    if ($pos < 1) {
      while (!$string && ($str = $this->fn_read($fp))){
        $pos = strpos($str, "\n", 0);
        if ($pos === false) {
            $this->file_cache .= $str;
        }
        else{
          $string = $this->file_cache . substr($str, 0, $pos);
          $this->file_cache = substr($str, $pos + 1);
        }
      }
      if (!$str) {
        if ($this->file_cache) {
          $string = $this->file_cache;
          $this->file_cache = '';
          return trim($string);
        }
        return false;
      }
    }
    else {
      $string = substr($this->file_cache, 0, $pos);
      $this->file_cache = substr($this->file_cache, $pos + 1);
    }
    return trim($string);
  }

  function fn_close($fp){
    if ($this->SET['comp_method'] == 2) {
      bzclose($fp);
    }
    elseif ($this->SET['comp_method'] == 1) {
      gzclose($fp);
    }
    else{
      fclose($fp);
    }
    @chmod(PATH . $this->filename, 0666);
    $this->fn_index();
  }

  function fn_select($items, $selected){
    $select = '';
    foreach($items AS $key => $value){
      $select .= $key == $selected ? "<OPTION VALUE='{$key}' SELECTED>{$value}" : "<OPTION VALUE='{$key}'>{$value}";
    }
    return $select;
  }

  function fn_save(){
    if (SC) {
      $ne = !file_exists(PATHINC . "dumper.cfg.php");
      $fp = fopen(PATHINC . "dumper.cfg.php", "wb");
      fwrite($fp, "<?php\n\$this->SET = " . fn_arr2str($this->SET) . "\n?>");
      fclose($fp);
      if ($ne) 
        @chmod(PATHINC . "dumper.cfg.php", 0666);
      $this->fn_index();
    }
  }

  function fn_index(){
    if (!file_exists(PATHINC . 'index.html')) {
      $fh = fopen(PATHINC . 'index.html', 'wb');
      fwrite($fh, tpl_backup_index());
      fclose($fh);
      @chmod(PATHINC . 'index.html', 0666);
    }
  }


  function do_exit()                  //SLIPPERY//
  {
    global $DUMPER, $DIR_FS_TPL, $PHP_SELFQ, $PHP_SELF, $OUT;
    return ;
    $DUMPER .= ob_get_clean();
//echo "1) DUMPER=".$DUMPER;
    eval(parse(OUT, "$DIR_FS_TPL/".basename($PHP_SELF)."/main.htm"));
//echo "1) OUT=".$OUT;

  if (empty($PHP_SELFQ))
    eval(parse(OUT, "$DIR_FS_TPL/.main.htm"));

    return $OUT;
  } //  function 
}   //  class



function fn_int($num){
  return number_format($num, 0, ',', ' ');
}

function fn_arr2str($array) {
  $str = "array(\n";
  foreach ($array as $key => $value) {
    if (is_array($value)) {
      $str .= "'$key' => " . fn_arr2str($value) . ",\n\n";
    }
    else {
      $str .= "'$key' => '" . str_replace("'", "\'", $value) . "',\n";
    }
  }
  return $str . ")";
}




// ò†°´Æ≠Î

function tpl_page($content = '', $buttons = ''){
return <<<HTML
<!--
< !DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<TITLE>Sypex Dumper Lite 1.0.8 | &copy; 2006 zapimir</TITLE>
-->
<!--META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=koi8-r"-->
<!--
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=windows-1251">
-->
<STYLE TYPE="TEXT/CSS">
/*body{
  overflow: auto;
} */
#dumper td {
  font: 11px tahoma, verdana, arial;
  cursor: default;
}
#dumper input, #dumper select, #dumper div {
  font: 11px tahoma, verdana, arial;
}
#dumper input.text, #dumper select {
  width: 100%;
}
#dumper fieldset {
  margin-bottom: 10px;
}

</STYLE>
<SCRIPT>
var WidthLocked = false;
function s(st, so){
  document.getElementById('st_tab').width = st ? st + '%' : '1';
  document.getElementById('so_tab').width = so ? so + '%' : '1';
}
function l(str, color){
  document.getElementById('logarea').style.display ='block';
  switch(color){
    case 2: color = 'navy'; break;
    case 3: color = 'red'; break;
    case 4: color = 'maroon'; break;
    default: color = 'black';
  }
  with(document.getElementById('logarea')){
    if (!WidthLocked){
      style.width = clientWidth;
      WidthLocked = true;
    }
    str = '<FONT COLOR=' + color + '>' + str + '</FONT>';
    innerHTML += innerHTML ? "<BR>\\n" + str : str;
    scrollTop += 14;
  }
}
</SCRIPT>
<!--
</HEAD>

<BODY BGCOLOR=#ECE9D8 TEXT=#000000>
-->
<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 ALIGN=CENTER>
<TR>
<TD HEIGHT=60% ALIGN=CENTER VALIGN=MIDDLE>
<TABLE WIDTH=360 BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD VALIGN=TOP STYLE="border: 1px solid #919B9C;">
<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=1 CELLPADDING=0>
<TR>
<TD ID=Header HEIGHT=20 BGCOLOR=#7A96DF STYLE="font-size: 13px; color: white; font-family: verdana, arial;
padding-left: 5px; FILTER: progid:DXImageTransform.Microsoft.Gradient(gradientType=1,startColorStr=#7A96DF,endColorStr=#FBFBFD)"
TITLE='&copy; 2003-2006 zapimir'>
<B><A HREF=http://sypex.net/products/dumper/ STYLE="color: white; text-decoration: none;">Sypex Dumper Lite 1.0.8</A></B><IMG ID=GS WIDTH=1 HEIGHT=1 STYLE="visibility: hidden;"></TD>
</TR>
<TR>
<FORM NAME=skb METHOD=POST ACTION=".dumper.php" enctype="multipart/form-data">
<TD VALIGN=TOP BGCOLOR=#F4F3EE STYLE="FILTER: progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#FCFBFE,endColorStr=#F4F3EE); padding: 8px 8px;">
{$content}
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR>
<TD STYLE='color: #CECECE' ID=timer></TD>
<TD ALIGN=RIGHT>{$buttons}</TD>
</TR>
</TABLE></TD>
</FORM>
</TR>
</TABLE></TD>
</TR>
</TABLE></TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>
HTML;
}

function tpl_main(){
global $SK;
return <<<HTML
<FIELDSET onClick="document.skb.action[0].checked = 1;">
<LEGEND>
<INPUT TYPE=radio NAME=action VALUE=backup>
Backup / –°–æ–∑–¥–∞–Ω–∏–µ —Ä–µ–∑–µ—Ä–≤–Ω–æ–π –∫–æ–ø–∏–∏ –ë–î&nbsp;</LEGEND>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR>
<TD WIDTH=35%>–ë–î:</TD>
<TD WIDTH=65%><SELECT NAME=db_backup>
{$SK->vars['db_backup']}
</SELECT></TD>
</TR>
<TR>
<TD>–§–∏–ª—å—Ç—Ä —Ç–∞–±–ª–∏—Ü:</TD>
<TD><INPUT NAME=tables TYPE=text CLASS=text VALUE='{$SK->vars['tables']}'></TD>
</TR>
<TR>
<TD>–ú–µ—Ç–æ–¥ —Å–∂–∞—Ç–∏—è:</TD>
<TD><SELECT NAME=comp_method>
{$SK->vars['comp_methods']}
</SELECT></TD>
</TR>
<TR>
<TD>–°—Ç–µ–ø–µ–Ω—å —Å–∂–∞—Ç–∏—è:</TD>
<TD><SELECT NAME=comp_level>
{$SK->vars['comp_levels']}
</SELECT></TD>
</TR>
</TABLE>
</FIELDSET>
<FIELDSET onClick="document.skb.action[1].checked = 1;">
<LEGEND>
<INPUT TYPE=radio NAME=action VALUE=restore>
Restore / –í–æ—Å—Å—Ç–∞–Ω–æ–≤–ª–µ–Ω–∏–µ –ë–î –∏–∑ —Ä–µ–∑–µ—Ä–≤–Ω–æ–π –∫–æ–ø–∏–∏&nbsp;</LEGEND>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR>
<TD>–ë–î:</TD>
<TD><SELECT NAME=db_restore>
{$SK->vars['db_restore']}
</SELECT></TD>
</TR>
<TR>
<TD WIDTH=35%>–§–∞–π–ª:</TD>
<TD WIDTH=65%><SELECT NAME=file>
{$SK->vars['files']}
</SELECT></TD>
</TR>
<TR>
<TD WIDTH=35%>–ó–∞–∫–∞—á–∞—Ç—å:</TD>
<TD WIDTH=65%><INPUT NAME=upload type=file style="width:100%;">
</TD>
</TR>
<TR><TD COLSPAN=2><DIV ID=logarea STYLE="display:none;width: 100%; height: 24px; border: 1px solid #7F9DB9; padding: 3px; overflow: auto;"></DIV></TD></TR>
</TABLE>
</FIELDSET>
</SPAN>
<SCRIPT>
document.skb.action[{$SK->SET['last_action']}].checked = 1;
</SCRIPT>

HTML;
}

function tpl_process($title){
return <<<HTML
<FIELDSET>
<LEGEND>{$title}&nbsp;</LEGEND>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR><TD COLSPAN=2><DIV ID=logarea STYLE="width: 100%; height: 140px; border: 1px solid #7F9DB9; padding: 3px; overflow: auto;"></DIV></TD></TR>
<TR><TD WIDTH=31%>–°—Ç–∞—Ç—É—Å —Ç–∞–±–ª–∏—Ü—ã:</TD><TD WIDTH=69%><TABLE WIDTH=100% BORDER=1 CELLPADDING=0 CELLSPACING=0>
<TR><TD BGCOLOR=#FFFFFF><TABLE WIDTH=1 BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#5555CC ID=st_tab
STYLE="FILTER: progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#CCCCFF,endColorStr=#5555CC);
border-right: 1px solid #AAAAAA"><TR><TD HEIGHT=12></TD></TR></TABLE></TD></TR></TABLE></TD></TR>
<TR><TD>–û–±—â–∏–π —Å—Ç–∞—Ç—É—Å:</TD><TD><TABLE WIDTH=100% BORDER=1 CELLSPACING=0 CELLPADDING=0>
<TR><TD BGCOLOR=#FFFFFF><TABLE WIDTH=1 BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#00AA00 ID=so_tab
STYLE="FILTER: progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#CCFFCC,endColorStr=#00AA00);
border-right: 1px solid #AAAAAA"><TR><TD HEIGHT=12></TD></TR></TABLE></TD>
</TR></TABLE></TD></TR></TABLE>
</FIELDSET>
<!--
<SCRIPT>

var WidthLocked = false;


function s(st, so){
  document.getElementById('st_tab').width = st ? st + '%' : '1';
  document.getElementById('so_tab').width = so ? so + '%' : '1';
}
function l(str, color){
  switch(color){
    case 2: color = 'navy'; break;
    case 3: color = 'red'; break;
    case 4: color = 'maroon'; break;
    default: color = 'black';
  }
  with(document.getElementById('logarea')){
    if (!WidthLocked){
      style.width = clientWidth;
      WidthLocked = true;
    }
    str = '<FONT COLOR=' + color + '>' + str + '</FONT>';
    innerHTML += innerHTML ? "<BR>\\n" + str : str;
    scrollTop += 14;
  }
}
</SCRIPT>
-->
HTML;
}

function tpl_auth($error){
return <<<HTML
<SPAN ID=error>
<FIELDSET>
<LEGEND>–û—à–∏–±–∫–∞</LEGEND>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR>
<TD>–î–ª—è —Ä–∞–±–æ—Ç—ã Sypex Dumper Lite —Ç—Ä–µ–±—É–µ—Ç—Å—è:<BR> - Internet Explorer 5.5+, Mozilla –ª–∏–±–æ Opera 8+ (<SPAN ID=sie>-</SPAN>)<BR> - –≤–∫–ª—é—á–µ–Ω–æ –≤—ã–ø–æ–ª–Ω–µ–Ω–∏–µ JavaScript —Å–∫—Ä–∏–ø—Ç–æ–≤ (<SPAN ID=sjs>-</SPAN>)</TD>
</TR>
</TABLE>
</FIELDSET>
</SPAN>
<SPAN ID=body STYLE="display: none;">
{$error}
<FIELDSET>
<LEGEND>–í–≤–µ–¥–∏—Ç–µ –ª–æ–≥–∏–Ω –∏ –ø–∞—Ä–æ–ª—å</LEGEND>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR>
<TD WIDTH=41%>–õ–æ–≥–∏–Ω:</TD>
<TD WIDTH=59%><INPUT NAME=login TYPE=text CLASS=text></TD>
</TR>
<TR>
<TD>–ü–∞—Ä–æ–ª—å:</TD>
<TD><INPUT NAME=pass TYPE=password CLASS=text></TD>
</TR>
</TABLE>
</FIELDSET>
</SPAN>
<SCRIPT>
document.getElementById('sjs').innerHTML = '+';
document.getElementById('body').style.display = '';
document.getElementById('error').style.display = 'none';
var jsEnabled = true;
</SCRIPT>
HTML;
}

function tpl_l($str, $color = C_DEFAULT){
$str = preg_replace("/\s{2}/", " &nbsp;", $str);
return <<<HTML
<SCRIPT>l('{$str}', $color);</SCRIPT>

HTML;
}

function tpl_enableBack(){
return <<<HTML
<SCRIPT>document.getElementById('back').disabled = 0;</SCRIPT>

HTML;
}

function tpl_s($st, $so){
$st = round($st * 100);
$st = $st > 100 ? 100 : $st;
$so = round($so * 100);
$so = $so > 100 ? 100 : $so;
return <<<HTML
<SCRIPT>s({$st},{$so});</SCRIPT>

HTML;
}

function tpl_backup_index(){
return <<<HTML
<CENTER>
<H1>–£ –≤–∞—Å –Ω–µ—Ç –ø—Ä–∞–≤ –¥–ª—è –ø—Ä–æ—Å–º–æ—Ç—Ä–∞ —ç—Ç–æ–≥–æ –∫–∞—Ç–∞–ª–æ–≥–∞</H1>
</CENTER>

HTML;
}

function tpl_error($error){
return <<<HTML
<FIELDSET>
<LEGEND>–û—à–∏–±–∫–∞ –ø—Ä–∏ –ø–æ–¥–∫–ª—é—á–µ–Ω–∏–∏ –∫ –ë–î</LEGEND>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR>
<TD ALIGN=center>{$error}</TD>
</TR>
</TABLE>
</FIELDSET>

HTML;
}

function SXD_errorHandler($errno, $errmsg, $filename, $linenum, $vars) {
  if ($errno == 2048) return true;
  if (preg_match("/chmod\(\).*?: Operation not permitted/", $errmsg)) return true;
    $dt = date("Y.m.d H:i:s");
    $errmsg = addslashes($errmsg);

//  echo tpl_l("{$dt}<BR><B>ÇÆß≠®™´† ÆË®°™†!</B>", C_ERROR);
  echo tpl_l("{$dt}<BR><B>–í–æ–∑–Ω–∏–∫–ª–∞ –æ—à–∏–±–∫–∞!</B>", C_ERROR);
  echo tpl_l("{$errmsg} ({$errno})", C_ERROR);
  echo tpl_enableBack();
  $DUMPER .= ob_get_clean();
  die($DUMPER);
}


$OUT = $OUT;
function do_exit($on=0)                  //SLIPPERY//
{
  global $DUMPER, $OUT;

  $DUMPER .= ob_get_clean();
/*
//echo "2) [$PHP_SELFQ] on=$on; DUMPER=".$DUMPER;
//echo "<br>%<br>";
  $DUMPE = 
          '<div id="dumper">'
.$DUMPER
'</div>
 ';
  eval($DUMPE);
//  eval(parse('OUT', "$DIR_FS_TPL/".basename($PHP_SELF)."/main.htm"));
//die($OUT);
if (empty($PHP_SELFQ)) {
//  echo "3) OUT=".$OUT;
//die($OUT);
//  $DUMPE = parse('OUT', "$DIR_FS_TPL/main.htm");
//die($DUMPE);
//  eval($DUMPE);
  eval(parse('OUT', "$DIR_FS_TPL/.main.htm"));
//die($OUT);
return $OUT;
}

//echo "4) OUT=".$OUT;
*/
  $OUT = $DUMPER;

  return $OUT;

} //  function 
      
  do_dumper();

  $DUMPER .= ob_get_clean();
/*
//die("%".$DUMPER."%");

//return $OUT=$DUMPER;
//  $DUMPE = parse('OUT', "$DIR_FS_TPL/".basename($PHP_SELF)."/main.htm");
//return $OUT."|".$DUMPE;
//  eval($DUMPE);
//return $OUT;
  eval(parse('OUT', "$DIR_FS_TPL/".basename($PHP_SELF)."/main.htm"));
if (empty($PHP_SELFQ)) {
//die($OUT);
//  $DUMPE = parse('OUT', "$DIR_FS_TPL/main.htm");
//die($DUMPE);
  eval($DUMPE);
//die($OUT);
  eval(parse('OUT', "$DIR_FS_TPL/.main.htm"));
}
//$OUT = do_exit(1);

//echo "5) OUT=".$OUT;
*/

  $OUT = '<div id="dumper">'.$DUMPER.'</div>';

 include 'header.php';

print $OUT;

include 'footer.php';

return $OUT;?>
