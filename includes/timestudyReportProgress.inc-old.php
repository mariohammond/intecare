<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

    require 'db.inc.php';

    $agencyId = $_COOKIE['agencyId'];
    $finalData = [];
    $finalHeaders = [];

    // Get current time study period
    $sqlA = "SELECT `value` FROM options WHERE optionName = 'current-time-study'";
    $stmtA = $conn->prepare($sqlA);
    mysqli_stmt_execute($stmtA);
    $resultA = mysqli_stmt_get_result($stmtA);
    $currentQuarter = mysqli_fetch_all($resultA)[0][0];
    $stmtA->close();

    // Get employee timestudy progress
    $sql = "SELECT options.value AS `Qtr End Date`, positions.positionName AS `Position`, agencies.AgencyName AS `Center`, employees.LastName AS `Last Name`, employees.FirstName AS `First Name`, selected.mhfrpid AS `ID` 
    FROM employee_selected AS selected 
    INNER JOIN agency_employees AS employees ON employees.systemID = selected.employee_systemId 
    INNER JOIN positions AS positions ON positions.positionId = employees.PositionID 
    INNER JOIN agencies AS agencies ON agencies.AgencyId = employees.InteCareAgencyID 
    INNER JOIN options AS options 
    WHERE selected.time_period = ? 
    GROUP BY selected.employee_systemId
    ORDER BY agencies.AgencyName, employees.LastName";

    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $currentQuarter);
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

        // SPMP vs NON-SPMP
        if ($data[1] == 'Nurse') {
            $data[1] = $data[1] . " SPMP";
        } else if($data[1] == 'Therapist') {
            $data[1] = $data[1] . " SPMP";
        } else if($data[1] == 'Physician') {
            $data[1] = $data[1] . " SPMP";
        } else if($data[1] == 'Psychologist') {
            $data[1] = $data[1] . " SPMP";
        } else if($data[1] == 'Social Worker MSW') {
            $data[1] = $data[1] . " SPMP";
        } else {
            $data[1] = $data[1] . " Non-SPMP";
        }

        // transform the quarter-year from YYYY-QX to Q-YY
        $qyear = explode("-", $data[0]);
        $yy = substr($qyear[0],2,2);
        $q = substr($qyear[1],1,1);
        $data[0] = $q . "-" . $yy;

        $replacements = array(0 => $endDate);
        $tempData = array_replace($data, $replacements);

        // Timestudy Progress
        for ($i = 1; $i <= 7; $i++) {
            $sql1 = "SELECT COUNT(*) AS count 
            FROM employee_timestudy 
            WHERE mhfrpid = ? AND log_day = ? AND log_code <> '' AND log_desc <> ''";
            
            $stmt1 = $conn->prepare($sql1);
            mysqli_stmt_bind_param($stmt1, "ss", $tempData[5], $i);
            mysqli_stmt_execute($stmt1);
            $result1 = mysqli_stmt_get_result($stmt1);

            $progressData = mysqli_fetch_assoc($result1);
            $progressCount = $progressData["count"];
            $progressPercent = round($progressCount / 48 * 100);
            $progress = $progressPercent . '%';

            array_push($tempData, $progress);
        }

        // Check for signature
        $sql2 = "SELECT COUNT(*) AS count 
        FROM employee_training 
        WHERE mhfrpid = ? AND `signature` <> '' AND completionDate <> ''";
        
        $stmt2 = $conn->prepare($sql2);
        mysqli_stmt_bind_param($stmt2, "s", $tempData[5]);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);

        $signatureData = mysqli_fetch_assoc($result2);
        $signatureCount = $signatureData["count"];

        if ($signatureCount > 0) {
            $signatureStatus = 'COMPLETE';
        } else {
            $signatureStatus = 'INCOMPLETE';
        }

        array_push($tempData, $signatureStatus);

        // Push all data into final array
        array_push($finalData, $tempData);
    }
    
    $xls_filename = 'EmpTimestudyProgress_' . $reportData[0][0] . '.xls';
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
        "Day 1 (MON)", "Day 2 (TUES)", "Day 3 (WED)", "Day 4 (THUR)", "Day 5 (FRI)", "Day 6 (SAT)", "Day 7 (SUN)", "SIGNATURE"
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