<?php
    session_start();
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
    <link rel="stylesheet" href="css/beta.css">
    <script type="text/javascript" src="js/script.js"></script>
</head>

<body>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert-container">
            <div class="alert alert-danger" role="alert">
                <?php if ($_GET['error'] == '101'): ?>
                    Please enter a value before submitting.
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert-container">
            <div class="alert alert-success" role="alert">
                <?php if ($_GET['success'] == 'locked'): ?>
                    Roster successfully locked.
                <?php endif; ?>
                <?php if ($_GET['success'] == 'unlocked'): ?>
                    Roster successfully unlocked.
                <?php endif; ?>
                <?php if ($_GET['success'] == 'costReport'): ?>
                    Cost Report period updated.
                <?php endif; ?>
                <?php if ($_GET['success'] == 'training'): ?>
                    Employee training accounts successfully created.
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>