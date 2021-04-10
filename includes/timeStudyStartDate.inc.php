<?php
    //error_reporting(E_ALL); ini_set('display_errors', 1);
    
    function getTimeStudyStartDate()
    {
        require 'db.inc.php';
        $sql = "SELECT value FROM options WHERE optionId = 6";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);

        //mysqli_stmt_bind_param($stmt, "is", $mhfrpid, $currentDay);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $option = mysqli_fetch_assoc($result);
        $temp = $option['value'];
        return $temp;
    }

    function isTimeStudyStartDatePast()
    {
        require 'db.inc.php';
        $sql = "SELECT value FROM options WHERE optionId = 6";
        $stmt = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt, $sql);

        //mysqli_stmt_bind_param($stmt, "is", $mhfrpid, $currentDay);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $option = mysqli_fetch_assoc($result);

        // TimeStudy Start day
        $timeStudyStart = $option['value'];
        $timeStudyStartSec = strtotime($timeStudyStart);
        //current date
        $currentDate = strtotime(date("Y-m-d"));
        if($currentDate >= $timeStudyStartSec)
        {
            $timeStudyStartDatePast = true;
        }
        else
        {
            $timeStudyStartDatePast = false;
        }

        return $timeStudyStartDatePast;
    }
    
?>