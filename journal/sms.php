<?php

include_once ('include/php_sms.php');

  
  $OFF = 0;
  $phone = (empty($_REQUEST['phone'])) ? '1111111111' : $_REQUEST['phone'];
  $sms_send_login='ikBaks';
  $sms_send_pass='111987';

  $SMS = "http://ikBaks:111987@gate.iqsms.ru/send/?phone=+7".$phone."&text=2011-11-28.ddd.test:proverka3&sender=DHEBHUK";

  $status=send("gate.iqsms.ru", 80, $sms_send_login, $sms_send_pass, 
		  "7".$phone, "2011-11-28.ddd.test:proverka2", "DHEBHUK");

echo "<br>phone=$phone|status=".$status."|<br>";

//$status= '138484079=accepted';
$sms_num = explode('=', $status);
echo status("gate.iqsms.ru", 80, $sms_send_login, $sms_send_pass, $sms_num[0]);

/*
  if (function_exists('file_get_contents'))
    echo "function_exists('file_get_contents') = YES";
  else
    echo "function_exists('file_get_contents') = NOT";

  $phone = (empty($_REQUEST['phone'])) ? '1111111111' : $_REQUEST['phone'];
         $SMS = "http://ikBaks:111987@gate.iqsms.ru/send/?phone=+7".$phone."&text=2011-11-28.ddd.test:proverka2";
if (empty($OFF)){
          $status = file_get_contents($SMS);
}
echo "phone=$phone|status=".$status."|<br>";

read_url ($SMS, 1);



$SMS="http://e.mail.ru/cgi-bin/login";
          $status = file_get_contents($SMS);
echo "phone=$phone|status=".$status."|<br>";

read_url ($SMS, 1);

  function read_url ($URL, $DUMP=0) 
  {
    if (!($fd=fopen($URL,"r"))) 
      echo "<br>couldn't open file '$URL'\n";

    if ($fd)
    {
//  READ record
      $alltext = "";
      while ($line = fread ( $fd, 1024 ))
        $alltext .= $line;

      fclose ($fd);

if ($DUMP)         echo "<BR>\n"."alltext=".$alltext."\n<BR>";

      return $alltext;
    }
    else
    {
if ($DUMP)       echo "<br>Not Page '".$URL."'!!!\n";
      return false;
    }
  }
//  http://business-barnaul.ru/sms.php?phone=9237291625

    http://el-dn.ru/sms3.php?phone=9237291625

138484079=accepted
phone=9237291625|status=138484079=accepted|
138484079=queued

138484079=delivered
*/
?>