<?php
    require "includes/loginCheck.inc.php";
    require "header.php";
?>

<?php include "nav.php"; ?>
<div class="container-fluid page-category">
    <div class="row justify-content-center">
        <div class="wrapper col-12">
            <h2 class="text-center">SELECT A CATEGORY</h2>
            <a href="./agency"><p class="text-center">BACK TO HOME</p></a>

            <div class="row justify-content-center category-list">
                <?php include 'includes/categories.inc.php'; ?>
            </div>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>