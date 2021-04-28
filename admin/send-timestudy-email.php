<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    require "../includes/adminCheck.inc.php";
    require "../includes/rosterLock.inc.php";
    require "../includes/costReport.inc.php";
    require "./header.php";
    require("../sendgrid/sendgrid-php.php");

    include "./nav.php";


    $timePeriod = $_GET['period'];
    $email = '';

    /*$sql1 = "SELECT agency_employees.FirstName, agency_employees.LastName, agency_employees.Email, agency_employees.MHFRPID FROM employee_selected INNER JOIN agency_employees WHERE employee_selected.mhfrpid = agency_employees.MHFRPID AND time_period = ?";*/

    $sql1 = "SELECT first_name, last_name, email, mhfrpid FROM employee_selected WHERE time_period = ?";
    
    $stmt1 = $conn->prepare($sql1);
    mysqli_stmt_bind_param($stmt1, "s", $timePeriod);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    $empList = mysqli_fetch_all($result1);
    $stmt1->close();

    
    foreach ($empList as $emp) {
        $message = " 
            <html> 
            <head> 
                <title>Intecare</title> 
            </head> 
            <body> 
                <h1 style='color:red'>TIMESTUDY EMAIL:</h1>
                <hr>
                <strong>Participant Name: $emp[1], $emp[0];</strong>
                <strong>MHFRP ID: $emp[3]</strong>
                <br/><br/>
                <p>You have been randomly selected for the MHFRP time study this quarter. Participation in both the training and the time study is mandatory.</p>
                <p><a href='http://www.intecareapp.com/timestudy?id=$emp[3]'>Please click here to access your time study</a>.</p>
                <p>You may quit and return to the time study at any point in the process, but make sure you save your progress using the record buttons. The system will save your place. Once you have completed the time study, you can access the system for review anytime by clicking the link above.</p>
                <p>If you have any questions regarding the time study, or if you are not the person named above, please contact Intecare using the link below.</p>

                <p>Thank you,</p>
                <a href='http://www.intecare.org'><p>Intecare</p></a>
            </body> 
            </html>
        ";

        // SendGrid details
    $name = $emp[0] . ' ' . $emp[1];
    $email = new \SendGrid\Mail\Mail();
    $email->setFrom("mhfrp@intecare.org", "Intecare Testing");
    $email->setSubject("Intecare Time Study Notification");
    $email->addTo(trim($emp[2]), $name);
    $email->addContent("text/html", $message);

    $sendgrid = new \SendGrid('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');

        try{
            $response = $sendgrid->send($email);
            if($response->statusCode() == '202'){
            echo 'Email has sent successfully.';
            }
            else{
                echo 'Email sending failed.<br> Please supply the following diagnostic code to the system admin: <br>' . var_dump($response); 
            }
        }
        catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

    }

    header("Location: emp-accounts.php?email=official&period=$timePeriod");
?>