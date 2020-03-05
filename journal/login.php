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

      $student = db_get_first_row("SELECT student_id,active FROM `".TABLE_USERS_STUDENTS."` WHERE login='".$login."' AND password='".$_REQUEST['pass']."';");
      if ($student) {

        $_SESSION['student_id'] = $student['student_id'];
        $_SESSION['blocked'] = $student['active'];
          
        $class=db_get_first_row("select class_id FROM `".TABLE_STUDENTS_IN_CLASS."` where student_id='".$student['student_id']."'");
        $_SESSION['class_id']=$class['class_id'];
          
        header('Location: ./students/index.php');
      }
      else{
        header('Location: auth.php?error=wrong_pincod');
      }
      exit();
    }

    if ($type=='parent'){

      $parent = db_get_first_row("SELECT parent_id,active FROM `".TABLE_USERS_PARENTS."` WHERE login='".$login."' AND password='".$_REQUEST['pass']."';");
      if ($parent) {

        $_SESSION['parent_id'] = $parent['parent_id'];
        $_SESSION['blocked']   = $parent['active'];
          
        header('Location: ./parents/index.php');
      }
      else{
        $parent = db_get_first_row("SELECT student_id,active FROM `".TABLE_USERS_STUDENTS."` WHERE login='".$login."' AND password='".$_REQUEST['pass']."';");
        if ($parent) {

          $_SESSION['parent_id'] = $parent['student_id'];
          $_SESSION['blocked'] = $parent['active'];
            
          header('Location: ./parents/index.php');
        }

        header('Location: auth.php?error=wrong_pincod');
      }
      exit();
    }

    if ($type=='teacher'){
       $passwd = md5($_REQUEST['pass']);
       $teacher = db_get_first_row("SELECT teacher_id FROM `".TABLE_USERS_TEACHERS."` WHERE login='".$login."' AND passwd='$passwd'");
       if (intval($teacher['teacher_id']) != 0) {
         $_SESSION['teacher_id'] = $teacher['teacher_id'];
         header('Location: ./teachers/index.php');
       } else {
         header('Location: ./teachers/login.php?error=wrong_passwd');
       }
       exit();
    }
  
    if ($type=='admin'){
      $passwd = md5($_POST['pass']);
//echo "SELECT user_id FROM `".TABLE_USERS."` WHERE login='$login' AND passwd='$passwd' AND access=1"; die();
      $user = db_get_first_row($sql = "SELECT user_id FROM `".TABLE_USERS."` WHERE login='".$login."' AND passwd='$passwd' AND access=1");

      if (intval($user['user_id']) != 0) {

        $_SESSION['admin_id'] = $user['user_id'];

        header('Location: ./admin/index.php');
      } else {
       	header('Location: ./admin/login.php?error=wrong_passwd');
      }
      exit();
    }
    
    if ($type=='director'){
      $passwd = md5($_POST['pass']);
//echo "SELECT user_id FROM `".TABLE_USERS."` WHERE login='$login' AND passwd='$passwd' AND access=1"; die();
       $user = db_get_first_row("SELECT teacher_id FROM `".TABLE_USERS_TEACHERS."` WHERE login='".$login."' AND passwd='$passwd' AND director=1");
//      $user = db_get_first_row($sql = "SELECT user_id FROM `".TABLE_USERS."` WHERE login='$login' AND passwd='$passwd' AND  access=2");

      if (intval($user['teacher_id']) != 0) {

    	$_SESSION['director_id'] = $user['teacher_id'];

    	header('Location: ./director/srv.php');
      } else {
       	header('Location: ./director/login.php?error=wrong_passwd');
      }
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