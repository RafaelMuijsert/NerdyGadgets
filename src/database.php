<!-- dit bestand bevat alle code die verbinding maakt met de database -->
<?php

function connectToDatabase() {
    $Connection = null;

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
    try {
        $Connection = mysqli_connect("localhost", "nerd", "NerdyGadgets69420!@", "nerdygadgets");
        mysqli_set_charset($Connection, 'latin1');
        $DatabaseAvailable = true;
    } catch (mysqli_sql_exception $e) {
//        var_dump($e);
        $DatabaseAvailable = false;
    }
    if (!$DatabaseAvailable) {
        ?><h2>Website wordt op dit moment onderhouden.</h2><?php
        die();
    }

    return $Connection;
}

function getHeaderStockGroups($databaseConnection) {
    $Query = "
                SELECT StockGroupID, StockGroupName, ImagePath
                FROM stockgroups 
                WHERE StockGroupID IN (
                                        SELECT StockGroupID 
                                        FROM stockitemstockgroups
                                        ) AND ImagePath IS NOT NULL
                ORDER BY StockGroupID ASC";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $HeaderStockGroups = mysqli_stmt_get_result($Statement);
    return $HeaderStockGroups;
}

function getStockGroups($databaseConnection) {
    $Query = "
            SELECT StockGroupID, StockGroupName, ImagePath
            FROM stockgroups 
            WHERE StockGroupID IN (
                                    SELECT StockGroupID 
                                    FROM stockitemstockgroups
                                    ) AND ImagePath IS NOT NULL
            ORDER BY StockGroupID ASC";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $StockGroups = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $StockGroups;
}

function getStockItem($id, $databaseConnection) {
    $Result = null;

    $Query = " 
           SELECT SI.StockItemID, 
            (RecommendedRetailPrice*(1+(TaxRate/100))) AS SellPrice, 
            StockItemName,
            CONCAT('Voorraad: ',QuantityOnHand)AS QuantityOnHand,
            SearchDetails, 
            (CASE WHEN (RecommendedRetailPrice*(1+(TaxRate/100))) > 50 THEN 0 ELSE 6.95 END) AS SendCosts, MarketingComments, CustomFields, SI.Video,
            (SELECT ImagePath FROM stockgroups JOIN stockitemstockgroups USING(StockGroupID) WHERE StockItemID = SI.StockItemID LIMIT 1) as BackupImagePath   
            FROM stockitems SI 
            JOIN stockitemholdings SIH USING(stockitemid)
            JOIN stockitemstockgroups ON SI.StockItemID = stockitemstockgroups.StockItemID
            JOIN stockgroups USING(StockGroupID)
            WHERE SI.stockitemid = ?
            GROUP BY StockItemID";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $ReturnableResult = mysqli_stmt_get_result($Statement);
    if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
        $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
    }

    return $Result;
}
function getItemStock($id, $databaseConnection) {
  $Result = null;
  $Query = "SELECT QuantityOnHand FROM stockitemholdings WHERE StockItemID = ?";
  $Statement = mysqli_prepare($databaseConnection, $Query);
  mysqli_stmt_bind_param($Statement, "i", $id);
  mysqli_stmt_execute($Statement);
  $ReturnableResult = mysqli_stmt_get_result($Statement);
  if ($ReturnableResult && mysqli_num_rows($ReturnableResult) == 1) {
      $Result = mysqli_fetch_all($ReturnableResult, MYSQLI_ASSOC)[0];
  }

  return $Result;
}

function getStockItemImage($id, $databaseConnection) {

    $Query = "
                SELECT ImagePath
                FROM stockitemimages 
                WHERE StockItemID = ?";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_bind_param($Statement, "i", $id);
    mysqli_stmt_execute($Statement);
    $R = mysqli_stmt_get_result($Statement);
    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);

    return $R;
}

/*
 *  Update shopping cart after submit with necessary checks
 * */
function updateShoppingCart($itemID, $connection) {
    $stock = getItemStock($itemID, $connection)['QuantityOnHand'];

    if(array_key_exists($itemID, $_SESSION['cart']) && $stock <= $_SESSION['cart'][$itemID]) {
        $_SESSION['cart'][$itemID] = $stock;
        print("<p style='color: red; max-width: 250px; text-align: right;'>Kan niet meer producten toevoegen dan de hoeveelheid producten in voorraad.</p>");
        return false;
    }

    if(array_key_exists($itemID, $_SESSION['cart'])) {
        $_SESSION['cart'][$itemID]++;
    } else {
        $_SESSION['cart'][$itemID] = 1;
    }

    print("<a style='color: green' href='../public/cart.php'>Toegevoegd!</a>");
    return true;
}
function getCountry($databaseConnection) {
    $Query = "
            SELECT CountryID, CountryName
            FROM Countries 
            ORDER BY CountryName ASC";
    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $Result = mysqli_stmt_get_result($Statement);
    $Countries = mysqli_fetch_all($Result, MYSQLI_ASSOC);
    return $Countries;
}