<?php
include "header.php";
$total = 0;
foreach($_POST as $key => $value) {
    //
    if($value == 0 || !$value) {
    continue;
    }
    // bij een negatieve hoeveelheid wordt deze positief gemaakt
    $value = abs($value);
    $stock = getItemStock($key, $databaseConnection)['QuantityOnHand'];
    // hoeveelheid is maximaal het aantal op voorraad
    $value = ($value <= $stock) ? $value : $stock;
    $_SESSION['cart'][$key] = abs($value);
}
if(array_key_exists('remove', $_GET)) {
    unset($_SESSION['cart'][$_GET['remove']]);
}
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>
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
                            $stockItem = getStockItem($key, $databaseConnection);
                            // als key niet bestaat, ga door.
                            if (!$stockItem) {
                                continue;
                            }
                            $stockItemImage = getStockItemImage($key, $databaseConnection);
                            $stockItemImage = $stockItemImage
                                ? "img/stock-item/" . $stockItemImage[0]['ImagePath']
                                : "img/stock-group/" . $stockItem['BackupImagePath'];

                            $quantity = $_SESSION['cart'][$stockItem['StockItemID']];
                            $stock = getItemStock($stockItem['StockItemID'], $databaseConnection)['QuantityOnHand'];
                            $price = round($stockItem['SellPrice'], 2);
                            ?>
                            <div class='col-3'>
                                <img class='img-fluid' src='<?=$stockItemImage?>'>
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
                                            <input
                                                    onchange='this.form.submit()'
                                                    required='required'
                                                    name='<?=$stockItem['StockItemID']?>'
                                                    min=1
                                                    type='number'
                                                    value='<?=$quantity?>'
                                                    max=<?=$stock?>>

                                        </form>
                                    </div>
                                    <div class="col-3 align-right">
                                        <a href="cart.php?remove=<?=$key?>" class="text-danger fa-solid fa-cart-shopping"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 align-right">
                                <div class='text-right align-bottom'>
                                    <p>€<?=number_format($stockItem['SellPrice'], 2, '.')?></p>
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
                        <a href="browse.php" class="btn btn-primary">Verder winkelen</a>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="col">
                        <div class="p-3 rounded border bg-light">
                            <h2 class="text-center">Overzicht</h2>
                            <hr>
                            <?php include "../src/summary.php"?>
                            <h4 class="text-right">Totaal: &euro;<?=number_format($total, 2, '.') ?></h4>
                            <a href="order.php" type="button" class="shadow-lg w-100 btn btn-primary">
                                Bestellen
                            </a>
                        </div>
                    </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>