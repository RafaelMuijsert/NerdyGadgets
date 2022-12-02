<?php
include "header.php";
$total = 0;
foreach($_POST as $key => $value) {
    //
    if($value == 0 || !$value) {
        if(isset($_SESSION['cart'][$key])) {
            unset($_SESSION['cart'][$key]);
        }
        continue;
    }
    // bij een negatieve hoeveelheid wordt deze positief gemaakt
    $value = abs($value);
    $stock = getItemStock($key, $GLOBALS['databaseConnection'])['QuantityOnHand'];
    if($stock <= 0) {
        if(isset($_SESSION['cart'][$key])) {
            unset($_SESSION['cart'][$key]);
            continue;
        }
    }
    // hoeveelheid is maximaal het aantal op voorraad
    $value = ($value <= $stock) ? $value : $stock;
    $_SESSION['cart'][$key] = abs($value);
}

foreach($_SESSION['cart'] as $key => $value) {
    $stock = getItemStock($key, $GLOBALS['databaseConnection'])['QuantityOnHand'];
    if($stock <= 0) {
        unset($_SESSION['cart'][$key]);
        continue;
    }
    if($value > $stock) {
        $_SESSION['cart'][$key] = $stock;
    }

}
if(array_key_exists('remove', $_GET)) {
    unset($_SESSION['cart'][$_GET['remove']]);
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
<body class="d-flex flex-column min-vh-100">
<div class="row">
    <div class="col-12">
        <h1>Winkelmandje</h1>
        <hr>
    </div>
    <div class="card border-0">
        <div class="row">
            <div class="col bg-light border rounded p-3 pb-0">
                <?php foreach ($_SESSION['cart'] as $key => $item): ?>
                    <div class='col'>
                        <div class='row'>
                            <div class='row align-items-end'>
                                <?php
                                //Haal item op
                                $stockItem = getStockItem($key, $GLOBALS['databaseConnection']);
                                // als key niet bestaat, ga door.
                                if (!$stockItem) {
                                    continue;
                                }
                                $stockItemImage = getStockItemImage($key, $GLOBALS['databaseConnection']);
                                $stockItemImage = $stockItemImage
                                    ? "img/stock-item/" . $stockItemImage[0]['ImagePath']
                                    : "img/stock-group/" . $stockItem['BackupImagePath'];

                                $quantity = $_SESSION['cart'][$stockItem['StockItemID']];
                                $stock = getItemStock($stockItem['StockItemID'], $GLOBALS['databaseConnection'])['QuantityOnHand'];
                                $price = round($stockItem['SellPrice'], 2);
                                ?>
                                <div class='col-3'>
                                    <img alt="stock item image" class='img-fluid' src='<?=$stockItemImage?>'>
                                </div>
                                <div class='col-5'>
                                    <div class='row'>
                                        <p class="align-text-top align-top">
                                            <?=$stockItem['StockItemName'] ?>
                                        </p>
                                    </div>
                                    <div class="row text-left align-items-center">
                                        <div class="col p-0">
                                            <form method='post'>
                                                <label>
                                                    <input
                                                            onchange='this.form.submit()'
                                                            required='required'
                                                            name='<?=$stockItem['StockItemID']?>'
                                                            min=1
                                                            type='number'
                                                            value='<?=$quantity?>'
                                                            max=<?=$stock?>>
                                                </label>
                                            </form>
                                        </div>
                                        <div class="col-3 align-right">
                                            <a href="cart.php?remove=<?=$key?>" class="text-danger fa-solid fa-cart-shopping"></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3 align-right">
                                    <div class='text-right align-bottom'>
                                        <p>€<?=number_format($stockItem['SellPrice'], 2)?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php endforeach; ?>
            </div>
            <?php
            if (empty($_SESSION['cart'])) {
                ?>
                <div>
                    <h2>Uw winkelmandje is nog leeg.</h2>
                </div>
                <?php
            } else {
                ?>
                <div class="col">
                    <div class="p-3 rounded border bg-light">
                        <h2 class="text-center">Overzicht</h2>
                        <hr>
                        <?php include "../src/summary.php"?>
                        <h4 class="text-right">Totaal: &euro;<?=number_format($total, 2) ?></h4>
                        <a href="order.php" type="button" class="shadow-lg w-100 btn btn-primary">
                            Bestellen
                        </a>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
    <a href="browse.php" class="p-2 mt-5 btn border btn-outline-primary">Verder winkelen</a>
</div>

<?php
include "footer.php";
?>
</body>

