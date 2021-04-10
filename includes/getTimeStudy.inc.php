<?php
    //error_reporting(E_ALL); ini_set('display_errors', 1);
    require 'db.inc.php';

    $mhfrpid = $_GET['id'];
    $currentDay = isset($_GET["d"]) ? $_GET["d"] : "1";

    $sql = "SELECT log_day, log_time, log_code, log_desc FROM employee_timestudy WHERE mhfrpid = ? AND log_day = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);

    mysqli_stmt_bind_param($stmt, "is", $mhfrpid, $currentDay);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $studyData = mysqli_fetch_all($result);

    $logCount = sizeof($studyData);

    // Populate logs from db
    foreach ($studyData as $index=>$log) {
        $currentTime = intval($log[1]) - 1;
        $finalDesc = html_entity_decode($log[3], ENT_QUOTES | ENT_HTML5);
        echo "<script>$(function() {
            $('#timelog-$currentTime #dayInput').val('$log[0]');
            $('#timelog-$currentTime #codeInput$currentTime').val('$log[2]');
            $('#timelog-$currentTime #descriptionInput$currentTime').val('$finalDesc');
        });</script>";
    }

    // Highlight current day
    echo "<script>$(function() { $('#day-$currentDay').addClass('progress__item--current'); });</script>";
?>