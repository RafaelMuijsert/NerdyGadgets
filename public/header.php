<!-- de inhoud van dit bestand wordt bovenaan elke pagina geplaatst -->
<?php
session_start();
include "database.php";
$databaseConnection = connectToDatabase();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>NerdyGadgets</title>

    <!-- Javascript -->
    <script src="js/fontawesome.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/resizer.js"></script>

    <!-- Style sheets-->
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/typekit.css">
</head>
<body>
<div class="Background">
    <header id="Header">
        <div class="container">
            <div class="row">
                <div class="col-3"><a href="./" id="LogoA">
                        <div id="LogoImage">
                            <img src="./img/logo.png" alt="">
                        </div>
                    </a></div>
                <div class="col-9" id="CategoriesBar">
                    <ul id="ul-class">
                        <?php
                        $HeaderStockGroups = getHeaderStockGroups($databaseConnection);

                        foreach ($HeaderStockGroups as $HeaderStockGroup) {
                            ?>
                            <li>
                                <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID']; ?>"
                                   class="HrefDecoration"><?php print $HeaderStockGroup['StockGroupName']; ?></a>
                            </li>
                            <?php
                        }
                        ?>
                        <li>
                            <a href="categories.php" class="HrefDecoration">Alle categorieën</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- code voor US3: zoeken -->



            <!-- einde code voor US3 zoeken -->
        </div>
    </header>
    <div class="container">
        <div class="row" id="Content">
            <!--            <div class="col-12">-->
            <!--                <div id="SubContent">-->
            <!--                --><?php //include "./Components/filter.php"; ?>



