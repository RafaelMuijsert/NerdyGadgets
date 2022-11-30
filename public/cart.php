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
            <div class="col">
            <?php
            foreach ($_SESSION['cart'] as $key => $item) {
                print("<div class='col'><div class='row'><div class='row align-items-center'>");
                //Haal item op
                $stockItem = getStockItem($key, $databaseConnection);

                // als key niet bestaat, ga door.
                if (!$stockItem) {
                    continue;
                }

                if ($stockItemImage = getStockItemImage($key, $databaseConnection)) {
                    print("<div class='col-2'><img class='img-fluid' src='img/stock-item/" . $stockItemImage[0]['ImagePath'] . "'></div>");
                } else {
                    print("<div class='col-2'><img class='img-fluid' src='img/stock-group/" . $stockItem['BackupImagePath'] . "'></div>");
                }

                print ("<div class='col'><div class='row'>" . $stockItem['StockItemName'] . "</div></div>");
                ?>
                <form method='post'><div class='col'>
                <?php
                $quantity = $_SESSION['cart'][$stockItem['StockItemID']];
                $stock = getItemStock($stockItem['StockItemID'], $databaseConnection)['QuantityOnHand'];

                print("<input onchange='this.form.submit()' required='required' name='" . $stockItem['StockItemID'] . "'min=1 type='number' value='$quantity' max=$stock></div></form>");
                print ("<div class='col'>&euro;" . number_format($stockItem['SellPrice'], 2, '.') . "<span class='close'><a href='cart.php?remove=" . $key . "' class='text-danger'>&#10005;</a></span></div>");
                print("</div></div></div>");
                print("<hr>");
                $price = round($stockItem['SellPrice'], 2);
                $total += $price * $quantity;
            }
            print ("</div>");

            if (empty($_SESSION['cart'])) {
                print("<h2>Uw winkelmandje is leeg.</h2>");
            } else {
            ?>
            <div class="col-4">
                <h5>
                    <b>Overzicht</b>
                </h5>
                <hr>
                <div class="row">
                    <div class="col">Totaal</div>
                    <div class="col text-right">&euro; <?php print(number_format($total, 2, '.')) ?></div>
                </div>
                <hr>
                <div class="text-right">
                    <a href="https://www.ideal.nl/demo/qr/?app=ideal" class="btn btn-primary">Bestelling plaatsen</a>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>

