<?php
  require "../includes/adminCheck.inc.php";
  require "../includes/rosterLock.inc.php";
  require "../includes/costReport.inc.php";
  require "./header.php";

  include "./nav.php";

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\SMTP;
  use PHPMailer\PHPMailer\Exception;

  require '../phpmailer/Exception.php';
  require '../phpmailer/PHPMailer.php';
  require '../phpmailer/SMTP.php';

  $mail = new PHPMailer(true);

try {
    // Server Settings
    $mail->isSMTP();                                                  // Send using SMTP
    $mail->SMTPDebug    = SMTP::DEBUG_SERVER;                         // Enable verbose debug output
    $mail->Host         = 'intecareapp-com.mail.protection.outlook.com';  // Set the SMTP server for GoDaddy
    $mail->Port         = 25;                                         // Set port for GoDaddy
    $mail->SMTPAuth     = false;                                      // Disable SMTP authentication for GoDaddy
    $mail->SMTPAutoTLS  = false;                                      // Disable AutoTLS for GoDaddy
    $mail->SMTPSecure   = PHPMailer::ENCRYPTION_STARTTLS;             // Enable TLS encryption

    // Auth Settings for Non-GoDaddy servers
    /*********************************
    $mail->Host         = 'smtp.office365.com';
    $mail->SMTPAuth     = true;
    $mail->SMTPAutoTLS  = true;
    $mail->Username     = 'mhfrp@intecare.org';
    $mail->Password     = 'eracetni2020!';
    **********************************/

    //Recipients
    $mail->setFrom('babbott1@intecare.org', 'Intecare Training');
    $mail->addAddress('demarelle@gmail.com', 'Demarelle Hammond');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('babbott@intecare.org', 'Intecare Training');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    $htmlContent = " 
      <html> 
      <head> 
          <title>Intecare</title> 
      </head> 
      <body> 
          <h1 style='color:red'>TRAINING EMAIL:</h1>
          <hr>
          <strong>Participant Name: Test</strong>
          <strong>MHFRP ID: 0000</strong>
          <br/><br/>
          <p>You have been randomly selected for the MHFRP time study this quarter. Participation in both the training and the time study is mandatory.</p>
          <p><a href='http://www.intecareapp.com/training?id=000'>Please click here to begin training</a>.</p>
          <p>You may quit and return to the training at any point in the process. The system will save your place. Once you have completed the training, you can access the system for review prior to the time study week by clicking the link above. If you want to print the training to use as a reference there will be a link to a PDF document for quick printing at the end of the training or go to our <a href='http://www.intecare.org/mhfrp'>website</a>.</p>
          <p>You must pass all three quizzes before your score is recorded. Once you reach the last page that contains our program\'s toll-free number in red, your training is complete and your score has been recorded. You will not receive further confirmation and you can exit the system at that point.
          <p>Please be sure to complete the training during the period of May 11th - May 22nd.</p>
          <p>If you have any questions regarding the training, process, the time study, or if you are not the person named above, please contact Intecare using the link below.</p>

          <p>Thank you,</p>
          <a href='http://www.intecare.org'><p>Intecare</p></a>
      </body> 
      </html>
    ";

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Intecare Training Email1';
    $mail->Body    = $htmlContent;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>