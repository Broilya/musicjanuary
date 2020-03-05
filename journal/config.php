<?php
   function setLocal($local = array("int", "local")) {
    $_LOCAL = (is_array($local)) ? 
       (in_array(array_pop(explode(".", $_SERVER["SERVER_NAME"])), $local) ? true : false) : 
       ( (($local === true) || ($local === 1))? true : false);


    define("LOCAL", $_LOCAL);
}
   setLocal();
 
   
   $db_host = "localhost";
   $db_user = "cl25536_mebel";
   $db_passwd = "111111";
   $db_base = "cl25536_mebel"; 
   
   $sms_send_login="ikBaks";
   $sms_send_pass="111987";
   
    define("PREFIX", "sch_");
  define("TABLE_BALANCE",                PREFIX."balance");
  define("TABLE_BALANCE_OPERATOR",       PREFIX."operator");
  define("TABLE_BALANCE_SERVICES",       PREFIX."services");
  define("TABLE_CLASSES",                PREFIX."classes");                
  define("TABLE_CLASSES_IN_GROUPS",      PREFIX."classes_in_groups");
  define("TABLE_CONFIG",                 PREFIX."config");                 
  define("TABLE_INFORMATION",            PREFIX."information");            
  define("TABLE_LESSONS",                PREFIX."lessons");                
  define("TABLE_SCHEDULE",               PREFIX."schedule");               
  define("TABLE_SCHOOL_QUARTERS",        PREFIX."quarters");               
  define("TABLE_SCHOOL_YEARS",           PREFIX."school_years");           
  define("TABLE_SMS_LOGS",               PREFIX."sms_logs");
  define("TABLE_SPR_DISCIPLINES",        PREFIX."disciplines");            
  define("TABLE_SPR_GROUPS",             PREFIX."groups");
  define("TABLE_SPR_RELATIVES",          PREFIX."relatives");
  define("TABLE_STUDENTS_IN_CLASS",      PREFIX."students_in_class");      
  define("TABLE_STUDENTS_IN_GROUPS",     PREFIX."students_in_groups");
  define("TABLE_STUDENTS_IN_PARENT",     PREFIX."students_in_parent");
  define("TABLE_STUDENTS_IN_SERVICE",    PREFIX."students_in_service");
  define("TABLE_STUDENTS_ON_LESSON",     PREFIX."students_on_lesson");     
  define("TABLE_SUBJECTS",               PREFIX."subjects");               
  define("TABLE_USERS",                  PREFIX."users");                  
  define("TABLE_USERS_PARENTS",          PREFIX."parents");
  define("TABLE_USERS_STUDENTS",         PREFIX."students");               
  define("TABLE_USERS_TEACHERS",         PREFIX."teachers");               


return;
   
?>