<!-- de inhoud van dit bestand wordt bovenaan elke pagina geplaatst -->
<?php
session_start();
include "../src/database.php";
$GLOBALS['databaseConnection'] = connectToDatabase();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>NerdyGadgets</title>

    <!-- Javascript -->
    <script src="js/fontawesome.js" crossorigin="anonymous"></script>
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
                            Voor 22:00 besteld, morgen in huis!
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header__brand">
            <div class="container">
                <div class="row align-items-center align-middle m-0">
                    <div class="col-md-3">
                        <a href="" class="header__logo" id="LogoA">
                            <div id="LogoImage" class="header__logo-img">
                                <a href="index.php">
                                    <img src="img/logo.png" alt="">
                                </a>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-5 p-1 rounded float-left align-middle">
                        <form class=" row align-items-center" action="browse.php">
                            <label class="clearfix fa-solid fa-magnifying-glass text-white" for="search_string"></label>
                            <div class="col">
                                <input class="form-control form-submit" type="text" placeholder="Waar ben je naar op zoek?" name="search_string" id="search_string">
                            </div>
                        </form>
                    </div>
                    <div class="nav-wrapper col-md-3">
                        <a href="login.php" class="btn btn-light btn-lg">
                            <i class="fa-solid fa-user"></i> Inloggen
                        </a>
                        <a href="cart.php" class="btn btn-light btn-lg">
                            <i class="fa-solid fa-shopping-bag"></i>
                        </a>
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
                            $HeaderStockGroups = getHeaderStockGroups($GLOBALS['databaseConnection']);

                            foreach($HeaderStockGroups as $HeaderStockGroup){?>
                                <li>
                                    <a href="browse.php?category_id=<?php print $HeaderStockGroup['StockGroupID']; ?>"
                                       class="HrefDecoration"><?php print $HeaderStockGroup['StockGroupName']; ?></a>
                                </li>
                                <?php
                            } ?>
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
<!--    --><?php //hea ?>
    <div class="container">
            <!--            <div class="col-12">-->
            <!--                <div id="SubContent">-->




