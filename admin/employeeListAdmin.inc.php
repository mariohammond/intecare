<?php
    // Auto-generated search list
    require '../includes/db.inc.php';

    $vacant = '%vacant%';

    // Get employee list for current quarter
    //$sql0 = "SELECT a.mhfrpid, b.FirstName, b.LastName FROM employee_selected a INNER JOIN agency_employees b ON a.mhfrpid = b.MHFRPID WHERE a.time_period = ? AND b.firstname NOT LIKE ? AND b.lastname NOT LIKE ? ORDER BY b.lastname";
    $sql0 = "SELECT mhfrpid, first_name, last_name FROM employee_selected WHERE time_period = ? AND first_name NOT LIKE ? AND last_name NOT LIKE ? ORDER BY last_name";
    $stmt0 = $conn->prepare($sql0);
    mysqli_stmt_bind_param($stmt0, "sss", $timePeriod, $vacant, $vacant);
    mysqli_stmt_execute($stmt0);
    $result0 = mysqli_stmt_get_result($stmt0);
    $employeeList = mysqli_fetch_all($result0);
    $stmt0->close();


    // Create script to populate list
    echo '<script>$(function() {var availableTags = [';
    foreach($employeeList as $value) {
        $mhfrpid = $value[0];

        $firstname = ucfirst(strtolower($value[1]));
        $firstname = implode("-", array_map("ucfirst", explode("-", $firstname)));
        $firstname = implode("'", array_map("ucfirst", explode("'", $firstname)));
        $firstname = implode(" ", array_map("ucfirst", explode(" ", $firstname)));
        $firstname = implode("Mc", array_map("ucfirst", explode("Mc", $firstname)));

        $lastname = ucfirst(strtolower($value[2]));
        $lastname = implode("-", array_map("ucfirst", explode("-", $lastname)));
        $lastname = implode("'", array_map("ucfirst", explode("'", $lastname)));
        $lastname = implode(" ", array_map("ucfirst", explode(" ", $lastname)));
        $lastname = implode("Mc", array_map("ucfirst", explode("Mc", $lastname)));

        echo '{ id: "' . $mhfrpid . '", label: "' . $firstname . ' ' . $lastname . '" },';
    }

    // Create script to scroll after selection
    echo "]; $('#employeeSearch').autocomplete({ source: availableTags, select: function(event, ui) {
        document.getElementById(ui.item.id).scrollIntoView({ behavior: 'smooth' });
    } }); });</script>";
?>