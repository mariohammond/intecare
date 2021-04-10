<?php
    require "../includes/adminCheck.inc.php";
    require "../includes/rosterLock.inc.php";
    require "../includes/costReport.inc.php";
    require "./header.php";

    include "./nav.php";

    $mhfrpid = $_GET['mhfrpid'];
    $period = $_GET['period'];

    // Display current email
    $sql0 = "SELECT email FROM agency_employees WHERE MHFRPID = ?";
    $stmt0 = $conn->prepare($sql0);
    mysqli_stmt_bind_param($stmt0, "s", $mhfrpid);
    mysqli_stmt_execute($stmt0);
    $result0 = mysqli_stmt_get_result($stmt0);
    $currentEmail = mysqli_fetch_assoc($result0)['email'];
    $stmt0->close();
    
?>

<div class="page-update-email">
    <div class="container pt-3">
        <form action="update-email-success.php?mhfrpid=<?php echo $mhfrpid; ?>&period=<?php echo $period; ?>" method="post">
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label"><strong>Current Email</strong></label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?php echo $currentEmail; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="newEmail" class="col-sm-2 col-form-label"><strong>Updated Email</strong></label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="newEmail" id="newEmail" placeholder="Enter new email here">
                </div>
            </div>
            <div class="form-group row d-flex justify-content-center">
                <a class='btn btn-danger mr-1' href='emp-accounts.php?period=<?php echo $period; ?>' role='button'>Cancel</a>
                <input type="submit" class='btn btn-success' value="Update">
            </div>
        </form>
    </div>
</div>