<?php
    require "header.php";
    if (isset($_COOKIE['agencyId'])) {
        header("Location: ./agency");
    }
?>

<div class="container page-login">
    <div class="row justify-content-center text-center">
        <div class="wrapper col-12 col-md-4">
            <h2 class="text-center">INTECARE</h2>
            <form class="loginForm" action="includes/login.inc.php" method="post">
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="EMAIL">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="PASSWORD">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" name="checkbox" class="form-check-input" id="checkbox">
                    <label class="form-check-label" for="checkbox">REMEMBER ME</label>
                </div>
                <button type="submit" name="login-submit" class="btn input-block-level">LOGIN</button>
            </form>
            <!--p class="login-options"><a href="/password-reset">Forgot Password?</a> | <a href="/signup">Sign Up</a></p-->
            <?php //echo password_hash("testing", PASSWORD_DEFAULT); ?>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>