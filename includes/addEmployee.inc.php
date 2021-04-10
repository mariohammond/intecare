<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    /* ADD NEW EMPLOYEE TO DATABASE (agency.php) */

    if (isset($_POST['add-employee-submit'])) {
        require 'db.inc.php';

        // Get input fields from add employee form
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $positionId = $_POST['positionTitle'];
        //$idNumber = $_POST['idNumber'];
        $stateId = $_COOKIE['agencyId'];
        $locationCode = $_POST['locationcode'];
        //$mhfrpId = $_POST['mhfrpId'];
        $agencyEmployeeId = $_POST['agencyEmployeeId'];
        $employeeType = $_POST['employeeType'];
        $startDate = $_POST['startDate'];
        //$endDate = $_POST['endDate'];
        //$employeeStatus = $_POST['employeeStatus'];

        // Return with error if field is empty
        if (empty($firstname) || empty($lastname) || empty($email)) {
            header("Location: ../agency?error=201");
            exit();
        }
        //Get next MHFRPID value
        $sql0 = "SELECT `MHFRPID` FROM `agency_employees` WHERE `InteCareAgencyID` = ? ORDER BY `MHFRPID` DESC";
        
        $stmt = mysqli_stmt_init($conn);
        

        if(!mysqli_stmt_prepare($stmt, $sql0)){
            echo $stmt->error;
            exit;
        } else{
            $stmt->bind_param("s", $stateId);
            $stmt->execute();
            $res0 = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_row($res0);
            $val = $row[0] + 1; 
            
            $idNumber = $val;
            $mhfrpId = $val;
        }



        // Check if email already exists
        $sql1 = "SELECT * FROM agency_employees WHERE email = ?";
        //$stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql1)) {
           header("Location: ../?error=104");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                header("Location: ../agency?error=202");
                exit();
            } else {
                $sql2 = "INSERT INTO agency_employees (FirstName, LastName, Email, PositionID, IdNumber, InteCareAgencyID, LocationCode, MHFRPID, AgencyEmployeeID, EmployeeType, StartDate)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($sql2);
                $stmt->bind_param("ssssiisssis", $firstname, $lastname, $email, $positionId, $idNumber, $stateId, $locationCode, $mhfrpId, $agencyEmployeeId, $employeeType, $startDate);
                $stmt->execute();
                    
                $stmt->close();

                /*
                $sql2 = "INSERT INTO agency_employees (FirstName, LastName, Email, PositionID, IdNumber, InteCareAgencyID, LocationCode. MHFRPID, AgencyEmployeeID, EmployeeType, StartDate)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($sql2);
                $stmt->bind_param("ssssiisssis", $firstname, $lastname, $email, $positionId, $idNumber, $stateId, $locationCode, $mhfrpId, $agencyEmployeeId, $employeeType, $startDate);
                
                $stmt->execute();
                
                 echo $stmt->error; exit;
                $stmt->close();
*/
                mysqli_close($conn);

                header("Location: ../employees?success=201");
                exit();
            }
        }
    } else {
        header("Location: ../employees");
        exit();
    }
?>
