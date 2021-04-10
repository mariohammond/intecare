<?php
    require "../includes/adminCheck.inc.php";
    require "./header.php";
    //require "../includes/agencyUsersList.inc.php";
?>
<?php include "./nav.php"; ?>
<div class="page-edit page-data-edit">
    <div class="" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="editEmployee" >
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">NEW AGENCY USER</h5>
            </div>
            <div class="modal-body">
                <form id="addAgencyUserForm" action="../includes/addAgencyUser.inc.php" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <div class="round">

                                  <label for="period">AGENCY</label>

                                  <select id="agencyID" class="form-control custom-select">
                                      <option value="0">Agency</option>
                                      <option value="429">ADULT &amp; CHILD MENTAL HEALTH CENTER</option>
                                      <option value="1279">AMETHYST HOUSE</option>
                                      <option value="430">ASPIRE INDIANA BEHAVIORAL HEALTH SYSTEM</option>
                                      <option value="423">BOWEN CENTER</option>
                                      <option value="431">CENTERSTONE OF INDIANA</option>
                                      <option value="990">COMMUNITY ADDICTION SERVICES OF INDIANA</option>
                                      <option value="407">COMMUNITY HOWARD REGIONAL HEALTH</option>
                                      <option value="413">COMMUNITY MENTAL HEALTH CENTER</option>
                                      <option value="428">CUMMINS BEHAVIORAL HEALTH SYSTEMS, INC.</option>
                                      <option value="421">EDGEWATER SYSTEMS FOR BALANCED LIVING</option>
                                      <option value="839">FAMILIES FIRST INDIANA, INC</option>
                                      <option value="427">FOUR COUNTY COUNSELING CENTER</option>
                                      <option value="416">GALLAHUE MENTAL HEALTH CENTER</option>
                                      <option value="999">GEMINUS CORPORATION</option>
                                      <option value="414">GRANT-BLACKFORD MENTAL HEALTH CORNERSTONE</option>
                                      <option value="405">HAMILTON CENTER</option>
                                      <option value="806">LIFE TREATMENT CENTERS</option>
                                      <option value="402">LIFESPRING</option>
                                      <option value="422">MERIDIAN HEALTH SERVICES</option>
                                      <option value="401">MIDTOWN COMMUNITY MENTAL HEALTH CENTER</option>
                                      <option value="426">NORTHEASTERN CENTER</option>
                                      <option value="409">OAKLAWN CENTER</option>
                                      <option value="419">PARK CENTER</option>
                                      <option value="418">PORTER-STARKE SERVICES</option>
                                      <option value="826">SALVATION ARMY</option>
                                      <option value="403">SAMARITAN CENTER VINCENNES</option>
                                      <option value="420">SOUTHERN HILLS COUNSELING CENTER</option>
                                      <option value="424">SOUTHLAKE COMMUNITY MENTAL HEALTH CENTER , INC. DBA REGIONAL MENTAL HEALTH CENTER</option>
                                      <option value="404">SOUTHWESTERN BEHAVIORAL HEALTHCARE, INC.</option>
                                      <option value="410">SWANSON CENTER</option>
                                      <option value="1006">VILLAGES OF INDIANA INC</option>
                                      <option value="415">WABASH VALLEY ALLIANCE, INC</option>
                                      <option value="819">YWCA</option>
                                  </select>


                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="d-none">
                            <input type="type" id="employeeId" name="employeeId" value="<?php echo $employeeId; ?>">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="email">EMAIL</label>
                            <input type="type" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lastName">LAST NAME</label>
                            <input type="text" class="form-control" id="lastName" name="lastname" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="firstName">FIRST NAME</label>
                            <input type="text" class="form-control" id="firstName" name="firstname" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="password">PASSWORD</label>
                            <input type="text" class="form-control" id="password" name="password" required>
                        </div>

                    </div>


                    <div class="add-button form-row justify-content-center">
                        <button type="submit" name="edit-data-submit" class="btn btn-primary">SUBMIT</button>
                        <input type="hidden" name="selectedAgencyID" id="selectedAgencyID" value=""/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$('#agencyID').change(function() {
    var a=$(':selected').text(); // "city1city2choose iofoo"
    var b=$(':selected').val();  // "city1" - selects just first query !
    //but..
    $('#selectedAgencyID').val(b);

});
</script>
