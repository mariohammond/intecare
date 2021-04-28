<?php
    //error_reporting(E_ALL);
    //ini_set('display_errors', TRUE);
    //ini_set('display_startup_errors', TRUE);

    require '../includes/db.inc.php';

    $period = $_GET['period'];

    /*$sql = "SELECT agencies.AgencyName, agency_employees.FirstName, agency_employees.LastName, agency_employees.Email, selected.mhfrpid FROM employee_selected AS selected INNER JOIN agency_employees ON agency_employees.MHFRPID = selected.mhfrpid INNER JOIN agencies ON agencies.AgencyId = agency_employees.InteCareAgencyID WHERE selected.time_period = ? ORDER BY agencies.AgencyName";*/

    $sql = "SELECT agency_name, first_name, last_name, email, mhfrpid FROM employee_selected WHERE time_period = ? ORDER BY agency_name";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "s", $period);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $agencyData = mysqli_fetch_all($result);
    $stmt->close();

    // Get training progress data
    $fullData = array();
    
    foreach ($agencyData as $agency) {
        $mhfrpid = $agency[4];
        $sql1 = "SELECT pdfStart, pdfComplete, completionDate FROM employee_training WHERE mhfrpid = ?";
        $stmt1 = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt1, $sql1);
        mysqli_stmt_bind_param($stmt1, "s", $mhfrpid);
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        $progressData = mysqli_fetch_all($result1);

        if (sizeof($progressData) > 0) {
            array_push($agency, $progressData[0][0], $progressData[0][1], $progressData[0][2]);
        } else {
            array_push($agency, '', '', '');
        }
        array_push($fullData, $agency);
        $stmt1->close();
    }

    $xls_filename = 'all_rosters_' . $period . '.xls';

    header ("Content-Type: application/xls");
    header ("Content-Disposition: attachment; filename=$xls_filename");
    header ("Pragma: no-cache");
    header ("Expires: 0");

    echo "
        <table>
            <tr>
                <th>Agency Name</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>MHFRPID</th>
                <th>PDF Start Date</th>
                <th>PDF Completion Date</th>
                <th>Timestudy Completion Date</th>
            </tr>";

            foreach ($fullData as $data) {
                echo "
                <tr>
                    <td>$data[0]</td>
                    <td>$data[1]</td>
                    <td>$data[2]</td>
                    <td>$data[3]</td>
                    <td>$data[4]</td>
                    <td>$data[5]</td>
                    <td>$data[6]</td>
                    <td>$data[7]</td>
                </tr>
                ";
            }
    echo "</table>";
?>
