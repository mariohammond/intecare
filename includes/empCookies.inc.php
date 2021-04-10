<?php
    $mhfrpid = $_GET['id'];
    
    // Set employee info and cookies
    $sql = "SELECT FirstName, LastName, InteCareAgencyID FROM agency_employees WHERE MHFRPID = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $mhfrpid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $empInfo = mysqli_fetch_all($result);

    setcookie('role', 'employee', time() + (86400 * 30), "/");
    setcookie('mhfrpid', $mhfrpid, time() + (86400 * 30), "/");
    setcookie('agencyId', $empInfo[0][2], time() + (86400), "/");
    $stmt->close();
?>