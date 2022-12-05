<section class="order">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="order__wrapper bg-white bg-white--large">
                    <h2 class=text-center>Gegevens invullen</h2><hr>
                    <form method="post" action="checkout.php" class="order__form">

                        <div class="order__form-row">
                            <?php
                            $mail = '';
                            if (isset($_SESSION['userinfo']['email'])):
                                $mail = $_SESSION['userinfo']['email'];
                            endif; ?>
                            <label for="email">Email:</label>
                            <input placeholder="Vul hier in..." value="<?= $mail ?>" type="email" id="email" name="email"

                                   style="width: 80%;" required><br><br>
                        </div>

                        <div class="order__form-row">
                            <?php
                            $phone = '';
                            if (isset($_SESSION['userinfo']['phone'])):
                                $phone = $_SESSION['userinfo']['phone'];
                            endif; ?>
                            <label for="number">Telefoonnummer:</label>
                            <input placeholder="Vul hier in..." value="<?= $phone ?>" type="text" id="phone" name="phone" style="width: 80%;"><br><br>
                        </div>

                        <div class="order__form-row">
                            <select name="country" id="country" style="width: 80%;">
                                <option value="Netherlands">Nederland</option>
                            </select>
                        </div>

                        <div class="order__form-row">
                            <?php
                            $city = '';
                            if (isset($_SESSION['userinfo']['city'])):
                                $city = $_SESSION['userinfo']['city'];
                            endif; ?>
                            <label for="city">Stad:</label>
                            <input placeholder="Vul hier in..." value="<?= $city ?>" type="text" id="city" name="city" style="width: 80%" required><br><br>
                        </div>

                        <div class="order__form-row">
                            <?php
                            $street = '';
                            if (isset($_SESSION['userinfo']['street'])):
                                $street = $_SESSION['userinfo']['street'];
                            endif; ?>
                            <label for="street">Adress:</label>
                            <input type="text" id="street" name="street" placeholder="Vul hier in..." value="<?= $street ?>" style="width: 80%;" required><br><br>
                        </div>

                        <div class="order__form-row">
                            <?php
                            $postalZip = '';
                            if (isset($_SESSION['userinfo']['postcode'])):
                                $postalZip = $_SESSION['userinfo']['postcode'];;
                            endif; ?>
                            <label for="postcode">Postcode:</label>
                            <input placeholder="Vul hier in..." value="<?= $postalZip ?>" type="text" id="postcode" name="postcode" style="width: 80%;" required><br><br>
                        </div>

                        <div class="order__form-row">
                            <input TYPE="hidden" NAME="required_fields" VALUE="name, from">
                            <input class="shadow-lg w-100 btn btn-primary" type="submit" value="Bevestig gegevens">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-4">
                <div class="order__wrapper bg-white">
                    <?php
//                        $quantity = $_SESSION['cart'][$stockItem['StockItemID']];
//                        $stock = getItemStock($stockItem['StockItemID'], $databaseConnection)['QuantityOnHand'];
//                        $price = round($stockItem['SellPrice'], 2);
//                        $total += $price * $quantity;
                    $total = 'Totaal moet nog berekend worden';
                    ?>
                    <h5>Overzicht</h5>
                    <hr>
                    <div class="shopping-cart__total">
                        <div class="">Totaal</div>
<!--                        <div class=" text-right">&euro; --><?//= (number_format($total, 2, '.')) ?><!--</div>-->
                        <?= $total ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>