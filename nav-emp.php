<?php //require 'includes/empNav.inc.php'; ?>

<nav class="navbar navbar-expand-lg navbar-dark">
    <a href="./" target="_self" class="navbar-brand"><img src="./images/intecare_logo_white.png"></a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            
            <li class="nav-item link">
                <a class="nav-link" href="./training?id=<?php echo $mhfrpid; ?>">Home</a>
            </li>
            <!--
            <li class="nav-item link">
                <a class="nav-link" href="./training-pdf?id=<?php echo $mhfrpid; ?>">Training PDF</a>
            </li>
          
           
            <li class="nav-item link">
                <a class="nav-link" href="./timestudy?id=<?php echo $mhfrpid; ?>">Time Study Logs</a>
            </li>
            -->
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown dropleft">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $empInfo[0][0] . ' ' . $empInfo[0][1]; ?></a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="includes/logout.inc.php">Signout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<script>
    $(function() {
        $('.nav-item.link a').each(function() {
            if ($(this).prop('href') == window.location.href) {
                $(this).addClass('active'); $(this).parents('li').addClass('active');
            }
        });
    });
</script>