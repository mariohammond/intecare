<?php
    require 'db.inc.php';
    $agencyId = $_COOKIE['agencyId'];
    //$vacant = '%vacant%';
    $letter = isset($_GET['lastname']) ? strtoupper($_GET['lastname']) : 'A';
    $letterSql = $letter . '%';
    $employeeInfo = [];
    $empty = ['empty'];

    // Highlight selected letter page
    echo '<script>$(function() { $("#positionSelect option[value=\"0\"]").attr("selected", true); }); </script>';
    echo '<script>$(function() { $("#letterPagination #' . $letter . '").addClass("current-letter"); });</script>';

    // Get employee data from db
    $sql = "SELECT agency_employees.*, positions.* FROM positions INNER JOIN agency_employees ON positions.positionId = agency_employees.PositionID WHERE agency_employees.inteCareAgencyID = ? AND agency_employees.lastname LIKE ? ORDER BY agency_employees.active DESC, agency_employees.lastname";
    $stmt = mysqli_stmt_init($conn);

    // Throw error is db issue
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../?error=304");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $agencyId, $letterSql);
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
