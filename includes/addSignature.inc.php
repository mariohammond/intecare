<?php
    require 'db.inc.php';

    $mhfrpid = $_COOKIE['mhfrpid'];
    $signature = $_POST['signature'];
    $date = $_POST['date'];
    $comment = $_POST['comment'];
    $yes = 'yes';

    $sql = "INSERT INTO employee_training (mhfrpid, timestudyComplete, `signature`, completionDate, comment) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $mhfrpid, $yes, $signature, $date, $comment);
    mysqli_stmt_execute($stmt);

    header("Location: ../timestudy?id=$mhfrpid&d=1&success=501");
?>