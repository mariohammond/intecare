<?php
    require 'db.inc.php';
    $agencyId = $_COOKIE['agencyId'];
    $positionId = isset($_GET['id']) ? $_GET['id'] : '1';
    $dataInfo = [];
    $empty = ['empty'];

    // Highlight selected position
    echo '<script>$(function() { $("#positionSelect option[value=\"' . $positionId . '\"]").attr("selected", true); }); </script>';

    // Get employee data from db
    $sql = "SELECT agency_employees.FirstName, agency_employees.LastName, agency_data.*, positions.positionName FROM agency_data INNER JOIN agency_employees ON agency_employees.IdNumber = agency_data.IdNumber INNER JOIN positions ON positions.positionId = agency_employees.PositionID WHERE agency_data.InteCareAgencyID = ? AND agency_data.PositionTitle = ? ORDER BY agency_employees.lastname";
    $stmt = mysqli_stmt_init($conn);

    // Throw error if db issue
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../?error=304");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $agencyId, $positionId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_all($result);

        // Push empty array if no results found
        if (empty($row)) {
            array_push($dataInfo, $empty);
        }
        foreach ($row as $value) {
            array_push($dataInfo, $row);
        }

        return $dataInfo;
    }
