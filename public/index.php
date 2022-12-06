<!DOCTYPE html>
<html lang="nl">
    <head>
        <title>The place for your gadgets - NerdyGadgets</title>

        <!-- Javascript -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/popper.min.js"></script>

        <!-- Style sheets-->
        <link rel="stylesheet" href="css/main.css" type="text/css">
    </head>
    <body>

    <?php
        include "header.php";
        include "blocks/page-banner.php";
        include "blocks/media-text.php";
        include "blocks/categories.php";
        include "footer.php";
    ?>

    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>
    </body>
</html>

