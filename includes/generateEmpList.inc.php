<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require 'db.inc.php';

    $id = $_GET['positionId'];
    $positionCount = $_GET['positionCount'];

    // Get current time period
    $currentTimeStudy = 'current-time-study';
    $sql2 = "SELECT `value` FROM options WHERE optionName = ?";
    $stmt2 = $conn->prepare($sql2);
    mysqli_stmt_bind_param($stmt2, "s", $currentTimeStudy);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    $period = mysqli_fetch_all($result2)[0][0];
    //$divisor = intval(5 - (substr($period, -1))); // Determine percentage of remaining employees
    $stmt2->close();

    // Gather all employee ids from each agency
    $sql3 = "SELECT agency_employees.MHFRPID FROM agency_employees WHERE agency_employees.MHFRPID NOT IN (SELECT employee_selected.mhfrpid FROM employee_selected) AND agency_employees.PositionID = ?";
    $stmt3 = $conn->prepare($sql3);
    mysqli_stmt_bind_param($stmt3, "s", $id);
    mysqli_stmt_execute($stmt3);
    $result3 = mysqli_stmt_get_result($stmt3);
    $idCount = mysqli_num_rows($result3);
    if ($idCount == 0) { echo '0'; return; }
    $idList = mysqli_fetch_all($result3);
    $stmt3->close();

    // Determine number of participants for this period
    //$trainingCount = intval($idCount / $divisor);
    $trainingCount = $positionCount;

    // Get random participants from list
    $participantIds = [];
    $randomKeys = array_rand($idList, $trainingCount);
    foreach ($randomKeys as $key) {
        array_push($participantIds, $idList[$key]);
    }

    // Create training account for participant
    foreach ($participantIds as $participantId) {
        $sql4 = "SELECT FirstName, LastName, Email, InteCareAgencyID, MHFRPID FROM agency_employees WHERE MHFRPID = ?";
        $stmt4 = $conn->prepare($sql4);
        mysqli_stmt_bind_param($stmt4, "s", $participantId[0]);
        mysqli_stmt_execute($stmt4);
        $result4 = mysqli_stmt_get_result($stmt4);
        $empInfo = mysqli_fetch_all($result4);
        $stmt4->close();

        $firstname = $empInfo[0][0];
        $lastname = $empInfo[0][1];
        $email = $empInfo[0][2];
        $agencyId = $empInfo[0][3];
        $mhfrpid = $empInfo[0][4];
        $password = password_hash($mhfrpid, PASSWORD_DEFAULT);
        $role = 'employee';

        // Add employee account login table in database
        /*$sql5 = "INSERT INTO employee_login (FirstName, LastName, email, `password`, agencyID, `role`, employee_time_period) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt5 = $conn->prepare($sql5);
        $stmt5->bind_param("ssssiss", $firstname, $lastname, $email, $password, $agencyId, $role, $period);
        $stmt5->execute();
        $stmt5->close();*/

        // Add employee account to selected table in database
        $sql6 = "INSERT INTO employee_selected (mhfrpid, agency_id, time_period) VALUES (?, ?, ?)";
        $stmt6 = $conn->prepare($sql6);
        $stmt6->bind_param("sis", $mhfrpid, $agencyId, $period);
        $stmt6->execute();
        $stmt6->close();
    }

    echo $trainingCount;
?>