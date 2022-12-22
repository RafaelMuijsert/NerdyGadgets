<section class="newsletter">
    <div class="container">
        <div class="row">
            <div class="col-8">
                <div class="order__wrapper bg-white bg-white--large">
                    <div>
                        <h2>Nieuwsbrief</h2>
                    </div>


                    <span class="order__form-row order__form-error">
                        <?php
                        if(isset($_POST) && isset($_POST['submit-email-Registration'])):

                            $_SESSION['email-registration'] = $_POST;
                            $username = $_SESSION['email-registration']['email'];

                            maillistaccount(
                                $_SESSION['email-registration']['email'],
                                $_SESSION['email-registration']['firstname'],
                                $_SESSION['email-registration']['prefixName'],
                                $_SESSION['email-registration']['surname'],
                                $databaseConnection,
                            );
                        endif;
                        ?>
                    </span>
                    <br>
                    <h5 style="font-weight: 500">Blijf up-to-date met onze Nieuwsbrief!</h5>
                    <ul class="newsletter__pros">
                        <li>U krijgt als enige kortingscodes!</li>
                        <li>U weet als een van de eerste de opkomende aanbiedingen!</li>
                        <li>U weet als eerste van nieuwe producten!</li>
                    </ul>
                    <br>
                    <?php include "form/newsletter-form.php" ?>
                </div>
            </div>
        </div>
    </div>
</section>