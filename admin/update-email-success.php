<?php
    require "../includes/adminCheck.inc.php";
    require "../includes/rosterLock.inc.php";
    require "../includes/costReport.inc.php";
    require "./header.php";

    include "./nav.php";

    $period = $_GET["period"];
    $mhfrpid = $_GET["mhfrpid"];
    $newEmail = $_POST["newEmail"];

    if ($newEmail == '') {
        header("Location: emp-accounts.php?period=$period");
    } else {
        $sql = "UPDATE agency_employees SET Email = ? WHERE MHFRPID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $newEmail, $mhfrpid);
        $stmt->execute();
        $stmt->close();

        header("Location: emp-accounts.php?period=$period&email=update");
    }
?>
