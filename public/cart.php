<?php
include "header.php";
include "cartFunctions.php"
?>
<div class="row">
    <div class="col-12">
        <h1>Winkelmandje</h1>
    </div>
    <div class="col-12 border-bottom"></div>
    <div class="col-12">
        
    </div>
</div>
<?php
$total = 0;
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

foreach (getCart() as $key => $item) {
    //Haal item op
    $stockItem = getStockItem($key, $databaseConnection);
    print("<div class='col-12 bg-light mb-1 rounded shadow'>");
        if ($stockItemImage = getStockItemImage($key, $databaseConnection)) {
            // gaat naar
            print("<img height='100px' width='auto' src='img/stock-item/" . $stockItemImage[0]['ImagePath'] . "' alt=''></img>");
        } else {
            print("<img height='100px' width='auto' src='img/stock-group/" . $stockItem['BackupImagePath'] . "' alt=''></img>");
        }
//        echo $stockItem['StockItemName'] . " " . round($stockItem['SellPrice'], 2);

        print ("<h4>" . $stockItem['StockItemName'] . "<br>" . "€" . round($stockItem['SellPrice'], 2) . "</h4>");

        $total += round($stockItem['SellPrice'], 2) * $item;
        print("<a href='cart.php?addId=" . $key . "'>+</a>");
        print($item);
        print("<a href='cart.php?removeId=" . $key . "'>-</a>");
        print("<a href='cart.php?fullRemoveId=" . $key . "' class='text-danger'> Verwijder</a>");
    print("</div>");
}

print("Totaal: €$total");
?>
<div class="col-6">
    <a href="https://www.ideal.nl/demo/qr/?app=ideal">Bestelling plaatsen</a>
</div>
<?php
include "footer.php";
?>

<script>
    // Verwijder URL GET query om dubbele uitvoering te voorkomen op refresh.
    window.history.pushState("object or string", "Title", "/"+window.location.href.substring(window.location.href.lastIndexOf('/') + 1).split("?")[0]);
</script>
