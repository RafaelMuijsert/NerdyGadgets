<?php
include "header.php";
include "cartFunctions.php";

// kijken of er op de plusknop is gedrukt.
if (isset($_GET['addId'])) {
    addItem($_GET['addId']);
}
// kijken of er op de minknop is gedrukt.
if (isset($_GET['removeId'])) {
    removeItem($_GET['removeId']);
}
// kijken of er op de verwijderknop is gedrukt.
if (isset($_GET['fullRemoveId'])) {
    removeItem($_GET['fullRemoveId'], true);
}

$cart = getCart();
$total = 0;
?>
<div class="row">
    <div class="col-12">
        <h1>Winkelmandje</h1>
        <hr>
    </div>
    <div class="card border-0">
        <div class="row">
            <?php
            foreach ($cart as $key => $item) {
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
                print ("<div class='col'><a href='cart.php?addId=" . $key . "'>+</a> " . $item . "<a href='cart.php?removeId=" . $key . "'> -</a></div>");
                print ("<div class='col'>&euro;" . round($stockItem['SellPrice'], 2) . "<span class='close'><a href='cart.php?fullRemoveId=" . $key . "' class='text-danger'>&#10005;</a></span></div>");
                print("</div></div></div>");
                $total += round($stockItem['SellPrice'], 2) * $item;
            }


            if (empty($cart)) {
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
                    <div class="col text-right">&euro; <?php print(str_replace('.', ',', $total)) ?></div>
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
