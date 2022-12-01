<?php
include "header.php";
$total = 0;
if(count($_POST) > 0) {
    $_SESSION['userinfo'] = $_POST;
}
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
                                <?=$_SESSION['userinfo']['number']?>
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
                    <a href="https://www.ideal.nl/demo/qr/?app=ideal" type="button" class="shadow-lg w-100 btn btn-primary">
                        Betalen
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
include "footer.php"
?>