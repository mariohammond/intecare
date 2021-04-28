<?php
    //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    require "../includes/adminCheck.inc.php";
    require "../includes/rosterLock.inc.php";
    require "../includes/costReport.inc.php";
    require "./header.php";

    include "./nav.php";

    $emailType = $_GET['email'];
    $timePeriod = $_GET['period'];

    // Get all agencies
    $sql0 = "SELECT AgencyName, AgencyId FROM agencies ORDER BY AgencyName";
    $stmt0 = $conn->prepare($sql0);
    mysqli_stmt_execute($stmt0);
    $result0 = mysqli_stmt_get_result($stmt0);
    $agencyList = mysqli_fetch_all($result0);
    $agencyCount = mysqli_num_rows($result0);
    $stmt0->close();

    // Check if training email sent
    /*$training = "training";
    $sqlA = "SELECT date FROM sent_email WHERE time_period = ? AND email_type = ?";
    $stmtA = $conn->prepare($sqlA);
    mysqli_stmt_bind_param($stmtA, "ss", $timePeriod, $training);
    mysqli_stmt_execute($stmtA);
    $resultA = mysqli_stmt_get_result($stmtA);
    $dateCheck = mysqli_num_rows($resultA);
    $dateSent = mysqli_fetch_all($resultA)[0][0];
    $stmtA->close();*/
?>

<!--<?php if ($emailType == 'test') : ?>
<div class="alert alert-success" role="alert">
  Test email successfully sent.
</div>
<?php elseif ($emailType == 'official') : ?>
<div class="alert alert-success" role="alert">
  Employee email successfully sent.
</div>
<?php elseif ($emailType == 'resend') : ?>
<div class="alert alert-success" role="alert">
  Employee email successfully sent.
</div>
<?php elseif ($emailType == 'update') : ?>
<div class="alert alert-success" role="alert">
  Employee email successfully updated.
</div>
<?php endif; ?>-->

<div class="page-emp-accounts">
  <div class="container">
    <div class="row justify-content-around">
      <div class="wrapper col">
        <div class="header text-center">
            <h3 class="pt-4">EMPLOYEE TIMESTUDY PROGRESS</h3>
            <h5 class="pb-4">Period: <?php echo $timePeriod; ?></h5>
            <!--<div class="btn-group mb-4" role="group">
              <button type="button" class="btn btn-primary border" data-toggle="modal" data-target="#realEmail">Send Training Email</button>
              <button type="button" class="btn btn-primary border" data-toggle="modal" data-target="#testEmail">Test Email</button>
              <a class="btn btn-primary border" href="download-list.php?period=<?php echo $timePeriod; ?>" role="button">Download List</a>
              <a class="btn btn-primary border" href="training-progress.php?period=<?php echo $timePeriod; ?>" role="button">Training Progress</a>
            </div>
            <?php if ($dateCheck > 0) : ?>
              <div class="row text-center justify-content-center mb-4">
                <p class="col-12">Training email sent on <?php echo $dateSent; ?>.</p>
                <button type="button" class="btn btn-primary border" data-toggle="modal" data-target="#timestudyEmail">Send Time Study Email</button>
              </div>
            <?php endif; ?>-->
        </div>
        <?php foreach ($agencyList as $agency) {
            // Get info of selected employees
            
            /*$sql1 = "SELECT agency_employees.MHFRPID, agency_employees.FirstName, agency_employees.LastName, agency_employees.Email FROM agency_employees INNER JOIN employee_selected ON employee_selected.mhfrpid = agency_employees.MHFRPID WHERE agency_employees.InteCareAgencyID = ? AND employee_selected.time_period = ?";*/

            $sql1 = "SELECT mhfrpid, first_name, last_name, email FROM employee_selected WHERE agency_id = ? AND time_period = ?";
            $stmt1 = $conn->prepare($sql1);
            mysqli_stmt_bind_param($stmt1, "ss", $agency[1], $timePeriod);
            mysqli_stmt_execute($stmt1);
            $result1 = mysqli_stmt_get_result($stmt1);
            $empList = mysqli_fetch_all($result1);
            $stmt1->close();

            // Display agency name
            echo "<strong>$agency[0]</strong>";

            // Display employee info
            echo "
              <table class='mb-3'>
              <tr>
              <th>MHFRPID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Training Started</th>
              <th>Training Completed</th>
              </tr>
            ";

            foreach ($empList as $emp) {
                // Get training status of selected employees
                $sql2 = "SELECT pdfStart, pdfComplete FROM employee_training WHERE mhfrpid = ?";
                $stmt2 = $conn->prepare($sql2);
                mysqli_stmt_bind_param($stmt2, "s", $emp[0]);
                mysqli_stmt_execute($stmt2);
                $result2 = mysqli_stmt_get_result($stmt2);
                $pdfStatus = mysqli_fetch_all($result2)[0];

                if ($pdfStatus[0] == '') {
                    $pdfStart = "<span class='text-danger'>Not Started</span>";
                } else {
                    $pdfStart = $pdfStatus[0];
                }

                if ($pdfStatus[1] == '') {
                    $pdfComplete = "<span class='text-danger'>Not Completed</span>";
                } else {
                    $pdfComplete = $pdfStatus[1];
                }

                $stmt2->close();

                echo "
                <tr>
                    <td>$emp[0]</td>
                    <td>$emp[1] $emp[2]</td>
                    <td>$emp[3]</td>
                    <td>$pdfStart</td>
                    <td>$pdfComplete</td>
                </tr>
                ";
            }
            echo "</table>";
        } ?>
      </div>
    </div>
  </div>
</div>