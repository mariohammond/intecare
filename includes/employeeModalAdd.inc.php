<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="newEmployee" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-center">NEW EMPLOYEE</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form id="addEmployeeForm" action="includes/addEmployee.inc.php" method="post">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="firstName">FIRST NAME</label>
                        <input type="type" class="form-control" id="firstName" name="firstname" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="lastName">LAST NAME</label>
                        <input type="type" class="form-control" id="lastName" name="lastname" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="email">EMAIL</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="positionTitle">POSITION TITLE</label>
                        <select id="positionTitle" class="form-control" name="positionTitle" required>
                            <option value="" selected>SELECT</option>
                            <?php include 'includes/optionsPositionTitle.inc.php'?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="idNumber">ID NUMBER</label>
                        <input type="type" class="form-control" id="idNumber" name="idNumber">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="stateId">STATE ID</label>
                        <input type="type" class="form-control" id="stateId" name="stateId" value="<?php echo $_COOKIE['agencyId']; ?>" disabled>
                    </div>
                </div>

                <div class="form-row">
                    <!--<div class="form-group col-md-4">
                        <label for="mhfrpId">MHFRP ID</label>
                        <input type="type" class="form-control" id="mhfrpId" name="mhfrpId">
                    </div>-->
                    <div class="form-group col-md-4">
                        <label for="agencyEmployeeId">AGENCY EMPLOYEE ID</label>
                        <input type="type" class="form-control" id="agencyEmployeeId" name="agencyEmployeeId">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="locationCode">LOCATION CODE</label>
                        <input type="type" class="form-control" id="locationCode" name="locationcode">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="employeeType">EMPLOYEE TYPE</label>
                        <select id="employeeType" class="form-control" name="employeeType" required>
                            <option value="" selected>SELECT</option>
                            <?php include 'includes/optionsEmployeeTitle.inc.php'?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <!--<div class="form-group col-md-3">
                        <label for="employeeType">EMPLOYEE TYPE</label>
                        <select id="employeeType" class="form-control" name="employeeType">
                            <option selected>SELECT</option>
                            <?php include 'includes/optionsEmployeeTitle.inc.php'?>
                        </select>
                    </div>-->
                    <div class="form-group col-md-4">
                        <label for="startDate">START DATE</label>
                        <input type="date" class="form-control" id="startDate" name="startDate" required>
                    </div>
                    <!--<div class="form-group col-md-3">
                        <label for="endDate">END DATE</label>
                        <input type="date" class="form-control" id="endDate" name="endDate">
                    </div>-->
                    <div class="form-group col-md-4">
                        <label for="employeeStatus">EMPLOYEE STATUS</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="employeeStatus" name="employeeStatus" value="1" checked disabled>
                            <label class="form-check-label" for="employeeStatus">Active</label>
                        </div>
                    </div>
                </div>

                <div class="add-button form-row justify-content-center">
                    <button type="submit" name="add-employee-submit" class="btn btn-primary">ADD EMPLOYEE</button>
                </div>
            </form>
        </div>
    </div>
</div>