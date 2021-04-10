<?php
    require "includes/logingCheck.inc.php";
    require "header.php";
?>

<div class="container page-signup">
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php if ($_GET['error'] == '201'): ?>
                Please fill out all fields.
            <?php elseif ($_GET['error'] == '202'): ?>
                Please enter a valid email.
            <?php elseif ($_GET['error'] == '203'): ?>
                Passwords do not match.
            <?php elseif ($_GET['error'] == '204'): ?>
                Email already exists in system. Please <a href="/">login</a>.
            <?php elseif ($_GET['error'] == '205'): ?>
                An unexpected error has occurred. Please contact the administrator.
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center text-center">
        <div class="wrapper col-12 col-md-4">
            <h2 class="text-center">SIGNUP</h2>
            <form class="signupForm" action="includes/signup.inc.php" method="post">
                <div class="form-group">
                    <input type="text" name="firstname" class="form-control" placeholder="FIRST NAME">
                </div>
                <div class="form-group">
                    <input type="text" name="lastname" class="form-control" placeholder="LAST NAME">
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="EMAIL">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="PASSWORD">
                </div>
                <div class="form-group">
                    <input type="password" name="confirmPassword" class="form-control" placeholder="CONFIRM PASSWORD">
                </div>
                <button type="submit" name="signup-submit" class="btn input-block-level">SIGNUP</button>
            </form>
            <p class="signup-options"><a href="/">&#8592; Return To Login</a></p>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>