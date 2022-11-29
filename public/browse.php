<!DOCTYPE html>
<html lang="nl">
    <head>
        <title>Browse - NerdyGadgets</title>

        <!-- Javascript -->
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/popper.min.js"></script>
<!--        <script src="js/resizer.js"></script>-->

        <!-- Style sheets-->
        <link rel="stylesheet" href="css/main.css" type="text/css">
    </head>
    <body>

        <?php
            include "header.php";
            include "functions.php";
        ?>

        <!-- dit bestand bevat alle code voor het productoverzicht -->
        <?php

        $ReturnableResult = null;
        $Sort = "SellPrice";
        $SortName = "price_low_high";

        $AmountOfPages = 0;
        $queryBuildResult = "";

        if (isset($_GET['category_id'])):
            $CategoryID = $_GET['category_id'];
        else:
            $CategoryID = "";
        endif;

        if (isset($_GET['products_on_page'])):
            $ProductsOnPage = $_GET['products_on_page'];
            $_SESSION['products_on_page'] = $_GET['products_on_page'];
        elseif (isset($_SESSION['products_on_page'])):
            $ProductsOnPage = $_SESSION['products_on_page'];
        else:
            $ProductsOnPage = 25;
            $_SESSION['products_on_page'] = 25;
        endif;

        if (isset($_GET['page_number'])):
            $PageNumber = $_GET['page_number'];
        else:
            $PageNumber = 0;
        endif;

        // code deel 1 van User story: Zoeken producten
        // <voeg hier de code in waarin de zoekcriteria worden opgebouwd>

        $SearchString = "";

        if (isset($_GET['search_string'])):
            $SearchString = $_GET['search_string'];
        endif;

        if (isset($_GET['sort'])):
            $SortOnPage = $_GET['sort'];
            $_SESSION["sort"] = $_GET['sort'];
        elseif(isset($_SESSION["sort"])):
            $SortOnPage = $_SESSION["sort"];
        else:
            $SortOnPage = "price_low_high";
            $_SESSION["sort"] = "price_low_high";
        endif;

        switch ($SortOnPage):
            case "price_high_low":
            {
                $Sort = "SellPrice DESC";
                break;
            }
            case "name_low_high":
            {
                $Sort = "StockItemName";
                break;
            }
            case "name_high_low";
                $Sort = "StockItemName DESC";
                break;
            case "price_low_high":
            {
                $Sort = "SellPrice";
                break;
            }
            default:
            {
                $Sort = "SellPrice";
                $SortName = "price_low_high";
            }
        endswitch;

        $searchValues = explode(" ", $SearchString);

        $queryBuildResult = "";
        if ($SearchString != ""):
            for ($i = 0; $i < count($searchValues); $i++):
                if ($i != 0):
                    $queryBuildResult .= "AND ";
                endif;
                $queryBuildResult .= "SI.SearchDetails LIKE '%$searchValues[$i]%' ";
            endfor;

            if ($queryBuildResult != ""):
                $queryBuildResult .= " OR ";
            endif;

            if ($SearchString != "" || $SearchString != null):
                $queryBuildResult .= "SI.StockItemID ='$SearchString'";
            endif;
        endif;

        $Offset = $PageNumber * $ProductsOnPage;

        if ($CategoryID != ""):
            if ($queryBuildResult != ""):
                $queryBuildResult .= " AND ";
            endif;
        endif;

        if ($CategoryID == ""):
            if ($queryBuildResult != ""):
                $queryBuildResult = "WHERE " . $queryBuildResult;
            endif;

            $Query = "
                        SELECT SI.StockItemID, SI.StockItemName, SI.MarketingComments, TaxRate, RecommendedRetailPrice, ROUND(TaxRate * RecommendedRetailPrice / 100 + RecommendedRetailPrice,2) as SellPrice,
                        QuantityOnHand,
                        (SELECT ImagePath
                        FROM stockitemimages
                        WHERE StockItemID = SI.StockItemID LIMIT 1) as ImagePath,
                        (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath
                        FROM stockitems SI
                        JOIN stockitemholdings SIH USING(stockitemid)
                        " . $queryBuildResult . "
                        GROUP BY StockItemID
                        ORDER BY " . $Sort . "
                        LIMIT ?  OFFSET ?";


            $Statement = mysqli_prepare($databaseConnection, $Query);
            mysqli_stmt_bind_param($Statement, "ii",  $ProductsOnPage, $Offset);
            mysqli_stmt_execute($Statement);
            $ReturnableResult = mysqli_stmt_get_result($Statement);
            $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

            $Query = "
                    SELECT count(*)
                    FROM stockitems SI
                    $queryBuildResult";
            $Statement = mysqli_prepare($databaseConnection, $Query);
            mysqli_stmt_execute($Statement);
            $Result = mysqli_stmt_get_result($Statement);
            $Result = mysqli_fetch_all($Result, MYSQLI_ASSOC);
        endif;

        if ($CategoryID !== ""):
            $Query = "
                   SELECT SI.StockItemID, SI.StockItemName, SI.MarketingComments, TaxRate, RecommendedRetailPrice,
                   ROUND(SI.TaxRate * SI.RecommendedRetailPrice / 100 + SI.RecommendedRetailPrice,2) as SellPrice,
                   QuantityOnHand,
                   (SELECT ImagePath FROM stockitemimages WHERE StockItemID = SI.StockItemID LIMIT 1) as ImagePath,
                   (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath
                   FROM stockitems SI
                   JOIN stockitemholdings SIH USING(stockitemid)
                   JOIN stockitemstockgroups USING(StockItemID)
                   JOIN stockgroups ON stockitemstockgroups.StockGroupID = stockgroups.StockGroupID
                   WHERE " . $queryBuildResult . " ? IN (SELECT StockGroupID from stockitemstockgroups WHERE StockItemID = SI.StockItemID)
                   GROUP BY StockItemID
                   ORDER BY " . $Sort . "
                   LIMIT ? OFFSET ?";

            $Statement = mysqli_prepare($databaseConnection, $Query);
            mysqli_stmt_bind_param($Statement, "iii", $CategoryID, $ProductsOnPage, $Offset);
            mysqli_stmt_execute($Statement);
            $ReturnableResult = mysqli_stmt_get_result($Statement);
            $ReturnableResult = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC);

            $Query = "
                        SELECT count(*)
                        FROM stockitems SI
                        WHERE " . $queryBuildResult . " ? IN (SELECT SS.StockGroupID from stockitemstockgroups SS WHERE SS.StockItemID = SI.StockItemID)";
            $Statement = mysqli_prepare($databaseConnection, $Query);
            mysqli_stmt_bind_param($Statement, "i", $CategoryID);
            mysqli_stmt_execute($Statement);
            $Result = mysqli_stmt_get_result($Statement);
            $Result = mysqli_fetch_all($Result, MYSQLI_ASSOC);
        endif;

        $amount = $Result[0];

        if (isset($amount)):
            $AmountOfPages = ceil($amount["count(*)"] / $ProductsOnPage);
        endif; ?>

        <section class="browse">
            <div class="container">
                <div class="row">
                    <div class="col-4">
                        <div class="browse__filter bg-white">
                            <h5 class="FilterText">Filteren</h5>
                            <form>
                                <div class="filter" id="FilterOptions">

                                    <div class="filter__search">
                                        <input type="text" placeholder="Waar ben je naar op zoek?" name="search_string" id="search_string" value="<?= (isset($_GET['search_string'])) ? $_GET['search_string'] : ""; ?>" class="form-submit filter__search-input"></div>

                                    <h6 class="FilterTopMargin">Producten per pagina:</h6>
                                    <div class="filter__page">
                                        <input type="hidden" name="category_id" id="category_id" value="<?= (isset($_GET['category_id'])) ? $_GET['category_id'] : ""; ?>">
                                        <select class="filter__page-select" name="products_on_page" id="products_on_page" onchange="this.form.submit()">>
                                            <option value="25" <?php if ($_SESSION['products_on_page'] == 25) {
                                                print "selected";
                                            } ?>>25
                                            </option>
                                            <option value="50" <?php if ($_SESSION['products_on_page'] == 50) {
                                                print "selected";
                                            } ?>>50
                                            </option>
                                            <option value="75" <?php if ($_SESSION['products_on_page'] == 75) {
                                                print "selected";
                                            } ?>>75
                                            </option>
                                        </select>
                                    </div>

                                    <h6 class="dropdown show FilterTopMargin">Sorteren op:</h6>
                                    <div class="filter__order">
                                        <select class="filter__order-select" name="sort" id="sort" onchange="this.form.submit()">>
                                            <option value="price_low_high" <?php if ($_SESSION['sort'] == "price_low_high") {
                                                print "selected";
                                            } ?>>Prijs oplopend
                                            </option>
                                            <option value="price_high_low" <?php if ($_SESSION['sort'] == "price_high_low") {
                                                print "selected";
                                            } ?> >Prijs aflopend
                                            </option>
                                            <option value="name_low_high" <?php if ($_SESSION['sort'] == "name_low_high") {
                                                print "selected";
                                            } ?>>Naam oplopend
                                            </option>
                                            <option value="name_high_low" <?php if ($_SESSION['sort'] == "name_high_low") {
                                                print "selected";
                                            } ?>>Naam aflopend
                                            </option>
                                        </select>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                    $expression = (isset($ReturnableResult) && count($ReturnableResult) > 0);
                ?>
                <div class="col-8 search__res">
                    <div class="browse__results bg-white <?php if($expression): else: echo 'browse__no-results-wrapper'; endif; ?>">
                        <?php if ($expression):
                            foreach ($ReturnableResult as $row): ?>

                                <div class="product-sum" id="ProductFrame">
                                    <a class="ListItem product-sum__left" href='view.php?id=<?= $row['StockItemID']; ?>'>
                                        <?php if (isset($row['ImagePath'])): ?>
                                            <div class="ImgFrame"
                                                 style="background-image: url('<?= "/img/stock-item/" . $row['ImagePath']; ?>'); background-size: 230px; background-repeat: no-repeat; background-position: center;"></div>
                                        <?php elseif (isset($row['BackupImagePath'])): ?>
                                            <div class="ImgFrame"
                                                 style="background-image: url('<?= "/img/stock-group/" . $row['BackupImagePath'] ?>'); background-size: cover;"></div>
                                        <?php endif; ?>
                                    </a>

                                    <div class="product-sum__right" id="StockItemFrameRight">
                                        <div>
                                            <h3 class="product-sum__title" style="width: 82.5%"><?= $row["StockItemName"]; ?></h3>
                                            <span class="product-sum__price"><?= sprintf("€%0.2f", berekenVerkoopPrijs($row["RecommendedRetailPrice"], $row["TaxRate"])); ?></span>
                                            <span class="product-sum__btw">Inclusief btw</span>

                                            <form method="post" class="product-sum__btn">
                                                <input class="btn btn--primary" type="submit" name="<?= ("submit" . $row["StockItemID"]) ?>" value="Toevoegen aan winkelmandje">
                                                <?php if (isset($_POST[("submit" . $row["StockItemID"])])) {
                                                    updateShoppingCart($row["StockItemID"], $databaseConnection);
                                                } ?>
                                            </form>
                                        </div>

                                        <h6 class="product-sum__number">Artikelnummer: <?= $row["StockItemID"]; ?></h6>
                                    </div>
                                </div>

                            <?php endforeach; ?>

                            <form class="pagination" id="PageSelector">

                                <!-- code deel 4 van User story: Zoeken producten  -->
                                <input type="hidden" name="search_string" id="search_string"
                                       value="<?php if (isset($_GET['search_string'])) {
                                           print ($_GET['search_string']);
                                       } ?>">
                                <input type="hidden" name="sort" id="sort" value="<?= ($_SESSION['sort']); ?>">

                                <!-- einde code deel 4 van User story: Zoeken producten  -->
                                <input type="hidden" name="category_id" id="category_id" value="<?php if (isset($_GET['category_id'])) {
                                    print ($_GET['category_id']);
                                } ?>">
                                <input type="hidden" name="result_page_numbers" id="result_page_numbers"
                                       value="<?= (isset($_GET['result_page_numbers'])) ? $_GET['result_page_numbers'] : "0"; ?>">
                                <input type="hidden" name="products_on_page" id="products_on_page"
                                       value="<?= ($_SESSION['products_on_page']); ?>">

                                <?php if ($AmountOfPages > 0):
                                    for ($i = 1; $i <= $AmountOfPages; $i++):
                                        if ($PageNumber == ($i - 1)): ?>
                                            <div id="SelectedPage" class="pagination__btn"><?= $i; ?></div>
                                        <?php else: ?>
                                            <button id="page_number" class="pagination__btn-active" value="<?= ($i - 1); ?>" type="submit" name="page_number"><?= $i; ?></button>
                                        <?php endif;
                                    endfor;
                                endif; ?>
                            </form>
                        <?php else: ?>
                            <h2 class="browse__no-results">
                                Helaas, er zijn geen resultaten gevonden.
                            </h2>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            </div>
        </section>

        <?php include 'footer.php'; ?>


        <script>
            if ( window.history.replaceState ) {
                window.history.replaceState( null, null, window.location.href );
            }
        </script>
    </body>
</html>
