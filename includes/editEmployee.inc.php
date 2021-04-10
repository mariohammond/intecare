<?php
    /* ADD NEW EMPLOYEE TO DATABASE (employee.php) */

    if (isset($_POST['edit-employee-submit'])) {
        require 'db.inc.php';

        // Get input fields from add employee form
        $systemId = $_POST['systemId'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $positionId = $_POST['positionTitle'];
        $idNumber = $_POST['idNumber'];
        $stateId = $_COOKIE['agencyId'];
        $locationCode = $_POST['locationcode'];
        $mhfrpId = $_POST['mhfrpId'];
        $agencyEmployeeId = $_POST['agencyEmployeeId'];
        $employeeType = $_POST['employeeType'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $employeeStatus = $_POST['employeeStatus'];

        // Return with error if field is empty
        if (empty($firstname) || empty($lastname) || empty($email)) {
            header("Location: ../agency?error=201");
            exit();
        }

        $sql = "UPDATE agency_employees SET FirstName = ?, LastName = ?, Email = ?, PositionID = ?, IdNumber = ?, InteCareAgencyID = ?, LocationCode = ?, MHFRPID = ?, AgencyEmployeeID = ?, EmployeeType = ?, StartDate = ?, EndDate = ?, Active = ? WHERE systemID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiisssissii", $firstname, $lastname, $email, $positionId, $idNumber, $stateId, $locationCode, $mhfrpId, $agencyEmployeeId, $employeeType, $startDate, $endDate, $employeeStatus, $systemId);
        $stmt->execute();
        $stmt->close();

        mysqli_close($conn);

        header("Location: ../agency?success=201");
        exit();
    } else {
        header("Location: ../agency");
        exit();
    }
?>