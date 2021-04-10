<?php
    header("Location: ./agency"); // temp redirect

    require "includes/loginCheck.inc.php";
    require "header.php";
?>

<?php include "nav.php"; ?>
<div class="container-fluid page-cost-report">
    <div class="row justify-content-center">
        <div class="wrapper col-12">
            <h2 class="text-center">CERTIFICATION STATUS</h2>
            <a href="./agency"><p class="text-center">BACK TO HOME</p></a>

            <div class="row justify-content-center certify-list">
                <?php include 'includes/certifyStatus.inc.php'; ?>
            </div>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>