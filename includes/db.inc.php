<?php

// Production DB Credentials
$servername = "localhost";
$dBUsername = "intecare_user";
$dBPassword = "cf73ba6e";
$dbName = "intecare-rosters";
$dbPort = "3306";

// Local (MAMP) DB Credentials
/*$servername = "localhost";
$dBUsername = "root";
$dBPassword = "root";
$dbName = "intecare-rosters";
$dbPort = "3306";*/

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
