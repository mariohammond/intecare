<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
if (isset($_POST['login-submit'])) {
    require 'db.inc.php';

    // Get input fields from login form
    $email = $_POST['email'];
    $password = $_POST['password'];
    $checkbox = $_POST['checkbox'];

    // Return with error if field is empty
    if (empty($email) || empty($password)) {
        header("Location: ../?error=101");
        exit();
    }

    else {
        $sql = "SELECT * FROM employee_login WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        // Throw error is db issue
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../?error=104");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // Check if email/password is found in database
            if ($row = mysqli_fetch_assoc($result)) {
                mysqli_stmt_close($stmt);

                // Check if password matches in database
                $pwdCheck = password_verify($password, $row['password']);
                if ($pwdCheck == false) {
                    header("Location: ../?error=103");
                    exit();
                } elseif ($pwdCheck == true) {
                    if (isset($_POST['checkbox'])) {
                        setcookie('agencyId', $row['agencyID'], time() + (86400 * 30), "/");
                        setcookie('loginId', $row['id'], time() + (86400 * 30), "/");
                    } else {
                        setcookie('agencyId', $row['agencyID'], time() + (86400), "/");
                        setcookie('loginId', $row['id'], time() + (86400), "/");
                    }
                    if ($row['role'] == 'employee') {
                        $sql1 = "SELECT MHFRPID FROM agency_employees WHERE email = ?";
                        $stmt1 = mysqli_stmt_init($conn);
                        mysqli_stmt_prepare($stmt1, $sql1);
                        mysqli_stmt_bind_param($stmt1, "s", $email);
                        mysqli_stmt_execute($stmt1);
                        $result1 = mysqli_stmt_get_result($stmt1);
                        $row1 = mysqli_fetch_assoc($result1);

                        setcookie('role', $row['role'], time() + (86400 * 30), "/");
                        setcookie('mhfrpid', $row1['MHFRPID'], time() + (86400 * 30), "/");
                    }
                    if ($row['role'] == 'admin') {
                        setcookie('role', $row['role'], time() + (86400 * 30), "/");
                    }
                    header("Location: ../agency");
                    exit();
                } else {
                    header("Location: ../?error=103");
                    exit();
                }
            } else {
                header("Location: ../?error=102");
                exit();
            }
        }
    }
} else {
    header("Location: ../");
    exit();
}