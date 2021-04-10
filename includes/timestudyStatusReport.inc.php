<?php
    error_reporting(E_ALL); ini_set('display_errors', 1);
    require 'db.inc.php';

    //$mhfrpid = $_COOKIE['mhfrpid'];
    $weekCheck = [];
    $completed = true;

    //query to get all data needed
    //$sql0 = "SELECT positions.positionName AS `Position`, timestudy.mhfrpid AS `MHFRPID`, employees.FirstName, employees.LastName, timestudy.log_day, timestudy.log_time, timestudy.log_code, timestudy.log_desc, agencies.AgencyName FROM employee_timestudy AS timestudy INNER JOIN agency_employees AS employees ON employees.MHFRPID = timestudy.mhfrpid INNER JOIN positions AS positions ON positions.positionId = employees.PositionID INNER JOIN agencies AS agencies on agencies.AgencyId = employees.InteCareAgencyID INNER JOIN options AS options WHERE options.optionId = '1' ORDER BY timestudy.mhfrpid DESC";
    
    $sql0 = "SELECT positions.positionName AS `Position`, timestudy.mhfrpid AS `MHFRPID`, employees.FirstName, employees.LastName, timestudy.log_day, timestudy.log_time, timestudy.log_code, timestudy.log_desc, agencies.AgencyName FROM employee_timestudy AS timestudy INNER JOIN agency_employees AS employees ON employees.MHFRPID = timestudy.mhfrpid INNER JOIN positions AS positions ON positions.positionId = employees.PositionID INNER JOIN agencies AS agencies on agencies.AgencyId = employees.InteCareAgencyID INNER JOIN options AS options WHERE options.optionId = '1' ORDER BY timestudy.mhfrpid DESC";
    
    
    //Select all of the entries int he employee_timestudy table and group by mhfrpid.
    //$sql0 = "SELECT * FROM employee_timestudy";
    $stmt0 = $conn->prepare($sql0);
    mysqli_stmt_execute($stmt0);
    $result0 = mysqli_stmt_get_result($stmt0);
    $testers = mysqli_fetch_all($result0);
var_dump($testers); exit;
    //loop through all testers
    foreach ($testers as $tester)
    {
        var_dump($tester); exit;

        // Get count of completed log entries
        for ($i = 1; $i <= 7; $i++) {
            $sql = "SELECT COUNT(*) AS count FROM employee_timestudy WHERE mhfrpid = ? AND log_day = ? AND log_code <> '' AND log_desc <> ''";
            $stmt = $conn->prepare($sql);
            mysqli_stmt_bind_param($stmt, "ss", $mhfrpid, $i);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $logCheck = mysqli_fetch_assoc($result);
            array_push($weekCheck, $logCheck["count"]);
            $stmt->close();
        }

    }
?>