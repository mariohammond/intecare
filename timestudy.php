<?php
  require "header.php";
  require "includes/timestudyInfo.inc.php";
  require "includes/getTimeStudy.inc.php";
  require './includes/empCookies.inc.php';
  require "nav-emp.php";
?>
<?php
    if (isset($_GET["d"]) && $_GET["d"] != "") {
      $currentDay = intval($_GET["d"]);
      if ($currentDay > 8) {
        header("Location: ./timestudy?id=$mhfrpid&d=1");
      }
    } else {
      $currentDay = 1;
    }

    $prevDay = $currentDay - 1;
    $nextDay = $currentDay + 1;

    $firstname = $timeStudyInfo["FirstName"];
    $lastname = $timeStudyInfo["LastName"];
    //$mhfrpid = $timeStudyInfo["MHFRPID"];
    $position = $timeStudyInfo["positionName"];
    $positionId = $timeStudyInfo["positionId"];
?>
<?php include "includes/timestudyDialog.inc.php"; ?>

<div class="page-timestudy">
  <div id="app">
    <div class="pt-4 container">
      <h2 class="text-center"><?php echo $firstname . " " . $lastname;?> - MHFRP ID: <?php echo $mhfrpid; ?><br/>Position: <?php echo $position; ?><br/>Time Study and Activity Log</h2>
    </div>

    <?php if ($currentDay != 8) : ?>
    <div class="pt-2 pb-2 container study-instructions text-center">
      <a href="./docs/Time_Study_Instructions.pdf" target="_blank"><h5>Click here for Time Study Instructions</h5></a>
      <a href="./docs/Time_Study_Activity_Codes.pdf" target="_blank"><h5>Click here for Activity Code Reference</h5></a>
      <hr>

      <p>If you do not work weekends or are on unpaid leave, FMLA, or extended PTO, click the appropriate button below to mark applicable samples:</p>
      <div>
        <button type="button" id="tsWeekend" class="btn pto-btn d-block d-md-inline-block mx-auto my-2">I do not work weekends</button>
        <button type="button" id="tsLeave" class="btn pto-btn d-block d-md-inline-block mx-auto my-2">I am on unpaid leave</button>
        <button type="button" id="tsVacant" class="btn pto-btn d-block d-md-inline-block mx-auto my-2">This position is vacant</button>
      </div>
      <hr>

      <p>If you work 8 hours a day, click the button below to fill in the remaining hours:</p>
      <div>
        <button type="button" id="tsHours" class="btn pto-btn d-block d-md-inline-block mx-auto my-2">I worked only 8 hours today</button>
      </div>
    </div>
    <div id="codeAlert" class="container alert alert-danger" role="alert">
      Please provide an activity code for each log or remove unneeded log.
    </div>
    <!--<div id="descAlert" class="container alert alert-danger" role="alert">
      Please provide a description for each log or remove unneeded log.
    </div>-->
    <div id="dialog-weekend" title="Confirm Update">
      <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>This action will automatically update Days 6 and 7. Continue?</p>
    </div>
    <div id="dialog-leave" title="Confirm Update">
      <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>This action will automatically update all days. Continue?</p>
    </div>
    <div id="dialog-vacant" title="Confirm Update">
      <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>This action will automatically update all days. Continue?</p>
    </div>
    <div id="dialog-hours" title="Confirm Update">
      <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Please SAVE any changes to hours 1 - 8 before proceeding. This action will automatically update hours 9 - 12.</p>
    </div>

    <?php endif; ?>
    <div class="py-4 container">
      <div class="row">
        <div class="col-1">
          <a <?php if ($currentDay != 1) { echo "href=./timestudy?id=$mhfrpid&d=$prevDay"; } ?>><i class="fas fa-chevron-left <?php if ($currentDay == 1) { echo 'disabled'; } ?>"></i></a>
        </div>
        <div class="col-10 px-0">
          <ol class="progress">
            <!--<li id="day-1" class="progress__item"><a href="./timestudy?id=<?php echo $mhfrpid; ?>&d=1">Day 1</a></li>
            <li id="day-2" class="progress__item"><a href="./timestudy?id=<?php echo $mhfrpid; ?>&d=2">Day 2</a></li>
            <li id="day-3" class="progress__item"><a href="./timestudy?id=<?php echo $mhfrpid; ?>&d=3">Day 3</a></li>
            <li id="day-4" class="progress__item"><a href="./timestudy?id=<?php echo $mhfrpid; ?>&d=4">Day 4</a></li>
            <li id="day-5" class="progress__item"><a href="./timestudy?id=<?php echo $mhfrpid; ?>&d=5">Day 5</a></li>
            <li id="day-6" class="progress__item"><a href="./timestudy?id=<?php echo $mhfrpid; ?>&d=6">Day 6</a></li>
            <li id="day-7" class="progress__item"><a href="./timestudy?id=<?php echo $mhfrpid; ?>&d=7">Day 7</a></li>
            <li id="day-8" class="progress__item"><a href="./timestudy?id=<?php echo $mhfrpid; ?>&d=8">Signature</a></li>-->

            <li id="day-1" class="progress__item"><a class="open-modal-save" href="" data-toggle="modal" data-target="#saveEntries" data-page="1">Day 1</a></li>
            <li id="day-2" class="progress__item"><a class="open-modal-save" href="" data-toggle="modal" data-target="#saveEntries" data-page="2">Day 2</a></li>
            <li id="day-3" class="progress__item"><a class="open-modal-save" href="" data-toggle="modal" data-target="#saveEntries" data-page="3">Day 3</a></li>
            <li id="day-4" class="progress__item"><a class="open-modal-save" href="" data-toggle="modal" data-target="#saveEntries" data-page="4">Day 4</a></li>
            <li id="day-5" class="progress__item"><a class="open-modal-save" href="" data-toggle="modal" data-target="#saveEntries" data-page="5">Day 5</a></li>
            <li id="day-6" class="progress__item"><a class="open-modal-save" href="" data-toggle="modal" data-target="#saveEntries" data-page="6">Day 6</a></li>
            <li id="day-7" class="progress__item"><a class="open-modal-save" href="" data-toggle="modal" data-target="#saveEntries" data-page="7">Day 7</a></li>
            <li id="day-8" class="progress__item"><a class="open-modal-save" href="" data-toggle="modal" data-target="#saveEntries" data-page="8">Signature</a></li>
          </ol>
        </div>
        <div class="col-1">
          <a <?php if ($currentDay != 8) { echo "href=./timestudy?id=$mhfrpid&d=$nextDay"; } ?>><i class="fas fa-chevron-right <?php if ($currentDay == 8) { echo 'disabled'; } ?>"></i></a>
        </div>
      </div>

      <?php if ($currentDay != 8) : ?>
      <div class="pt-4 text-right">
        <button type="button" class="save-btn btn btn-primary btn-sm"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="save" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-save fa-w-14"><path fill="currentColor" d="M433.941 129.941l-83.882-83.882A48 48 0 0 0 316.118 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V163.882a48 48 0 0 0-14.059-33.941zM224 416c-35.346 0-64-28.654-64-64 0-35.346 28.654-64 64-64s64 28.654 64 64c0 35.346-28.654 64-64 64zm96-304.52V212c0 6.627-5.373 12-12 12H76c-6.627 0-12-5.373-12-12V108c0-6.627 5.373-12 12-12h228.52c3.183 0 6.235 1.264 8.485 3.515l3.48 3.48A11.996 11.996 0 0 1 320 111.48z" class=""></path></svg>  Save</button>
      </div>
      <form id="timeLogForm" action="includes/addTimeStudy.inc.php?id=<?php echo $mhfrpid; ?>" method="post">
        <div class="row logs">
          <div id="timelog-0" class="col-12 timelog" data-count="0">
            <div class="card mt-4 shadow">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4 col-lg-4 col-xl-3 col-12">
                    <div class="b-form-group form-group">
                      <div id="alertDanger0" class="alert alert-danger" role="alert">Please enter a code and description before proceeding.</div>
                      <input id="dayInput" type="text" name="day" class="d-none" value="<?php echo $currentDay; ?>">
                      <input id="selectedDay" type="text" name="selectedDay" class="d-none" value="1">
                      <label class="col-form-label pt-0">Time</label>
                      <select id="timeInput0" name="time0" class="time-select form-control custom-select" disabled>
                        <option value="1">HOUR 1 - 0 min</option>
                        <option value="2">HOUR 1 - 15 min</option>
                        <option value="3">HOUR 1 - 30 min</option>
                        <option value="4">HOUR 1 - 45 min</option>
                        <option value="5">HOUR 2 - 0 min</option>
                        <option value="6">HOUR 2 - 15 min</option>
                        <option value="7">HOUR 2 - 30 min</option>
                        <option value="8">HOUR 2 - 45 min</option>
                        <option value="9">HOUR 3 - 0 min</option>
                        <option value="10">HOUR 3 - 15 min</option>
                        <option value="11">HOUR 3 - 30 min</option>
                        <option value="12">HOUR 3 - 45 min</option>
                        <option value="13">HOUR 4 - 0 min</option>
                        <option value="14">HOUR 4 - 15 min</option>
                        <option value="15">HOUR 4 - 30 min</option>
                        <option value="16">HOUR 4 - 45 min</option>
                        <option value="17">HOUR 5 - 0 min</option>
                        <option value="18">HOUR 5 - 15 min</option>
                        <option value="19">HOUR 5 - 30 min</option>
                        <option value="20">HOUR 5 - 45 min</option>
                        <option value="21">HOUR 6 - 0 min</option>
                        <option value="22">HOUR 6 - 15 min</option>
                        <option value="23">HOUR 6 - 30 min</option>
                        <option value="24">HOUR 6 - 45 min</option>
                        <option value="25">HOUR 7 - 0 min</option>
                        <option value="26">HOUR 7 - 15 min</option>
                        <option value="27">HOUR 7 - 30 min</option>
                        <option value="28">HOUR 7 - 45 min</option>
                        <option value="29">HOUR 8 - 0 min</option>
                        <option value="30">HOUR 8 - 15 min</option>
                        <option value="31">HOUR 8 - 30 min</option>
                        <option value="32">HOUR 8 - 45 min</option>
                        <option value="33">HOUR 9 - 0 min</option>
                        <option value="34">HOUR 9 - 15 min</option>
                        <option value="35">HOUR 9 - 30 min</option>
                        <option value="36">HOUR 9 - 45 min</option>
                        <option value="37">HOUR 10 - 0 min</option>
                        <option value="38">HOUR 10 - 15 min</option>
                        <option value="39">HOUR 10 - 30 min</option>
                        <option value="40">HOUR 10 - 45 min</option>
                        <option value="41">HOUR 11 - 0 min</option>
                        <option value="42">HOUR 11 - 15 min</option>
                        <option value="43">HOUR 11 - 30 min</option>
                        <option value="44">HOUR 11 - 45 min</option>
                        <option value="45">HOUR 12 - 0 min</option>
                        <option value="46">HOUR 12 - 15 min</option>
                        <option value="47">HOUR 12 - 30 min</option>
                        <option value="48">HOUR 12 - 45 min</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-8 col-lg-8 col-xl-9 col-12">
                    <div id="codeInputGroup0" class="b-form-group form-group">
                      <label for="codeInput0" class="col-form-label pt-0">Activity Code</label>
                      <select id="codeInput0" name="code0" class="code-select form-control custom-select">
                        <option value="">SELECT ACTIVITY CODE</option>
                        <option value="A">A: Direct Medical &amp; Other Medicated Services</option>
                        <option value="B">B: Non Medical, Non-Medicaid, Educ., Social Svcs</option>
                        <option value="C">C: Medicaid Outreach</option>
                        <option value="D">D: Non-Medicaid Outreach</option>
                        <option value="E">E: Facilitating Access to Medicaid Eligibility</option>
                        <option value="F">F: Facilitating Non-Medicaid Program Eligibility</option>
                        <option value="G1">G1: Referral, Coordination &amp; Monitoring of Medicaid Svcs.</option>
                        <?php if ($positionId == 4 || $positionId == 5 || $positionId == 7 || $positionId == 9 || $positionId == 12) : ?>
                          <option value="G2">G2: Referral, Coordination &amp; Monitoring of Medicaid Svcs. - SPMP</option>
                        <?php endif; ?>
                        <option value="H">H: Referral, Coordination &amp; Monitoring of Non-Medicaid Svcs.</option>
                        <option value="I">I: Medicaid Provider Relations</option>
                        <option value="J1">J1: Program, Plan, Dvlp. &amp; Agency-wide Coord</option>
                        <?php if ($positionId == 4 || $positionId == 5 || $positionId == 7 || $positionId == 9 || $positionId == 12) : ?>
                          <option value="J2">J2: Program, Plan, Dvlp. &amp; Agency-wide Coord - SPMP</option>
                        <?php endif; ?>
                        <option value="K">K: Medicaid Administrative Training</option>
                        <option value="L">L: Non-Medicaid Administrative Training</option>
                        <option value="M">M: Family Planning Referral</option>
                        <option value="N">N: General Administration</option>
                        <option value="O">O: Non-Paid Time</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div id="descriptionInputGroup0" class="b-form-group form-group">
                    <label for="descriptionInput0" class="col-form-label pt-0">Description</label>
                    <textarea id="descriptionInput0" name="description0" placeholder="Enter description" rows="2" wrap="soft" class="desc-input form-control"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <!--<i class="delete-btn fas fa-trash-alt"></i>-->
            <!--<i class="submit-btn fas fa-check"></i>-->
            <i class="copy-btn far fa-copy" title="Copy Previous Log"></i>
          </div>
        </div>
        <div class="pt-4 text-right">
          <button type="button" class="save-btn btn btn-primary btn-sm"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="save" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-save fa-w-14"><path fill="currentColor" d="M433.941 129.941l-83.882-83.882A48 48 0 0 0 316.118 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V163.882a48 48 0 0 0-14.059-33.941zM224 416c-35.346 0-64-28.654-64-64 0-35.346 28.654-64 64-64s64 28.654 64 64c0 35.346-28.654 64-64 64zm96-304.52V212c0 6.627-5.373 12-12 12H76c-6.627 0-12-5.373-12-12V108c0-6.627 5.373-12 12-12h228.52c3.183 0 6.235 1.264 8.485 3.515l3.48 3.48A11.996 11.996 0 0 1 320 111.48z" class=""></path></svg>  Save</button>
        </div>
        <!--<div class="py-4 container">
          <h3><span class="d-none">[Start Date - End Date]</span><button type="button" class="save-btn btn float-right btn-primary btn-sm"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="save" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-save fa-w-14"><path fill="currentColor" d="M433.941 129.941l-83.882-83.882A48 48 0 0 0 316.118 32H48C21.49 32 0 53.49 0 80v352c0 26.51 21.49 48 48 48h352c26.51 0 48-21.49 48-48V163.882a48 48 0 0 0-14.059-33.941zM224 416c-35.346 0-64-28.654-64-64 0-35.346 28.654-64 64-64s64 28.654 64 64c0 35.346-28.654 64-64 64zm96-304.52V212c0 6.627-5.373 12-12 12H76c-6.627 0-12-5.373-12-12V108c0-6.627 5.373-12 12-12h228.52c3.183 0 6.235 1.264 8.485 3.515l3.48 3.48A11.996 11.996 0 0 1 320 111.48z" class=""></path></svg>  Save</button></h3>
        </div>-->
      </form>

      <!--<a class="add-log btn float-right my-4 btn-link" href="javascript:addTimeLog();">
        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus fa-w-14">
          <path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" class=""></path>
        </svg> Add Log
      </a>-->
      <!--<a class="add-log copy-log btn float-right my-4 mx-4 btn-link" href="javascript:addTimeLog();">
        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-plus fa-w-14">
          <path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z" class=""></path>
        </svg> Copy Prev Log
      </a>-->
      <?php endif; ?>

      <?php if ($currentDay == 8) { include 'includes/timestudyCheck.inc.php'; } ?>

    </div>
  </div>
</div>

<div class="modal fade" id="saveEntries" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Save Time Study Entries</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Save changes to time study entries?</p>
        <div class="float-right">
          <button type="button" class="save-btn btn btn-primary save-modal-btn">Save</button>
          <a id="modalNextPage" class="btn btn-success" href="#" role="button">Go To Selected Page</a>
          <!--<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>-->
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).on("click", ".open-modal-save", function () {
  var dataPage = $(this).data('page');
  $("#modalNextPage").attr('href', './timestudy?id=<?php echo $mhfrpid; ?>&d=' + dataPage);
});
</script>
<?php echo '<script>createTimeLogs();</script>'; ?>