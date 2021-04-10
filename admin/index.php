<?php
  require "../includes/adminCheck.inc.php";
  require "../includes/rosterLock.inc.php";
  require "../includes/costReport.inc.php";
  require "../mhfrpid-fix.php";
  require "./header.php";

  include "./nav.php";

  // Get list of agencies from db
  $sql = "SELECT AgencyId, AgencyName FROM agencies ORDER BY AgencyName";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sql);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $agencyList = mysqli_fetch_all($result);
?>

<div class="page-admin">
  <div class="container">
    <div class="row justify-content-around text-center">
      <div class="wrapper col-12 col-md-5 mb-5">
        <h2 class="text-center">ROSTER MANAGEMENT</h2>
        <h5 class="text-center">Current Roster Status: <?php echo $rosterStatus; ?></h5>
        <form class="rosterForm" action="../includes/rosterLock.inc.php" method="post">
          <div class="form-group">
            <select class="form-control" name="lock-status">
              <option value="">SELECT CURRENT STATUS</option>
              <option value="locked">Lock</option>
              <option value="unlocked">Unlock</option>
            </select>
          </div>
          <button type="submit" name="roster-submit" class="btn standard mb-4">SUBMIT</button>
        </form>
        <p class="download"><a href="../includes/allAgencyRoster.inc.php">Download Rosters</a></p>
      </div>

      <div class="wrapper col-12 col-md-5 mb-5">
        <h2 class="text-center">EMPLOYEE TRAINING</h2>
        <a href="./emp-accounts.php?period=<?php echo $costReportStatus; ?>"><button type="button" class="btn standard mb-4">VIEW ACCOUNTS</button></a>
        <!--<button type="button" class="btn standard mb-4" data-toggle="modal" data-target="#employeeModal">CREATE ACCOUNTS</button>-->
        <h5><i>View the employee training accounts for the <?php echo $costReportStatus; ?> time period.</i></h5>
      </div>
    </div>

    <div class="row justify-content-around text-center">
      <div class="wrapper col-12 col-md-5 mb-5">
        <h2 class="text-center">COST REPORT</h2>
        <h5 class="text-center">Current Period: <?php echo $costReportStatus; ?></h5>
        <form class="costControlForm" action="../includes/costReport.inc.php" method="post">
          <div class="form-group">
            <select class="form-control" name="report-period">
              <option value="">SELECT CURRENT PERIOD</option>
              <option value="2020-Q1">2020-Q1</option>
              <option value="2020-Q2">2020-Q2</option>
              <option value="2020-Q3">2020-Q3</option>
              <option value="2020-Q4">2020-Q4</option>
              <option value="2021-Q1">2021-Q1</option>
              <option value="2021-Q2">2021-Q2</option>
              <option value="2021-Q3">2021-Q3</option>
              <option value="2021-Q4">2021-Q4</option>
            </select>
          </div>
          <button type="submit" name="report-submit" class="btn standard mb-4">SUBMIT</button>
        </form>
      </div>

      <div class="wrapper col-12 col-md-5 mb-5">
        <h2 class="text-center">TIME STUDY REPORT</h2>
        <h5 class="text-center">Current Period: <?php echo $costReportStatus; ?></h5><br>
        <p class="download"><a href="../includes/timestudyReportByEmp.inc.php">Final Results</a></p>
        <!--<p class="download"><a href="../includes/timestudyReportByAgency.inc.php">Final Results (Agency)</a></p>-->
        <!--<p class="download"><a href="../includes/timestudyReportProgress.inc.php">Employee Progress</a></p>-->
        <form class="agencyReportForm" action="../includes/timestudyReportBeta.inc.php?q=<?php echo $costReportStatus; ?>" method="post">
          <div class="form-group">
            <select class="form-control" name="agencyReportForm">
              <option value="">SELECT AGENCY</option>
              <?php 
                foreach ($agencyList as $agency) {
                  if ($agency[0] != '808') { // 808 -> testing agency
                    echo "<option value=$agency[0]>$agency[1]</option>";
                  }
                }
              ?>
            </select>
          </div>
          <button type="submit" name="results-submit" class="btn standard mb-4">SUBMIT</button>
        </form>
      </div>
    </div>

    <div class="row justify-content-around text-center">
      <div class="wrapper col-12 col-md-4">
        <h2 class="text-center">AGENCY USERS</h2>
        <h5 class="text-center">Manage agency users</h5>
        <form class="costControlForm" action="newAgencyUser.php" method="post">
          <button type="submit" name="report-submit" class="btn standard mb-4">SUBMIT</button>
        </form>
      </div>
    </div>

    <!-- Account Confirm Modal -->
    <div class="modal fade" id="employeeModal" tabindex="-1" role="dialog" aria-labelledby="employeeModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="employeeModalLabel">Confirm Account Creation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            This action will erase any previous accounts for the <?php echo $costReportStatus; ?> time period. Continue?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <!--<button type="button" class="btn btn-primary">Continue</button>-->
            <form action="./emp-training.php" method="post">
              <button type="submit" name="generate-submit" class="btn btn-primary">Continue</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>