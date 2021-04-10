<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require "../includes/adminCheck.inc.php";
  require "../includes/rosterLock.inc.php";
  require "../includes/costReport.inc.php";
  require "./header.php";

  include "./nav.php";
  
  // Get all agency ids
  /*$sql0 = "SELECT AgencyName, AgencyId FROM agencies limit 1";
  $stmt0 = $conn->prepare($sql0);
  mysqli_stmt_execute($stmt0);
  $result0 = mysqli_stmt_get_result($stmt0);
  $agencyList = mysqli_fetch_all($result0);
  $agencyCount = mysqli_num_rows($result0);
  $stmt0->close();*/

  // Remove all accounts for selected time period
  $sql1A = "DELETE FROM employee_selected WHERE time_period = ?";
  $stmt1A = $conn->prepare($sql1A);
  mysqli_stmt_bind_param($stmt1A, "s", $costReportStatus);
  mysqli_stmt_execute($stmt1A);
  $stmt1A->close();

  $sql1B = "DELETE FROM employee_login WHERE employee_time_period = ?";
  $stmt1B = $conn->prepare($sql1B);
  mysqli_stmt_bind_param($stmt1B, "s", $costReportStatus);
  mysqli_stmt_execute($stmt1B);
  $stmt1B->close();

  // Get total number of employees
  $sql2 = "SELECT COUNT(*) FROM agency_employees";
  $stmt2 = $conn->prepare($sql2);
  mysqli_stmt_execute($stmt2);
  $result2 = mysqli_stmt_get_result($stmt2);
  $employeeTotal = mysqli_fetch_all($result2);
  $stmt2->close();

  // Get all positions
  $sqlZ = "SELECT positionId, positionName FROM positions WHERE positionId != 14";
  $stmtZ = $conn->prepare($sqlZ);
  mysqli_stmt_execute($stmtZ);
  $resultZ = mysqli_stmt_get_result($stmtZ);
  $positionList = mysqli_fetch_all($resultZ);
  $stmtZ->close();

  $calculatedTotalNS = 0;
  $calculatedFinal = 0;
  $populationSquared = 25000000;
  $estError = 0.000625;
  $calculatedQuotient;
  $positionCountArray = [];
  
  foreach ($positionList as $position) {
    $sql3 = "SELECT COUNT(*) FROM agency_employees WHERE PositionID = ?";
    $stmt3 = $conn->prepare($sql3);
    mysqli_stmt_bind_param($stmt3, "s", $position[0]);
    mysqli_stmt_execute($stmt3);
    $result3 = mysqli_stmt_get_result($stmt3);
    $positionCount = mysqli_fetch_all($result3);
    //var_dump($positionCount);
    $stmt3->close();

    // Calculate position weight
    $calculatedNS = $positionCount[0][0] * 0.25;
    $calculatedTotalNS += $calculatedNS;
    //echo $calculatedTotalNS . '<br>';
    
    $calculatedProduct1 = 5000 * $estError;
    $calculatedProduct2 = $calculatedTotalNS / 5000;
    $calculatedSum = $calculatedProduct1 + $calculatedProduct2;
    $calculatedQuotient = $calculatedTotalNS / $calculatedSum;
    //echo $calculatedQuotient . '<br>';
  }

  foreach ($positionList as $position) {
    $sql3 = "SELECT COUNT(*) FROM agency_employees WHERE PositionID = ?";
    $stmt3 = $conn->prepare($sql3);
    mysqli_stmt_bind_param($stmt3, "s", $position[0]);
    mysqli_stmt_execute($stmt3);
    $result3 = mysqli_stmt_get_result($stmt3);
    $positionCount = mysqli_fetch_all($result3);
    $stmt3->close();

    $calculatedWeight = $positionCount[0][0] / $employeeTotal[0][0];
    $calculatedFinal = ceil($calculatedWeight * $calculatedQuotient * 1.1);
    array_push($positionCountArray, $calculatedFinal);
    //echo $calculatedFinal . '<br>';
  }
?>
<script>
$.when(
  <?php foreach ($positionList as $index=>$position) : ?>
  $.ajax({
      type: "GET",
      cache: false,
      url: "../includes/generateEmpList.inc.php?positionId=<?php echo $position[0]; ?>&positionCount=<?php echo $positionCountArray[$index]; ?>",
      success: function(data) {
        $(".agencyProgress ol").append("<li>Completed: <?php echo $position[1]; ?> (" + data + " accounts)</li>");
      },
  }),
  <?php endforeach; ?>
).then(function() {
  window.location.href = "./emp-accounts.php?period=<?php echo $costReportStatus; ?>";
});
</script>

<div class="page-emp-training">
  <div class="container">
    <iframe width="0" height="0" src="https://www.youtube.com/embed/n9v-2xF54HM?autoplay=1&mute=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    <div class="row justify-content-around text-center">
      <div class="wrapper col-10">
        <h2 class="text-center">EMPLOYEE TRAINING ACCOUNTS</h2>
        <h4 class="text-center">Total Positions: 13</h4>
        <hr>
        <div class="agencyProgress">
            <ol></ol>
        </div>
        <button type="button" class="complete-button btn mb-4" onClick="window.location.href = '../admin/index.php?success=training'">COMPLETE</button>
      </div>
    </div>
  </div>
</div>