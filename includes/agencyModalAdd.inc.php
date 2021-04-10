<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="newEmployee" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-center">NEW AGENCY USER</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <form id="addEmployeeForm" action="includes/addEmployee.inc.php" method="post">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="firstName">FIRST NAME</label>
                        <input type="type" class="form-control" id="firstName" name="firstname">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="lastName">LAST NAME</label>
                        <input type="type" class="form-control" id="lastName" name="lastname">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="email">EMAIL</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="positionTitle">AGENCY</label>
                        <select id="positionTitle" class="form-control" name="positionTitle">
                            <option selected>SELECT</option>
                            <?php include 'includes/optionsAgency.inc.php'?>
                        </select>
                    </div>
                </div>

                <div class="form-row">

                    <div class="form-group col-md-3">
                        <label for="startDate">PASSWORD</label>
                        <input type="date" class="form-control" id="startDate" name="startDate">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="endDate">CONFIRM PASSWORD</label>
                        <input type="date" class="form-control" id="endDate" name="endDate">
                    </div>
                    
                </div>

                <div class="add-button form-row justify-content-center">
                    <button type="submit" name="add-employee-submit" class="btn btn-primary">ADD USER</button>
                </div>
            </form>
        </div>
    </div>
</div>
