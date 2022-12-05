<?php
include "header.php";
$total = 0;
if(count($_POST) > 0) {
    $_SESSION['userinfo'] = $_POST;
}
$databaseConnection = $GLOBALS['databaseConnection'];
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
                            <p>
                                <?=$_SESSION['userinfo']['fname']?> <?=$_SESSION['userinfo']['lname']?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Email: </p>
                        </div>
                        <div class="col">
                            <p>
                                <?=$_SESSION['userinfo']['email']?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Telefoonnummer: </p>
                        </div>
                        <div class="col">
                            <p>
                                <?=$_SESSION['userinfo']['phone']?>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Land: </p>
                        </div>
                        <div class="col">
                            <p>
                                <?=$_SESSION['userinfo']['country']?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Straat: </p>
                        </div>
                        <div class="col">
                            <p>
                                <?=$_SESSION['userinfo']['street']?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Postcode: </p>
                        </div>
                        <div class="col">
                            <p>
                                <?=$_SESSION['userinfo']['postcode']?>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <p>Stad: </p>
                        </div>
                        <div class="col">
                            <p>
                                <?=$_SESSION['userinfo']['city']?>
                            </p>
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
                    <?php include "../src/summary.php"?>
                    <h4 class="text-right">Totaal: &euro;<?=number_format($total, 2, '.') ?></h4>
                    <a href="?action=pay" class="w-100 btn btn-primary">
                        Betalen
                    </a>
                    <?php
                    if(isset($_GET['action']) && $_GET['action'] == 'pay') {
                        addKlant($_SESSION['userinfo']['fname'], $_SESSION['userinfo']['lname'], $_SESSION['userinfo']['email'], $_SESSION['userinfo']['phone'], $databaseConnection);
                        $klantID = findKlant($databaseConnection);
                        addOrder($klantID[0]['max(klantID)'], $_SESSION['userinfo']['country'], $_SESSION['userinfo']['street'], $_SESSION['userinfo']['postcode'], $_SESSION['userinfo']['city'], $databaseConnection);
                        $orderID = findOrder($databaseConnection);
                        foreach ($_SESSION['cart'] as $id => $quantity) {
                            $total = 0;
                            $stockItem = getStockItem($id, $GLOBALS['databaseConnection']);
                            $price = round($stockItem['SellPrice'], 2);
                            $total += $price * $quantity;
                            addOrderregel($orderID[0]['max(OrderID)'], $id, $quantity, $total, $databaseConnection);
                            removeStock($id, $quantity, $databaseConnection);
                        }
                        ?>
                        <script>
                            window.location.replace('https://www.ideal.nl/demo/qr/?app=ideal');
                        </script>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
include "footer.php"
?>