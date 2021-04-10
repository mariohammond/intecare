<?php
ini_set("include_path", '/home/intecareapp/php:' . ini_get("include_path") );
 require_once "Mail.php";
 
 $from = "Intecare MHFRP <mhfrp@intecare.orgm>";
 $to = "Jeff Musgrove <jeffrey.musgrove@gmail.com>";
 $subject = "SMTP email test";
 $body = "This is a test email.";
 
 $host = "smtp.office365.com";
 $port = "587";
 $username = "mhfrp@intecare.org";
 $password = "intecare2020!";
 
 $headers = array ('From' => $from,
   'To' => $to,
   'Subject' => $subject);
 $smtp = Mail::factory('smtp',
   array ('host' => $host,
     'port' => $port,
     'auth' => true,
     'username' => $username,
     'password' => $password));
 
 $mail = $smtp->send($to, $headers, $body);
 
 if (PEAR::isError($mail)) {
   echo("<p>" . $mail->getMessage() . "</p>");
  } else {
   echo("<p>Message successfully sent!</p>");
  }
 ?>