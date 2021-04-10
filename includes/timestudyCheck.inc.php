<?php
    error_reporting(E_ALL); ini_set('display_errors', 1);
    require 'db.inc.php';
    require 'getQuarter.inc.php';

    //$mhfrpid = $_COOKIE['mhfrpid'];
    $weekCheck = [];
    $completed = true;

    // Check if time log has been signed
    $sql0 = "SELECT * FROM employee_training WHERE mhfrpid = ? and timePeriod = '" . $currentQuarter ."' and timestudyComplete = 'yes' AND completionDate <> ''";
    $stmt0 = $conn->prepare($sql0);
    mysqli_stmt_bind_param($stmt0, "s", $mhfrpid);
    mysqli_stmt_execute($stmt0);
    $result0 = mysqli_stmt_get_result($stmt0);
    $rowCount = mysqli_num_rows($result0);
    $sigInfo = mysqli_fetch_assoc($result0);
    $stmt0->close();

    // Get count of completed log entries
    for ($i = 1; $i <= 7; $i++) {
        $sql = "SELECT COUNT(*) AS count FROM employee_timestudy WHERE mhfrpid = ? AND log_day = ? AND log_code <> '' AND log_desc <> ''";
        $stmt = $conn->prepare($sql);
        mysqli_stmt_bind_param($stmt, "ss", $mhfrpid, $i);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $logCheck = mysqli_fetch_assoc($result);
        array_push($weekCheck, $logCheck["count"]);
        $stmt->close();
    }
?>

<div class="container pt-4 pb-1 study-instructions">
    <div class="pb-4">
        <h4>Activity Log Status</h4>
        <i>Each day must have at least 12 hours of logs to be marked as complete.</i>
    </div>
    <?php foreach ($weekCheck as $day=>$dayCount): $logDay = $day + 1; ?>
        <p>Day <?php echo $logDay ?>:
        <?php if ($dayCount >= 48) :?>
        <span class="text-success">COMPLETE</span>
        <?php else : ?>
        <?php $completed = false; ?>
        <span class="text-danger"><a href="./timestudy?id=<?php echo $mhfrpid; ?>&d=<?php echo $logDay ?>">INCOMPLETE (<?php echo $dayCount; ?> of 48 entries completed)</a></span>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<?php if ($completed) : ?>

<?php if ($rowCount > 0) : ?>
<div class="text-center">
    <button type="button" class="btn btn-secondary">Signature Added <?php echo $sigInfo['completionDate']; ?></button>
</div>
<?php else : ?>
<div class="text-center">
    <button type="button" class="btn btn-primary" onClick="openSigModal()">Apply Signature</button>
</div>
<?php endif; ?>

<div role="dialog" aria-hidden="true" class="modal fade" style="display:none;" id="signatureModal">
    <div class="modal-dialog modal-md">
        <div tabindex="-1" role="document" class="modal-content">
            <div class="modal-body">
                <h3>Electronic Signature</h3>
                <p>By typing your name and clicking "submit" below, you agree that the information captured in this time study is truthful and reflective of real events.</p>
                <form action="includes/addSignature.inc.php" method="post">
                    <div class="form-group">
                        <label for="signatureInput">Full Name</label>
                        <input id="signatureInput" type="text" name="signature" required="required" aria-required="true" class="form-control">
                    </diV>
                    <div class="form-group">
                        <label for="dateInput">Completion Date</label>
                        <input id="dateInput" type="date" name="date" required="required" aria-required="true" class="form-control">
                    </diV>
                    <div class="form-group">
                        <label for="commentInput">Comments</label>
                        <input id="commentInput" type="text" name="comment" aria-required="true" class="form-control">
                    </diV>
                    <button type="submit" class="btn float-right mt-3 btn-primary">Submit</button>
                    <button type="button" class="btn float-right mt-3 btn-link" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>