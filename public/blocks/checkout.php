<?php
    $total = 0;
    if(count($_POST) > 0) {
        $_SESSION['userinfo'] = $_POST;
    }
    $databaseConnection = $GLOBALS['databaseConnection'];
?>
<section class="checkout">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="checkout__wrapper bg-white">
                    <h5>Ingevulde gegevens</h5>

                    <?php
                        $firstname = $_SESSION['userinfo']['firstname'];
                        $prefixName = $_SESSION['userinfo']['prefixName'];
                        $surname = $_SESSION['userinfo']['surname'];

                        $postalzip = $_SESSION['userinfo']['postcode'];
                        $city = $_SESSION['userinfo']['city'];
                        $adress = $_SESSION['userinfo']['street'];
                    ?>

                    <ul>
                        <li><?= $firstname . " $prefixName" . " $surname" ?></li>
                        <li><?= $_SESSION['userinfo']['email'] ?></li>
                        <?php if (isset($_SESSION['userinfo']['phone'])): ?>
                            <li><?= $_SESSION['userinfo']['phone'] ?></li>
                        <?php endif; ?>
                    </ul>

                    <ul>
                        <li><?= $postalzip . ", " . $city  ?></li>
                        <li><?= $adress  ?></li>
                    </ul>

                    <span>Uitzonderingen</span>
                    <?php if (isset($_SESSION['userinfo']['comment'])): ?>
                        <p><?= $_SESSION['userinfo']['comment'] ?></p>
                    <?php else: ?>
                        <p>---</p>
                    <?php endif; ?>

                    <h5>Bezorgmoment</h5>
                    <p>Dinsdag 25 November - 10:30</p>
                </div>
            </div>
            <div class="col-8">
                <div class="checkout__wrapper bg-white bg-white--large">
                    <h2>Te bestellen producten</h2>

                    <div class="div">
                        // Alle producten
                    </div>

                    <a href="?action=pay" class="btn btn--order">Ga naar betalen</a>
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
</section>