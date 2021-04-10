<?php
    /* Check/Manage Cost Report Time Period */

    require 'db.inc.php';
    $optionName = "current-time-study";

    if (isset($_POST['report-submit'])) {
        $reportPeriod = $_POST['report-period'];

        if (!empty($reportPeriod)) {
            $sql = "UPDATE options SET value = ? WHERE optionName = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $reportPeriod, $optionName);
            $stmt->execute();
            $stmt->close();

            mysqli_close($conn);
            header("Location: ../admin/index.php?success=costReport");
        } else {
            header("Location: ../admin/index.php?error=101");
        }
    } else {
        $sql = "SELECT * FROM options WHERE optionName = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "s", $optionName);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $report = mysqli_fetch_assoc($result);
        $costReportStatus = $report["value"];
    }
    mysqli_close($conn);
?>