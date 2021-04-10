<?php
    require "includes/loginCheck.inc.php";
    require "header.php";
    require "includes/employeeList.inc.php";
    require "includes/rosterLock.inc.php";
    require "includes/costReport.inc.php";
?>

<?php include "nav.php"; ?>
<div class="container-fluid page-agency">
    <div class="row justify-content-center text-center">
        <div id="page-fit" class="wrapper col-12">
            <h2 class="text-center">WELCOME TO THE INTECARE APP</h2>
            <a href="./category">
                <button type="button" class="btn btn-outline-light col-12 col-md-6 mt-4">
                    <h3>ROSTER MANAGEMENT</h3>
                </button>
            </a>
            <h4 class="col-12 col-md-6 mx-auto py-2 bg-light text-primary">Current Roster Status: <span class="text-success"><?php if ($rosterStatus == "Locked") { echo 'Locked'; } else { echo 'Unlocked'; } ?></span></h4>
            <!--<a href="./cost-report">
                <button type="button" class="btn btn-outline-light col-12 col-md-6 mt-5">
                    <h3>COST REPORT</h3>
                </button>
            </a>
            <h4 class="col-12 col-md-6 mx-auto py-2 bg-light text-primary">Current Cost Reporting Period: <span class="text-success"><?php echo $costReportStatus; ?></span></h4>-->
            <div class="row justify-content-around">
                <a href="./includes/agencyRoster.inc.php">
                    <button type="button" class="btn btn-outline-light col-12 mt-5">
                        <h3>EXPORT ROSTER</h3>
                    </button>
                </a>
                <!--<a href="./includes/agencyData.inc.php">
                    <button type="button" class="btn btn-outline-light col-12 mt-5">
                        <h3>EXPORT DATA</h3>
                    </button>
                </a>-->
            </div>
            <button type="button" class="btn btn-outline-light col-12 col-md-6 mt-4">
                <h3>IN-TRAINING EMPLOYEES</h3>
            </button>
        </div>
    </div>

    <!--<a href="javascript:addEmployeeModal();"><h5 class="add-employee text-center"><i class="far fa-plus-square"></i> ADD EMPLOYEE</p></h5></a>
    <h5 class="text-center">EMPLOYEE SEARCH</h5>

    <div class="input-group col-12 col-md-4 container-fluid">
        <span class="input-group-addon"><i class="fa fa-search"></i></span>
        <input type="text" id="employeeSearch" class="employee-input form-control" name="employee">
        --<form id="systemIdForm<?php echo $systemId; ?>" class="d-none" action="employee-edit.php" method="post">
            <input type="text" name="systemId" value="<?php echo $systemId; ?>">
        </form>--
    </div>

    <button class="btn btn-outline-light col-12 col-md-3" onclick="editEmployeeModal()">SUBMIT</button>
    <a href="includes/logout.inc.php"><button class="btn btn-outline-light col-12 col-md-3">SIGN OUT</button></a>-->

    <?php //require "includes/employeeModalAdd.inc.php"; ?>
</div>

<?php require "footer.php"; ?>