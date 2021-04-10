<?php
    if (!isset($_COOKIE['agencyId'])) {
        header("Location: ../");
    }

    if ($_COOKIE['role'] !== 'admin') {
        header("Location: ../");
    }
?>