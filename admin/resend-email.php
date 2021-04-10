<?php
    /*require "../includes/adminCheck.inc.php";
    require "../includes/rosterLock.inc.php";
    require "../includes/costReport.inc.php";*/
    require "./header.php";
    require("../sendgrid/sendgrid-php.php");

    include "./nav.php"; 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    //$timePeriod = $_GET['period'];
    $id = $_GET['id'];
    $emailAddress = $_GET['email'];
    $period = $_GET['period'];

    $message = " 
    <html> 
    <head> 
        <title>Intecare Training Link</title> 
    </head> 
    <body> 
        <p>Here is your link for the Intecare Training portal:</p>
        <a href='http://www.intecareapp.com/training?id=$id'><p>http://www.intecareapp.com/training?id=$id</p></a>
        <p>If you have any questions, please contact Brooke Abbott at <a href='mailto:babbott@intecare.org'>babbott@intecare.org</a>.</p>

        <p>Thank you,</p>
        <a href='http://www.intecare.org'><p>Intecare</p></a>
    </body> 
    </html>
    ";
    
    /*
    $message ="<html> 
            <head> 
                <title>Intecare</title> 
            </head> 
            <body> 
                <h1 style='color:red'>TIMESTUDY EMAIL:</h1>
                <hr>
                <br/><br/>
                <p>You have been randomly selected for the MHFRP time study this quarter. Participation in both the training and the time study is mandatory.</p>
                <p><a href='http://www.intecareapp.com/timestudy?id=$id'>Please click here to access your time study</a>.</p>
                <p>You may quit and return to the time study at any point in the process, but make sure you save your progress using the record buttons. The system will save your place. Once you have completed the time study, you can access the system for review anytime by clicking the link above.</p>
                <p>If you have any questions regarding the time study, or if you are not the person named above, please contact Intecare using the link below.</p>

                <p>Thank you,</p>
                <a href='http://www.intecare.org'><p>Intecare</p></a>
            </body> 
            </html>
            ";
*/
    // SendGrid details
    
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
      header("Location: emp-accounts.php?email=resend&period=$period");
      }
      else{
        echo 'Email sending failed.<br> Please supply the following diagnostic code to the system admin: <br>' . $response[5]; 
      }
    }catch (Exception $e) {
      echo 'Caught exception: '. $e->getMessage() ."\n";
  }
?>