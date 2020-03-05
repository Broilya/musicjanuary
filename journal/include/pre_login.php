<?php

include_once ('init.php');

include_once ('include/classes.php');

   foreach($_SESSION as $key => $val) {
     if ($key != 'SUB_DOMEN')
       unset($_SESSION[$key]);
   }

if (isset($_REQUEST['action'])) {
  $action = $_REQUEST['action'];
  $type = $_REQUEST['type'];

  if ($action == 'login')	{
    $login = mysql_escape_string(substr($_REQUEST['name'], 0, 25));

    if ($type=='student'){

    
$db = mysql_connect("localhost",$db_user,$db_passwd);
mysql_select_db($db_base);

$query="select * from all_schools";
$res = mysql_query($query);

while ($row = mysql_fetch_assoc($res))
{
	$db = mysql_connect("localhost", $row['username'], $row['password']);
	
	mysql_select_db($row['basename']);
      $student = mysql_fetch_assoc(mysql_query("SELECT student_id,active FROM `".TABLE_USERS_STUDENTS."` WHERE login='".$login."' AND password='".$_REQUEST['pass']."';",$db));
      
        if ($student) {
        	$action="http://".$row['sub_domen'].".".$row['domen']."/login.php";
       ?>
       <form name='login_form' id='login_form' method="post" action="<?php echo $action?>">
       <input type='hidden' name='name' value='<?php echo $login; ?>'>
       <input type='hidden' name='pass' value='<?php echo $_REQUEST['pass']; ?>'>
       <input type='hidden' name='type' value='<?php echo $_REQUEST['type']; ?>'>
       <input type='hidden' name='action' value='<?php echo $_REQUEST['action']; ?>'>
	   </form>
<body onLoad="document.forms['login_form'].submit();">
             
       <?php
        die();
}
      
  
      mysql_close($db); 
}
 header('Location: auth.php?error=wrong_pincod');
      exit();
    }

    if ($type=='parent'){

$db = mysql_connect("localhost",$db_user,$db_passwd);
mysql_select_db($db_base);

$query="select * from all_schools";
$res = mysql_query($query);

while ($row = mysql_fetch_assoc($res))
{
	$db = mysql_connect("localhost", $row['username'], $row['password']);
	
	mysql_select_db($row['basename']);
	$password=$_REQUEST['pass'];
      $parent = db_get_first_row("SELECT parent_id,active FROM `".TABLE_USERS_PARENTS."` WHERE login='".$login."' AND password='".$password."';",$db);

      if ($parent) {

        	$action="http://".$row['sub_domen'].".".$row['domen']."/login.php";
       ?>
       <form name='login_form' id='login_form' method="post" action="<?php echo $action?>">
       <input type='hidden' name='name' value='<?php echo $login; ?>'>
       <input type='hidden' name='pass' value='<?php echo $_REQUEST['pass']; ?>'>
       <input type='hidden' name='type' value='<?php echo $_REQUEST['type']; ?>'>
       <input type='hidden' name='action' value='<?php echo $_REQUEST['action']; ?>'>
	   </form>
<body onLoad="document.forms['login_form'].submit();">
             
       <?php
        die();
}
      
  
      mysql_close($db); 
        
      }
      header('Location: auth.php?error=wrong_pincod');
      exit();
    }

    if ($type=='teacher'){
    	
$db = mysql_connect("localhost",$db_user,$db_passwd);
mysql_select_db($db_base);

$query="select * from all_schools";
$res = mysql_query($query);

while ($row = mysql_fetch_assoc($res))
{
	$db = mysql_connect("localhost", $row['username'], $row['password']);
	
	mysql_select_db($row['basename']);
       $passwd = md5($_REQUEST['pass']);
       $teacher = db_get_first_row("SELECT teacher_id FROM `".TABLE_USERS_TEACHERS."` WHERE login='".$login."' AND passwd='$passwd'");
       if (intval($teacher['teacher_id']) != 0) {
        	$action="http://".$row['sub_domen'].".".$row['domen']."/login.php";
       ?>
       <form name='login_form' id='login_form' method="post" action="<?php echo $action?>">
       <input type='hidden' name='name' value='<?php echo $login; ?>'>
       <input type='hidden' name='pass' value='<?php echo $_REQUEST['pass']; ?>'>
       <input type='hidden' name='type' value='<?php echo $_REQUEST['type']; ?>'>
       <input type='hidden' name='action' value='<?php echo $_REQUEST['action']; ?>'>
	   </form>
<body onLoad="document.forms['login_form'].submit();">
             
       <?php
        die();
}
      
  
      mysql_close($db); 
        
}
         header('Location: ./teachers/login.php?error=wrong_passwd');
       
       exit();
    }
  
    if ($type=='admin'){
    		
$db = mysql_connect("localhost",$db_user,$db_passwd);
mysql_select_db($db_base);

$query="select * from all_schools";
$res = mysql_query($query);

while ($row = mysql_fetch_assoc($res))
{
	$db = mysql_connect("localhost", $row['username'], $row['password']);
	
	mysql_select_db($row['basename']);
      $passwd = md5($_POST['pass']);
//echo "SELECT user_id FROM `".TABLE_USERS."` WHERE login='$login' AND passwd='$passwd' AND access=1"; die();
      $user = db_get_first_row($sql = "SELECT user_id FROM `".TABLE_USERS."` WHERE login='".$login."' AND passwd='$passwd' AND access=1");

      if (intval($user['user_id']) != 0) {

         	$action="http://".$row['sub_domen'].".".$row['domen']."/login.php";
       ?>
       <form name='login_form' id='login_form' method="post" action="<?php echo $action?>">
       <input type='hidden' name='name' value='<?php echo $login; ?>'>
       <input type='hidden' name='pass' value='<?php echo $_REQUEST['pass']; ?>'>
       <input type='hidden' name='type' value='<?php echo $_REQUEST['type']; ?>'>
       <input type='hidden' name='action' value='<?php echo $_REQUEST['action']; ?>'>
	   </form>
<body onLoad="document.forms['login_form'].submit();">
             
       <?php
        die();
}
      
  
      mysql_close($db); 
        

       	
      }
      header('Location: ./login.php?error=wrong_passwd');
      exit();
    }
    
    if ($type=='director'){
    		
$db = mysql_connect("localhost",$db_user,$db_passwd);
mysql_select_db($db_base);

$query="select * from all_schools";
$res = mysql_query($query);

while ($row = mysql_fetch_assoc($res))
{
	$db = mysql_connect("localhost", $row['username'], $row['password']);
	
	mysql_select_db($row['basename']);
      $passwd = md5($_POST['pass']);
//echo "SELECT user_id FROM `".TABLE_USERS."` WHERE login='$login' AND passwd='$passwd' AND access=1"; die();
       $user = db_get_first_row("SELECT teacher_id FROM `".TABLE_USERS_TEACHERS."` WHERE login='".$login."' AND passwd='$passwd' AND director=1");
//      $user = db_get_first_row($sql = "SELECT user_id FROM `".TABLE_USERS."` WHERE login='$login' AND passwd='$passwd' AND  access=2");

      if (intval($user['teacher_id']) != 0) {

    	 	$action="http://".$row['sub_domen'].".".$row['domen']."/login.php";
       ?>
       <form name='login_form' id='login_form' method="post" action="<?php echo $action?>">
       <input type='hidden' name='name' value='<?php echo $login; ?>'>
       <input type='hidden' name='pass' value='<?php echo $_REQUEST['pass']; ?>'>
       <input type='hidden' name='type' value='<?php echo $_REQUEST['type']; ?>'>
       <input type='hidden' name='action' value='<?php echo $_REQUEST['action']; ?>'>
	   </form>
<body onLoad="document.forms['login_form'].submit();">
             
       <?php
        die();
}
      
  
      mysql_close($db); 
        

       	
      }
      header('Location: ./login.php?error=wrong_passwd');
      exit();
    }
    
  } elseif ($action == 'logout')	{
//    unset($_SESSION['SUB_DOMEN']);
    header('Location: ./');
    exit();
  }
}

    header('Location: ./');
    exit();


?>