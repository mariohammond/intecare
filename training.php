<?php 
    //error_reporting(E_ALL); ini_set('display_errors', 1);

    require "header.php"; 
    require './includes/db.inc.php';
    require './includes/empCookies.inc.php';
    require './includes/timeStudyStartDate.inc.php';
    require "nav-emp.php";

?>
<?php
// TimeStudy Start day
$timeStudyStart = getTimeStudyStartDate();
$timeStudyStartSec = strtotime($timeStudyStart);
//current date
$currentDate = strtotime(date("Y-m-d"));
if($currentDate >= $timeStudyStartSec)
{
    $showTimeStudyLink = true;
}
else
{
    $showTimeStudyLink = false;
}
?>
<div class="container-fluid page-training">
    <div class="row justify-content-center text-center">
        <div id="page-fit" class="wrapper col-12">
            <h2 class="text-center">EMPLOYEE TRAINING</h2>
            <?php 
                if ($showTimeStudyLink)
                {
                    echo "Training has ended" . "<!--";
                }

            ?>
            <a href="./training-pdf?id=<?php echo $mhfrpid; ?>">
                <button type="button" class="btn btn-outline-light col-12 col-md-6 mt-4">
                    <h3>TRAINING PDF</h3>
                </button>
            </a>
            <?php 
                if ($showTimeStudyLink)
                {
                    echo "-->";
                }

            ?>

            <h2 class="text-center">TIME STUDY LOGS</h2>
            <?php 
                if (!$showTimeStudyLink)
                {
                    echo "The Time Study will be available on " . $timeStudyStart . "<!--";
                }

            ?>
            <a href="./timestudy?id=<?php echo $mhfrpid; ?>">
                <button type="button" class="btn btn-outline-light col-12 col-md-6 mt-4">
                    <h3>ENTER</h3>
                </button>
            </a>
            <?php 
                if (!$showTimeStudyLink)
                {
                    echo "-->";
                }

            ?>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>