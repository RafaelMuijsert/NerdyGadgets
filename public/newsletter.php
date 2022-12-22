<!DOCTYPE html>
<html lang="nl">
<head>
    <title>Nieuwsbrief</title>
    <!-- Javascript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <!--        <script src="js/resizer.js"></script>-->

    <!-- Style sheets-->
    <link rel="stylesheet" href="css/main.css" type="text/css">
</head>
<body>

<script> if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
} </script>


<?php
session_start();
include "header.php";
include "../src/functions.php";
include "../src/form-functions.php";
include "./blocks/newsletter.php";
?>


<?php include 'footer.php'; ?>

</body>
</html>

