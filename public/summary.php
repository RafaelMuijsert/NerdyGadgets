<?php
include "header.php";
?>
<!DOCTYPE Html>
<html lang="en">
<div class="col-12">
    <h1>Afronden</h1>
    <hr>
</div>
<body>

<METHOD="post">

    <div class="container overflow-hidden text-center">
        <div class="row gx-5">
            <div class="col">
                <div class="p-3 border bg-light">
                    <h2>Gegevens</h2>
                    <hr>
    <div>
    <?php print("Naam: ". $_POST["fname"]. " " . $_POST["lname"]); ?>
    </div><br>

    <div><?php print("Email: " . $_POST["email"]); ?>
    </div><br>

    <div><?php print("Telefoonnummer: " . $_POST["Number"]); ?>
    </div><br>

    <div><?php print("Land:" . $_POST["country"]); ?>
    </div><br>

    <div><?php print("Straat: " . $_POST["street"]); ?>
    </div><br>

    <div><?php print("Postcode: " . $_POST["postcode"]); ?>
    </div><br>

    <div><?php print("Stad:" . $_POST["city"]); ?>
    </div><br>


                 </div>
            </div>
            <div class="col">
                <div class="p-3 border bg-light">
                    <h2>Overzicht</h2>
<hr>

                    <div>
                        <div class='col'><div class='row'><div class='row align-items-center'>
                        <div class="card border-0">
                            <div class="row">
                                <div class="col">
                                    <?php
                                    foreach ($_SESSION['cart'] as $key => $item) {
                                    //Haal item op
                                    $stockItem = getStockItem($key, $databaseConnection);
                                    // als key niet bestaat, ga door.
                                    if (!$stockItem) {
                                        continue;
                                    }

                                    if ($stockItemImage = getStockItemImage($key, $databaseConnection)) {
                                        print("<div class='col-2'></div>");
                                    } else {
                                        print("<div class='col-2'></div>");
                                    };
                                    print ("<div class='col'><div class='row'>" . $stockItem['StockItemName']);
                                    ?>
                                    <form method='post'><div class='col'>

                                            <?php

                                            $quantity = $_SESSION['cart'][$stockItem['StockItemID']];
                                            $stock = getItemStock($stockItem['StockItemID'], $databaseConnection)['QuantityOnHand'];

                                            print("<p class='align-items-end'> Aantal: $quantity </p></form>");
                                            print("</div></div></div></div>");
                                            print("<hr>");
                                            $price = round($stockItem['SellPrice'], 2);
                                            $total = $price * $quantity;
                                            print ("</div>");
                                            }
                                    ?>
                                        </div></div></div>
                                            <div class="col-4">
                                                <br>
                                                <hr>
                                                <div class="row">
                                                    <div class="col">Totaal</div>
                                                    <div class="col text-right">&euro; <?php print(number_format($total, 2, '.')) ?></div>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="https://www.ideal.nl/demo/qr/?app=ideal" class="btn btn-primary">Doorgaan</a>

</body>