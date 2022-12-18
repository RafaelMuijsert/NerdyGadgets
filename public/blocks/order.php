<section class="order">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="order__wrapper bg-white bg-white--large">
                    <h2>Gegevens invullen</h2>
                    <p>Vul in de onderstaande Velden uw in:</p>
                    <?php include 'form/order-form.php'?>
                </div>
            </div>
            <div class="col-4">
                <div class="order__wrapper bg-white">
                    <h5>Overzicht</h5>
                    <hr>
                    <div class="shopping-cart__total">
                        <?php if (isset($_SESSION['korting'][0]['procent'])): ?>
                            <!--                                    even naar kijken wat moet voor de css, mij lukt dit niet-->
                            <div class="">Prijs</div>
                            <div class=" text-right">&euro; <?= (number_format($_SESSION[ 'noDiscount'], 2, '.', ',')) ?></div>
                            <div class=""><?php print ($_SESSION['korting'][0]['procent'] . "% korting")?></div>
                            <div class=" text-right">&euro; <?= (number_format(($_SESSION[ 'noDiscount'] - $_SESSION[ 'total']), 2, '.', ',')) ?></div>
                        <?php endif; ?>
                        <div class="">Totaal</div>
                        <div class=" text-right">&euro; <?= (number_format($_SESSION[ 'total'], 2, '.', ',')) ?></div>

                        <!--                        € --><?//= getTotalPrice(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>