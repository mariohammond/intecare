<?php

/*$servername = "us-cdbr-iron-east-02.cleardb.net";
$dBUsername = "bf1a8ae3089fa8";
$dBPassword = "cf73ba6e";
$dbName = "heroku_67836d319d02a26";
$dbPort = "3306";*/

$servername = "localhost";
$dBUsername = "intecare_user";
$dBPassword = "cf73ba6e";
$dbName = "intecare-rosters";
$dbPort = "3306";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
