
<?php
  require 'db.inc.php';

  //Get the list of employees with no mhfrpId
  $sql = "SELECT * FROM `agency_employees_bk` WHERE `MHFRPID` = '' ORDER BY `agency_employees_bk`.`lastUpdate` ASC";
  $stmt = mysqli_stmt_init($conn);

  if (!mysqli_stmt_prepare($stmt, $sql)) {
      echo "?error=104";
      exit();
  } else {
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      
      //get the count of rows in the result
      $rowcount=mysqli_num_rows($result);
      
      //loop through the results
      while($row = mysqli_fetch_assoc($result)) {
        var_dump($row);
        echo "<br/>";   
    }
      
    
  }


/*
  // Get the next MHFRPID
  $sql5 = "SELECT `MHFRPID` FROM `agency_employees` WHERE `InteCareAgencyID` = ? ORDER BY `MHFRPID` DESC";
  $stmt5 = mysqli_stmt_init($conn);
  //var_dump($sql5); exit;

  if (!mysqli_stmt_prepare($stmt5, $sql5)) {
      header("Location: ../?error=104");
      exit();
  } else {
      mysqli_stmt_bind_param($stmt5, "i", $stateId);
      mysqli_stmt_execute($stmt5);
      $result5 = mysqli_stmt_get_result($stmt5);
      $row = mysqli_fetch_row($result5);

      $mhfrpId = $row[0] + 1;
  }
*/
?>
