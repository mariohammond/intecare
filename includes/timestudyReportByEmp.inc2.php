<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

    require 'db.inc.php';

    $agencyId = $_COOKIE['agencyId'];
    $finalData = [];
    $finalHeaders = [];

    $sql = "SELECT options.value AS `Qtr End Date`, positions.positionName AS `Position`, timestudy.mhfrpid AS `ID`, timestudy.log_day AS `Quarter w/ Day` FROM employee_timestudy_$agencyId AS timestudy INNER JOIN agency_employees AS employees ON employees.MHFRPID = timestudy.mhfrpid INNER JOIN positions AS positions ON positions.positionId = employees.PositionID INNER JOIN agencies AS agencies on agencies.AgencyId = employees.InteCareAgencyID INNER JOIN options AS options WHERE options.optionId = '1' AND timestudy.quarter = options.value GROUP BY timestudy.log_day";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $reportData = mysqli_fetch_all($result);

    foreach ($reportData as $data) {
        // Qtr End Date
        $endDateInfo = explode("-", $data[0]);
        if ($endDateInfo[1] == 'Q1') {
            $endDate = "3/31/$endDateInfo[0]";
        } else if ($endDateInfo[1] == 'Q2') {
            $endDate = "6/30/$endDateInfo[0]";
        } else if ($endDateInfo[1] == 'Q3') {
            $endDate = "9/30/$endDateInfo[0]";
        } else {
            $endDate = "12/31/$endDateInfo[0]";
        }

        //SPMP vs NON-SPMP
        if($data[1] == 'Nurse') {
            $data[1] = $data[1] . " SPMP";
        } else if($data[1] == 'Therapist'){
            $data[1] = $data[1] . " SPMP";
        } else if($data[1] == 'Physician'){
            $data[1] = $data[1] . " SPMP";
        } else if($data[1] == 'Psychologist'){
            $data[1] = $data[1] . " SPMP";
        } else if($data[1] == 'Social Worker MSW'){
            $data[1] = $data[1] . " SPMP";
        } else {
            $data[1] = $data[1] . " Non-SPMP";
        }

        // Quarter w/ Day
        $reportDayInfo = $data[3];

        //transform the quarter-year from YYYY-QX to Q-YY
        $qyear= explode("-", $data[0]);
        $yy = substr($qyear[0],2,2);
        $q = substr($qyear[1],1,1);
        $data[0] = $q . "-" . $yy;

        if ($reportDayInfo == '1') {
            $reportDay = $data[0] . "-MON"; 
        } else if ($reportDayInfo == '2') {
            $reportDay = $data[0] . "-TUES"; 
        } else if ($reportDayInfo == '3') {
            $reportDay = $data[0] . "-WED"; 
        } else if ($reportDayInfo == '4') {
            $reportDay = $data[0] . "-THURS"; 
        } else if ($reportDayInfo == '5') {
            $reportDay = $data[0] . "-FRI"; 
        } else if ($reportDayInfo == '6') {
            $reportDay = $data[0] . "-SAT"; 
        } else if ($reportDayInfo == '7') {
            $reportDay = $data[0] . "-SUN"; 
        }

        $replacements = array(0 => $endDate, 3 => $reportDay);
        $tempData = array_replace($data, $replacements);

        // Code and Desc
        $sql1 = "SELECT log_code FROM employee_timestudy WHERE mhfrpid = ? AND log_day = ?";
        $stmt1 = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt1, $sql1);
        mysqli_stmt_bind_param($stmt1, "is", $data[2], $reportDayInfo);
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        $codeData = mysqli_fetch_all($result1);

        foreach ($codeData as $cd) {
            array_push($tempData, $cd[0]);
        }        
        array_push($finalData, $tempData);
    }
    
    $xls_filename = 'INFinalResults_' . $reportData[0][0] . '.xls';
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=$xls_filename");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Excel Formatting
    $sep = "\t";

    // Add column names
    for ($i = 0; $i < $result->field_count; $i++) {
        array_push($finalHeaders, $result->fetch_field_direct($i)->name);
    }

    $codeHeaders = [
        "0Min1-Code", "15Min1-Code", "30Min1-Code", "45Min1-Code", "0Min2-Code", "15Min2-Code", "30Min2-Code", "45Min2-Code", "0Min3-Code", "15Min3-Code", "30Min3-Code", "45Min3-Code", "0Min4-Code", "15Min4-Code", "30Min4-Code", "45Min4-Code", "0Min5-Code", "15Min5-Code", "30Min5-Code", "45Min5-Code", "0Min6-Code", "15Min6-Code", "30Min6-Code", "45Min6-Code", "0Min7-Code", "15Min7-Code", "30Min7-Code", "45Min7-Code", "0Min8-Code", "15Min8-Code", "30Min8-Code", "45Min8-Code", "0Min9-Code", "15Min9-Code", "30Min9-Code", "45Min9-Code", "0Min10-Code", "15Min10-Code", "30Min10-Code", "45Min10-Code", "0Min11-Code", "15Min11-Code", "30Min11-Code", "45Min11-Code", "0Min12-Code", "15Min12-Code", "30Min12-Code", "45Min12-Code"
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
            if (!isset($data[$j])) {
                $schema_insert .= "NULL" . $sep;
            } elseif ($data[$j] != "") {
                $schema_insert .= "$data[$j]" . $sep;
            } else {
                $schema_insert .= "" . $sep;
            }
        }
        $schema_insert = str_replace($sep . "$", "", $schema_insert);
        $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
        $schema_insert .= "\t";

        print(trim($schema_insert));
        print "\n";
    }
?>