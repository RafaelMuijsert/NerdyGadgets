<?php
require __DIR__ . '/environment.php';
require __DIR__ . '/../vendor/autoload.php';
function connectToDatabase($writeAccess) {
    $connection = null;

    $databaseUser = ($writeAccess) ? getEnvironmentVariable('DB_USER_WRITE') : getEnvironmentVariable('DB_USER');
    $databasePassword = ($writeAccess) ? getEnvironmentVariable('DB_PASSWORD_WRITE') : getEnvironmentVariable('DB_PASSWORD');

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // Set MySQLi to throw exceptions
    try {
        $connection = mysqli_connect(
            getEnvironmentVariable('DB_HOST'),
            $databaseUser,
            $databasePassword,
            getEnvironmentVariable('DB_NAME'),
            getEnvironmentVariable('DB_PORT')
        );
        mysqli_set_charset($connection, 'latin1');
        $databaseAvailable = true;
    } catch (mysqli_sql_exception $e) {
//        var_dump($e);
        error_log($e->getMessage());
        $databaseAvailable = false;
    }
    if (!$databaseAvailable) {
        ?><h2>Kon geen verbinding maken met de database.</h2><?php
        die();
    }

    $GLOBALS['databaseConnection'] = $connection;
    return $connection;
}

function getHeaderStockGroups($databaseConnection) {
    $Query = "
                SELECT *
                FROM stock_groups";
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
            IsChillerStock,
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

  return $Result['QuantityOnHand'];
}

function getColdroomTemperature($databaseConnection) {
    try {
        $result = mysqli_query($databaseConnection, 'SELECT Temperature FROM coldroomtemperatures');
        return(mysqli_fetch_row($result)[0]);
    } catch (Exception $err) {
        return '???';
    }

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

function getDatabaseHostname($databaseConnection) {
    $Query = "SELECT @@HOSTNAME";

    $Statement = mysqli_prepare($databaseConnection, $Query);
    mysqli_stmt_execute($Statement);
    $R = mysqli_stmt_get_result($Statement);
    $R = mysqli_fetch_all($R, MYSQLI_ASSOC);
    return $R[0]['@@HOSTNAME'];
}

function cartUpdateRequested() {
    return isset($_POST['id']);
}

/*
 *  Update shopping cart after submit with necessary checks
 * */
function updateShoppingCart($connection) {
    if(array_key_exists('remove', $_GET)):
        unset($_SESSION['cart'][$_GET['remove']]);
    endif;

    if(cartUpdateRequested()) {
        $quantity = 1;
        if(isset($_POST['itemQuantity'])) {
            $quantity = intval($_POST['itemQuantity']);
        }
        if(addToCart($_POST['id'], $quantity, $connection)) {
            return true;
        } else {
            return false;
        }
    }
}
/*
Add $quantity of $id to cart. Returns false if available stock is less than $quantity.
*/
function addToCart($id, $quantity, $connection) {
    $quantity = abs($quantity);
    if($quantity == 0) {
        return false;
    }
    $stock = getItemStock($id, $connection);

    $cartQuantity = 0;
    if(array_key_exists($id, $_SESSION['cart'])) {
        $cartQuantity = $_SESSION['cart'][$id];
    }
    if($stock < $cartQuantity + $quantity) {
        return false;
    }
    $_SESSION['cart'][$id] = $cartQuantity + $quantity;
    return true;
}
