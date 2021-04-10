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
    $training = "training";
    $sqlA = "SELECT date FROM sent_email WHERE time_period = ? AND email_type = ?";
    $stmtA = $conn->prepare($sqlA);
    mysqli_stmt_bind_param($stmtA, "ss", $timePeriod, $training);
    mysqli_stmt_execute($stmtA);
    $resultA = mysqli_stmt_get_result($stmtA);
    $dateCheck = mysqli_num_rows($resultA);
    $dateSent = mysqli_fetch_all($resultA)[0][0];
    $stmtA->close();
?>

<?php if ($emailType == 'test') : ?>
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
<?php endif; ?>

<div class="page-emp-accounts">
  <div class="container">
    <div class="row justify-content-around">
      <div class="wrapper col">
        <div class="header text-center">
            <h3 class="pt-4">EMPLOYEE TIMESTUDY ACCOUNTS</h3>
            <h5 class="pb-4">Period: <?php echo $timePeriod; ?></h5>
            <div class="btn-group mb-4" role="group">
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
            <?php endif; ?>
        </div>
        <?php
          /***************
           
          // Get count of all positions
          $sql = "SELECT positions.positionName, COUNT(employee_selected.id) FROM agency_employees INNER JOIN employee_selected ON employee_selected.mhfrpid = agency_employees.MHFRPID INNER JOIN positions ON positions.positionId = agency_employees.PositionID WHERE employee_selected.time_period = ? GROUP BY positions.positionName";
          $stmt = $conn->prepare($sql);
          mysqli_stmt_bind_param($stmt, "s", $timePeriod);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          $posList = mysqli_fetch_all($result);
          $stmt->close();

          // Display employee info
          echo "
            <table class='mb-3'>
              <tr>
              <th>Position</th>
              <th>Count</th>
              </tr>
          ";

          foreach ($posList as $position) {
              echo "
              <tr>
                  <td>$position[0]</td>
                  <td>$position[1]</td>
              </tr>
              ";
          }
          echo "</table>";

          *******************/
        ?>
        <?php foreach ($agencyList as $agency) {
            $sql1 = "SELECT agency_employees.MHFRPID, agency_employees.FirstName, agency_employees.LastName, positions.positionName, agencies.AgencyName, agencies.AgencyId, agency_employees.LocationCode, agency_employees.Email FROM agency_employees INNER JOIN employee_selected ON employee_selected.mhfrpid = agency_employees.MHFRPID INNER JOIN positions ON positions.positionId = agency_employees.PositionID INNER JOIN agencies ON agencies.AgencyId = agency_employees.InteCareAgencyID WHERE agency_id = ? AND time_period = ? Order By agency_employees.LastName";
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
              <th>Position</th>
              <th>Agency</th>
              <th>Agency ID</th>
              <th>Location Code</th>
              <th>Email</th>
              <th>Send Link</th>
              </tr>
            ";

            foreach ($empList as $emp) {
              $link = "<a href='http://intecareapp.com/timestudy?id=".$emp[0]."' target='_blank'>".$emp[0]."</a>";
              echo "
              <tr>
                  <td>$link</td>
                  <td>$emp[1] $emp[2]</td>
                  <td>$emp[3]</td>
                  <td>$emp[4]</td>
                  <td>$emp[5]</td>
                  <td>$emp[6]</td>
                  <td>$emp[7]</td>
                  <td>
                    <a class='btn btn-primary btn-sm btn-block mb-2' href='update-email.php?mhfrpid=$emp[0]&period=$timePeriod' role='button'>Update</a>
                    <a class='btn btn-success btn-sm btn-block' href='resend-email.php?id=$emp[0]&email=$emp[7]' role='button'>Send</a>
                  </td>
              </tr>
              ";
            }
            echo "</table>";
        } ?>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="testEmail" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Test Training Email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="send-email.php?type=test&period=<?php echo $timePeriod; ?>" method="post">
          <input type="email" name="email" class="form-control mb-2" aria-describedby="emailHelp" placeholder="Enter email">
          <div class="float-right">
            <button type="submit" class="btn btn-primary">Send</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="realEmail" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Employee Training Email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="send-email.php?type=official&period=<?php echo $timePeriod; ?>" method="post">
          <p>This will send an email to all employees selected for training. Proceed?</p>
          <div class="float-right">
            <button type="submit" class="btn btn-primary">Send</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="timestudyEmail" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Employee Time Study Email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="send-timestudy-email.php?period=<?php echo $timePeriod; ?>" method="post">
          <p>This will send an email to all employees selected for the time study. Proceed?</p>
          <div class="float-right">
            <button type="submit" class="btn btn-primary">Send</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>