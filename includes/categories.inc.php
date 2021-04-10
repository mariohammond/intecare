<?php
    /* POPULATE CERTIFICATION COUNT (categories.php) */

    require 'db.inc.php';

    $agencyId = $_COOKIE['agencyId'];
    $nonTime = "14"; // Non-Time Study Category

    // Get all current positions
    $sql = "SELECT * FROM positions WHERE positionId != ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "i", $nonTime);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_all($result);

    // Get count of each position
    foreach ($row as $key=>$value) {
        $positionId = $value[0];
        $positionName = $value[1];

        // Get active employee count and display
        $active = 1;
        $sql2 = "SELECT * FROM agency_employees where InteCareAgencyID = ? and PositionID = ? and Active = ?";
        $stmt2 = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt2, $sql2);
        mysqli_stmt_bind_param($stmt2, "ssi", $agencyId, $positionId, $active);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $activeEmployees = mysqli_num_rows($result2);

        // Get inactive employee count and display
        $active = 0;
        $sql3 = "SELECT * FROM agency_employees where InteCareAgencyID = ? and PositionID = ? and Active = ?";
        $stmt3 = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt3, $sql3);
        mysqli_stmt_bind_param($stmt3, "ssi", $agencyId, $positionId, $active);
        mysqli_stmt_execute($stmt3);
        $result3 = mysqli_stmt_get_result($stmt3);
        $inactiveEmployees = mysqli_num_rows($result3);

        // Display employee count on page
        echo '<div class="category-section col-12 col-md-3">';
        echo '<a href="./position?id=' .  $positionId . '"><h5>' .  strtoupper($positionName) . '</h5></a>';
        echo '<p>' . $activeEmployees . ' active employees</p>';
        echo '<p>' . $inactiveEmployees . ' inactive employees</p>';
        echo '</div>';
    }

    $sql4 = "SELECT * FROM agencies where AgencyId = ?";
    $stmt4 = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt4, $sql4);
    mysqli_stmt_bind_param($stmt4, "s", $agencyId);
    mysqli_stmt_execute($stmt4);
    $result4 = mysqli_stmt_get_result($stmt4);
    $nonTimeCount = mysqli_fetch_assoc($result4);

    $genOverhead = $nonTimeCount['GeneralOverheadStaff'];
    $dirServices = $nonTimeCount['DirectServicesAndOther'];

    echo "<div class='category-section col-12 col-md-3'>";
    echo "<h5 class='non-time' data-toggle='modal' data-target='#nonTimeModal'>NON-TIME STUDY CATEGORY</h5>";
    echo "<p>General Overhead Staff: $genOverhead</p>";
    echo "<p>Direct Services And Other: $dirServices</p>";
    echo '</div>';

    mysqli_close($conn);
?>

<div class="modal fade" id="nonTimeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Non-Time Study Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="includes/editNonTime.inc.php" method="post">
                    <div class="form-group">
                        <label>General Overhead Staff</label>
                        <input type="text" name="genOverhead" value="<?php echo $genOverhead; ?>" placeholder="Enter Value"/>
                    </div>
                    <div class="form-group">
                        <label>Direct Services And Other</label>
                        <input type="text" name="dirServices" value="<?php echo $dirServices; ?>" placeholder="Enter Value"/>
                    </div>
                    <button type="submit" name="btnNonTime" class="btn btn-primary">Save changes</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>