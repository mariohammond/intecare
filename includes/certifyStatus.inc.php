<?php
    /* POPULATE CERTIFICATION COUNT (cost-report.php) */

    require 'db.inc.php';
    $nonTime = "14"; // Non-Time Study Category

    // Get all current positions
    $sql = "SELECT * FROM positions WHERE positionId != ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "i", $nonTime);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_all($result);

    // Get count of each position
    foreach ($row as $key=>$value) {
        $agencyId = $_COOKIE['agencyId'];
        $positionId = $value[0];
        $positionName = $value[1];

        // Get active employee count and display
        $sql2 = "SELECT * from agency_data where InteCareAgencyID = ? AND PositionTitle = ? and certified IS NOT NULL";
        $stmt2 = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt2, $sql2);
        mysqli_stmt_bind_param($stmt2, "ss", $agencyId, $positionId);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $certifiedEmployees = mysqli_num_rows($result2);

        // Get inactive employee count and display
        $sql3 = "SELECT * from agency_data where InteCareAgencyID = ? AND PositionTitle = ? and certified IS NULL";
        $stmt3 = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt3, $sql3);
        mysqli_stmt_bind_param($stmt3, "ss", $agencyId, $positionId);
        mysqli_stmt_execute($stmt3);
        $result3 = mysqli_stmt_get_result($stmt3);
        $notCertifiedEmployees = mysqli_num_rows($result3);

        // Display employee count on page
        echo '<div class="category-section col-12 col-md-3">';
        echo '<a href="./agency-data?id=' .  $positionId . '"><h5>' .  strtoupper($positionName) . '</h5></a>';
        echo '<p>' . $certifiedEmployees . ' certified</p>';
        echo '<p>' . $notCertifiedEmployees . ' needing certificates</p>';
        echo '</div>';
    }

    mysqli_close($conn);
?>