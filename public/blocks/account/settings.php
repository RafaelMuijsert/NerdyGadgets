<?php
if (isset($_POST['remove'])) {
    removeDiscountCodes($_POST['remove'], $databaseConnection);
    unset($_POST['remove']);
}
if (isset($_POST['VerzendKosten']) && $_POST['VerzendKosten'] == 'Verwerk'){
    $_POST['deliveryLimit'] = str_replace(",", ".", $_POST['deliveryLimit']);
    $_POST['deliveryCosts'] = str_replace(",", ".", $_POST['deliveryCosts']);
    if ($_POST['deliveryLimit'] == ''){
        $_POST['deliveryLimit'] = getDeliverycosts($databaseConnection)[0][1];
    }
    if ($_POST['deliveryCosts'] == ''){
        $_POST['deliveryCosts'] = getDeliverycosts($databaseConnection)[1][1];
    }
    updateDeliveryLimit($_POST['deliveryLimit'], $databaseConnection);
    updateDeliveryCosts($_POST['deliveryCosts'], $databaseConnection);
    unset($_POST['VerzendKosten']);
}
$deliveryCosts = getDeliverycosts($databaseConnection);
$waarschuwing = 0;
if (isset($_POST['KortingNaam']) && isset($_POST['KortingProcent'])) {
    $gelijk = 0;
    foreach (discountCodes($databaseConnection) as $kortingscode){
        if ($kortingscode['codenaam'] == $_POST['KortingNaam']){
            $gelijk ++;
        }
    }
    if ((strlen($_POST['KortingNaam']) >= 1) && strlen($_POST['KortingNaam'] <= 10) && $gelijk == 0) {
        if (($_POST['KortingProcent'] > 0) && ($_POST['KortingProcent'] < 100)){
            if ($_POST['KortingDate'] == ''){
                $_POST['KortingDate'] = NULL;
            }
            if ($_POST['KortingDate'] < date("Y-m-d") && !($_POST['KortingDate'] == NULL)){
                $waarschuwing = 3;
            }
            else {
                if ($_POST['KortingUses'] == '') {
                    $_POST['KortingUses'] = NULL;
                }
                if ($_POST['KortingUses'] < 1 && !($_POST['KortingUses'] == NULL)) {
                    $waarschuwing = 4;
                }
                else {
                    addDiscountCode($_POST['KortingNaam'], $_POST['KortingProcent'], $_POST['KortingDate'], $_POST['KortingUses'], $databaseConnection);
                }
            }
        }
        else $waarschuwing = 2;
    }
    else if (!($gelijk == 0)){
        if ($_POST['KortingProcent'] > 0 && $_POST['KortingProcent'] < 100){
            if ($_POST['KortingDate'] == ''){
                $_POST['KortingDate'] = NULL;
            }
            if ($_POST['KortingDate'] < date("Y-m-d") && !($_POST['KortingDate'] == NULL)){
                $waarschuwing = 3;
            }
            else {
                if ($_POST['KortingUses'] == '') {
                    $_POST['KortingUses'] = NULL;
                }
                if ($_POST['KortingUses'] < 1 && !($_POST['KortingUses'] == NULL)) {
                    $waarschuwing = 4;
                }
                else {
                    updateDiscountCode($_POST['KortingNaam'], $_POST['KortingProcent'], $_POST['KortingDate'], $_POST['KortingUses'], $databaseConnection);
                }
            }
        }
    }
    else $waarschuwing = 1;
}
if (isset($_POST['cleanUp']) && $_POST['cleanUp'] == 'Verwijder ongeldige codes'){
    foreach (discountCodes($databaseConnection) as $key){
        if ($key['uses'] == 0 && !($key['uses'] == '')){
            removeDiscountCodes($key['kortingID'], $databaseConnection);
        }
        $datum = date("Y-m-d");
        if (strtotime($key['geldigtot']) < strtotime($datum) && !($key['geldigtot'] == '')){
            removeDiscountCodes($key['kortingID'], $databaseConnection);
        }
    }
}
?>
<div class="settings">
    <h1 class="settings__title">Admin instellingen</h1>
    <h5>Verzendkosten</h5>
    <form method="post">
        <div class="row">
            <div class="col-2">
                <label>Verzendkosten Grens:</label>
            </div>
            <div class="col">
                <input type="text" name="deliveryLimit" required <?php print ('value="' . $deliveryCosts[0][1]) . '"' ?>>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <label>Verzendkosten Aantal:</label>
            </div>
            <div class="col">
                <input type="text" name="deliveryCosts" required <?php print ('value="' . $deliveryCosts[1][1]) . '"' ?>>
            </div>
        </div>
        <input type="submit" CLASS="btn btn--discount--add" name="VerzendKosten" value="Verwerk">
    </form>
    <br>
    <h5>Kortingscodes</h5>
    <div>
        <div class="table discount--table">
            <div class="row" style="border-bottom: 4px solid white">
                <div class="col-1 discount--table--top" style="text-align: right">ID</div>
                <div class="col-3 discount--table--top">Kortingscode</div>
                <div class="col-2 discount--table--top">Procent</div>
                <div class="col-2 discount--table--top">Geldig Tot</div>
                <div class="col-2 discount--table--top">Uses</div>
                <div class="col-md-auto discount--table--top"></div>
            </div>
            <?php foreach (discountCodes($databaseConnection) as $kortingscode): ?>
                <div class="row">
                    <div class="col-1 discount--table--cell" style="text-align: right" ><?php print ($kortingscode['kortingID'])?></div>
                    <div class="col-3 discount--table--cell"><?php print ($kortingscode['codenaam'])?></div>
                    <div class="col-2 discount--table--cell"><?php print (round($kortingscode['procent'], 2))?></div>
                    <div class="col-2 discount--table--cell"><?php if ($kortingscode['geldigtot'] == ''){
                        print ("-");
                        }
                        else print ($kortingscode['geldigtot'])?></div>
                    <div class="col-2 discount--table--cell"><?php if ($kortingscode['uses'] == ''){
                            print ("-");
                        }
                        else print ($kortingscode['uses'])?></div>
                    <div class="col-md-auto discount--table--end">
                        <form method="post">
                            <label class="btn--discount--remove text-center">
                                Remove
                                <input style="display: none" type="submit" name="remove" value="<?= $kortingscode['kortingID']; ?>">
                            </label>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <form method="post">
                <div class="row">
                    <div class="col-1 discount--table--cell"></div>
                    <div class="col-3 discount--table--cell">
                        <input class="input--discount" style="width: 100%" type="text" maxlength="10" name="KortingNaam" required>
                    </div>
                    <div class="col-2 discount--table--cell">
                        <input class="input--discount" style="width: 100%" type="text" name="KortingProcent" required>
                    </div>
                    <div class="col-2 discount--table--cell">
                        <input class="input--discount" style="width: 100%" type="date" name="KortingDate">
                    </div>
                    <div class="col-2 discount--table--cell">
                        <input class="input--discount" style="width: 100%" type="text" maxlength="4" name="KortingUses">
                    </div>
                    <div class="col-md-auto discount--table--end">
                        <input class="btn--discount--add" type="submit" value="Update/add">
                    </div>
                </div>
            </form>
        </div>
        <div class="text-warning"><?php
                if ($waarschuwing == 1){
                    print ("Geen geldige naam! Probeer opnieuw.");
                }
                else if ($waarschuwing == 2){
                    print ("Geen geldig percentage! Probeer opnieuw.");
                }
                else if ($waarschuwing == 3){
                    print ("Geen geldige datum! Probeer opnieuw!");
                }
                else if ($waarschuwing == 4){
                    print ("Geen geldig aantal uses! Probeer opnieuw");
                }
            ?>
        </div>
        <form method="post">
            <input type="submit" class="btn btn--discount--remove" style="width: auto" name="cleanUp" value="Verwijder ongeldige codes">
        </form>
    </div>
</div>