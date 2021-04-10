<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

    require 'db.inc.php';

    $finalData = [];
    $finalHeaders = [];

    $formQuarter = $_GET['q'];
    if (isset($_POST['agencyReportForm'])) {
        $formAgencyId = $_POST['agencyReportForm'];
    } else {
        $formAgencyId = $_GET['a'];
    }
    
    $sql = "SELECT timestudy.quarter, timestudy.positionName, timestudy.AgencyName, timestudy.FirstName, timestudy.LastName, timestudy.mhfrpid, timestudy.log_day, timestudy.log_time
    FROM employee_timestudy_flat AS timestudy
    WHERE quarter = ? AND InteCareAgencyID = ?";

    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $formQuarter, $formAgencyId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $reportData = mysqli_fetch_all($result);

    var_dump($reportData);

    foreach ($reportData as $data) {
        $quarter = $data[0];
        $position = $data[1];
        $agencyName = $data[2];
        $firstName = $data[3];
        $lastName = $data[4];
        $mhfrpid = $data[5];
        $logDay = $data[6];
        $logTime = $data[7];

        // Qtr End Date
        $endDateInfo = explode("-", $quarter);
        if ($endDateInfo[1] == 'Q1') {
            $endDate = "3/31/$endDateInfo[0]";
        } else if ($endDateInfo[1] == 'Q2') {
            $endDate = "6/30/$endDateInfo[0]";
        } else if ($endDateInfo[1] == 'Q3') {
            $endDate = "9/30/$endDateInfo[0]";
        } else {
            $endDate = "12/31/$endDateInfo[0]";
        }

        //echo "<br><br>" . $endDate;
        
        // SPMP vs NON-SPMP
        if ($position == 'Nurse' || $position == 'Therapist' || $position == 'Physician' || $position == 'Psychologist' || $position == 'Social Worker MSW') {
            $position = $position . " SPMP";
        } else {
            $position = $position . " Non-SPMP";
        }

        //echo "<br><br>" . $position;

        // Employee Name
        $fullName = $lastName . ", " . $firstName;

        //echo "<br><br>" . $fullName;

        // Quarter w/ Day
        // Transform the quarter-year from YYYY-QX to Q-YY
        $qyear = explode("-", $quarter);
        $yy = substr($qyear[0], 2, 2);
        $q = substr($qyear[1], 1,1 );
        $quarterInfo = $q . "-" . $yy;

        //echo "<br><br>" . $quarterInfo . "<br><br>";

        if ($logDay == '1') {
            $quarterWithDay = $quarterInfo . "-MON"; 
        } else if ($logDay == '2') {
            $quarterWithDay = $quarterInfo . "-TUES"; 
        } else if ($logDay == '3') {
            $quarterWithDay = $quarterInfo . "-WED"; 
        } else if ($logDay == '4') {
            $quarterWithDay = $quarterInfo . "-THURS"; 
        } else if ($logDay == '5') {
            $quarterWithDay = $quarterInfo . "-FRI"; 
        } else if ($logDay == '6') {
            $quarterWithDay = $quarterInfo . "-SAT"; 
        } else if ($logDay == '7') {
            $quarterWithDay = $quarterInfo . "-SUN"; 
        }

        $replacements = array(0 => $endDate, 1 => $position, 3 => $fullName, 6 => $quarterWithDay);
        $tempData = array_replace($data, $replacements);

        //var_dump($tempData);
        
        // Code and Desc
        $sql1 = "SELECT log_code, log_desc FROM employee_timestudy_flat WHERE mhfrpid = ? AND log_day = ?";
        $stmt1 = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt1, $sql1);
        mysqli_stmt_bind_param($stmt1, "ss", $mhfrpid, $logDay);
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        $codeData = mysqli_fetch_all($result1);

        foreach ($codeData as $cd) {
            array_push($tempData, $cd[0], $cd[1]);
        }        
        array_push($finalData, $tempData);

        //echo "<br><br>";
        //var_dump($finalData);
        //exit;
    }
    
    //var_dump ($finalData); exit;
    
    $xls_filename = 'INFinalResultsByAgency_' . $formAgencyId . '.xls';
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=$xls_filename");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Excel Formatting
    $sep = "\t";

    // Add column names
    for ($i = 0; $i < $result->field_count; $i++) {
        if ($i != 4) { // lastname field not needed
            array_push($finalHeaders, $result->fetch_field_direct($i)->name);
        }
    }

    $codeHeaders = [
        "0Min1-Code", "0Min1-Desc", "15Min1-Code", "15Min1-Desc", "30Min1-Code", "30Min1-Desc", "45Min1-Code", "45Min1-Desc", "0Min2-Code", "0Min2-Desc", "15Min2-Code", "15Min2-Desc", "30Min2-Code", "30Min2-Desc", "45Min2-Code", "45Min2-Desc", "0Min3-Code", "0Min3-Desc", "15Min3-Code", "15Min3-Desc", "30Min3-Code", "30Min3-Desc", "45Min3-Code", "45Min3-Desc", "0Min4-Code", "0Min4-Desc", "15Min4-Code", "15Min4-Desc", "30Min4-Code", "30Min4-Desc", "45Min4-Code", "45Min4-Desc", "0Min5-Code", "0Min5-Desc", "15Min5-Code", "15Min5-Desc", "30Min5-Code", "30Min5-Desc", "45Min5-Code", "45Min5-Desc", "0Min6-Code", "0Min6-Desc", "15Min6-Code", "15Min6-Desc", "30Min6-Code", "30Min6-Desc", "45Min6-Code", "45Min6-Desc", "0Min7-Code", "0Min7-Desc", "15Min7-Code", "15Min7-Desc", "30Min7-Code", "30Min7-Desc", "45Min7-Code", "45Min7-Desc", "0Min8-Code", "0Min8-Desc", "15Min8-Code", "15Min8-Desc", "30Min8-Code", "30Min8-Desc", "45Min8-Code", "45Min8-Desc", "0Min9-Code", "0Min9-Desc", "15Min9-Code", "15Min9-Desc", "30Min9-Code", "30Min9-Desc", "45Min9-Code", "45Min9-Desc", "0Min10-Code", "0Min10-Desc", "15Min10-Code", "15Min10-Desc", "30Min10-Code", "30Min10-Desc", "45Min10-Code", "45Min10-Desc", "0Min11-Code", "0Min11-Desc", "15Min11-Code", "15Min11-Desc", "30Min11-Code", "30Min11-Desc", "45Min11-Code", "45Min11-Desc", "0Min12-Code", "0Min12-Desc", "15Min12-Code", "15Min12-Desc", "30Min12-Code", "30Min12-Desc", "45Min12-Code", "45Min12-Desc"
    ];
    foreach ($codeHeaders as $ch) {
        array_push($finalHeaders, $ch);
    }

    // Print headers
    foreach ($finalHeaders as $fh) {
        echo $fh . $sep;
    }

    print("\n");

    // Print data
    foreach ($finalData as $data) {
        $schema_insert = "";
        for ($j = 0; $j < count($data); $j++) {
            if ($j != 4) { // firstname
                if (!isset($data[$j])) {
                    $schema_insert .= "NULL" . $sep;
                } elseif ($data[$j] != "") {
                    $schema_insert .= "$data[$j]" . $sep;
                } else {
                    $schema_insert .= "" . $sep;
                }
            }
        }
        $schema_insert = str_replace($sep . "$", "", $schema_insert);
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";

        print(trim($schema_insert));
        print "\n";
    }
?>