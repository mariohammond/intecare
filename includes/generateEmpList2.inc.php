<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require 'db.inc.php';

    $id = $_GET['agencyId'];

    // Get current time period
    $currentTimeStudy = 'current-time-study';
    $sql2 = "SELECT `value` FROM options WHERE optionName = ?";
    $stmt2 = $conn->prepare($sql2);
    mysqli_stmt_bind_param($stmt2, "s", $currentTimeStudy);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    $period = mysqli_fetch_all($result2)[0][0];
    $divisor = intval(5 - (substr($period, -1))); // Determine percentage of remaining employees
    $stmt2->close();

    // Gather all employee ids from each agency
    $sql3 = "SELECT MHFRPID FROM agency_employees WHERE InteCareAgencyID = ?";
    $stmt3 = $conn->prepare($sql3);
    //mysqli_stmt_bind_param($stmt3, "s", $agency[0]);
    mysqli_stmt_bind_param($stmt3, "s", $id);
    mysqli_stmt_execute($stmt3);
    $result3 = mysqli_stmt_get_result($stmt3);
    $idCount = mysqli_num_rows($result3);
    $idList = mysqli_fetch_all($result3);
    $stmt3->close();

    // Determine number of participants for this period
    $trainingCount = intval($idCount / $divisor);

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
        $email = $empInfo[0][2]; var_dump($email);
        $password = password_hash($empInfo[0][4], PASSWORD_DEFAULT);
        $agencyId = $empInfo[0][3];
        $role = 'employee';

        // Add employee account to database
        $sql5 = "INSERT INTO employee_login (FirstName, LastName, email, `password`, agencyID, `role`) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt5 = $conn->prepare($sql5);
        $stmt5->bind_param("ssssis", $firstname, $lastname, $email, $password, $agencyId, $role);
        $stmt5->execute();
        $stmt5->close();
    }
?>