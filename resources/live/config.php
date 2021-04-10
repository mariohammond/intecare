<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);


$servername = "160.153.57.72";
$username = "intecare_user";
$password = "password1";
$dbname = "intecare-rosters";
$appTitle = "Indiana Mental Health Funds Recovery Program";

function GetPositions($id, $period) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT count(a.PositionTitle) as `cnt`, a.PositionTitle, b.positionName FROM `agency-data` a
			INNER JOIN `positions` b ON b.positionId = a.PositionTitle

                        WHERE a.InteCareAgencyID = " . $id . " AND a.Period = '" . $period . "'
			GROUP BY a.PositionTitle";

    $result = $conn->query($sql);

    $conn->close();

    return $result;
}

function GetRosterPositions($id) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT count(a.PositionID) as `cnt`, a.PositionID, b.positionName FROM `agency-employees` a
			INNER JOIN `positions` b ON b.positionId = a.PositionID WHERE a.InteCareAgencyID = " . $id . " GROUP BY a.PositionID ORDER BY b.positionName";

    $result = $conn->query($sql);

    $conn->close();
    return $result;
}

function GetRosterPositions2($id) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT count(a.PositionID) as `cnt`, a.PositionID, b.positionName FROM `agency-employees` a
			INNER JOIN `positions` b ON b.positionId = a.PositionID GROUP BY a.PositionID ORDER BY b.positionName";

    $result = $conn->query($sql);

    $conn->close();
    return $result;
}
function GetEmployeeTypes() {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM `EmployeeTypes`";

    $result = $conn->query($sql);

    $conn->close();
    return $result;
}

function GetPositionTitle($id) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT positionName FROM `positions` WHERE `positionId` = " . $id;

    $result = $conn->query($sql);

    $conn->close();

    while ($row = $result->fetch_assoc()) {
        $title = $row['positionName'];
    }

    return $title;
}

function GetEmployee($id) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT a.LastName, a.FirstName, a.Email, b.* FROM `agency-employees` a
	INNER JOIN `agency-data` b on b.IdNumber = a.IdNumber
	WHERE a.Active = 1 AND a.IdNumber=" . $id;

    $result = $conn->query($sql);

    $conn->close();

    return $result;
}

function GetEmployeeRoster($id) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM `agency-employees` WHERE IdNumber=" . $id;

    $result = $conn->query($sql);

    $conn->close();

    return $result;
}

function GetEmployeeDetails($email) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM `agency-employees` WHERE Active = 1 AND Email= '" . $email . "'";

    $result = $conn->query($sql);

    $conn->close();

    return $result;
}

function GetEmployeesFromPositionTitle($id, $agencyid, $period) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT DISTINCT a.* FROM `agency-employees` a
	INNER JOIN `agency-data` b on b.IdNumber = a.IdNumber
	WHERE a.Active = 1 AND a.PositionID = '" . $id . "' AND b.InteCareAgencyID = '" . $agencyid . "' AND b.Period = '" . $period . "' ORDER BY a.LastName, a.FirstName";

    $result = $conn->query($sql);

    $conn->close();

    return $result;
}

function GetEmployeesFromPositionTitleRoster($id, $agencyid) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT DISTINCT a.* FROM `agency-employees` a
	WHERE a.PositionID = '" . $id . "' AND a.InteCareAgencyID = '" . $agencyid . "' ORDER BY a.LastName, a.FirstName";

    $result = $conn->query($sql);

    $conn->close();

    return $result;
}

function GetEmployeesForExport($id, $agency, $period) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT DISTINCT a.LastName, a.FirstName, a.PositionID, b.* FROM `agency-employees` a
	LEFT JOIN `agency-data` b on b.IdNumber = a.IdNumber
	WHERE a.Active =1 AND a.PositionID = '" . $id . "' AND a.InteCareAgencyID = '" . $agency . "' ORDER BY a.LastName, a.FirstName";

    $result = $conn->query($sql);

    $conn->close();

    return $result;
}

function GetCertifiedCount($id, $agency, $period) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT count(*) FROM `agency-data`
	WHERE `PositionTitle` = '" . $id . "' AND `certified` = 1 AND InteCareAgencyID = '" . $agency . "' AND `period` = '" . $period . "'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_row($result);
    $conn->close();


    return $row[0];
}

