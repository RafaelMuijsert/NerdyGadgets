<section class="order">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="order__wrapper bg-white bg-white--large">
                    <h2>Gegevens invullen</h2>
                    <p>Vul in de onderstaande Velden uw in:</p>
                    <form method="post" action="checkout.php" class="order__form">

                        <div class="order__form-row order__form-row--40">
                            <?php
                            $firstname = '';
                            if (isset($_SESSION['userinfo']['firstname'])):
                                $firstname = $_SESSION['userinfo']['firstname'];
                            endif; ?>
                            <label for="firstname">Voornaam:*</label>
                            <input class="input" placeholder="Voornaam" value="<?= $firstname ?>" type="text" id="firstname" name="firstname" required>
                        </div>

                        <div class="order__form-row order__form-row--20">
                            <?php
                            $prefixName = '';
                            if (isset($_SESSION['userinfo']['prefixName'])):
                                $prefixName = $_SESSION['userinfo']['prefixName'];
                            endif; ?>
                            <label for="prefixName">Tussenvoegsel:</label>
                            <input class="input" placeholder="Tussenvoegsel" value="<?= $prefixName ?>" type="text" id="prefixName" name="prefixName">
                        </div>

                        <div class="order__form-row order__form-row--40">
                            <?php
                            $surname = '';
                            if (isset($_SESSION['userinfo']['surname'])):
                                $surname = $_SESSION['userinfo']['surname'];
                            endif; ?>
                            <label for="surname">Achternaam:*</label>
                            <input class="input" placeholder="Achternaam" value="<?= $surname ?>" type="text" id="surname" name="surname" required>
                        </div>

                        <div class="order__form-row order__form-row--50">
                            <?php
                            $birthDate = '';
                            if (isset($_SESSION['userinfo']['birthDate'])):
                                $birthDate = $_SESSION['userinfo']['birthDate'];
                            endif; ?>
                            <label for="birthDate">Geboortedatum:*</label>
                            <input class="input" placeholder="Geboortedatum" value="<?= $birthDate ?>" type="date" id="birthDate" name="birthDate" required>
                        </div>

                        <div class="order__form-row order__form-row--50">
                            <?php
                            $mail = '';
                            if (isset($_SESSION['userinfo']['email'])):
                                $mail = $_SESSION['userinfo']['email'];
                            endif; ?>
                            <label for="email">Email:*</label>
                            <input class="input" placeholder="Emailadres" value="<?= $mail ?>" type="email" id="email" name="email" required>
                        </div>

                        <div class="order__form-row order__form-row--50">
                            <?php
                            $phone = '';
                            if (isset($_SESSION['userinfo']['phone'])):
                                $phone = $_SESSION['userinfo']['phone'];
                            endif; ?>
                            <label for="number">Telefoonnummer:</label>
                            <input class="input" placeholder="Telefoonnummer" value="<?= $phone ?>" type="tel" id="phone" name="phone">
                        </div>

                        <div class="order__form-row order__form-row--50">
                            <label for="country">Land:</label>
                            <select class="select country" name="country" id="country">
                                <option value="Netherlands">Nederland</option>
                            </select>
                        </div>

                        <div class="order__form-row order__form-row--50">
                            <?php
                            $city = '';
                            if (isset($_SESSION['userinfo']['city'])):
                                $city = $_SESSION['userinfo']['city'];
                            endif; ?>
                            <label for="city">Stad:*</label>
                            <input class="input" placeholder="Stad" value="<?= $city ?>" type="text" id="city" name="city" required>
                        </div>

                        <div class="order__form-row order__form-row--50">
                            <?php
                            $street = '';
                            if (isset($_SESSION['userinfo']['street'])):
                                $street = $_SESSION['userinfo']['street'];
                            endif; ?>
                            <label for="street">Straat + huisnummer:*</label>
                            <input class="input" type="text" id="street" name="street" placeholder="Vul hier in..." value="<?= $street ?>" required>
                        </div>

                        <div class="order__form-row order__form-row--50">
                            <?php
                            $postalZip = '';
                            if (isset($_SESSION['userinfo']['postcode'])):
                                $postalZip = $_SESSION['userinfo']['postcode'];;
                            endif; ?>
                            <label for="postcode">Postcode:*</label>
                            <input class="input" placeholder="Vul hier in..." value="<?= $postalZip ?>" type="text" id="postcode" name="postcode" required>
                        </div>

                        <div class="order__form-row">
                            <?php
                            $comment = '';
                            if (isset($_SESSION['userinfo']['comment'])):
                                $comment = $_SESSION['userinfo']['comment'];;
                            endif; ?>
                            <label for="comment">Opmerkingen:</label>
                            <textarea class="input" placeholder="Vul hier in..." value="<?= $comment ?>" type="text" id="comment" name="comment"></textarea>
                        </div>

                        <div class="order__form-row">
                            <input TYPE="hidden" NAME="required_fields" VALUE="name, from">
                            <input class="btn btn--order" type="submit" value="Bevestig gegevens">
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