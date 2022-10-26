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

    <link rel="stylesheet" href="css/components/header.css" type="text/css">
    <link rel="stylesheet" href="css/components/article-header.css" type="text/css">

    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/typekit.css">
</head>
<body>
<div class="Background">
    <header class="header" id="Header">
        <div class="header__pop-up">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="header__pop-up-inner">
                            Plaats hier updates of sale gerelateerde updates zodat de klant daarvan op de hoogte is. (dit is conversie verhogend)
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header__brand">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-3">
                        <a href="./" class="header__logo" id="LogoA">
                            <div id="LogoImage" class="header__logo-img">
                                <img src="./img/logo.png" alt="">
                            </div>
                        </a>
                    </div>
                    <div class="col-2">
                        Winkelmandje + login
                    </div>
                </div>
            </div>
        </div>
        <div class="header__nav">
            <div class="container">
                <div class="row">
                    <div class="col-12" id="CategoriesBar">
                        <ul class="header__categories">
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
            </div>
        </div>

            <!-- code voor US3: zoeken -->



            <!-- einde code voor US3 zoeken -->
    </header>
    <div class="container">
        <div class="row" id="Contentt">
            <!--            <div class="col-12">-->
            <!--                <div id="SubContent">-->
            <!--                --><?php //include "./Components/filter.php"; ?>



