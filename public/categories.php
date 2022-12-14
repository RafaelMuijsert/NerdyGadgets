<!DOCTYPE html>
<html lang="nl">
    <head>
        <title>Categoriën - NerdyGadgets</title>

        <!-- Javascript -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/resizer.js"></script>

        <!-- Style sheets-->
        <link rel="stylesheet" href="css/main.css" type="text/css">
    </head>
    <body>

        <?php
            session_start();
            include "header.php";
            include __DIR__ . "/blocks/categories.php";
            include "footer.php";
         ?>

        <script>
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
        </script>
    </body>
</html>
