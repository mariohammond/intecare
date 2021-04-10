<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    //require "includes/adminCheck.inc.php";
    //require "includes/rosterLock.inc.php";
    //require "includes/costReport.inc.php";
    require "header.php";
    include "nav.php";

    $agencyId = $_COOKIE['agencyId'];

    // Get current time period
    $sql0 = "SELECT `value` FROM `options` WHERE optionName = 'current-time-study'";
    $stmt0 = $conn->prepare($sql0);
    mysqli_stmt_execute($stmt0);
    $result0 = mysqli_stmt_get_result($stmt0);
    $timePeriod = mysqli_fetch_all($result0)[0][0];
    $stmt0->close();

    // Get agency participants list
    $sql1 = "SELECT agency_employees.FirstName, agency_employees.LastName, agency_employees.Email, agency_employees.MHFRPID FROM employee_selected INNER JOIN agency_employees WHERE employee_selected.mhfrpid = agency_employees.MHFRPID AND agency_id = ? AND time_period = ?";
    $stmt1 = $conn->prepare($sql1);
    mysqli_stmt_bind_param($stmt1, "ss", $agencyId, $timePeriod);
    mysqli_stmt_execute($stmt1);
    $result1 = mysqli_stmt_get_result($stmt1);
    $empList = mysqli_fetch_all($result1);
    $stmt1->close();

    // Get current site
    $serverHost = $_SERVER['HTTP_HOST'];
    if ($serverHost == 'perfectpickem.com') {
        $requestUrl = explode('/', $_SERVER['REQUEST_URI'])[1];
        $currentUrl = 'http://www.' . $serverHost . '/' . $requestUrl;
    } else {
        $currentUrl = 'http://www.' . $serverHost;
    }
?>

<div class="page-emp-accounts">
    <div class="row px-4 py-2">
        <a class="btn btn-primary" href="download-emp-list.php" role="button">Download List</a>
    </div>
    <?php
        // Display employee info
        echo "
            <table class='mb-3'>
            <tr>
            <th>Name</th>
            <th>Email</th>
            <th>MHFRPID</th>
            <th>Timestudy Link</th>
            <th>Percent Completed</th>
            </tr>
        ";

    foreach ($empList as $emp) {
        // Check employee progress of training pdf
        $sql2 = "SELECT COUNT(*) AS count FROM employee_pdf WHERE mhfrpid = ?";
        $stmt2 = $conn->prepare($sql2);
        mysqli_stmt_bind_param($stmt2, "s", $emp[3]);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $pgData = mysqli_fetch_assoc($result2);
        $pgCount = round(intval($pgData['count']) / 70 * 100);
        $pgCountText = $pgCount . '%';
        array_push($emp, $pgCountText);
        $stmt2->close();

        // Display table
        echo "
        <tr>
            <td>$emp[0] $emp[1]</td>
            <td>$emp[2]</td>
            <td>$emp[3]</td>
            <td><a href='timestudy?id=$emp[3]' target='_blank'>$currentUrl/timestudy?id=$emp[3]</a></td>
            <td>$emp[4]</td>
        </tr>
        ";
    }
    echo "</table>";
?>
</div>