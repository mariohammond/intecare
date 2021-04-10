<?php
    // Auto-generated search list
    require 'db.inc.php';
    $agencyId = $_COOKIE['agencyId'];
    $vacant = '%vacant%';

    $sql = "SELECT systemId, firstname, lastname FROM agency_employees WHERE inteCareAgencyID = ? AND lastname NOT LIKE ? ORDER BY lastname"; //sysid
    $stmt = mysqli_stmt_init($conn);

    // Throw error is db issue
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../?error=304");
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $agencyId, $vacant);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_all($result);

        echo '<script>$(function() {var availableTags = [';
        foreach($row as $value) {
            $systemId = $value[0];

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

            //echo '"' . $firstname . ' ' . $lastname . '",';
            echo '{ id: "' . $systemId . '", label: "' . $firstname . ' ' . $lastname . '" },';
        }

        //echo ']; $("#employeeSearch").autocomplete({ source: availableTags }); });</script>';
        echo ']; $("#employeeSearch").autocomplete({ source: availableTags, select: function(event, ui) {
            //console.log( "Selected: " + ui.item.value + " aka " + ui.item.id );
            window.location.href = "./employee-edit?id=" + ui.item.id;
          } }); });</script>';

        //return $row;
    }