function GetActiveCount($id, $agency, $period) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT count(*) FROM `agency-employees`
	WHERE `PositionID` = '" . $id . "' AND `Active` = 1 AND InteCareAgencyID = '" . $agency . "'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_row($result);
    $conn->close();


    return $row[0];
}

function GetInactiveCount($id, $agency, $period) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT count(*) FROM `agency-employees`
	WHERE `PositionID` = '" . $id . "' AND `Active` = 0 AND InteCareAgencyID = '" . $agency . "'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_row($result);
    $conn->close();


    return $row[0];
}

function GetGAInactiveCount($agency) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `GA_Inactive` FROM `agencies`
	WHERE `AgencyId` = '" . $agency . "'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_row($result);
    $conn->close();


    return $row[0];
}

function GetGeneralOverheadStaffCount($agency) {
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `GeneralOverheadStaff` FROM `agencies`
	WHERE `AgencyId` = '" . $agency . "'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_row($result);
    $conn->close();


    return $row[0];
}

function GetGAActiveCount($agency) {
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `GeneralOverheadStaff` FROM `agencies`
	WHERE `AgencyId` = '" . $agency . "'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_row($result);
    $conn->close();


    return $row[0];
}

function GetDirectServicesAndOther($agency) {
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `DirectServicesAndOther` FROM `agencies`
	WHERE `AgencyId` = '" . $agency . "'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_row($result);
    $conn->close();


    return $row[0];
}

function GetCertifiedValue($id, $period) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `certified` FROM `agency-data`
	WHERE `IdNumber` = " . $id . " AND `period` = '" . $period . "'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_row($result);
    $conn->close();


    return $row[0];
}

function GetActiveStatus($id) {
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `Active` FROM `agency-employees`
	WHERE `IdNumber` = " . $id;
    $result = $conn->query($sql);
    $row = mysqli_fetch_row($result);
    $conn->close();

    return $row[0];
}

function GetNonCertifiedCount($id, $agency, $period) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT count(*) FROM `agency-data`
	WHERE `PositionTitle` = '" . $id . "'  AND (`certified` IS NULL OR `certified` = 0) AND InteCareAgencyID = '" . $agency . "' AND `period` = '" . $period . "'";
    $result = $conn->query($sql);
    $row = mysqli_fetch_row($result);
    $conn->close();


    return $row[0];
}

function GetPassword($email) {
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `password` FROM `employee-login`  WHERE `email` = '" . $email . "'";
    $result = $conn->query($sql);

    $row = mysqli_fetch_row($result);
    $conn->close();

    return $row[0];
}

function UpdatePassword($passwordtochangto, $email) {
    global $servername, $username, $password, $dbname;


    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $salted_password = md5('c6d79930875cdaa4462337b7263f47e347e07d3e' . $passwordtochangto . '2155209');

    $sql = "UPDATE `employee-login` SET `password` = '" . $salted_password . "' WHERE `email` = '" . $email . "'";

    $result = $conn->query($sql);

    $conn->close();
}

function InsertPassword($email, $password) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    $bl = false;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $salted_password = md5('c6d79930875cdaa4462337b7263f47e347e07d3e' . $password . '2155209');

    $sql = "INSERT INTO `employee-login` (`email`, `password`) VALUES ('" . $email . "', '" . $salted_password . "')";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return true;
    } else {
        $conn->close();
        return false;
    }
}

function InsertPasswordFull($email, $password, $firstName, $lastName, $agencyId) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    $bl = false;

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $salted_password = md5('c6d79930875cdaa4462337b7263f47e347e07d3e' . $password . '2155209');

    $sql = "INSERT INTO `employee-login` (`email`, `password`, `FirstName`, `LastName`, `agencyID`) VALUES ('" . strtolower($email) . "', '" . $salted_password . "', '" . $firstName . "', '" . $lastName . "', " . $agencyID . ")";

    if ($conn->query($sql) === TRUE) {
        $conn->close();
        return true;
    } else {
        $conn->close();
        return false;
    }
}

