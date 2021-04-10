<?php
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);

    require 'db.inc.php';

    $agencyId = $_COOKIE['agencyId'];

    $sql = "SELECT emp.Email, emp.LastName, emp.FirstName, positions.positionName, emp.MHFRPID, emp.AgencyEmployeeID, agencies.AgencyName, emp.LocationCode, employeetypes.employeeTypeName AS EmployeeType, emp.Active, emp.StartDate, emp.EndDate FROM agency_employees AS emp INNER JOIN agencies ON emp.InteCareAgencyID = agencies.AgencyId INNER JOIN positions ON emp.PositionID = positions.positionId INNER JOIN employeetypes ON emp.EmployeeType = employeetypes.employeeTypeID WHERE agencies.AgencyID = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $agencyId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $agencyData = mysqli_fetch_all($result);

    $agencyName = str_replace(",", "", $agencyData[0][6]);
    $xls_filename = $agencyName . '_roster_' . date('Y-m-d') . '.xls';

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
?>
