<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

//require 'db.inc.php';

function GetHighestMaximusIDbyAgency($stateId){
    $servername = "localhost";
    $username = "intecare_user";
    $password = "password1";
    $dbname = "intecare-rosters";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT `MHFRPID` FROM `agency_employees` WHERE `InteCareAgencyID` = " . $stateId . " ORDER BY `MHFRPID` DESC";
    //echo $sql; exit;
    $result = $conn->query($sql);

    $row = mysqli_fetch_row($result);
    $conn->close();

    return $row[0];

}

function UpdateMHFRPID($sysId, $mhfrpid)
{
  $servername = "localhost";
  $username = "intecare_user";
  $password = "password1";
  $dbname = "intecare-rosters";

  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $sql = "UPDATE `agency_employees` SET `IdNumber` = '" . $mhfrpid . "', `MHFRPID` = '" . $mhfrpid . "' WHERE `agency_employees`.`systemID` = " . $sysId;

  $result = $conn->query($sql);
  $conn->close();

  return;
}

?>
