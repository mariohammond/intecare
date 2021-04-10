<?php
    require "includes/loginCheck.inc.php";
    require "header.php";
    require "includes/db.inc.php";

    // Get input fields from employee data form
    if (isset($_GET['id'])) {
        $employeeId = $_GET['id'];
    } else {
        $employeeId = $_POST['systemId'];
    }

    if (empty($employeeId)) {
        header("Location: ./agency-data");
    }

    //
    $sql = "SELECT agency_data.*, agency_employees.FirstName, agency_employees.LastName, positions.PositionName FROM agency_data INNER JOIN agency_employees ON agency_data.IdNumber = agency_employees.IdNumber INNER JOIN positions ON positions.PositionID = agency_employees.positionId WHERE agency_data.IdNumber = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../?error=104");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "i", $employeeId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        $period = $row["Period"];
        $intecareAgencyId = $row["InteCareAgencyID"];
        $email = $row["Email"];
        $lastname = ucfirst(strtolower($row["LastName"]));
        $firstname = ucfirst(strtolower($row["FirstName"]));
        $positionNumber = $row["PositionTitle"];
        $idNumber = $row["IdNumber"];
        $locationCode = $row["LocationCode"];
        $salariesWages = $row["SalariesWages"];
        $payrollTax = $row["PayrollTaxFICA"];
        $otherFringe = $row["OtherFringe"];
        $duesFees = $row["DuesFees"];
        $travelTraining = $row["TravelTraining"];
        $materialsSupplies = $row["MaterialsSupplies"];
        $purchasedServices = $row["PurchasedServices"];
        $otherExpenses = $row["OtherExpenses"];
        $dssSalariesWages = $row["DSSSalariesWages"];
        $dssFringeBenefits = $row["DSSFringeBenefits"];
        $totalCost = $row["TotalCost"];
        $fedRevenue = $row["FederalRevenueApplicable"];
        $netCost = $row["NetCost"];
        $certified = $row["certified"];
        $positionTitle = $row["PositionName"];

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
<div class="page-edit page-data-edit">
    <div class="modal show" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="editEmployee" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">EDIT EMPLOYEE DATA</h5>
            </div>
            <div class="modal-body">
                <form id="addEmployeeForm" action="includes/editEmployeeData.inc.php" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <div class="round">
                                <input type="checkbox" id="checkbox" name="certified" value="1" <?php if ($certified == 1) { echo 'checked'; } ?>/>
                                <label for="checkbox"></label><span class="checkbox-label">Certify Data</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="d-none">
                            <input type="type" id="employeeId" name="employeeId" value="<?php echo $employeeId; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="period">PERIOD</label>
                            <input type="text" class="form-control" id="period" name="period" value="<?php echo $period; ?>" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lastName">LAST NAME</label>
                            <input type="text" class="form-control" id="lastName" name="lastname" value="<?php echo $lastname; ?>" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="firstName">FIRST NAME</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo $firstname; ?>" disabled>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="positionTitle">POSITION TITLE</label>
                            <input type="text" class="form-control" id="positionTitle" name="positionTitle" value="<?php echo $positionTitle; ?>" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="idNumber">AGENCY ID</label>
                            <input type="type" class="form-control" id="idNumber" name="idNumber" value="<?php echo $_COOKIE['agencyId']; ?>" disabled>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="stateId">LOCATION CODE</label>
                            <input type="type" class="form-control" id="stateId" name="stateId" value="<?php echo $locationCode; ?>" disabled>
                        </div>
                    </div>

                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="salariesWages">SALARY &amp; WAGES</label>
                            <input type="type" class="form-control" id="salariesWages" name="salariesWages" value="<?php echo $salariesWages; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="payrollTax">PAYROLL TAX / FICA</label>
                            <input type="type" class="form-control" id="payrollTax" name="payrollTax" value="<?php echo $payrollTax; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="otherFringe">OTHER FRINGE</label>
                            <input type="type" class="form-control" id="otherFringe" name="otherFringe" value="<?php echo $otherFringe; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="duesFees">DUES / FEES</label>
                            <input type="type" class="form-control" id="duesFees" name="duesFees" value="<?php echo $duesFees; ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="travelTraining">TRAVEL / TRAINING</label>
                            <input type="text" class="form-control" id="travelTraining" name="travelTraining" value="<?php echo $travelTraining; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="materialsSupplies">MATERIALS &amp; SUPPLIES</label>
                            <input type="text" class="form-control" id="materialsSupplies" name="materialsSupplies" value="<?php echo $materialsSupplies; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="purchasedServices">PURCHASED SERVICES</label>
                            <input type="text" class="form-control" id="purchasedServices" name="purchasedServices" value="<?php echo $purchasedServices; ?>">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="otherExpenses">OTHER</label>
                            <input type="text" class="form-control" id="otherExpenses" name="otherExpenses" value="<?php echo $otherExpenses; ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-12">
                            <label for="totalCost">TOTAL COST PER PERSON</label>
                            <input type="text" class="form-control" id="totalCost" name="totalCost" value="<?php echo $totalCost; ?>">
                        </div>
                    </div>

                    <hr>
                    <div class="form-row">
                        <h5>FEDERAL REVENUE APPLICABLE</h5>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="fedRevenue">AMOUNT</label>
                            <input type="text" class="form-control" id="fedRevenue" name="fedRevenue" value="<?php echo $fedRevenue; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fedRevenueSource">DESCRIBE, TYPE SOURCE</label>
                            <input type="text" class="form-control" id="fedRevenueSource" name="fedRevenueSource" value="<?php echo $fedRevenueSource; ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="netCost">NET COST</label>
                            <input type="text" class="form-control" id="netCost" name="netCost" value="<?php echo $netCost; ?>">
                        </div>
                    </div>

                    <div class="add-button form-row justify-content-center">
                        <button type="submit" name="edit-data-submit" class="btn btn-primary">UPDATE</button>
                        <a href="./agency-data"><button type="button" class="btn btn-danger">CANCEL</button></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>