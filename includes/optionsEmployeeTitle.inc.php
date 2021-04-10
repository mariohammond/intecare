<?php
    require 'db.inc.php';

    $sql = 'SELECT * FROM employeetypes';
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'console.log("Database error. Please contact administrator.")';
        exit();
    } else {
        mysqli_stmt_bind_param($stmt);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_all($result);
        foreach ($row as $value) {
            echo '<option value="' . $value[0] . '">' . $value[1] . '</option>';
        }
    }
?>