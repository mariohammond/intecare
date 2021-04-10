<?php
    require 'db.inc.php';

    $mhfrpid = $_GET['id'];
    $currentDay = $_GET['currentday'];
    require 'getQuarter.inc.php';

    for ($i = 33; $i <= 48; $i++) {
        $sql1 = "DELETE FROM employee_timestudy WHERE mhfrpid = ? AND log_day = ? AND log_time = ?";
        $stmt1 = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt1, $sql1);
        mysqli_stmt_bind_param($stmt1, "sss", $mhfrpid, $currentDay, $i);
        mysqli_stmt_execute($stmt1);
    }

    //foreach ($weekendDays as $day) {
        for ($j = 33; $j <= 48; $j++) {
            //$day = $day;
            $time = $j;
            $code = 'O';
            $desc = 'Work shift completed - Code O';

            $sql = "INSERT INTO employee_timestudy (mhfrpid, log_day, log_time, log_code, log_desc, quarter) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt, $sql);
            mysqli_stmt_bind_param($stmt, "isssss", $mhfrpid, $currentDay, $time, $code, $desc, $currentQuarter);
            mysqli_stmt_execute($stmt);
        }
    //}

    header("Location: ../timestudy?id=$mhfrpid&d=$currentDay&success=404");
?>