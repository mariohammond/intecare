<?php
  error_reporting(E_ALL); ini_set('display_errors', 1);

  require "header.php"; 
  require './includes/db.inc.php';
  require './includes/empCookies.inc.php';
  require "nav-emp.php";

  $mhfrpid = $_GET['id'];
  
  // Check if employee has started training pdf
  $sql = "SELECT * FROM employee_training WHERE mhfrpid = ?";
  $stmt = mysqli_stmt_init($conn);
  mysqli_stmt_prepare($stmt, $sql);
  mysqli_stmt_bind_param($stmt, "s", $mhfrpid);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $rowCount = mysqli_num_rows($result);

  // If not, document start time
  if ($rowCount == 0) {
    date_default_timezone_set('US/Eastern');
    $currentTime = date("m/d/Y h:i:s A");

    $sql1 = "INSERT INTO employee_training (mhfrpid, pdfStart) VALUES (?, ?)";
    $stmt1 = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt1, $sql1);
    mysqli_stmt_bind_param($stmt1, "ss", $mhfrpid, $currentTime);
    mysqli_stmt_execute($stmt1);
  }
?>

<?php
    $totalPages = 69;
    if (isset($_GET["d"]) && $_GET["d"] != "") {
      $currentPage = intval($_GET["d"]);
      if ($currentPage > $totalPages) {
        header("Location: ./training-pdf?id=$mhfrpid&d=1");
      }
    } else {
      $currentPage = 0;
    }

    $prevPage = $currentPage - 1;
    $nextPage = $currentPage + 1;

    include "includes/pageCheck.inc.php";
?>

<?php if ($currentPage != $totalPages) : ?>
<div class="container-fluid page-training-pdf">
    <div class="row justify-content-center text-center align-items-center">
        <div class="col-1">
          <a <?php if ($currentPage != 1) { echo "href=./training-pdf?id=$mhfrpid&d=$prevPage"; } ?>><i class="fas fa-chevron-left <?php if ($currentPage == 1) { echo 'disabled'; } ?>"></i></a>
        </div>
        <div class="col-10">
          <?php /* if ($currentPage == 2 || $currentPage == 25) : */ ?>
            <?php /* include "docs/html/Time-Study-Training-HTML-$currentPage.php"; */ ?>
          <?php if ($currentPage == 14 || $currentPage == 35 || $currentPage == 68) : ?>
            <script>
              $(function() {
                $(".fa-chevron-right").hide();
              });
            </script>
          <?php include "docs/html/Time-Study-Training-HTML-$currentPage.php"; ?>
          <?php else : ?>
            <!--<iframe id="trainingPdf" src="docs/Time-Study-Training-PPT-<?php echo $currentPage; ?>.pdf"></iframe>-->
            <iframe id="trainingPdf" src="docs/TIME_STUDY_TRAINING_ONLINE_Q1_2021_Part_<?php echo $currentPage; ?>.pdf"></iframe>
          <?php endif; ?>
        </div>
      <div class="col-1">
        <a <?php if ($currentPage != $totalPages) { echo "href=./training-pdf?id=$mhfrpid&d=$nextPage"; } ?>><i class="fas fa-chevron-right <?php if ($currentPage == $totalPages) { echo 'disabled'; } ?>"></i></a>
      </div>
  </div>
</div>
<?php endif; ?>

<?php require "footer.php"; ?>