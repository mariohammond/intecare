<?php
    require "includes/loginCheck.inc.php";
    require "header.php";
    require "includes/db.inc.php";

    // Get input fields from add employee form
    if (isset($_GET['id'])) {
        $systemId = $_GET['id'];
    } else {
        $systemId = $_POST['systemId'];
    }

    if (empty($systemId)) {
        header("Location: ./employees");
    }

    // Check if email already exists
    $sql = "SELECT * FROM agency_employees WHERE systemID = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../?error=104");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $systemId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        $systemId = $row["systemID"];
        $email = $row["Email"];
        $lastname = ucfirst(strtolower($row["LastName"]));
        $firstname = ucfirst(strtolower($row["FirstName"]));
        $idNumber = $row["IdNumber"];
        $positionId = $row["PositionID"];
        $mhfrpId = $row["MHFRPID"];
        $agencyEmployeeId = $row["AgencyEmployeeID"];
        $intecareAgencyId = $row["InteCareAgencyID"];
        $locationCode = $row["LocationCode"];
        $employeeType = $row["EmployeeType"];
        $active = $row["Active"];
        $startDate = $row["StartDate"];
        $endDate = $row["EndDate"];

        $firstname = implode("-", array_map("ucfirst", explode("-", $firstname)));
        $firstname = implode("'", array_map("ucfirst", explode("'", $firstname)));
        $firstname = implode(" ", array_map("ucfirst", explode(" ", $firstname)));
        $firstname = implode("Mc", array_map("ucfirst", explode("Mc", $firstname)));
        $lastname = implode("-", array_map("ucfirst", explode("-", $lastname)));
        $lastname = implode("'", array_map("ucfirst", explode("'", $lastname)));
        $lastname = implode(" ", array_map("ucfirst", explode(" ", $lastname)));
        $lastname = implode("Mc", array_map("ucfirst", explode("Mc", $lastname)));
    }
?>

<?php include "nav.php"; ?>
<div class="page-edit">
    <div class="modal show" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="editEmployee" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">EDIT EMPLOYEE</h5>
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
            </div>
            <div class="modal-body">
                <form id="addEmployeeForm" action="includes/editEmployee.inc.php" method="post">
                    <div class="form-row">
                        <div class="d-none">
                            <input type="type" id="systemId" name="systemId" value="<?php echo $systemId; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="firstName">FIRST NAME</label>
                            <input type="type" class="form-control" id="firstName" name="firstname" value="<?php echo $firstname; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lastName">LAST NAME</label>
                            <input type="type" class="form-control" id="lastName" name="lastname" value="<?php echo $lastname; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="email">EMAIL</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="positionTitle">POSITION TITLE</label>
                            <select id="positionTitle" class="form-control" name="positionTitle">
                                <option value="0">SELECT</option>
                                <?php include 'includes/optionsPositionTitle.inc.php'?>
                                <?php echo "<script>document.getElementById('positionTitle').selectedIndex = $positionId;</script>"; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="idNumber">ID NUMBER</label>
                            <input type="type" class="form-control" id="idNumber" name="idNumber" value="<?php echo $idNumber; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="stateId">STATE ID</label>
                            <input type="type" class="form-control" id="stateId" name="stateId" value="<?php echo $_COOKIE['agencyId']; ?>" disabled>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="mhfrpId">MHFRP ID</label>
                            <input type="type" class="form-control" id="mhfrpId" name="mhfrpId" value="<?php echo $mhfrpId; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="agencyEmployeeId">AGENCY EMPLOYEE ID</label>
                            <input type="type" class="form-control" id="agencyEmployeeId" name="agencyEmployeeId" value="<?php echo $agencyEmployeeId; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="locationCode">LOCATION CODE</label>
                            <input type="type" class="form-control" id="locationCode" name="locationcode" value="<?php echo $locationCode; ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="employeeType">EMPLOYEE TYPE</label>
                            <select id="employeeType" class="form-control" name="employeeType">
                                <option value="0">SELECT</option>
                                <?php include 'includes/optionsEmployeeTitle.inc.php'?>
                                <?php echo "<script>document.getElementById('employeeType').selectedIndex = $employeeType;</script>"; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="startDate">START DATE</label>
                            <input type="date" class="form-control" id="startDate" name="startDate" value="<?php echo $startDate; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="endDate">END DATE</label>
                            <input type="date" class="form-control" id="endDate" name="endDate" value="<?php echo $endDate; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="employeeStatus">EMPLOYEE STATUS</label>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="employeeStatus" name="employeeStatus" value="1" <?php if ($active == '1') { echo 'checked'; } ?>>
                                <label class="form-check-label" for="employeeStatus">Active</label>
                            </div>
                        </div>
                    </div>

                    <div class="add-button form-row justify-content-center">
                        <button type="submit" name="edit-employee-submit" class="btn btn-primary">UPDATE</button>
                        <a href="./employees"><button type="button" class="btn btn-danger">CANCEL</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>