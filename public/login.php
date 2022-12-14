<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Login page - NerdyGadgets</title>

    <!-- Javascript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>

    <!-- Style sheets-->
    <link rel="stylesheet" href="css/main.css" type="text/css">
</head>
<body>

<?php
//    $databaseConnection = $GLOBALS['databaseConnection'];
    session_start();
    include "header.php";
    include "./blocks/login.php";
    include "footer.php";
?>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>

