<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

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

  $timePeriod = $_GET['period'];
  $type = $_GET['type'];
  $email = $_POST['email'];

  $to = $email; 
  $from = 'testing@intecare.com'; 
  $fromName = 'Intecare Timestudy'; 
   
  $subject = "Intecare Training Email (TEST)"; 
  
  if ($type === 'test') {
    $htmlContent = "
    <html> 
        <head> 
            <title>Intecare</title> 
        </head> 
        <body> 
            <h1 style='color:red'>TRAINING EMAIL:</h1>
            <hr>
            <strong>Participant Name: $emp[1], $emp[0];</strong>
            <strong>MHFRP ID: $emp[3]</strong>
            <br/><br/>
            <p>You have been randomly selected for the MHFRP time study this quarter. Participation in both the training and the time study is mandatory.</p>
            <p><a href='http://www.intecareapp.com/training?id=$emp[3]'>Please click here to begin training</a>.</p>
            <p>You may quit and return to the training at any point in the process. The system will save your place. Once you have completed the training, you can access the system for review prior to the time study week by clicking the link above. If you want to print the training to use as a reference there will be a link to a PDF document for quick printing at the end of the training or go to our <a href='http://www.intecare.org/mhfrp'>website</a>.</p>
            <p>You must pass all three quizzes before your score is recorded. Once you reach the last page that contains our program\'s toll-free number in red, your training is complete and your score has been recorded. You will not receive further confirmation and you can exit the system at that point.
            <p>Please be sure to complete the training during the period of October 19th - October 30th.</p>
            <p>If you have any questions regarding the training, process, the time study, or if you are not the person named above, please contact Intecare using the link below.</p>

            <p>Thank you,</p>
            <a href='http://www.intecare.org'><p>Intecare</p></a>
        </body> 
        </html>
        "; 
    
    // Set content-type header for sending HTML email 
    $headers = "MIME-Version: 1.0" . "\r\n"; 
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    // Add Office365 email credentials
    $mail->Host         = 'smtp.office365.com';
    $mail->SMTPAuth     = true;
    $mail->SMTPAutoTLS  = true;
    $mail->Username     = 'mhfrp@intecare.org';
    $mail->Password     = 'eracetni2020!';

    $mail->setFrom('mhfrp@intecare.org', 'Intecare Training');
    $mail->addReplyTo('babbott@intecare.org', 'Intecare Training');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject      = 'Intecare Training Email';
    $mail->Body         = $htmlContent;
    
    // Send email 
    if (mail($to, $subject, $htmlContent, $headers)) { 
        echo 'Email has sent successfully.';
        header("Location: emp-accounts.php?email=test&period=$timePeriod");
    } else { 
      echo 'Email sending failed.'; 
    }
  }

  if ($type === 'official') {
    $sql1 = "SELECT agency_employees.FirstName, agency_employees.LastName, agency_employees.Email, agency_employees.MHFRPID FROM employee_selected INNER JOIN agency_employees WHERE employee_selected.mhfrpid = agency_employees.MHFRPID AND time_period = ? AND email_sent = 0";
    $stmt1 = $conn->prepare($sql1);
    mysqli_stmt_bind_param($stmt1, "s", $timePeriod);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    $empList = mysqli_fetch_all($result1);
    $stmt1->close();
    
    // Email Data
    //$from = 'babbott@intecare.org'; 
    //$fromName = 'Intecare'; 
    //$subject = "Intecare Training Email";
    //$headers = "MIME-Version: 1.0" . "\r\n"; 
    //$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    //$headers .= 'From: Intecare Training' . "\r\n" . 'Reply-To: ' . 'babbott@intecare.org' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
    //var_dump($empList); exit;
    foreach ($empList as $emp) {
      $htmlContent = " 
        <html> 
        <head> 
            <title>Intecare</title> 
        </head> 
        <body> 
            <h1 style='color:red'>TRAINING EMAIL 2021-Q1:</h1>
            <hr>
            <strong>Participant Name: $emp[1], $emp[0];</strong>
            <strong>MHFRP ID: $emp[3]</strong>
            <br/><br/>
            <p>You have been randomly selected for the MHFRP time study this quarter. Participation in both the training and the time study is mandatory.</p>
            <p><a href='http://www.intecareapp.com/training?id=$emp[3]'>Please click here to begin training</a>.</p>
            <p>You may quit and return to the training at any point in the process. The system will save your place. Once you have completed the training, you can access the system for review prior to the time study week by clicking the link above. If you want to print the training to use as a reference there will be a link to a PDF document for quick printing at the end of the training or go to our <a href='http://www.intecare.org/mhfrp'>website</a>.</p>
            <p>You must pass all three quizzes before your score is recorded. Once you reach the last page that contains our program\'s toll-free number in red, your training is complete and your score has been recorded. You will not receive further confirmation and you can exit the system at that point.
            <p>Please be sure to complete the training during the period of February 15th - March 1st.</p>
            <p>If you have any questions regarding the training, process, the time study, or if you are not the person named above, please contact Intecare using the link below.</p>

            <p>Thank you,</p>
            <a href='http://www.intecare.org'><p>Intecare</p></a>
        </body> 
        </html>
      ";
  
      // SendGrid details
    require("../sendgrid/sendgrid-php.php");

    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("mhfrp@intecare.org", "Intecare Testing");
    $email->setSubject("Intecare Training Email");
    $email->addTo($emp[2], $emp[1]." ".$emp[0]);
    $email->addContent("text/html", $htmlContent);

    $sendgrid = new \SendGrid('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');
    // Send email
    try{
      $response = $sendgrid->send($email);
      if($response->statusCode() == '202'){
      echo $emp[3] .'<br>';
      usleep(250000);
      //header("Location: agency-emp-accounts.php?email=resend&period=$timePeriod");
      }
      else{
        echo 'Email sending failed.<br> Please supply the following diagnostic code to the system admin: <br>' . $response[5]; 
      }
    }catch (Exception $e) {
      echo 'Caught exception: '. $e->getMessage() ."\n";
  }
    }

    /* Add training start date
    $date = date('Y-m-d');
    $sql2 = "UPDATE employee_selected SET training_date = ? WHERE time_period = ?";
    $stmt2 = $conn->prepare($sql2);
    mysqli_stmt_bind_param($stmt2, "ss", $date, $timePeriod);
    mysqli_stmt_execute($stmt2);
    $stmt2->close();
*/
    // Add email sent date
    $emailType = "training";
    $sql3 = "INSERT INTO sent_email (time_period, email_type, `date`) VALUES (?, ?, ?)";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param("sss", $timePeriod, $emailType, $date);
    $stmt3->execute();
    $stmt3->close();

    //header("Location: emp-accounts.php?email=official&period=$timePeriod");
  }
?>