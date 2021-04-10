<?php
    require 'db.inc.php';

    $pages = [];
    $completed = true;

    $mhfrpid = $_GET['id'];
    
    // Get viewed pages from db
    $sql = "SELECT * FROM employee_pdf WHERE mhfrpid = ? ORDER BY pdfPage DESC";
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_bind_param($stmt, "i", $mhfrpid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $pageData = mysqli_fetch_all($result);

    if ($currentPage == 0) {
        $startPage = $pageData[0][2];
        if (empty($startPage)) {
            header("Location: ./training-pdf?id=$mhfrpid&d=1");
        } else {
            header("Location: ./training-pdf?id=$mhfrpid&d=$startPage");
        }
    } else {
        // Check if page has already been viewed
        $sql2 = "SELECT * FROM employee_pdf WHERE mhfrpid = ? AND pdfPage = ?";
        $stmt2 = mysqli_stmt_init($conn);
        mysqli_stmt_prepare($stmt2, $sql2);
        mysqli_stmt_bind_param($stmt2, "ii", $mhfrpid, $currentPage);
        mysqli_stmt_execute($stmt2);
        $result2 = mysqli_stmt_get_result($stmt2);
        $pageData2 = mysqli_fetch_all($result2);

        // If not, add page to db
        if (empty($pageData2)) {
            $sql3 = "INSERT INTO employee_pdf (mhfrpid, pdfPage) VALUES (?, ?)";
            $stmt3 = mysqli_stmt_init($conn);
            mysqli_stmt_prepare($stmt3, $sql3);
            mysqli_stmt_bind_param($stmt3, "ii", $mhfrpid, $currentPage);
            mysqli_stmt_execute($stmt3);
        }
    }

    // Get status of pages
    if ($currentPage == $totalPages) {
        // Add page numbers to array
        foreach ($pageData as $page) {
            array_push($pages, $page[2]);
        }
    }
?>

<?php if ($currentPage == $totalPages) : ?>
<div class="container pt-4 pb-1 page-check">
    <div class="pb-4">
        <h4>Training PDF Status</h4>
        <i>Each page must be viewed to be marked as complete.</i>
    </div>
    <?php foreach (range(1, $totalPages - 1) as $number) : ?>
        <?php if (!in_array($number, $pages)) :?>
        <p>Page <?php echo $number ?>:
        <span class="text-danger"><a href="./training-pdf?id=<?php echo $mhfrpid; ?>&d=<?php echo $number ?>">INCOMPLETE</a></span>
        <?php $completed = false; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
<?php if ($completed) : ?>
<div class="container pt-4 pb-1 text-center">
    <h3>TRAINING COMPLETE</h3>
    <a href="includes/completePdf.inc.php?id=<?php echo $mhfrpid; ?>"><button type="button" class="btn btn-primary">Complete Training</button>
</div>
<?php endif; ?>
<?php endif; ?>