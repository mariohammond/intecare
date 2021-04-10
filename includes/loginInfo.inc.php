<?php
    require 'db.inc.php';
    $loginId = $_COOKIE['loginId'];

    // Get login data from db
    $sql = "SELECT FirstName, LastName FROM employee_login WHERE id = ?";
    $stmt = mysqli_stmt_init($conn);

    // Throw error if db issue
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../?error=304");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $loginId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        return $row;
    }
