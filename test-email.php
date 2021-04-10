<?php
    //require "../includes/adminCheck.inc.php";
    //require "/includes/rosterLock.inc.php";
    require "includes/costReport.inc.php";
    require "header.php";

    include "nav.php";

    $timePeriod = $_GET['period'];
    $id = $_GET['id'];
    $email = $_GET['email'];
    //$email = 'jeffrey.musgrove@gmail.com';


    $to = 'mnaibauer@nec.org';
    $to = 'jeffrey.musgrove@gmail.com';
    $from = 'babbott@intecare.org'; 
    $fromName = 'Intecare'; 
    $subject = "Intecare Training Link";

    // Set content-type header for sending HTML email 
    $headers = "MIME-Version: 1.0" . "\r\n"; 
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers = "MIME-Version: 1.0" . "\r\n"; 
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    $htmlContent = " 
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
    
    // Send email 
    if (mail($to, $subject, $htmlContent, $headers)) { 
        echo 'Email has sent successfully.';
        header("Location: agency-emp-accounts.php?email=resend&period=$timePeriod");
    } else { 
        echo 'Email sending failed.'; 
    }
?>