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
    <script src="Public/JS/fontawesome.js"></script>
    <script src="Public/JS/jquery.min.js"></script>
    <script src="Public/JS/bootstrap.min.js"></script>
    <script src="Public/JS/popper.min.js"></script>
    <script src="Public/JS/resizer.js"></script>

    <!-- Style sheets-->
    <link rel="stylesheet" href="Public/CSS/style.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="Public/CSS/typekit.css">
</head>
<body>
<div class="Background">
<!--    <div class="container">-->
        <div class="row" id="Header">
            <div class="col-2"><a href="./" id="LogoA">
                    <div id="LogoImage">
                        <img src="Public/img/correct-format__nerdy-gadgets-logo.png" alt="">
                    </div>
                </a></div>
            <div class="col-8" id="CategoriesBar">
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
<!--        </div>-->
<!-- code voor US3: zoeken -->



<!-- einde code voor US3 zoeken -->
    </div>
<!--    <div class="container">-->
        <div class="row" id="Content">
            <div class="col-12">
                <div id="SubContent">
<!--                --><?php //include "./Components/filter.php"; ?>



