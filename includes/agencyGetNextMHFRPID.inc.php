<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

    require 'db.inc.php';

    //$agencyId = $_COOKIE['agencyId'];
    //$agencyId = '423';
    echo $_SERVER["QUERY_STRING"];
    parse_str($_SERVER["QUERY_STRING"]);

    //$sql = "SELECT emp.Email, emp.LastName, emp.FirstName, positions.positionName, emp.MHFRPID, emp.AgencyEmployeeID, agencies.AgencyName, emp.LocationCode, EmployeeTypes.employeeTypeName AS EmployeeType, emp.Active, emp.StartDate, emp.EndDate FROM agency_employees as emp INNER JOIN agencies ON emp.InteCareAgencyID = agencies.AgencyId INNER JOIN positions ON emp.PositionID = positions.positionId INNER JOIN EmployeeTypes ON emp.EmployeeType = EmployeeTypes.employeeTypeID";
    $sql = "SELECT emp.MHFRPID FROM agency_employees as emp WHERE emp.InteCareAgencyID = " . $agencyId . " ORDER BY emp.MHFRPID DESC";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $agencyData = mysqli_fetch_all($result);
    $nextID = $agencyData[0][0]+1;
    echo "Starting MHRFPID is " . $nextID . "<br/>";

    //select all of the employees with blank MHFRPID for the current agency.
    $sql = "SELECT * FROM agency_employees as emp where emp.MHFRPID = '' AND emp.InteCareAgencyID = " . $agencyId . "; ";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $empData = mysqli_fetch_all($result);
    //echo $empData[0][0] . "<br/><br/><br/><br/><br/><br/>";
    $counter = 0;
    //loop through all of the employees
    foreach ($empData as $data) {
      $sysId = $data[0];

      //generate the sql to update the current row
      $sql = "UPDATE `agency_employees` SET `IdNumber` = '" . $nextID . "', `MHFRPID` = '" . $nextID . "' WHERE `agency_employees`.`systemID` = " . $sysId . ";";
      $stmt = mysqli_stmt_init($conn);
      mysqli_stmt_prepare($stmt, $sql);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      //var_dump($result);

      //echo $sql . "<br/>";
      $nextID = $nextID + 1;
      $counter = $counter+1;
    }
    echo "Finished processing " . $counter . " records";




/*
    $agencyName = str_replace(",", "", $agencyData[0][6]);
    $xls_filename = 'rosters_' . date('Y-m-d') . '.xls';

    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=$xls_filename");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Excel Formatting
    $sep = "\t";

    // Add column names
    for ($i = 0; $i < $result->field_count; $i++) {
        echo $result->fetch_field_direct($i)->name . "\t";
    }

    print("\n");

    // Add data
    foreach ($agencyData as $data) {
        $schema_insert = "";
        for ($j = 0; $j < $result->field_count; $j++) {
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
    */
?>
