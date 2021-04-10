<?php
    // Destroy cookies
    unset($_COOKIE['agencyId']);
    setcookie('agencyId', '', time() - 3600, '/');

    unset($_COOKIE['loginId']);
    setcookie('loginId', '', time() - 3600, '/');

    unset($_COOKIE['role']);
    setcookie('role', '', time() - 3600, '/');

    unset($_COOKIE['mhfrpid']);
    setcookie('mhfrpid', '', time() - 3600, '/');

    // Destroy sesssion
    session_unset();
    session_destroy();

    // Redirect to home page
    header("Location: ../");
//}
