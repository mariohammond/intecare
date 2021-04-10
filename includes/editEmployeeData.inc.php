<?php
    /* ADD NEW EMPLOYEE TO DATABASE (agency-data.php) */

    if (isset($_POST['edit-data-submit'])) {
        require 'db.inc.php';

        // Get input fields from add employee form
        $employeeId = $_POST["employeeId"];
        $salariesWages = $_POST["salariesWages"];
        $payrollTax = $_POST["payrollTax"];
        $otherFringe = $_POST["otherFringe"];
        $duesFees = $_POST["duesFees"];
        $travelTraining = $_POST["travelTraining"];
        $materialsSupplies = $_POST["materialsSupplies"];
        $purchasedServices = $_POST["purchasedServices"];
        $otherExpenses = $_POST["otherExpenses"];
        $totalCost = $_POST["totalCost"];
        $fedRevenue = $_POST["fedRevenue"];
        $netCost = $_POST["netCost"];
        $certified = $_POST["certified"];

        $sql = "UPDATE agency_data SET SalariesWages = ?, PayrollTaxFICA = ?, OtherFringe = ?, DuesFees = ?, TravelTraining = ?, MaterialsSupplies = ?, PurchasedServices = ?, OtherExpenses = ?, TotalCost = ?, FederalRevenueApplicable = ?, NetCost = ?, certified = ? WHERE IdNumber = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ddddddddddddi", $salariesWages, $payrollTax, $otherFringe, $duesFees, $travelTraining, $materialsSupplies, $purchasedServices, $otherExpenses, $totalCost, $fedRevenue, $netCost, $certified, $employeeId);
        $stmt->execute();
        $stmt->close();

        mysqli_close($conn);

        header("Location: ../agency-data?success=201");
        exit();
    } else {
        header("Location: ../agency-data");
        exit();
    }
?>