function UpdateEmployeeAgencyData($id, $period) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE `agency-data` SET
	`SalariesWages`=" . $_POST['SalariesWages'] . ",
	`PayrollTaxFICA`=" . $_POST['PayrollTaxFICA'] . ",
	`OtherFringe`=" . $_POST['OtherFringe'] . ",
	`DuesFees`=" . $_POST['DuesFees'] . ",
	`TravelTraining`=" . $_POST['TravelTraining'] . ",
	`MaterialsSupplies`=" . $_POST['MaterialsSupplies'] . ",
	`PurchasedServices`=" . $_POST['PurchasedServices'] . ",
	`OtherExpenses`=" . $_POST['OtherExpenses'] . ",
	`TotalCost`=" . $_POST['TotalCost'] . ",
	`certified`=" . $_POST['certvalue'] . ",
    `FederalRevenueApplicable` =" . $_POST['amount'] . ",
	`NetCost`=" . $_POST['NetCost'] . " WHERE IdNumber = " . $id . " AND `period` ='" . $period . "'";


    $result = $conn->query($sql);

    $conn->close();

    //UpdateEmployeeData($id,$_POST['PositionTitle'] );

    return $sql;
}

function UpdateEmployees($generalOverhead, $directServiceOther, $id) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE `agencies` SET
	`GeneralOverheadStaff`=" . $generalOverhead . ",
	`DirectServicesAndOther`=" . $directServiceOther . " WHERE `AgencyId` = '" . $id . "'";


    $result = $conn->query($sql);

    $conn->close();

    return $sql;
}

function UpdateEmployeeData($id, $positionid) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE `agency-employees` SET
	`PositionID`='" . $positionid . "' WHERE IdNumber = " . $id;

    $result = $conn->query($sql);

    $conn->close();
}

function UpdateEmployeeDetails($id) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //check for values passed in
    if (isset($_POST['AgencyEmployeeId']))
    {
        $agencyEmpId = $_POST['AgencyEmployeeId'];

    }

    else
        $agencyEmpId = NULL;

    if (isset($_POST['LocationCode']))
        $locationCode = $_POST['LocationCode'];
    else
        $locationCode = NULL;


    //Check the value of the Active checkbox
    if (isset($_POST['Active'])) {
        $active = 1;

        $sql = "UPDATE `agency-employees` SET
        `Email` = '" . mysqli_real_escape_string($conn, $_POST['email']) . "',
	`LastName`= '" . mysqli_real_escape_string($conn, $_POST['LastName']) . "',
	`FirstName`='" . mysqli_real_escape_string($conn, $_POST['FirstName']) . "',

    `AgencyEmployeeID` ='" . $agencyEmpId . "',
	`PositionID`=" . mysqli_real_escape_string($conn, $_POST['PositionID']) . ",
	`MHFRPID`=" . mysqli_real_escape_string($conn, $_POST['MHFRPID']) . ",
	`LocationCode`='" . $locationCode . "',
	`EmployeeType`=" . mysqli_real_escape_string($conn, $_POST['EmployeeType']) . ",
    `EndDate` = NULL,
	`Active`=" . $active . " WHERE IdNumber = " . $id;
    } else {
        $active = 0;

        $sql = "UPDATE `agency-employees` SET
        `Email` = '" . mysqli_real_escape_string($conn, $_POST['email']) . "',
	`LastName`= '" . mysqli_real_escape_string($conn, $_POST['LastName']) . "',
	`FirstName`='" . mysqli_real_escape_string($conn, $_POST['FirstName']) . "',

    `AgencyEmployeeID` ='" . $agencyEmpId . "',
	`PositionID`=" . mysqli_real_escape_string($conn, $_POST['PositionID']) . ",
	`MHFRPID`=" . mysqli_real_escape_string($conn, $_POST['MHFRPID']) . ",
	`LocationCode`='" . $locationCode . "',
	`EmployeeType`=" . mysqli_real_escape_string($conn, $_POST['EmployeeType']) . ",
	`Active`=" . $active . ",
    `EndDate`=CURDATE() WHERE IdNumber = " . $id;
    }
//echo $sql; exit;
    $result = $conn->query($sql);

    $conn->close();

    //UpdateEmployeeData($id,$_POST['PositionTitle'] );

    return $sql;
}

function GetEmployeeType($id) {
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT employeeTypeName FROM `EmployeeTypes` WHERE `employeeTypeID` = " . $id;

    $result = $conn->query($sql);

    $conn->close();

    while ($row = $result->fetch_assoc()) {
        $title = $row['employeeTypeName'];
    }

    return $title;
}

function UpdateEmployeeEmail($newEmail, $email) {
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE `intecare-rosters`.`agency-employees` SET `Email` = '" . $newEmail . "' WHERE `Email` = '" . $email . "'; UPDATE `intecare-rosters`.`agency-data` SET `Email` = '" . $newEmail . "' WHERE `Email` = '" . $email . "'; ";


    $result = $conn->query($sql);
    $conn->close();

    return $result;
}

