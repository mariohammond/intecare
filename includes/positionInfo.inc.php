<?php
    require 'db.inc.php';
    $agencyId = $_COOKIE['agencyId'];
    $positionId = isset($_GET['id']) ? $_GET['id'] : '1';
    $employeeInfo = [];
    $empty = ['empty'];

    // Highlight selected position
    echo '<script>$(function() { $("#positionSelect2 option[value=\"' . $positionId . '\"]").attr("selected", true); }); </script>';

    // Get employee data from db
    $sql = "SELECT agency_employees.*, positions.* FROM positions INNER JOIN agency_employees ON positions.positionId = agency_employees.PositionID WHERE agency_employees.inteCareAgencyID = ? AND positions.positionId = ? ORDER BY agency_employees.active DESC, agency_employees.lastname";
    $stmt = mysqli_stmt_init($conn);

    // Throw error if db issue
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../?error=304");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "si", $agencyId, $positionId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_all($result);

        // Push empty array if no results found
        if (empty($row)) {
            array_push($employeeInfo, $empty);
        }
        foreach ($row as $value) {
            array_push($employeeInfo, $row);
        }

        return $employeeInfo;
    }
