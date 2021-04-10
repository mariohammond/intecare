<?php

if (isset($_POST['signup-submit'])) {
    require 'db.inc.php';

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if any field is empty
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($confirmPassword)) {
        header("Location: ../signup?error=201");
        exit();
    }

    // Check if email is valid
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup?error=202");
        exit();
    }

    // Check if passwords match
    elseif ($password !== $confirmPassword) {
        header("Location: ../signup?error=203");
        exit();
    }

    // Check if email already exists
    else {
        $sql = "SELECT email FROM login_info WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup?error=205");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);

            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);

            // If so, throw error. If not, insert account into database
            if ($resultCheck > 0) {
                header("Location: ../signup?error=204");
                exit();
            } else {
                $sql = "INSERT INTO login_info (role, firstname, lastname, email, password) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);

                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../signup?error=205");
                    exit();
                } else {
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
                    $role = "employee";
                    mysqli_stmt_bind_param($stmt, "sssss", $role, $firstname, $lastname, $email, $hashedPwd);
                    mysqli_stmt_execute($stmt);

                    header("Location: ../agency");
                    exit();
                }
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: ../signup");
    exit();
}