function GetAgencyID($email) {
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `agencyID` FROM `employee-login` WHERE `email` = '" . $email . "'";
    $result = $conn->query($sql);

    $row = mysqli_fetch_row($result);
    $conn->close();

    return $row[0];
}

function GetAgencyName($id) {
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `AgencyName` FROM `agencies` WHERE `AgencyId` = '" . $id . "'";
    $result = $conn->query($sql);

    $row = mysqli_fetch_row($result);
    $conn->close();

    return $row[0];
}

function GetAgencyFromUserToken($userToken) {
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `agencyID` FROM `employee-login` WHERE `email` = '" . $userToken . "'";
    $result = $conn->query($sql);

    $row = mysqli_fetch_row($result);
    $conn->close();

    return $row[0];
}

function GetPeriod() {
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `value` FROM `options` WHERE `option` LIKE 'current-time-study'";
    $result = $conn->query($sql);

    $row = mysqli_fetch_row($result);
    $conn->close();

    return $row[0];
}

function GetTimeEntryStatus() {
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `value` FROM `options` WHERE `optionId` = 2";
    $result = $conn->query($sql);

    $row = mysqli_fetch_row($result);
    $conn->close();

    return $row[0];
}

function GetRosterStatus() {
    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `value` FROM `options` WHERE `optionId` = 4";
    $result = $conn->query($sql);

    $row = mysqli_fetch_row($result);
    $conn->close();

    return $row[0];
}

function GetAllRosterPositions() {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM `positions`";

    $result = $conn->query($sql);

    $conn->close();
    return $result;
}

function IsLocked() {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `value` FROM `options` WHERE `option` = 'locked'";

    $result = $conn->query($sql);

    $row = mysqli_fetch_row($result);
    $conn->close();

    return $row[0];
}

function IDExists($id) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `IdNumber` FROM `agency-employees` WHERE `IdNumber` = " . $id;

    $result = $conn->query($sql);
    $num_rows = mysqli_num_rows($result);
    //$row = mysqli_fetch_row($result);
    $conn->close();

    return $num_rows;
}

function GenerateID($stateId)
{
    //This function will generate a new MAXIMUS ID for a newly created employee
    //1. Get the highest value for the ID for the given agency.
    $newMaximusID = GetHighestMaximusIDbyAgency($stateId) + 1;
    return $newMaximusID;
}

function GetHighestMaximusIDbyAgency($stateId){
    global $servername, $username, $password, $dbname;
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `MHFRPID` FROM `agency-employees` WHERE `InteCareAgencyID` = " . $stateId . " ORDER BY `MHFRPID` DESC";

    $result = $conn->query($sql);

    $row = mysqli_fetch_row($result);
    $conn->close();

    return $row[0];

}

function UpdateEmployeeDetailsAdmin($id) {

    global $servername, $username, $password, $dbname;

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    //Check the value of the Active checkbox
    if (isset($_POST['Active'])) {
        $active = 1;

        $sql = "UPDATE `agency-employees` SET
	`LastName`= '" . $_POST['lastname'] . "',
	`FirstName`='" . $_POST['firstname'] . "',
	`IdNumber`=" . $_POST['IdNumber'] . ",
	`PositionID`=" . $_POST['PositionID'] . ",
	`MHFRPID`=" . $_POST['mhfrpid'] . ",
	`LocationCode`='" . $_POST['LocationCode'] . "',
	`EmployeeType`=" . $_POST['employeeType'] . ",
	`Active`=" . $active . " WHERE IdNumber = " . $id;
    } else {
        $active = 0;

        $sql = "UPDATE `agency-employees` SET
	`LastName`= '" . $_POST['lastname'] . "',
	`FirstName`='" . $_POST['firstname'] . "',
	`IdNumber`=" . $_POST['IdNumber'] . ",
	`PositionID`=" . $_POST['PositionID'] . ",
	`MHFRPID`=" . $_POST['mhfrpid'] . ",
	`LocationCode`='" . $_POST['LocationCode'] . "',
	`EmployeeType`=" . $_POST['employeeType'] . ",
	`Active`=" . $active . ",
    `EndDate`=CURDATE() WHERE IdNumber = " . $id;
    }

    $result = $conn->query($sql);

    $conn->close();

    //UpdateEmployeeData($id,$_POST['PositionTitle'] );

    return $sql;
}

function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

?>
