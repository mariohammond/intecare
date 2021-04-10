<?php
    /* ADD NEW EMPLOYEE TO DATABASE (agency-data.php) */

    if (isset($_POST['edit-data-submit'])) {
        require 'db.inc.php';

        // Get input fields from add employee form
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $agencyID = $_POST["selectedAgencyID"];


        $sql = "INSERT INTO employee_login (id, email, FirstName, LastName, password, agencyID) VALUES (NULL, ?, ?, ?, ?, ?);";


        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $email, $firstname, $lastname, $passwordHash, $agencyID);

        $stmt->execute();
        
        $stmt->close();

        mysqli_close($conn);

        header("Location: ../admin/index?success=701");
        exit();
    } else {
        header("Location: ../admin/index");
        exit();
    }

?>
