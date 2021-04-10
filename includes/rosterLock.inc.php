<?php
    /* Check/Manage Roster Lock */

    require 'db.inc.php';
    $optionName = "rosterStatus";

    if (isset($_POST['roster-submit'])) {
        $lockStatus = $_POST['lock-status'];

        if (!empty($lockStatus)) {
            $sql = "UPDATE options SET value = ? WHERE optionName = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $lockStatus, $optionName);
            $stmt->execute();
            $stmt->close();

            mysqli_close($conn);
            header("Location: ../admin/index.php?success=$lockStatus");
        } else {
            header("Location: ../admin/index.php?error=101");
        }
    } else {
        $sql = "SELECT * FROM options WHERE optionName = ?";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);
        mysqli_stmt_bind_param($stmt, "s", $optionName);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $status = mysqli_fetch_assoc($result);

        if ($status["value"] === "unlocked") {
            $rosterStatus = "Unlocked";
        } else {
            $rosterStatus = "Locked";
        }
    }
    mysqli_close($conn);
?>