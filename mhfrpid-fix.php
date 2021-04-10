<?php
    /*ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);*/

    require "header.php";
    require "includes/db.inc.php";

    // Check for employee records with blank MHFRPID
    $sql0 = "SELECT systemID, InteCareAgencyID, FirstName, LastName FROM agency_employees WHERE MHFRPID = ''";
    $stmt0 = $conn->prepare($sql0);
    mysqli_stmt_execute($stmt0);
    $result0 = mysqli_stmt_get_result($stmt0);
    $agencyIds = mysqli_fetch_all($result0);
    $stmt0->close();
    
    //echo "Updated Employee MHFRPID <br>";

    foreach($agencyIds as $agencyId) {
        $currentEmp = $agencyId[0];
        $currentAgency = $agencyId[1];
        $firstName = $agencyId[2];
        $lastName = $agencyId[3];
        $currentName = "$firstName $lastName";
        
        // Get latest MHFRPID from each agency
        $sql1 = "SELECT MHFRPID FROM agency_employees WHERE InteCareAgencyID = ? ORDER BY MHFRPID DESC LIMIT 1";
        $stmt1 = $conn->prepare($sql1);
        mysqli_stmt_bind_param($stmt1, "s", $currentAgency);
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        $latestId = mysqli_fetch_all($result1)[0][0];
        $stmt1->close();

        // Increment latest MHFRPID and update employee record
        $newId = intval($latestId) + 1;

        $sql2 = "UPDATE agency_employees SET MHFRPID = ? WHERE systemID = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("is", $newId, $currentEmp);
        $stmt2->execute();
        $stmt2->close();

        //echo "Name: $currentName -- Agency ID: $currentAgency -- <strong>MHFRPID:</strong> $newId<br>";
    }
?>
