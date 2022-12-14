<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Bestel overzicht - NerdyGadgets</title>

    <!-- Javascript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>

    <!-- Style sheets-->
    <link rel="stylesheet" href="css/main.css" type="text/css">
</head>
<body>

<?php
    session_start();
    include "../src/functions.php";
    include "header.php";
    include "./blocks/checkout.php";
    include "footer.php";
?>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>

