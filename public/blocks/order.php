<section class="order">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="order__wrapper bg-white bg-white--large">
                    <h2>Gegevens invullen</h2>
                    <p>Vul in de onderstaande velden uw gegevens in:</p>
                    <?php include 'form/order-form.php'?>
                </div>
            </div>
            <div class="col-4">
                <div class="order__wrapper bg-white">
                    <h5>Overzicht</h5>
                    <hr>
                    <div class="shopping-cart__total">
                        <?php if (isset($_SESSION['korting'][0]['procent'])): ?>
                            <div class="">Prijs (<?= ($_SESSION['korting'][0]['procent'] . "% korting")?>)</div>
                            <div class=" text-right"><s>&euro; <?= (number_format($_SESSION['noDiscount'], 2, '.', ',')) ?></s> &euro; <?= (number_format(($_SESSION['total'] - $_SESSION['deliveryCosts']), 2, '.', ',')) ?></div>
                        <?php else: ?>
                            <div class="">Prijs</div>
                            <div class=" text-right">&euro; <?= (number_format($_SESSION['noDiscount'], 2, '.', ',')) ?></div>
                        <?php endif; ?>
                        <div class="">
                            <abbr title="Gratis verzendkosten vanaf &euro;<?= (getDeliverycosts($databaseConnection)[0][1]) ?>">Verzendkosten</abbr>
                        </div>
                        <div class="text-right" style="margin-left: auto; margin-right: 0;">&euro; <?= (number_format($_SESSION['deliveryCosts'], 2, '.', ',')) ?></div>
                    </div>
                    <hr>
                    <div class="shopping-cart__total">
                        <div class="">Totaal</div>
                        <div class=" text-right">&euro; <?= (number_format($_SESSION['total'], 2, '.', ',')) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>