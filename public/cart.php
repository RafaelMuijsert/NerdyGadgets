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
            <div class="col border rounded p-3 m-4">
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
                            $total += $price * $quantity;
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
                                <div class="row text-left">
                                    <div class="col-3 p-0">
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
                                </div>
                            </div>
                            <div class="col-3 align-right">
                                <br>
                                <div class='text-right align-bottom'>
                                    €<?=number_format($stockItem['SellPrice'], 2, '.')?>
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
                print("<h2>Uw winkelmandje is leeg.</h2>");
            } else {
                ?>
                <div class="col">
                    <div class="p-3 rounded border bg-light">
                        <h2 class="text-center">Overzicht</h2>
                        <hr>
                        <?php include "../src/summary.php"?>
                        <h4 class="text-right">Totaal: &euro;<?=$total ?></h4>
                        <a href="order.php" type="button" class="shadow-lg w-100 btn btn-primary">
                            Betalen
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