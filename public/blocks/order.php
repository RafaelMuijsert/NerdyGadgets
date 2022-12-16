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
                        <div class="">Totaal</div>
                        € <?= getTotalPrice(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>