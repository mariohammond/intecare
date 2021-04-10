<?php
    session_start();

    if (isset($_GET['debug'])) {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }
?>

<!doctype html>
<html lang="en">

<head>
    <title>Intecare</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="js/script.js"></script>
</head>

<body>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert-container">
            <div class="alert alert-danger" role="alert">
                <?php if ($_GET['error'] == '101'): ?>
                    Please fill out all fields.
                <?php elseif ($_GET['error'] == '102'): ?>
                    Email address not found.
                <?php elseif ($_GET['error'] == '103'): ?>
                    Invalid email/password combination.
                <?php elseif ($_GET['error'] == '104'): ?>
                    An unexpected error has occurred. Please contact the administrator.
                <?php elseif ($_GET['error'] == '201'): ?>
                    Please provide a name and email address.
                <?php elseif ($_GET['error'] == '202'): ?>
                    Email address is already registered.
                <?php elseif ($_GET['error'] == '301'): ?>
                    Please enter values for all fields.
                <?php elseif ($_GET['error'] == '302'): ?>
                    Please enter a numeric value for all fields.
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert-container">
            <div class="alert alert-success" role="alert">
                <?php if ($_GET['success'] == '201'): ?>
                    Employee successfully added.
                <?php endif; ?>
                <?php if ($_GET['success'] == '301'): ?>
                    Category successfully updated.
                <?php endif; ?>
                <?php if ($_GET['success'] == '401'): ?>
                    Log page successfully updated.
                <?php endif; ?>
                <?php if ($_GET['success'] == '402'): ?>
                    Weekend logs successfully updated.
                <?php endif; ?>
                <?php if ($_GET['success'] == '403'): ?>
                    All log days successfully updated.
                <?php endif; ?>
                <?php if ($_GET['success'] == '404'): ?>
                    Log day successfully updated.
                <?php endif; ?>
                <?php if ($_GET['success'] == '501'): ?>
                    Time study form successfully submitted.
                <?php endif; ?>
                <?php if ($_GET['success'] == '601'): ?>
                    PDF training completed.
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>