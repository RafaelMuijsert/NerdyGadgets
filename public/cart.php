<?php
include "header.php";
$total = 0;
foreach($_POST as $key => $value) {
  $value = abs($value);
  $stock = getItemStock($key, $databaseConnection)['QuantityOnHand'];
  $value = ($value <= $stock) ? $value : $stock;
  $_SESSION['cart'][$key] = abs($value);
}
if(!empty($_GET['remove'])) {
  unset($_SESSION['cart'][$_GET['remove']]);
}
?>
<div class="row">
    <div class="col-12">
        <h1>Winkelmandje</h1>
        <hr>
    </div>
    <div class="card border-0">
        <div class="row">
            <?php
            foreach ($_SESSION['cart'] as $key => $item) {
                print("<div class='col-8'><div class='row'><div class='row align-items-center'>");
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
                $stock = end(explode(': ', $stockItem['QuantityOnHand'])); 

                print("<input name='" . $stockItem['StockItemID'] . "'min=1 type='number' value='$quantity' max=$stock></div></form>");
                print ("<div class='col'>&euro;" . number_format($stockItem['SellPrice'], 2, '.') . "<span class='close'><a href='cart.php?remove=" . $key . "' class='text-danger'>&#10005;</a></span></div>");
                print("</div></div></div>");
                $price = round($stockItem['SellPrice'], 2);
                $total += $price * $quantity;
            }


            if (empty($_SESSION['cart'])) {
                print("Uw winkelwagen is leeg.");
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

<script>
    // Verwijder URL GET-query om dubbele uitvoering te voorkomen op ververs.
    window.history.pushState("object or string", "Title", "/" + window.location.href.substring(window.location.href.lastIndexOf('/') + 1).split("?")[0]);
</script>
