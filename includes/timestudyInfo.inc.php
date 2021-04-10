<?php
    require 'db.inc.php';

    $mhfrpid = $_GET['id'];

    // Get employee data from db
    $sql = "SELECT agency_employees.*, positions.* FROM positions INNER JOIN agency_employees ON positions.positionId = agency_employees.PositionID WHERE agency_employees.MHFRPID = ?";
    $stmt = mysqli_stmt_init($conn);

    // Throw error is db issue
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../?error=304");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $mhfrpid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $timeStudyInfo = mysqli_fetch_assoc($result);

        return $timeStudyInfo;
    }
