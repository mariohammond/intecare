<?php
    require 'db.inc.php';
    require 'getQuarter.inc.php';

    $mhfrpid = $_GET['id'];
    $allDays = ['1', '2', '3', '4', '5', '6', '7'];

    // Remove previous db entries
    $sql1 = "DELETE FROM employee_timestudy_v2 WHERE mhfrpid = ?";
    $stmt1 = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt1, $sql1);
    mysqli_stmt_bind_param($stmt1, "s", $mhfrpid);
    mysqli_stmt_execute($stmt1);


    // Insert new data into db
    foreach ($allDays as $day) {
        // Hard-coded data
        $dayInfo = "$day,$day,1,O,Unpaid Leave - Code O,2,O,Unpaid Leave - Code O,3,O,Unpaid Leave - Code O,4,O,Unpaid Leave - Code O,5,O,Unpaid Leave - Code O,6,O,Unpaid Leave - Code O,7,O,Unpaid Leave - Code O,8,O,Unpaid Leave - Code O,9,O,Unpaid Leave - Code O,10,O,Unpaid Leave - Code O,11,O,Unpaid Leave - Code O,12,O,Unpaid Leave - Code O,13,O,Unpaid Leave - Code O,14,O,Unpaid Leave - Code O,15,O,Unpaid Leave - Code O,16,O,Unpaid Leave - Code O,17,O,Unpaid Leave - Code O,18,O,Unpaid Leave - Code O,19,O,Unpaid Leave - Code O,20,O,Unpaid Leave - Code O,21,O,Unpaid Leave - Code O,22,O,Unpaid Leave - Code O,23,O,Unpaid Leave - Code O,24,O,Unpaid Leave - Code O,25,O,Unpaid Leave - Code O,26,O,Unpaid Leave - Code O,27,O,Unpaid Leave - Code O,28,O,Unpaid Leave - Code O,29,O,Unpaid Leave - Code O,30,O,Unpaid Leave - Code O,31,O,Unpaid Leave - Code O,32,O,Unpaid Leave - Code O,33,O,Unpaid Leave - Code O,34,O,Unpaid Leave - Code O,35,O,Unpaid Leave - Code O,36,O,Unpaid Leave - Code O,37,O,Unpaid Leave - Code O,38,O,Unpaid Leave - Code O,39,O,Unpaid Leave - Code O,40,O,Unpaid Leave - Code O,41,O,Unpaid Leave - Code O,42,O,Unpaid Leave - Code O,43,O,Unpaid Leave - Code O,44,O,Unpaid Leave - Code O,45,O,Unpaid Leave - Code O,46,O,Unpaid Leave - Code O,47,O,Unpaid Leave - Code O,48,O,Unpaid Leave - Code O";

        $sql2 = "INSERT INTO employee_timestudy_v2 (mhfrpid, quarter, log_day, log_info) VALUES (?, ?, ?, ?)";
        $stmt2 = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt2, $sql2);
        mysqli_stmt_bind_param($stmt2, "isss", $mhfrpid, $currentQuarter, $day, $dayInfo);
        mysqli_stmt_execute($stmt2);
    }

    header("Location: ../timestudy?id=$mhfrpid");
?>