<?php
    require 'db.inc.php';

    $sql = 'SELECT * FROM agencies ORDER BY AgencyName';
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'console.log("Database error. Please contact administrator.")';
        exit();
    } else {
        mysqli_stmt_bind_param($stmt);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $agencies = mysqli_fetch_all($result);
        foreach ($agencies as $agency) {
            echo '<option value="' . $agency[1] . '">' . $agency[0] . '</option>';
        }
    }
?>