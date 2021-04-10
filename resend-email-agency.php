<?php
    /*require "../includes/adminCheck.inc.php";
    require "../includes/rosterLock.inc.php";
    require "../includes/costReport.inc.php";*/
    require "./header.php";
    require "includes/timeStudyStartDate.inc.php";

    include "./nav.php"; 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $timePeriod = $_GET['period'];
    $id = $_GET['id'];
    $emailAddress = $_GET['email'];

    if(!isTimeStudyStartDatePast())
    {
      $message = " 
      <html> 
      <head> 
          <title>Intecare Training Link</title> 
      </head> 
      <body> 
          <p>Here is your link for the Intecare Training portal:</p>
          <a href='http://www.intecareapp.com/training?id=$id'><p>http://www.intecareapp.com/training?id=$id</p></a>
          <p>If you have any questions, please contact Ashley Owens at <a href='mailto:aowens@intecare.org'>aowens@intecare.org</a>.</p>

          <p>Thank you,</p>
          <a href='http://www.intecare.org'><p>Intecare</p></a>
      </body> 
      </html>
      ";
    }
    else
    {
      $message = " 
      <html> 
      <head> 
          <title>Intecare Time Study Link</title> 
      </head> 
      <body> 
          <p>Here is your link for the Intecare Training portal:</p>
          <a href='http://www.intecareapp.com/timestudy?id=$id'><p>http://www.intecareapp.com/timestudy?id=$id</p></a>
          <p>If you have any questions, please contact Brooke Abbott at <a href='mailto:babbott@intecare.org'>babbott@intecare.org</a>.</p>

          <p>Thank you,</p>
          <a href='http://www.intecare.org'><p>Intecare</p></a>
      </body> 
      </html>
      ";
    }
    // SendGrid details
    require("sendgrid/sendgrid-php.php");

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("mhfrp@intecare.org", "Intecare Testing");
    //$email->setReply('babbott@intecare.org', 'Intecare Training');
    $email->setSubject("Intecare Training Email");
    $email->addTo($emailAddress, "Training Participant");
    $email->addContent("text/html", $message);

    $sendgrid = new \SendGrid('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');

    // Send email
    try{
      $response = $sendgrid->send($email);
      if($response->statusCode() == '202'){
      echo 'Email has sent successfully.';
      header("Location: agency-emp-accounts.php?email=resend&period=$timePeriod");
      }
      else{
        echo 'Email sending failed.<br> Please supply the following diagnostic code to the system admin: <br>' . $response[5]; 
      }
    }catch (Exception $e) {
      echo 'Caught exception: '. $e->getMessage() ."\n";
  }
?>