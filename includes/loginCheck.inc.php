<?php
    if (!isset($_COOKIE['agencyId'])) {
        header("Location: ./");
    }

    if ($_COOKIE['role'] === 'admin') {
        header("Location: ./admin/index.php");
    }

    if ($_COOKIE['role'] === 'employee') {
        header("Location: ./training");
    }
?>