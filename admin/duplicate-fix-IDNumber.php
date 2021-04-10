<?php
    ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
    require "../includes/adminCheck.inc.php";
    require "../includes/rosterLock.inc.php";
    require "../includes/costReport.inc.php";
    require "./header.php";

    include "./nav.php";

    // Get list of all employees
    $sql = "SELECT employees.MHFRPID, COUNT(employees.MHFRPID) AS count 
    FROM agency_employees AS employees
    GROUP BY employees.MHFRPID
    ORDER BY employees.MHFRPID";

    $stmt = $conn->prepare($sql);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $empList = mysqli_fetch_all($result);
    $stmt->close();

    // Get data of employees with duplicate ids
    $entireList = [];
    foreach($empList as $emp) {
      $id = $emp[0];
      $idCount = $emp[1];

      if ($idCount > 1) {
        $sql1 = "SELECT employees.FirstName, employees.LastName, employees.Email, employees.MHFRPID
        FROM agency_employees AS employees
        WHERE employees.mhfrpid = ?";

        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("s", $id);
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        $tempList = mysqli_fetch_all($result1);
        $stmt1->close();

        array_push($entireList, $tempList);
      }
    }
?>

<html>
<body>
    <div style="padding: 20px">
      <?php foreach($entireList as $listById): ?>

      <strong>Duplicate ID: <?php echo $listById[0][3]; ?></strong>
      <table style="margin: 10px 0 20px 0">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Old ID</th>
            <th>New ID</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($listById as $index => $listByEmp): ?>
            
          <?php
            if ($index != 0) {

              // Get duplicate info
              $sql1 = "SELECT employees.systemID, employees.InteCareAgencyID
              FROM agency_employees AS employees
              WHERE employees.mhfrpid = ?";

              $stmt1 = $conn->prepare($sql1);
              $stmt1->bind_param("s", $listByEmp[3]);
              mysqli_stmt_execute($stmt1);
              $result1 = mysqli_stmt_get_result($stmt1);
              $dupList = mysqli_fetch_all($result1);
              $stmt1->close();

              $systemId = $dupList[0][0];
              $agencyId = $dupList[0][1];

              // Get last id of employee's agency
              $sql2 = "SELECT MHFRPID FROM agency_employees WHERE InteCareAgencyID = ? ORDER BY MHFRPID DESC LIMIT 1";
              $stmt2 = $conn->prepare($sql2);
              mysqli_stmt_bind_param($stmt2, "s", $agencyId);
              mysqli_stmt_execute($stmt2);
              $result2 = mysqli_stmt_get_result($stmt2);
              $latestId = mysqli_fetch_all($result2)[0][0];
              $stmt2->close();

              // Increment and update employee's id
              $newId = intval($latestId) + 1;

              $sql3 = "UPDATE agency_employees SET MHFRPID = ? WHERE systemID = ?";
              $stmt3 = $conn->prepare($sql3);
              $stmt3->bind_param("is", $newId, $systemId);
              $stmt3->execute();
              $stmt3->close();

              // Get new id for display
              $sql4 = "SELECT MHFRPID FROM agency_employees WHERE systemID = ?";
              $stmt4 = $conn->prepare($sql4);
              mysqli_stmt_bind_param($stmt4, "s", $systemId);
              mysqli_stmt_execute($stmt4);
              $result4 = mysqli_stmt_get_result($stmt4);
              $updatedId = mysqli_fetch_all($result4)[0][0];
              $stmt4->close();

              echo "
              <tr>
                <td style='width: 30%'>$listByEmp[0] $listByEmp[1]</td>
                <td style='width: 40%'>$listByEmp[2]</td>
                <td style='width: 15%'>$listByEmp[3]</td>
                <td style='width: 15%'>$updatedId</td>
              </tr>
              ";
            } else {
              echo "
              <tr>
                <td style='width: 30%'>$listByEmp[0] $listByEmp[1]</td>
                <td style='width: 40%'>$listByEmp[2]</td>
                <td style='width: 15%'>$listByEmp[3]</td>
                <td style='width: 15%'>NOT CHANGED</td>
              </tr>
              ";
            }
          ?>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php endforeach; ?>
    </div>
</body>
</html>