<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

  /***** EDIT BELOW LINES *****/
  $DB_Server = "160.153.57.72"; // MySQL Server
  $DB_Username = "intecare_user"; // MySQL Username
  $DB_Password = "password1"; // MySQL Password
  $DB_DBName = "intecare-rosters"; // MySQL Database Name
  $DB_TBLName = "agency-employees"; // MySQL Table Name
  $xls_filename = 'rosters_'.date('Y-m-d').'.xls'; // Define Excel (.xls) file name

   
  /***** DO NOT EDIT BELOW LINES *****/
  // Create MySQL connection
  //$sql = "Select * from `$DB_TBLName`";
$sql = "Select emp.Email, emp.LastName, emp.FirstName, positions.positionName, emp.MHFRPID, emp.AgencyEmployeeID, agencies.AgencyName, emp.LocationCode, EmployeeTypes.employeeTypeName as EmployeeType, emp.Active, emp.StartDate, emp.EndDate from `agency-employees` as emp INNER JOIN agencies ON emp.InteCareAgencyID=agencies.AgencyId INNER JOIN positions ON emp.PositionID=positions.positionId INNER JOIN EmployeeTypes ON emp.EmployeeType=EmployeeTypes.employeeTypeID;";
  $conn = new mysqli($DB_Server, $DB_Username, $DB_Password, $DB_DBName) or die("Failed to connect to MySQL:<br />" . mysql_error() . "<br />" . mysql_errno());
  // Select database
  //$Db = @mysql_select_db($DB_DBName, $Connect) or die("Failed to select database:<br />" . mysql_error(). "<br />" . mysql_errno());
  // Execute query
  //$result = @mysql_query($sql,$Connect) or die("Failed to execute query:<br />" . mysql_error(). "<br />" . mysql_errno());
   $result = $conn->query($sql);
  // Header info settings
  header("Content-Type: application/xls");
  header("Content-Disposition: attachment; filename=$xls_filename");
  header("Pragma: no-cache");
  header("Expires: 0");
   
  /***** Start of Formatting for Excel *****/
  // Define separator (defines columns in excel &amp; tabs in word)
  $sep = "\t"; // tabbed character
   
  // Start of printing column names as names of MySQL fields
  for ($i = 0; $i<$result->field_count; $i++) {
      
    echo $result->fetch_field_direct($i)->name . "\t";
  }
  print("\n");
  // End of printing column names
   
  // Start while loop to get data
  while($row = $result->fetch_row())
  {
    $schema_insert = "";
    for($j=0; $j<$result->field_count; $j++)
    {
      if(!isset($row[$j])) {
        $schema_insert .= "NULL".$sep;
      }
      elseif ($row[$j] != "") {
        $schema_insert .= "$row[$j]".$sep;
      }
      else {
        $schema_insert .= "".$sep;
      }
    }
    $schema_insert = str_replace($sep."$", "", $schema_insert);
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
    print "\n";
  }
?>