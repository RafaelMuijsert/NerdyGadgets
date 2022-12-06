<?php
    $total = 0;
    if(count($_POST) > 0):
        $_SESSION['userinfo'] = $_POST;
    endif;
    $databaseConnection = $GLOBALS['databaseConnection'];
?>
<section class="checkout">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="checkout__wrapper bg-white">
                    <h5 class="checkout__title">Ingevulde gegevens</h5>

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

                    <h5 class="checkout__title checkout__title-delivery">Bezorgmoment</h5>
                    <ul>
                        <li>Dinsdag 25 November - 10:30</li>
                        <li>PostNL</li>
                    </ul>
                </div>
            </div>
            <div class="col-8">
                <div class="checkout__wrapper bg-white bg-white--large">
                    <h2>Te bestellen producten</h2>

                    <div class="checkout__products">
                        <?php
                        $total = 0;
                        foreach($_SESSION['cart'] as $id => $quantity): ?>
                            <?php $stockItem = getStockItem($id, $GLOBALS['databaseConnection']);
                            $price = round($stockItem['SellPrice'], 2);
                            $total += $price * $quantity;
                            ?>
                            <div class="p-2 mb-3 border d-flex align-items-center">
                                <div class="">
                                    <label for="quantity" class=""><?=$stockItem['StockItemName']?></label>
                                </div>
                                <div class="text-right">
                                    <label>
                                        <input name="quantity" type="number" disabled value="<?=$quantity?>">
                                    </label>
                                </div>

                                <div class="text-right">
                                    <p class="">&euro;<?=number_format($price * $quantity, 2)?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        Totaal: <?= $total ?>
                    </div>

                    <a href="?action=pay" class="btn btn--order">Ga naar betalen</a>
                    <?php if(isset($_GET['action']) && $_GET['action'] == 'pay'):

                        $postcode = str_replace(' ', '', $_SESSION['userinfo']['postcode']);

                        addKlant(
                                $_SESSION['userinfo']['firstname'],
                                $_SESSION['userinfo']['prefixName'],
                                $_SESSION['userinfo']['surname'],
                                $_SESSION['userinfo']['birthDate'],
                                $_SESSION['userinfo']['email'],
                                $_SESSION['userinfo']['phone'],
                                $databaseConnection
                        );
                        $klantID = findKlant($databaseConnection);

                        addOrder(
                                $klantID[0]['max(klantID)'],
                                $_SESSION['userinfo']['country'],
                                $_SESSION['userinfo']['street'],
                                $_SESSION['userinfo']['housenumber'],
                                $postcode,
                                $_SESSION['userinfo']['city'],
                                $_SESSION['userinfo']['comment'],
                                $databaseConnection
                        );
                        $orderID = findOrder($databaseConnection);

                        $_SESSION['userinfo'] = '';
                        $_SESSION['cart'] = [];

                        foreach ($_SESSION['cart'] as $id => $quantity):
                            $total = 0;
                            $stockItem = getStockItem($id, $GLOBALS['databaseConnection']);
                            $price = round($stockItem['SellPrice'], 2);
                            $total += $price * $quantity;
                            addOrderregel($orderID[0]['max(OrderID)'], $id, $quantity, $total, $databaseConnection);
                            removeStock($id, $quantity, $databaseConnection);
                        endforeach; ?>

                        <script>
                            window.location.replace('https://www.ideal.nl/demo/qr/?app=ideal');
                        </script>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>