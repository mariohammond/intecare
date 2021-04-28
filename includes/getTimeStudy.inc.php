<?php
    //error_reporting(E_ALL); ini_set('display_errors', 1);
    require 'db.inc.php';

    $mhfrpid = $_GET['id'];
    $currentDay = isset($_GET["d"]) ? $_GET["d"] : "1";

    // Pull log info from DB
    $sql = "SELECT log_info FROM employee_timestudy_v2 WHERE mhfrpid = ? AND log_day = ?";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);

    mysqli_stmt_bind_param($stmt, "is", $mhfrpid, $currentDay);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $prep = mysqli_fetch_all($result);

    // Convert string data to array
    $prep2 = array();
    $studyData = array();

    $prep2 = explode(",", $prep[0][0]);
    $studyData = array_slice($prep2, 2);

    // Separate time, code, and desc values into different arrays
    $i = 0;
    $codeArray = array();
    $descArray = array();
    $codeElement = 1;
    $descElement = 2;

    foreach ($studyData as $sd) {
        if ($i == $codeElement) {
            $codeArray[$i] = $sd;
            unset($studyData[$i]);
            $codeElement += 3;
        }
        if ($i == $descElement) {
            $descArray[$i] = $sd;
            unset($studyData[$i]);
            $descElement += 3;
        }
        $i++;
    }

    $studyData = array_merge($studyData);
    $codeArray = array_merge($codeArray);
    $descArray = array_merge($descArray);

    // View array content (debug only)
    //var_dump($studyData); echo '<br><br>';
    //var_dump($codeArray); echo '<br><br>';
    //var_dump($descArray); echo '<br><br>';

    // Create scripts to add values to view on page
    $j = 0;
    echo "<script>$(function() {";
    foreach ($studyData as $sd) {
        $currentTime = $j;
        echo "$('#timelog-$currentTime #dayInput').val('$currentDay');";
        echo "$('#timelog-$currentTime #codeInput$currentTime').val('$codeArray[$j]');";

        $finalDesc = html_entity_decode($descArray[$j], ENT_QUOTES | ENT_HTML5);
        echo "$('#timelog-$currentTime #descriptionInput$currentTime').val('$finalDesc');";
        $j++;
    }
    echo "});</script>";

    // Highlight current day
    echo "<script>$(function() { $('#day-$currentDay').addClass('progress__item--current'); });</script>";
?>