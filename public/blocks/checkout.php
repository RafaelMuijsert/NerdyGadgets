<?php
    $total = 0;
    if(count($_POST) > 0):
        $_SESSION['userinfo'] = $_POST;
    endif;
    $databaseConnection = $GLOBALS['databaseConnection'];
    $dateformatter = new IntlDateFormatter(
        'nl_NL',
        IntlDateFormatter::FULL,
        IntlDateFormatter::FULL,
        'Europe/Amsterdam',
        IntlDateFormatter::GREGORIAN,
        'EEEE d MMMM'
    );
    $shippingTime = '1 day';
    $shippingDate = $dateformatter->format(strtotime("+$shippingTime", mktime(0, 0, 0)));
    $CHECKOUT_DISABLED = false;
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
                        <li>
                            <?= ucfirst($shippingDate) ?>
                        </li>
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
                        $factor = 1;
                        foreach($_SESSION['cart'] as $id => $quantity): ?>
                            <?php $stockItem = getStockItem($id, $GLOBALS['databaseConnection']);
                            $price = round($stockItem['SellPrice'], 2);
                            if (isset($_SESSION['korting'][0]['procent'])){
                                $factor = (1 - ($_SESSION['korting'][0]['procent'] * 0.01));
                            }
                            $total += round(($price * $factor),2) * $quantity;
                            ?>
                            <div class="container p-2 mb-3 border d-flex align-items-center">
                                <div class="row">
                                    <div class="col-4 display align-middle text-left w-100">
                                        <label for="quantity" class=""><?=$stockItem['StockItemName']?></label>
                                    </div>
                                    <div class="col text-right align-middle">
                                        <label>
                                            <input name="quantity" type="number" disabled value="<?=$quantity?>">
                                        </label>
                                    </div>

                                    <div class="col text-right">
                                        <?php if (!isset($_SESSION['korting'][0]['procent'])): ?>
                                        <p class="">&euro;<?=number_format($price * $quantity, 2)?></p>
                                        <?php else:
                                        ?>
                                        <del><del style="display:inline-block;">&euro;<?=number_format($price * $quantity, 2)?></del></del>
                                        <p style="display:inline-block;">&emsp;&euro;<?=number_format($price * $factor * $quantity, 2)?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        Totaal: <?= $total ?>
                    </div>

                    <a href="?action=pay" class="btn btn--order">Ga naar betalen</a>
                    <?php if(isset($_GET['action']) && $_GET['action'] == 'pay' && !$CHECKOUT_DISABLED):

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

                        $userID = NULL;
                        if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn']):
                            $userID = $_SESSION['account']['id'];
                        endif;

                        addOrder(
                                $klantID[0]['max(klantID)'],
                                $_SESSION['userinfo']['country'],
                                $_SESSION['userinfo']['street'],
                                $_SESSION['userinfo']['housenumber'],
                                $postcode,
                                $_SESSION['userinfo']['city'],
                                $_SESSION['userinfo']['comment'],
                                $userID,
                                $databaseConnection
                        );
                        $orderID = findOrder($databaseConnection);

                        foreach ($_SESSION['cart'] as $id => $quantity):
                            $total = 0;
                            $factor = 1;
                            $stockItem = getStockItem($id, $GLOBALS['databaseConnection']);
                            $price = round($stockItem['SellPrice'], 2);
                            if (isset($_SESSION['korting'][0]['procent'])){
                                $factor = (1 - ($_SESSION['korting'][0]['procent'] * 0.01));
                                $procent = $_SESSION['korting'][0]['procent'];
                            }
                            else $procent = NULL;
                            $total += round(($price * $factor),2) * $quantity;

                            addOrderregel($orderID[0]['max(OrderID)'], $id, $quantity, $total, $procent,$databaseConnection);
                            removeStock($id, $quantity, $databaseConnection);
                        endforeach;
                        $_SESSION['userinfo'] = '';
                        $_SESSION['cart'] = [];
                        unset($_SESSION['korting']);
                        ?>

                        <script>
                            window.location.replace('https://www.ideal.nl/demo/qr/?app=ideal');
                        </script>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>