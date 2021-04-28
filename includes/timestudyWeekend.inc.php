<?php
    require 'db.inc.php';
    require 'getQuarter.inc.php';

    $mhfrpid = $_GET['id'];
    $weekendDays = ['6', '7'];

    // Remove previous db entries
    $sql1 = "DELETE FROM employee_timestudy_v2 WHERE mhfrpid = ? AND (log_day = ? OR log_day = ?)";
    $stmt1 = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt1, $sql1);
    mysqli_stmt_bind_param($stmt1, "sss", $mhfrpid, $weekendDays[0], $weekendDays[1]);
    mysqli_stmt_execute($stmt1);

    // Hard-coded data for days 6 and 7
    $day6Info = '6,6,1,O,Vacant Position - Code O,2,O,Vacant Position - Code O,3,O,Vacant Position - Code O,4,O,Vacant Position - Code O,5,O,Vacant Position - Code O,6,O,Vacant Position - Code O,7,O,Vacant Position - Code O,8,O,Vacant Position - Code O,9,O,Vacant Position - Code O,10,O,Vacant Position - Code O,11,O,Vacant Position - Code O,12,O,Vacant Position - Code O,13,O,Vacant Position - Code O,14,O,Vacant Position - Code O,15,O,Vacant Position - Code O,16,O,Vacant Position - Code O,17,O,Vacant Position - Code O,18,O,Vacant Position - Code O,19,O,Vacant Position - Code O,20,O,Vacant Position - Code O,21,O,Vacant Position - Code O,22,O,Vacant Position - Code O,23,O,Vacant Position - Code O,24,O,Vacant Position - Code O,25,O,Vacant Position - Code O,26,O,Vacant Position - Code O,27,O,Vacant Position - Code O,28,O,Vacant Position - Code O,29,O,Vacant Position - Code O,30,O,Vacant Position - Code O,31,O,Vacant Position - Code O,32,O,Vacant Position - Code O,33,O,Vacant Position - Code O,34,O,Vacant Position - Code O,35,O,Vacant Position - Code O,36,O,Vacant Position - Code O,37,O,Vacant Position - Code O,38,O,Vacant Position - Code O,39,O,Vacant Position - Code O,40,O,Vacant Position - Code O,41,O,Vacant Position - Code O,42,O,Vacant Position - Code O,43,O,Vacant Position - Code O,44,O,Vacant Position - Code O,45,O,Vacant Position - Code O,46,O,Vacant Position - Code O,47,O,Vacant Position - Code O,48,O,Vacant Position - Code O';
    $day7Info = '7,7,1,O,Vacant Position - Code O,2,O,Vacant Position - Code O,3,O,Vacant Position - Code O,4,O,Vacant Position - Code O,5,O,Vacant Position - Code O,6,O,Vacant Position - Code O,7,O,Vacant Position - Code O,8,O,Vacant Position - Code O,9,O,Vacant Position - Code O,10,O,Vacant Position - Code O,11,O,Vacant Position - Code O,12,O,Vacant Position - Code O,13,O,Vacant Position - Code O,14,O,Vacant Position - Code O,15,O,Vacant Position - Code O,16,O,Vacant Position - Code O,17,O,Vacant Position - Code O,18,O,Vacant Position - Code O,19,O,Vacant Position - Code O,20,O,Vacant Position - Code O,21,O,Vacant Position - Code O,22,O,Vacant Position - Code O,23,O,Vacant Position - Code O,24,O,Vacant Position - Code O,25,O,Vacant Position - Code O,26,O,Vacant Position - Code O,27,O,Vacant Position - Code O,28,O,Vacant Position - Code O,29,O,Vacant Position - Code O,30,O,Vacant Position - Code O,31,O,Vacant Position - Code O,32,O,Vacant Position - Code O,33,O,Vacant Position - Code O,34,O,Vacant Position - Code O,35,O,Vacant Position - Code O,36,O,Vacant Position - Code O,37,O,Vacant Position - Code O,38,O,Vacant Position - Code O,39,O,Vacant Position - Code O,40,O,Vacant Position - Code O,41,O,Vacant Position - Code O,42,O,Vacant Position - Code O,43,O,Vacant Position - Code O,44,O,Vacant Position - Code O,45,O,Vacant Position - Code O,46,O,Vacant Position - Code O,47,O,Vacant Position - Code O,48,O,Vacant Position - Code O';

    // Enter day 6 info
    $sql2 = "INSERT INTO employee_timestudy_v2 (mhfrpid, quarter, log_day, log_info) VALUES (?, ?, ?, ?)";
    $stmt2 = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt2, $sql2);
    mysqli_stmt_bind_param($stmt2, "isss", $mhfrpid, $currentQuarter, $weekendDays[0], $day6Info);
    mysqli_stmt_execute($stmt2);

    // Enter day 7 info
    $sql3 = "INSERT INTO employee_timestudy_v2 (mhfrpid, quarter, log_day, log_info) VALUES (?, ?, ?, ?)";
    $stmt3 = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt3, $sql3);
    mysqli_stmt_bind_param($stmt3, "isss", $mhfrpid, $currentQuarter, $weekendDays[1], $day7Info);
    mysqli_stmt_execute($stmt3);

    header("Location: ../timestudy?id=$mhfrpid&d=6");
?>