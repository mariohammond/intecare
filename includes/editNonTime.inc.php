<?php
    $agencyId = $_COOKIE['agencyId'];

    if (isset($_POST['btnNonTime'])) {
        require 'db.inc.php';

        // Get input fields from add employee form
        $genOverhead = $_POST['genOverhead'];
        $dirServices = $_POST['dirServices'];

        // Return with error if field is empty
        if (empty($genOverhead) || empty($dirServices)) {
            header("Location: ../category?error=301");
            exit();
        }

        if (!is_numeric($genOverhead) || !is_numeric($dirServices)) {
            header("Location: ../category?error=302");
            exit();
        }

        $sql = "UPDATE agencies SET GeneralOverheadStaff = ?, DirectServicesAndOther = ? WHERE AgencyId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $genOverhead, $dirServices, $agencyId);
        $stmt->execute();
        $stmt->close();

        mysqli_close($conn);

        header("Location: ../category?success=301");
        exit();
    } else {
        header("Location: ../category");
        exit();
    }
?>