<?php
    //error_reporting(E_ALL); ini_set('display_errors', 1);
    require 'db.inc.php';

    $timeData = $_POST;
    $day = $timeData["day"];
    $mhfrpid = $_GET['id'];

    // Get current time study period
    $sqlA = "SELECT `value` FROM options WHERE optionName = 'current-time-study'";
    $stmtA = $conn->prepare($sqlA);
    mysqli_stmt_execute($stmtA);
    $resultA = mysqli_stmt_get_result($stmtA);
    $currentQuarter = mysqli_fetch_all($resultA)[0][0];
    $stmtA->close();

    // Delete previous logs for that day
    $sql1 = "DELETE FROM employee_timestudy_v2 WHERE mhfrpid = ? AND log_day = ?";
    $stmt1 = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt1, $sql1);
    mysqli_stmt_bind_param($stmt1, "ss", $mhfrpid, $day);
    mysqli_stmt_execute($stmt1);
    $stmt1->close();

    $prep = array();
    foreach($timeData as $k => $v) {
        $prep[$k] = $v;
    }

    // Convert info array into string
    $arrayString = implode(",", $prep);
    var_dump($arrayString); // Leave un-commented. Issue needs to be checked.

    // Add new daily log
    $info = $arrayString;

    $sql = "INSERT INTO employee_timestudy_v2 (mhfrpid, quarter, log_day, log_info) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "isss", $mhfrpid, $currentQuarter, $day, $info);
    mysqli_stmt_execute($stmt);

    // Redirect to last saved page
    $currentDay = substr($arrayString, 0, 1);
    header("Location: ../timestudy?id=$mhfrpid&d=$currentDay&success=401");
?>