<?php
    require 'db.inc.php';
    require 'getQuarter.inc.php';

    $mhfrpid = $_GET['id'];
    $weekendDays = ['6', '7'];

    $sql1 = "DELETE FROM employee_timestudy WHERE mhfrpid = ? AND (log_day = ? OR log_day = ?)";
    $stmt1 = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt1, $sql1);
    mysqli_stmt_bind_param($stmt1, "sss", $mhfrpid, $weekendDays[0], $weekendDays[1]);
    mysqli_stmt_execute($stmt1);

    foreach ($weekendDays as $day) {
        for ($i = 1; $i <= 48; $i++) {
            $day = $day;
            $time = $i;
            $code = 'O';
            $desc = 'Not scheduled to work - Code O';

            $sql = "INSERT INTO employee_timestudy (mhfrpid, log_day, log_time, log_code, log_desc, quarter) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "isssss", $mhfrpid, $day, $time, $code, $desc, $currentQuarter);
            mysqli_stmt_execute($stmt);
        }
    }

    //header("Location: ../timestudy?id=$mhfrpid&d=$currentDay&success=402");
    header("Location: ../timestudy?id=$mhfrpid");
?>