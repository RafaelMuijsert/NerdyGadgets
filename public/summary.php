<?php
include "header.php";
$total = 0;
$_SESSION['userinfo'] = $_POST;
?>
<!DOCTYPE html>
<html lang="en">
<div class="text-center col-12">
    <h1>Afronden</h1>
    <hr>
</div>
<body>
    <div class="container overflow-hidden mb-5">
        <div class="row gx-5">
            <div class="col">
                <div class="p-3 rounded border bg-light">
                    <h2 class="text-center">Gegevens</h2>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Naam: </p>
                        </div>
                        <div class="col">
                            <p><?php print($_POST["fname"]); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Email: </p>
                        </div>
                        <div class="col">
                            <p><?php print($_POST["email"]); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Telefoonnummer: </p>
                        </div>
                        <div class="col">
                            <p><?php print($_POST["Number"]); ?></p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Land: </p>
                        </div>
                        <div class="col">
                            <p><?php print($_POST["country"]); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Straat: </p>
                        </div>
                        <div class="col">
                            <p><?php print($_POST["street"]); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Postcode: </p>
                        </div>
                        <div class="col">
                            <p><?php print($_POST["postcode"]); ?></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Stad: </p>
                        </div>
                        <div class="col">
                            <p><?php print($_POST["city"]); ?></p>
                        </div>
                    </div>
                    <hr>
                    <a>Kloppen de gegevens niet? Ga naar de</a>
                    <a href="order.php">vorige pagina</a>
                </div>
            </div>
            <div class="col">
                <div class="p-3 rounded border bg-light">
                    <h2 class="text-center">Overzicht</h2>
                    <hr>
                    <?php foreach($_SESSION['cart'] as $id => $quantity): ?>
                        <?php $stockItem = getStockItem($id, $databaseConnection);
                        $price = round($stockItem['SellPrice'], 2);
                        $total += $price * $quantity;
                        ?>
                        <div class="p-2 m-3 border rounded row text-left align-items-center">
                            <div class="col-6">
                                <p class="mb-0"><?=$stockItem['StockItemName']?></p>
                            </div>
                            <div class="text-right col">
                                <input disabled value=<?=$quantity?> type="number">
                            </div>
                            <div class="text-right col">
                                <p class="mb-0">&euro;<?=$price?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <h4 class="text-right">Totaal: &euro;<?=$total ?></h4>
                    <a href="https://www.ideal.nl/demo/qr/?app=ideal" type="button" class="shadow-lg w-100 btn btn-primary">
                        Betalen
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>