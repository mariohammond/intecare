<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
require 'includes/db.inc.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$agencyId = $_COOKIE['agencyId'];

// Get current time period
$sql0 = "SELECT `value` FROM `options` WHERE optionName = 'current-time-study'";
$stmt0 = $conn->prepare($sql0);
mysqli_stmt_execute($stmt0);
$result0 = mysqli_stmt_get_result($stmt0);
$timePeriod = mysqli_fetch_all($result0)[0][0];
$stmt0->close();

// Get agency participants list
$sql1 = "SELECT agency_employees.FirstName, agency_employees.LastName, agency_employees.Email, agency_employees.MHFRPID FROM employee_selected INNER JOIN agency_employees WHERE employee_selected.mhfrpid = agency_employees.MHFRPID AND agency_id = ? AND time_period = ?";
$stmt1 = $conn->prepare($sql1);
mysqli_stmt_bind_param($stmt1, "ss", $agencyId, $timePeriod);
mysqli_stmt_execute($stmt1);
$result1 = mysqli_stmt_get_result($stmt1);
$empList = mysqli_fetch_all($result1);
$stmt1->close();

// Get current site
$serverHost = $_SERVER['HTTP_HOST'];
if ($serverHost == 'perfectpickem.com') {
    $requestUrl = explode('/', $_SERVER['REQUEST_URI'])[1];
    $currentUrl = 'http://www.' . $serverHost . '/' . $requestUrl;
} else {
    $currentUrl = 'http://www.' . $serverHost;
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(30);
$spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
$spreadsheet->getDefaultStyle()->getFont()->setSize(12);

$sheet->setCellValue('A1', 'First Name');
$sheet->setCellValue('B1', 'Last Name');
$sheet->setCellValue('C1', 'Email');
$sheet->setCellValue('D1', 'MHFRPID');
$sheet->setCellValue('E1', 'Timestudy Link');
$sheet->setCellValue('F1', 'Training Pages Completed');

foreach ($empList as $x=>$emp) {
    $cell = $x + 2;
    $link = $currentUrl . "/timestudy?id=" . $empList[$x][3];

    // Check employee progress of training pdf
    $sql2 = "SELECT COUNT(*) AS count FROM employee_pdf WHERE mhfrpid = ?";
    $stmt2 = $conn->prepare($sql2);
    mysqli_stmt_bind_param($stmt2, "s", $emp[3]);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);
    $pgData = mysqli_fetch_assoc($result2);
    $pgCount = $pgData['count'];
    array_push($emp, $pgCount);
    $stmt2->close();

    $sheet->setCellValue("A$cell", $empList[$x][0]);
    $sheet->setCellValue("B$cell", $empList[$x][1]);
    $sheet->setCellValue("C$cell", $empList[$x][2]);
    $sheet->setCellValue("D$cell", $empList[$x][3]);
    $sheet->setCellValue("E$cell", $link);
    $sheet->setCellValue("F$cell", $pgCount);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Participant_Progress_List.xlsx"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');