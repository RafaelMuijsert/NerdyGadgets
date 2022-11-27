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
            include "header.php";
            $StockGroups = getStockGroups($databaseConnection);
        ?>

        <div class="row">
            <div class="col-12">
                <div id="Wrap">
                    <?php if (isset($StockGroups)) {
                        $i = 0;
                        foreach ($StockGroups as $StockGroup) {
                            if ($i < 6) {
                                ?>
                                <a href="<?php print "browse.php?category_id=";
                                print $StockGroup["StockGroupID"]; ?>">
                                    <div id="StockGroup<?php print $i + 1; ?>"
                                         style="background-image: url('img/stock-group/<?php print $StockGroup["ImagePath"]; ?>')"
                                         class="StockGroups">
                                        <h1><?php print $StockGroup["StockGroupName"]; ?></h1>
                                    </div>
                                </a>
                                <?php
                            }
                            $i++;
                        }
                    } ?>
                </div>
            </div>
        </div>

        <?php include "footer.php"; ?>

        <script>
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
        </script>
    </body>
</html>
